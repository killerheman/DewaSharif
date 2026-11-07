<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HotelPartnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('hotel')->check()) {
            session()->put('hotel_intended', $request->fullUrl());
            return redirect()->route('hotel.login')->with('error', 'Please log in to access your Hotel Partner Dashboard.');
        }

        $partner = auth('hotel')->user();

        if ($partner->status === 'suspended') {
            auth('hotel')->logout();
            return redirect()->route('hotel.login')->with('error', 'Your Hotel Partner account has been suspended by Admin. Please contact DewaSharif support.');
        }

        if ($partner->status === 'pending_approval') {
            return response()->view('hotel.auth.pending_approval', compact('partner'), 403);
        }

        return $next($request);
    }
}
