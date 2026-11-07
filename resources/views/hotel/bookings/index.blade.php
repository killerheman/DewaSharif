@extends('hotel.includes.master')

@section('title', 'Guest Reservations & Bookings')

@section('content')
<div class="row align-items-center mb-4 g-3">
    <div class="col-md-7">
        <h3 class="fw-bold text-dark mb-1">
            📅 Guest Reservations &amp; Check-In Desk
        </h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">
            Verify guest check-in PINs, track online paid stays &amp; view your 80% payout shares.
        </p>
    </div>
    <div class="col-md-5 text-md-end">
        <span class="badge bg-success bg-opacity-10 text-success fs-6 px-3 py-2 border border-success">
            <i class="bi bi-shield-check me-1"></i> Paid Online to DewaSharif
        </span>
    </div>
</div>

<!-- FILTER PILLS -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-body p-2 d-flex gap-2 flex-wrap align-items-center">
        <span class="text-muted fw-bold ms-2 me-1" style="font-size: 12.5px;">Filter Status:</span>
        <a href="{{ route('hotel.bookings') }}" class="btn btn-sm {{ empty($filter) ? 'btn-dark' : 'btn-light border' }}" style="border-radius: 8px;">
            All ({{ count($bookings) }})
        </a>
        <a href="{{ route('hotel.bookings', ['status' => 'confirmed']) }}" class="btn btn-sm {{ $filter === 'confirmed' ? 'btn-primary' : 'btn-light border' }}" style="border-radius: 8px;">
            Confirmed &amp; Upcoming
        </a>
        <a href="{{ route('hotel.bookings', ['status' => 'checked']) }}" class="btn btn-sm {{ $filter === 'checked' ? 'btn-success' : 'btn-light border' }}" style="border-radius: 8px;">
            Checked-In (Verified)
        </a>
        <a href="{{ route('hotel.bookings', ['status' => 'cancel']) }}" class="btn btn-sm {{ $filter === 'cancel' ? 'btn-danger' : 'btn-light border' }}" style="border-radius: 8px;">
            Cancelled Stays
        </a>
    </div>
</div>

