<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	
	class TaskScheduleTest extends Mailable
	{
		use Queueable, SerializesModels;
		
		/**
		 * Create a new message instance.
		 *
		 * @return void
		 */
		public function __construct()
		{
			//
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
				->markdown('emails.task_schedule_test');
		}
	}
