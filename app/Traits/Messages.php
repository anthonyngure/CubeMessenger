<?php
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 12/03/2018
	 * Time: 10:46
	 */
	
	namespace App\Traits;
	
	use App\Utils;
	use GuzzleHttp;
	
	
	trait Messages
	{
		//http://107.20.199.106/api/v3/sendsms/plain?user=CubeCare&password=Rsmry2ve&sender=Cube-Movers&SMSText=text&GSM=254704872214
		
		public function sendSMS($smsText, $number)
		{
			//$message = "I'm a lumberjack and its ok, I sleep all night and I work all day";
			//$number = Utils::normalizePhone("0723203475");
			$url = "http://107.20.199.106/api/v3/sendsms/plain";
			$client = new GuzzleHttp\Client();
			$res = $client->get($url, [
				'query' => [
					'user'     => 'CubeCare',
					'password' => 'Rsmry2ve',
					'sender'   => 'Cube-Movers',
					'SMSText'  => $smsText,
					'GSM'      => Utils::normalizePhone($number),
				],
			]);
			
			return $res->getStatusCode() == 200;
		}
	}