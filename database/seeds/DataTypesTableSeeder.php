<?php

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            
            array (
                'id' => 1,
                'name' => 'posts',
                'slug' => 'posts',
                'display_name_singular' => 'Post',
                'display_name_plural' => 'Posts',
                'icon' => 'voyager-news',
                'model_name' => 'TCG\\Voyager\\Models\\Post',
                'policy_name' => 'TCG\\Voyager\\Policies\\PostPolicy',
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'created_at' => '2018-01-23 12:45:54',
                'updated_at' => '2018-01-23 12:45:54',
            ),
            
            array (
                'id' => 2,
                'name' => 'pages',
                'slug' => 'pages',
                'display_name_singular' => 'Page',
                'display_name_plural' => 'Pages',
                'icon' => 'voyager-file-text',
                'model_name' => 'TCG\\Voyager\\Models\\Page',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'created_at' => '2018-01-23 12:45:54',
                'updated_at' => '2018-01-23 12:45:54',
            ),
            
            array (
                'id' => 3,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-group',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'created_at' => '2018-01-23 12:45:54',
                'updated_at' => '2018-01-24 05:15:36',
            ),
            
            array (
                'id' => 4,
                'name' => 'categories',
                'slug' => 'categories',
                'display_name_singular' => 'Category',
                'display_name_plural' => 'Categories',
                'icon' => 'voyager-categories',
                'model_name' => 'TCG\\Voyager\\Models\\Category',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'created_at' => '2018-01-23 12:45:54',
                'updated_at' => '2018-01-23 12:45:54',
            ),
            
            array (
                'id' => 5,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'created_at' => '2018-01-23 12:45:54',
                'updated_at' => '2018-01-23 12:45:54',
            ),
            
            array (
                'id' => 6,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'created_at' => '2018-01-23 12:45:54',
                'updated_at' => '2018-01-23 12:45:54',
            ),
            
            array (
                'id' => 7,
                'name' => 'driver_options',
                'slug' => 'driver-options',
                'display_name_singular' => 'Driver Option',
                'display_name_plural' => 'Driver Options',
                'icon' => 'voyager-list',
                'model_name' => 'App\\DriverOption',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'created_at' => '2018-01-23 13:07:59',
                'updated_at' => '2018-01-23 13:07:59',
            ),
            
            array (
                'id' => 8,
                'name' => 'driver_details',
                'slug' => 'driver-details',
                'display_name_singular' => 'Driver Detail',
                'display_name_plural' => 'Driver Details',
                'icon' => 'voyager-book',
                'model_name' => 'App\\DriverDetail',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'created_at' => '2018-01-23 13:43:43',
                'updated_at' => '2018-01-23 14:00:59',
            ),
            
            array (
                'id' => 9,
                'name' => 'vehicles',
                'slug' => 'vehicles',
                'display_name_singular' => 'Vehicle',
                'display_name_plural' => 'Vehicles',
                'icon' => 'voyager-params',
                'model_name' => 'App\\Vehicle',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'created_at' => '2018-01-23 13:54:46',
                'updated_at' => '2018-01-23 13:54:46',
            ),
            
            array (
                'id' => 10,
                'name' => 'verification_messages',
                'slug' => 'verification-messages',
                'display_name_singular' => 'Verification Message',
                'display_name_plural' => 'Verification Messages',
                'icon' => 'voyager-chat',
                'model_name' => 'App\\VerificationMessage',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'created_at' => '2018-01-23 13:58:37',
                'updated_at' => '2018-01-23 14:00:05',
            ),
            
            array (
                'id' => 11,
                'name' => 'courier_options',
                'slug' => 'courier-options',
                'display_name_singular' => 'Courier Option',
                'display_name_plural' => 'Courier Options',
                'icon' => NULL,
                'model_name' => 'App\\CourierOption',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'created_at' => '2018-02-14 16:15:27',
                'updated_at' => '2018-02-14 16:15:27',
            ),
            
            array (
                'id' => 12,
                'name' => 'clients',
                'slug' => 'clients',
                'display_name_singular' => 'Client',
                'display_name_plural' => 'Clients',
                'icon' => 'voyager-book',
                'model_name' => 'App\\Client',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'created_at' => '2018-02-14 16:17:33',
                'updated_at' => '2018-02-14 16:17:33',
            ),
        ));
        
        
    }
}