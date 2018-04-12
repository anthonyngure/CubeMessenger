<?php
	
	use Illuminate\Database\Seeder;
	
	class SubscriptionOptionItemsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			$newspaperSubscriptionOption = \App\SubscriptionOption::where('name', 'Newspaper')->firstOrFail();
			
			$newspaperSubscriptionOptionItems = array();
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Daily Nation', 'price' => 65]));
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'The Standard', 'price' => 65]));
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'The Star', 'price' => 65]));
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'The EastAfrican', 'price' => 65]));
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Business Daily Africa', 'price' => 65]));
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Taifa Leo', 'price' => 65]));
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Kenya Times', 'price' => 65]));
			array_push($newspaperSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Kenya Gazzette', 'price' => 65]));
			
			$newspaperSubscriptionOption->items()->saveMany($newspaperSubscriptionOptionItems);
			
			$milkSubscriptionOption = \App\SubscriptionOption::where('name', 'Milk')->firstOrFail();
			$milkSubscriptionOptionItems = array();
			array_push($milkSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Brookside 500 ML', 'price' => 55]));
			array_push($milkSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Tuzo 500 ML', 'price' => 55]));
			array_push($milkSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Ilara 500 ML', 'price' => 55]));
			array_push($milkSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Gold Crown 500 ML', 'price' => 55]));
			array_push($milkSubscriptionOptionItems, new \App\SubscriptionOptionItem(['name' => 'Molo Milk 500 ML', 'price' => 55]));
			
			$milkSubscriptionOption->items()->saveMany($milkSubscriptionOptionItems);
		}
	}
