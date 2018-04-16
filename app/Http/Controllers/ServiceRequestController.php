<?php
	
	namespace App\Http\Controllers;
	
	use App\Exceptions\WrappedException;
	use App\ServiceRequest;
	use Auth;
	use Illuminate\Http\Request;
	
	class ServiceRequestController extends Controller
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
			//
			
			
			$this->validate($request, [
				'filter' => 'required|in:pendingApproval,pending,attended,rejected,rider',
				'type'   => 'required_unless:filter,rider|in:it,repair',
			]);
			
			if ($request->filter == 'rider') {
				$services = ServiceRequest::where('status', 'PENDING_QUOTE')
					->orWhere('status', 'PENDING_ATTENDANCE')->get();
			} else if ($request->filter === 'pendingApproval') {
				$client = $this->getClient();
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where(function ($query) {
						$query->where('status', 'AT_DEPARTMENT_HEAD')
							->orWhere('status', 'AT_PURCHASING_HEAD');
					})
					->whereType(strtoupper($request->type))->get();
			} else if ($request->filter === 'pending') {
				$client = $this->getClient();
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where(function ($query) {
						$query->where('status', 'PENDING_QUOTE')
							->orWhere('status', 'PENDING_ATTENDANCE');
					})
					->whereType(strtoupper($request->type))->get();
			} else if ($request->filter === 'attended') {
				$client = $this->getClient();
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'ATTENDED')
					->whereType(strtoupper($request->type))->get();
			} else {
				$client = $this->getClient();
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'REJECTED')
					->whereType(strtoupper($request->type))
					->with('rejectedBy')
					->get();
			}
			
			
			return $this->collectionResponse($services);
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function store(Request $request)
		{
			//
			sleep(3);
			$this->validate($request, [
				'details' => 'required',
				'type'    => 'required|in:it,repair',
			]);
			
			$client = $this->getClient();
			
			$serviceRequest = ServiceRequest::create([
				'user_id'       => \Auth::user()->getKey(),
				'schedule_date' => empty($request->scheduleDate) ? date("Y-m-d H:i:s") : $request->scheduleDate,
				'schedule_time' => empty($request->scheduleTime) ? date("H:i:s") : $request->scheduleTime,
				'note'          => $request->note,
				'type'          => $request->type === 'it' ? 'IT' : 'REPAIR',
				'details'       => implode('#', $request->details),
			]);
			
			return $this->itemCreatedResponse($serviceRequest);
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
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function update(Request $request, $id)
		{
			$serviceRequest = ServiceRequest::findOrFail($id);
			$client = $this->getClient();
			
			$this->validate($request, [
				'action' => 'required|in:approve,reject',
				'type'   => 'required|in:it,repair',
			]);
			
			$this->handleApprovals($request, $serviceRequest, 'PENDING_QUOTE');
			
			$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
				->where(function ($query) {
					$query->where('status', 'AT_DEPARTMENT_HEAD')
						->orWhere('status', 'AT_PURCHASING_HEAD');
				})
				->whereType(strtoupper($request->type))->get();
			
			return $this->collectionResponse($services);
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
