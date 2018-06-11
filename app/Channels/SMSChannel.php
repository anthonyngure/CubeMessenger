<?php
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 21/05/2018
	 * Time: 18:35
	 */
	
	namespace App\Channels;
	
	
	use App\Utils;
	use Illuminate\Notifications\Notification;
	use Log;
	use GuzzleHttp;
	
	class SMSChannel
	{
		/**
		 * Send the given notification.
		 *
		 * @param  mixed | \App\User                      $notifiable
		 * @param  \Illuminate\Notifications\Notification $notification
		 * @return void
		 */
		public function send($notifiable, Notification $notification)
		{
			
			$text = $notification->toSMS($notifiable);
			
			$recipient = $notifiable->routeNotificationForSMSChannel();
			
			$url = "http://107.20.199.106/api/v3/sendsms/plain";
			$client = new GuzzleHttp\Client();
			$res = $client->get($url, [
				'query' => [
					'user'     => 'CubeCare',
					'password' => 'Rsmry2ve',
					'sender'   => 'Cube-Movers',
					'SMSText'  => $text,
					'GSM'      => Utils::normalizePhone($recipient),
				],
			]);
		}
	}