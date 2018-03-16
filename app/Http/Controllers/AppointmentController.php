<?php
	
	namespace App\Http\Controllers;
	
	use App\Appointment;
	use App\AppointmentParticipant;
	use App\Client;
	use App\Exceptions\WrappedException;
	use Auth;
	use Illuminate\Http\Request;
	
	class AppointmentController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$appointments = Appointment::with('participants')->get();
			
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
			$client = Client::find(Auth::user()->client_id);
			if (is_null($client)) {
				throw new WrappedException("Sorry, you are not associated to any client.");
			}
			
			\Validator::validate($request->json()->all(), [
				'venue'        => 'required',
				'with'         => 'required|exists:users,id',
				'title'        => 'required',
				'startDate'    => 'required',
				'startTime'    => 'required_if:allDay,false',
				'endDate'      => 'required',
				'endTime'      => 'required_if:allDay,false',
				'allDay'       => 'required',
			]);
			
			$appointment = Appointment::create([
				'client_id'  => $client->id,
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
