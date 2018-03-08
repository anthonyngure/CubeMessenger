<?php
	
	namespace App\Sms;
	
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 14/01/2017
	 * Time: 03:11
	 */
	
	
	use App\LogHelper;
	use App\VerificationMessage;
	
	class SmsSender
	{
		private $tag = 'SmsSender';
		
		// Specify your login credentials
		private $username = "tosh_ngure";
		private $apikey = "be04e411a0cd23b4238363d7eaeaef75e0a6df96c1711ad14590540d8c2460cb";
		
		// Specify the numbers that you want to send to in a comma-separated list
		// Please ensure you include the country code (+254 for Kenya in this case)
		private $recipients;
		
		/**
		 * SmsSender constructor.
		 * @param $recipients
		 */
		public function __construct($recipients)
		{
			
			$this->recipients = $recipients;
		}
		
		
		public function send($message)
		{
			
			// Create a new instance of our awesome gateway class
			$gateway = new AfricasTalkingGateway($this->username, $this->apikey);
			// Any gateway error will be captured by our custom Exception class below,
			// so wrap the call in a try-catch block
			try {
				// Thats it, hit send and we'll take care of the rest.
				
				$results = $gateway->sendMessage($this->recipients, $message);
				
				foreach ($results as $result) {
					// status is either "Success" or "error message"
					LogHelper::info("Number: " . $result->number, $this->tag);
					LogHelper::info("Status: " . $result->status, $this->tag);
					LogHelper::info("MessageId: " . $result->messageId, $this->tag);
					LogHelper::info("Cost: " . $result->cost . "\n", $this->tag);
					VerificationMessage::create([
						'number'     => $result->number,
						'status'     => $result->status,
						'message_id' => $result->messageId,
						'cost'       => $result->cost,
					]);
				}
				
				return true;
				
			} catch (AfricasTalkingGatewayException $e) {
				//echo "Encountered an error while sending: " . $e->getMessage();
				LogHelper::error($e->getMessage(), 'SmsSender');
				
				return false;
			}
			
		}
		
	}