@extends('admin.includes.master')

@section('title', 'Hotel Bookings | DewaSharif Admin')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="bi bi-calendar-check text-warning me-2"></i>Hotel Customer Reservations</h3>
                    <small class="text-muted">Manage guest house stays, bookings, verification &amp; check-in status</small>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-outline-dark fw-bold">
                        <i class="bi bi-building me-1"></i> Manage Hotel Rooms
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-list-stars me-2 text-warning"></i>All Hotel Reservations ({{ count($bookings) }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Guest Info</th>
                                    <th>Hotel &amp; Room</th>
                                    <th>Check-In / Out</th>
                                    <th>Duration &amp; Guests</th>
                                    <th>Tariff / Amount</th>
                                    <th>Status</th>
                                    <th class="text-end" style="min-width: 275px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    @php
                                        $bId = is_array($booking) ? ($booking['id'] ?? 1) : $booking->id;
                                        $bCode = is_array($booking) ? ($booking['booking_code'] ?? ($booking['booking_number'] ?? ('DWS-HTL-' . $bId))) : ($booking->booking_code ?? ('DWS-HTL-' . $bId));
                                        $cName = is_array($booking) ? ($booking['customer_name'] ?? 'Guest User') : ($booking->customer_name ?? 'Guest User');
                                        $cPhone = is_array($booking) ? ($booking['customer_phone'] ?? '9648777223') : ($booking->customer_phone ?? '9648777223');
                                        $cAltPhone = is_array($booking) ? ($booking['alternate_phone'] ?? null) : ($booking->alternate_phone ?? null);
                                        $cEmail = is_array($booking) ? ($booking['customer_email'] ?? ($booking['email'] ?? '')) : ($booking->customer_email ?? ($booking->email ?? ''));
                                        $cAddress = is_array($booking) ? ($booking['customer_address'] ?? ($booking['address'] ?? '')) : ($booking->customer_address ?? ($booking->address ?? ''));
                                        $hName = is_array($booking) ? ($booking['hotel_name'] ?? 'Al-Waris Deluxe Guest House') : ($booking->hotel_name ?? 'Al-Waris Deluxe Guest House');
                                        $rName = is_array($booking) ? ($booking['room_name'] ?? ($booking['room_type'] ?? 'Deluxe AC Room')) : ($booking->room_name ?? 'Deluxe AC Room');
                                        $checkIn = is_array($booking) ? ($booking['check_in'] ?? ($booking['checkin'] ?? 'N/A')) : ($booking->check_in ?? 'N/A');
                                        $checkOut = is_array($booking) ? ($booking['check_out'] ?? ($booking['checkout'] ?? 'N/A')) : ($booking->check_out ?? 'N/A');
                                        $totAmt = (float)(is_array($booking) ? ($booking['total_amount'] ?? ($booking['amount'] ?? ($booking['total_price'] ?? 1499))) : ($booking->total_amount ?? 1499));
                                        $nights = (int)(is_array($booking) ? ($booking['nights'] ?? 1) : ($booking->nights ?? 1));
                                        $persons = (int)(is_array($booking) ? ($booking['persons'] ?? ($booking['guests'] ?? 2)) : ($booking->persons ?? 2));
                                        $roomsCount = (int)(is_array($booking) ? ($booking['rooms'] ?? 1) : ($booking->rooms ?? 1));
                                        $idType = is_array($booking) ? ($booking['id_type'] ?? 'Aadhaar Card') : ($booking->id_type ?? 'Aadhaar Card');
                                        $idNo = is_array($booking) ? ($booking['id_no'] ?? 'N/A') : ($booking->id_no ?? 'N/A');
                                        $payId = is_array($booking) ? ($booking['payment_id'] ?? 'RZP_DIRECT') : ($booking->payment_id ?? 'RZP_DIRECT');
                                        $bRawStatus = is_array($booking) ? ($booking['status'] ?? 'Pending Approval') : ($booking->status ?? 'Pending Approval');
                                        $bStatusLower = strtolower($bRawStatus);
                                        $isConfirmed = str_contains($bStatusLower, 'confirm') || str_contains($bStatusLower, 'paid');
                                        $bUtr = is_array($booking) ? ($booking['utr_number'] ?? null) : ($booking->utr_number ?? null);
                                        $bPayMode = is_array($booking) ? ($booking['payment_mode'] ?? null) : ($booking->payment_mode ?? null);
                                        $bPayGateway = is_array($booking) ? ($booking['payment_gateway'] ?? null) : ($booking->payment_gateway ?? null);
                                        $bPayStatus = strtolower(is_array($booking) ? ($booking['payment_status'] ?? 'paid') : ($booking->payment_status ?? 'paid'));
                                        $isPaidStatus = in_array($bPayStatus, ['paid', 'completed', 'success']);

                                        $rawBookingAmenities = is_array($booking) ? ($booking['amenities'] ?? ($booking['amenities_list'] ?? null)) : ($booking->amenities ?? null);
                                        if ($rawBookingAmenities === null) {
                                            $rawBookingAmenities = ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Air Conditioner', 'CCTV Security'];
                                        } elseif (is_string($rawBookingAmenities)) {
                                            $rawBookingAmenities = explode(',', $rawBookingAmenities);
                                        }
                                        $bAmenitiesList = array_values(array_filter(array_map('trim', (array)$rawBookingAmenities)));

                                        $cleanGuestPhone = preg_replace('/[^0-9]/', '', $cPhone);
                                        if (strlen($cleanGuestPhone) === 10) {
                                            $cleanGuestPhone = '91' . $cleanGuestPhone;
                                        }
                                        $waHotelMsg = "🎉 *DEWA SHARIF HOTEL RESERVATION " . ($isConfirmed ? 'CONFIRMED' : 'UPDATE') . "*\n\n" .
                                                      "🎫 *Booking ID:* {$bCode}\n" .
                                                      "👤 *Guest Name:* {$cName}\n" .
                                                      "🏨 *Hotel:* {$hName}\n" .
                                                      "🛏️ *Room:* {$rName}\n" .
                                                      "📅 *Check-In:* {$checkIn}\n" .
                                                      "📅 *Check-Out:* {$checkOut} ({$nights} Night)\n" .
                                                      "💰 *Amount " . ($isPaidStatus ? "Paid" : "Due / Pending") . ":* ₹" . number_format($totAmt, 2) . "\n\n" .
                                                      "⚠️ *Check-in Notice:* Hotel reception desk par original physical {$idType} verify karwana anivarya hai.\n\n" .
                                                      "📄 *Tax Invoice PDF Voucher:* " . route('customer.invoice', ['type' => 'hotel', 'id' => $bId]) . "\n\n" .
                                                      "Wish you a blessed & comfortable stay at Dewa Sharif!";
                                        $waGuestUrl = "https://wa.me/{$cleanGuestPhone}?text=" . urlencode($waHotelMsg);
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $bCode }}</strong>
                                            <br><small class="text-muted">#ID: {{ $bId }}</small>
                                        </td>
                                        <td>
                                            <strong class="d-block text-dark">{{ $cName }}</strong>
                                            <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $cPhone }}</small>
                                            @if(!empty($cAltPhone))
                                                <small class="d-block text-secondary"><i class="bi bi-telephone-plus text-primary me-1"></i>Alt: {{ $cAltPhone }}</small>
                                            @endif
                                            @if(!empty($cEmail))
                                                <small class="d-block text-muted text-truncate" style="max-width: 170px;"><i class="bi bi-envelope me-1"></i>{{ $cEmail }}</small>
                                            @endif
                                            <small class="d-block text-primary"><i class="bi bi-card-heading me-1"></i>{{ $idType }}: <strong>{{ $idNo }}</strong></small>
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $hName }}</strong>
                                            <br><span class="badge bg-light text-dark border">{{ $rName }}</span>
                                        </td>
                                        <td>
                                            <small class="d-block text-success fw-bold"><i class="bi bi-box-arrow-in-right me-1"></i>In: {{ $checkIn }}</small>
                                            <small class="d-block text-danger fw-bold"><i class="bi bi-box-arrow-right me-1"></i>Out: {{ $checkOut }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $nights }} Night(s)</span>
                                            <span class="badge bg-info text-dark">👥 {{ $persons }} Guests</span>
                                            @if($roomsCount > 1)
                                                <span class="badge bg-light text-dark border d-block mt-1">🚪 {{ $roomsCount }} Rooms</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $isFailedStatus = in_array($bPayStatus, ['failed', 'cancelled', 'rejected']);
                                            @endphp
                                            @if($totAmt > 0)
                                                <strong class="text-success fs-6">₹{{ number_format($totAmt, 2) }}</strong>
                                                @if($isPaidStatus)
                                                    <span class="badge bg-success d-block w-auto mt-1"><i class="bi bi-check-circle-fill me-1"></i>Paid</span>
                                                @elseif($isFailedStatus)
                                                    <span class="badge bg-danger d-block w-auto mt-1"><i class="bi bi-x-circle-fill me-1"></i>Payment Failed</span>
                                                @else
                                                    <span class="badge bg-warning text-dark d-block w-auto mt-1"><i class="bi bi-clock-history me-1"></i>Pending UTR Check</span>
                                                @endif
                                                @if(!empty($bUtr))
                                                    <small class="badge d-block mt-1 text-wrap" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 45%, #e2e8f0 75%, #cbd5e1 100%) !important; color: #0f172a !important; border: 1px solid #94a3b8 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); font-family: monospace; font-size: 10.5px; font-weight: 700;">UTR: {{ $bUtr }}</small>
                                                @elseif(!empty($bPayMode) && str_contains($bPayMode, 'QR'))
                                                    <small class="badge bg-light text-dark border d-block mt-1">PhonePe QR</small>
                                                @endif
                                            @else
                                                <strong class="text-secondary fs-6">Custom Stay</strong>
                                                <span class="badge bg-info text-dark d-block w-auto mt-1"><i class="bi bi-chat-quote me-1"></i>Quote Req</span>
                                                <button type="button" class="btn btn-xs btn-outline-success d-block w-100 mt-1 fw-bold" data-bs-toggle="modal" data-bs-target="#editModal{{ $bId }}" title="Click to Finalize & Enter Agreed Amount" style="font-size: 11px; padding: 2px 4px;">
                                                    <i class="bi bi-plus-circle me-1"></i> Add Fare
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($isPaidStatus || $isConfirmed)
                                                <span class="badge bg-success text-center d-inline-block py-1 px-2 lh-sm shadow-sm" style="font-size: 11px;">
                                                    <i class="bi bi-check-circle-fill me-1"></i>Confirmed<br>&amp; Paid
                                                </span>
                                            @elseif($isFailedStatus)
                                                <span class="badge bg-danger text-center d-inline-block py-1 px-2 lh-sm shadow-sm" style="font-size: 11px;">
                                                    <i class="bi bi-x-circle-fill me-1"></i>Cancelled<br>&amp; Failed
                                                </span>
                                            @elseif(str_contains($bStatusLower, 'whatsapp') || str_contains($bStatusLower, 'custom') || str_contains($bStatusLower, 'inquiry'))
                                                <span class="badge shadow-sm text-white text-center d-inline-block py-1 px-2 lh-sm" style="background-color: #25D366 !important; font-weight: 700; font-size: 11px;">
                                                    <i class="bi bi-whatsapp me-1"></i>Custom<br>Inquiry
                                                </span>
                                            @elseif(str_contains($bStatusLower, 'pending'))
                                                <span class="badge bg-warning text-dark text-center d-inline-block py-1 px-2 lh-sm shadow-sm" style="font-size: 11px;">
                                                    <i class="bi bi-clock-history me-1"></i>Pending<br>Approval
                                                </span>
                                            @else
                                                <span class="badge bg-secondary shadow-sm text-center d-inline-block py-1 px-2 lh-sm" style="font-size: 11px;">{{ ucfirst($bRawStatus) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div style="display: inline-grid; grid-template-columns: repeat(3, 88px); gap: 4px; vertical-align: middle;">
                                                <!-- Row 1: View, Edit, Delete -->
                                                <button type="button" class="btn btn-sm btn-info text-white fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#viewModal{{ $bId }}" title="View Full Reservation Voucher" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-eye me-1"></i> View
                                                </button>

                                                <button type="button" class="btn btn-sm btn-warning text-dark fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#editModal{{ $bId }}" title="Edit Booking Details & Payment Status" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>

                                                <form action="{{ route('admin.hotels.bookings.destroy', $bId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Are you sure you want to permanently delete hotel reservation #{{ $bCode }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Delete Reservation Record" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-trash-fill me-1"></i> Delete
                                                    </button>
                                                </form>

                                                <!-- Row 2: Approve (1-click), Reject (1-click), Invoice -->
                                                <form action="{{ route('admin.hotels.bookings.approve', $bId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Approve hotel booking #{{ $bCode }} as PAID? Customer voucher will show verified PAID.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isPaidStatus ? 'btn-outline-success disabled' : 'btn-success' }} fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Approve & Confirm Paid" style="font-size: 11px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.hotels.bookings.reject', $bId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Reject hotel booking #{{ $bCode }}? UTR will be marked FAILED and stay voucher will be rendered VOID.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isFailedStatus ? 'btn-outline-danger disabled' : 'btn-danger' }} fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Reject / Mark Failed (Fake UTR)" style="font-size: 11px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-x-circle-fill me-1"></i> Reject
                                                    </button>
                                                </form>

                                                <a href="{{ route('customer.invoice', ['type' => 'hotel', 'id' => $bId]) }}" target="_blank" class="btn btn-sm btn-primary fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" title="View Tax Invoice Voucher" style="font-size: 11px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Invoice
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- VIEW BOOKING DETAILS MODAL -->
                                    <div class="modal fade" id="viewModal{{ $bId }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered text-start">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title fw-bold">
                                                        <i class="bi bi-building me-2 text-warning"></i>Reservation Voucher: {{ $bCode }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="p-3 mb-3 bg-light rounded border">
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Booking Reference:</small>
                                                                <strong>{{ $bCode }}</strong>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <small class="text-muted d-block">Booking Status:</small>
                                                                <span class="badge {{ $isConfirmed ? 'bg-success' : 'bg-warning text-dark' }}">{{ $bRawStatus }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">👤 Guest Information</h6>
                                                    <p class="mb-1"><strong>Name:</strong> {{ $cName }}</p>
                                                    <p class="mb-1"><strong>Phone:</strong> {{ $cPhone }}</p>
                                                    @if(!empty($cAltPhone))
                                                        <p class="mb-1"><strong>Alternate Contact:</strong> {{ $cAltPhone }}</p>
                                                    @endif
                                                    @if(!empty($cEmail))
                                                        <p class="mb-1"><strong>Email:</strong> {{ $cEmail }}</p>
                                                    @endif
                                                    @if(!empty($cAddress))
                                                        <p class="mb-1"><strong>Address:</strong> {{ $cAddress }}</p>
                                                    @endif
                                                    <p class="mb-2"><strong>Govt ID:</strong> <span class="badge bg-secondary">{{ $idType }}</span> {{ $idNo }}</p>
                                                    <div class="p-2 mb-3 bg-light border border-success rounded text-success" style="font-size: 11.5px; font-weight: 600;">
                                                        <i class="bi bi-shield-check me-1"></i> <strong>Reception Rule:</strong> Verify guest's original physical {{ $idType }} prior to room check-in.
                                                    </div>

                                                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">🏨 Hotel &amp; Room Reserved</h6>
                                                    <p class="mb-1"><strong>Hotel:</strong> {{ $hName }}</p>
                                                    <p class="mb-1"><strong>Room Type:</strong> {{ $rName }}</p>
                                                    <p class="mb-1"><strong>Check-In Date:</strong> <span class="text-success fw-bold">{{ $checkIn }}</span></p>
                                                    <p class="mb-1"><strong>Check-Out Date:</strong> <span class="text-danger fw-bold">{{ $checkOut }}</span></p>
                                                    <p class="mb-2"><strong>Stay Duration:</strong> {{ $nights }} Night(s) for {{ $persons }} Guest(s) ({{ $roomsCount }} Room{{ $roomsCount > 1 ? 's' : '' }})</p>
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-1"><strong>Included Amenities:</strong></small>
                                                        @forelse($bAmenitiesList as $am)
                                                            <span class="badge bg-light text-dark border me-1 mb-1"><i class="bi bi-check2 text-success me-1"></i>{{ $am }}</span>
                                                        @empty
                                                            <span class="text-muted small">None specified</span>
                                                        @endforelse
                                                    </div>

                                                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">💳 Payment &amp; Tariff Summary</h6>
                                                    
                                                    <!-- FINALIZE / UPDATE AMOUNT & GOVT ID FORM -->
                                                    <div class="p-3 mb-3 bg-light rounded border border-success" style="box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                                                        <form action="{{ route('admin.hotels.bookings.update-amount', $bId) }}" method="POST">
                                                            @csrf
                                                            <label class="form-label fw-bold text-dark mb-2" style="font-size: 12.5px;">
                                                                <i class="bi bi-cash-coin text-success me-1"></i> {{ $totAmt > 0 ? 'Update Finalized Fare & Mark Paid:' : 'Finalize Custom Stay Fare & Mark as Paid:' }}
                                                            </label>
                                                            <div class="row g-2 mb-2">
                                                                <div class="col-sm-6">
                                                                    <label class="form-label text-muted mb-0 fw-semibold" style="font-size: 11px;">Agreed Amount (₹)*</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-text fw-bold">₹</span>
                                                                        <input type="number" step="0.01" name="amount" class="form-control fw-bold" placeholder="e.g. 3500" value="{{ $totAmt > 0 ? $totAmt : '' }}" required style="font-size: 13.5px;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label class="form-label text-muted mb-0 fw-semibold" style="font-size: 11px;">Payment Mode*</label>
                                                                    <select name="payment_mode" class="form-select form-select-sm fw-semibold">
                                                                        <option value="SBI UPI / PhonePe" {{ ($bPayMode ?? '') === 'SBI UPI / PhonePe' ? 'selected' : '' }}>SBI UPI / PhonePe</option>
                                                                        <option value="Cash at Check-in" {{ ($bPayMode ?? '') === 'Cash at Check-in' ? 'selected' : '' }}>Cash at Check-in</option>
                                                                        <option value="Direct Online" {{ ($bPayMode ?? '') === 'Direct Online' ? 'selected' : '' }}>Direct Online</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <label class="form-label text-muted mb-0 fw-semibold" style="font-size: 11px;"><i class="bi bi-card-heading text-primary me-1"></i>Guest Govt ID / Aadhaar No (Optional)</label>
                                                                    <input type="text" name="id_no" class="form-control form-control-sm fw-semibold" placeholder="e.g. 5482 9102 3841" value="{{ (!empty($idNo) && strtoupper(trim($idNo)) !== 'N/A') ? $idNo : '' }}">
                                                                </div>
                                                                <div class="col-sm-4 d-flex align-items-end">
                                                                    <button type="submit" class="btn btn-sm btn-success fw-bold w-100" style="font-size: 12px; height: 31px;">
                                                                        <i class="bi bi-check-circle me-1"></i> Save Details
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <small class="text-muted d-block" style="font-size: 11px;">
                                                            💡 Save karte hi Tax Invoice aur WhatsApp confirmation link par amount aur Aadhaar number update ho jayega.
                                                            </small>
                                                        </form>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>Total Tariff Amount:</span>
                                                        <strong class="text-success fs-5">₹{{ number_format($totAmt, 2) }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>Payment Status:</span>
                                                        @if($isPaidStatus)
                                                            <span class="badge bg-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i>PAID</span>
                                                        @else
                                                            <span class="badge bg-danger fw-bold"><i class="bi bi-exclamation-circle-fill me-1"></i>UNPAID / PENDING</span>
                                                        @endif
                                                    </div>
                                                    @if(!empty($bUtr))
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>UPI / UTR Ref No:</span>
                                                        <span class="badge bg-warning text-dark font-monospace fs-6">{{ $bUtr }}</span>
                                                    </div>
                                                    @endif
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>Payment Gateway / ID:</span>
                                                        <code>{{ $payId }}</code>
                                                    </div>
                                                    @if(!empty($bPayMode))
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>Payment Mode:</span>
                                                        <span class="badge bg-light text-dark border">{{ $bPayMode }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-warning fw-bold text-dark me-auto" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editModal{{ $bId }}">
                                                        <i class="bi bi-pencil-square me-1"></i> Edit All Details
                                                    </button>
                                                    <a href="{{ route('customer.invoice', ['type' => 'hotel', 'id' => $bId]) }}" target="_blank" class="btn btn-primary fw-bold">
                                                        <i class="bi bi-file-earmark-pdf me-1"></i> Open Tax Invoice
                                                    </a>
                                                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDIT HOTEL RESERVATION MODAL -->
                                    <div class="modal fade" id="editModal{{ $bId }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content text-start shadow-lg">
                                                <form action="{{ route('admin.hotels.bookings.update', $bId) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header bg-warning text-dark">
                                                        <h5 class="modal-title fw-bold">
                                                            <i class="bi bi-pencil-square me-2"></i>Edit Hotel Reservation #{{ $bCode }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <!-- Guest Details -->
                                                            <div class="col-12">
                                                                <h6 class="fw-bold text-primary mb-2 border-bottom pb-1">
                                                                    <i class="bi bi-person-circle me-1"></i> Guest Details
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Guest Full Name *</label>
                                                                <input type="text" name="customer_name" class="form-control" value="{{ $cName }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Mobile Number *</label>
                                                                <input type="text" name="customer_phone" class="form-control" value="{{ $cPhone }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Alternate Mobile Number</label>
                                                                <input type="text" name="alternate_phone" class="form-control" value="{{ $cAltPhone }}" placeholder="Optional">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Guest Email</label>
                                                                <input type="email" name="customer_email" class="form-control" value="{{ $cEmail }}" placeholder="e.g. guest@gmail.com">
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold small text-muted">Guest Address (Print on Tax Invoice)</label>
                                                                <input type="text" name="customer_address" class="form-control" value="{{ $cAddress }}" placeholder="e.g. Dewa Sharif, Barabanki, UP - 225301">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Govt Approved ID Type</label>
                                                                <select name="id_type" class="form-select">
                                                                    <option value="Aadhaar Card" {{ ($idType === 'Aadhaar Card') ? 'selected' : '' }}>Aadhaar Card</option>
                                                                    <option value="PAN Card" {{ ($idType === 'PAN Card') ? 'selected' : '' }}>PAN Card</option>
                                                                    <option value="Voter ID Card" {{ ($idType === 'Voter ID Card') ? 'selected' : '' }}>Voter ID Card</option>
                                                                    <option value="Driving License" {{ ($idType === 'Driving License') ? 'selected' : '' }}>Driving License</option>
                                                                    <option value="Passport" {{ ($idType === 'Passport') ? 'selected' : '' }}>Passport</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Govt ID Number</label>
                                                                <input type="text" name="id_no" class="form-control" value="{{ (!empty($idNo) && strtoupper(trim($idNo)) !== 'N/A') ? $idNo : '' }}" placeholder="e.g. 5482 9102 3841">
                                                            </div>

                                                            <!-- Hotel & Stay Schedule -->
                                                            <div class="col-12 mt-3">
                                                                <h6 class="fw-bold text-primary mb-2 border-bottom pb-1">
                                                                    <i class="bi bi-building me-1"></i> Hotel &amp; Stay Schedule
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Hotel Name *</label>
                                                                <input type="text" name="hotel_name" class="form-control" value="{{ $hName }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Room Type / Category *</label>
                                                                <input type="text" name="room_name" class="form-control" value="{{ $rName }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Check-In Date *</label>
                                                                <input type="text" name="check_in" class="form-control" value="{{ $checkIn }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Check-Out Date *</label>
                                                                <input type="text" name="check_out" class="form-control" value="{{ $checkOut }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Number of Guests (Persons)</label>
                                                                <input type="number" min="1" name="persons" class="form-control" value="{{ $persons }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Number of Rooms</label>
                                                                <input type="number" min="1" name="rooms" class="form-control" value="{{ $roomsCount }}" required>
                                                            </div>

                                                            <!-- Included Amenities (Tax Invoice & Voucher sync) -->
                                                            <div class="col-12 mt-3">
                                                                <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-2">
                                                                    <h6 class="fw-bold text-primary mb-0">
                                                                        <i class="bi bi-stars me-1 text-warning"></i> Included Amenities (Tax Invoice &amp; Voucher)
                                                                    </h6>
                                                                    <small class="text-muted">Check / Uncheck to add or remove on PDF bill</small>
                                                                </div>
                                                                <div class="p-3 bg-light rounded border">
                                                                    <div class="row g-2">
                                                                        @php
                                                                            $allPresetAmenities = [
                                                                                '24/7 Power Backup',
                                                                                'Free Wi-Fi',
                                                                                'Geyser/Hot Water',
                                                                                'Air Conditioner',
                                                                                'CCTV Security',
                                                                                'Attached Washroom',
                                                                                'LED TV',
                                                                                'Breakfast Included',
                                                                                'Room Service',
                                                                                'Electric Kettle',
                                                                                'Elevator/Lift'
                                                                            ];
                                                                        @endphp
                                                                        @foreach($allPresetAmenities as $amItem)
                                                                            <div class="col-md-4 col-sm-6">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amItem }}" id="am_{{ $bId }}_{{ Str::slug($amItem) }}" {{ in_array($amItem, $bAmenitiesList) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label small fw-semibold text-dark" for="am_{{ $bId }}_{{ Str::slug($amItem) }}">
                                                                                        {{ $amItem }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="mt-3 pt-2 border-top">
                                                                        <label class="form-label small text-muted mb-1 fw-bold">
                                                                            <i class="bi bi-plus-circle-fill text-success me-1"></i> Add Custom / Other Amenity:
                                                                        </label>
                                                                        <input type="text" name="custom_amenity" class="form-control form-control-sm" placeholder="e.g. Extra Bedding, Garden View, Balcony">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Payment & Booking Status (Key Request) -->
                                                            <div class="col-12 mt-3">
                                                                <h6 class="fw-bold text-success mb-2 border-bottom pb-1">
                                                                    <i class="bi bi-credit-card-2-front me-1"></i> Payment &amp; Reservation Status
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Total Stay Tariff / Amount (₹) *</label>
                                                                <input type="number" step="0.01" min="0" name="total_amount" class="form-control fw-bold text-success fs-6" value="{{ $totAmt }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Payment Status (Invoice Badge) *</label>
                                                                <select name="payment_status" class="form-select fw-bold {{ $isPaidStatus ? 'border-success text-success' : ($isFailedStatus ? 'border-danger text-danger' : 'border-warning text-dark') }}">
                                                                    <option value="paid" {{ $isPaidStatus ? 'selected' : '' }}>✅ PAID (Mark as Paid &amp; Verified on Voucher)</option>
                                                                    <option value="pending" {{ (!$isPaidStatus && !$isFailedStatus) ? 'selected' : '' }}>⏳ PENDING (Under Bank Settlement Verification)</option>
                                                                    <option value="failed" {{ $isFailedStatus ? 'selected' : '' }}>❌ FAILED / VOID (Fake/Uncredited UTR — Mark Void)</option>
                                                                </select>
                                                                <small class="text-muted d-block mt-1" style="font-size: 11px;">
                                                                    💡 <strong>Failed / Void</strong> select karne se guest ka stay voucher Red <strong>PAYMENT FAILED / VOID</strong> ban jayega.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Booking Status *</label>
                                                                <select name="status" class="form-select fw-semibold">
                                                                    <option value="Pending Approval" {{ str_contains($bStatusLower, 'pending') ? 'selected' : '' }}>Pending Approval</option>
                                                                    <option value="Confirmed &amp; Paid" {{ $isConfirmed ? 'selected' : '' }}>Confirmed &amp; Paid</option>
                                                                    <option value="Checked-in" {{ str_contains($bStatusLower, 'checked-in') ? 'selected' : '' }}>Checked-in</option>
                                                                    <option value="Completed" {{ str_contains($bStatusLower, 'completed') ? 'selected' : '' }}>Completed</option>
                                                                    <option value="Cancelled" {{ str_contains($bStatusLower, 'cancel') ? 'selected' : '' }}>Cancelled</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">Payment Mode</label>
                                                                <select name="payment_mode" class="form-select">
                                                                    <option value="SBI UPI / PhonePe" {{ ($bPayMode ?? '') === 'SBI UPI / PhonePe' ? 'selected' : '' }}>SBI UPI / PhonePe</option>
                                                                    <option value="Cash at Check-in" {{ ($bPayMode ?? '') === 'Cash at Check-in' ? 'selected' : '' }}>Cash at Check-in</option>
                                                                    <option value="Direct Online" {{ ($bPayMode ?? '') === 'Direct Online' ? 'selected' : '' }}>Direct Online (Razorpay)</option>
                                                                    <option value="WhatsApp Direct" {{ ($bPayMode ?? '') === 'WhatsApp Direct' ? 'selected' : '' }}>WhatsApp Direct</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold small text-muted">UPI / UTR Reference Number</label>
                                                                <input type="text" name="utr_number" class="form-control" value="{{ $bUtr }}" placeholder="e.g. 427819038291 (Optional)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-warning fw-bold text-dark">
                                                            <i class="bi bi-check-circle-fill me-1"></i> Update Reservation &amp; Sync Invoice
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">No hotel reservations found in the database.</td>
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
