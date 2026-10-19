<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('admin.auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email',
            'phone'      => 'required|max:15|unique:users,phone',
            'address'    => 'nullable|string|max:500',
            'password'   => 'required|min:6|confirmed',
        ]);

        $name = trim($request->first_name . ' ' . $request->last_name);

        $user = User::create([
            'name'       => $name,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'password'   => Hash::make($request->password),
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('customer');
        }

        Auth::login($user);

        return redirect()->intended(route('customer.dashboard'))->with('success', "Welcome to DewaSharif, {$name}! Account created successfully.");
    }
}