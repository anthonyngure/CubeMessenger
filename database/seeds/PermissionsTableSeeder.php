<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            
            array (
                'id' => 1,
                'key' => 'browse_admin',
                'table_name' => NULL,
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 2,
                'key' => 'browse_database',
                'table_name' => NULL,
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 3,
                'key' => 'browse_media',
                'table_name' => NULL,
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 4,
                'key' => 'browse_compass',
                'table_name' => NULL,
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 5,
                'key' => 'browse_menus',
                'table_name' => 'menus',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 6,
                'key' => 'read_menus',
                'table_name' => 'menus',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 7,
                'key' => 'edit_menus',
                'table_name' => 'menus',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 8,
                'key' => 'add_menus',
                'table_name' => 'menus',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 9,
                'key' => 'delete_menus',
                'table_name' => 'menus',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 10,
                'key' => 'browse_pages',
                'table_name' => 'pages',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 11,
                'key' => 'read_pages',
                'table_name' => 'pages',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 12,
                'key' => 'edit_pages',
                'table_name' => 'pages',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 13,
                'key' => 'add_pages',
                'table_name' => 'pages',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 14,
                'key' => 'delete_pages',
                'table_name' => 'pages',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 15,
                'key' => 'browse_roles',
                'table_name' => 'roles',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 16,
                'key' => 'read_roles',
                'table_name' => 'roles',
                'created_at' => '2018-01-23 12:45:59',
                'updated_at' => '2018-01-23 12:45:59',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 17,
                'key' => 'edit_roles',
                'table_name' => 'roles',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 18,
                'key' => 'add_roles',
                'table_name' => 'roles',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 19,
                'key' => 'delete_roles',
                'table_name' => 'roles',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 20,
                'key' => 'browse_users',
                'table_name' => 'users',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 21,
                'key' => 'read_users',
                'table_name' => 'users',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 22,
                'key' => 'edit_users',
                'table_name' => 'users',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 23,
                'key' => 'add_users',
                'table_name' => 'users',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 24,
                'key' => 'delete_users',
                'table_name' => 'users',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 25,
                'key' => 'browse_posts',
                'table_name' => 'posts',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 26,
                'key' => 'read_posts',
                'table_name' => 'posts',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 27,
                'key' => 'edit_posts',
                'table_name' => 'posts',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 28,
                'key' => 'add_posts',
                'table_name' => 'posts',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 29,
                'key' => 'delete_posts',
                'table_name' => 'posts',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 30,
                'key' => 'browse_categories',
                'table_name' => 'categories',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 31,
                'key' => 'read_categories',
                'table_name' => 'categories',
                'created_at' => '2018-01-23 12:46:00',
                'updated_at' => '2018-01-23 12:46:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 32,
                'key' => 'edit_categories',
                'table_name' => 'categories',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 33,
                'key' => 'add_categories',
                'table_name' => 'categories',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 34,
                'key' => 'delete_categories',
                'table_name' => 'categories',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 35,
                'key' => 'browse_settings',
                'table_name' => 'settings',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 36,
                'key' => 'read_settings',
                'table_name' => 'settings',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 37,
                'key' => 'edit_settings',
                'table_name' => 'settings',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 38,
                'key' => 'add_settings',
                'table_name' => 'settings',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 39,
                'key' => 'delete_settings',
                'table_name' => 'settings',
                'created_at' => '2018-01-23 12:46:01',
                'updated_at' => '2018-01-23 12:46:01',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 40,
                'key' => 'browse_hooks',
                'table_name' => NULL,
                'created_at' => '2018-01-23 12:46:12',
                'updated_at' => '2018-01-23 12:46:12',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 41,
                'key' => 'browse_driver_options',
                'table_name' => 'driver_options',
                'created_at' => '2018-01-23 13:08:00',
                'updated_at' => '2018-01-23 13:08:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 42,
                'key' => 'read_driver_options',
                'table_name' => 'driver_options',
                'created_at' => '2018-01-23 13:08:00',
                'updated_at' => '2018-01-23 13:08:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 43,
                'key' => 'edit_driver_options',
                'table_name' => 'driver_options',
                'created_at' => '2018-01-23 13:08:00',
                'updated_at' => '2018-01-23 13:08:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 44,
                'key' => 'add_driver_options',
                'table_name' => 'driver_options',
                'created_at' => '2018-01-23 13:08:00',
                'updated_at' => '2018-01-23 13:08:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 45,
                'key' => 'delete_driver_options',
                'table_name' => 'driver_options',
                'created_at' => '2018-01-23 13:08:00',
                'updated_at' => '2018-01-23 13:08:00',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 46,
                'key' => 'browse_driver_details',
                'table_name' => 'driver_details',
                'created_at' => '2018-01-23 13:43:43',
                'updated_at' => '2018-01-23 13:43:43',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 47,
                'key' => 'read_driver_details',
                'table_name' => 'driver_details',
                'created_at' => '2018-01-23 13:43:43',
                'updated_at' => '2018-01-23 13:43:43',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 48,
                'key' => 'edit_driver_details',
                'table_name' => 'driver_details',
                'created_at' => '2018-01-23 13:43:43',
                'updated_at' => '2018-01-23 13:43:43',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 49,
                'key' => 'add_driver_details',
                'table_name' => 'driver_details',
                'created_at' => '2018-01-23 13:43:43',
                'updated_at' => '2018-01-23 13:43:43',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 50,
                'key' => 'delete_driver_details',
                'table_name' => 'driver_details',
                'created_at' => '2018-01-23 13:43:44',
                'updated_at' => '2018-01-23 13:43:44',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 51,
                'key' => 'browse_vehicles',
                'table_name' => 'vehicles',
                'created_at' => '2018-01-23 13:54:46',
                'updated_at' => '2018-01-23 13:54:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 52,
                'key' => 'read_vehicles',
                'table_name' => 'vehicles',
                'created_at' => '2018-01-23 13:54:46',
                'updated_at' => '2018-01-23 13:54:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 53,
                'key' => 'edit_vehicles',
                'table_name' => 'vehicles',
                'created_at' => '2018-01-23 13:54:46',
                'updated_at' => '2018-01-23 13:54:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 54,
                'key' => 'add_vehicles',
                'table_name' => 'vehicles',
                'created_at' => '2018-01-23 13:54:46',
                'updated_at' => '2018-01-23 13:54:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 55,
                'key' => 'delete_vehicles',
                'table_name' => 'vehicles',
                'created_at' => '2018-01-23 13:54:46',
                'updated_at' => '2018-01-23 13:54:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 56,
                'key' => 'browse_verification_messages',
                'table_name' => 'verification_messages',
                'created_at' => '2018-01-23 13:58:38',
                'updated_at' => '2018-01-23 13:58:38',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 57,
                'key' => 'read_verification_messages',
                'table_name' => 'verification_messages',
                'created_at' => '2018-01-23 13:58:38',
                'updated_at' => '2018-01-23 13:58:38',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 58,
                'key' => 'edit_verification_messages',
                'table_name' => 'verification_messages',
                'created_at' => '2018-01-23 13:58:38',
                'updated_at' => '2018-01-23 13:58:38',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 59,
                'key' => 'add_verification_messages',
                'table_name' => 'verification_messages',
                'created_at' => '2018-01-23 13:58:38',
                'updated_at' => '2018-01-23 13:58:38',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 60,
                'key' => 'delete_verification_messages',
                'table_name' => 'verification_messages',
                'created_at' => '2018-01-23 13:58:38',
                'updated_at' => '2018-01-23 13:58:38',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 61,
                'key' => 'browse_courier_options',
                'table_name' => 'courier_options',
                'created_at' => '2018-02-14 16:15:27',
                'updated_at' => '2018-02-14 16:15:27',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 62,
                'key' => 'read_courier_options',
                'table_name' => 'courier_options',
                'created_at' => '2018-02-14 16:15:27',
                'updated_at' => '2018-02-14 16:15:27',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 63,
                'key' => 'edit_courier_options',
                'table_name' => 'courier_options',
                'created_at' => '2018-02-14 16:15:27',
                'updated_at' => '2018-02-14 16:15:27',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 64,
                'key' => 'add_courier_options',
                'table_name' => 'courier_options',
                'created_at' => '2018-02-14 16:15:27',
                'updated_at' => '2018-02-14 16:15:27',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 65,
                'key' => 'delete_courier_options',
                'table_name' => 'courier_options',
                'created_at' => '2018-02-14 16:15:27',
                'updated_at' => '2018-02-14 16:15:27',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 66,
                'key' => 'browse_clients',
                'table_name' => 'clients',
                'created_at' => '2018-02-14 16:17:33',
                'updated_at' => '2018-02-14 16:17:33',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 67,
                'key' => 'read_clients',
                'table_name' => 'clients',
                'created_at' => '2018-02-14 16:17:33',
                'updated_at' => '2018-02-14 16:17:33',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 68,
                'key' => 'edit_clients',
                'table_name' => 'clients',
                'created_at' => '2018-02-14 16:17:33',
                'updated_at' => '2018-02-14 16:17:33',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 69,
                'key' => 'add_clients',
                'table_name' => 'clients',
                'created_at' => '2018-02-14 16:17:33',
                'updated_at' => '2018-02-14 16:17:33',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 70,
                'key' => 'delete_clients',
                'table_name' => 'clients',
                'created_at' => '2018-02-14 16:17:33',
                'updated_at' => '2018-02-14 16:17:33',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 71,
                'key' => 'browse_client_subscriptions',
                'table_name' => 'client_subscriptions',
                'created_at' => '2018-03-02 11:43:46',
                'updated_at' => '2018-03-02 11:43:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 72,
                'key' => 'read_client_subscriptions',
                'table_name' => 'client_subscriptions',
                'created_at' => '2018-03-02 11:43:46',
                'updated_at' => '2018-03-02 11:43:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 73,
                'key' => 'edit_client_subscriptions',
                'table_name' => 'client_subscriptions',
                'created_at' => '2018-03-02 11:43:46',
                'updated_at' => '2018-03-02 11:43:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 74,
                'key' => 'add_client_subscriptions',
                'table_name' => 'client_subscriptions',
                'created_at' => '2018-03-02 11:43:46',
                'updated_at' => '2018-03-02 11:43:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 75,
                'key' => 'delete_client_subscriptions',
                'table_name' => 'client_subscriptions',
                'created_at' => '2018-03-02 11:43:46',
                'updated_at' => '2018-03-02 11:43:46',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 76,
                'key' => 'browse_deliveries',
                'table_name' => 'deliveries',
                'created_at' => '2018-03-02 11:51:45',
                'updated_at' => '2018-03-02 11:51:45',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 77,
                'key' => 'read_deliveries',
                'table_name' => 'deliveries',
                'created_at' => '2018-03-02 11:51:45',
                'updated_at' => '2018-03-02 11:51:45',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 78,
                'key' => 'edit_deliveries',
                'table_name' => 'deliveries',
                'created_at' => '2018-03-02 11:51:45',
                'updated_at' => '2018-03-02 11:51:45',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 79,
                'key' => 'add_deliveries',
                'table_name' => 'deliveries',
                'created_at' => '2018-03-02 11:51:45',
                'updated_at' => '2018-03-02 11:51:45',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 80,
                'key' => 'delete_deliveries',
                'table_name' => 'deliveries',
                'created_at' => '2018-03-02 11:51:45',
                'updated_at' => '2018-03-02 11:51:45',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 81,
                'key' => 'browse_subscription_items',
                'table_name' => 'subscription_items',
                'created_at' => '2018-03-05 09:20:40',
                'updated_at' => '2018-03-05 09:20:40',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 82,
                'key' => 'read_subscription_items',
                'table_name' => 'subscription_items',
                'created_at' => '2018-03-05 09:20:40',
                'updated_at' => '2018-03-05 09:20:40',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 83,
                'key' => 'edit_subscription_items',
                'table_name' => 'subscription_items',
                'created_at' => '2018-03-05 09:20:40',
                'updated_at' => '2018-03-05 09:20:40',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 84,
                'key' => 'add_subscription_items',
                'table_name' => 'subscription_items',
                'created_at' => '2018-03-05 09:20:40',
                'updated_at' => '2018-03-05 09:20:40',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 85,
                'key' => 'delete_subscription_items',
                'table_name' => 'subscription_items',
                'created_at' => '2018-03-05 09:20:40',
                'updated_at' => '2018-03-05 09:20:40',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 86,
                'key' => 'browse_subscription_types',
                'table_name' => 'subscription_types',
                'created_at' => '2018-03-05 09:24:20',
                'updated_at' => '2018-03-05 09:24:20',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 87,
                'key' => 'read_subscription_types',
                'table_name' => 'subscription_types',
                'created_at' => '2018-03-05 09:24:20',
                'updated_at' => '2018-03-05 09:24:20',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 88,
                'key' => 'edit_subscription_types',
                'table_name' => 'subscription_types',
                'created_at' => '2018-03-05 09:24:20',
                'updated_at' => '2018-03-05 09:24:20',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 89,
                'key' => 'add_subscription_types',
                'table_name' => 'subscription_types',
                'created_at' => '2018-03-05 09:24:20',
                'updated_at' => '2018-03-05 09:24:20',
                'permission_group_id' => NULL,
            ),
            
            array (
                'id' => 90,
                'key' => 'delete_subscription_types',
                'table_name' => 'subscription_types',
                'created_at' => '2018-03-05 09:24:20',
                'updated_at' => '2018-03-05 09:24:20',
                'permission_group_id' => NULL,
            ),
        ));
        
        
    }
}