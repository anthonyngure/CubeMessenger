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
                'created_at' => '2018-04-24 16:18:59',
                'updated_at' => '2018-04-24 16:18:59',
            ),
            
            array (
                'id' => 2,
                'name' => 'user',
                'display_name' => 'Normal User',
                'created_at' => '2018-04-24 16:18:59',
                'updated_at' => '2018-04-24 16:18:59',
            ),
            
            array (
                'id' => 3,
                'name' => 'CLIENT_ADMIN',
                'display_name' => 'CLIENT_ADMIN',
                'created_at' => '2018-04-24 16:18:59',
                'updated_at' => '2018-04-24 16:18:59',
            ),
            
            array (
                'id' => 4,
                'name' => 'PURCHASING_HEAD',
                'display_name' => 'PURCHASING_HEAD',
                'created_at' => '2018-04-24 16:18:59',
                'updated_at' => '2018-04-24 16:18:59',
            ),
            
            array (
                'id' => 5,
                'name' => 'DEPARTMENT_HEAD',
                'display_name' => 'DEPARTMENT_HEAD',
                'created_at' => '2018-04-24 16:18:59',
                'updated_at' => '2018-04-24 16:18:59',
            ),
            
            array (
                'id' => 6,
                'name' => 'DEPARTMENT_USER',
                'display_name' => 'DEPARTMENT_USER',
                'created_at' => '2018-04-24 16:18:59',
                'updated_at' => '2018-04-24 16:18:59',
            ),
            
            array (
                'id' => 7,
                'name' => 'RIDER',
                'display_name' => 'RIDER',
                'created_at' => '2018-04-24 16:18:59',
                'updated_at' => '2018-04-24 16:18:59',
            ),
        ));
        
        
    }
}