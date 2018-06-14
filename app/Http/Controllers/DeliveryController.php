<?php
	
	namespace App\Http\Controllers;
	
	use App\CrudHeader;
	use App\Delivery;
	use App\DeliveryItem;
	use App\Exceptions\WrappedException;
	use App\Notifications\DeliveryItemRecipientNotification;
	use App\Notifications\DeliveryRequestNotification;
	use App\Traits\Messages;
	use App\Utils;
	use Auth;
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Http\Request;
	
	class DeliveryController extends Controller
	{
		use Messages;
		
		/**
		 * Display a listing of the resource.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index(Request $request)
		{
			$user = Auth::user();
			
			if ($user->isAdmin() || $user->isOperations()) {
				$headers = CrudHeader::whereModel(Delivery::class)->get();
				$deliveries = Delivery::with(['user.client', 'rider'])->withCount('items')->get();
				
				//dd($deliveries);
				
				return $this->collectionResponse($deliveries, ['headers' => $headers]);
			} else {
				$this->validate($request, [
					'filter' => 'required|in:pendingApproval,pendingDelivery,delivered,rejected,rider',
					'month'  => 'required_unless:filter,rider',
				]);
				if ($request->filter == 'rider') {
					$deliveries = Delivery::whereHas('items', function ($query) {
						$query->whereNull('status');
					})->with(['items' => function (HasMany $hasMany) {
						$hasMany->whereNull('status')
							->with(['courierOption' => function (BelongsTo $belongsTo) {
								$belongsTo->select(['id', 'name', 'plural_name', 'icon']);
							}])->orderByDesc('id');
					}])->where('status', 'PENDING_DELIVERY')
						->orderByDesc('id')->get();
					
					
					return $this->collectionResponse($deliveries);
				} else {
					
					$client = Auth::user()->getClient();
					
					$builder = Delivery::whereIn('user_id', $client->users->pluck('id'));
					if ($request->filter == 'pendingApproval') {
						$builder = $builder->where(function (Builder $builder) {
							$builder->where('status', 'AT_DEPARTMENT_HEAD')
								->orWhere('status', 'AT_PURCHASING_HEAD');
						});
					} else if ($request->filter == 'rejected') {
						$builder = $builder->where('status', 'REJECTED');
					} else if ($request->filter == 'pendingDelivery') {
						$builder = $builder->where('status', 'PENDING_DELIVERY');
					} else if ($request->filter == 'delivered') {
						$builder = $builder->whereHas('items', function (Builder $builder) {
							$builder->where('status', 'AT_DESTINATION');
						});
					}
					
					$deliveries = $builder->with(['rejectedBy', 'items' => function (HasMany $hasMany) {
						$hasMany->with(['courierOption' => function (BelongsTo $belongsTo) {
							$belongsTo->select(['id', 'name', 'plural_name', 'icon']);
						}])->orderByDesc('id');
					}])->orderByDesc('id')
						//->toSql();
						->get();
					
					//dd($deliveries);
					
					return $this->collectionResponse($deliveries);
				}
			}
			
		}
		
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws WrappedException
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function store(Request $request)
		{
			$client = Auth::user()->getClient();
			
			if (is_null($client)) {
				throw new WrappedException("Sorry, you are not associated to any client.");
			}
			
			\Validator::validate($request->json()->all(), [
				'urgent'                 => 'required|boolean',
				'originName'             => 'required',
				'originVicinity'         => 'required',
				'originFormattedAddress' => 'required',
				'originLatitude'         => 'required|numeric',
				'originLongitude'        => 'required|numeric',
				'estimatedCost'          => 'required|numeric',
				'estimatedMaxDuration'   => 'required|numeric',
				'estimatedMaxDistance'   => 'required|numeric',
			]);
			
			
			$items = $request->json('items');
			
			$scheduleDate = $request->json('scheduleDate');
			$scheduleTime = $request->json('scheduleTime');
			
			$insufficientBalanceMessage = 'You have insufficient balance to request a delivery of ' . count($items) .
				' items to ' . $request->json('originName') . ' at a cost of '
				. Utils::toCurrencyText($request->json('estimatedCost'));
			
			$this->checkBalance($request->json('estimatedCost'), $insufficientBalanceMessage);
			
			
			$delivery = Delivery::create([
				'user_id'                  => Auth::user()->getKey(),
				'urgent'                   => $request->json('urgent'),
				'origin_name'              => $request->json('originName'),
				'origin_vicinity'          => $request->json('originVicinity'),
				'origin_formatted_address' => $request->json('originFormattedAddress'),
				'origin_latitude'          => $request->json('originLatitude'),
				'origin_longitude'         => $request->json('originLongitude'),
				'estimated_cost'           => $request->json('estimatedCost'),
				'estimated_max_duration'   => $request->json('estimatedMaxDuration'),
				'estimated_max_distance'   => $request->json('estimatedMaxDistance'),
				'schedule_date'            => empty($scheduleDate) ? date("Y-m-d H:i:s") : $scheduleDate,
				'schedule_time'            => empty($scheduleTime) ? date("H:i:s") : $scheduleTime,
			]);
			
			$deliveryItems = array();
			foreach ($items as $item) {
				$deliveryItemObject = ((object)$item);
				$deliveryItem = new DeliveryItem([
					'courier_option_id'             => $deliveryItemObject->courierOptionId,
					'destination_name'              => $deliveryItemObject->destinationName,
					'destination_vicinity'          => $deliveryItemObject->destinationVicinity,
					'destination_formatted_address' => $deliveryItemObject->destinationFormattedAddress,
					'destination_latitude'          => $deliveryItemObject->destinationLatitude,
					'destination_longitude'         => $deliveryItemObject->destinationLongitude,
					'recipient_contact'             => Utils::normalizePhone($deliveryItemObject->recipientContact),
					'recipient_name'                => $deliveryItemObject->recipientName,
					'quantity'                      => $deliveryItemObject->quantity,
					'note'                          => $deliveryItemObject->note,
					'estimated_duration'            => $deliveryItemObject->estimatedDuration,
					'estimated_distance'            => $deliveryItemObject->estimatedDistance,
				]);
				
				array_push($deliveryItems, $deliveryItem);
			}
			
			$delivery->items()->saveMany($deliveryItems);
			
			$data = Delivery::with('items')->findOrFail($delivery->getKey());
			
			$client->notify(new DeliveryRequestNotification($delivery));
			
			return $this->itemCreatedResponse($data);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			$delivery = Delivery::with('items')->findOrFail($id);
			
			return $this->itemResponse($delivery);
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Exception
		 */
		public function update(Request $request, $id)
		{
			$this->validate($request, [
				'action' => 'required|in:approve,reject',
			]);
			/** @var Delivery $delivery */
			$delivery = Delivery::with(['items' => function (HasMany $hasMany) {
				$hasMany->with('courierOption');
			}, 'user'                           => function (BelongsTo $belongsTo) {
				$belongsTo->with('client');
			}])->findOrFail($id);
			
			
			//It is an update from the web
			
			$this->handleApprovals($request, $delivery, 'PENDING_DELIVERY');
			
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
		 * @param                          $id
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function start(Request $request, $id)
		{
			
			$this->validate($request, [
				'pickupLatitude'  => 'required:pickupLongitude|numeric',
				'pickupLongitude' => 'required:pickupLatitude|numeric',
			]);
			
			/** @var Delivery $delivery */
			$delivery = Delivery::with(['items' => function (HasMany $hasMany) {
				$hasMany->with('courierOption');
			}, 'user'                           => function (BelongsTo $belongsTo) {
				$belongsTo->with('client');
			}])->findOrFail($id);
			
			$this->checkIfUserIsRider();
			
			$delivery->rider_id = Auth::user()->getKey();
			$delivery->pickup_time = Carbon::now()->toDateTimeString();
			$delivery->pickup_latitude = $request->input('pickupLatitude');
			$delivery->pickup_longitude = $request->input('pickupLongitude');
			$delivery->save();
			
			/** @var DeliveryItem $deliveryItem */
			foreach ($delivery->items as $deliveryItem) {
				$deliveryItem->estimated_arrival_time = Carbon::now()
					->addSeconds($deliveryItem->estimated_duration)
					->toDateTimeString();
				$deliveryItem->received_confirmation_code = Messages::code($deliveryItem->recipient_contact);
				$deliveryItem->status = 'EN_ROUTE_TO_DESTINATION';
				$deliveryItem->save();
				
				
				$deliveryItem->notify(new DeliveryItemRecipientNotification());
				
				//dd($smsText);
			}
			
			$delivery->setHidden(['client']);
			
			return $this->itemUpdatedResponse($delivery);
			
		}
		
		
	}
