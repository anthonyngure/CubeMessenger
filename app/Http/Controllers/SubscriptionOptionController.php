<?php
	
	namespace App\Http\Controllers;
	
	use App\Subscription;
	use App\SubscriptionOption;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	
	class SubscriptionOptionController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index()
		{
			/**
			 * Return subscription option with items that the client is not subscribed to yet
			 */
			$client = \Auth::user()->getClient();
			
			/**
			 * Get all client subscriptions
			 */
			$subscriptions = Subscription::whereIn('user_id', $client->users->pluck('id'))
				->with(['optionItem'])
				->get();
			/**
			 * Get an array of client subscription option item ids
			 */
			$subscriptionOptionItemIds = $subscriptions->pluck('subscription_option_item_id');
			
			/**
			 * Exlude items with id in $subscriptionOptionItemIds
			 */
			$data = SubscriptionOption::with(['items' => function (HasMany $hasMany) use ($subscriptionOptionItemIds) {
				$hasMany->whereNotIn('id', $subscriptionOptionItemIds);
			}])->get();
			
			return $this->collectionResponse($data);
		}
		
	}
