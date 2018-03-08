<?php
	
	use Illuminate\Database\Seeder;
	
	class ClientsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			\App\Client::create([
				'name'          => 'Test Client',
				'logo'          => 'clients/default.jpg',
				'email'         => 'testclient@cubemessenger.com',
				'phone'         => '0723203475',
				'latitude'      => -1.33113,
				'longitude'     => 36.88117,
				'primary_color' => '#4CAF50',
				'accent_color'  => '#FF4081',
			]);
		}
	}
