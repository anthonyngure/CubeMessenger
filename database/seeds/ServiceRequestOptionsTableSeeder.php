<?php
	
	use Illuminate\Database\Seeder;
	
	class ServiceRequestOptionsTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Computer is slow',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Computer keeps restarting',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Keyboard, mouse, printer or other peripherals aren’t working properly',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Computer not booting',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Frozen screen',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Strange noises',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Slow internet',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Overheating',
			]);
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Downloads take forever',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Computer freezes',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Attachments not opening',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Pop-up ads',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Corrupt files',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Long delays accessing files',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Sudden Shut off',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Computer not turning On',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Applications not installing',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Applications running slowly',
			]);
			
			\App\ServiceRequestOption::create([
				'type'        => 'IT',
				'description' => 'Blue Screen of Death (BSoD)',
			]);
			
		}
	}
