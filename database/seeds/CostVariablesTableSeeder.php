<?php
	
	use Illuminate\Database\Seeder;
	
	class CostVariablesTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			//
			\App\CostVariable::create(['name'  => 'URGENT_COST_PER_KM', 'value' => '3.15',]);
			\App\CostVariable::create(['name'  => 'NON_URGENT_COST_PER_KM', 'value' => '2.00',]);
			\App\CostVariable::create(['name'  => 'ERRAND_COST_PER_KM', 'value' => '3.15',]);
			
			\App\CostVariable::create(['name'  => 'URGENT_COST_PER_MIN', 'value' => '1.5',]);
			\App\CostVariable::create(['name'  => 'NON_URGENT_COST_PER_MIN', 'value' => '1.00',]);
			\App\CostVariable::create(['name'  => 'ERRAND_COST_PER_MIN', 'value' => '3.00',]);
			
			\App\CostVariable::create(['name'  => 'URGENT_BASE_COST', 'value' => '150',]);
			\App\CostVariable::create(['name'  => 'NON_URGENT_BASE_COST', 'value' => '50',]);
			\App\CostVariable::create(['name'  => 'ERRAND_BASE_COST', 'value' => '150',]);
			
			
		}
	}
