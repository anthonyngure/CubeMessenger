<?php
	
	use Illuminate\Database\Seeder;
	
	class DepartmentsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			$testClient = \App\Client::where('name', 'Test Client')->firstOrFail();
			$testClient->departments()->save(new \App\Department([
				'name' => 'Test Department',
			]));
		}
	}
