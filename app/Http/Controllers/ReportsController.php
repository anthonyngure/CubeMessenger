<?php
	
	namespace App\Http\Controllers;
	
	use App\DeliveryItem;
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
				'filter' => 'required|in:charges',
			]);
			
			if ($request->filter == 'charges') {
				$data = $client->charges()->get();
			} else {
				$data = DeliveryItem::all();
			}
			
			return $this->collectionResponse($data);
		}
	}
