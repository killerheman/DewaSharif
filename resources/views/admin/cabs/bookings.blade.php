@extends('admin.includes.master')

@section('title', 'Cab & Taxi Duty Bookings | DewaSharif Admin')

@section('content')
<style>
    .badge-gradient-dark {
        background: linear-gradient(135deg, #0b132b 0%, #1e293b 50%, #1e40af 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.4);
    }
    .badge-silver-gradient {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 45%, #e2e8f0 75%, #cbd5e1 100%) !important;
        color: #0f172a !important;
        border: 1px solid #94a3b8 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        font-family: monospace;
        font-size: 10.5px;
        font-weight: 700;
    }
</style>
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="bi bi-journal-check text-success me-2"></i>Cab &amp; Taxi Customer Reservations</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.cabs.index') }}" class="btn btn-outline-primary fw-bold shadow-sm">
                        <i class="bi bi-car-front-fill me-1"></i> Manage Routes &amp; Fleet
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <i class="bi bi-check-circle-fill fs-5 me-2"></i><strong>{{ session('success') }}</strong>
                        </div>
                        @if(session('whatsapp_redirect'))
                            <a href="{{ session('whatsapp_redirect') }}" target="_blank" class="btn btn-sm btn-success fw-bold shadow-sm ms-3">
                                <i class="bi bi-whatsapp me-1"></i> Send Duty Slip on WhatsApp Now
                            </a>
                        @endif
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card card-outline card-success shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-list-stars text-success me-2"></i>Customer Taxi Duty Bookings List</h5>
                    <span class="badge bg-primary fs-6">{{ count($bookings) }} Bookings Registered</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Passenger Info &amp; ID Verification</th>
                                    <th>Route &amp; Vehicle Category</th>
                                    <th>Pickup Date &amp; Time</th>
                                    <th>Total Fare</th>
                                    <th>Duty Driver</th>
                                    <th>Status</th>
                                    <th class="text-end" style="min-width: 215px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    @php
                                        $bId = is_array($booking) ? ($booking['id'] ?? 1) : $booking->id;
                                        $bCode = is_array($booking) ? ($booking['booking_code'] ?? "#CB-{$bId}") : ($booking->booking_code ?? "#CB-{$bId}");
                                        
                                        $bName = is_array($booking) ? ($booking['customer_name'] ?? ($booking['passenger_name'] ?? ($booking['name'] ?? 'Mohd Amir Khan'))) : ($booking->customer_name ?? 'Mohd Amir Khan');
                                        $bPhone = is_array($booking) ? ($booking['customer_phone'] ?? ($booking['passenger_phone'] ?? ($booking['phone'] ?? '9876543210'))) : ($booking->customer_phone ?? '9876543210');
                                        $bAltPhone = is_array($booking) ? ($booking['alternate_phone'] ?? null) : ($booking->alternate_phone ?? null);
                                        $bIdType = is_array($booking) ? ($booking['id_type'] ?? 'Aadhaar Card') : ($booking->id_type ?? 'Aadhaar Card');
                                        $bIdNo = is_array($booking) ? ($booking['id_no'] ?? ($booking['aadhaar'] ?? '5482 9102 3841')) : ($booking->id_no ?? '5482 9102 3841');

                                        $bRoute = is_array($booking) ? ($booking['route'] ?? ($booking['route_name'] ?? 'Lucknow ↔ Dewa Sharif')) : ($booking->route ?? 'Lucknow ↔ Dewa Sharif');
                                        $bPickup = is_array($booking) ? ($booking['pickup'] ?? 'Dewa Sharif') : ($booking->pickup ?? 'Dewa Sharif');
                                        $bDrop = is_array($booking) ? ($booking['destination'] ?? 'Lucknow') : ($booking->destination ?? 'Lucknow');
                                        $bVehicle = is_array($booking) ? ($booking['vehicle_type'] ?? 'Swift Dzire (AC)') : ($booking->vehicle_type ?? 'Swift Dzire (AC)');
                                        $bTime = is_array($booking) ? ($booking['pickup_time'] ?? 'Oct 27, 2026 @ 08:30 AM') : ($booking->pickup_time ?? 'Oct 27, 2026 @ 08:30 AM');
                                        
                                        $bFare = is_array($booking) ? ($booking['fare'] ?? ($booking['total_fare'] ?? 1499)) : ($booking->fare ?? 1499);
                                        $bNight = !empty(is_array($booking) ? ($booking['night_surcharge'] ?? 0) : ($booking->night_surcharge ?? 0));

                                        $bDriver = is_array($booking) ? ($booking['driver'] ?? '') : ($booking->driver ?? '');
                                        $rawDriverName = is_array($booking) ? ($booking['driver_name'] ?? '') : ($booking->driver_name ?? '');
                                        $bDriverName = ($rawDriverName && $rawDriverName !== 'Ramesh Kumar') ? $rawDriverName : '';
                                        $rawDriverPhone = is_array($booking) ? ($booking['driver_phone'] ?? '') : ($booking->driver_phone ?? '');
                                        $bDriverPhone = ($rawDriverPhone && $rawDriverPhone !== '9876543210') ? $rawDriverPhone : '';
                                        $rawVehicleNo = is_array($booking) ? ($booking['driver_vehicle_number'] ?? '') : ($booking->driver_vehicle_number ?? '');
                                        $bVehicleNo = ($rawVehicleNo && !str_contains($rawVehicleNo, 'UP 32 AB 1234') && !str_contains($rawVehicleNo, 'UP32 AB 1234')) ? $rawVehicleNo : '';
                                        $bStatus = is_array($booking) ? ($booking['status'] ?? 'Confirmed & Paid') : ($booking->status ?? 'Confirmed & Paid');
                                        $bRawStatus = strtolower($bStatus);
                                        $isConfirmed = str_contains($bRawStatus, 'confirm') || str_contains($bRawStatus, 'paid') || str_contains($bRawStatus, 'dispatched');

                                        // Prepare full WhatsApp Duty Slip Text for Direct Button
                                        $waPassengerContact = $bPhone . (!empty($bAltPhone) ? " (Alt: {$bAltPhone})" : "");
                                        $waMsgText = "🚨 *DEWA SHARIF CAB DUTY SLIP - DRIVER ASSIGNED*\n\n" .
                                                     "🎫 *Booking ID:* {$bCode}\n" .
                                                     "👤 *Passenger Name:* {$bName}\n" .
                                                     "📞 *Passenger Phone:* {$waPassengerContact}\n" .
                                                     "🪪 *ID Verification:* {$bIdType} ({$bIdNo})\n" .
                                                     "📍 *Route:* {$bRoute}\n" .
                                                     "🚕 *Vehicle Category:* {$bVehicle}\n" .
                                                     "📅 *Pickup Date & Time:* {$bTime}\n" .
                                                     "💰 *Total Fare Paid:* ₹" . number_format((float)$bFare, 2) . ($bNight ? " (Includes ₹100 Night Charge 10 PM-5 AM)" : "") . "\n\n" .
                                                     "🚖 *Assigned Driver:* {$bDriverName}\n" .
                                                     "📱 *Driver Contact:* {$bDriverPhone}\n" .
                                                     "🔢 *Vehicle No Plate:* {$bVehicleNo}\n\n" .
                                                     "⚠️ *Driver Instruction:* Gaadi me baithne se pehle passenger ki original physical ID check karein.\n" .
                                                     "Please reach pickup point 15 mins prior to time. Wish you a safe trip!";

                                        $cleanDriverNo = preg_replace('/[^0-9]/', '', $bDriverPhone);
                                        if (strlen($cleanDriverNo) === 10) {
                                             $cleanDriverNo = '91' . $cleanDriverNo;
                                        }
                                        if (empty($cleanDriverNo)) {
                                            $cleanPassengerNo = preg_replace('/[^0-9]/', '', $bPhone);
                                            if (strlen($cleanPassengerNo) === 10) {
                                                $cleanPassengerNo = '91' . $cleanPassengerNo;
                                            }
                                            $cleanDriverNo = $cleanPassengerNo;
                                        }
                                        $waDirectUrl = "https://wa.me/{$cleanDriverNo}?text=" . urlencode($waMsgText);
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong class="d-block text-primary">{{ $bCode }}</strong>
                                            <small class="text-muted">#ID-{{ $bId }}</small>
                                        </td>
                                        <td>
                                            <strong class="d-block text-dark"><i class="bi bi-person-fill text-primary me-1"></i>{{ $bName }}</strong>
                                            <small class="d-block text-muted"><i class="bi bi-telephone-fill text-success me-1"></i>{{ $bPhone }}</small>
                                            @if(!empty($bAltPhone))
                                                <small class="d-block text-secondary"><i class="bi bi-telephone-plus text-primary me-1"></i>Alt: {{ $bAltPhone }}</small>
                                            @endif
                                            <small class="d-block text-primary"><i class="bi bi-card-heading me-1"></i>{{ $bIdType }}: <strong>{{ $bIdNo }}</strong></small>
                                        </td>
                                        <td>
                                            <strong class="d-block text-dark"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $bRoute }}</strong>
                                            <span class="badge bg-dark mt-1"><i class="bi bi-car-front-fill me-1"></i>{{ $bVehicle }}</span>
                                        </td>
                                        <td>
                                            <strong class="d-block text-success"><i class="bi bi-calendar-event me-1"></i>{{ $bTime }}</strong>
                                            @if($bNight)
                                                <span class="badge badge-gradient-dark text-white text-center d-inline-block py-1 px-2 lh-sm shadow-sm mt-1 border border-primary" style="font-size: 11px;">
                                                    <i class="bi bi-moon-stars-fill text-warning me-1"></i>₹100<br>Night Charge
                                                </span>
                                            @else
                                                <span class="badge bg-light text-muted border text-center d-inline-block py-1 px-2 lh-sm mt-1" style="font-size: 11px;">
                                                    ☀️ Standard<br>Hours
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $bUtr = is_array($booking) ? ($booking['utr_number'] ?? null) : ($booking->utr_number ?? null);
                                                $bPayMode = is_array($booking) ? ($booking['payment_mode'] ?? null) : ($booking->payment_mode ?? null);
                                                $bPayStatus = strtolower(is_array($booking) ? ($booking['payment_status'] ?? 'paid') : ($booking->payment_status ?? 'paid'));
                                                $isPaidStatus = in_array($bPayStatus, ['paid', 'completed', 'success']);
                                                $isFailedStatus = in_array($bPayStatus, ['failed', 'cancelled', 'rejected']);
                                                $numFare = (float)$bFare;
                                            @endphp
                                            @if($numFare > 0)
                                                <strong class="text-success fs-6">₹{{ number_format($numFare, 2) }}</strong>
                                                @if($isPaidStatus)
                                                    <span class="badge bg-success d-block w-auto mt-1"><i class="bi bi-check-circle-fill me-1"></i>Paid</span>
                                                @elseif($isFailedStatus)
                                                    <span class="badge bg-danger d-block w-auto mt-1"><i class="bi bi-x-circle-fill me-1"></i>Payment Failed</span>
                                                @else
                                                    <span class="badge bg-warning text-dark d-block w-auto mt-1"><i class="bi bi-clock-history me-1"></i>Pending UTR Check</span>
                                                @endif
                                                @if(!empty($bUtr))
                                                    <small class="badge badge-silver-gradient d-block mt-1 text-wrap">UTR: {{ $bUtr }}</small>
                                                @elseif(!empty($bPayMode) && str_contains($bPayMode, 'QR'))
                                                    <small class="badge bg-light text-dark border d-block mt-1">PhonePe QR</small>
                                                @endif
                                            @else
                                                <strong class="text-secondary fs-6">Custom Route</strong>
                                                <span class="badge bg-info text-dark d-block w-auto mt-1"><i class="bi bi-chat-quote me-1"></i>Quote Req</span>
                                                <button type="button" class="btn btn-xs btn-outline-success d-block w-100 mt-1 fw-bold" data-bs-toggle="modal" data-bs-target="#viewModal{{ $bId }}" title="Click to Finalize & Enter Agreed Fare" style="font-size: 11px; padding: 2px 4px;">
                                                    <i class="bi bi-plus-circle me-1"></i> Add Fare
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            @if(strtolower($bStatus) === 'dispatched' || !empty($bDriverName))
                                                <span class="badge bg-success mb-1"><i class="bi bi-check2-circle me-1"></i>Dispatched</span>
                                                <small class="d-block text-dark"><strong>Driver:</strong> {{ $bDriverName }}</small>
                                                <small class="d-block text-muted"><strong>Phone:</strong> {{ $bDriverPhone }}</small>
                                                <small class="d-block text-primary"><strong>Vehicle:</strong> {{ $bVehicleNo }}</small>
                                            @else
                                                <span class="badge bg-warning text-dark text-center d-inline-block py-1 px-2 lh-sm shadow-sm" style="font-size: 11px;">
                                                    <i class="bi bi-clock-history me-1"></i>Pending<br>Assignment
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(str_contains($bRawStatus, 'dispatched'))
                                                <span class="badge bg-success shadow-sm"><i class="bi bi-truck-flatbed me-1"></i> Dispatched</span>
                                            @elseif(str_contains(strtolower($bRawStatus), 'whatsapp') || str_contains(strtolower($bRawStatus), 'custom') || str_contains(strtolower($bRawStatus), 'inquiry'))
                                                <span class="badge shadow-sm text-white" style="background-color: #25D366 !important; font-weight: 700;"><i class="bi bi-whatsapp me-1"></i> Custom Inquiry</span>
                                            @elseif(str_contains($bRawStatus, 'confirm') || str_contains($bRawStatus, 'paid'))
                                                <span class="badge bg-success shadow-sm"><i class="bi bi-check-circle-fill me-1"></i> Confirmed</span>
                                            @elseif(str_contains($bRawStatus, 'failed') || str_contains($bRawStatus, 'cancel'))
                                                <span class="badge bg-danger shadow-sm"><i class="bi bi-x-circle-fill me-1"></i> Cancelled</span>
                                            @elseif(str_contains($bRawStatus, 'pending'))
                                                <span class="badge bg-warning text-dark shadow-sm"><i class="bi bi-clock-history me-1"></i> Pending</span>
                                            @else
                                                <span class="badge bg-secondary shadow-sm">{{ ucfirst($bStatus) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div style="display: inline-grid; grid-template-columns: repeat(3, 88px); gap: 4px; vertical-align: middle;">
                                                <!-- Row 1: View, Edit, Delete -->
                                                <button type="button" class="btn btn-sm btn-info text-white fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#viewModal{{ $bId }}" title="View Full Duty Slip Voucher" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-eye me-1"></i> View
                                                </button>

                                                <button type="button" class="btn btn-sm btn-warning text-dark fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#editModal{{ $bId }}" title="Edit Booking Details & Payment Status" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>

                                                <form action="{{ route('admin.cabs.bookings.destroy', $bId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Are you sure you want to permanently delete cab reservation #{{ $bCode }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Delete Booking" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-trash-fill me-1"></i> Delete
                                                    </button>
                                                </form>

                                                <!-- Row 2: Approve, Reject, Driver -->
                                                <form action="{{ route('admin.cabs.bookings.approve', $bId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Approve booking #{{ $bCode }} as PAID? Customer voucher will show verified PAID.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isPaidStatus ? 'btn-outline-success disabled' : 'btn-success' }} fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Approve &amp; Confirm Paid" style="font-size: 11px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.cabs.bookings.reject', $bId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Reject booking #{{ $bCode }}? UTR will be marked FAILED and customer voucher will be rendered VOID.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isFailedStatus ? 'btn-outline-danger disabled' : 'btn-danger' }} fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Reject / Mark Failed (Fake UTR)" style="font-size: 11px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-x-circle-fill me-1"></i> Reject
                                                    </button>
                                                </form>

                                                <button type="button" class="btn btn-sm btn-primary fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#assignDriverModal{{ $bId }}" title="Assign/Update Driver &amp; Vehicle" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-person-plus-fill me-1"></i> Driver
                                                </button>

                                                <!-- Row 3: WhatsApp Full Width across all 3 columns -->
                                                <a href="{{ $waDirectUrl }}" target="_blank" class="btn btn-sm text-white fw-bold d-flex align-items-center justify-content-center shadow-sm m-0" style="grid-column: span 3; width: 100%; height: 28px; font-size: 11.5px; background-color: #25D366; border-color: #25D366; padding: 0 4px;" title="Send Duty Slip to Driver on WhatsApp">
                                                    <i class="bi bi-whatsapp me-1" style="font-size: 13.5px;"></i> WhatsApp Duty Slip
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- VIEW DUTY SLIP VOUCHER MODAL -->
                                    <div class="modal fade" id="viewModal{{ $bId }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered text-start">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title fw-bold">
                                                        <i class="bi bi-car-front-fill me-2 text-warning"></i>Cab Duty Slip: {{ $bCode }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="p-3 mb-3 bg-light rounded border">
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Passenger Name</small>
                                                                <strong class="text-dark">{{ $bName }}</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Phone / WhatsApp</small>
                                                                <strong class="text-success">{{ $bPhone }}</strong>
                                                                @if(!empty($bAltPhone))
                                                                    <small class="d-block text-muted">Alt: {{ $bAltPhone }}</small>
                                                                @endif
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Govt ID Type</small>
                                                                <strong class="text-primary">{{ $bIdType }}</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Govt ID Number</small>
                                                                <strong class="text-primary">{{ $bIdNo }}</strong>
                                                            </div>
                                                            <div class="col-12 mt-1">
                                                                <small class="text-success fw-bold d-block"><i class="bi bi-shield-check me-1"></i>Boarding Rule: Driver must verify original physical ID at boarding.</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="p-3 mb-3 bg-light rounded border">
                                                        <div class="row g-2">
                                                            <div class="col-12">
                                                                <small class="text-muted d-block">Trip Route</small>
                                                                <strong class="text-danger"><i class="bi bi-geo-alt-fill me-1"></i>{{ $bRoute }}</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Vehicle Model</small>
                                                                <span class="badge bg-dark">{{ $bVehicle }}</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Pickup Schedule</small>
                                                                <strong class="text-dark">{{ $bTime }}</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Total Fare Paid</small>
                                                                <strong class="text-success fs-5">₹{{ number_format((float)$bFare, 2) }}</strong>
                                                                @if($bNight)
                                                                    <small class="badge badge-gradient-dark border border-primary px-2 py-0.5 mt-1 d-inline-block" style="font-size: 11px;"><i class="bi bi-moon-stars-fill text-warning me-1"></i> ₹100 Night Surcharge</small>
                                                                @endif
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Current Status</small>
                                                                <span class="badge {{ $isConfirmed ? 'bg-success' : 'bg-warning text-dark' }}">{{ $bStatus }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- FINALIZE / UPDATE CAB FARE & GOVT ID FORM -->
                                                    <div class="p-3 mb-3 bg-light rounded border border-success" style="box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                                                        <form action="{{ route('admin.cabs.bookings.update-amount', $bId) }}" method="POST">
                                                            @csrf
                                                            <label class="form-label fw-bold text-dark mb-2" style="font-size: 12.5px;">
                                                                <i class="bi bi-cash-coin text-success me-1"></i> {{ (float)$bFare > 0 ? 'Update Finalized Fare & Mark Paid:' : 'Finalize Custom Route Fare & Mark as Paid:' }}
                                                            </label>
                                                            <div class="row g-2 mb-2">
                                                                <div class="col-sm-6">
                                                                    <label class="form-label text-muted mb-0 fw-semibold" style="font-size: 11px;">Agreed Fare (₹)*</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-text fw-bold">₹</span>
                                                                        <input type="number" step="0.01" name="amount" class="form-control fw-bold" placeholder="e.g. 2200" value="{{ (float)$bFare > 0 ? (float)$bFare : '' }}" required style="font-size: 13.5px;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label class="form-label text-muted mb-0 fw-semibold" style="font-size: 11px;">Payment Mode*</label>
                                                                    <select name="payment_mode" class="form-select form-select-sm fw-semibold">
                                                                        <option value="SBI UPI / PhonePe" {{ ($bPayMode ?? '') === 'SBI UPI / PhonePe' ? 'selected' : '' }}>SBI UPI / PhonePe</option>
                                                                        <option value="Cash to Driver" {{ ($bPayMode ?? '') === 'Cash to Driver' ? 'selected' : '' }}>Cash to Driver</option>
                                                                        <option value="Direct Online" {{ ($bPayMode ?? '') === 'Direct Online' ? 'selected' : '' }}>Direct Online</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <label class="form-label text-muted mb-0 fw-semibold" style="font-size: 11px;"><i class="bi bi-card-heading text-primary me-1"></i>Passenger Govt ID / Aadhaar No (Optional)</label>
                                                                    <input type="text" name="id_no" class="form-control form-control-sm fw-semibold" placeholder="e.g. 5482 9102 3841" value="{{ (!empty($bIdNo) && strtoupper(trim($bIdNo)) !== 'N/A') ? $bIdNo : '' }}">
                                                                </div>
                                                                <div class="col-sm-4 d-flex align-items-end">
                                                                    <button type="submit" class="btn btn-sm btn-success fw-bold w-100" style="font-size: 12px; height: 31px;">
                                                                        <i class="bi bi-check-circle me-1"></i> Save Details
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <small class="text-muted d-block" style="font-size: 11px;">
                                                            💡 Saving will instantly update the fare and Aadhaar number on the Invoice, Duty Slip & WhatsApp.
                                                            </small>
                                                        </form>
                                                    </div>

                                                    <div class="p-3 mb-3 bg-white rounded border border-success">
                                                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-person-badge me-1"></i>Assigned Duty Driver</h6>
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Driver Name</small>
                                                                <strong>{{ $bDriverName ?: 'Pending Allocation' }}</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Driver Mobile</small>
                                                                <strong>{{ $bDriverPhone ?: 'Pending' }}</strong>
                                                            </div>
                                                            <div class="col-12">
                                                                <small class="text-muted d-block">Car Number Plate</small>
                                                                <strong class="text-primary">{{ $bVehicleNo ?: 'Pending' }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('customer.invoice', ['type' => 'cab', 'id' => $bId]) }}" target="_blank" class="btn btn-primary w-50 fw-bold">
                                                            <i class="bi bi-receipt me-1"></i> View Tax Invoice
                                                        </a>
                                                        <a href="{{ $waDirectUrl }}" target="_blank" class="btn btn-success w-50 fw-bold">
                                                            <i class="bi bi-whatsapp me-1"></i> Duty WhatsApp
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Assign Driver Modal -->
                                    <div class="modal fade" id="assignDriverModal{{ $bId }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.cabs.assign', $bId) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>Assign Driver &amp; Vehicle Duty — {{ $bCode }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3 text-start">
                                                        <div class="col-12 bg-light p-2 rounded border">
                                                            <small class="text-muted d-block">Passenger: <strong>{{ $bName }}</strong> ({{ $bPhone }}{{ !empty($bAltPhone) ? ' / Alt: ' . $bAltPhone : '' }})</small>
                                                            <small class="text-muted d-block">Govt ID: <strong>{{ $bIdType }} ({{ $bIdNo }})</strong></small>
                                                            <small class="text-muted d-block">Route: <strong>{{ $bRoute }}</strong></small>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Driver Full Name*</label>
                                                            <input type="text" name="driver_name" class="form-control" value="{{ $bDriverName }}" placeholder="e.g., Ramesh Kumar" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Driver Mobile / WhatsApp Number*</label>
                                                            <input type="text" name="driver_phone" class="form-control" value="{{ $bDriverPhone }}" placeholder="e.g., 9876543210" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Vehicle Model / Car Name*</label>
                                                            <input type="text" name="vehicle_name" class="form-control" value="{{ is_array($booking) ? ($booking['vehicle_name'] ?? $bVehicle) : ($booking->vehicle_name ?? $bVehicle) }}" placeholder="e.g., Maruti Suzuki Omni (Omni Van)" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Vehicle Number Plate*</label>
                                                            <input type="text" name="vehicle_number" class="form-control" value="{{ $bVehicleNo }}" placeholder="e.g., UP 32 AB 1234" required>
                                                        </div>
                                                        @if($numFare <= 0)
                                                        <div class="col-12 bg-light p-2 rounded border border-success">
                                                            <label class="form-label fw-bold text-success mb-1" style="font-size: 12.5px;">
                                                                <i class="bi bi-cash-stack me-1"></i> Agreed Trip Fare (₹) <span class="badge bg-warning text-dark">Custom Route</span>
                                                            </label>
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text fw-bold">₹</span>
                                                                <input type="number" step="0.01" min="0" name="fare" class="form-control fw-bold" placeholder="e.g. 2500">
                                                            </div>
                                                            <small class="text-muted d-block mt-1" style="font-size: 11px;">Agar yahan agreed fare likhenge to duty slip aur WhatsApp par automatically yeh amount set ho jayega.</small>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary fw-bold">
                                                            <i class="bi bi-whatsapp me-1"></i> Assign Driver &amp; Open Duty Slip
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDIT BOOKING MODAL -->
                                    <div class="modal fade" id="editModal{{ $bId }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content text-start shadow-lg">
                                                <form action="{{ route('admin.cabs.bookings.update', $bId) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header bg-warning text-dark">
                                                        <h5 class="modal-title fw-bold">
                                                            <i class="bi bi-pencil-square me-2"></i>Edit Cab Reservation #{{ $bCode }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <!-- Passenger Details -->
                                                            <div class="col-12">
                                                                <h6 class="fw-bold text-primary mb-2 border-bottom pb-1">
                                                                    <i class="bi bi-person-circle me-1"></i> Passenger Details
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Passenger Full Name *</label>
                                                                <input type="text" name="customer_name" class="form-control" value="{{ $bName }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Mobile Number *</label>
                                                                <input type="text" name="customer_phone" class="form-control" value="{{ $bPhone }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Alternate Mobile Number</label>
                                                                <input type="text" name="alternate_phone" class="form-control" value="{{ $bAltPhone }}" placeholder="Optional">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Customer Email</label>
                                                                <input type="email" name="customer_email" class="form-control" value="{{ is_array($booking) ? ($booking['customer_email'] ?? '') : ($booking->customer_email ?? '') }}" placeholder="e.g. customer@gmail.com">
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold small text-muted">Customer Address (Print on Invoice)</label>
                                                                <input type="text" name="customer_address" class="form-control" value="{{ is_array($booking) ? ($booking['customer_address'] ?? '') : ($booking->customer_address ?? '') }}" placeholder="e.g. Dewa Sharif, Barabanki, UP - 225301">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Govt Approved ID Type</label>
                                                                <select name="id_type" class="form-select">
                                                                    <option value="Aadhaar Card" {{ ($bIdType === 'Aadhaar Card') ? 'selected' : '' }}>Aadhaar Card</option>
                                                                    <option value="PAN Card" {{ ($bIdType === 'PAN Card') ? 'selected' : '' }}>PAN Card</option>
                                                                    <option value="Voter ID Card" {{ ($bIdType === 'Voter ID Card') ? 'selected' : '' }}>Voter ID Card</option>
                                                                    <option value="Driving License" {{ ($bIdType === 'Driving License') ? 'selected' : '' }}>Driving License</option>
                                                                    <option value="Passport" {{ ($bIdType === 'Passport') ? 'selected' : '' }}>Passport</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Govt ID Number</label>
                                                                <input type="text" name="id_no" class="form-control" value="{{ ($bIdNo !== 'N/A') ? $bIdNo : '' }}" placeholder="e.g. 5482 9102 3841">
                                                            </div>

                                                            <!-- Trip & Vehicle Details -->
                                                            <div class="col-12 mt-3">
                                                                <h6 class="fw-bold text-primary mb-2 border-bottom pb-1">
                                                                    <i class="bi bi-car-front-fill me-1"></i> Trip &amp; Vehicle Schedule
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Route (Pickup → Destination)</label>
                                                                <input type="text" name="route" class="form-control" value="{{ $bRoute }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Vehicle Model / Category</label>
                                                                <input type="text" name="vehicle_type" class="form-control" value="{{ $bVehicle }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Pickup Schedule (Date &amp; Time)</label>
                                                                <input type="text" name="pickup_time" class="form-control" value="{{ $bTime }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Total Fare (₹) *</label>
                                                                <input type="number" step="0.01" min="0" name="fare" class="form-control fw-bold text-success fs-6" value="{{ $bFare }}" required>
                                                            </div>

                                                            <!-- Payment & Booking Status (Key Request) -->
                                                            <div class="col-12 mt-3">
                                                                <h6 class="fw-bold text-success mb-2 border-bottom pb-1">
                                                                    <i class="bi bi-credit-card-2-front me-1"></i> Payment &amp; Reservation Status
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Payment Status (Invoice Badge) *</label>
                                                                <select name="payment_status" class="form-select fw-bold {{ $isPaidStatus ? 'border-success text-success' : ($isFailedStatus ? 'border-danger text-danger' : 'border-warning text-dark') }}">
                                                                    <option value="paid" {{ $isPaidStatus ? 'selected' : '' }}>✅ PAID (Mark as Paid &amp; Verified on Voucher)</option>
                                                                    <option value="pending" {{ (!$isPaidStatus && !$isFailedStatus) ? 'selected' : '' }}>⏳ PENDING (Under Bank Settlement Verification)</option>
                                                                    <option value="failed" {{ $isFailedStatus ? 'selected' : '' }}>❌ FAILED / VOID (Fake/Uncredited UTR — Mark Void)</option>
                                                                </select>
                                                                <small class="text-muted d-block mt-1" style="font-size: 11px;">
                                                                    💡 <strong>Failed / Void</strong> select karne se customer ka Tax Invoice Red <strong>PAYMENT FAILED / VOID</strong> ban jayega aur customer ride claim nahi kar payega.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Booking Status *</label>
                                                                <select name="status" class="form-select fw-semibold">
                                                                    <option value="Pending" {{ strtolower($bStatus) === 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="Confirmed &amp; Paid" {{ str_contains(strtolower($bStatus), 'confirm') || str_contains(strtolower($bStatus), 'paid') ? 'selected' : '' }}>Confirmed &amp; Paid</option>
                                                                    <option value="Dispatched" {{ strtolower($bStatus) === 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                                                    <option value="Completed" {{ strtolower($bStatus) === 'completed' ? 'selected' : '' }}>Completed</option>
                                                                    <option value="Cancelled" {{ strtolower($bStatus) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Payment Mode</label>
                                                                <select name="payment_mode" class="form-select">
                                                                    <option value="SBI UPI / PhonePe" {{ ($bPayMode ?? '') === 'SBI UPI / PhonePe' ? 'selected' : '' }}>SBI UPI / PhonePe</option>
                                                                    <option value="Direct Online" {{ ($bPayMode ?? '') === 'Direct Online' ? 'selected' : '' }}>Direct Online (Razorpay)</option>
                                                                    <option value="Cash to Driver" {{ ($bPayMode ?? '') === 'Cash to Driver' ? 'selected' : '' }}>Cash to Driver</option>
                                                                    <option value="WhatsApp Direct" {{ ($bPayMode ?? '') === 'WhatsApp Direct' ? 'selected' : '' }}>WhatsApp Direct</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">UPI / UTR Reference Number</label>
                                                                <input type="text" name="utr_number" class="form-control" value="{{ $bUtr }}" placeholder="e.g. 427819038291 (Optional)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success fw-bold px-4">
                                                            <i class="bi bi-check-circle-fill me-1"></i> Save &amp; Update Booking
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">No cab reservations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
