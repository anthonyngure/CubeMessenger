<?php
	
	use Illuminate\Database\Seeder;
	
	class ShopProductsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			
			$shopCategory = \App\ShopCategory::orderBy('order')->firstOrFail();
			$dummyDescription = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
			
			$faker = Faker\Factory::create();
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Highlighter',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Permanent marker (Texta / Sharpie)',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Pencil and pencil sharpener',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Colored pencils',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Colored pens',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Correction tape / fluid / Liquid Paper',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Eraser',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Mechanical pencil and spare leads',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Plain paper (for printer)',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Notebooks, ruled paper, binder books',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Scrapbook, art book',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Ruler',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Glue',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Sticky tape + dispenser',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Packing tape + dispenser',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
		}
	}
