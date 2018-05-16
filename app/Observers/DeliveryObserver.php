<?php
	
	namespace App\Observers;
	
	use App\Bill;
	use App\Delivery;
	use App\User;
	use App\Utils;
	
	class DeliveryObserver
	{
		
		/**
		 * Listen to the Delivery creating event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function creating(Delivery $delivery)
		{
			//code...
		}
		
		/**
		 * Listen to the Delivery created event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function created(Delivery $delivery)
		{
			/**
			 * Charge this delivery
			 * The user associated with the delivery
			 * @var \App\User $user
			 */
			$user = User::with('client')->findOrFail($delivery->user_id);
			
			
			$description = 'Delivery from ' . $delivery->origin_name;
			
			Bill::updateOrCreate([
				'client_id'     => $user->client_id,
				'billable_id'   => $delivery->id,
				'billable_type' => Delivery::class,
			], [
				'description' => $description,
				'amount'      => $delivery->estimated_cost,
			]);
		}
		
		/**
		 * Listen to the Delivery updating event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function updating(Delivery $delivery)
		{
			//code...
		}
		
		/**
		 * Listen to the Delivery updated event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function updated(Delivery $delivery)
		{
			//code...
		}
		
		/**
		 * Listen to the Delivery saving event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function saving(Delivery $delivery)
		{
			//code...
		}
		
		/**
		 * Listen to the Delivery saved event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function saved(Delivery $delivery)
		{
			//code...
			
		}
		
		/**
		 * Listen to the Delivery deleting event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function deleting(Delivery $delivery)
		{
			//code...
		}
		
		/**
		 * Listen to the Delivery deleted event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function deleted(Delivery $delivery)
		{
			//code...
		}
		
		/**
		 * Listen to the Delivery restoring event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function restoring(Delivery $delivery)
		{
			//code...
		}
		
		/**
		 * Listen to the Delivery restored event.
		 *
		 * @param  Delivery $delivery
		 * @return void
		 */
		public function restored(Delivery $delivery)
		{
			//code...
		}
	}