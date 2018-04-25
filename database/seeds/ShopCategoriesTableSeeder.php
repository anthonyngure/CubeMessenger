<?php
	
	use Illuminate\Database\Seeder;
	
	class ShopCategoriesTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			
			\App\ShopCategory::create([
				'name'  => 'Office Furniture',
				'order' => 5,
			]);
			
			\App\ShopCategory::create([
				'name'  => 'Laptops & Desktops',
				'order' => 3,
			]);
			
			\App\ShopCategory::create([
				'name'  => 'Computer Accessories',
				'order' => 4,
			]);
			
			\App\ShopCategory::create([
				'name'  => 'Electronics',
				'order' => 2,
			]);
			
			\App\ShopCategory::create([
				'name'  => 'Office Stationary',
				'order' => 1,
			]);
		}
	}
