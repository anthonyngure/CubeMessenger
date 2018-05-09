<?php
	
	namespace App\Http\Controllers;
	
	use App\Delivery;
	use App\DeliveryItem;
	use App\Exceptions\WrappedException;
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
			$this->validate($request, [
				'filter' => 'required|in:pendingApproval,pendingDelivery,delivered,rejected,rider',
				'month'  => 'required_unless:filter,rider',
			]);
			
			if ($request->filter == 'rider') {
				$deliveries = Delivery::whereHas('items', function (Builder $builder) use ($request) {
					$builder->where('status', 'PENDING_DELIVERY');
				})->with(['items' => function (HasMany $hasMany) {
					$hasMany->with(['courierOption' => function (BelongsTo $belongsTo) {
						$belongsTo->select(['id', 'name', 'plural_name', 'icon']);
					}])->orderByDesc('id');
				}])->orderByDesc('id')->get();
				
				
				return $this->collectionResponse($deliveries);
			} else {
				
				$client = Auth::user()->getClient();
				
				$deliveries = Delivery::whereIn('user_id', $client->users->pluck('id'))
					->whereHas('items', function (Builder $builder) use ($request) {
						if ($request->filter == 'pendingApproval') {
							$builder->where('status', 'AT_DEPARTMENT_HEAD')
								->orWhere('status', 'AT_PURCHASING_HEAD');
						} else if ($request->filter == 'pendingDelivery') {
							$builder->where('status', 'PENDING_DELIVERY')
								->orWhere('status', 'EN_ROUTE_TO_DESTINATION');
						} else if ($request->filter == 'delivered') {
							$builder->where('status', 'AT_DESTINATION');
						} else {
							$builder->where('status', 'REJECTED');
						}
					})
					->with(['items' => function (HasMany $hasMany) {
						$hasMany->with(['rejectedBy', 'courierOption' => function (BelongsTo $belongsTo) {
							$belongsTo->select(['id', 'name', 'plural_name', 'icon']);
						}])->orderByDesc('id');
					}])->orderByDesc('id')
					//->toSql();
					->get();
				
				//dd($deliveries);
				
				return $this->collectionResponse($deliveries);
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
			
			$this->checkBalance($request->json('estimatedCost'));
			
			
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
		 */
		public function update(Request $request, $id)
		{
			/**
			 * An update on deliveries will only come from the staff app with a rider
			 */
			
			$this->validate($request, [
				'pickupLatitude'  => 'required|numeric',
				'pickupLongitude' => 'required|numeric',
			]);
			
			$this->checkIfUserIsRider();
			
			/** @var Delivery $delivery */
			$delivery = Delivery::with(['items' => function (HasMany $hasMany) {
				$hasMany->with('courierOption');
			}, 'user'                           => function (BelongsTo $belongsTo) {
				$belongsTo->with('client');
			}])->findOrFail($id);
			
			
			$delivery->rider_id = Auth::user()->getKey();
			$delivery->pickup_time = Carbon::now()->toDateTimeString();
			$delivery->pickup_latitude = $request->pickupLatitude;
			$delivery->pickup_longitude = $request->pickupLongitude;
			$delivery->save();
			
			/** @var DeliveryItem $deliveryItem */
			foreach ($delivery->items as $deliveryItem) {
				$deliveryItem->estimated_arrival_time = Carbon::now()
					->addSeconds($deliveryItem->estimated_duration)
					->toDateTimeString();
				$deliveryItem->received_confirmation_code = Messages::code($deliveryItem->recipient_contact);
				$deliveryItem->status = 'EN_ROUTE_TO_DESTINATION';
				$deliveryItem->save();
				
				
				//Send sms to the recipient of the item
				$nameToUse = $deliveryItem->quantity > 1 ? $deliveryItem->courierOption->plural_name
					: $deliveryItem->courierOption->name;
				$smsText = 'Hi ' . $deliveryItem->recipient_name . ', ' . $deliveryItem->quantity . ' ' . $nameToUse .
					' from ' . $delivery->user->client->name . ' will be delivered to you around '
					. $deliveryItem->estimated_arrival_time . '. Use CODE: ' . $deliveryItem->received_confirmation_code .
					' to confirm you have received.';
				
				$this->sendSMS($smsText, $deliveryItem->recipient_contact);
				
				//dd($smsText);
			}
			
			$delivery->setHidden(['client']);
			
			return $this->itemUpdatedResponse($delivery);
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
