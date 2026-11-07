@extends('hotel.includes.master')

@section('title', 'Hotel Partner Dashboard')

@section('content')
<div class="row align-items-center mb-4 g-3">
    <div class="col-md-7">
        <h3 class="fw-bold text-dark mb-1">
            🏨 {{ $partner->hotel_name ?: 'Dewa Sharif Guest House' }}
        </h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">
            Welcome, <strong>{{ $partner->name }}</strong>! Real-time guest house occupancy, 80/20 revenue breakdown &amp; payout status.
        </p>
    </div>
    <div class="col-md-5 text-md-end">
        <button class="btn btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#verifyPinModal">
            <i class="bi bi-shield-lock-fill me-1"></i> Verify Guest Check-In PIN
        </button>
        <a href="{{ route('hotel.rooms.create') }}" class="btn btn-success fw-bold shadow-sm ms-2">
            <i class="bi bi-plus-circle me-1"></i> Add Room
        </a>
    </div>
</div>

<!-- TIME RANGE FILTER BAR (All Time / This Week / This Month / This Year) -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div class="d-flex align-items-center gap-1 bg-white p-1 rounded-3 shadow-sm border">
        <span class="text-muted fw-bold px-2" style="font-size: 12px;"><i class="bi bi-funnel me-1"></i>Period:</span>
        <a href="{{ route('hotel.dashboard', ['period' => 'all']) }}" 
           class="btn btn-sm {{ ($period ?? 'all') === 'all' ? 'btn-success fw-bold text-white shadow-sm' : 'btn-light text-muted' }}" 
           style="border-radius: 6px; font-size: 12px; padding: 4px 12px;">
            All Time
        </a>
        <a href="{{ route('hotel.dashboard', ['period' => 'week']) }}" 
           class="btn btn-sm {{ ($period ?? '') === 'week' ? 'btn-success fw-bold text-white shadow-sm' : 'btn-light text-muted' }}" 
           style="border-radius: 6px; font-size: 12px; padding: 4px 12px;">
            This Week (7 Days)
        </a>
        <a href="{{ route('hotel.dashboard', ['period' => 'month']) }}" 
           class="btn btn-sm {{ ($period ?? '') === 'month' ? 'btn-success fw-bold text-white shadow-sm' : 'btn-light text-muted' }}" 
           style="border-radius: 6px; font-size: 12px; padding: 4px 12px;">
            This Month
        </a>
        <a href="{{ route('hotel.dashboard', ['period' => 'year']) }}" 
           class="btn btn-sm {{ ($period ?? '') === 'year' ? 'btn-success fw-bold text-white shadow-sm' : 'btn-light text-muted' }}" 
           style="border-radius: 6px; font-size: 12px; padding: 4px 12px;">
            This Year ({{ date('Y') }})
        </a>
    </div>

    <div class="text-muted" style="font-size: 12.5px;">
        <i class="bi bi-clock-history text-success me-1"></i>
        Metrics for: <strong class="text-dark">{{ $periodLabel ?? 'All Time' }}</strong>
    </div>
</div>

