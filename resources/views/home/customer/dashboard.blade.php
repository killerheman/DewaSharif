@extends('home.includes.master')

@section('content')
<div style="background: #f8fafc; padding: 40px 0 80px 0; min-height: 85vh;">
    <div class="container">
        
        <div class="row">
            <!-- LEFT SIDEBAR -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('home.customer.includes.customer_sidebar')
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="col-lg-9 col-md-8">
                
                @if(request('payment_success') || session('success'))
                <div style="background: #15803d; color: #ffffff; padding: 20px 25px; border-radius: 14px; margin-bottom: 25px; box-shadow: 0 8px 25px rgba(21,128,61,0.25); border: 2px solid #22c55e;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 24px;">🎉</span>
                                <h4 style="margin: 0; font-weight: 900; color: #ffffff; font-size: 20px;">
                                    Your Payment Was Successful! Thank You for Your Booking
                                </h4>
                            </div>
                            <p style="margin: 6px 0 0 0; font-size: 13.5px; opacity: 0.95; font-weight: 600;">
                                @if(request('code'))
                                    Booking Reference: <strong>#{{ request('code') }}</strong> | 
                                @endif
                                Real-time email confirmation &amp; WhatsApp duty slip have been dispatched to your mobile number!
                            </p>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            @if(request('type') && request('id'))
                                <a href="{{ route('customer.invoice', ['type' => request('type'), 'id' => request('id')]) }}" target="_blank" class="btn" style="background: #ffffff; color: #15803d; font-weight: 900; padding: 9px 18px; border-radius: 8px; text-decoration: none; font-size: 13.5px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                    📄 Download Tax Invoice PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <script>
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                </script>
                @endif

                <!-- WELCOME BANNER -->
                <div style="background: linear-gradient(135deg, #052c16 0%, #074121 100%); color: #ffffff; padding: 25px 30px; border-radius: 16px; margin-bottom: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.12); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                    <div>
                        <span style="background: #ffeb3b; color: #052c16; font-size: 11px; font-weight: 900; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                            👤 Verified Customer Account 🎉 
                        </span>
                        <h3 style="font-weight: 900; margin-top: 8px; margin-bottom: 4px; color: #ffffff; font-size: 24px;">
                            Welcome, {{ $profile['name'] ?? 'User' }}
                        </h3>
                        <p style="font-size: 13.5px; color: #e8f5e9; margin: 0; font-weight: 500;">
                            Manage your verified Hotel stays, Cab duty slips , Sacred store orders and Official invoices.
                        </p>
                    </div>
                   
                </div>

                <!-- STATS CARDS -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-4 mb-3">
                        <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Hotel Stays</span>
                                <span class="badge" style="background: #dcfce7; color: #16a34a; padding: 6px 8px; border-radius: 50%;"><i class="fa fa-building"></i></span>
                            </div>
                            <h3 style="font-weight: 900; color: #0f172a; margin: 0;">{{ count($hotelBookings) }}</h3>
                            <small class="text-success font-weight-bold">Active Bookings</small>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Cab Rides</span>
                                <span class="badge" style="background: #e0f2fe; color: #0284c7; padding: 6px 8px; border-radius: 50%;"><i class="fa fa-taxi"></i></span>
                            </div>
                            <h3 style="font-weight: 900; color: #0f172a; margin: 0;">{{ count($cabBookings) }}</h3>
                            <small class="text-info font-weight-bold">Assigned Drivers</small>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Sacred Shop Orders</span>
                                <span class="badge" style="background: #fae8ff; color: #86198f; padding: 6px 8px; border-radius: 50%;"><i class="fa fa-shopping-bag"></i></span>
                            </div>
                            <h3 style="font-weight: 900; color: #0f172a; margin: 0;">{{ count($shopOrders) }}</h3>
                            <small style="color: #86198f;" class="font-weight-bold">Dispatched Orders</small>
                        </div>
                    </div>
                </div>

                <!-- DYNAMICALLY ORDERED RECENT ACTIVITY SECTIONS -->
                @php
                    $sOrder = $sectionOrder ?? [
                        ['type' => 'hotel'],
                        ['type' => 'cab'],
                        ['type' => 'shop'],
                    ];
                @endphp

                @foreach($sOrder as $sec)
                    @if($sec['type'] === 'hotel')
                        <!-- RECENT HOTEL BOOKINGS -->
                        <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 25px;">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                                <h5 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 17px;">🏨 Recent Hotel &amp; Guest House Reservations</h5>
                                <a href="{{ route('customer.hotels') }}" class="btn btn-sm btn-outline-success font-weight-bold" style="border-radius: 6px; font-size: 12px;">View All Stays →</a>
                            </div>
                            <br>

                            @forelse($hotelBookings as $booking)
                                @php
                                    $hPay = strtolower($booking['payment_status'] ?? '');
                                    $hStat = strtolower($booking['status'] ?? '');
                                    $hIsFailed = ($hPay === 'failed' || str_contains($hStat, 'failed') || str_contains($hStat, 'cancel'));
                                    $hIsPaid = ($hPay === 'paid' || str_contains($hStat, 'paid') || str_contains($hStat, 'confirmed'));
                                    $hIsPending = !$hIsFailed && !$hIsPaid;
                                @endphp
                                <div style="background: #f8fafc; border-radius: 12px; border: 1px solid {{ $hIsFailed ? '#fecaca' : '#e2e8f0' }}; padding: 16px; margin-bottom: 12px;">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div>
                                            @if($hIsFailed)
                                                <span style="font-size: 11px; font-weight: 800; color: #dc2626; background: #fee2e2; padding: 2px 8px; border-radius: 4px;">❌ PAYMENT FAILED / VOID</span>
                                            @elseif($hIsPending)
                                                <span style="font-size: 11px; font-weight: 800; color: #b45309; background: #fef3c7; padding: 2px 8px; border-radius: 4px;">⏳ VERIFICATION PENDING</span>
                                            @else
                                                <span style="font-size: 11px; font-weight: 800; color: #16a34a; background: #dcfce7; padding: 2px 8px; border-radius: 4px;">✔ {{ strtoupper($booking['status'] ?? 'CONFIRMED') }}</span>
                                            @endif
                                            <h5 style="font-weight: 800; color: #0f172a; margin: 6px 0 2px 0;">{{ $booking['hotel_name'] ?? 'Guest House Stay' }}</h5>
                                            <small style="color: #64748b;">Booking ID: <strong>#{{ $booking['booking_code'] ?? ($booking['booking_id'] ?? 'DWS-HTL-2026-001') }}</strong> | Check-in: <strong>{{ $booking['checkin'] ?? ($booking['check_in'] ?? '27 Oct 2026') }}</strong></small>
                                        </div>
                                        <div class="text-right">
                                            <h5 style="font-weight: 900; color: {{ $hIsFailed ? '#dc2626' : '#052c16' }}; margin: 0;">₹{{ number_format($booking['total_amount'] ?? ($booking['amount'] ?? 2998)) }}</h5>
                                            @if($hIsFailed)
                                                <a href="{{ route('customer.invoice', ['type' => 'hotel', 'id' => $booking['id'] ?? 1]) }}" target="_blank" class="btn btn-sm" style="background: #dc2626; color: #fff; font-size: 11.5px; font-weight: 700; border-radius: 6px; margin-top: 4px;">
                                                    ❌ Void Invoice
                                                </a>
                                            @else
                                                <a href="{{ route('customer.invoice', ['type' => 'hotel', 'id' => $booking['id'] ?? 1]) }}" target="_blank" class="btn btn-sm" style="background: #052c16; color: #fff; font-size: 11.5px; font-weight: 700; border-radius: 6px; margin-top: 4px;">
                                                    📥 Invoice
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3 m-0">No active hotel bookings found.</p>
                            @endforelse
                        </div>

                    @elseif($sec['type'] === 'cab')
                        <!-- RECENT CAB DUTIES -->
                        <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 25px;">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                                <h5 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 17px;">🚖 Recent Cab Duty Slips</h5>
                                <a href="{{ route('customer.cabs') }}" class="btn btn-sm btn-outline-info font-weight-bold" style="border-radius: 6px; font-size: 12px;">View All Cab Rides →</a>
                            </div><br>

                            @forelse($cabBookings as $cab)
                                @php
                                    $cPay = strtolower($cab['payment_status'] ?? '');
                                    $cStat = strtolower($cab['status'] ?? '');
                                    $cIsFailed = ($cPay === 'failed' || str_contains($cStat, 'failed') || str_contains($cStat, 'cancel'));
                                    $cIsPaid = ($cPay === 'paid' || str_contains($cStat, 'paid') || str_contains($cStat, 'confirmed'));
                                    $cIsPending = !$cIsFailed && !$cIsPaid;
                                @endphp
                                <div style="background: #f8fafc; border-radius: 12px; border: 1px solid {{ $cIsFailed ? '#fecaca' : '#e2e8f0' }}; padding: 16px; margin-bottom: 12px;">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div>
                                            <span style="font-size: 11px; font-weight: 800; color: #0284c7; background: #e0f2fe; padding: 2px 8px; border-radius: 4px;">🚖 {{ strtoupper($cab['vehicle_type'] ?? 'SEDAN DZIRE') }}</span>
                                            @if($cIsFailed)
                                                <span style="font-size: 11px; font-weight: 800; color: #dc2626; background: #fee2e2; padding: 2px 8px; border-radius: 4px; margin-left: 4px;">❌ PAYMENT FAILED / VOID</span>
                                            @elseif($cIsPending)
                                                <span style="font-size: 11px; font-weight: 800; color: #b45309; background: #fef3c7; padding: 2px 8px; border-radius: 4px; margin-left: 4px;">⏳ VERIFICATION PENDING</span>
                                            @else
                                                <span style="font-size: 11px; font-weight: 800; color: #16a34a; background: #dcfce7; padding: 2px 8px; border-radius: 4px; margin-left: 4px;">✔ CONFIRMED</span>
                                            @endif
                                            <h5 style="font-weight: 800; color: #0f172a; margin: 6px 0 2px 0;">{{ $cab['route'] ?? 'Lucknow Station → Dewa Sharif' }}</h5>
                                            @if($cIsFailed)
                                                <small style="color: #dc2626; font-weight: 700;">❌ Booking Cancelled (Payment Uncredited / Void)</small>
                                            @else
                                                @php
                                                    $dName = $cab['driver_name'] ?? null;
                                                    $dString = $cab['driver'] ?? null;
                                                    $hasRealDriver = (!empty($dName) && $dName !== 'Ramesh Kumar' && $dName !== 'Assigned Duty Driver') || (!empty($dString) && !str_contains($dString, 'UP32 AB 1234') && !str_contains($dString, 'Pending') && !str_contains($dString, 'Progress'));
                                                @endphp
                                                @if($hasRealDriver)
                                                    <small style="color: #64748b;">Driver: <strong>{{ $dName ?: $dString }}</strong> | Vehicle: <strong>{{ $cab['driver_vehicle_number'] ?? ($cab['vehicle_number'] ?? '') }}</strong></small>
                                                @else
                                                    <small style="color: #0284c7; font-weight: 700;">🕒 Driver Assignment in Progress (Details sent via WhatsApp before trip)</small>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <h5 style="font-weight: 900; color: {{ $cIsFailed ? '#dc2626' : '#052c16' }}; margin: 0;">₹{{ number_format($cab['total_fare'] ?? ($cab['fare'] ?? 1400)) }}</h5>
                                            @if($cIsFailed)
                                                <a href="{{ route('customer.invoice', ['type' => 'cab', 'id' => $cab['id'] ?? 1]) }}" target="_blank" class="btn btn-sm" style="background: #dc2626; color: #fff; font-size: 11.5px; font-weight: 700; border-radius: 6px; margin-top: 4px;">
                                                    ❌ Void Voucher
                                                </a>
                                            @else
                                                <a href="{{ route('customer.invoice', ['type' => 'cab', 'id' => $cab['id'] ?? 1]) }}" target="_blank" class="btn btn-sm" style="background: #0284c7; color: #fff; font-size: 11.5px; font-weight: 700; border-radius: 6px; margin-top: 4px;">
                                                    📥 Duty Voucher
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3 m-0">No active cab bookings found.</p>
                            @endforelse
                        </div>

                    @elseif($sec['type'] === 'shop')
                        <!-- RECENT SACRED STORE ORDERS -->
                        <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 25px;">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                                <h5 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 17px;">🛍️ Recent Sacred Store &amp; Souvenir Orders</h5>
                                <a href="{{ route('customer.orders') }}" class="btn btn-sm font-weight-bold" style="border-radius: 6px; font-size: 12px; color: #86198f; border: 1px solid #86198f;">View All Orders →</a>
                            </div><br>

                            @forelse($shopOrders as $order)
                                @php
                                    $sPay = strtolower($order['payment_status'] ?? '');
                                    $sStat = strtolower($order['status'] ?? '');
                                    $sIsFailed = ($sPay === 'failed' || str_contains($sStat, 'failed') || str_contains($sStat, 'cancel'));
                                    $sIsPaid = ($sPay === 'paid' || str_contains($sStat, 'paid') || str_contains($sStat, 'dispatched') || str_contains($sStat, 'delivered'));
                                    $sIsPending = !$sIsFailed && !$sIsPaid;
                                @endphp
                                <div style="background: #f8fafc; border-radius: 12px; border: 1px solid {{ $sIsFailed ? '#fecaca' : '#e2e8f0' }}; padding: 16px; margin-bottom: 12px;">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div>
                                            @if($sIsFailed)
                                                <span style="font-size: 11px; font-weight: 800; color: #dc2626; background: #fee2e2; padding: 2px 8px; border-radius: 4px;">❌ PAYMENT FAILED / VOID</span>
                                            @elseif($sIsPending)
                                                <span style="font-size: 11px; font-weight: 800; color: #b45309; background: #fef3c7; padding: 2px 8px; border-radius: 4px;">⏳ VERIFICATION PENDING</span>
                                            @else
                                                <span style="font-size: 11px; font-weight: 800; color: #86198f; background: #fae8ff; padding: 2px 8px; border-radius: 4px;">📦 {{ strtoupper($order['status'] ?? 'DISPATCHED') }}</span>
                                            @endif
                                            <h5 style="font-weight: 800; color: #0f172a; margin: 6px 0 2px 0;">{{ $order['items_summary'] ?? 'Sacred Store Order' }}</h5>
                                            <small style="color: #64748b;">Order ID: <strong>#{{ $order['order_code'] ?? ($order['order_id'] ?? 'DWS-ORD-2026-0001') }}</strong> | Tracking: <strong>{{ $order['tracking'] ?? 'DTDC Express' }}</strong></small>
                                        </div>
                                        <div class="text-right">
                                            <h5 style="font-weight: 900; color: {{ $sIsFailed ? '#dc2626' : '#052c16' }}; margin: 0;">₹{{ number_format($order['total_amount'] ?? ($order['amount'] ?? 1497)) }}</h5>
                                            @if($sIsFailed)
                                                <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $order['id'] ?? 1]) }}" target="_blank" class="btn btn-sm" style="background: #dc2626; color: #fff; font-size: 11.5px; font-weight: 700; border-radius: 6px; margin-top: 4px;">
                                                    ❌ Void Receipt
                                                </a>
                                            @else
                                                <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $order['id'] ?? 1]) }}" target="_blank" class="btn btn-sm" style="background: #86198f; color: #fff; font-size: 11.5px; font-weight: 700; border-radius: 6px; margin-top: 4px;">
                                                    📥 Receipt PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3 m-0">No sacred store orders found.</p>
                            @endforelse
                        </div>
                    @endif
                @endforeach

            </div>
        </div>

    </div>
</div>
@endsection
