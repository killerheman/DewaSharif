<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
            'remember'       => 'accepted',
        ], [
            'remember.accepted' => 'You must check the Remember Me box to proceed.'
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

            // Email Verification Check
            if (!$user->email_verified_at) {

                Auth::logout();

                return redirect()->route('verify.otp', $user->id)
                    ->with('error', 'Please verify your email first');
            }

            $user->update([
                'login_status' => 'online',
            ]);

            Alert::success('Success', 'Login Successfully');

            // Role Based Redirect & Sync
            if ($user->role == 'admin' || $user->hasRole('admin')) {
                if ($user->role != 'admin') {
                    $user->update(['role' => 'admin']);
                }
                if (!$user->hasRole('admin')) {
                    $user->assignRole('admin');
                }
                return redirect()->route('admin.dashboard');
            }

            if ($user->role == 'customer' || $user->hasRole('customer')) {
                if ($user->role != 'customer') {
                    $user->update(['role' => 'customer']);
                }
                if (!$user->hasRole('customer')) {
                    $user->assignRole('customer');
                }
                return redirect()->route('customer.dashboard');
            }

            Auth::logout();

            Alert::error('Error', 'No role assigned to this account.');

            return redirect()->route('admin.login');
        }

        Alert::error('Error', 'Invalid Email/Phone or Password');

        return back()->withInput();
    }
}