<!-- BOOKINGS TABLE -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr style="font-size: 12.5px;">
                        <th>Booking Ref</th>
                        <th>Guest Details</th>
                        <th>Room Reserved</th>
                        <th>Check-In / Out</th>
                        <th>Occupancy</th>
                        <th>Tariff / Payout</th>
                        <th>Check-In Status &amp; PIN</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody style="font-size: 13.5px;">
                    @forelse($bookings as $b)
                        @php
                            $bId = is_array($b) ? ($b['id'] ?? 1) : $b->id;
                            $bCode = is_array($b) ? ($b['booking_code'] ?? ($b['booking_number'] ?? 'DWS-HTL-'.$bId)) : ($b->booking_code ?? 'DWS-HTL-'.$bId);
                            $cName = is_array($b) ? ($b['customer_name'] ?? 'Devotee Guest') : ($b->customer_name ?? 'Devotee Guest');
                            $cPhone = is_array($b) ? ($b['customer_phone'] ?? '9648777223') : ($b->customer_phone ?? '9648777223');
                            $cAlt = is_array($b) ? ($b['alternate_phone'] ?? null) : ($b->alternate_phone ?? null);
                            $rName = is_array($b) ? ($b['room_name'] ?? ($b['room_type'] ?? 'Deluxe Room')) : ($b->room_name ?? 'Deluxe Room');
                            $checkIn = is_array($b) ? ($b['check_in_date'] ?? ($b['check_in'] ?? ($b['checkin'] ?? 'Today'))) : ($b->check_in_date ?? ($b->check_in ?? ($b->checkin ?? 'Today')));
                            $checkOut = is_array($b) ? ($b['check_out_date'] ?? ($b['check_out'] ?? ($b['checkout'] ?? 'Tomorrow'))) : ($b->check_out_date ?? ($b->check_out ?? ($b->checkout ?? 'Tomorrow')));
                            $nights = is_array($b) ? ($b['nights'] ?? 1) : ($b->nights ?? 1);
                            $persons = is_array($b) ? ($b['persons'] ?? ($b['guests'] ?? 2)) : ($b->persons ?? 2);
                            $tot = (float)(is_array($b) ? ($b['total_amount'] ?? ($b['amount'] ?? 0)) : ($b->total_amount ?? ($b->amount ?? 0)));
                            if ($tot <= 0) {
                                $pricePerNight = (float)(is_array($b) ? ($b['price_per_night'] ?? 0) : ($b->price_per_night ?? 0));
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
                                <strong class="text-primary d-block">#{{ $bCode }}</strong>
                                <small class="text-muted">ID: {{ $bId }}</small>
                            </td>
                            <td>
                                <strong class="d-block text-dark">{{ $cName }}</strong>
                                <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $cPhone }}</small>
                                @if($cAlt)
                                    <small class="text-muted d-block" style="font-size: 11px;">Alt: {{ $cAlt }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $rName }}</span>
                            </td>
                            <td>
                                <div><small class="text-muted">In:</small> <strong>{{ $checkIn }}</strong></div>
                                <div><small class="text-muted">Out:</small> <strong>{{ $checkOut }}</strong></div>
                            </td>
                            <td>
                                <span>{{ $persons }} Guests</span>
                                <small class="text-muted d-block">({{ $nights }} Night{{ $nights > 1 ? 's' : '' }})</small>
                            </td>
                            <td>
                                <span class="text-muted" style="font-size: 12px;">Total: ₹{{ number_format($tot, 2) }}</span>
                                <div class="fw-bold text-success fs-6">
                                    ₹{{ number_format($pShare, 2) }}
                                    @if($isCancelled)
                                        <small class="text-danger fw-normal" style="font-size: 11px;">(Cancel Share)</small>
                                    @else
                                        <small class="text-success fw-normal" style="font-size: 11px;">(80% Net)</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($isCancelled)
                                    <span class="badge bg-danger">Cancelled</span>
                                    @if(($b['cancellation_hotel_share'] ?? 0) > 0)
                                        <small class="d-block text-muted mt-1">+₹{{ number_format($b['cancellation_hotel_share'], 2) }} Penalty credit</small>
                                    @endif
                                @elseif($isCheckedIn)
                                    <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i>Checked-In Verified</span>
                                    <small class="text-muted d-block mt-1" style="font-size: 11px;">PIN Matched</small>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Expected</span>
                                    <div class="mt-1">
                                        <span class="badge bg-light text-dark border fw-bold" style="letter-spacing: 1px;">PIN: {{ $pin }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="text-end">
                                @if(!$isCheckedIn && !$isCancelled)
                                    <button class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#pinModal_{{ $bId }}">
                                        <i class="bi bi-shield-check me-1"></i> Check-In
                                    </button>
                                    <form action="{{ route('hotel.bookings.no-show', $bId) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Report this booking as Guest No-Show?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Mark as No-Show">
                                            No-Show
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted" style="font-size: 12px;">Locked</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal for PIN verification -->
                        @if(!$isCheckedIn && !$isCancelled)
                            <div class="modal fade" id="pinModal_{{ $bId }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content" style="border-radius: 16px;">
                                        <div class="modal-header bg-success text-white">
                                            <h6 class="modal-title fw-bold mb-0">Verify Check-In PIN</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('hotel.bookings.verify-pin', $bId) }}" method="POST">
                                            @csrf
                                            <div class="modal-body text-center p-4">
                                                <p class="text-muted mb-2" style="font-size: 13px;">Ask <strong>{{ $cName }}</strong> for the 4-digit PIN on their voucher:</p>
                                                <input type="text" name="pin" class="form-control text-center fw-bold fs-3 mb-3" placeholder="••••" maxlength="4" style="letter-spacing: 8px;" required autofocus>
                                                <button type="submit" class="btn btn-success fw-bold w-100">
                                                    Verify &amp; Handover Room
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                No reservations match the selected filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
