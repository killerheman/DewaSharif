<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function getCountries()
    {
        try {
            $countries = DB::table('countries')
                ->select('id', 'name', 'iso2', 'phonecode')
                ->orderBy('name', 'asc')
                ->get();

            if ($countries->isEmpty()) {
                return response()->json(['status' => false, 'data' => []]);
            }

            return response()->json(['status' => true, 'data' => $countries]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getStates(Request $request, $country)
    {
        try {
            $query = DB::table('states');

            if (is_numeric($country)) {
                $query->where('country_id', $country);
            } else {
                $countryObj = DB::table('countries')
                    ->where('name', $country)
                    ->orWhere('iso2', $country)
                    ->first();

                if ($countryObj) {
                    $query->where('country_id', $countryObj->id);
                } else {
                    $query->where('country_name', $country);
                }
            }

            $states = $query->orderBy('name', 'asc')->get();

            return response()->json(['status' => true, 'data' => $states]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getCities(Request $request, $state)
    {
        try {
            $query = DB::table('cities');

            if (is_numeric($state)) {
                $query->where('state_id', $state);
            } else {
                $stateObj = DB::table('states')
                    ->where('name', $state)
                    ->first();

                if ($stateObj) {
                    $query->where('state_id', $stateObj->id);
                } else {
                    $query->where('state_name', $state);
                }
            }

            $cities = $query->orderBy('name', 'asc')->get();

            return response()->json(['status' => true, 'data' => $cities]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
}
