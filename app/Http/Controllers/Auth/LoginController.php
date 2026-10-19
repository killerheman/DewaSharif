<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required',
            'password'       => 'required|min:4',
        ]);

        $credentials = [
            'password' => $request->password,
        ];

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->email_or_phone;
        } else {
            $credentials['phone'] = $request->email_or_phone;
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (($user->role ?? 'customer') === 'admin' || (method_exists($user, 'hasRole') && $user->hasRole('admin'))) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, Admin!');
            }

            return redirect()->intended(route('customer.dashboard'))->with('success', 'Welcome back!');
        }

        return back()->with('error', 'Invalid Email/Phone or Password!')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}