<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->get();
        return view('frontend.customer.my-profile', compact('countries'));
    }

    public function edit(string $id)
    {
        $countries = Country::orderBy('name')->get();
        return view('frontend.customer.my-profile', compact('countries'));
    }

    public function update(Request $request, string $id)
    {
        $user = auth()->user();

        $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'company'     => 'nullable|string|max:255',
            'field'       => 'nullable|in:Individual,Company,Organization',
            'country_id'  => 'nullable|exists:countries,id',
            'state_id'    => 'nullable|exists:states,id',
            'city_id'     => 'nullable|exists:cities,id',
            'postal_code' => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:500',
        ]);

        $user->update([
            'name'        => trim($request->first_name . ' ' . $request->last_name),
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'phone'       => $request->phone,
            'company'     => $request->company,
            'field'       => $request->field ?? $user->field,
            'country_id'  => $request->country_id,
            'state_id'    => $request->state_id,
            'city_id'     => $request->city_id,
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
        ]);

        return redirect()->route('customer.my-account.index')->with('success', 'Profile and Address updated successfully.');
    }
}