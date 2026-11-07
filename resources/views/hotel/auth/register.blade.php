<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Hotel / Guest House - DewaSharif.com</title>
    <link rel="icon" href="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" type="image/png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #052c16 0%, #031c0e 50%, #021208 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
        }
        .register-card {
            width: 100%;
            max-width: 640px;
            background: #ffffff;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            border: 1.5px solid #cbd5e1;
        }
        .form-control:focus, .form-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        .btn-register {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 800;
            padding: 13px;
            border-radius: 10px;
            font-size: 15px;
            border: none;
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="text-center mb-4">
            <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="Logo" style="width: 56px; height: 56px; border-radius: 50%; border: 2px solid #10b981; margin-bottom: 10px;">
            <h4 class="fw-bold text-dark mb-1">Partner Onboarding with DewaSharif.com</h4>
            <p class="text-muted" style="font-size: 13px;">List your guest house, reach thousands of Zaireen &amp; enjoy guaranteed 80% direct payouts.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3 border-0" style="border-radius: 8px; font-size: 13px;">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hotel.register.post') }}" method="POST">
            @csrf
            <h6 class="fw-bold text-success border-bottom pb-2 mb-3">1. Hotel &amp; Contact Details</h6>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Hotel / Guest House Name *</label>
                    <input type="text" name="hotel_name" class="form-control" placeholder="e.g. Al-Waris Deluxe Guest House" value="{{ old('hotel_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Owner / Manager Full Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Haji Irfan Warsi" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Mobile / WhatsApp Number *</label>
                    <input type="text" name="phone" class="form-control" placeholder="e.g. 9648777223" value="{{ old('phone') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Email Address *</label>
                    <input type="email" name="email" class="form-control" placeholder="e.g. alwaris@dewasharif.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <h6 class="fw-bold text-success border-bottom pb-2 mb-3 pt-2">2. Bank Payout &amp; UPI Account (For 80% Settlements)</h6>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Bank Name</label>
                    <input type="text" name="bank_name" class="form-control" placeholder="e.g. State Bank of India" value="{{ old('bank_name') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Account Number</label>
                    <input type="text" name="account_no" class="form-control" placeholder="e.g. 38472910482" value="{{ old('account_no') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Account Holder Name</label>
                    <input type="text" name="account_holder" class="form-control" placeholder="e.g. Haji Irfan Warsi" value="{{ old('account_holder') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">IFSC Code</label>
                    <input type="text" name="ifsc_code" class="form-control" placeholder="e.g. SBIN0001234" value="{{ old('ifsc_code') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">UPI ID (Fast Settlement)</label>
                    <input type="text" name="upi_id" class="form-control" placeholder="e.g. 9648777223@sbi or hotel@paytm" value="{{ old('upi_id') }}">
                </div>
            </div>

            <h6 class="fw-bold text-success border-bottom pb-2 mb-3 pt-2">3. Set Portal Password</h6>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark" style="font-size: 13px;">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register w-100 mb-3">
                <i class="bi bi-check2-circle me-1"></i> Complete Partner Registration
            </button>
        </form>

        <div class="text-center pt-3 border-top">
            <span class="text-muted" style="font-size: 13px;">Already have a Partner account?</span>
            <a href="{{ route('hotel.login') }}" class="text-success fw-bold text-decoration-none ms-1" style="font-size: 13.5px;">Sign In Here</a>
        </div>
    </div>

</body>
</html>
