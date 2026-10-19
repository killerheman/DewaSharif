<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Show a server page dynamically by slug, with plans & FAQs from DB.
     */
    public function show($slug)
    {
        $server = Server::with([
            'plans' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
            'faqs'  => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
        ])->where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Sidebar ke liye data controller se fetch karein (Safe & Clean)
        $allServers = Server::where('is_active', true)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->orderBy('sort_order')
            ->get();

        return view('frontend.server.show', compact('server', 'allServers'));
    }

    // Legacy static routes kept for backward compatibility
    public function vpsServer()
    {
        $server = Server::with([
            'plans' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
            'faqs'  => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
        ])->where('is_active', true)
          ->where(function ($q) {
              $q->where('slug', 'like', '%vps%')
                ->orWhere('name', 'like', '%vps%');
          })
          ->orderBy('sort_order')
          ->first();

        if ($server) {
            $allServers = Server::where('is_active', true)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->orderBy('sort_order')
                ->get();

            return view('frontend.server.show', compact('server', 'allServers'));
        }

        return view('frontend.server.vps-server', compact('server'));
    }

    public function dedicatedServer()
    {
        $dedicatedServers = Server::where('is_active', true)
            ->where('slug', 'like', 'dedicated-server-in-%')
            ->orderBy('sort_order')
            ->get();

        return view('frontend.server.dedicated-server', compact('dedicatedServers'));
    }
}