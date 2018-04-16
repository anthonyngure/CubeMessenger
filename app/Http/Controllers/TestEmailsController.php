<?php
	
	namespace App\Http\Controllers;
	
	use App\Client;
	use App\Mail\AccountTopUp;
	use App\Mail\Demo;
	use App\Utils;
	use Mail;
	
	class TestEmailsController extends Controller
	{
		//
		
		private $testClient;
		
		/**
		 * EmailTester constructor.
		 */
		public function __construct()
		{
			$this->testClient = Client::where('name', 'Test Client')->firstOrFail();
		}
		
		
		public function topUp()
		{
			Mail::to($this->testClient)->send(new AccountTopUp());
			
			return new AccountTopUp();
		}
		
		public function demo()
		{
			Utils::sendDemoEmail();
			
			return new Demo();
		}
	}
