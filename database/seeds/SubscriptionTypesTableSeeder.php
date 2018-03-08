<?php
	
	use Illuminate\Database\Seeder;
	
	class SubscriptionTypesTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			\App\SubscriptionType::create(['name' => 'Newspaper', 'delivery_base_cost' => 10]);
			\App\SubscriptionType::create(['name' => 'Milk', 'delivery_base_cost' => 5]);
		}
	}
