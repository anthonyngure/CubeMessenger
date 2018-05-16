<?php
	
	namespace App\Notifications;
	
	use App\Delivery;
	use App\Utils;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class DeliveryRequestNotification extends Notification implements ShouldQueue
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
			$message = 'A delivery request from ' . $this->delivery->origin_name .
				' was added with ' . $this->delivery->items()->count() .
				' items and a cost of ' . Utils::toCurrencyText($this->delivery->estimated_cost);
			
			return (new MailMessage)
				->subject('Delivery request')
				->greeting('Delivery at ' . Utils::toCurrencyText($this->delivery->estimated_cost))
				->line($message)
				->line('Actual balance: KES ' . number_format($actual, 2))
				->line('Spending limit: KES ' . number_format($limit, 2))
				->line('Amount settled: KES ' . number_format($spent, 2))
				->line('Amount blocked: KES ' . number_format($blocked, 2))
				->action('View your spending', url('/#/dashboard'))
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
