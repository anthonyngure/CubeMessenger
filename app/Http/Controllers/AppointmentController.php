<?php
	
	namespace App\Http\Controllers;
	
	use App\Appointment;
	use App\AppointmentExternalParticipant;
	use App\AppointmentInternalParticipant;
	use App\AppointmentItem;
	use Auth;
	use Illuminate\Http\Request;
	
	class AppointmentController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index(Request $request)
		{
			$this->validate($request, [
				'publish_at' => 'nullable|date',
			]);
			
			$client = $this->getClient();
			
			$date = empty($request->date) ? date("Y-m-d") : $request->date;
			
			$appointments = Appointment::whereIn('user_id', $client->users->pluck('id'))
				->where('start_date', $date)
				->with('internalParticipants', 'externalParticipants', 'items')
				->orderBy('start_date')
				->orderBy('start_time')
				->get();
			
			//dd(Appointment::firstOrFail()->internalParticipants()->toSql());
			
			return $this->collectionResponse($appointments);
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \App\Exceptions\WrappedException
		 */
		public function store(Request $request)
		{
			
			\Validator::validate($request->json()->all(), [
				'venue'                => 'required',
				'internalParticipants' => 'required',
				'title'                => 'required',
				'startDate'            => 'required',
				'startTime'            => 'required_if:allDay,false',
				'endDate'              => 'required',
				'endTime'              => 'required_if:allDay,false',
				'allDay'               => 'required',
			]);
			
			$appointment = Appointment::create([
				'user_id'    => Auth::user()->getKey(),
				'venue'      => $request->venue,
				'title'      => $request->title,
				'start_date' => $request->startDate,
				'start_time' => $request->startTime,
				'end_date'   => $request->endDate,
				'end_time'   => $request->endTime,
				'all_day'    => $request->allDay,
			]);
			
			$internalParticipants = $request->internalParticipants;
			if (!empty($internalParticipants)) {
				foreach ($internalParticipants as $participant) {
					$appointment->internalParticipants()->save(new AppointmentInternalParticipant([
						'user_id' => $participant,
					]));
				}
			}
			
			$externalParticipants = $request->externalParticipants;
			if (!empty($externalParticipants)) {
				foreach ($externalParticipants as $participant) {
					$appointment->externalParticipants()->save(new AppointmentExternalParticipant([
						'email' => $participant['email'],
						'phone' => $participant['phone'],
					]));
				}
			}
			
			$itemsToDiscuss = $request->itemsToDiscuss;
			if (!empty($itemsToDiscuss)) {
				foreach ($itemsToDiscuss as $itemToDiscuss) {
					$appointment->items()->save(new AppointmentItem([
						'details' => $itemToDiscuss,
					]));
				}
			}
			$data = Appointment::with('internalParticipants', 'externalParticipants', 'items')
				->findOrFail($appointment->id);
			
			return $this->itemCreatedResponse($data);
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}
