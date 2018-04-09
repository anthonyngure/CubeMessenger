<?php
	
	use Illuminate\Database\Seeder;
	
	class CourierOptionsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			
			\App\CourierOption::create([
				'name'        => 'Envelope',
				'plural_name' => 'Envelopes',
				'icon'        => 'courier_options/envelope.png',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
			]);
			\App\CourierOption::create([
				'name'        => 'Box',
				'plural_name' => 'Boxes',
				'icon'        => 'courier_options/box.jpg',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
			]);
			
			\App\CourierOption::create([
				'name'        => 'Errand',
				'plural_name' => 'Errands',
				'icon'        => 'courier_options/errand.gif',
				'active'      => false,
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
			]);
		}
	}
