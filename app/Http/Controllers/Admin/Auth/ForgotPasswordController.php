<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\SendResetPasswordOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

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

        $user = User::where('email', $request->email)->firstOrFail();

        $otp = rand(100000, 999999);
        $user->update([
            'email_otp' => $otp,
            'email_otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($user->email)->send(new SendResetPasswordOtpMail($user));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Unable to send OTP email: ' . $e->getMessage()]);
        }

        return redirect()->route('forgot.password.verify', $user->id);
    }

    public function verifyForm($id)
    {
        $user = User::findOrFail($id);
        return view('admin.auth.forgot-password-verify', compact('user'));
    }

    public function verifyOtp(Request $request, $id)
    {
        $request->validate([
            'email_otp' => 'required|digits:6',
        ]);

        $user = User::findOrFail($id);

        if ($user->email_otp != $request->email_otp) {
            return back()->withErrors(['email_otp' => 'Invalid OTP code. Please try again.']);
        }

        if (now()->gt($user->email_otp_expires_at)) {
            return back()->withErrors(['email_otp' => 'OTP has expired. Please request a new one.']);
        }

        // Clear OTP and save user_id in secure session
        $user->update([
            'email_otp' => null,
            'email_otp_expires_at' => null,
        ]);

        session(['reset_user_id' => $user->id]);

        return redirect()->route('forgot.password.reset.form');
    }

    public function resetForm()
    {
        if (!session()->has('reset_user_id')) {
            Alert::error('Error', 'Unauthorized password reset attempt.');
            return redirect()->route('forgot.password');
        }

        return view('admin.auth.reset-password-otp');
    }

    public function resetPassword(Request $request)
    {
        if (!session()->has('reset_user_id')) {
            Alert::error('Error', 'Session expired. Please request a new OTP.');
            return redirect()->route('forgot.password');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::min(4)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        $userId = session('reset_user_id');
        $user = User::findOrFail($userId);
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget('reset_user_id');

        Alert::success('Success', 'Password has been reset successfully. Please login with your new password.');
        return redirect()->route('login');
    }
}
