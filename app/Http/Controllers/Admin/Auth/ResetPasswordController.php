<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use RealRashid\SweetAlert\Facades\Alert;

class ResetPasswordController extends Controller
{
    public function index(Request $request, $token)
    {
        return view('admin.auth.resetpassword', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function store(Request $request)
    {
      $request->validate([
    'token' => 'required',
    'email' => 'required|email|exists:users,email',
    'password' => ['required', 'confirmed', PasswordRule::min(4)->letters()->mixedCase()->numbers()->symbols()],
]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {

            Alert::success('Success', 'Password Reset Successfully');

            return redirect()->route('login');
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }
}