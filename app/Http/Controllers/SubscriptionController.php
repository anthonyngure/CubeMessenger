<?php
	
	namespace App\Http\Controllers;
	
	use App\Exceptions\WrappedException;
	use App\Subscription;
	use App\SubscriptionOptionItem;
	use Auth;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	use Illuminate\Http\Request;
	
	class SubscriptionController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index(Request $request)
		{
			$client = Auth::user()->getClient();
			$this->validate($request, [
				'filter' => 'required|in:active,pendingApproval,rejected',
			]);
			
			if ($request->filter === 'pendingApproval') {
				$subscriptions = Subscription::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'AT_DEPARTMENT_HEAD')
					->orWhere('status', 'AT_PURCHASING_HEAD')
					->with(['optionItem'])
					->get();
			} else if ($request->filter === 'rejected') {
				$subscriptions = Subscription::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'REJECTED')
					->with(['optionItem'])
					->with(['rejectedBy' => function (BelongsTo $belongsTo) {
						$belongsTo->with('role');
					}])
					->get();
			} else {
				$subscriptions = Subscription::whereIn('user_id', $client->users->pluck('id'))
					->where('status', 'ACTIVE')
					->with(['optionItem'])
					->get();
			}
			
			return $this->collectionResponse($subscriptions);
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
				'optionId'        => 'required|exists:subscription_options,id',
				'optionItemId'    => 'required|exists:subscription_option_items,id',
				'quantity'        => 'required|numeric',
				'weekdays'        => 'required',
				'itemCost'        => 'required|numeric',
				'deliveryCost'    => 'required|numeric',
				'renewEveryMonth' => 'required_without:terminationDate|boolean',
				'terminationDate' => 'required_without:renewEveryMonth',
			]);
			
			$amountToCharge = $request->json('itemCost') + $request->json('deliveryCost');
			
			$this->checkBalance($amountToCharge);
			
			$subscription = Subscription::create([
				'user_id'                     => \Auth::user()->getKey(),
				'quantity'                    => $request->json('quantity'),
				'subscription_option_item_id' => $request->json('optionItemId'),
				'weekdays'                    => $request->json('weekdays'),
				'renew_every_month'           => $request->json('renewEveryMonth'),
				'termination_date'            => $request->json('terminationDate'),
				'item_cost'                   => $request->json('itemCost'),
				'delivery_cost'               => $request->json('deliveryCost'),
			]);
			
			return $this->itemCreatedResponse($subscription);
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
			$subscriptionItem = SubscriptionOptionItem::with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
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
		 */
		public function update(Request $request, $id)
		{
			
			$this->validate($request, [
				'action' => 'required|in:approve,reject',
			]);
			
			$subscription = Subscription::findOrFail($id);
			$user = \Auth::user();
			
			if ($request->action == 'reject') {
				$subscription->rejected_by_id = $user->getKey();
			}
			
			if (($subscription->status == 'AT_DEPARTMENT_HEAD' && $user->isDepartmentHead())) {
				$subscription->status = $request->action == 'approve' ? 'AT_PURCHASING_HEAD' : 'REJECTED';
				$subscription->save();
			} else if (($subscription->status == 'AT_PURCHASING_HEAD' && $user->isPurchasingHead())) {
				$subscription->status = $request->action == 'approve' ? 'ACTIVE' : 'REJECTED';
				$subscription->save();
			} else {
				throw new WrappedException("You are not allowed to perform the requested operation");
			}
			
			$client = Auth::user()->getClient();
			
			$subscriptions = Subscription::whereIn('user_id', $client->users->pluck('id'))
				->where('status', 'AT_DEPARTMENT_HEAD')
				->orWhere('status', 'AT_PURCHASING_HEAD')
				->with(['optionItem'])
				->get();
			
			return $this->itemDeletedResponse($subscriptions);
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
			$clientSubscription = Subscription::whereClientId($client->getKey())
				->where('subscription_item_id', $id)->firstOrFail();
			
			//Delete weekdays
			ClientSubscriptionSchedule::whereClientSubscriptionId($clientSubscription->getKey())->delete();
			
			//Delete the subscription now
			$clientSubscription->delete();
			
			$subscriptionItem = SubscriptionOptionItem::with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
				$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
			}])->findOrFail($id);
			
			return $this->itemDeletedResponse($subscriptionItem);
		}
		
	}
