<?php
	
	namespace App\Notifications;
	
	use App\User;
	use Illuminate\Bus\Queueable;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class LPONotification extends Notification
	{
		use Queueable;
		/**
		 * @var array
		 */
		private $LPOItems;
		/**
		 * @var \App\User
		 */
		private $supplier;
		
		/**
		 * Create a new notification instance.
		 *
		 * @param array     $LPOItems
		 * @param \App\User $supplier
		 */
		public function __construct(array $LPOItems, User $supplier)
		{
			//
			$this->LPOItems = $LPOItems;
			$this->supplier = $supplier;
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
				->subject('LPO from CubeMessenger')
				->markdown('mail.lpo', ['LPOItems' => $this->LPOItems, 'supplier' => $this->supplier]);
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
