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
			
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Highlighter',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Permanent marker (Texta / Sharpie)',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Pencil and pencil sharpener',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Colored pencils',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Colored pens',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Correction tape / fluid / Liquid Paper',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Eraser',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Mechanical pencil and spare leads',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Plain paper (for printer)',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Notebooks, ruled paper, binder books',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Scrapbook, art book',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Ruler',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Glue',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Sticky tape + dispenser',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
			$shopCategory->products()->save(new \App\ShopProduct([
				'name'        => 'Packing tape + dispenser',
				'price'       => 19.99,
				'description' => $dummyDescription,
			]));
			
		}
	}
