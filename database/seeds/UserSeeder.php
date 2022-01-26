<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'name' => 'Admin',
                'email' => 'admin@demo.com',
                'role' => 1,
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Passenger User',
                'email' => 'user@demo.com',
                'role' => 0,
                'password' => bcrypt('password'),
            ],

        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
