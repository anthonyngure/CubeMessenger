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
            'name' => 'Envelope',
            'plural_name' => 'Envelopes',
            'base_cost' => 50.00,
            'icon' => 'icons/envelope.png',
        ]);
        \App\CourierOption::create([
            'name' => 'Box',
            'plural_name' => 'Boxes',
            'base_cost' => 80.00,
            'icon' => 'icons/box.jpg',
        ]);
    }
}
