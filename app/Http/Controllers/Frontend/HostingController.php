<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Hosting;
use Illuminate\Http\Request;

class HostingController extends Controller
{
    /**
     * Show a hosting category page by its slug, dynamically loading plans from DB.
     */
    public function show($slug)
    {
        $hosting = Hosting::with([
            'plans' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
            'faqs'  => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
        ])->where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('frontend.hosting.show', compact('hosting'));
    }

    /**
     * List all active hosting categories.
     */
    public function list()
    {
        $hostings = Hosting::with(['plans' => function ($q) {
            $q->where('is_active', true)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();

        return view('frontend.hosting.list', compact('hostings'));
    }

    // Legacy named methods - fetch matching hosting model if available
    public function sharedWebHosting()
    {
        $hosting = Hosting::where('slug', 'shared-web-hosting')->orWhere('name', 'like', '%shared%')->first();
        return view('frontend.hosting.shared-web-hosting', compact('hosting'));
    }

    public function cpanelHosting()
    {
        $hosting = Hosting::where('slug', 'cpanel-hosting')->orWhere('name', 'like', '%cpanel%')->first();
        return view('frontend.hosting.cpanel-hosting', compact('hosting'));
    }

    public function crmHosting()
    {
        $hosting = Hosting::where('slug', 'crm-hosting')->orWhere('name', 'like', '%crm%')->first();
        return view('frontend.hosting.crm-hosting', compact('hosting'));
    }

    public function pleskHosting()
    {
        $hosting = Hosting::where('slug', 'plesk-hosting')->orWhere('name', 'like', '%plesk%')->first();
        return view('frontend.hosting.plesk-hosting', compact('hosting'));
    }

    public function cloudHosting()
    {
        $hosting = Hosting::where('slug', 'cloud-hosting')->orWhere('name', 'like', '%cloud%')->first();
        return view('frontend.hosting.cloud-hosting', compact('hosting'));
    }

    public function wordpressHosting()
    {
        $hosting = Hosting::where('slug', 'wordpress-hosting')->orWhere('name', 'like', '%wordpress%')->first();
        return view('frontend.hosting.wordpress-hosting', compact('hosting'));
    }

    public function woocommerceHosting()
    {
        $hosting = Hosting::where('slug', 'woocommerce-hosting')->orWhere('name', 'like', '%woocommerce%')->first();
        return view('frontend.hosting.woocommerce-hosting', compact('hosting'));
    }
}
