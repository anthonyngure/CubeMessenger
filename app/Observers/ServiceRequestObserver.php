<?php
	
	namespace App\Observers;
	
	use App\Bill;
	use App\Mail\ServiceRequestQuote;
	use App\ServiceRequest;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	use Mail;
	
	class ServiceRequestObserver
	{
		
		/**
		 * Listen to the ServiceRequest creating event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function creating(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest created event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function created(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest updating event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function updating(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest updated event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function updated(ServiceRequest $serviceRequest)
		{
			/** @var ServiceRequest $serviceRequest */
			$serviceRequest = ServiceRequest::with(['quote' => function (HasOne $hasOne) {
				$hasOne->with('items');
			}, 'user'                                       => function (BelongsTo $belongsTo) {
				$belongsTo->with('client');
			}])->findOrFail($serviceRequest->getKey());
			
			//code...
			if ($serviceRequest->status == 'PENDING_QUOTE_CONFIRMATION') {
				
				Mail::to($serviceRequest->user->client)->queue(new ServiceRequestQuote($serviceRequest));
			}
			if ($serviceRequest->status == 'PENDING_ATTENDANCE') {
				/**
				 * Charge client for this order
				 * The user associated with the delivery
				 * @var \App\User $user
				 */;
				
				$amount = $serviceRequest->quote->diagnosis_cost + $serviceRequest->quote->labour_cost;
				
				foreach ($serviceRequest->quote->items as $item) {
					$amount += $item->price;
				}
				
				$description = $serviceRequest->type . ' service request';
				
				Bill::updateOrCreate([
					'client_id'       => $serviceRequest->user->client->id,
					'billable_id'   => $serviceRequest->id,
					'billable_type' => ServiceRequest::class,
				], [
					'description' => $description,
					'amount'      => $amount,
				]);
			}
		}
		
		/**
		 * Listen to the ServiceRequest saving event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function saving(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest saved event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function saved(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest deleting event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function deleting(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest deleted event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function deleted(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest restoring event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function restoring(ServiceRequest $serviceRequest)
		{
			//code...
		}
		
		/**
		 * Listen to the ServiceRequest restored event.
		 *
		 * @param  ServiceRequest $serviceRequest
		 * @return void
		 */
		public function restored(ServiceRequest $serviceRequest)
		{
			//code...
		}
	}