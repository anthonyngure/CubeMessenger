<?php
	
	namespace App\Observers;
	
	use App\Charge;
	use App\Subscription;
	use App\User;
	
	class SubscriptionObserver
	{
		
		/**
		 * Listen to the Subscription creating event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function creating(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription created event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function created(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription updating event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function updating(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription updated event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function updated(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription saving event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function saving(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription saved event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function saved(Subscription $subscription)
		{
			//code...
			
			/**
			 * Charge client for this subscription
			 * The user associated with the delivery
			 * @var \App\User $user
			 */
			$user = User::with('client')->findOrFail($subscription->user_id);
			
			$amount = $subscription->item_cost + $subscription->delivery_fee;
			
			$description = 'Subscription for ' . $subscription->optionItem()->firstOrFail(['name'])->name;
			
			Charge::updateOrCreate([
				'client_id'       => $user->client_id,
				'chargeable_id'   => $subscription->id,
				'chargeable_type' => Subscription::class,
			], [
				'description' => $description,
				'amount'      => $amount,
			]);
		}
		
		/**
		 * Listen to the Subscription deleting event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function deleting(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription deleted event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function deleted(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription restoring event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function restoring(Subscription $subscription)
		{
			//code...
		}
		
		/**
		 * Listen to the Subscription restored event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function restored(Subscription $subscription)
		{
			//code...
		}
	}