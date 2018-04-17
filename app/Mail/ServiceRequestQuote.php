<?php
	
	namespace App\Mail;
	
	use App\ServiceRequest;
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	
	class ServiceRequestQuote extends Mailable
	{
		use Queueable, SerializesModels;
		/**
		 * @var \App\ServiceRequest
		 */
		public $serviceRequest;
		
		/**
		 * Create a new message instance.
		 *
		 * @param \App\ServiceRequest $serviceRequest
		 */
		public function __construct(ServiceRequest $serviceRequest)
		{
			//
			$this->serviceRequest = $serviceRequest;
		}
		
		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			$subject = $this->serviceRequest->type . ' Service Request Quote';
			
			return $this->subject($subject)
				->markdown('emails.services.quote');
		}
	}
