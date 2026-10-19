<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SiteLockMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('SITE_LOCK_ENABLED', false)) {
            // Check if user is trying to access auth routes
            $isAuthRoute = $request->is('login') || $request->is('register') || 
                           $request->is('login-store') || $request->is('register-store') || 
                           $request->is('auth/google*') || $request->is('admin*') ||
                           $request->is('maintenance');
            
            // If the user is not authenticated and they are not already on an auth route
            if (!Auth::check() && !$isAuthRoute) {
                return redirect()->route('maintenance');
            }
        }

        return $next($request);
    }
}
