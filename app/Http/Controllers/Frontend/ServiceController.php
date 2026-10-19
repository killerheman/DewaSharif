<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function businessMail()
    {
        $emailServices = \App\Models\EmailService::where('is_active', true)
            ->with('plans')
            ->orderBy('sort_order', 'asc')
            ->get();
        return view('frontend.services.business-mail', compact('emailServices'));
    }

    public function serverManagement()
    {
        return view('frontend.services.server-management');
    }

    public function dedicatedSupport()
    {
        return view('frontend.services.dedicated-support');
    }

    public function cyberSecurity()
    {
        return view('frontend.services.cyber-security');
    }

    public function dedicatedServicesServer()
    {
        return view('frontend.services.dedicated-services-server');
    }

    public function websiteMigration()
    {
        return view('frontend.services.website-migration');
    }
}
