<?php
	
	namespace App\Http\Controllers;
	
	use App\SubscriptionSchedule;
	
	class SubscriptionScheduleController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			//
			
			$data = SubscriptionSchedule::all();
			
			return $this->collectionResponse($data);
		}
		
	}
