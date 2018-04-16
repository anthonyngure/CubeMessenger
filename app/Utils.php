<?php
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 21/04/2017
	 * Time: 09:47
	 */
	
	namespace App;
	
	
	use App\Mail\Demo;
	use Mail;
	
	class Utils
	{
		
		
		
		/**
		 * @param $phone
		 * @return string
		 */
		public static function normalizePhone($phone)
		{
			if (empty($phone)) {
				return '';
			}
			
			if (strlen($phone) < 9) {
				return '';
			}
			
			return '254' . substr($phone, (strlen($phone) - 9));
		}
		
		public static function sendDemoEmail($context = "Demo Email")
		{
			$testClient = Client::where('name', 'Test Client')->firstOrFail();
			Mail::to($testClient)->send(new Demo($context));
		}
	}