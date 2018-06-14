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
			$this->validate($request, [
				'code'              => 'required_with:receivedLatitude,receivedLongitude|digits:4',
				'receivedLatitude'  => 'required_with:code,receivedLongitude|numeric',
				'receivedLongitude' => 'required_with:code,receivedLatitude|numeric',
				'action'            => 'required_without:code,receivedLatitude,receivedLongitude|in:approve,reject',
			]);
			
			/** @var DeliveryItem $deliveryItem */
			$deliveryItem = DeliveryItem::whereDeliveryId($deliveryId)->findOrFail($itemId);
			
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
		 * @param                          $deliveryId
		 * @param                          $itemId
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function received(Request $request, $deliveryId, $itemId)
		{
			$this->validate($request, [
				'code'              => 'required|digits:4',
				'receivedLatitude'  => 'required|numeric',
				'receivedLongitude' => 'required|numeric',
			]);
			
			/** @var DeliveryItem $deliveryItem */
			$deliveryItem = DeliveryItem::whereDeliveryId($deliveryId)->findOrFail($itemId);
			
			//This is an update from a stuff app
			
			$this->checkIfUserIsRider();
			
			if ($deliveryItem->received_confirmation_code != $request->input('code')) {
				throw new WrappedException("The code entered is invalid!");
			}
			
			$deliveryItem->received_time = Carbon::now()->toDateTimeString();
			$deliveryItem->received_latitude = $request->input('receivedLatitude');
			$deliveryItem->received_longitude = $request->input('receivedLongitude');
			$deliveryItem->status = 'AT_DESTINATION';
			$deliveryItem->save();
			
			return $this->itemUpdatedResponse($deliveryItem);
			
		}
		
		/**
		 * @param $deliveryId
		 * @param $itemId
		 * @return \Illuminate\Http\Response
		 */
		public function token($deliveryId, $itemId)
		{
			/** @var Delivery $delivery */
			$delivery = Delivery::findOrFail($deliveryId);
			/** @var DeliveryItem $deliveryItem */
			$deliveryItem = $delivery->items()->findOrFail($itemId);
			
			$deliveryItem->notify(new DeliveryItemRecipientNotification($delivery));
			
			return $this->itemResponse($deliveryItem);
		}
	}
