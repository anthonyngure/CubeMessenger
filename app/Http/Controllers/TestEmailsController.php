<?php
	
	namespace App\Http\Controllers;
	
	use App\Mail\AccountTopUp;
	use App\Mail\Demo;
	use App\Mail\Password;
	use App\Mail\StructureTest;
	use App\User;
	
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
				'email'         => 'anthonyngure25@gmail.com',
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
			//Mail::to($this->user)->send(new StructureTest());
			
			return new Demo();
		}
	}
