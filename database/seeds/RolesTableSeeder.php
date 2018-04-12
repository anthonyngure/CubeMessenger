<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    \App\Role::create(['name'=>'RIDER']);
	    \App\Role::create(['name'=>'CLIENT_ADMIN']);
	    \App\Role::create(['name'=>'PURCHASING_HEAD']);
	    \App\Role::create(['name'=>'DEPARTMENT_HEAD']);
	    \App\Role::create(['name'=>'DEPARTMENT_USER']);
    }
}
