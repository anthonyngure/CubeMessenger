<?php
	
	namespace App\Notifications;
	
	use App\Appointment;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\MailMessage;
	use Illuminate\Notifications\Notification;
	
	class AppointmentNotification extends Notification implements ShouldQueue
	{
		use Queueable;
		/**
		 * @var \App\Appointment
		 */
		private $appointment;
		
		/**
		 * Create a new notification instance.
		 *
		 * @param \App\Appointment $appointment
		 */
		public function __construct(Appointment $appointment)
		{
			//
			$this->appointment = $appointment;
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
				->subject('Appointment|Meeting : ' . $this->appointment->title)
				->markdown('mail.appointment', ['appointment' => $this->appointment, 'participant' => $notifiable]);
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
