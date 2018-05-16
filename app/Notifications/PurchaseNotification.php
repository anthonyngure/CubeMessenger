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
			$actual = $notifiable->getBalance();
			$limit = $notifiable->limit;
			$spent = $notifiable->getSpent();
			$blocked = $notifiable->getBlocked();
			
			return (new MailMessage)
				->subject('Purchase')
				->greeting('New purchase!')
				->line('A new order for ' . $this->shopOrder->quantity . ' '
					. $this->shopOrder->shopProduct->name . ' has been added.')
				->line('Actual balance: KES ' . number_format($actual, 2))
				->line('Spending limit: KES ' . number_format($limit, 2))
				->line('Amount settled: KES ' . number_format($spent, 2))
				->line('Amount blocked: KES ' . number_format($blocked, 2))
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
