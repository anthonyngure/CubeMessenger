<?php
	
	namespace App\Observers;
	
	use App\Charge;
	use App\Transaction;
	use App\Utils;
	
	class ChargeObserver
	{
		
		/**
		 * Listen to the Charge creating event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function creating(Charge $charge)
		{
			//code...
		}
		
		/**
		 * Listen to the Charge created event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function created(Charge $charge)
		{
			//code...
			
			/**
			 * The user associated with the chargeable
			 * @var \App\User $user
			 */
			// $user = User::with('client')->findOrFail($charge->chargeable()->user_id);
			
			// $client = $user->client;
			
			
		}
		
		/**
		 * Listen to the Charge updating event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function updating(Charge $charge)
		{
			//code...
			
			//Send email if it is a settlement
			if ($charge->status == 'SETTLED') {
				$context = 'KSH ' . $charge->amount . '  ####### ' . $charge->description;
				Utils::sendDemoEmail($context);
			}
		}
		
		/**
		 * Listen to the Charge updated event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function updated(Charge $charge)
		{
			//code...
			
		}
		
		/**
		 * Listen to the Charge saving event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function saving(Charge $charge)
		{
			//code...
		}
		
		/**
		 * Listen to the Charge saved event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function saved(Charge $charge)
		{
			//code...
		}
		
		/**
		 * Listen to the Charge deleting event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function deleting(Charge $charge)
		{
			//code...
		}
		
		/**
		 * Listen to the Charge deleted event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function deleted(Charge $charge)
		{
			//code...
		}
		
		/**
		 * Listen to the Charge restoring event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function restoring(Charge $charge)
		{
			//code...
		}
		
		/**
		 * Listen to the Charge restored event.
		 *
		 * @param  Charge $charge
		 * @return void
		 */
		public function restored(Charge $charge)
		{
			//code...
		}
	}