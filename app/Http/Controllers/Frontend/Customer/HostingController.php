<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function index()
    {
        $hostings = \App\Models\HostingOrder::where('user_id', auth()->id())
            ->whereIn('status', ['active', 'processing', 'renewed', 'completed', 'paid'])
            ->latest()
            ->paginate(10);

        return view('frontend.customer.my-hostings', compact('hostings'));
    }
}
