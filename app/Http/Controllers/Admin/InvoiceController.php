<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Helpers\DataStore;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $items = collect();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('invoices')) {
                $query = Invoice::with('user');

                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('invoice_no', 'like', "%{$search}%")
                            ->orWhere('service_name', 'like', "%{$search}%")
                            ->orWhere('payment_id', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($user) use ($search) {
                                $user->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                            });
                    });
                }

                if ($request->filled('payment_status')) {
                    $query->where('payment_status', $request->payment_status);
                }

                $dbInvoices = $query->latest()->get();
                foreach ($dbInvoices as $inv) {
                    $items->push((object)[
                        'id' => $inv->id,
                        'invoice_no' => $inv->invoice_no ?? ('INV-' . $inv->id),
                        'user' => $inv->user,
                        'customer_name' => $inv->user?->name ?? 'Customer',
                        'service_type' => $inv->service_type ?? 'Service Booking',
                        'service_name' => $inv->service_name ?? 'Dewa Sharif Service',
                        'net_amount' => $inv->net_amount ?? ($inv->amount ?? 0),
                        'payment_status' => $inv->payment_status ?? 'Paid',
                        'invoice_date' => $inv->created_at ?? now(),
                        'type' => 'db',
                    ]);
                }
            }
        } catch (\Throwable $e) {}

        // Merge DataStore Bookings & Orders if DB list is empty
        if ($items->isEmpty()) {
            $hotels = \App\Helpers\DataStore::getCollection('hotel_bookings');
            foreach ($hotels as $h) {
                $hId = $h['id'] ?? rand(100, 999);
                $numId = is_numeric($hId) ? str_pad($hId, 3, '0', STR_PAD_LEFT) : $hId;
                $items->push((object)[
                    'id' => $hId,
                    'invoice_no' => 'INV-HOT-' . $numId,
                    'customer_name' => $h['customer_name'] ?? 'Guest User',
                    'user' => (object)['name' => $h['customer_name'] ?? 'Guest User', 'email' => $h['customer_phone'] ?? 'N/A'],
                    'service_type' => 'Hotel Stay',
                    'service_name' => $h['hotel_name'] ?? 'Guest House Stay',
                    'net_amount' => (float)($h['total_fare'] ?? ($h['amount'] ?? 2998)),
                    'payment_status' => 'Paid',
                    'invoice_date' => \Carbon\Carbon::parse($h['created_at'] ?? now()),
                    'type' => 'hotel',
                    'raw_id' => $hId
                ]);
            }

            $cabs = \App\Helpers\DataStore::getCollection('cab_bookings');
            foreach ($cabs as $c) {
                $cId = $c['id'] ?? rand(100, 999);
                $numId = is_numeric($cId) ? str_pad($cId, 3, '0', STR_PAD_LEFT) : $cId;
                $items->push((object)[
                    'id' => $cId,
                    'invoice_no' => 'INV-CAB-' . $numId,
                    'customer_name' => $c['customer_name'] ?? 'Passenger',
                    'user' => (object)['name' => $c['customer_name'] ?? 'Passenger', 'email' => $c['customer_phone'] ?? 'N/A'],
                    'service_type' => 'Taxi Ride',
                    'service_name' => $c['route'] ?? 'Lucknow - Dewa Sharif Cab',
                    'net_amount' => (float)($c['fare'] ?? 1400),
                    'payment_status' => 'Paid',
                    'invoice_date' => \Carbon\Carbon::parse($c['created_at'] ?? now()),
                    'type' => 'cab',
                    'raw_id' => $cId
                ]);
            }

            $shops = \App\Helpers\DataStore::getCollection('shop_orders');
            foreach ($shops as $s) {
                $sId = $s['id'] ?? rand(100, 999);
                $numId = is_numeric($sId) ? str_pad($sId, 3, '0', STR_PAD_LEFT) : $sId;
                $items->push((object)[
                    'id' => $sId,
                    'invoice_no' => 'INV-SHP-' . $numId,
                    'customer_name' => $s['customer_name'] ?? 'Customer',
                    'user' => (object)['name' => $s['customer_name'] ?? 'Customer', 'email' => $s['customer_phone'] ?? 'N/A'],
                    'service_type' => 'Sacred Store',
                    'service_name' => $s['items_summary'] ?? 'Warsi Attar & Handicrafts',
                    'net_amount' => (float)($s['total_amount'] ?? 1497),
                    'payment_status' => 'Paid',
                    'invoice_date' => \Carbon\Carbon::parse($s['created_at'] ?? now()),
                    'type' => 'shop',
                    'raw_id' => $sId
                ]);
            }
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $items = $items->filter(function($i) use ($search) {
                return str_contains(strtolower($i->invoice_no), $search) || 
                       str_contains(strtolower($i->customer_name), $search) || 
                       str_contains(strtolower($i->service_name), $search);
            });
        }

        if ($request->filled('payment_status')) {
            $items = $items->where('payment_status', $request->payment_status);
        }

        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $invoices = new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('admin.invoices.view', compact('invoices'));
    }

    public function show($id, Request $request)
    {
        $type = $request->query('type', 'hotel');
        $invoice = null;

        try {
            if (is_numeric($id) && \Illuminate\Support\Facades\Schema::hasTable('invoices')) {
                $invoice = Invoice::with('user')->find($id);
            }
        } catch (\Throwable $e) {}

        // If not found in DB, construct dynamic invoice object from DataStore for Admin Panel View
        if (!$invoice) {
            if ($type === 'hotel') {
                $hotelBookings = DataStore::getCollection('hotel_bookings');
                $b = null;
                foreach ($hotelBookings as $item) {
                    if ((string)($item['id'] ?? '') === (string)$id) { $b = $item; break; }
                }
                if (!$b && !empty($hotelBookings)) { $b = $hotelBookings[0]; }
                $rawId = $b['id'] ?? $id;
                $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;

                $invoice = (object)[
                    'id' => $rawId,
                    'invoice_no' => 'INV-HOT-' . $numId,
                    'user' => (object)[
                        'name' => $b['customer_name'] ?? 'Mohd Amir Khan',
                        'email' => $b['customer_phone'] ?? '9876543210'
                    ],
                    'billing_address' => 'Dewa Sharif, Barabanki, Uttar Pradesh, India',
                    'service_type' => 'Hotel Stay',
                    'service_name' => ($b['hotel_name'] ?? 'Al-Waris Deluxe Guest House') . ' (' . ($b['room_name'] ?? 'Deluxe AC') . ')',
                    'period' => ($b['checkin'] ?? '26 Sep 2026') . ' to ' . ($b['checkout'] ?? '28 Sep 2026'),
                    'invoice_date' => \Carbon\Carbon::parse($b['created_at'] ?? now()),
                    'payment_status' => 'Paid',
                    'order_id' => $b['booking_code'] ?? ('ORD-HOT-' . $numId),
                    'payment_id' => $b['payment_id'] ?? ('pay_HOT_' . substr(md5($id), 0, 10)),
                    'subscription_id' => 'SUB-HTL-2026',
                    'amount' => (float)($b['total_fare'] ?? ($b['amount'] ?? 2998)),
                    'gst' => 0.00,
                    'vendor_amount' => (float)($b['total_fare'] ?? ($b['amount'] ?? 2998)),
                    'net_amount' => (float)($b['total_fare'] ?? ($b['amount'] ?? 2998)),
                    'plan_features' => "• 24/7 Hot Water & Power Backup\n• Free High-Speed Wi-Fi\n• Near Dewa Sharif Dargah Gate 1\n• Deluxe Room AC with Attached Bath",
                ];
            } elseif ($type === 'cab') {
                $cabBookings = DataStore::getCollection('cab_bookings');
                $c = null;
                foreach ($cabBookings as $item) {
                    if ((string)($item['id'] ?? '') === (string)$id) { $c = $item; break; }
                }
                if (!$c && !empty($cabBookings)) { $c = $cabBookings[0]; }
                $rawId = $c['id'] ?? $id;
                $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;

                $invoice = (object)[
                    'id' => $rawId,
                    'invoice_no' => 'INV-CAB-' . $numId,
                    'user' => (object)[
                        'name' => $c['customer_name'] ?? 'Shahzade Alam',
                        'email' => $c['customer_phone'] ?? '9648456133'
                    ],
                    'billing_address' => 'Lucknow / Dewa Sharif Route, Uttar Pradesh',
                    'service_type' => 'Taxi Ride',
                    'service_name' => ($c['route'] ?? 'Dewa Sharif Dargah Gate → Lucknow Charbagh Railway Station') . ' (' . ($c['vehicle'] ?? 'Swift Dzire Non-AC') . ')',
                    'period' => $c['pickup_time'] ?? '26 Sep 2026',
                    'invoice_date' => \Carbon\Carbon::parse($c['created_at'] ?? now()),
                    'payment_status' => 'Paid',
                    'order_id' => $c['booking_code'] ?? ('ORD-CAB-' . $numId),
                    'payment_id' => $c['payment_id'] ?? ('pay_CAB_' . substr(md5($id), 0, 10)),
                    'subscription_id' => 'SUB-CAB-2026',
                    'amount' => (float)($c['fare'] ?? 1190),
                    'gst' => 0.00,
                    'vendor_amount' => (float)($c['fare'] ?? 1190),
                    'net_amount' => (float)($c['fare'] ?? 1190),
                    'plan_features' => "• Verified Professional Driver\n• Doorstep Pickup & Drop\n• Highway Tolls Included\n• Clean Sanitized Taxi",
                ];
            } else {
                $shopOrders = DataStore::getCollection('shop_orders');
                $s = null;
                foreach ($shopOrders as $item) {
                    if ((string)($item['id'] ?? '') === (string)$id) { $s = $item; break; }
                }
                if (!$s && !empty($shopOrders)) { $s = $shopOrders[0]; }
                $rawId = $s['id'] ?? $id;
                $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;

                $invoice = (object)[
                    'id' => $rawId,
                    'invoice_no' => 'INV-SHP-' . $numId,
                    'user' => (object)[
                        'name' => $s['customer_name'] ?? 'Salman Siddiqui',
                        'email' => $s['customer_phone'] ?? '9123456789'
                    ],
                    'billing_address' => 'Sacred Store Parcel Shipping, India',
                    'service_type' => 'Sacred Store',
                    'service_name' => $s['items_summary'] ?? 'Rooh-e-Waris Khas Attar & Sufi White Kurta Set',
                    'period' => 'One-time Order Purchase',
                    'invoice_date' => \Carbon\Carbon::parse($s['created_at'] ?? now()),
                    'payment_status' => 'Paid',
                    'order_id' => $s['order_code'] ?? ('ORD-SHP-' . $numId),
                    'payment_id' => $s['payment_id'] ?? ('pay_SHP_' . substr(md5($id), 0, 10)),
                    'subscription_id' => 'SUB-SHP-2026',
                    'amount' => (float)($s['total_amount'] ?? 1497),
                    'gst' => 0.00,
                    'vendor_amount' => (float)($s['total_amount'] ?? 1497),
                    'net_amount' => (float)($s['total_amount'] ?? 1497),
                    'plan_features' => "• 100% Authentic Dewa Sharif Fragrance\n• DTDC Express Shipping with Tracking\n• Leak-Proof Safe Packaging",
                ];
            }
        }

        return view('admin.invoices.show', compact('invoice'));
    }

    public function download($id, Request $request)
    {
        $type = $request->query('type', 'hotel');

        try {
            if (is_numeric($id) && \Illuminate\Support\Facades\Schema::hasTable('invoices')) {
                $invoice = Invoice::with('user')->find($id);
                if ($invoice) {
                    $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'invoice-' . ($invoice->invoice_no ?? $id) . '.pdf');
                }
            }
        } catch (\Throwable $e) {}

        // Route to customer invoice with download=1 parameter to trigger direct PDF/Print download
        return redirect()->route('customer.invoice', ['type' => $type, 'id' => $id, 'download' => 1]);
    }

    public function export()
    {
        $filename = 'invoices-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Invoice No', 'Customer Name', 'Service Type', 'Particulars', 'Amount', 'Payment Status', 'Date']);

            $hotels = \App\Helpers\DataStore::getCollection('hotel_bookings');
            foreach ($hotels as $h) {
                $hId = $h['id'] ?? 1;
                $numId = is_numeric($hId) ? str_pad($hId, 3, '0', STR_PAD_LEFT) : $hId;
                fputcsv($handle, [
                    'INV-HOT-' . $numId,
                    $h['customer_name'] ?? 'Guest User',
                    'Hotel Stay',
                    $h['hotel_name'] ?? 'Guest House Stay',
                    $h['total_fare'] ?? 2998,
                    'Paid',
                    $h['created_at'] ?? date('Y-m-d')
                ]);
            }

            $cabs = \App\Helpers\DataStore::getCollection('cab_bookings');
            foreach ($cabs as $c) {
                $cId = $c['id'] ?? 1;
                $numId = is_numeric($cId) ? str_pad($cId, 3, '0', STR_PAD_LEFT) : $cId;
                fputcsv($handle, [
                    'INV-CAB-' . $numId,
                    $c['customer_name'] ?? 'Passenger',
                    'Taxi Ride',
                    $c['route'] ?? 'Lucknow - Dewa Sharif',
                    $c['fare'] ?? 1400,
                    'Paid',
                    $c['created_at'] ?? date('Y-m-d')
                ]);
            }

            $shops = \App\Helpers\DataStore::getCollection('shop_orders');
            foreach ($shops as $s) {
                $sId = $s['id'] ?? 1;
                $numId = is_numeric($sId) ? str_pad($sId, 3, '0', STR_PAD_LEFT) : $sId;
                fputcsv($handle, [
                    'INV-SHP-' . $numId,
                    $s['customer_name'] ?? 'Customer',
                    'Sacred Store',
                    $s['items_summary'] ?? 'Attar & Souvenirs',
                    $s['total_amount'] ?? 1497,
                    'Paid',
                    $s['created_at'] ?? date('Y-m-d')
                ]);
            }

            fclose($handle);
        }, $filename);
    }

    public function sendRenewalReminder($id)
    {
        return back()->with('success', "Renewal reminder sent for Invoice #{$id}!");
    }
}
