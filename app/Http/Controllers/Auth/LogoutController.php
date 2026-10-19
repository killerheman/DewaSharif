<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LogoutController extends Controller
{
    public function store(Request $request)
    {
        // Login status offline
        if (Auth::check()) {
            $user = Auth::user();
            $user->login_status = 'offline';
            $user->save();
        }

        // Logout
        Auth::logout();

        // Session destroy
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Success', 'Logout Successfully');

        return redirect()->route('maintenance');
    }
}