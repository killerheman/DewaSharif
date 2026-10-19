<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index()
    {
        return view('frontend.auth.register');
    }

    public function store(Request $request)
    {
        // Remove spaces, hyphens, or any non-numeric characters from the phone number
        if ($request->has('phone')) {
            $request->merge([
                'phone' => preg_replace('/[^0-9]/', '', $request->phone)
            ]);
        }

        // Check if an unverified user exists with this email
        $existingUnverifiedUser = User::where('email', $request->email)
            ->whereNull('email_verified_at')
            ->first();

        if ($existingUnverifiedUser) {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'nullable|string|max:255',
                'field'      => 'required|in:Company,Organization,Individual',
                'phone'      => 'required|digits:10|unique:users,phone,' . $existingUnverifiedUser->id,
                'company'    => 'nullable|string|max:255',
                'address'    => 'nullable|string|max:500',
                'password'   => ['required', 'confirmed', Password::min(4)->letters()->mixedCase()->numbers()->symbols()],
                'terms'      => 'accepted',
            ], [
                'terms.accepted' => 'You must agree to the Terms and Conditions and Privacy Policy before creating an account.',
            ]);

            $emailOtp = rand(100000, 999999);

            $existingUnverifiedUser->update([
                'name'                 => trim($request->first_name . ' ' . $request->last_name),
                'first_name'           => $request->first_name,
                'last_name'            => $request->last_name,
                'field'                => $request->field,
                'phone'                => $request->phone,
                'company'              => $request->company,
                'address'              => $request->address,
                'password'             => Hash::make($request->password),
                'email_otp'            => $emailOtp,
                'email_otp_expires_at' => now()->addMinutes(10),
            ]);

            Mail::to($existingUnverifiedUser->email)->send(new SendOtpMail($existingUnverifiedUser));

            return redirect()->route('verify.otp', $existingUnverifiedUser->id)
                ->with('success', 'A new verification OTP has been sent to your email.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'field'      => 'required|in:Company,Organization,Individual',
            'email'      => 'required|email|max:255|unique:users,email',
            'phone'      => 'required|digits:10|unique:users,phone',
            'company'    => 'nullable|string|max:255',
            'address'    => 'nullable|string|max:500',
            'password'   => ['required', 'confirmed', Password::min(4)->letters()->mixedCase()->numbers()->symbols()],
            'terms'      => 'accepted',
        ], [
            'terms.accepted' => 'You must agree to the Terms and Conditions and Privacy Policy before creating an account.',
        ]);

        $emailOtp = rand(100000, 999999);

        $user = User::create([
            'name'                 => trim($request->first_name . ' ' . $request->last_name),
            'first_name'           => $request->first_name,
            'last_name'            => $request->last_name,
            'field'                => $request->field,
            'email'                => $request->email,
            'phone'                => $request->phone,
            'company'              => $request->company,
            'address'              => $request->address,
            'password'             => Hash::make($request->password),

            // Temporary
            'role'                 => 'customer',

            'email_otp'            => $emailOtp,
            'email_otp_expires_at' => now()->addMinutes(10),
        ]);

        // Assign Customer Role
        $user->assignRole('customer');

        Mail::to($user->email)->send(new SendOtpMail($user));

        return redirect()->route('verify.otp', $user->id)
            ->with('success', 'A verification OTP has been sent to your email.');
    }
}
