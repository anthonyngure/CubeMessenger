<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	
	class ScheduleExecution extends Mailable
	{
		use Queueable, SerializesModels;
		private $message;
		
		/**
		 * Create a new message instance.
		 *
		 * @param $message
		 */
		public function __construct($message)
		{
			//
			$this->message = $message;
		}
		
		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			return $this
				->to(['thinksynergy@thinksynergy.co.ke', 'anthonyngure25@gmail.com'])
				->markdown('emails.schedule_execution', ['message' => $this->message]);
		}
	}
