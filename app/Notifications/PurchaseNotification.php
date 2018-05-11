<?php
	
	namespace App\Notifications;
	
	use App\ShopOrder;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class PurchaseNotification extends Notification  implements ShouldQueue
	{
		use Queueable;
		/**
		 * @var \App\ShopOrder
		 */
		private $shopOrder;
		
		/**
		 * Create a new notification instance.
		 *
		 * @param \App\ShopOrder $shopOrder
		 */
		public function __construct(ShopOrder $shopOrder)
		{
			//
			$this->shopOrder = $shopOrder;
		}
		
		/**
		 * Get the notification's delivery channels.
		 *
		 * @param  mixed $notifiable
		 * @return array
		 */
		public function via($notifiable)
		{
			return ['mail', 'database'];
		}
		
		/**
		 * Get the mail representation of the notification.
		 *
		 * @param  mixed|\App\Client $notifiable
		 * @return \Illuminate\Notifications\Messages\MailMessage
		 */
		public function toMail($notifiable)
		{
			return (new MailMessage)
				->subject('Purchase')
				->greeting('New purchase!')
				->line('A new order for ' . $this->shopOrder->quantity . ' '
					. $this->shopOrder->shopProduct->name . ' has been added.')
				->line('Click "View Orders" button below to view and track your order')
				->action('View Orders', url('/#/orders'))
				->line('Thank you for using our application!');
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
