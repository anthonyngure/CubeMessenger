<?php
	
	use Illuminate\Database\Seeder;
	
	class SubscriptionOptionsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			\App\SubscriptionOption::create(['name' => 'Newspaper', 'delivery_cost' => 5]);
			\App\SubscriptionOption::create(['name' => 'Milk', 'delivery_cost' => 10]);
			\App\SubscriptionOption::create(['name' => 'Water', 'delivery_cost' => 5]);
		}
	}
