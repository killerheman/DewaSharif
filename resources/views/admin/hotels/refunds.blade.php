@extends('admin.includes.master')

@section('title', 'Customer Cancellation & Refund Queue | DewaSharif Admin')

@section('content')
@php
    $pendingRefundsCount = 0;
    $pendingRefundsTotal = 0;
    $completedRefundsCount = 0;
    $completedRefundsTotal = 0;
    $totalPenaltiesCollected = 0;

    foreach ($refundQueue as $b) {
        $st = strtolower(is_array($b) ? ($b['status'] ?? '') : ($b->status ?? ''));
        $refundSt = strtolower(is_array($b) ? ($b['refund_status'] ?? 'pending') : ($b->refund_status ?? 'pending'));
        $custRefund = (float)(is_array($b) ? ($b['cancellation_customer_refund'] ?? 0) : ($b->cancellation_customer_refund ?? 0));
        $pen = (float)(is_array($b) ? ($b['cancellation_fee_total'] ?? 0) : ($b->cancellation_fee_total ?? 0));

        $totalPenaltiesCollected += $pen;

        if ($refundSt === 'refunded') {
            $completedRefundsCount++;
            $completedRefundsTotal += $custRefund;
        } elseif ($custRefund > 0) {
            $pendingRefundsCount++;
            $pendingRefundsTotal += $custRefund;
        }
    }
@endphp

