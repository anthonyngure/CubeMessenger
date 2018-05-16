<?php
	
	namespace App\Notifications;
	
	use App\Bill;
	use App\Utils;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class BillNotification extends Notification implements ShouldQueue
	{
		use Queueable;
		/**
		 * @var \App\Bill
		 */
		private $bill;
		
		/**
		 * Create a new notification instance.
		 *
		 * @param \App\Bill $bill
		 */
		public function __construct(Bill $bill)
		{
			//
			$this->bill = $bill;
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
				->subject('Bill')
				->greeting(Utils::toCurrencyText($this->bill->amount) . ' - ' . $this->bill->status)
				->line($this->bill->description)
				->line('')
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
