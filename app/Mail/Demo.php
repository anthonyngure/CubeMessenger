<?php
	
	namespace App\Mail;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	
	class Demo extends Mailable
	{
		use Queueable, SerializesModels;
		/**
		 * @var string
		 */
		private $context;
		
		/**
		 * Create a new message instance.
		 *
		 * @param string $context
		 */
		public function __construct(string $context = 'Demo Email')
		{
			//
			$this->context = $context;
		}
		
		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			return $this->markdown('emails.demo')->with(['context' => $this->context]);
		}
	}
