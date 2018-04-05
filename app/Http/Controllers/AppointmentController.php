<?php
	
	namespace App\Http\Controllers;
	
	use App\Appointment;
	use App\AppointmentParticipant;
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
				->with(['participants', 'user'])
				->orderBy('start_date')
				->orderBy('start_time')
				->get();
			
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
			$client = $this->getClient();
			
			\Validator::validate($request->json()->all(), [
				'venue'     => 'required',
				'with'      => 'required|exists:users,id',
				'title'     => 'required',
				'startDate' => 'required',
				'startTime' => 'required_if:allDay,false',
				'endDate'   => 'required',
				'endTime'   => 'required_if:allDay,false',
				'allDay'    => 'required',
			]);
			
			$appointment = Appointment::create([
				'user_id'    => Auth::user()->getKey(),
				'venue'      => $request->venue,
				'with_id'    => $request->with,
				'title'      => $request->title,
				'start_date' => $request->startDate,
				'start_time' => $request->startTime,
				'end_date'   => $request->endDate,
				'end_time'   => $request->endTime,
				'all_day'    => $request->allDay,
				'note'       => $request->note,
			]);
			
			$participants = $request->participants;
			if (!empty($participants)) {
				foreach ($participants as $participant) {
					$appointment->participants()->save(new AppointmentParticipant([
						'email' => $participant['email'],
						'phone' => $participant['phone'],
					]));
				}
			}
			
			return $this->itemCreatedResponse($appointment);
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
