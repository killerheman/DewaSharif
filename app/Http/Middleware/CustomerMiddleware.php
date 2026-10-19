<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            session()->put('url.intended', $request->fullUrl());
            return redirect()->route('login')->with('error', 'Please log in or register an account to access your account.');
        }

        return $next($request);
    }
}