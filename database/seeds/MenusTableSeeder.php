<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            
            array (
                'id' => 1,
                'name' => 'admin',
                'created_at' => '2018-01-23 12:45:57',
                'updated_at' => '2018-01-23 12:45:57',
            ),
        ));
        
        
    }
}