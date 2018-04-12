<?php
	
	namespace App\Mail;
	
	use App\User;
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	
	class Password extends Mailable
	{
		use Queueable, SerializesModels;
		/**
		 * @var \App\User
		 */
		private $user;
		/**
		 * @var string
		 */
		private $rawPassword;
		
		/**
		 * Create a new message instance.
		 *
		 * @param \App\User $user
		 */
		public function __construct(User $user)
		{
			//
			$this->user = $user;
		}
		
		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			return $this->subject('Cube Messenger Password')
				->markdown('emails.password');
		}
	}
