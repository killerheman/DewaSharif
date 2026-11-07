@extends('hotel.includes.master')

@section('title', 'Settlements & Payouts Passbook')

@section('content')
<div class="row align-items-center mb-4 g-3">
    <div class="col-md-7">
        <h3 class="fw-bold text-dark mb-1">
            💰 Settlements &amp; Payouts Passbook
        </h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">
            Audited transaction ledger of all 80% earnings transferred directly to your bank account or UPI by DewaSharif Admin.
        </p>
    </div>
    <div class="col-md-5 text-md-end">
        <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 border border-primary">
            <i class="bi bi-clock-history me-1"></i> Cycle: Every 3 Days
        </span>
    </div>
</div>

<!-- 3 PASSBOOK SUMMARY CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Total Settled (Received)</span>
                <span class="badge bg-white text-success fw-bold" style="font-size: 11px;">Credited</span>
            </div>
            <h3 class="fw-bold mb-1">₹{{ number_format($totalSettled, 2) }}</h3>
            <small style="font-size: 11.5px; opacity: 0.85;">Audited bank/UPI transfers received so far</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #ffffff;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Pending Due (Accumulating)</span>
                <span class="badge bg-white text-danger fw-bold" style="font-size: 11px;">Cycle: Every 3 Days</span>
            </div>
            <h3 class="fw-bold mb-1">₹{{ number_format($currentBalance, 2) }}</h3>
            <small style="font-size: 11.5px; opacity: 0.85;">Current 80% balance due from Admin</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; background: #ffffff; border: 1.5px solid #e2e8f0 !important;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted fw-bold" style="font-size: 12.5px;"><i class="bi bi-bank2 text-success me-1"></i>Your Payout Destination</span>
                <a href="{{ route('hotel.profile') }}" class="btn btn-sm btn-outline-success py-0 px-2 fw-bold" style="font-size: 11px;">
                    {{ (!empty($partner->account_no) || !empty($partner->upi_id)) ? 'Edit' : '+ Add Bank' }}
                </a>
            </div>
            @if(!empty($partner->bank_name) || !empty($partner->account_no) || !empty($partner->upi_id))
                <div class="fw-bold text-dark" style="font-size: 14px;">{{ $partner->bank_name }}</div>
                @if(!empty($partner->account_no))
                    <div class="text-muted" style="font-size: 12px;">A/C: <strong>{{ $partner->account_no }}</strong> | IFSC: {{ $partner->ifsc_code ?: 'N/A' }}</div>
                @endif
                @if(!empty($partner->upi_id))
                    <div class="text-primary fw-semibold mt-1" style="font-size: 12px;">UPI: {{ $partner->upi_id }}</div>
                @endif
            @else
                <div class="text-danger fw-bold mt-2" style="font-size: 13px;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>Bank details not added yet
                </div>
                <small class="text-muted d-block mt-1" style="font-size: 11px; line-height: 1.4;">
                    Please add your own Bank A/C or UPI under Profile so Admin can transfer your 80% earnings.
                </small>
            @endif
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
    <div class="card-header bg-white py-3 border-0" style="border-radius: 16px 16px 0 0;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-journal-check text-success me-2"></i>Payout Disbursements History</h5>
            <span class="badge bg-success bg-opacity-10 text-success fw-bold">{{ count($settlements) }} Payouts Received</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr style="font-size: 12.5px;">
                        <th>Date &amp; Time</th>
                        <th>Settlement Code</th>
                        <th>Payment Mode</th>
                        <th>Transaction UTR / Ref</th>
                        <th>Amount Transferred</th>
                        <th>Admin Verification Notes</th>
                        <th class="text-end">Status</th>
                    </tr>
                </thead>
                <tbody style="font-size: 13.5px;">
                    @forelse($settlements as $st)
                        <tr>
                            <td>
                                <strong class="text-dark d-block">{{ $st->created_at->format('d M Y') }}</strong>
                                <small class="text-muted">{{ $st->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border font-monospace fw-bold" style="font-size: 12.5px;">
                                    {{ $st->settlement_code }}
                                </span>
                            </td>
                            <td>
                                @if(str_contains(strtolower($st->payment_mode), 'cash'))
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold" style="font-size: 11.5px;">
                                        <i class="bi bi-cash-stack me-1"></i>CASH HANDOVER
                                    </span>
                                @else
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-bold" style="font-size: 11.5px;">
                                        <i class="bi bi-bank me-1"></i>{{ strtoupper($st->payment_mode) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark">{{ $st->transaction_ref ?: 'Direct Bank Transfer' }}</strong>
                            </td>
                            <td>
                                <span class="fw-bold text-success fs-5">₹{{ number_format($st->amount_paid, 2) }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $st->admin_notes ?: 'Regular settlement verified against completed check-ins.' }}</small>
                            </td>
                            <td class="text-end">
                                <span class="badge bg-success py-2 px-3">
                                    <i class="bi bi-check2-all me-1"></i> CREDITED
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-cash-coin fs-1 d-block mb-2 text-warning"></i>
                                <h6 class="fw-bold text-dark mb-1">No Past Settlements Disbursed Yet</h6>
                                <p class="text-muted mb-0" style="font-size: 13px;">
                                    Your 80% take-home earnings are safely accumulating under your <em>Current Balance</em>.<br>
                                    DewaSharif Admin processes payout transfers directly to your bank every 3 days.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
