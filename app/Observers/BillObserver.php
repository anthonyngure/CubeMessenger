<?php
	
	namespace App\Observers;
	
	use App\Bill;
	use App\Notifications\BillCanceledNotification;
	use App\Notifications\BillNotification;
	
	class BillObserver
	{
		
		/**
		 * Listen to the Bill creating event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function creating(Bill $bill)
		{
			//code...
		}
		
		/**
		 * Listen to the Bill created event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function created(Bill $bill)
		{
			//code...
			
			/** @var \App\Client $client */
			$client = $bill->client()->firstOrFail();
			$client->notify(new BillNotification($bill));
			
		}
		
		/**
		 * Listen to the Bill updating event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function updating(Bill $bill)
		{
			//code...
			
			
		}
		
		/**
		 * Listen to the Bill updated event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function updated(Bill $bill)
		{
			
		}
		
		/**
		 * Listen to the Bill saving event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function saving(Bill $bill)
		{
			//code...
		}
		
		/**
		 * Listen to the Bill saved event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function saved(Bill $bill)
		{
			//code...
			
			
		}
		
		/**
		 * Listen to the Bill deleting event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function deleting(Bill $bill)
		{
			//code...
		}
		
		/**
		 * Listen to the Bill deleted event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function deleted(Bill $bill)
		{
			//code...
			
			
			/** @var \App\Client $client */
			$client = $bill->client()->firstOrFail();
			$client->notify(new BillCanceledNotification($bill));
			
			
		}
		
		/**
		 * Listen to the Bill restoring event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function restoring(Bill $bill)
		{
			//code...
		}
		
		/**
		 * Listen to the Bill restored event.
		 *
		 * @param  Bill $bill
		 * @return void
		 */
		public function restored(Bill $bill)
		{
			/** @var \App\Client $client */
			$client = $bill->client()->firstOrFail();
			$client->notify(new BillNotification($bill));
		}
	}