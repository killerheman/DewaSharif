<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OtpVerificationController extends Controller
{
    public function index(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->is('admin/*') || $user->role === 'admin' || $user->hasRole('admin')) {
            return view('admin.auth.verify-otp', compact('user'));
        }

        return view('frontend.auth.verify-otp', compact('user'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'email_otp' => 'required|digits:6',
        ]);

        $user = User::findOrFail($id);

        if ($user->email_otp != $request->email_otp) {
            Alert::error('Error', 'Invalid OTP');
            return back()->with('error', 'Invalid OTP code. Please enter the correct 6-digit code.');
        }

        if ($user->email_otp_expires_at && now()->gt($user->email_otp_expires_at)) {
            Alert::error('Error', 'OTP expired, please request a new OTP');
            return back()->with('error', 'OTP has expired. Please click Resend OTP below to get a new code.');
        }

        $user->update([
            'email_verified_at' => now(),
            'email_otp' => null,
            'email_otp_expires_at' => null,
        ]);

        Alert::success('Success', 'Email verified successfully');

        if ($request->is('admin/*') || $user->role === 'admin' || $user->hasRole('admin')) {
            return redirect()->route('admin.login')->with('success', 'Email verified successfully. You can now login.');
        }

        return redirect()->route('login')->with('success', 'Email verified successfully. You can now sign in.');
    }

    public function resend(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $emailOtp = rand(100000, 999999);
        $user->update([
            'email_otp' => $emailOtp,
            'email_otp_expires_at' => now()->addMinutes(10),
        ]);

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($user));

        Alert::success('Success', 'Verification OTP has been resent to your email.');
        return back()->with('success', 'A fresh verification OTP has been sent to ' . $user->email);
    }
}