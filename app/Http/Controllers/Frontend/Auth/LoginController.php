<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('frontend.auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required',
            'password'       => 'required|min:4',
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

            // Handle pending plan order from session if user clicked Buy Now before logging in
            if (session()->has('pending_plan_id')) {
                $planId = session('pending_plan_id');
                $hostingId = session('pending_hosting_id');
                session()->forget(['pending_plan_id', 'pending_hosting_id']);

                $plan = \App\Models\Plan::find($planId);
                if ($plan) {
                    $hostingName = 'Hosting Plan';
                    if ($hostingId) {
                        $hostingObj = \App\Models\Hosting::find($hostingId) ?? \App\Models\Server::find($hostingId);
                        if ($hostingObj) {
                            $hostingName = $hostingObj->name;
                        }
                    }
                    \App\Models\HostingOrder::firstOrCreate([
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'status'  => 'pending',
                    ], [
                        'hosting_id'   => $hostingId ?? $plan->common_id,
                        'plan_name'    => $plan->name,
                        'hosting_name' => $hostingName,
                        'price'        => $plan->price,
                        'period'       => $plan->period ?? 'monthly',
                        'status'       => 'pending',
                    ]);
                }
                return redirect()->route('cart')->with('success', 'Plan added to cart successfully!');
            }

            if (session()->has('pending_email_order')) {
                $eData = session('pending_email_order');
                session()->forget('pending_email_order');

                \App\Models\EmailOrder::firstOrCreate([
                    'user_id'   => $user->id,
                    'provider'  => $eData['provider'],
                    'plan_name' => $eData['plan_name'],
                    'status'    => 'pending',
                ], [
                    'desired_email' => $eData['desired_email'],
                    'domain_name'   => $eData['domain_name'],
                    'price'         => $eData['price'],
                    'period'        => $eData['period'],
                    'status'        => 'pending',
                ]);

                return redirect()->route('cart')->with('success', 'Email plan added to cart successfully!');
            }

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
            return redirect()->route('login');
        }

        Alert::error('Error', 'Invalid Email/Phone or Password');
        return back()->withInput();
    }
}