<div class="pt-2 pb-4">
    <!-- PAGE HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center">
            <div class="p-3 rounded-3 bg-danger bg-opacity-10 text-danger me-3 shadow-xs">
                <i class="bi bi-arrow-counterclockwise fs-2"></i>
            </div>
            <div>
                <h3 class="mb-1 fw-bold text-dark">
                    Customer Cancellation &amp; Refund Queue
                </h3>
                <p class="text-muted mb-0" style="font-size: 13.5px;">
                    Audit cancellations, tiered deduction rules, 50-50 penalty splits &amp; disburse devotee refunds
                </p>
            </div>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="{{ route('admin.hotels.partners') }}" class="btn btn-outline-success fw-bold px-3 shadow-xs">
                <i class="bi bi-bank2 me-1"></i> Partners Hub &amp; Settlements
            </a>
            <a href="{{ route('admin.hotels.bookings') }}" class="btn btn-outline-dark fw-bold px-3 shadow-xs">
                <i class="bi bi-calendar-check me-1"></i> All Bookings
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 3 SUMMARY STAT CARDS -->
    <div class="row g-3 mb-4">
        <!-- CARD 1: PENDING REFUND CLAIMS -->
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="stat-card card-gradient-red w-100 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Pending Customer Refunds</span>
                    <span class="badge bg-white text-danger shadow-xs fw-bold">{{ $pendingRefundsCount }} Awaiting</span>
                </div>
                <div class="my-auto py-2">
                    <h2 class="fw-bold text-white mb-0" style="font-size: 2rem; letter-spacing: -0.5px;">
                        ₹{{ number_format($pendingRefundsTotal, 2) }}
                    </h2>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-25">
                    <small style="opacity: 0.9; font-size: 11.5px;">Money to be paid back to devotees</small>
                    <i class="bi bi-clock-history fs-5 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- CARD 2: PROCESSED & CREDITED REFUNDS -->
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="stat-card card-gradient-green w-100 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Disbursed Refunds (Completed)</span>
                    <span class="badge bg-white text-success shadow-xs fw-bold">{{ $completedRefundsCount }} Refunded</span>
                </div>
                <div class="my-auto py-2">
                    <h2 class="fw-bold text-white mb-0" style="font-size: 2rem; letter-spacing: -0.5px;">
                        ₹{{ number_format($completedRefundsTotal, 2) }}
                    </h2>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-25">
                    <small style="opacity: 0.9; font-size: 11.5px;">Successfully settled to customer accounts</small>
                    <i class="bi bi-check2-all fs-5 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- CARD 3: TOTAL CANCELLATION PENALTIES -->
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="stat-card card-gradient-dark w-100 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Retained Penalty Pool (50/50 Split)</span>
                    <span class="badge bg-white text-dark shadow-xs fw-bold">Deductions</span>
                </div>
                <div class="my-auto py-2">
                    <h2 class="fw-bold text-white mb-0" style="font-size: 2rem; letter-spacing: -0.5px;">
                        ₹{{ number_format($totalPenaltiesCollected, 2) }}
                    </h2>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-25">
                    <small style="opacity: 0.9; font-size: 11.5px;">Shared equally between Admin &amp; Hotel</small>
                    <i class="bi bi-pie-chart-fill fs-5 opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- POLICY RECAP CARD -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: #ffffff; border: 1px solid #e2e8f0 !important;">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom">
            <div class="d-flex align-items-center">
                <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning-emphasis me-3">
                    <i class="bi bi-shield-check fs-5"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">DewaSharif Hotel Cancellation &amp; Penalty Policy Matrix</h6>
                    <small class="text-muted">Standardized tiered deductions with equal 50-50 penalty sharing between Admin &amp; Hotel Partner</small>
                </div>
            </div>
            <span class="badge bg-light text-dark border fw-bold px-3 py-2">
                <i class="bi bi-sliders me-1 text-primary"></i> 50/50 Split Rule
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <!-- TIER 1 -->
                <div class="col-xl-3 col-sm-6">
                    <div class="p-3 rounded-3 border bg-white shadow-xs h-100 d-flex flex-column justify-content-between" style="border-top: 3px solid #10b981 !important;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Tier 1 Notice</span>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-bold px-2 py-1">60% REFUND</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px;">≥ 48 Hours Prior</h6>
                            <div class="text-danger fw-bold mb-2" style="font-size: 12.5px;">
                                <i class="bi bi-dash-circle me-1"></i>40% Penalty
                            </div>
                        </div>
                        <div class="pt-2 border-top text-muted" style="font-size: 11.5px; line-height: 1.6;">
                            <div class="d-flex justify-content-between">
                                <span>Admin Share (50%):</span>
                                <strong class="text-dark">20%</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Hotel Partner (50%):</span>
                                <strong class="text-dark">20%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TIER 2 -->
                <div class="col-xl-3 col-sm-6">
                    <div class="p-3 rounded-3 border bg-white shadow-xs h-100 d-flex flex-column justify-content-between" style="border-top: 3px solid #3b82f6 !important;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Tier 2 Notice</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-bold px-2 py-1">40% REFUND</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px;">24h – 48h Prior</h6>
                            <div class="text-danger fw-bold mb-2" style="font-size: 12.5px;">
                                <i class="bi bi-dash-circle me-1"></i>60% Penalty
                            </div>
                        </div>
                        <div class="pt-2 border-top text-muted" style="font-size: 11.5px; line-height: 1.6;">
                            <div class="d-flex justify-content-between">
                                <span>Admin Share (50%):</span>
                                <strong class="text-dark">30%</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Hotel Partner (50%):</span>
                                <strong class="text-dark">30%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TIER 3 -->
                <div class="col-xl-3 col-sm-6">
                    <div class="p-3 rounded-3 border bg-white shadow-xs h-100 d-flex flex-column justify-content-between" style="border-top: 3px solid #f59e0b !important;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Tier 3 Notice</span>
                                <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 fw-bold px-2 py-1">20% REFUND</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px;">Same Day (&lt; 24h)</h6>
                            <div class="text-danger fw-bold mb-2" style="font-size: 12.5px;">
                                <i class="bi bi-dash-circle me-1"></i>80% Penalty
                            </div>
                        </div>
                        <div class="pt-2 border-top text-muted" style="font-size: 11.5px; line-height: 1.6;">
                            <div class="d-flex justify-content-between">
                                <span>Admin Share (50%):</span>
                                <strong class="text-dark">40%</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Hotel Partner (50%):</span>
                                <strong class="text-dark">40%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TIER 4 -->
                <div class="col-xl-3 col-sm-6">
                    <div class="p-3 rounded-3 border bg-white shadow-xs h-100 d-flex flex-column justify-content-between" style="border-top: 3px solid #ef4444 !important;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Tier 4 Notice</span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 fw-bold px-2 py-1">0% REFUND</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px;">No-Show / Arrival Day</h6>
                            <div class="text-danger fw-bold mb-2" style="font-size: 12.5px;">
                                <i class="bi bi-dash-circle me-1"></i>100% Forfeit
                            </div>
                        </div>
                        <div class="pt-2 border-top text-muted" style="font-size: 11.5px; line-height: 1.6;">
                            <div class="d-flex justify-content-between">
                                <span>Admin Share (50%):</span>
                                <strong class="text-dark">50%</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Hotel Partner (50%):</span>
                                <strong class="text-dark">50%</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REFUND QUEUE TABLE -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0 !important;">
        <div class="card-header bg-light py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
            <div class="d-flex align-items-center">
                <i class="bi bi-list-task text-danger fs-5 me-2"></i>
                <h5 class="card-title mb-0 fw-bold text-dark">Cancellations Awaiting Refund</h5>
                <span class="badge {{ count($refundQueue) > 0 ? 'bg-danger' : 'bg-secondary' }} ms-2 px-2.5 py-1">
                    {{ count($refundQueue) }} Total
                </span>
            </div>
            <div>
                <span class="text-muted" style="font-size: 12.5px;">
                    <i class="bi bi-arrow-repeat me-1"></i> Live synced with Hotel Bookings
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Booking Ref</th>
                            <th>Customer Devotee</th>
                            <th>Hotel Property</th>
                            <th>Stay Dates</th>
                            <th>Gross Fare</th>
                            <th>Penalty (50-50 Split)</th>
                            <th>Refund Due</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Action / Process</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13.5px;">
                        @forelse($refundQueue as $b)
                            @php
                                $bId = is_array($b) ? ($b['id'] ?? 1) : $b->id;
                                $bCode = is_array($b) ? ($b['booking_code'] ?? ($b['booking_number'] ?? 'DWS-HTL-'.$bId)) : ($b->booking_code ?? 'DWS-HTL-'.$bId);
                                $cName = is_array($b) ? ($b['customer_name'] ?? 'Devotee') : ($b->customer_name ?? 'Devotee');
                                $cPhone = is_array($b) ? ($b['customer_phone'] ?? '9648777223') : ($b->customer_phone ?? '9648777223');
                                $hName = is_array($b) ? ($b['hotel_name'] ?? 'Hotel') : ($b->hotel_name ?? 'Hotel');
                                $checkIn = is_array($b) ? ($b['check_in'] ?? ($b['checkin'] ?? 'Today')) : ($b->check_in ?? 'Today');
                                $tot = (float)(is_array($b) ? ($b['total_amount'] ?? ($b['amount'] ?? 0)) : ($b->total_amount ?? 0));
                                
                                $penaltyTot = (float)(is_array($b) ? ($b['cancellation_fee_total'] ?? 0) : ($b->cancellation_fee_total ?? 0));
                                $adminShare = (float)(is_array($b) ? ($b['cancellation_admin_share'] ?? 0) : ($b->cancellation_admin_share ?? 0));
                                $hotelShare = (float)(is_array($b) ? ($b['cancellation_hotel_share'] ?? 0) : ($b->cancellation_hotel_share ?? 0));
                                $custRefund = (float)(is_array($b) ? ($b['cancellation_customer_refund'] ?? 0) : ($b->cancellation_customer_refund ?? 0));
                                
                                $refundSt = strtolower(is_array($b) ? ($b['refund_status'] ?? 'pending') : ($b->refund_status ?? 'pending'));
                                $isRefunded = ($refundSt === 'refunded');
                                $utr = is_array($b) ? ($b['refund_utr'] ?? null) : ($b->refund_utr ?? null);
                            @endphp
                            <tr>
                                <td class="ps-3">
                                    <strong class="text-primary font-monospace">#{{ $bCode }}</strong>
                                </td>
                                <td>
                                    <strong class="d-block text-dark">{{ $cName }}</strong>
                                    <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $cPhone }}</small>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $hName }}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $checkIn }}</span>
                                </td>
                                <td>
                                    <strong>₹{{ number_format($tot, 2) }}</strong>
                                </td>
                                <td>
                                    <strong class="text-danger">₹{{ number_format($penaltyTot, 2) }}</strong>
                                    <div class="text-muted" style="font-size: 11px;">
                                        Admin: ₹{{ number_format($adminShare, 2) }} | Hotel: ₹{{ number_format($hotelShare, 2) }}
                                    </div>
                                </td>
                                <td>
                                    <strong class="text-success fs-6">₹{{ number_format($custRefund, 2) }}</strong>
                                </td>
                                <td>
                                    @if($isRefunded)
                                        <span class="badge bg-success">
                                            ✓ REFUNDED
                                        </span>
                                        <small class="d-block text-muted font-monospace mt-1">UTR: {{ $utr }}</small>
                                    @elseif($custRefund > 0)
                                        <span class="badge bg-warning text-dark">
                                            ⏳ PENDING ACTION
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">No Refund (0%)</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    @if(!$isRefunded && $custRefund > 0)
                                        <button class="btn btn-sm btn-danger fw-bold" data-bs-toggle="modal" data-bs-target="#refundModal_{{ $bId }}">
                                            <i class="bi bi-cash me-1"></i> Process Refund
                                        </button>
                                    @else
                                        <span class="badge bg-light text-muted border">Completed</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- REFUND EXECUTION MODAL -->
                            @if(!$isRefunded && $custRefund > 0)
                                <div class="modal fade" id="refundModal_{{ $bId }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="border-radius: 16px;">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title fw-bold mb-0">Transfer Refund to {{ $cName }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.hotels.refunds.process', $bId) }}" method="POST">
                                                @csrf
                                                <div class="modal-body p-4">
                                                    <div class="p-3 bg-light rounded-3 mb-3" style="font-size: 13px;">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-muted">Customer Name:</span>
                                                            <strong>{{ $cName }} ({{ $cPhone }})</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span class="text-muted">Booking Reference:</span>
                                                            <strong>#{{ $bCode }}</strong>
                                                        </div>
                                                        <hr class="my-2">
                                                        <div class="d-flex justify-content-between">
                                                            <span class="fw-bold text-dark">Approved Refund Amount:</span>
                                                            <strong class="text-success fs-5">₹{{ number_format($custRefund, 2) }}</strong>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold text-dark" style="font-size: 13px;">Bank Transaction UTR / Ref Number *</label>
                                                        <input type="text" name="refund_utr" class="form-control fw-bold" placeholder="e.g. 428919204910" required>
                                                        <small class="text-muted">Enter the bank UTR or UPI ref after sending money to customer's account.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger fw-bold px-4">
                                                        <i class="bi bi-check2-circle me-1"></i> Mark Refund as Transferred
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3">
                                            <span class="p-3 rounded-circle bg-success bg-opacity-10 text-success d-inline-block shadow-xs">
                                                <i class="bi bi-shield-check fs-1"></i>
                                            </span>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">All Clear — No Pending Refunds</h5>
                                        <p class="text-muted mb-0" style="font-size: 13px;">
                                            All hotel room bookings are active or previous cancellation requests have been settled.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
