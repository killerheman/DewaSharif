<?php

namespace App\Http\Controllers\Admin\Auth;

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
        return view('admin.auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'field'      => 'required|in:Company,Organization,Individual',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'required|digits:10|unique:users,phone',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
          'password' => ['required', 'confirmed', Password::min(4)->letters()->mixedCase()->numbers()->symbols()],
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

            // Temporary (baad me remove kar denge)
            'role'                 => 'customer',

            'email_otp'            => $emailOtp,
            'email_otp_expires_at' => now()->addMinutes(10),
        ]);

        // Assign Customer Role
        $user->assignRole('customer');

        Mail::to($user->email)->send(new SendOtpMail($user));

        return redirect()->route('admin.verify.otp', $user->id);
    }
}