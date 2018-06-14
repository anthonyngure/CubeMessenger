<?php
	
	namespace App\Http\Controllers;
	
	use App\Delivery;
	use App\DeliveryItem;
	use App\Exceptions\WrappedException;
	use App\Notifications\DeliveryItemRecipientNotification;
	use Auth;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
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
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param                           $deliveryId
		 * @param                           $itemId
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Exception
		 */
		public function update(Request $request, $deliveryId, $itemId)
		{
			
			/**
			 * action is required when we are updating from the Web
			 * code, receivedLatitude & receivedLongitude are required when updating from the stuff app
			 * code is the recipient confirmation code sent to the recipient of the delivery item
			 * receivedLongitude & receivedLongitude are the coordinates of where the recipient
			 * enters the code on receiving the item
			 */
			
			
			$this->validate($request, [
				'code'              => 'required_with:receivedLatitude,receivedLongitude|digits:4',
				'receivedLatitude'  => 'required_with:code,receivedLongitude|numeric',
				'receivedLongitude' => 'required_with:code,receivedLatitude|numeric',
				'action'            => 'required_without:code,receivedLatitude,receivedLongitude|in:approve,reject',
			]);
			
			/** @var DeliveryItem $deliveryItem */
			$deliveryItem = DeliveryItem::whereDeliveryId($deliveryId)->findOrFail($itemId);
			
			/**
			 * Make sure the status of this item is EN_ROUTE_TO_DESTINATION
			 */
			
			//$deliveryItem->checkEnRouteRoDestination();
			
			if (!empty($request->action)) {
				
				//It is an update from the web
				
				$this->handleApprovals($request, $deliveryItem, 'PENDING_DELIVERY');
				
				$deliveries = Delivery::whereIn('user_id',
					Auth::user()->getClient()->users->pluck('id'))
					->whereHas('items', function (Builder $builder) use ($request) {
						$builder->where('status', 'AT_DEPARTMENT_HEAD')
							->orWhere('status', 'AT_PURCHASING_HEAD');
					})
					->with(['items' => function (HasMany $hasMany) {
						$hasMany->with(['courierOption' => function (BelongsTo $belongsTo) {
							$belongsTo->select(['id', 'name', 'plural_name', 'icon']);
						}])->orderByDesc('id');
					}])->orderByDesc('id')
					//->toSql();
					->get();
				
				//dd($deliveries);
				return $this->collectionResponse($deliveries);
				
			} else {
				
				//This is an update from a stuff app
				
				$this->checkIfUserIsRider();
				
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
		 * @param $deliveryId
		 * @param $itemId
		 * @return \Illuminate\Http\Response
		 */
		public function token($deliveryId, $itemId)
		{
			/** @var DeliveryItem $deliveryItem */
			$deliveryItem = DeliveryItem::whereDeliveryId($deliveryId)->findOrFail($itemId);
			
			$deliveryItem->notify(new DeliveryItemRecipientNotification());
			
			return $this->itemResponse($deliveryItem);
		}
	}
