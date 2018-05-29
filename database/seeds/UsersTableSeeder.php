<?php
	
	use App\Role;
	use App\User;
	use Illuminate\Database\Seeder;
	
	class UsersTableSeeder extends Seeder
	{
		/**
		 * Auto generated seed file.
		 *
		 * @return void
		 */
		public function run()
		{
			
			$adminRole = Role::where('name', 'admin')->firstOrFail();
			
			//Admin
			User::create([
				'name'           => 'Administrator',
				'email'          => 'admin@cube-messenger.com',
				'phone'          => '254700000000',
				'password'       => bcrypt('admin2018'),
				'remember_token' => str_random(60),
				'role_id'        => $adminRole->getKey(),
			]);
			
			$testClient = \App\Client::where('name', 'Test Client')->firstOrFail();
			$testDepartment = \App\Department::where('name', 'Test Department')->firstOrFail();
			
			//Test Client Admin
			User::create([
				'client_id'      => $testClient->getKey(),
				'name'           => 'Test Admin',
				'email'          => 'testadmin@cube-messenger.com',
				'role_id'        => Role::where('name', 'CLIENT_ADMIN')->firstOrFail()->getKey(),
				'password'       => bcrypt('testadmin'),
				'remember_token' => str_random(60),
			]);
			
			
			//Test Supplier
			User::create([
				'name'           => 'Test Supplier',
				'email'          => 'testsupplier@cube-messenger.com',
				'role_id'        => Role::where('name', 'SUPPLIER')->firstOrFail()->getKey(),
				'password'       => bcrypt('testsupplier'),
				'remember_token' => str_random(60),
			]);
			
			
			//Test Purchasing Head
			User::create([
				'client_id'      => $testClient->getKey(),
				'name'           => 'Test Purchasing Head',
				'email'          => 'testpurchasinghead@cube-messenger.com',
				'role_id'        => Role::where('name', 'PURCHASING_HEAD')->firstOrFail()->getKey(),
				'password'       => bcrypt('testpurchasinghead'),
				'remember_token' => str_random(60),
			]);
			
			//Test Department Head
			User::create([
				'client_id'      => $testClient->getKey(),
				'department_id'  => $testDepartment->getKey(),
				'name'           => 'Test Department Head',
				'email'          => 'testdepartmenthead@cube-messenger.com',
				'role_id'        => Role::where('name', 'DEPARTMENT_HEAD')->firstOrFail()->getKey(),
				'password'       => bcrypt('testdepartmenthead'),
				'remember_token' => str_random(60),
			]);
			
			//Test Department User
			User::create([
				'client_id'      => $testClient->getKey(),
				'department_id'  => $testDepartment->getKey(),
				'name'           => 'Test Department User',
				'email'          => 'testdepartmentuser@cube-messenger.com',
				'role_id'        => Role::where('name', 'DEPARTMENT_USER')->firstOrFail()->getKey(),
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
				'phone'          => $faker->phoneNumber,
				'password'       => bcrypt('testrider' . $i),
				'role_id'        => Role::where('name', 'RIDER')->firstOrFail()->getKey(),
				'remember_token' => str_random(60),
			]);
		}
		
		
		
	}
