<?php
	
	namespace App\Http\Controllers;
	
	use App\Appointment;
	use App\AppointmentExternalParticipant;
	use App\AppointmentInternalParticipant;
	use App\AppointmentItem;
	use App\Notifications\AppointmentNotification;
	use Auth;
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
	use Illuminate\Http\Request;
	
	class AppointmentController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @param \Illuminate\Http\Request $request
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
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			//
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \Illuminate\Validation\ValidationException
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
			$startingAt = $request->input('allDay') ? Carbon::parse($request->input('startDate'))
				: Carbon::parse($request->input('startDate') . ' ' . $request->input('startTime'));
			/** @var Carbon $endingAt */
			$endingAt = $request->input('allDay') ? Carbon::parse($request->input('endDate'))
				: Carbon::parse($request->input('endDate') . ' ' . $request->input('endTime'));
			
			$appointment = Appointment::create([
				'user_id'     => Auth::user()->getKey(),
				'venue'       => $request->input('venue'),
				'title'       => $request->input('title'),
				'starting_at' => $startingAt->toDateTimeString(),
				'ending_at'   => $endingAt->toDateTimeString(),
				'all_day'     => $request->input('allDay'),
			]);
			
			$internalParticipants = $request->input('internalParticipants');
			if (!empty($internalParticipants)) {
				foreach ($internalParticipants as $participant) {
					AppointmentInternalParticipant::create([
						'appointment_id' => $appointment->id,
						'user_id'        => $participant,
					]);
				}
			}
			
			$externalParticipants = $request->input('externalParticipants');
			if (!empty($externalParticipants)) {
				foreach ($externalParticipants as $participant) {
					$appointment->externalParticipants()->save(new AppointmentExternalParticipant([
						'name'  => $participant['name'],
						'email' => $participant['email'],
						'phone' => $participant['phone'],
					]));
				}
			}
			
			$itemsToDiscuss = $request->input('itemsToDiscuss');
			if (!empty($itemsToDiscuss)) {
				foreach ($itemsToDiscuss as $itemToDiscuss) {
					$appointment->items()->save(new AppointmentItem([
						'details' => $itemToDiscuss,
					]));
				}
			}
			
			/** @var \App\Appointment $appointment */
			$appointment = Appointment::with('internalParticipants', 'externalParticipants', 'items')
				->findOrFail($appointment->id);
			
			/** @var AppointmentInternalParticipant $internalParticipant */
			foreach ($appointment->internalParticipants as $internalParticipant) {
				$internalParticipant->notify(new AppointmentNotification($appointment));
			}
			
			/** @var \App\AppointmentExternalParticipant $externalParticipant */
			foreach ($appointment->externalParticipants as $externalParticipant) {
				$externalParticipant->notify(new AppointmentNotification($appointment));
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
		
		/**
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function userSuggestions(Request $request)
		{
			$client = Auth::user()->getClient();
			
			$this->validate($request, [
				'search' => 'required|string',
			]);
			
			$query = $request->input('search') . '';
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
