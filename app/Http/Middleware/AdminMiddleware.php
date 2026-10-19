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
        $isAdmin = false;
        try {
            if (($user->role ?? 'customer') === 'admin') {
                $isAdmin = true;
            } elseif (in_array(strtolower($user->email ?? ''), ['admin@dewa.com', 'admin@dewasharif.com'])) {
                $isAdmin = true;
            } elseif (method_exists($user, 'hasRole') && \Illuminate\Support\Facades\Schema::hasTable('roles')) {
                $isAdmin = $user->hasRole('admin');
            }
        } catch (\Throwable $e) {
            $isAdmin = in_array(strtolower($user->email ?? ''), ['admin@dewa.com', 'admin@dewasharif.com']);
        }

        if (!$isAdmin) {
            return redirect()->route('admin.login')->with('error', 'Access denied. Admin authorization required.');
        }

        return $next($request);
    }
}