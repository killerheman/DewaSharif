<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendChangePasswordOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

class ChangePasswordController extends Controller
{
    public function index()
    {
        if (request()->routeIs('customer.*')) {
            return view('frontend.customer.change-password');
        }

        return view('admin.auth.changepassword');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'newpassword' => [
                'required',
                'confirmed',
                Password::min(4)->letters()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = Auth::user();

        $otp = rand(100000, 999999);
        $user->update([
            'email_otp' => $otp,
            'email_otp_expires_at' => now()->addMinutes(10),
        ]);

        // Save new password temporarily in session
        session(['change_password_new_hash' => Hash::make($request->newpassword)]);

        try {
            Mail::to($user->email)->send(new SendChangePasswordOtpMail($user));
        } catch (\Exception $e) {
            return back()->withErrors(['newpassword' => 'Unable to send OTP email: ' . $e->getMessage()]);
        }

        return request()->routeIs('customer.*')
            ? redirect()->route('customer.change.password.verify')
            : redirect()->route('admin.change.password.verify');
    }

    public function verifyForm()
    {
        if (!session()->has('change_password_new_hash')) {
            Alert::error('Error', 'Unauthorized attempt.');
            return request()->routeIs('customer.*')
                ? redirect()->route('customer.change.password')
                : redirect()->route('admin.change.password');
        }

        if (request()->routeIs('customer.*')) {
            return view('frontend.customer.change-password-verify');
        }

        return view('admin.auth.change-password-verify');
    }

    public function verifyOtp(Request $request)
    {
        if (!session()->has('change_password_new_hash')) {
            Alert::error('Error', 'Session expired. Please try again.');
            return request()->routeIs('customer.*')
                ? redirect()->route('customer.change.password')
                : redirect()->route('admin.change.password');
        }

        $request->validate([
            'email_otp' => 'required|digits:6',
        ]);

        $user = Auth::user();

        if ($user->email_otp != $request->email_otp) {
            return back()->withErrors(['email_otp' => 'Invalid OTP code. Please try again.']);
        }

        if (now()->gt($user->email_otp_expires_at)) {
            return back()->withErrors(['email_otp' => 'OTP has expired. Please try again.']);
        }

        // Apply new password
        $user->update([
            'password' => session('change_password_new_hash'),
            'email_otp' => null,
            'email_otp_expires_at' => null,
        ]);

        session()->forget('change_password_new_hash');

        Alert::success('Success', 'Password changed successfully!');

        return request()->routeIs('customer.*')
            ? redirect()->route('customer.change.password')
            : redirect()->route('admin.change.password');
    }
}
