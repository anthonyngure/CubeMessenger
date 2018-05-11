<?php
	
	namespace App\Observers;
	
	use App\Notifications\TopUpNotification;
	use App\TopUp;
	use App\Utils;
	
	class TopUpObserver
	{
		
		/**
		 * Listen to the TopUp creating event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function creating(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp created event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function created(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp updating event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function updating(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp updated event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function updated(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp saving event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function saving(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp saved event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function saved(TopUp $topUp)
		{
			/** @var \App\Client $client */
			$client = $topUp->client()->firstOrFail();
			$client->notify(new TopUpNotification($topUp));
		}
		
		/**
		 * Listen to the TopUp deleting event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function deleting(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp deleted event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function deleted(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp restoring event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function restoring(TopUp $topUp)
		{
			//code...
		}
		
		/**
		 * Listen to the TopUp restored event.
		 *
		 * @param  TopUp $topUp
		 * @return void
		 */
		public function restored(TopUp $topUp)
		{
			//code...
		}
	}