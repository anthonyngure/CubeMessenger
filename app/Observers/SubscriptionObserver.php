<?php
	
	namespace App\Observers;
	
	use App\Bill;
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
			/**
			 * Charge client for this subscription
			 * The user associated with the delivery
			 * @var \App\User $user
			 */
			$user = User::with('client')->findOrFail($subscription->user_id);
			
			$amount = $subscription->item_cost + $subscription->delivery_fee;
			
			$description = 'Subscription for ' . $subscription->quantity . ' '
				. $subscription->optionItem()->firstOrFail(['name'])->name . ', '
				. ($subscription->renew_every_month ? ' renewable every month ' : ' until '
					. $subscription->termination_date);
			
			
			Bill::updateOrCreate([
				'client_id'     => $user->client_id,
				'billable_id'   => $subscription->id,
				'billable_type' => Subscription::class,
			], [
				'description' => $description,
				'amount'      => $amount,
			]);
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
			if ($subscription->status == 'REJECTED') {
				$subscription->bill()->delete();
			} else if ($subscription->status == 'ACTIVE') {
				$subscription->bill()->update([
					'status' => 'SETTLED',
				]);
			}
		}
		
		/**
		 * Listen to the Subscription updated event.
		 *
		 * @param  Subscription $subscription
		 * @return void
		 */
		public function updated(Subscription $subscription)
		{
		
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