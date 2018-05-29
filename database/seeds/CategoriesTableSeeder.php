<?php
	
	use Illuminate\Database\Seeder;
	
	class CategoriesTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			
			\App\Category::create([
				'name'  => 'Office Furniture',
				'order' => 5,
			]);
			
			\App\Category::create([
				'name'  => 'Laptops & Desktops',
				'order' => 3,
			]);
			
			\App\Category::create([
				'name'  => 'Computer Accessories',
				'order' => 4,
			]);
			
			\App\Category::create([
				'name'  => 'Electronics',
				'order' => 2,
			]);
			
			\App\Category::create([
				'name'  => 'Office Stationary',
				'order' => 1,
			]);
		}
	}
