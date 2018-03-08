<?php
	
	use Illuminate\Database\Seeder;
	
	class SubscriptionSchedulesTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			\App\SubscriptionSchedule::create(['name' => 'Everyday', 'description' => 'Deliver everyday']);
			\App\SubscriptionSchedule::create(['name' => 'Monday', 'description' => 'Deliver on Monday']);
			\App\SubscriptionSchedule::create(['name' => 'Tuesday', 'description' => 'Deliver on Tuesday']);
			\App\SubscriptionSchedule::create(['name' => 'Wednesday', 'description' => 'Deliver on Wednesday']);
			\App\SubscriptionSchedule::create(['name' => 'Thursday', 'description' => 'Deliver on Thursday']);
			\App\SubscriptionSchedule::create(['name' => 'Friday', 'description' => 'Deliver on Friday']);
		}
	}
