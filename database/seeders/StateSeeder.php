<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use JsonMachine\Items;

class StateSeeder extends Seeder
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

                State::updateOrCreate(

                    ['id' => $state->id],

                    [
                        'country_id' => $countryModel->id,
                        'name'       => $state->name,
                    ]

                );

            }

        }
    }
}