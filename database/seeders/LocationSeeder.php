<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,

        ]);
    }
}