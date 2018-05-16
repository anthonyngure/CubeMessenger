<?php
	
	use Illuminate\Database\Seeder;
	
	class DatabaseSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			
			$this->call(CostVariablesTableSeeder::class);
			$this->call(ClientsTableSeeder::class);
			$this->call(TopUpsTableSeeder::class);
			$this->call(DepartmentsTableSeeder::class);
			$this->call(RolesTableSeeder::class);
			$this->call(UsersTableSeeder::class);
			$this->call(CourierOptionsTableSeeder::class);
			$this->call(SubscriptionOptionsTableSeeder::class);
			$this->call(SubscriptionOptionItemsTableSeeder::class);
			$this->call(ShopCategoriesTableSeeder::class);
			$this->call(ShopProductsTableSeeder::class);
			$this->call(ServiceRequestOptionsTableSeeder::class);
		}
	}
