<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Database\Seeder;
use JsonMachine\Items;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $countries = Items::fromFile(database_path('data/countries-states-cities.json'));

        foreach ($countries as $country) {

            $countryModel = Country::find($country->id);

            if (!$countryModel || empty($country->states)) {
                continue;
            }

            foreach ($country->states as $state) {

                $stateModel = State::find($state->id);

                if (!$stateModel || empty($state->cities)) {
                    continue;
                }

                foreach ($state->cities as $city) {

                    City::updateOrCreate(

                        ['id' => $city->id],

                        [
                            'state_id' => $stateModel->id,
                            'name'     => $city->name,
                        ]

                    );

                }

            }

        }
    }
}