<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Models\DomainOrder;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index()
    {
        $domains = DomainOrder::where('user_id', Auth::id())
            ->where('status', '!=', 'pending') // Exclude cart items, but show payment_pending, processing, etc.
            ->latest()
            ->paginate(20);

        return view('frontend.customer.my-domains', compact('domains'));
    }
}
