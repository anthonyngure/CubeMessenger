<?php
	
	namespace App;
	
	use App\Notifications\LPONotification;
	use App\Notifications\TestScheduledNotification;
	use Illuminate\Database\Eloquent\Builder;
	
	class ScheduledTasksManager
	{
		//
		
		public static function sendTestEmail()
		{
			/** @var \App\User $admin */
			$admin = User::whereHas('role', function (Builder $builder) {
				$builder->where('name', 'ADMIN');
			})->firstOrFail();
			$admin->notify(new TestScheduledNotification());
		}
		
		public static function sendLPO()
		{
			$suppliers = User::whereHas('role', function (Builder $builder) {
				return $builder->where('name', 'SUPPLIER');
			})->get();
			
			/** @var \App\User $supplier */
			foreach ($suppliers as $supplier) {
				//Get supplier products
				$products = $supplier->products()->get();
				//dd($products->pluck('id'));
				//Get order items with this supplier products
				$orderItems = OrderItem::whereStatus('PENDING_LPO')->whereIn('product_id', $products->pluck('id'))->get();
				//dd($orderItems->count());
				//Group the orderItems by product id
				$orderItemsGroupedByProductId = $orderItems->groupBy('product_id');
				//dd($orderItemsGroupedByProductId->count());
				$LPOItems = array();
				foreach ($orderItemsGroupedByProductId as $key => $orderItemsProductGroup) {
					
					//dd($orderItemsProductGroup);
					
					//Key is the product Id
					//Sum the total quantity we need for this product from this supplier
					//To make an LPO Item
					/** @var \App\Product $product */
					$product = Product::findOrFail($key);
					array_push($LPOItems, [
						'item'     => $product->name,
						'quantity' => collect($orderItemsProductGroup)->sum('quantity'),
					]);
					
					//Update order items in this product group to status SENT_LPO
					/** @var OrderItem $orderItem */
					foreach ($orderItemsProductGroup as $orderItem) {
						$orderItem->update(['status' => 'SENT_LPO']);
					}
					
				}
				
				if (count($LPOItems) > 0) {
					
					$supplier->notify(new LPONotification($LPOItems, $supplier));
				}
				
			}
		}
	}
