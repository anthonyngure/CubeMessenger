<?php
	
	use Illuminate\Database\Seeder;
	
	class SubscriptionItemsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			$newspaperSubscriptionType = \App\SubscriptionType::where('name', 'Newspaper')->firstOrFail();
			
			$subscriptionItems = array();
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'Daily Nation', 'item_cost' => 35]));
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'The Standard', 'item_cost' => 35]));
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'The Star', 'item_cost' => 35]));
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'The EastAfrican', 'item_cost' => 35]));
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'Business Daily Africa', 'item_cost' => 35]));
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'Taifa Leo', 'item_cost' => 35]));
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'Kenya Times', 'item_cost' => 35]));
			array_push($subscriptionItems, new \App\SubscriptionItem(['name' => 'Kenya Gazzette', 'item_cost' => 35]));
			
			$newspaperSubscriptionType->subscriptionItems()->saveMany($subscriptionItems);
		}
	}
