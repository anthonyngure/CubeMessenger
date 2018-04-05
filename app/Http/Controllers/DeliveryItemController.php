<?php
	
	namespace App\Http\Controllers;
	
	use App\Delivery;
	use App\DeliveryItem;
	use App\Exceptions\WrappedException;
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
		 */
		public function update(Request $request, $deliveryId, $itemId)
		{
			//An update on deliveries will only come from the riders
			
			$this->validate($request, [
				'code'              => 'required_with:receivedLatitude,receivedLongitude|digits:4',
				'receivedLatitude'  => 'required_with:code,receivedLongitude|numeric',
				'receivedLongitude' => 'required_with:code,receivedLatitude|numeric',
				'action'            => 'required_without:code,receivedLatitude,receivedLongitude|in:approve,reject',
			]);
			
			/** @var DeliveryItem $deliveryItem */
			$deliveryItem = DeliveryItem::findOrFail($itemId);
			
			if (!empty($request->action)) {
				
				if ($request->action == 'reject') {
					$deliveryItem->rejected_by_id = Auth::user()->getKey();
				}
				
				//This is an update from the web, either
				$client = $this->getClient();
				$user = Auth::user();
				if (($deliveryItem->status == 'AT_DEPARTMENT_HEAD' && $user->isDepartmentHead())) {
					$deliveryItem->status = $request->action == 'approve' ? 'AT_PURCHASING_HEAD' : 'REJECTED';
					$deliveryItem->save();
				} else if (($deliveryItem->status == 'AT_PURCHASING_HEAD' && $user->isPurchasingHead())) {
					$deliveryItem->status = $request->action == 'approve' ? 'PENDING_DELIVERY' : 'REJECTED';
					$deliveryItem->save();
				} else {
					throw new WrappedException("You are not allowed to perform the requested operation");
				}
				
				$deliveries = Delivery::whereIn('user_id', $client->users->pluck('id'))
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
				
				$deliveries->each(function (Delivery $delivery) {
					$stats = array();
					$courierOptionGroups = $delivery->items->groupBy('courier_option_id');
					foreach ($courierOptionGroups as $courierOptionGroup) {
						$totalQuantity = 0;
						foreach ($courierOptionGroup as $courierOptionDeliveryItem) {
							$totalQuantity += $courierOptionDeliveryItem->quantity;
						}
						array_push($stats, [
							'courierOption' => $courierOptionGroup->first()->courierOption,
							'count'         => $totalQuantity,
						]);
					}
					$delivery->stats = $stats;
				});
				
				return $this->collectionResponse($deliveries);
				
			} else {
				
				//This is an update from a rider
				
				/** @var \App\User $rider */
				$rider = Auth::user();
				
				if ($rider->account_type != 'RIDER') {
					throw new WrappedException('You are not authorized to perform deliveries!');
				}
				
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
	}
