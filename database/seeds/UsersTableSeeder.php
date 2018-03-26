<?php
	
	use App\User;
	use Illuminate\Database\Seeder;
	use TCG\Voyager\Models\Role;
	
	class UsersTableSeeder extends Seeder
	{
		/**
		 * Auto generated seed file.
		 *
		 * @return void
		 */
		public function run()
		{
			
			$accountTypes = ['CUBE_MESSENGER_USER', 'CUBE_MESSENGER_RIDER', 'CLIENT_ADMIN',
				'CLIENT_PURCHASING_HEAD', 'CLIENT_DEPARTMENT_HEAD', 'CLIENT_DEPARTMENT_USER', 'CLIENT_USER'];
			
			$adminRole = Role::where('name', 'admin')->firstOrFail();
			$testClient = \App\Client::where('name', 'Test Client')->firstOrFail();
			
			//Admin
			User::create([
				'name'           => 'Administrator',
				'email'          => 'admin@cube-messenger.com',
				'email_verified' => 1,
				'password'       => bcrypt('admin'),
				'remember_token' => str_random(60),
				'role_id'        => $adminRole->getKey(),
			]);
			
			//Test Client Admin
			User::create([
				'client_id'      => $testClient->getKey(),
				'name'           => 'Test Admin',
				'email'          => 'testadmin@cube-messenger.com',
				'email_verified' => 1,
				'account_type'   => 'CLIENT_ADMIN',
				'password'       => bcrypt('testadmin'),
				'remember_token' => str_random(60),
			]);
			
			//Test Purchasing Head
			User::create([
				'client_id'      => $testClient->getKey(),
				'name'           => 'Test Purchasing Head',
				'email'          => 'testpurchasinghead@cube-messenger.com',
				'email_verified' => 1,
				'account_type'   => 'CLIENT_PURCHASING_HEAD',
				'password'       => bcrypt('testpurchasinghead'),
				'remember_token' => str_random(60),
			]);
			
			//Test Department Head
			User::create([
				'client_id'      => $testClient->getKey(),
				'name'           => 'Test Department Head',
				'email'          => 'testdepartmenthead@cube-messenger.com',
				'email_verified' => 1,
				'account_type'   => 'CLIENT_DEPARTMENT_HEAD',
				'password'       => bcrypt('testdepartmenthead'),
				'remember_token' => str_random(60),
			]);
			
			//Test Department User
			User::create([
				'client_id'      => $testClient->getKey(),
				'name'           => 'Test Department User',
				'email'          => 'testdepartmentuser@cube-messenger.com',
				'email_verified' => 1,
				'account_type'   => 'CLIENT_DEPARTMENT_USER',
				'password'       => bcrypt('testdepartmentuser'),
				'remember_token' => str_random(60),
			]);
			
			$faker = Faker\Factory::create();
			$this->addRider($faker);
			//Add dummy riders
			for ($i = 1; $i < 5; $i++) {
				//A radius of 50km with center = Think Synergy
				$this->addRider($faker, $i);
			}
			
		}
		
		private function addRider($faker, $i = '')
		{
			$location = \App\Geo::generateRandomPoint(-1.33113, 36.88117, 50);
			\App\User::create([
				'name'           => 'Test Rider ' . $i,
				'email'          => 'testrider' . $i . '@cube-messenger.com',
				'email_verified' => 1,
				'phone'          => $faker->phoneNumber,
				'phone_verified' => 1,
				'password'       => bcrypt('testrider' . $i),
				'remember_token' => str_random(60),
				'account_type'   => 'CUBE_MESSENGER_RIDER',
				'latitude'       => $location['latitude'],
				'longitude'      => $location['longitude'],
			]);
		}
	}
