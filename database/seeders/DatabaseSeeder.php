<?php

use Database\Seeders\IndoRegionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(IndoRegionSeeder::class);
    }
}
