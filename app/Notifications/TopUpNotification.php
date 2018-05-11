<?php
	
	namespace App\Notifications;
	
	use App\TopUp;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class TopUpNotification extends Notification implements ShouldQueue
	{
		use Queueable;
		/**
		 * @var \App\TopUp
		 */
		private $topUp;
		
		/**
		 * Create a new notification instance.
		 *
		 * @param \App\TopUp $topUp
		 */
		public function __construct(TopUp $topUp)
		{
			//
			$this->topUp = $topUp;
		}
		
		/**
		 * Get the notification's delivery channels.
		 *
		 * @param  mixed|\App\Client $notifiable
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
				->subject('Account top up')
				->greeting('Account top up!')
				->line('You account for ' . $notifiable->name .
					' has been topped up with KES ' . number_format($this->topUp->amount, 2))
				->line('New account status is :')
				->line('Actual balance: KES ' . number_format($actual, 2))
				->line('Spending limit: KES ' . number_format($limit, 2))
				->line('Amount settled: KES ' . number_format($spent, 2))
				->line('Amount blocked: KES ' . number_format($blocked, 2))
				->line('The introduction to the notification.')
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
