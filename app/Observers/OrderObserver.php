<?php
	
	namespace App\Observers;
	
	use App\Bill;
	use App\Notifications\OrderNotification;
	use App\Order;
	use App\User;
	
	class OrderObserver
	{
		
		/**
		 * Listen to the ShopOrder creating event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function creating(Order $order)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder created event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function created(Order $order)
		{
			//code...
			
			/**
			 * Charge client for this order
			 * The user associated with the delivery
			 * @var \App\User $user
			 */
			
			
			//$user->client->notify(new OrderNotification($order));
			
			
		}
		
		/**
		 * Listen to the ShopOrder updating event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function updating(Order $order)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder updated event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function updated(Order $order)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder saving event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function saving(Order $order)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder saved event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function saved(Order $order)
		{
		
		}
		
		/**
		 * Listen to the ShopOrder deleting event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function deleting(Order $order)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder deleted event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function deleted(Order $order)
		{
		
		}
		
		/**
		 * Listen to the ShopOrder restoring event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function restoring(Order $order)
		{
			//code...
		}
		
		/**
		 * Listen to the ShopOrder restored event.
		 *
		 * @param  Order $order
		 * @return void
		 */
		public function restored(Order $order)
		{
			//code...
		}
	}