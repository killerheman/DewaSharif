<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in to access the Admin Panel.');
        }

        $user = auth()->user();
        $isAdmin = ($user->role ?? 'customer') === 'admin' || (method_exists($user, 'hasRole') && $user->hasRole('admin'));

        if (!$isAdmin) {
            return redirect()->route('admin.login')->with('error', 'Access denied. Admin authorization required.');
        }

        return $next($request);
    }
}