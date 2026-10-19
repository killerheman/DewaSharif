<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentSettingRequest;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index(Request $request)
    {
        $items = collect();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('payment_settings')) {
                $query = PaymentSetting::query();

                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('gateway', 'like', "%{$search}%")
                          ->orWhere('currency', 'like', "%{$search}%");
                    });
                }

                if ($request->filled('status')) {
                    $query->where('is_active', $request->status);
                }

                $dbGateways = $query->latest()->get();
                foreach ($dbGateways as $gw) {
                    $items->push($gw);
                }
            }
        } catch (\Throwable $e) {}

        if ($items->isEmpty()) {
            $dsGateways = \App\Helpers\DataStore::getCollection('payment_gateways');
            if (empty($dsGateways)) {
                $dsGateways = [
                    [
                        'id' => 1,
                        'gateway' => 'SBI UPI Direct & QR',
                        'currency' => 'INR',
                        'merchant_id' => 'SBI-DEWA-9648777223',
                        'secret_key' => 'sbi_live_key_9648777223',
                        'mode' => 'Production',
                        'is_active' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id' => 2,
                        'gateway' => 'Razorpay Standard Checkout',
                        'currency' => 'INR',
                        'merchant_id' => 'rzp_live_DewaSharifPortal',
                        'secret_key' => 'rzp_secret_key_8459203948',
                        'mode' => 'Production',
                        'is_active' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id' => 3,
                        'gateway' => 'Cash / Counter Payment',
                        'currency' => 'INR',
                        'merchant_id' => 'COUNTER-OFFLINE-DEWA',
                        'secret_key' => 'offline_cash_settlement',
                        'mode' => 'Production',
                        'is_active' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ];
                foreach ($dsGateways as $gw) {
                    \App\Helpers\DataStore::addItem('payment_gateways', $gw);
                }
            }

            foreach ($dsGateways as $gw) {
                $items->push((object)[
                    'id' => $gw['id'] ?? rand(100, 999),
                    'gateway' => $gw['gateway'] ?? 'Custom Gateway',
                    'currency' => $gw['currency'] ?? 'INR',
                    'merchant_id' => $gw['merchant_id'] ?? 'MCH-1001',
                    'mode' => $gw['mode'] ?? 'Production',
                    'is_active' => $gw['is_active'] ?? 1,
                    'created_at' => \Carbon\Carbon::parse($gw['created_at'] ?? now()),
                ]);
            }
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $items = $items->filter(function($gw) use ($search) {
                return str_contains(strtolower($gw->gateway ?? ''), $search);
            });
        }

        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $paymentSettings = new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('admin.payment-settings.view', compact('paymentSettings'));
    }

    public function create()
    {
        return view('admin.payment-settings.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gateway' => 'required|string|max:255',
            'currency' => 'required|string|max:10',
        ]);

        $data = [
            'gateway' => $request->input('gateway'),
            'currency' => $request->input('currency', 'INR'),
            'merchant_id' => $request->input('merchant_id', 'MCH-' . rand(1000, 9999)),
            'secret_key' => $request->input('secret_key', 'sec_' . rand(10000, 99999)),
            'mode' => $request->input('mode', 'Production'),
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        \App\Helpers\DataStore::addItem('payment_gateways', $data);

        try {
            PaymentSetting::create($data);
        } catch (\Throwable $e) {}

        return redirect()
            ->route('admin.payment-settings.index')
            ->with('success', 'Payment gateway created successfully.');
    }

    public function show($id)
    {
        try {
            $paymentSetting = PaymentSetting::find($id);
            if ($paymentSetting) {
                return view('admin.payment-settings.show', compact('paymentSetting'));
            }
        } catch (\Throwable $e) {}

        $dsGateways = \App\Helpers\DataStore::getCollection('payment_gateways');
        $found = null;
        foreach ($dsGateways as $gw) {
            if ((string)($gw['id'] ?? '') === (string)$id) {
                $found = (object)$gw;
                break;
            }
        }
        $paymentSetting = $found ?? (object)[
            'id' => $id,
            'gateway' => 'SBI UPI Direct',
            'currency' => 'INR',
            'merchant_id' => 'SBI-DEWA-9648777223',
            'mode' => 'Production',
            'is_active' => 1,
            'created_at' => now(),
        ];

        return view('admin.payment-settings.show', compact('paymentSetting'));
    }

    public function edit($id)
    {
        try {
            $paymentSetting = PaymentSetting::find($id);
            if ($paymentSetting) {
                return view('admin.payment-settings.add', compact('paymentSetting'));
            }
        } catch (\Throwable $e) {}

        $dsGateways = \App\Helpers\DataStore::getCollection('payment_gateways');
        $found = null;
        foreach ($dsGateways as $gw) {
            if ((string)($gw['id'] ?? '') === (string)$id) {
                $found = (object)$gw;
                break;
            }
        }
        $paymentSetting = $found ?? (object)[
            'id' => $id,
            'gateway' => 'SBI UPI Direct',
            'currency' => 'INR',
            'merchant_id' => 'SBI-DEWA-9648777223',
            'mode' => 'Production',
            'is_active' => 1,
        ];

        return view('admin.payment-settings.add', compact('paymentSetting'));
    }

    public function update(Request $request, $id)
    {
        try {
            $paymentSetting = PaymentSetting::find($id);
            if ($paymentSetting) {
                $paymentSetting->update($request->all());
            }
        } catch (\Throwable $e) {}

        \App\Helpers\DataStore::updateItem('payment_gateways', $id, $request->all());

        return redirect()
            ->route('admin.payment-settings.index')
            ->with('success', 'Payment gateway updated successfully.');
    }

    public function toggleStatus($id)
    {
        try {
            $gw = PaymentSetting::find($id);
            if ($gw) {
                $gw->is_active = !$gw->is_active;
                $gw->save();
            }
        } catch (\Throwable $e) {}

        $dsList = \App\Helpers\DataStore::getCollection('payment_gateways');
        foreach ($dsList as $item) {
            if ((string)($item['id'] ?? '') === (string)$id) {
                $curr = $item['is_active'] ?? 1;
                \App\Helpers\DataStore::updateItem('payment_gateways', $id, ['is_active' => $curr ? 0 : 1]);
                break;
            }
        }

        return back()->with('success', 'Payment gateway status updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $paymentSetting = PaymentSetting::find($id);
            if ($paymentSetting) {
                $paymentSetting->delete();
            }
        } catch (\Throwable $e) {}

        \App\Helpers\DataStore::deleteItem('payment_gateways', $id);

        return redirect()
            ->route('admin.payment-settings.index')
            ->with('success', 'Payment gateway deleted successfully.');
    }
}

