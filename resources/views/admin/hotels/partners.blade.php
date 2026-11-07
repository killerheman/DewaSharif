@extends('admin.includes.master')

@section('title', 'Hotel Partners & 80/20 Settlements | DewaSharif Admin')

@section('content')
<div class="pt-2 pb-4">
    <!-- PAGE HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h3 class="mb-1 fw-bold text-dark">
                <i class="bi bi-bank2 text-success me-2"></i>Hotel Partners &amp; 80/20 Settlement Hub
            </h3>
            <p class="text-muted mb-0" style="font-size: 13.5px;">
                Manage guest house partner accounts, 80% balance payouts &amp; direct bank disbursements
            </p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('admin.hotels.refunds') }}" class="btn btn-outline-danger fw-bold me-2 shadow-sm">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Customer Refund Queue
            </a>
            <a href="{{ route('admin.hotels.index') }}" class="btn btn-outline-dark fw-bold shadow-sm">
                <i class="bi bi-building me-1"></i> Manage Rooms
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 4 SUMMARY CARDS -->
    <div class="row g-3 mb-4">
        <!-- CARD 1: PLATFORM REVENUE -->
        <div class="col-xl-3 col-sm-6 d-flex align-items-stretch">
            <div class="stat-card card-gradient-green w-100 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Platform Revenue (20%)</span>
                    <span class="badge bg-white text-dark shadow-xs fw-bold">DewaSharif Cut</span>
                </div>
                <div class="my-auto py-2">
                    <h2 class="fw-bold text-white mb-0" style="font-size: 2rem; letter-spacing: -0.5px;">
                        ₹{{ number_format($totalPlatformCommission, 2) }}
                    </h2>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-25">
                    <small style="opacity: 0.9; font-size: 11.5px;">Direct earnings from completed stays</small>
                    <i class="bi bi-pie-chart-fill fs-5 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- CARD 2: CLEARED SETTLEMENTS -->
        <div class="col-xl-3 col-sm-6 d-flex align-items-stretch">
            <div class="stat-card card-gradient-blue w-100 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Cleared Settlements (Paid)</span>
                    <span class="badge bg-white text-dark shadow-xs fw-bold">Bank &amp; UPI</span>
                </div>
                <div class="my-auto py-2">
                    <h2 class="fw-bold text-white mb-0" style="font-size: 2rem; letter-spacing: -0.5px;">
                        ₹{{ number_format($totalSettledPayouts, 2) }}
                    </h2>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-25">
                    <small style="opacity: 0.9; font-size: 11.5px;">Total 80% payouts transferred to hotels</small>
                    <i class="bi bi-check2-circle fs-5 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- CARD 3: PENDING BALANCE DUE -->
        <div class="col-xl-3 col-sm-6 d-flex align-items-stretch">
            <div class="stat-card card-gradient-amber w-100 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Pending Balance Due</span>
                    <span class="badge bg-white text-dark shadow-xs fw-bold">Every 3 Days</span>
                </div>
                <div class="my-auto py-2">
                    <h2 class="fw-bold text-white mb-0" style="font-size: 2rem; letter-spacing: -0.5px;">
                        ₹{{ number_format($totalPendingPayouts, 2) }}
                    </h2>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-25">
                    <small style="opacity: 0.9; font-size: 11.5px;">Outstanding to be paid by Admin</small>
                    <i class="bi bi-clock-history fs-5 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- CARD 4: REGISTERED PARTNERS -->
        <div class="col-xl-3 col-sm-6 d-flex align-items-stretch">
            <div class="stat-card card-gradient-dark w-100 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span style="font-size: 13px; font-weight: 600; opacity: 0.9;">Registered Partners</span>
                    <span class="badge bg-white text-dark shadow-xs fw-bold">Active Network</span>
                </div>
                <div class="my-auto py-2">
                    <h2 class="fw-bold text-white mb-0" style="font-size: 2rem; letter-spacing: -0.5px;">
                        {{ count($partners) }} {{ count($partners) === 1 ? 'Hotel' : 'Hotels' }}
                    </h2>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-white border-opacity-25">
                    <small style="opacity: 0.9; font-size: 11.5px;">Guest houses onboarding Dewa Sharif</small>
                    <i class="bi bi-buildings-fill fs-5 opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

            <!-- PARTNERS DIRECTORY TABLE -->
            <div class="card card-outline card-success shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-people-fill text-success me-2"></i>Hotel Partner Accounts &amp; Payout Balances</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#ID</th>
                                    <th>Hotel &amp; Manager</th>
                                    <th>Bank &amp; UPI Destination</th>
                                    <th>Confirmed Stays</th>
                                    <th>80% Total Earned</th>
                                    <th>Settled So Far</th>
                                    <th>Balance Due (Unpaid)</th>
                                    <th>Status</th>
                                    <th class="text-end" style="min-width: 170px;">Action / Payout</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($partners as $p)
                                    @php
                                        $stats = $partnerStats[$p->id] ?? ['gross' => 0, 'partner_share' => 0, 'settled' => 0, 'balance' => 0, 'confirmed_count' => 0];
                                        $bal = (float)$stats['balance'];
                                        $isActive = ($p->status === 'active');
                                    @endphp
                                    <tr>
                                        <td>#PTR-{{ $p->id }}</td>
                                        <td>
                                            <strong class="d-block text-dark">{{ $p->hotel_name ?: 'Guest House' }}</strong>
                                            <span class="text-muted" style="font-size: 13px;">👤 {{ $p->name }}</span>
                                            <small class="text-muted d-block"><i class="bi bi-telephone me-1"></i>{{ $p->phone }} | {{ $p->email }}</small>
                                        </td>
                                        <td>
                                            @if(!empty($p->bank_name) || !empty($p->account_no))
                                                <div><strong>{{ $p->bank_name }}</strong></div>
                                                <div style="font-size: 12px; color: #475569;">A/C: {{ $p->account_no }} | IFSC: {{ $p->ifsc_code }}</div>
                                            @endif
                                            @if(!empty($p->upi_id))
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary mt-1">
                                                    UPI: {{ $p->upi_id }}
                                                </span>
                                            @endif
                                            @if(empty($p->bank_name) && empty($p->upi_id))
                                                <span class="text-danger fw-bold" style="font-size: 12px;">No Bank / UPI added</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $stats['confirmed_count'] }}</strong> Stays
                                            <small class="text-muted d-block">Gross: ₹{{ number_format($stats['gross'], 2) }}</small>
                                        </td>
                                        <td>
                                            <strong class="text-dark">₹{{ number_format($stats['partner_share'], 2) }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-success fw-bold">₹{{ number_format($stats['settled'], 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold fs-6 {{ $bal > 0 ? 'text-danger' : 'text-muted' }}">
                                                ₹{{ number_format($bal, 2) }}
                                            </span>
                                            @if($bal > 0)
                                                <small class="badge bg-danger bg-opacity-10 text-danger border border-danger d-block mt-1">Payout Pending</small>
                                            @else
                                                <small class="badge bg-success bg-opacity-10 text-success border border-success d-block mt-1">Cleared</small>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.hotels.partners.toggle', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $isActive ? 'btn-success' : 'btn-danger' }} fw-bold" style="font-size: 11px;">
                                                    {{ $isActive ? '● ACTIVE' : '⏸ SUSPENDED' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#payModal_{{ $p->id }}">
                                                <i class="bi bi-cash-stack me-1"></i> Pay Settlement
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- SETTLEMENT PAYOUT MODAL -->
                                    <div class="modal fade" id="payModal_{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="border-radius: 16px;">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title fw-bold mb-0">
                                                        💰 Disburse Hotel Payout — {{ $p->hotel_name }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.hotels.partners.pay') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="partner_id" value="{{ $p->id }}">
                                                    <div class="modal-body p-4">
                                                        <div class="p-3 bg-light rounded-3 mb-3" style="font-size: 13px;">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-muted">Partner Name:</span>
                                                                <strong>{{ $p->name }} ({{ $p->phone }})</strong>
                                                            </div>
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-muted">Bank Destination:</span>
                                                                <strong>{{ $p->bank_name ?: 'N/A' }} ({{ $p->account_no ?: 'N/A' }})</strong>
                                                            </div>
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-muted">UPI ID:</span>
                                                                <strong class="text-primary">{{ $p->upi_id ?: 'N/A' }}</strong>
                                                            </div>
                                                            <hr class="my-2">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-dark fw-bold">Current Unpaid Balance Due:</span>
                                                                <strong class="text-danger fs-5">₹{{ number_format($bal, 2) }}</strong>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Disbursement Amount (₹) *</label>
                                                            <input type="number" name="amount_paid" class="form-control fw-bold fs-5 text-success" value="{{ $bal > 0 ? $bal : 1000 }}" min="1" step="0.01" required>
                                                            <small class="text-muted">Full payment resets balance to 0.00. Partial amounts persist remaining balance.</small>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Payment Transfer Mode *</label>
                                                            <select name="payment_mode" class="form-select fw-semibold" id="modeSelect_{{ $p->id }}" onchange="handleModeChange(this, '{{ $p->id }}')" required>
                                                                <option value="UPI / PhonePe" {{ !empty($p->upi_id) ? 'selected' : '' }}>📱 PhonePe / Google Pay / SBI UPI</option>
                                                                <option value="NEFT / IMPS">🏛️ NEFT / RTGS / IMPS Bank Transfer</option>
                                                                <option value="Cash Handover">💵 Cash Handover (Physical Cash)</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold text-dark" style="font-size: 13px;" id="refLabel_{{ $p->id }}">Bank Transaction UTR / Ref Number</label>
                                                            <input type="text" name="transaction_ref" id="refInput_{{ $p->id }}" class="form-control fw-bold" placeholder="e.g. 428910482910 (or Cash Receipt / Memo)">
                                                            <small class="text-muted" id="refHelp_{{ $p->id }}">Audit UTR reference displayed on partner's passbook. (Auto-generated if left empty for cash).</small>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Admin Notes (Optional)</label>
                                                            <textarea name="admin_notes" id="notesInput_{{ $p->id }}" class="form-control" rows="2" placeholder="e.g. Physical cash handed over to Haji Irfan Warsi / Settled Oct 26-29"></textarea>
                                                        </div>

                                                        <div id="cashNotice_{{ $p->id }}" class="alert alert-success d-none py-2 px-3 mb-0" style="font-size: 12px;">
                                                            <i class="bi bi-info-circle-fill me-1"></i> <strong>Cash Handover:</strong> Hotel ke dashboard pe <strong>"CASH HANDOVER"</strong> receipt generate hogi aur Unpaid Balance turant <strong>₹0.00</strong> ho jayega.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success fw-bold px-4">
                                                            <i class="bi bi-check2-circle me-1"></i> Confirm &amp; Credit Payout
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">
                                            No hotel partners registered yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PAST DISBURSEMENTS AUDIT TABLE -->
            <div class="card card-outline card-secondary shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-journal-text text-primary me-2"></i>Past Settlement Disbursements Ledger (Last 25)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0" style="font-size: 13px;">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Date</th>
                                    <th>Code</th>
                                    <th>Hotel Partner</th>
                                    <th>Amount Paid</th>
                                    <th>Mode</th>
                                    <th>UTR / Reference</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allSettlements as $st)
                                    <tr>
                                        <td>{{ $st->created_at->format('d M Y, h:i A') }}</td>
                                        <td><span class="badge bg-light text-primary border font-monospace">{{ $st->settlement_code }}</span></td>
                                        <td><strong>{{ $st->partner->hotel_name ?? 'Hotel' }}</strong> ({{ $st->partner->name ?? 'Partner' }})</td>
                                        <td><strong class="text-success fs-6">₹{{ number_format($st->amount_paid, 2) }}</strong></td>
                                        <td>
                                            @if(str_contains(strtolower($st->payment_mode), 'cash'))
                                                <span class="badge bg-success"><i class="bi bi-cash-stack me-1"></i> Cash Handover</span>
                                            @else
                                                <span class="badge bg-dark">{{ $st->payment_mode }}</span>
                                            @endif
                                        </td>
                                        <td><code>{{ $st->transaction_ref }}</code></td>
                                        <td><small class="text-muted">{{ $st->admin_notes ?: 'Regular settlement' }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3 text-muted">No payout disbursements recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
function handleModeChange(select, id) {
    const val = select.value;
    const isCash = val.toLowerCase().includes('cash');
    const label = document.getElementById('refLabel_' + id);
    const input = document.getElementById('refInput_' + id);
    const help = document.getElementById('refHelp_' + id);
    const notice = document.getElementById('cashNotice_' + id);
    const notes = document.getElementById('notesInput_' + id);

    if (isCash) {
        if (label) label.innerText = 'Cash Voucher / Memo Ref (Optional)';
        if (input) input.placeholder = 'e.g. CASH-PAID-TODAY or leave blank for auto code';
        if (help) help.innerText = 'Physical cash voucher or slip number. Auto-generated if left blank.';
        if (notice) notice.classList.remove('d-none');
        if (notes && !notes.value) notes.value = 'Physical cash handed over in person by Admin.';
    } else {
        if (label) label.innerText = 'Bank Transaction UTR / Ref Number *';
        if (input) input.placeholder = 'e.g. 428910482910';
        if (help) help.innerText = 'Audit UTR reference displayed on partner passbook.';
        if (notice) notice.classList.add('d-none');
        if (notes && notes.value === 'Physical cash handed over in person by Admin.') notes.value = '';
    }
}
</script>
@endsection
