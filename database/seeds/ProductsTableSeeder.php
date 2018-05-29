<?php
	
	use Illuminate\Database\Seeder;
	
	class ProductsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			
			$shopCategory = \App\Category::orderBy('order')->firstOrFail();
			$dummyDescription = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
			
			$faker = Faker\Factory::create();
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Highlighter',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Permanent marker (Texta / Sharpie)',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Pencil and pencil sharpener',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Colored pencils',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Colored pens',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Correction tape / fluid / Liquid Paper',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Eraser',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Mechanical pencil and spare leads',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Plain paper (for printer)',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Notebooks, ruled paper, binder books',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Scrapbook, art book',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Ruler',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Glue',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Sticky tape + dispenser',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\Product([
				'name'        => 'Packing tape + dispenser',
				'price'       => $faker->randomFloat(2, 20, 200),
				'description' => $dummyDescription,
			]));
			
		}
	}
