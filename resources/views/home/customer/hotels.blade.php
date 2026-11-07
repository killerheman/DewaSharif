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
                            <h4 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 22px;">🏨 My Hotel &amp; Guest House Reservations</h4>
                            <small class="text-muted">Verified stays near Dargah Waris Ali Shah</small>
                        </div>
                        <a href="{{ route('hotels') }}" class="btn btn-sm btn-success font-weight-bold px-3" style="border-radius: 8px;">+ Book New Hotel</a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>✓ Success:</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>✕ Error:</strong> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @forelse($hotelBookings as $booking)
                        @php
                            $bId = $booking['id'] ?? 1;
                            $hPayStatus = strtolower($booking['payment_status'] ?? 'paid');
                            $hStatus = strtolower($booking['status'] ?? '');
                            $isCancelled = str_contains($hStatus, 'cancel');
                            $isPaid = (in_array($hPayStatus, ['paid', 'completed', 'success']) || str_contains($hStatus, 'paid')) && !$isCancelled;
                            $isFailed = in_array($hPayStatus, ['failed', 'rejected']) || str_contains($hStatus, 'fail');
                            $pin = $booking['checkin_pin'] ?? '4821';

                            // Cancellation calculation preview
                            $checkinStr = $booking['check_in'] ?? ($booking['checkin'] ?? date('Y-m-d'));
                            $checkinTime = strtotime($checkinStr);
                            $diffHours = $checkinTime ? (($checkinTime - time()) / 3600) : 48;
                            if ($diffHours >= 48) {
                                $pctDeduct = 40; $pctRefund = 60;
                            } elseif ($diffHours >= 24) {
                                $pctDeduct = 60; $pctRefund = 40;
                            } else {
                                $pctDeduct = 80; $pctRefund = 20;
                            }
                            $totFare = (float)($booking['total_amount'] ?? ($booking['amount'] ?? 0));
                            $estRefund = round($totFare * ($pctRefund / 100), 2);
                            $estPenalty = round($totFare * ($pctDeduct / 100), 2);
                        @endphp
                        <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 20px;">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                                <div>
                                    @if($isPaid)
                                        <span style="font-size: 11px; font-weight: 800; color: #16a34a; background: #dcfce7; padding: 3px 10px; border-radius: 6px;">
                                            ✔ CONFIRMED &amp; PAID
                                        </span>
                                        <span style="font-size: 11px; font-weight: 800; color: #1e3a8a; background: #dbeafe; padding: 3px 10px; border-radius: 6px; margin-left: 6px;">
                                            🔐 CHECK-IN PIN: {{ $pin }}
                                        </span>
                                    @elseif($isCancelled)
                                        <span style="font-size: 11px; font-weight: 800; color: #dc2626; background: #fee2e2; padding: 3px 10px; border-radius: 6px;">
                                            ❌ RESERVATION CANCELLED
                                        </span>
                                        @if(($booking['refund_status'] ?? 'none') === 'refunded')
                                            <span style="font-size: 11px; font-weight: 800; color: #16a34a; background: #dcfce7; padding: 3px 10px; border-radius: 6px; margin-left: 6px;">
                                                ✓ REFUND PROCESSED (UTR: {{ $booking['refund_utr'] ?? 'BANK_TRANSFER' }})
                                            </span>
                                        @elseif(($booking['cancellation_customer_refund'] ?? 0) > 0)
                                            <span style="font-size: 11px; font-weight: 800; color: #d97706; background: #fef3c7; padding: 3px 10px; border-radius: 6px; margin-left: 6px;">
                                                ⏳ REFUND QUEUED: ₹{{ number_format($booking['cancellation_customer_refund'], 2) }}
                                            </span>
                                        @endif
                                    @elseif($isFailed)
                                        <span style="font-size: 11px; font-weight: 800; color: #dc2626; background: #fee2e2; padding: 3px 10px; border-radius: 6px;">
                                            ❌ PAYMENT FAILED
                                        </span>
                                    @else
                                        <span style="font-size: 11px; font-weight: 800; color: #d97706; background: #fef3c7; padding: 3px 10px; border-radius: 6px;">
                                            ⏳ VERIFICATION PENDING
                                        </span>
                                    @endif

                                    <h4 style="font-weight: 900; color: #0f172a; margin-top: 8px; margin-bottom: 4px; font-size: 19px;">
                                        {{ $booking['hotel_name'] ?? 'Guest House Stay' }}
                                    </h4>
                                    <p style="font-size: 13px; color: #64748b; margin: 0;">
                                        Booking ID: <strong>#{{ $booking['booking_code'] ?? ($booking['booking_id'] ?? 'DWS-HTL-2026-0001') }}</strong> | Check-in: <strong>{{ $checkinStr }}</strong>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span style="font-size: 22px; font-weight: 900; color: #052c16; display: block;">₹{{ number_format($totFare) }}</span>
                                    @if($isPaid)
                                        <span style="font-size: 11px; color: #16a34a; font-weight: 800; background: #dcfce7; padding: 3px 10px; border-radius: 4px;">✓ Paid Online</span>
                                    @elseif($isCancelled)
                                        <span style="font-size: 11px; color: #dc2626; font-weight: 800; background: #fee2e2; padding: 3px 10px; border-radius: 4px;">❌ Cancelled</span>
                                    @elseif($isFailed)
                                        <span style="font-size: 11px; color: #dc2626; font-weight: 800; background: #fee2e2; padding: 3px 10px; border-radius: 4px;">❌ Payment Failed</span>
                                    @else
                                        <span style="font-size: 11px; color: #d97706; font-weight: 800; background: #fef3c7; padding: 3px 10px; border-radius: 4px;">⏳ Settlement Pending</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 6px;">
                                        👤 <strong>Guest Name:</strong> {{ $booking['customer_name'] ?? 'Pilgrim Guest' }} ({{ $booking['customer_phone'] ?? '+91 9648777223' }}{{ !empty($booking['alternate_phone']) ? ' / Alt: ' . $booking['alternate_phone'] : '' }})
                                    </p>
                                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 0;">
                                        🛏️ <strong>Room Reserved:</strong> {{ $booking['room_name'] ?? ($booking['room_type'] ?? 'Deluxe AC Double Room with Generator Backup') }}
                                    </p>
                                    @if($isPaid)
                                        <div style="margin-top: 8px; font-size: 12px; color: #065f46; background: #ecfdf5; padding: 6px 10px; border-radius: 6px; border: 1px solid #a7f3d0;">
                                            🛡️ <strong>Paid Online Notice:</strong> Room rent is already paid. Do NOT pay rent to reception staff in cash. Quote PIN: <strong>{{ $pin }}</strong>.
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-5 text-md-right mt-3 mt-md-0 d-flex justify-content-md-end gap-2 align-items-center flex-wrap">
                                    <a href="{{ route('customer.invoice', ['type' => 'hotel', 'id' => $bId]) }}" target="_blank" class="btn btn-sm" style="background: {{ ($isFailed || $isCancelled) ? '#dc2626' : '#052c16' }}; color: #ffffff; font-weight: 800; font-size: 13px; border-radius: 8px; padding: 8px 14px;">
                                        {{ ($isFailed || $isCancelled) ? '❌ View Void Voucher' : '📥 Tax Invoice PDF' }}
                                    </a>

                                    @if($isPaid && !$isCancelled)
                                        <button type="button" class="btn btn-sm btn-outline-danger font-weight-bold" data-toggle="modal" data-target="#cancelModal_{{ $bId }}" style="border-radius: 8px; padding: 8px 14px; font-size: 13px;">
                                            ✕ Cancel Stay
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Cancellation Modal --}}
                        @if($isPaid && !$isCancelled)
                            <div class="modal fade" id="cancelModal_{{ $bId }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                                        <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%); color: #ffffff; padding: 18px 24px;">
                                            <h5 class="modal-title font-weight-bold text-white mb-0">
                                                ✕ Cancel Hotel Reservation #{{ $booking['booking_code'] ?? $bId }}
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('customer.hotels.cancel', $bId) }}" method="POST">
                                            @csrf
                                            <div class="modal-body" style="padding: 24px;">
                                                <p style="font-size: 14px; color: #475569; margin-bottom: 16px;">
                                                    Are you sure you want to cancel your stay at <strong>{{ $booking['hotel_name'] ?? 'Hotel' }}</strong>?
                                                </p>

                                                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 16px;">
                                                    <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                                                        <span class="text-muted">Total Paid Fare:</span>
                                                        <strong>₹{{ number_format($totFare, 2) }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                                                        <span class="text-muted">Cancellation Fee ({{ $pctDeduct }}% policy):</span>
                                                        <strong class="text-danger">-₹{{ number_format($estPenalty, 2) }}</strong>
                                                    </div>
                                                    <hr style="margin: 8px 0;">
                                                    <div class="d-flex justify-content-between" style="font-size: 14.5px;">
                                                        <span class="font-weight-bold text-dark">Estimated Refund ({{ $pctRefund }}%):</span>
                                                        <strong class="text-success" style="font-size: 16px;">₹{{ number_format($estRefund, 2) }}</strong>
                                                    </div>
                                                </div>

                                                <div style="font-size: 11.5px; color: #64748b; line-height: 1.6; margin-bottom: 16px; background: #fffbeb; padding: 10px 14px; border-radius: 8px; border: 1px solid #fef3c7;">
                                                    <strong>📋 DewaSharif Cancellation Policy:</strong><br>
                                                    • &gt;= 2 Days Prior: 40% Deduction, 60% Refund<br>
                                                    • 1 Day Prior (24-48h): 60% Deduction, 40% Refund<br>
                                                    • Same Day (&lt; 24h): 80% Deduction, 20% Refund<br>
                                                    • <em>Refunds are personally verified &amp; transferred by DewaSharif Admin directly to your original payment mode.</em>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label style="font-size: 13px; font-weight: 700; color: #334155;">Reason for Cancellation (Optional):</label>
                                                    <textarea name="cancellation_reason" class="form-control" rows="2" placeholder="e.g. Change in travel plans, family emergency..." style="border-radius: 8px; font-size: 13px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #f1f5f9; padding: 14px 24px;">
                                                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px; font-size: 13px;">Keep Reservation</button>
                                                <button type="submit" class="btn btn-danger font-weight-bold" style="border-radius: 8px; font-size: 13px;">Confirm Cancellation</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-building text-muted mb-2" style="font-size: 40px;"></i>
                            <h5>No Hotel Bookings Found</h5>
                            <a href="{{ route('hotels') }}" class="btn btn-success font-weight-bold mt-2">Browse &amp; Book Hotels</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
