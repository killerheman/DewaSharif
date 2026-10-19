<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect()
    {
        try {
            if (class_exists('\Laravel\Socialite\Facades\Socialite')) {
                return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
            }
        } catch (\Throwable $e) {}

        return redirect()->route('admin.login')->with('info', 'Google Social Sign-In is configured for Production environment.');
    }

    public function callback()
    {
        try {
            if (class_exists('\Laravel\Socialite\Facades\Socialite')) {
                $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

                $user = User::where('email', $googleUser->email)->first();

                if (!$user) {
                    $user = User::create([
                        'name'     => $googleUser->name,
                        'email'    => $googleUser->email,
                        'password' => bcrypt(Str::random(16)),
                        'role'     => 'customer',
                    ]);
                }

                Auth::login($user);

                if (($user->role ?? 'customer') === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('customer.dashboard');
            }
        } catch (\Throwable $e) {}

        return redirect()->route('admin.login')->with('error', 'Google Auth callback failed.');
    }
}
