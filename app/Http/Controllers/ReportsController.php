<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	
	class ReportsController extends Controller
	{
		//
		
		/**
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index(Request $request)
		{
			$client = \Auth::user()->getClient();
			$this->validate($request, [
				'filter' => 'required|in:bills,subscriptions,shopping,it,repairs,courier',
			]);
			
			if ($request->filter == 'bills') {
				$data = $client->bills()->get();
			} else {
				return $this->arrayResponse([]);
			}
			
			return $this->collectionResponse($data);
		}
	}
