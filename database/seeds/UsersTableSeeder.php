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
			
			$accountTypes = ['CUBE_MESSENGER_USER', 'CUBE_MESSENGER_RIDER', 'CLIENT_PURCHASING_HEAD',
				'CLIENT_DEPARTMENT_HEAD', 'CLIENT_DEPARTMENT_USER', 'CLIENT_USER'];
			
			$adminRole = Role::where('name', 'admin')->firstOrFail();
			$testClient = \App\Client::where('name', 'Test Client')->firstOrFail();
			$testDepartment = \App\Department::where('name', 'Test Department')->firstOrFail();
			
			//Admin
			User::create([
				'name'     => 'Administrator',
				'email'    => 'admin@cube-messenger.com',
				'password' => bcrypt('admin'),
				'role_id'  => $adminRole->getKey(),
			]);
			
			//Test Client Admin
			User::create([
				'client_id'    => $testClient->getKey(),
				'name'         => 'Test Admin',
				'email'        => 'testadmin@cube-messenger.com',
				'account_type' => 'CLIENT_ADMIN',
				'password'     => bcrypt('testadmin'),
			]);
			
			//Test Purchasing Head
			User::create([
				'client_id'    => $testClient->getKey(),
				'name'         => 'Test Purchasing Head',
				'email'        => 'testpurchasinghead@cube-messenger.com',
				'account_type' => 'PURCHASING_HEAD',
				'password'     => bcrypt('testpurchasinghead'),
			]);
			
			//Test Department Head
			User::create([
				'client_id'     => $testClient->getKey(),
				'department_id' => $testDepartment->getKey(),
				'name'          => 'Test Department Head',
				'email'         => 'testdepartmenthead@cube-messenger.com',
				'account_type'  => 'DEPARTMENT_HEAD',
				'password'      => bcrypt('testdepartmenthead'),
			]);
			
			//Test Department User
			User::create([
				'client_id'     => $testClient->getKey(),
				'department_id' => $testDepartment->getKey(),
				'name'          => 'Test Department User',
				'email'         => 'testdepartmentuser@cube-messenger.com',
				'account_type'  => 'DEPARTMENT_USER',
				'password'      => bcrypt('testdepartmentuser'),
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
				'name'         => 'Test Rider ' . $i,
				'email'        => 'testrider' . $i . '@cube-messenger.com',
				'phone'        => $faker->phoneNumber,
				'password'     => bcrypt('testrider' . $i),
				'account_type' => 'CUBE_MESSENGER_RIDER',
				'latitude'     => $location['latitude'],
				'longitude'    => $location['longitude'],
			]);
		}
	}
