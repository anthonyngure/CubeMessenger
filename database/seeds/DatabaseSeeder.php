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
			//Commands to run before db refresh
			//php artisan iseed categories,data_types,data_rows,menus,menu_items,pages,roles,permissions,permission_groups,permission_role,posts,settings,translations --force --noindex
			//php artisan voyager:admin anthonyngure25@gmail.com
			
			/*Seeders for admin tables will be here*/
			
			$this->call(CategoriesTableSeeder::class);
			$this->call(DataTypesTableSeeder::class);
			$this->call(DataRowsTableSeeder::class);
			$this->call(MenusTableSeeder::class);
			$this->call(MenuItemsTableSeeder::class);
			$this->call(PagesTableSeeder::class);
			$this->call(RolesTableSeeder::class);
			$this->call(PermissionsTableSeeder::class);
			$this->call(PermissionGroupsTableSeeder::class);
			$this->call(PermissionRoleTableSeeder::class);
			$this->call(PostsTableSeeder::class);
			$this->call(SettingsTableSeeder::class);
			$this->call(TranslationsTableSeeder::class);
			
			$this->call(ClientsTableSeeder::class);
			$this->call(DepartmentsTableSeeder::class);
			$this->call(UsersTableSeeder::class);
			$this->call(CourierOptionsTableSeeder::class);
			$this->call(SubscriptionTypesTableSeeder::class);
			$this->call(SubscriptionSchedulesTableSeeder::class);
			$this->call(SubscriptionItemsTableSeeder::class);
			$this->call(ShopCategoriesTableSeeder::class);
			$this->call(ShopProductsTableSeeder::class);
			$this->call(ServiceRequestOptionsTableSeeder::class);
			
		}
	}
