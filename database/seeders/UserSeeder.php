<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{

    public function run(): void
    {

        $users = [
            [
                'email' => 'admin@store.com',
                'name' => 'Admin One',
                'password' => bcrypt('password123'),
                'roles' => 'ADMIN',
                'store_name' => 'Store One',
                'categories_id' => 1,
                'store_status' => '1',
                'address_one' => 'Address One',
                'address_two' => 'Address Two',
                'provinces_id' => 32,
                'regencies_id' => 3213,
                'zip_code' => '12345',
                'country' => 'Country',
                'phone_number' => '123456789'
            ],
            [
                'email' => 'user@store.com',
                'name' => 'Customer One',
                'password' => bcrypt('password123'),
                'roles' => 'USER',
                'store_name' => 'Store One',
                'categories_id' => 1,
                'store_status' => '1',
                'address_one' => 'Address One',
                'address_two' => 'Address Two',
                'provinces_id' => 32,
                'regencies_id' => 3214,
                'zip_code' => '12345',
                'country' => 'Country',
                'phone_number' => '123456789'
            ],
            // Add more users as needed
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
