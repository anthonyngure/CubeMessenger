<?php
	
	namespace App\Http\Controllers;
	
	use App\Subscription;
	use App\SubscriptionOptionItem;
	use App\Utils;
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
			
			/** @var SubscriptionOptionItem $subscriptionOptionItem */
			$subscriptionOptionItem = SubscriptionOptionItem::findOrFail($request->json('optionItemId'));
			
			$insufficientBalanceMessage = 'You have insufficient balance to subscribe for '
				. $request->json('quantity') . ' ' . $subscriptionOptionItem->name .
				' at a cost of  ' . Utils::toCurrencyText($amountToCharge);
			
			$this->checkBalance($amountToCharge, $insufficientBalanceMessage);
			
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
			$client = Auth::user()->getClient();
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
		 * @throws \Exception
		 */
		public function update(Request $request, $id)
		{
			
			$this->validate($request, [
				'action' => 'required|in:approve,reject',
			]);
			
			/** @var \App\Subscription $subscription */
			$subscription = Subscription::findOrFail($id);
			
			$this->handleApprovals($request, $subscription, 'ACTIVE');
			
			$subscriptions = Subscription::whereIn('user_id',
				Auth::user()->getClient()->users->pluck('id'))
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
		
		}
		
	}
