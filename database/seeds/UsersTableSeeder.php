<?php

use App\User;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $testClient = \App\Client::where('name', 'Test Client')->firstOrFail();
        //Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@cube-messenger.com',
            'email_verified' => 1,
            'password' => bcrypt('admin'),
            'remember_token' => str_random(60),
            'role_id' => $adminRole->getKey(),
        ]);

        //My self as user
        User::create([
            'client_id' => $testClient->getKey(),
            'name' => 'Test User',
            'email' => 'testuser@cube-messenger.com',
            'email_verified' => 1,
            'phone' => '254723203475',
            'phone_verified' => 1,
            'password' => bcrypt('testuser'),
            'remember_token' => str_random(60),
        ]);

        $faker = Faker\Factory::create();
        $this->addRider($faker);
        //Add dummy riders
        for ($i = 1; $i < 5; $i++) {
            //A radius of 50km with center = Think Synergy
            $this->addRider($faker, $i);
        }

    }

    private function addRider($faker, $i = '')
    {
        $location = \App\Geo::generateRandomPoint(-1.33113, 36.88117, 50);
        \App\User::create([
            'name' => 'Test Rider ' . $i,
            'email' => 'testrider' . $i . '@cube-messenger.com',
            'email_verified' => 1,
            'phone' => $faker->phoneNumber,
            'phone_verified' => 1,
            'password' => bcrypt('testrider' . $i),
            'remember_token' => str_random(60),
            'account_type' => 'RIDER',
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
        ]);
    }
}
