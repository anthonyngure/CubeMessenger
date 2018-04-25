<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => __('voyager::seeders.roles.admin'),
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => __('voyager::seeders.roles.user'),
                ])->save();
        }
	
	    $role = Role::firstOrNew(['name' => 'CLIENT_ADMIN']);
	    if (!$role->exists) {
		    $role->fill([
			    'display_name' => 'CLIENT_ADMIN',
		    ])->save();
	    }
	    $role = Role::firstOrNew(['name' => 'PURCHASING_HEAD']);
	    if (!$role->exists) {
		    $role->fill([
			    'display_name' => 'PURCHASING_HEAD',
		    ])->save();
	    }
	
	    $role = Role::firstOrNew(['name' => 'DEPARTMENT_HEAD']);
	    if (!$role->exists) {
		    $role->fill([
			    'display_name' => 'DEPARTMENT_HEAD',
		    ])->save();
	    }
	
	    $role = Role::firstOrNew(['name' => 'DEPARTMENT_USER']);
	    if (!$role->exists) {
		    $role->fill([
			    'display_name' => 'DEPARTMENT_USER',
		    ])->save();
	    }
	
	    $role = Role::firstOrNew(['name' => 'RIDER']);
	    if (!$role->exists) {
		    $role->fill([
			    'display_name' => 'RIDER',
		    ])->save();
	    }
	    
    }
}
