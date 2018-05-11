<?php
	
	namespace App\Notifications;
	
	use App\ShopOrder;
	use App\User;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class PurchaseRejectedNotification extends Notification implements ShouldQueue
	{
		use Queueable;
		private $userWhoShouldApprove;
		/**
		 * @var \App\ShopOrder
		 */
		private $shopOrder;
		
		/**
		 * Create a new notification instance.
		 *
		 * @param \App\ShopOrder $shopOrder
		 * @param \App\User      $userWhoShouldApprove
		 */
		public function __construct(ShopOrder $shopOrder, User $userWhoShouldApprove)
		{
			//
			$this->userWhoShouldApprove = $userWhoShouldApprove;
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
		 * @param  mixed $notifiable
		 * @return \Illuminate\Notifications\Messages\MailMessage
		 */
		public function toMail($notifiable)
		{
			return (new MailMessage)
				->subject('Purchase rejected')
				->greeting('Purchase rejected!')
				->line('Your purchase for ' . $this->shopOrder->quantity . ' '
					. $this->shopOrder->shopProduct->name . ' has been rejected by ' . $this->userWhoShouldApprove->role->name)
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
