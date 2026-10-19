<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class LocationController extends Controller
{
    public function countries()
    {
        return response()->json(

            Country::orderBy('name')
                ->select('id','name')
                ->get()

        );
    }

    public function states($country)
    {
        return response()->json(

            State::where('country_id',$country)
                ->orderBy('name')
                ->select('id','name')
                ->get()

        );
    }

    public function cities($state)
    {
        return response()->json(

            City::where('state_id',$state)
                ->orderBy('name')
                ->select('id','name')
                ->get()

        );
    }
}