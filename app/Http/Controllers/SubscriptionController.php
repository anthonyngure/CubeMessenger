<?php
	
	namespace App\Http\Controllers;
	
	use App\ClientSubscription;
	use App\ClientSubscriptionSchedule;
	use App\SubscriptionItem;
	use App\SubscriptionSchedule;
	use App\SubscriptionType;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	use Illuminate\Http\Request;
	
	class SubscriptionController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index()
		{
			$client = $this->getClient();
			
			$subscriptionTypes = SubscriptionType::with(['subscriptionItems' => function (HasMany $hasMany) use ($client) {
				$hasMany->with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
					$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
				}]);
			}])->get();
			
			$subscriptionSchedules = SubscriptionSchedule::all();
			
			$data = [
				'subscriptionTypes'     => $subscriptionTypes,
				'subscriptionSchedules' => $subscriptionSchedules,
			];
			
			return $this->arrayResponse($data);
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \App\Exceptions\WrappedException
		 */
		public function store(Request $request)
		{
			//
			\Validator::validate($request->json()->all(), [
				'subscriptionItemId' => 'required|exists:subscription_items,id',
				'quantity'           => 'required|numeric',
				'schedules'          => 'required',
			]);
			
			
			$client = $this->getClient();
			$clientSubscription = ClientSubscription::firstOrCreate([
				'client_id'            => $client->getKey(),
				'quantity'             => $request->json('quantity'),
				'subscription_item_id' => $request->json('subscriptionItemId'),
			]);
			
			$schedules = $request->json('schedules');
			foreach ($schedules as $schedule) {
				ClientSubscriptionSchedule::firstOrCreate([
					'client_subscription_id'   => $clientSubscription->getKey(),
					'subscription_schedule_id' => $schedule,
				]);
			}
			
			$subscriptionItem = SubscriptionItem::with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
				$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
			}])->findOrFail($request->json('subscriptionItemId'));
			
			return $this->itemCreatedResponse($subscriptionItem);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function show($id)
		{
			$client = $this->getClient();
			$subscriptionItem = SubscriptionItem::with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
				$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
			}])->findOrFail($id);
			
			return $this->itemResponse($subscriptionItem);
		}
		
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Illuminate\Validation\ValidationException
		 */
		public function update(Request $request, $id)
		{
			\Validator::validate($request->json()->all(), [
				'subscriptionItemId' => 'required|exists:subscription_items,id',
				'quantity'           => 'required|numeric',
				'schedules'          => 'required',
			]);
			
			$client = $this->getClient();
			$clientSubscription = ClientSubscription::whereClientId($client->getKey())
				->where('subscription_item_id', $id)->firstOrFail();
			
			//Delete schedules
			ClientSubscriptionSchedule::whereClientSubscriptionId($clientSubscription->getKey())->delete();
			
			//Delete the subscription now
			$clientSubscription->delete();
			
			//Create new client subscription
			$clientSubscription = ClientSubscription::firstOrCreate([
				'client_id'            => $client->getKey(),
				'quantity'             => $request->json('quantity'),
				'subscription_item_id' => $request->json('subscriptionItemId'),
			]);
			
			//Add schedules
			$schedules = $request->json('schedules');
			foreach ($schedules as $schedule) {
				ClientSubscriptionSchedule::firstOrCreate([
					'client_subscription_id'   => $clientSubscription->getKey(),
					'subscription_schedule_id' => $schedule,
				]);
			}
			
			$subscriptionItem = SubscriptionItem::with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
				$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
			}])->findOrFail($id);
			
			return $this->itemDeletedResponse($subscriptionItem);
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function destroy($id)
		{
			$client = $this->getClient();
			$clientSubscription = ClientSubscription::whereClientId($client->getKey())
				->where('subscription_item_id', $id)->firstOrFail();
			
			//Delete schedules
			ClientSubscriptionSchedule::whereClientSubscriptionId($clientSubscription->getKey())->delete();
			
			//Delete the subscription now
			$clientSubscription->delete();
			
			$subscriptionItem = SubscriptionItem::with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
				$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
			}])->findOrFail($id);
			
			return $this->itemDeletedResponse($subscriptionItem);
		}
	}
