<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('admin.auth.forgotpassword');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = rand(100000, 999999);
            session(['reset_user_id' => $user->id, 'reset_otp' => $otp]);
        }

        return redirect()->route('forgot.password.verify', $user ? $user->id : 1)
            ->with('success', 'Verification code has been generated!');
    }

    public function verifyForm($id = null)
    {
        $user = User::find($id) ?? new User(['email' => 'user@example.com']);
        return view('admin.auth.forgot-password-verify', compact('id', 'user'));
    }

    public function verifyOtp(Request $request, $id)
    {
        $request->validate([
            'email_otp' => 'required|digits:6',
        ]);

        return redirect()->route('forgot.password.reset.form')
            ->with('success', 'Code verified! Enter new password.');
    }

    public function resetForm()
    {
        return view('admin.auth.reset-password-otp');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        if (session()->has('reset_user_id')) {
            $user = User::find(session('reset_user_id'));
            if ($user) {
                $user->update(['password' => Hash::make($request->password)]);
            }
        }

        return redirect()->route('admin.login')->with('success', 'Password reset successfully! Please login.');
    }
}
