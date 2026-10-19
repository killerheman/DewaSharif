<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::where('role', 'customer')->count();
        $hostingPlans = \App\Models\Plan::count();
        
        // Count domains that are registered or renewed
        $registeredDomains = \App\Models\DomainOrder::whereIn('status', ['registered', 'renewed'])->count();
        
        $pendingOrders = \App\Models\Invoice::where('payment_status', '!=', 'Paid')->count();
        $activeServers = \App\Models\Server::where('is_active', 1)->count();
        $totalRevenue = \App\Models\Invoice::where('payment_status', 'Paid')->sum('net_amount');

        return view('admin.dashboard.index', compact(
            'totalUsers', 
            'hostingPlans', 
            'registeredDomains', 
            'pendingOrders', 
            'activeServers', 
            'totalRevenue'
        ));
    }
}
