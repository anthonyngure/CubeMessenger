<?php
	
	use Illuminate\Database\Seeder;
	
	class TopUpsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			
			$testClient = \App\Client::where('name', 'Test Client')->firstOrFail();
			$testClient->topUps()->save(new \App\TopUp([
				'amount' => 50000,
			]));
		}
	}
