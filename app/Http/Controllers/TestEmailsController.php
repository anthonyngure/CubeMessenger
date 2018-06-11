<?php
	
	namespace App\Http\Controllers;
	
	use App\Client;
	use App\Mail\AccountTopUp;
	use App\Mail\Demo;
	use App\Mail\ServiceRequestQuote;
	use App\ScheduledTasksManager;
	use App\ServiceRequest;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	
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
			//Mail::to($this->testClient)->send(new AccountTopUp());
			
			return new AccountTopUp();
		}
		
		public function demo()
		{
			//Utils::sendDemoEmail();
			ScheduledTasksManager::sendAppointmentsNotifications();
		}
		
		public function serviceRequestQuote()
		{
			$serviceRequest = ServiceRequest::with(['quote' => function (HasOne $hasOne) {
				$hasOne->with('items');
			}, 'user'                                       => function (BelongsTo $belongsTo) {
				$belongsTo->with('client');
			}])->firstOrFail();
			
			return new ServiceRequestQuote($serviceRequest);
		}
	}
