<?php
	
	namespace App\Http\Controllers;
	
	use App\ServiceRequest;
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
			
			$client = $this->getClient();
			
			$this->validate($request, [
				'filter' => 'required|in:pendingApproval,pending,attended,rejected',
				'type'   => 'required|in:it,repair',
			]);
			
			if ($request->filter === 'pendingApproval'){
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'AT_DEPARTMENT_HEAD')
					->orWhere('status', 'AT_PURCHASING_HEAD')
					->whereType(strtoupper($request->type))->get();
			}
			else if($request->filter === 'pending'){
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'PENDING')
					->whereType(strtoupper($request->type))->get();
			}
			else if($request->filter === 'attended'){
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'ATTENDED')
					->whereType(strtoupper($request->type))->get();
			}
			else {
				$services = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'REJECTED')
					->whereType(strtoupper($request->type))->get();
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
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
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
