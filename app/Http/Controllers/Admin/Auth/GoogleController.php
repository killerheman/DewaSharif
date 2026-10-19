<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {

            $user = User::create([
                'name'              => $googleUser->name,
                'email'             => $googleUser->email,
                'google_id'         => $googleUser->id,
                'email_verified_at' => now(),
                'password'          => bcrypt(Str::random(16)),

                // Added
                'role'              => 'customer',
            ]);
        } else {

            $user->update([
                'google_id' => $googleUser->id,
            ]);
        }

        Auth::login($user);

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

        if ($user->role != 'customer') {
            $user->update(['role' => 'customer']);
        }
        if (!$user->hasRole('customer')) {
            $user->assignRole('customer');
        }
        return redirect()->route('customer.dashboard');
    }
}
