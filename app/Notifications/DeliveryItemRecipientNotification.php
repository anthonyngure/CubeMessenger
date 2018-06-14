<?php
	
	namespace App\Notifications;
	
	use App\Channels\SMSChannel;
	use App\Delivery;
	use Illuminate\Bus\Queueable;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class DeliveryItemRecipientNotification extends Notification
	{
		use Queueable;
		/**
		 * @var \App\Delivery
		 */
		private $delivery;
		
		/**
		 * Create a new notification instance.
		 *
		 * @param \App\Delivery $delivery
		 */
		public function __construct(Delivery $delivery)
		{
			//
			$this->delivery = $delivery;
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
		 * @param  mixed|\App\DeliveryItem $notifiable
		 * @return string
		 */
		public function toSMS($notifiable)
		{
			//Send sms to the recipient of the item
			$nameToUse = $notifiable->quantity > 1 ? $notifiable->courierOption->plural_name
				: $notifiable->courierOption->name;
			
			return 'Hi ' . $notifiable->recipient_name . ', ' . $notifiable->quantity . ' ' . $nameToUse .
				' from ' . $this->delivery->user->client->name . ' will be delivered to you around '
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
