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
				'name'  => 'Test Client',
				'logo'  => 'images/client_default.jpg',
				'email' => 'testclient@cube-messenger.com',
				'phone' => '0700000001',
			]);
			
			\App\Client::create([
				'name'  => 'Test Client 2',
				'logo'  => 'images/client_default.jpg',
				'email' => 'testclient2@cube-messenger.com',
				'phone' => '0700000002',
			]);
		}
	}
