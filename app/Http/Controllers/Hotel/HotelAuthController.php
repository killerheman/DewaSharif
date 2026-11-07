<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelPartner;
use App\Helpers\DataStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HotelAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('hotel')->check()) {
            return redirect()->route('hotel.dashboard');
        }
        return view('hotel.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = trim($request->input('login'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Check if login is email or phone
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::guard('hotel')->attempt([$fieldType => $loginInput, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            $partner = Auth::guard('hotel')->user();

            if ($partner->status === 'suspended') {
                Auth::guard('hotel')->logout();
                return back()->with('error', 'Your Hotel Partner account has been suspended by Admin. Please contact DewaSharif Support.');
            }

            return redirect()->intended(route('hotel.dashboard'))->with('success', "Welcome back, {$partner->name}! Logged into Hotel Partner Portal.");
        }

        return back()->withInput($request->only('login', 'remember'))->with('error', 'Invalid email/phone or password credentials.');
    }

    public function showRegisterForm()
    {
        if (Auth::guard('hotel')->check()) {
            return redirect()->route('hotel.dashboard');
        }
        return view('hotel.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'hotel_name' => 'required|string|max:200',
            'phone' => 'required|string|max:20|unique:hotel_partners,phone',
            'email' => 'required|email|max:150|unique:hotel_partners,email',
            'password' => 'required|string|min:6|confirmed',
            'bank_name' => 'nullable|string|max:100',
            'account_no' => 'nullable|string|max:50',
            'account_holder' => 'nullable|string|max:150',
            'ifsc_code' => 'nullable|string|max:20',
            'upi_id' => 'nullable|string|max:100',
        ]);

        // Auto create primary Hotel entry in hotels table & DataStore
        $hotel = Hotel::create([
            'name' => $request->input('hotel_name'),
            'phone' => $request->input('phone'),
            'category' => 'queen_ac',
            'category_name' => 'Queen Size AC',
            'room_type' => 'Deluxe AC Room',
            'ac_type' => 'AC',
            'bed_type' => 'Double Bed',
            'price' => 1499.00,
            'price_per_night' => 1499.00,
            'mrp' => 1999.00,
            'available_rooms' => 5,
            'location' => 'Near Dewa Sharif Dargah',
            'distance' => 'Near Dewa Sharif Dargah',
            'status' => 'active',
            'image' => 'home/images/dewasharif/dewapage/hero_hotel_bg.jpg',
            'image_main' => 'home/images/dewasharif/dewapage/hero_hotel_bg.jpg',
        ]);

        // Also add to DataStore for sync
        DataStore::addItem('hotels', [
            'id' => $hotel->id,
            'name' => $hotel->name,
            'phone' => $hotel->phone,
            'category' => 'queen_ac',
            'room_type' => 'Deluxe AC Room',
            'price' => 1499.00,
            'price_per_night' => 1499.00,
            'available_rooms' => 5,
            'location' => 'Near Dewa Sharif Dargah',
            'status' => 'active',
            'image' => 'home/images/dewasharif/dewapage/hero_hotel_bg.jpg',
        ]);

        $partner = HotelPartner::create([
            'hotel_id' => $hotel->id,
            'name' => $request->input('name'),
            'hotel_name' => $request->input('hotel_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'status' => 'active',
            'bank_name' => $request->input('bank_name'),
            'account_no' => $request->input('account_no'),
            'account_holder' => $request->input('account_holder'),
            'ifsc_code' => $request->input('ifsc_code'),
            'upi_id' => $request->input('upi_id'),
            'commission_rate' => 20.00,
        ]);

        $hotel->update(['partner_id' => $partner->id]);

        Auth::guard('hotel')->login($partner);

        return redirect()->route('hotel.dashboard')->with('success', "Congratulations! Your Hotel Partner account for {$hotel->name} has been successfully registered!");
    }

    public function logout(Request $request)
    {
        Auth::guard('hotel')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('hotel.login')->with('success', 'Logged out of Hotel Partner Portal.');
    }
}
