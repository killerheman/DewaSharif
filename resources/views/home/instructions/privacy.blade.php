@extends('home.includes.master')

@section('content')
<style>
    .policy-wrapper {
        background: #f4f6f8;
        padding: 45px 0 70px;
        min-height: 85vh;
    }
    
    .policy-wrapper .d-flex {
        justify-content: flex-start !important;
    }
    
    .policy-hero {
        background: linear-gradient(135deg, #063820 0%, #0b5e36 50%, #16a34a 100%);
        border-radius: 20px;
        padding: 40px 30px;
        color: #ffffff;
        box-shadow: 0 12px 30px rgba(11, 94, 54, 0.25);
        margin-bottom: 35px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .policy-hero .badge-pill {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        color: #ffeb3b;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 15px;
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    /* Green Gradient to Yellow Gradient Header Effect */
    .gradient-heading {
        background: linear-gradient(135deg, #0b5e36 0%, #16a34a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        transition: all 0.35s ease-in-out;
        cursor: pointer;
        display: inline-block;
        text-align: left;
    }
    
    .gradient-heading:hover,
    .gradient-heading:focus,
    .gradient-heading:active {
        background: linear-gradient(135deg, #f7de01ff 0%, #f59e0b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        transform: translateY(-2px);
    }
    
    .hero-title {
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 12px;
        transition: all 0.35s ease-in-out;
        cursor: pointer;
    }
    
    .hero-title:hover {
        background: linear-gradient(135deg, #fef08a 0%, #f59e0b 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
    }
    
    .policy-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid rgba(11, 94, 54, 0.08);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }
    
    .policy-card:hover {
        box-shadow: 0 8px 25px rgba(11, 94, 54, 0.12);
        border-color: rgba(22, 163, 74, 0.3);
    }
    
    .heading-icon-badge {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(11, 94, 54, 0.1);
        color: #0b5e36;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-right: 12px;
        vertical-align: middle;
        flex-shrink: 0;
        transition: all 0.3s ease;
        -webkit-text-fill-color: #0b5e36 !important;
    }
    
    .policy-card:hover .heading-icon-badge {
        background: #0b5e36;
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
    }

    .policy-section-content {
        padding-left: 52px;
    }

    @media (max-width: 576px) {
        .policy-section-content {
            padding-left: 0px;
        }
    }
</style>

<div class="policy-wrapper">
    <div class="container">
        <!-- Hero Header -->
        <div class="policy-hero">
            <span class="badge-pill"><i class="fa fa-user-secret"></i> Data Protection &amp; Trust</span>
            <h1 class="hero-title" title="Hover / Tap to view Yellow Gradient">Privacy Policy</h1>
            <p style="font-size: 16px; opacity: 0.95; max-width: 780px; margin: 0 auto;">
                At dewasharif.com, we are committed to safeguarding your personal details and booking data with industry-leading encryption and security standards.
            </p>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-database"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            1. Information We Collect
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 10px;">
                            When you register an account, book hotel rooms, schedule cab pickups, or purchase items on dewasharif.com, we collect necessary personal details including:
                        </p>
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li><strong>Account Details:</strong> Name, Email Address, Phone Number, and Delivery Address.</li>
                            <li><strong>Government Photo ID:</strong> Aadhaar / ID details required for hotel booking verification.</li>
                            <li><strong>Payment Information:</strong> Transacted securely via Razorpay / Bank gateways. We do not store raw Credit/Debit card numbers or CVV.</li>
                        </ul>
                    </div>
                </div>

                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-shield"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            2. How We Use Your Data
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 10px;">
                            Your data is strictly used to fulfill your service bookings and communicate vital updates:
                        </p>
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li>Sending instant booking confirmation vouchers, SMS/Email receipts, and PDF invoices.</li>
                            <li>Sharing room reservation details with hotel reception desk for seamless check-in.</li>
                            <li>Dispatching cab driver details and store delivery updates.</li>
                        </ul>
                    </div>
                </div>

                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-lock"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            3. Data Protection &amp; Zero Third-Party Selling
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin: 0;">
                            We enforce strict 256-bit SSL encryption across all website pages. Your personal information is <strong>never sold, rented, or commercialized</strong> to third-party advertisers.
                        </p>
                    </div>
                </div>

                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-envelope"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            4. Contact Our Data Privacy Officer
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 10px;">
                            If you have questions regarding data privacy or wish to request data modification/deletion, please contact our support team at:
                        </p>
                        <p style="color: #0b5e36; font-weight: 700; margin: 0;">
                            <i class="fa fa-envelope me-2"></i> privacy@dewasharif.com | <i class="fa fa-phone me-2"></i> +91 94150 00000
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
