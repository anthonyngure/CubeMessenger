<?php
	
	use Illuminate\Database\Seeder;
	
	class RolesTableSeeder extends Seeder
	{
		
		/**
		 * Auto generated seed file
		 *
		 * @return void
		 */
		public function run()
		{
			
			\App\Role::create([
				'name'         => 'ADMIN',
				'display_name' => 'Administrator',
			]);
			
			\App\Role::create([
				'name'         => 'OPERATIONS',
				'display_name' => 'Operations',
			]);
			
			\App\Role::create([
				'name'         => 'SUPPLIER',
				'display_name' => 'Supplier',
			]);
			
			\App\Role::create([
				'name'         => 'CLIENT_ADMIN',
				'display_name' => 'Client Administrator',
			]);
			\App\Role::create([
				'name'         => 'PURCHASING_HEAD',
				'display_name' => 'Purchasing Head',
			]);
			\App\Role::create([
				'name'         => 'DEPARTMENT_HEAD',
				'display_name' => 'Department Head',
			]);
			\App\Role::create([
				'name'         => 'DEPARTMENT_USER',
				'display_name' => 'Department User',
			]);
			\App\Role::create([
				'name'         => 'RIDER',
				'display_name' => 'Rider',
			]);
			
			
		}
	}