<?php
	
	namespace App\Http\Controllers;
	
	use App\Delivery;
	use App\ServiceRequest;
	use App\ShopOrder;
	use App\Subscription;
	use Auth;
	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Http\Request;
	
	class UIController extends Controller
	{
		//
		/**
		 * @throws \App\Exceptions\WrappedException
		 */
		public function drawerItems()
		{
			$client = $this->getClient();
			$pendingShopOrders = ShopOrder::whereIn('user_id', $client->users->pluck('id'))
				->where('status', '!=', 'DELIVERED')
				->where('status', '!=', 'REJECTED')
				->count();
			$pendingDeliveries = Delivery::whereIn('user_id', $client->users->pluck('id'))
				->whereHas('items', function (Builder $builder) {
					$builder->where('status', '!=', 'REJECTED')
						->where('status', '!=', 'AT_DESTINATION');
				})->count();
			
			$pendingSubscriptions = Subscription::whereIn('user_id', $client->users->pluck('id'))
				->where('status', '!=', 'REJECTED')
				->Where('status', '!=', 'EXPIRED')
				->Where('status', '!=', 'ACTIVE')
				->count();
			
			$pendingITServiceRequests = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
				->where('status', '!=', 'ATTENDED')
				->where('status', '!=', 'REJECTED')
				->whereType('IT')->count();
			
			$pendingRepairServiceRequests = ServiceRequest::whereIn('user_id', $client->users->pluck('id'))
				->where('status', '!=', 'ATTENDED')
				->where('status', '!=', 'REJECTED')
				->whereType('REPAIR')->count();
			
			$items = [
				['icon' => 'dashboard', 'title' => 'Dashboard', 'route' => 'dashboard', 'pendingApprovals' => 0],
				['icon' => 'schedule', 'title' => 'Subscriptions', 'route' => 'subscriptions', 'pendingApprovals' => $pendingSubscriptions],
				['icon' => 'date_range', 'title' => 'Appointments', 'route' => 'appointments', 'pendingApprovals' => 0],
				['icon' => 'shopping_cart', 'title' => 'Shopping', 'route' => 'shopping', 'pendingApprovals' => 0],
				['icon' => 'shopping_basket', 'title' => 'Orders', 'route' => 'orders', 'pendingApprovals' => $pendingShopOrders],
				['icon' => 'computer', 'title' => 'IT Services', 'route' => 'it', 'pendingApprovals' => $pendingITServiceRequests],
				['icon' => 'build', 'title' => 'Repair Services', 'route' => 'repairs', 'pendingApprovals' => $pendingRepairServiceRequests],
				['icon' => 'local_shipping', 'title' => 'Courier', 'route' => 'courier', 'pendingApprovals' => $pendingDeliveries],
				['icon' => 'group', 'title' => 'Users', 'route' => 'users', 'pendingApprovals' => 0],
				['icon' => 'group_work', 'title' => 'Departments', 'route' => 'departments', 'pendingApprovals' => 0],
				['icon' => 'settings', 'title' => 'Settings', 'route' => 'settings', 'pendingApprovals' => 0],
			];
			
			return $this->arrayResponse($items);
			
		}
		
		/**
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function balance()
		{
			$client = $this->getClient();
			
			$data = [
				'actual'  => $client->getBalance(),
				'limit'   => $client->limit,
				'spent'   => $client->getSpent(),
				'blocked' => $client->getBlocked(),
			];
			
			return $this->arrayResponse($data);
			
		}
		
		/**
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function userSuggestions(Request $request)
		{
			$client = Auth::user()->getClient();
			
			$this->validate($request, [
				'search' => 'required',
			]);
			
			$query = $request->search . '';
			//dd($query);
			$suggestions = $client->users()
				->where('name', 'LIKE', '%' . $query . '%')
				->where('email', 'LIKE', '%' . $query . '%')
				->get();
			
			return $this->collectionResponse($suggestions);
		}
	}
