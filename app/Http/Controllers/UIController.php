<?php
	
	namespace App\Http\Controllers;
	
	use App\Delivery;
	use App\ShopOrder;
	use Illuminate\Database\Eloquent\Builder;
	
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
			$items = [
				['icon' => 'dashboard', 'title' => 'Dashboard', 'route' => 'dashboard', 'pendingApprovals' => 0],
				['icon' => 'schedule', 'title' => 'Subscriptions', 'route' => 'subscriptions', 'pendingApprovals' => 0],
				['icon' => 'date_range', 'title' => 'Appointments', 'route' => 'appointments', 'pendingApprovals' => 0],
				['icon' => 'shopping_cart', 'title' => 'Shopping', 'route' => 'shopping', 'pendingApprovals' => 0],
				['icon' => 'shopping_basket', 'title' => 'Orders', 'route' => 'orders', 'pendingApprovals' => $pendingShopOrders],
				['icon' => 'computer', 'title' => 'IT Services', 'route' => 'it', 'pendingApprovals' => 0],
				['icon' => 'build', 'title' => 'Repair Services', 'route' => 'repairs', 'pendingApprovals' => 0],
				['icon' => 'local_shipping', 'title' => 'Courier', 'route' => 'courier', 'pendingApprovals' => $pendingDeliveries],
				['icon' => 'group', 'title' => 'Users', 'route' => 'users', 'pendingApprovals' => 0],
				['icon' => 'group_work', 'title' => 'Departments', 'route' => 'departments', 'pendingApprovals' => 0],
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
				'balance' => $client->getBalance(),
			];
			
			return $this->arrayResponse($data);
			
		}
	}
