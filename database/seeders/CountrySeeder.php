<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use JsonMachine\Items;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = Items::fromFile(
            database_path('data/countries-states-cities.json')
        );

       foreach ($countries as $country) {

    Country::updateOrCreate(

        ['id' => $country->id],

        [
            'name' => $country->name,
        ]

    );

}
    }
}