<?php
	
	namespace App\Notifications;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class PasswordChanged extends Notification  implements ShouldQueue
	{
		use Queueable;
		
		/**
		 * Create a new notification instance.
		 *
		 * @return void
		 */
		public function __construct()
		{
			//
		}
		
		/**
		 * Get the notification's delivery channels.
		 *
		 * @param  mixed|\App\User $notifiable
		 * @return array
		 */
		public function via($notifiable)
		{
			return ['mail', 'database'];
		}
		
		/**
		 * Get the mail representation of the notification.
		 *
		 * @param  mixed $notifiable
		 * @return \Illuminate\Notifications\Messages\MailMessage
		 */
		public function toMail($notifiable)
		{
			return (new MailMessage)
				->greeting('Password changed!')
				->subject('Password changed')
				->line('Your password has been changed successfully. click "Sign In" button below to Sign In')
				->action('Sign In', url('/#/auth/signIn'));
		}
		
		/**
		 * Get the array representation of the notification.
		 *
		 * @param  mixed $notifiable
		 * @return array
		 */
		public function toArray($notifiable)
		{
			return [
				//
			];
		}
	}
