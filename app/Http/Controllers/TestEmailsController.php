<?php
	
	namespace App\Http\Controllers;
	
	use App\Mail\AccountTopUp;
	use App\Mail\Demo;
	use App\User;
	use App\Utils;
	use Mail;
	
	class TestEmailsController extends Controller
	{
		//
		
		private $user;
		
		/**
		 * EmailTester constructor.
		 */
		public function __construct()
		{
			$password = str_random(5);
			
			$this->user = new User([
				'department_id' => 1,
				'name'          => 'Anthony Ngure',
				'email'         => 'thinksynergy@thinksynergy.co.ke',
				'password'      => bcrypt($password),
				'rawPassword'   => $password,
			]);
		}
		
		
		public function topUp()
		{
			//Mail::to($this->user)->send(new AccountTopUp());
			
			return new AccountTopUp();
		}
		
		public function demo()
		{
			Utils::sendDemoEmail();
			
			return new Demo();
		}
	}
