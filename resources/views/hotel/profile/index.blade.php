@extends('hotel.includes.master')

@section('title', 'Bank Payout Details & Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="mb-4">
            <h3 class="fw-bold text-dark mb-1">
                🏦 Bank Payout Details &amp; Profile Settings
            </h3>
            <p class="text-muted mb-0" style="font-size: 13.5px;">
                Ensure your bank account and UPI ID are accurately set. DewaSharif Admin uses these details for all 80% payouts.
            </p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <ul class="mb-0 ps-3" style="font-size: 13.5px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hotel.profile.update') }}" method="POST">
            @csrf

            <!-- 1. BANK ACCOUNT & UPI (PRIMARY FOR PAYOUTS) -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; border-left: 5px solid #10b981 !important;">
                <div class="card-header bg-white py-3 border-0" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-bank2 text-success me-2"></i>Bank &amp; UPI Payout Destination</h5>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold">Settlement Account</span>
                    </div>
                </div>
                <div class="card-body p-4 pt-1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Bank Name *</label>
                            <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $partner->bank_name) }}" placeholder="e.g. State Bank of India" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Account Holder Name *</label>
                            <input type="text" name="account_holder" class="form-control" value="{{ old('account_holder', $partner->account_holder) }}" placeholder="e.g. Haji Irfan Warsi" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Bank Account Number *</label>
                            <input type="text" name="account_no" class="form-control fw-bold" value="{{ old('account_no', $partner->account_no) }}" placeholder="e.g. 38472910482" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">IFSC Code *</label>
                            <input type="text" name="ifsc_code" class="form-control text-uppercase fw-bold" value="{{ old('ifsc_code', $partner->ifsc_code) }}" placeholder="e.g. SBIN0001234" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">UPI ID (Fast PhonePe / Google Pay / Paytm Transfer)</label>
                            <input type="text" name="upi_id" class="form-control fw-bold text-primary" value="{{ old('upi_id', $partner->upi_id) }}" placeholder="e.g. 9648777223@sbi or hotel@paytm">
                            <small class="text-muted" style="font-size: 11.5px;">Admin can send direct 80% UPI settlements to this virtual payment address.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. CONTACT & CREDENTIALS -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-badge text-primary me-2"></i>Manager Details &amp; Password</h5>
                </div>
                <div class="card-body p-4 pt-1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Manager / Partner Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $partner->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Registered Mobile Number *</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $partner->phone) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Registered Email Address</label>
                            <input type="email" class="form-control bg-light" value="{{ $partner->email }}" disabled>
                            <small class="text-muted" style="font-size: 11px;">Primary login identity</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Hotel Property</label>
                            <input type="text" class="form-control bg-light" value="{{ $partner->hotel_name }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">New Password (Optional)</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Leave blank to keep current">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Re-type new password">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <button type="submit" class="btn btn-success fw-bold px-5 py-2 shadow" style="border-radius: 10px; font-size: 15px;">
                    <i class="bi bi-check2-circle me-1"></i> Save Payout &amp; Profile Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
