@extends('home.includes.master')

@section('content')
<div style="background: #f8fafc; padding: 40px 0 80px 0; min-height: 85vh;">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-4">
                @include('home.customer.includes.customer_sidebar')
            </div>

            <div class="col-lg-9 col-md-8">
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <h4 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 22px;">🚖 My Cab Trips &amp; Duty Slips</h4>
                            <small class="text-muted">Verified Station/Airport Taxi duty slips</small>
                        </div>
                        <a href="{{ route('cabs') }}" class="btn btn-sm btn-info font-weight-bold px-3 text-white" style="border-radius: 8px;">+ Book New Cab</a>
                    </div>

                    @forelse($cabBookings as $cab)
                        <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 16px;">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                                <div>
                                    <span style="font-size: 11px; font-weight: 800; color: #0284c7; background: #e0f2fe; padding: 3px 10px; border-radius: 6px;">
                                        🚖 {{ strtoupper($cab['vehicle_type'] ?? 'SEDAN (DZIRE)') }}
                                    </span>
                                    <h4 style="font-weight: 900; color: #0f172a; margin-top: 8px; margin-bottom: 4px; font-size: 19px;">
                                        {{ $cab['route'] ?? 'Lucknow Charbagh Station → Dewa Sharif Dargah' }}
                                    </h4>
                                    <p style="font-size: 13px; color: #64748b; margin: 0;">
                                        Trip ID: <strong>#{{ $cab['booking_code'] ?? ($cab['booking_id'] ?? 'DWS-CAB-2026-0001') }}</strong> | Pickup Date &amp; Time: <strong>{{ $cab['pickup_time'] ?? ($cab['date'] ?? '27 Oct 2026 @ 08:30 AM') }}</strong>
                                    </p>
                                </div>
                                @php
                                    $cPayStatus = strtolower($cab['payment_status'] ?? 'paid');
                                    $cStatus = strtolower($cab['status'] ?? '');
                                    $isPaid = in_array($cPayStatus, ['paid', 'completed', 'success']) || str_contains($cStatus, 'paid');
                                    $isFailed = in_array($cPayStatus, ['failed', 'cancelled', 'rejected']) || str_contains($cStatus, 'fail') || str_contains($cStatus, 'cancel');
                                @endphp
                                <div class="text-right">
                                    <span style="font-size: 22px; font-weight: 900; color: #052c16; display: block;">₹{{ number_format($cab['total_fare'] ?? ($cab['fare'] ?? 1400)) }}</span>
                                    @if($isPaid)
                                        <span style="font-size: 11px; color: #166534; font-weight: 800; background: #dcfce7; padding: 3px 10px; border-radius: 4px; display: inline-block;">✓ Verified Paid Fare</span>
                                    @elseif($isFailed)
                                        <span style="font-size: 11px; color: #991b1b; font-weight: 800; background: #fee2e2; padding: 3px 10px; border-radius: 4px; display: inline-block;">❌ Payment Failed / Void</span>
                                    @else
                                        <span style="font-size: 11px; color: #b45309; font-weight: 800; background: #fef3c7; padding: 3px 10px; border-radius: 4px; display: inline-block;">⏳ Settlement Verification Underway</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 6px;">
                                        👤 <strong>Passenger:</strong> {{ $cab['customer_name'] ?? (auth()->check() ? auth()->user()->name : 'Passenger') }} ({{ $cab['customer_phone'] ?? (auth()->check() ? (auth()->user()->phone ?? auth()->user()->mobile ?? '') : '') }}{{ !empty($cab['alternate_phone']) ? ' / Alt: ' . $cab['alternate_phone'] : '' }})
                                    </p>
                                    @php
                                        $dName = $cab['driver_name'] ?? null;
                                        $dString = $cab['driver'] ?? null;
                                        $hasRealDriver = (!empty($dName) && $dName !== 'Ramesh Kumar' && $dName !== 'Assigned Duty Driver') || (!empty($dString) && !str_contains($dString, 'UP32 AB 1234') && !str_contains($dString, 'Pending') && !str_contains($dString, 'Progress'));
                                    @endphp
                                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 0;">
                                        🚘 <strong>Assigned Driver &amp; Duty:</strong> 
                                        @if($isFailed)
                                            <span class="text-danger font-weight-bold">❌ Booking Cancelled (Payment Uncredited / Void)</span>
                                        @elseif($hasRealDriver)
                                            <span class="text-success font-weight-bold">{{ $dName ?: $dString }}{{ !empty($cab['driver_vehicle_number']) ? ' (' . $cab['driver_vehicle_number'] . ')' : '' }}</span>
                                        @else
                                            <span style="color: #0284c7; font-weight: 700;">Driver Assignment in Progress (Details sent via WhatsApp before pickup)</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                    <a href="{{ route('customer.invoice', ['type' => 'cab', 'id' => $cab['id'] ?? 1]) }}" target="_blank" class="btn" style="background: {{ $isFailed ? '#dc2626' : '#0284c7' }}; color: #ffffff; font-weight: 800; font-size: 13px; border-radius: 8px; padding: 9px 16px;">
                                        {{ $isFailed ? '❌ View Void Voucher (Failed)' : '📥 Duty Voucher PDF' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-taxi text-muted mb-2" style="font-size: 40px;"></i>
                            <h5>No Cab Duty Slips Found</h5>
                            <a href="{{ route('cabs') }}" class="btn btn-info text-white font-weight-bold mt-2">Book Taxi Service</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
