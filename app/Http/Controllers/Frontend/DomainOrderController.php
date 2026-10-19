<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DomainOrder;
use Illuminate\Http\Request;

class DomainOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required',
            'price' => 'required'
        ]);


        $exists = DomainOrder::where('user_id', auth()->id())
            ->where('domain', $request->domain)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->route('cart')->with('info', 'This domain is already in your cart!');
        }

        $order = DomainOrder::create([
            'user_id' => auth()->id(),
            'domain' => $request->domain,
            'extension' => '.' . ($domain[1] ?? ''),
            'price' => $request->price,
            'currency' => 'INR',
            'status' => 'pending',
        ]);


        return redirect()->route('cart');
    }
}
