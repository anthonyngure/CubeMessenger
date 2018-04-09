<?php
	
	namespace App\Observers;
	
	use App\Charge;
	use App\ShopOrder;
	use App\User;
	
	class ShopOrderObserver
	{
		
		/**
		 * Listen to the ShopOrder creating event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function creating(ShopOrder $shopOrder)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder created event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function created(ShopOrder $shopOrder)
		{
			//code...
			
			/**
			 * Charge client for this order
			 * The user associated with the delivery
			 * @var \App\User $user
			 */
			$user = User::with('client')->findOrFail($shopOrder->user_id);
			
			/** @var \App\ShopProduct $product */
			$product = $shopOrder->shopProduct()->firstOrFail();
			$amount = $product->price * $shopOrder->quantity;
			Charge::updateOrCreate([
				'client_id'       => $user->client_id,
				'chargeable_id'   => $shopOrder->id,
				'chargeable_type' => ShopOrder::class,
			], [
				'amount' => $amount,
			]);
		}
		
		/**
		 * Listen to the ShopOrder updating event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function updating(ShopOrder $shopOrder)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder updated event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function updated(ShopOrder $shopOrder)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder saving event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function saving(ShopOrder $shopOrder)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder saved event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function saved(ShopOrder $shopOrder)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder deleting event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function deleting(ShopOrder $shopOrder)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder deleted event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function deleted(ShopOrder $shopOrder)
		{
		
		}
		
		/**
		 * Listen to the ShopOrder restoring event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function restoring(ShopOrder $shopOrder)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder restored event.
		 *
		 * @param  ShopOrder $shopOrder
		 * @return void
		 */
		public function restored(ShopOrder $shopOrder)
		{
			//code...
		}
	}