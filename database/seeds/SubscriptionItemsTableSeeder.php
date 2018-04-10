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
			
			$newspaperSubscriptionItems = array();
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'Daily Nation', 'item_cost' => 35]));
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'The Standard', 'item_cost' => 35]));
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'The Star', 'item_cost' => 35]));
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'The EastAfrican', 'item_cost' => 35]));
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'Business Daily Africa', 'item_cost' => 35]));
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'Taifa Leo', 'item_cost' => 35]));
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'Kenya Times', 'item_cost' => 35]));
			array_push($newspaperSubscriptionItems, new \App\SubscriptionItem(['name' => 'Kenya Gazzette', 'item_cost' => 35]));
			
			$newspaperSubscriptionType->subscriptionItems()->saveMany($newspaperSubscriptionItems);
			
			$milkSubscriptionType = \App\SubscriptionType::where('name', 'Milk')->firstOrFail();
			$milkSubscriptionItems = array();
			array_push($milkSubscriptionItems, new \App\SubscriptionItem(['name' => 'Brookside 500 ML', 'item_cost' => 55]));
			array_push($milkSubscriptionItems, new \App\SubscriptionItem(['name' => 'Tuzo 500 ML', 'item_cost' => 55]));
			array_push($milkSubscriptionItems, new \App\SubscriptionItem(['name' => 'Ilara 500 ML', 'item_cost' => 55]));
			array_push($milkSubscriptionItems, new \App\SubscriptionItem(['name' => 'Gold Crown 500 ML', 'item_cost' => 55]));
			array_push($milkSubscriptionItems, new \App\SubscriptionItem(['name' => 'Molo Milk 500 ML', 'item_cost' => 55]));
			
			$milkSubscriptionType->subscriptionItems()->saveMany($milkSubscriptionItems);
		}
	}
