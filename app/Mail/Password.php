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
		 * @param string    $rawPassword
		 */
		public function __construct(User $user, string $rawPassword)
		{
			//
			$this->user = $user;
			$this->rawPassword = $rawPassword;
		}
		
		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			return $this->from('support@cube-messenger.com')
				->markdown('emails.password')
				->with([
					'user'        => $this->user,
					'rawPassword' => $this->rawPassword,
				]);
		}
	}
