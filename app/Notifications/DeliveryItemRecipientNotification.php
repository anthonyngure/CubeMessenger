<?php
	
	namespace App\Notifications;
	
	use App\Channels\SMSChannel;
	use Illuminate\Bus\Queueable;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class DeliveryItemRecipientNotification extends Notification
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
		 * @param  mixed $notifiable
		 * @return array
		 */
		public function via($notifiable)
		{
			return ['database', SMSChannel::class];
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
				->line('The introduction to the notification.')
				->action('Notification Action', url('/'))
				->line('Thank you for using our application!');
		}
		
		/**
		 * Get the mail representation of the notification.
		 *
		 * @param  mixed|\App\DeliveryItem $notifiable
		 * @return string
		 */
		public function toSMS($notifiable)
		{
			//Send sms to the recipient of the item
			$nameToUse = $notifiable->quantity > 1 ? $notifiable->courierOption->plural_name
				: $notifiable->courierOption->name;
			
			return 'Hi ' . $notifiable->recipient_name . ', ' . $notifiable->quantity . ' ' . $nameToUse .
				' from ' . $notifiable->user->client->name . ' will be delivered to you around '
				. $notifiable->estimated_arrival_time . '. Use CODE: ' . $notifiable->received_confirmation_code .
				' to confirm you have received.';
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
