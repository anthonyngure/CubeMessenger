<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'created_at' => '2018-01-23 12:45:58',
                'updated_at' => '2018-01-23 12:45:58',
            ),
            
            array (
                'id' => 2,
                'name' => 'user',
                'display_name' => 'Normal User',
                'created_at' => '2018-01-23 12:45:58',
                'updated_at' => '2018-01-23 12:45:58',
            ),
        ));
        
        
    }
}