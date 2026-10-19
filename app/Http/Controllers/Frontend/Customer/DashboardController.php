<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user ? $user->id : 0;

        $expiringDomains = collect();
        $hostingCount = 0;
        $domainCount = 0;
        $emailCount = 0;
        $invoiceCount = 0;

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('domain_orders')) {
                $expiringDomains = \App\Models\DomainOrder::where('user_id', $userId)
                    ->where('status', 'registered')
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '>=', now()->toDateString())
                    ->where('expires_at', '<=', now()->addDays(30)->toDateString())
                    ->get();

                $domainCount = \App\Models\DomainOrder::where('user_id', $userId)
                    ->whereIn('status', ['registered', 'active', 'processing', 'renewed', 'completed'])
                    ->count();
            }
        } catch (\Throwable $e) {}

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hosting_orders')) {
                $hostingCount = \App\Models\HostingOrder::where('user_id', $userId)
                    ->whereIn('status', ['active', 'processing', 'renewed', 'completed', 'paid'])
                    ->count();
            }
        } catch (\Throwable $e) {}

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('business_emails')) {
                $emailCount = \App\Models\BusinessEmail::where('user_id', $userId)->count();
            }
        } catch (\Throwable $e) {}

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('invoices')) {
                $invoiceCount = \App\Models\Invoice::where('user_id', $userId)->count();
            }
        } catch (\Throwable $e) {}

        return view('frontend.customer.dashboard', compact(
            'expiringDomains',
            'hostingCount',
            'domainCount',
            'emailCount',
            'invoiceCount'
        ));
    }
}
