<?php
	
	namespace App\Http\Controllers;
	
	use App\Delivery;
	use App\DeliveryItem;
	use App\Exceptions\WrappedException;
	use Auth;
	use Illuminate\Http\Request;
	use Illuminate\Support\Carbon;
	
	class DeliveryItemController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			//
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
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
		 * @param                           $deliveryId
		 * @param                           $itemId
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function update(Request $request, $deliveryId, $itemId)
		{
			//An update on deliveries will only come from the riders
			
			$this->validate($request, [
				'code'              => 'required|digits:4',
				'receivedLatitude'  => 'required|numeric',
				'receivedLongitude' => 'required|numeric',
			]);
			
			/** @var \App\User $rider */
			$rider = Auth::user();
			
			if ($rider->account_type != 'RIDER') {
				throw new WrappedException('You are not authorized to perform deliveries!');
			}
			
			$delivery = Delivery::findOrFail($deliveryId);
			
			/** @var DeliveryItem $deliveryItem */
			$deliveryItem = DeliveryItem::findOrFail($itemId);
			if ($deliveryItem->received_confirmation_code != $request->code) {
				throw new WrappedException("The code entered is invalid!");
			}
			$deliveryItem->received_time = Carbon::now()->toDateTimeString();
			$deliveryItem->received_latitude = $request->receivedLatitude;
			$deliveryItem->received_longitude = $request->receivedLongitude;
			$deliveryItem->status = 'AT_DESTINATION';
			$deliveryItem->save();
			
			return $this->itemUpdatedResponse($deliveryItem);
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