<!-- 4 VIBRANT GRADIENT STAT CARDS (GREEN, YELLOW, BLUE, RED - EQUAL HEIGHT) -->
<div class="row g-3 mb-4 align-items-stretch">
    <!-- Card 1: GREEN (Total Confirmed Bookings - 100% Gross) -->
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="stat-box bg-card-green w-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="stat-label">Total Confirmed Bookings</span>
                <span class="stat-badge">100% Value</span>
            </div>
            <div class="my-auto py-1">
                <h2 class="stat-value">₹{{ number_format($totalGross, 2) }}</h2>
            </div>
            <div class="stat-sub mt-3">
                <i class="bi bi-calendar-check-fill flex-shrink-0"></i>
                <span class="text-truncate">{{ $totalConfirmedBookings }} Stays Booked ({{ $totalCancelledBookings }} Cancelled)</span>
            </div>
        </div>
    </div>

    <!-- Card 2: YELLOW (DewaSharif Platform Fee - 20% Commission) -->
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="stat-box bg-card-yellow w-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="stat-label">DewaSharif Platform Fee</span>
                <span class="stat-badge">20% Commission</span>
            </div>
            <div class="my-auto py-1">
                <h2 class="stat-value">₹{{ number_format($totalPlatform20, 2) }}</h2>
            </div>
            <div class="stat-sub mt-3">
                <i class="bi bi-graph-up-arrow flex-shrink-0"></i>
                <span class="text-truncate">Website hosting, marketing &amp; support</span>
            </div>
        </div>
    </div>

    <!-- Card 3: BLUE (Partner Net Take-Home - 80% Share) -->
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="stat-box bg-card-blue w-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="stat-label">Your Net Earnings</span>
                <span class="stat-badge">80% Net Share</span>
            </div>
            <div class="my-auto py-1">
                <h2 class="stat-value">₹{{ number_format($totalNet80, 2) }}</h2>
            </div>
            <div class="stat-sub mt-3">
                <i class="bi bi-wallet-fill flex-shrink-0"></i>
                <span class="text-truncate">Direct partner take-home revenue</span>
            </div>
        </div>
    </div>

    <!-- Card 4: RED (Current Unpaid Balance - Every 3 Days Payout) -->
    <div class="col-xl-3 col-sm-6 d-flex">
        <div class="stat-box bg-card-red w-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="stat-label">Current Unpaid Balance</span>
                <span class="stat-badge">Every 3 Days Payout</span>
            </div>
            <div class="my-auto py-1">
                <h2 class="stat-value">₹{{ number_format($currentBalance, 2) }}</h2>
            </div>
            <div class="stat-sub mt-3">
                <i class="bi bi-bank2 flex-shrink-0"></i>
                <span class="text-truncate">Settled so far: ₹{{ number_format($totalSettled, 2) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- PAYOUT CYCLE & FINANCIAL CUSTODY NOTICE -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); border-left: 5px solid #10b981 !important;">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-9">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-success fw-bold">Active Payout Cycle: Every 3 Days</span>
                    <strong class="text-dark" style="font-size: 14px;">Direct Bank &amp; UPI Settlement Policy</strong>
                </div>
                <p class="text-muted mb-0" style="font-size: 12.5px; line-height: 1.5;">
                    • <strong>100% Online Security:</strong> Customer pays 100% online directly to DewaSharif Admin (<strong>State Bank of India</strong> | A/C: 21345457115 | IFSC: SBIN0011224 | UPI: 9648777223@ybl). Do NOT collect room rent in cash.<br>
                    • <strong>Every 3 Days Settlements:</strong> In this launch phase, Admin audits check-ins and transfers your 80% balance every 3 days. Once order volume scales, settlements will transition to <em>Every Wednesday</em>.<br>
                    • <strong>Your Registered Payout Destination:</strong> 
                    @if(!empty($partner->bank_name) || !empty($partner->upi_id))
                        <strong>{{ $partner->bank_name }}</strong> (A/C: {{ $partner->account_no ?: 'N/A' }} | IFSC: {{ $partner->ifsc_code ?: 'N/A' }}) {{ $partner->upi_id ? ' | UPI: ' . $partner->upi_id : '' }}
                    @else
                        <span class="text-danger fw-bold">Bank details pending! Please update your Bank/UPI under profile so Admin can transfer your 80% earnings.</span>
                    @endif
                </p>
            </div>
            <div class="col-md-3 text-md-end mt-2 mt-md-0">
                <a href="{{ route('hotel.profile') }}" class="btn btn-sm btn-outline-success fw-bold">
                    <i class="bi bi-bank me-1"></i> Update Bank Details
                </a>
            </div>
        </div>
    </div>
</div>

<!-- RECENT RESERVATIONS TABLE -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center" style="border-radius: 16px 16px 0 0;">
        <div>
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-calendar2-check text-success me-2"></i>Recent Guest Stays</h5>
            <small class="text-muted">Showing latest 5 reservations for {{ $partner->hotel_name }}</small>
        </div>
        <a href="{{ route('hotel.bookings') }}" class="btn btn-sm btn-light fw-bold border">
            View All Bookings <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr style="font-size: 12.5px;">
                        <th>Booking Code</th>
                        <th>Guest Devotee</th>
                        <th>Room Reserved</th>
                        <th>Stay Dates</th>
                        <th>Status &amp; PIN</th>
                        <th>Gross Tariff</th>
                        <th>Your 80% Share</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody style="font-size: 13.5px;">
                    @forelse($recentBookings as $b)
                        @php
                            $bId = is_array($b) ? ($b['id'] ?? 1) : $b->id;
                            $bCode = is_array($b) ? ($b['booking_code'] ?? ($b['booking_number'] ?? 'DWS-HTL-'.$bId)) : ($b->booking_code ?? 'DWS-HTL-'.$bId);
                            $cName = is_array($b) ? ($b['customer_name'] ?? 'Guest Devotee') : ($b->customer_name ?? 'Guest Devotee');
                            $cPhone = is_array($b) ? ($b['customer_phone'] ?? '9648777223') : ($b->customer_phone ?? '9648777223');
                            $rName = is_array($b) ? ($b['room_name'] ?? ($b['room_type'] ?? 'Deluxe Room')) : ($b->room_name ?? 'Deluxe Room');
                            $checkIn = is_array($b) ? ($b['check_in_date'] ?? ($b['check_in'] ?? ($b['checkin'] ?? 'Today'))) : ($b->check_in_date ?? ($b->check_in ?? ($b->checkin ?? 'Today')));
                            $checkOut = is_array($b) ? ($b['check_out_date'] ?? ($b['check_out'] ?? ($b['checkout'] ?? 'Tomorrow'))) : ($b->check_out_date ?? ($b->check_out ?? ($b->checkout ?? 'Tomorrow')));
                            $tot = (float)(is_array($b) ? ($b['total_amount'] ?? ($b['amount'] ?? 0)) : ($b->total_amount ?? ($b->amount ?? 0)));
                            if ($tot <= 0) {
                                $pricePerNight = (float)(is_array($b) ? ($b['price_per_night'] ?? 0) : ($b->price_per_night ?? 0));
                                $nights = (int)(is_array($b) ? ($b['nights'] ?? 1) : ($b->nights ?? 1));
                                $rooms = (int)(is_array($b) ? ($b['rooms'] ?? 1) : ($b->rooms ?? 1));
                                $tot = $pricePerNight > 0 ? ($pricePerNight * max(1, $nights) * max(1, $rooms)) : 1499.00;
                            }
                            $st = strtolower(is_array($b) ? ($b['status'] ?? '') : ($b->status ?? ''));
                            $isCancelled = str_contains($st, 'cancel');
                            $isCheckedIn = str_contains($st, 'checked') || !empty(is_array($b) ? ($b['checkin_verified_at'] ?? null) : ($b->checkin_verified_at ?? null));
                            $pin = is_array($b) ? ($b['checkin_pin'] ?? '4821') : ($b->checkin_pin ?? '4821');

                            $pShare = (float)(is_array($b) ? ($b['hotel_payout_amount'] ?? 0) : ($b->hotel_payout_amount ?? 0));
                            if ($pShare <= 0 && !$isCancelled) {
                                $pShare = round($tot * 0.80, 2);
                            }
                            if ($isCancelled) {
                                $pShare = (float)(is_array($b) ? ($b['cancellation_hotel_share'] ?? 0) : ($b->cancellation_hotel_share ?? 0));
                            }
                        @endphp
                        <tr>
                            <td>
                                <strong class="text-primary">#{{ $bCode }}</strong>
                            </td>
                            <td>
                                <strong class="d-block text-dark">{{ $cName }}</strong>
                                <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $cPhone }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $rName }}</span>
                            </td>
                            <td>
                                <div><small class="text-muted">In:</small> <strong>{{ $checkIn }}</strong></div>
                                <div><small class="text-muted">Out:</small> <strong>{{ $checkOut }}</strong></div>
                            </td>
                            <td>
                                @if($isCancelled)
                                    <span class="badge bg-danger">Cancelled</span>
                                @elseif($isCheckedIn)
                                    <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i>Checked-In</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Expected</span>
                                    <small class="d-block text-muted mt-1">PIN: <strong>{{ $pin }}</strong></small>
                                @endif
                            </td>
                            <td>
                                <strong>₹{{ number_format($tot, 2) }}</strong>
                            </td>
                            <td>
                                <strong class="text-success fs-6">₹{{ number_format($pShare, 2) }}</strong>
                                @if($isCancelled)
                                    <small class="d-block text-muted" style="font-size: 11px;">(Cancel Penalty Share)</small>
                                @else
                                    <small class="d-block text-muted" style="font-size: 11px;">(80% Profit)</small>
                                @endif
                            </td>
                            <td class="text-end">
                                @if(!$isCheckedIn && !$isCancelled)
                                    <button class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="modal" data-bs-target="#verifyPinModal_{{ $bId }}">
                                        Verify PIN
                                    </button>
                                @else
                                    <span class="badge bg-light text-muted border">Completed</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal for this booking -->
                        <div class="modal fade" id="verifyPinModal_{{ $bId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content" style="border-radius: 16px;">
                                    <div class="modal-header bg-primary text-white">
                                        <h6 class="modal-title fw-bold mb-0">Check-In PIN Verification</h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('hotel.bookings.verify-pin', $bId) }}" method="POST">
                                        @csrf
                                        <div class="modal-body text-center p-4">
                                            <p class="text-muted mb-2" style="font-size: 13px;">Ask guest for 4-digit PIN on their booking voucher:</p>
                                            <input type="text" name="pin" class="form-control text-center fw-bold fs-3 mb-3" placeholder="••••" maxlength="4" style="letter-spacing: 8px;" required autofocus>
                                            <button type="submit" class="btn btn-success fw-bold w-100">
                                                Confirm Check-In
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                No room reservations found yet. Ensure your rooms are active to receive pilgrims!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- GLOBAL PIN VERIFICATION MODAL -->
<div class="modal fade" id="verifyPinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold mb-0"><i class="bi bi-shield-lock-fill text-warning me-2"></i>Verify Guest Voucher PIN</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted" style="font-size: 13.5px;">
                    Enter the 4-digit PIN printed on the customer's DewaSharif voucher to confirm check-in and unlock instant settlement.
                </p>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Select Guest Stay</label>
                    <select class="form-select" id="globalModalBookingSelect">
                        @foreach($hotelBookings as $b)
                            @php
                                $mId = is_array($b) ? ($b['id'] ?? 1) : $b->id;
                                $mName = is_array($b) ? ($b['customer_name'] ?? 'Guest') : ($b->customer_name ?? 'Guest');
                                $mRoom = is_array($b) ? ($b['room_name'] ?? 'Room') : ($b->room_name ?? 'Room');
                            @endphp
                            <option value="{{ $mId }}">{{ $mName }} — {{ $mRoom }} (#{{ $mId }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" id="globalPinInput" class="form-control text-center fw-bold fs-2" placeholder="••••" maxlength="4" style="letter-spacing: 10px;">
                </div>
                <button type="button" class="btn btn-success fw-bold w-100 py-2" onclick="submitGlobalPin()">
                    Verify &amp; Handover Room
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function submitGlobalPin() {
        const bookingId = document.getElementById('globalModalBookingSelect').value;
        const pin = document.getElementById('globalPinInput').value;
        if (!pin || pin.length !== 4) {
            alert('Please enter a 4-digit PIN.');
            return;
        }
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/hotel/bookings/' + bookingId + '/verify-pin';
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        const pinInput = document.createElement('input');
        pinInput.type = 'hidden';
        pinInput.name = 'pin';
        pinInput.value = pin;
        form.appendChild(pinInput);
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection
