<?php
	
	namespace App\Http\Controllers;
	
	use App\Appointment;
	use App\AppointmentExternalParticipant;
	use App\AppointmentInternalParticipant;
	use App\AppointmentItem;
	use Auth;
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
			
			$client = Auth::user()->getClient();
			
			$date = empty($request->date) ? date("Y-m-d") : $request->date;
			
			$appointments = Appointment::whereIn('user_id', $client->users->pluck('id'))
				->whereDate('starting_at', Carbon::parse($date)->toDateString())
				->with('internalParticipants', 'externalParticipants', 'items')
				->orderBy('starting_at')
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
				'startDate'            => 'required|date',
				'startTime'            => 'required_if:allDay,false',
				'endDate'              => 'required|date',
				'endTime'              => 'required_if:allDay,false',
				'allDay'               => 'required',
			]);
			
			/** @var Carbon $startingAt */
			$startingAt = $request->allDay ? Carbon::parse($request->startDate) : Carbon::parse($request->startDate . ' ' . $request->startTime);
			/** @var Carbon $endingAt */
			$endingAt = $request->allDay ? Carbon::parse($request->endDate) : Carbon::parse($request->endDate . ' ' . $request->endTime);
			
			$appointment = Appointment::create([
				'user_id'     => Auth::user()->getKey(),
				'venue'       => $request->venue,
				'title'       => $request->title,
				'starting_at' => $startingAt->toDateTimeString(),
				'ending_at'   => $endingAt->toDateTimeString(),
				'all_day'     => $request->allDay,
			]);
			
			$internalParticipants = $request->internalParticipants;
			if (!empty($internalParticipants)) {
				foreach ($internalParticipants as $participant) {
					AppointmentInternalParticipant::create([
						'appointment_id' => $appointment->id,
						'user_id'        => $participant,
					]);
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
		
		/**
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function userSuggestions(Request $request)
		{
			$client = Auth::user()->getClient();
			
			$this->validate($request, [
				'search' => 'required',
			]);
			
			$query = $request->search . '';
			//dd($query);
			
			//dd(Auth::user()->appointments()->toSql());
			
			$suggestions = $client->users()
				->with(['appointments' => function (BelongsToMany $belongsToMany) {
					/**
					 * start_date has to be >= to today so as to return pending appointments
					 * used for validation when adding an appointment
					 */
					$belongsToMany->whereDate('starting_at', '>=', Carbon::now()->toDateString());
					//->select(['id','start_date','start_time','end_date','end_time']);
				}])
				->where('name', 'LIKE', '%' . $query . '%')
				->where('email', 'LIKE', '%' . $query . '%')
				->get();
			
			return $this->collectionResponse($suggestions);
		}
	}
