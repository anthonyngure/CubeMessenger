<?php
	
	namespace App\Notifications;
	
	use App\Appointment;
	use App\Channels\SMSChannel;
	use Carbon\Carbon;
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
			//If appointment is in the next 30 minutes, send an sms
			$appointmentStartingAt = Carbon::createFromTimeString($this->appointment->starting_at);
			if ($appointmentStartingAt->between(now(), now()->addMinutes(10))) {
				return ['mail', 'database', SMSChannel::class];
			} else {
				return ['mail', 'database'];
			}
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
		 * Get the mail representation of the notification.
		 *
		 * @param  mixed $notifiable |User
		 * @return string
		 */
		public function toSMS($notifiable)
		{
			return 'Hi ' . $notifiable->name . ' you have a meeting at ' . $this->appointment->venue .
				' Time: ' . $this->appointment->starting_at . ' to ' . $this->appointment->ending_at;
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
