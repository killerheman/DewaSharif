@extends('home.includes.master')

@section('title', 'Contact Us | Dewa Sharif Ziyarat & Support')

@section('head-area')
    <style>
        .contact-hero-wrapper {
            background: linear-gradient(180deg, #f0fdf4 0%, #f8fafc 100%);
            padding: 60px 0 110px 0 !important;
            min-height: 85vh;
        }

        .contact-card-box {
            background: #ffffff !important;
            border-radius: 24px !important;
            border: 1px solid rgba(226, 232, 240, 0.9) !important;
            padding: 40px 35px !important;
            box-shadow: 0 12px 35px -5px rgba(15, 23, 42, 0.06) !important;
            transition: all 0.3s ease;
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            text-align: left !important;
            width: 100% !important;
        }

        .contact-card-box:hover {
            box-shadow: 0 20px 45px -5px rgba(15, 23, 42, 0.1) !important;
        }

        .card-header-bar {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin-bottom: 25px !important;
            padding-bottom: 14px !important;
            border-bottom: 2.5px solid #16a34a !important;
            box-shadow: 0 3px 10px rgba(22, 163, 74, 0.18) !important;
        }

        .header-badge-green {
            background: linear-gradient(135deg, #0b5e36 0%, #16a34a 100%) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 12.5px !important;
            padding: 7px 18px !important;
            border-radius: 50px !important;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.35) !important;
            border: none !important;
            white-space: nowrap !important;
            letter-spacing: 0.3px !important;
        }

        .contact-form-wrapper {
            display: flex !important;
            flex-direction: column !important;
            flex-grow: 1 !important;
            justify-content: space-between !important;
        }

        .info-card-item {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            text-align: left !important;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 18px !important;
            transition: all 0.2s ease;
        }

        .info-card-item:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
        }

        .info-icon-badge {
            width: 46px !important;
            height: 46px !important;
            min-width: 46px !important;
            border-radius: 14px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 19px !important;
            margin-right: 16px !important;
            flex-shrink: 0 !important;
        }

        .badge-emerald {
            background: #e8f5e9 !important;
            color: #15803d !important;
        }

        .badge-sapphire {
            background: #e0f2fe !important;
            color: #0284c7 !important;
        }

        .badge-amber {
            background: #fef3c7 !important;
            color: #b45309 !important;
        }

        .badge-purple {
            background: #f3e8ff !important;
            color: #7e22ce !important;
        }

        .info-text-content {
            flex: 1 1 auto !important;
            text-align: left !important;
        }

        .info-item-title {
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 3px !important;
            text-align: left !important;
            display: block !important;
        }

        .info-item-desc {
            font-size: 13.5px !important;
            color: #64748b !important;
            line-height: 1.5 !important;
            margin-bottom: 0 !important;
            text-align: left !important;
            display: block !important;
        }

        .btn-wa-pill {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            background: #25d366 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            padding: 8px 18px !important;
            border-radius: 50px !important;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35) !important;
            transition: all 0.2s ease;
            margin-top: 10px !important;
        }

        .btn-wa-pill:hover {
            background: #20ba5a !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 18px rgba(37, 211, 102, 0.45) !important;
            color: #ffffff !important;
        }

        .quick-assistance-bottom {
            margin-top: auto !important;
            padding-top: 20px !important;
            border-top: 2px solid #f1f5f9 !important;
        }

        .assistance-pill {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 10px 22px !important;
            border-radius: 50px !important;
            font-size: 13.5px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            transition: all 0.25s ease !important;
            white-space: nowrap !important;
            border: none !important;
        }

        .assistance-pill-green {
            background: linear-gradient(135deg, #0b5e36 0%, #16a34a 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.35) !important;
        }

        .assistance-pill-green:hover {
            background: linear-gradient(135deg, #094d2c 0%, #15803d 100%) !important;
            color: #ffffff !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 18px rgba(22, 163, 74, 0.45) !important;
        }

        .assistance-pill-yellow {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35) !important;
        }

        .assistance-pill-yellow:hover {
            background: linear-gradient(135deg, #b45309 0%, #d97706 100%) !important;
            color: #ffffff !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 18px rgba(217, 119, 6, 0.45) !important;
        }

        .form-row-space {
            margin-bottom: 24px !important;
        }

        .form-custom-label {
            font-weight: 700 !important;
            color: #334155 !important;
            font-size: 14px !important;
            margin-bottom: 8px !important;
            display: block !important;
            text-align: left !important;
        }

        .form-custom-input {
            border-radius: 12px !important;
            border: 1.5px solid #cbd5e1 !important;
            height: 50px !important;
            font-size: 14.5px !important;
            padding: 12px 18px !important;
            background-color: #f8fafc !important;
            transition: all 0.2s ease-in-out !important;
        }

        .form-custom-input:focus {
            background-color: #ffffff !important;
            border-color: #16a34a !important;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.15) !important;
            outline: none !important;
        }

        .form-custom-textarea {
            border-radius: 12px !important;
            border: 1.5px solid #cbd5e1 !important;
            font-size: 14.5px !important;
            padding: 14px 18px !important;
            background-color: #f8fafc !important;
            transition: all 0.2s ease-in-out !important;
            min-height: 145px !important;
            resize: none !important;
        }

        .form-custom-textarea:focus {
            background-color: #ffffff !important;
            border-color: #16a34a !important;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.15) !important;
            outline: none !important;
        }

        .btn-submit-hero {
            border-radius: 12px !important;
            background: linear-gradient(135deg, #0b5e36 0%, #16a34a 100%) !important;
            border: none !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            padding: 16px 28px !important;
            box-shadow: 0 8px 24px -4px rgba(22, 163, 74, 0.4) !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
        }

        .btn-submit-hero:hover {
            background: linear-gradient(135deg, #094d2c 0%, #15803d 100%) !important;
            box-shadow: 0 12px 28px -4px rgba(22, 163, 74, 0.55) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }

        .submit-btn-wrapper {
            margin-top: auto !important;
            padding-top: 10px !important;
        }
    </style>
@endsection

@section('content')
    @php
        $sitePhone = $setting->website_phone ?: ($setting->phone ?: ($setting->support_phone ?: '+91 9648777223'));
        $siteWhatsapp = $setting->whatsapp ?: $sitePhone;
        $siteEmail = $setting->website_email ?: ($setting->company_email ?: 'info@dewasharif.com');
        $siteAddress = $setting->address ?: 'Dewa Sharif, Barabanki, Uttar Pradesh - 225301, India';
    @endphp
    <div class="contact-hero-wrapper">
        <div class="container">

            <!-- HEADER TITLE -->
            <div class="text-center mb-5 pb-2">
                <span class="badge"
                    style="background: #dcfce7; color: #15803d; font-weight: 800; font-size: 13px; padding: 10px 22px; border-radius: 50px; letter-spacing: 0.3px; border: 1px solid #bbf7d0;">
                    🤝 Pilgrim Support & Guidance
                </span>
                <h1 class="mt-3 fw-bold" style="color: #0b5e36; font-size: 36px; letter-spacing: -0.5px;">
                    Contact Dewa Sharif Portal
                </h1>
                <p class="text-muted"
                    style="display: block; width: 100%; text-align: center !important; margin: 12px auto 0 auto !important; padding: 0 30px !important; font-size: 15.5px; line-height: 1.6; color: #0b5e36; font-weight: 500;">
                    Have questions about Hotel Stays, Cabs Booking, Degh Niyaz, Dewa Sharif Mela 2026? Drop us a message below and we'll get right back to you!
                </p>
            </div>

            <div class="row g-4 g-lg-5 align-items-stretch justify-content-center">

                <!-- LEFT COLUMN: CONTACT DETAILS -->
                <div class="col-lg-5 col-md-6 mb-4 d-flex">
                    <div class="contact-card-box">
                        <div>
                            <div class="card-header-bar">
                                <h4 class="fw-bold m-0 d-flex align-items-center" style="color: #0f172a; font-size: 20px; margin-left: 10px;">
                                    <i class="fa fa-map-marker text-success me-2 pe-1" style="margin-right: 10px;"></i> Visit
                                    Our Office
                                </h4>
                                <span class="header-badge-green">
                                    📍Our Office
                                </span>
                            </div>

                            <!-- Item 1: Address -->
                            <div class="info-card-item">
                                <div class="info-icon-badge badge-emerald">
                                    <i class="fa fa-building"></i>
                                </div>
                                <div class="info-text-content">
                                    <span class="info-item-title">www.dewasharif.com</span>
                                    <p class="info-item-desc">
                                        {{ $siteAddress }}
                                    </p>
                                </div>
                            </div>

                            <!-- Item 2: Phone & WhatsApp -->
                            <div class="info-card-item">
                                <div class="info-icon-badge badge-sapphire">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="info-text-content">
                                    <span class="info-item-title">Phone & WhatsApp Helpline</span>
                                    <p class="info-item-desc">{{ $sitePhone }} (Management & Duty Support)</p>
                                    <div>
                                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteWhatsapp) }}?text=Assalam%20Alaikum,%20Mujhe%20Dewa%20Sharif%20ziyarat%20help%20chahiye"
                                            target="_blank" class="btn-wa-pill">
                                            <i class="fa fa-whatsapp"></i> WhatsApp Us
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Item 3: Email -->
                            <div class="info-card-item">
                                <div class="info-icon-badge badge-amber">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="info-text-content">
                                    <span class="info-item-title">Official Email</span>
                                    <a href="mailto:{{ $siteEmail }}" target="_blank" rel="noopener"
                                        class="info-item-desc text-decoration-none"
                                        style="color: #0284c7 !important; font-weight: 600;">
                                        {{ $siteEmail }}
                                    </a>
                                </div>
                            </div>

                            <!-- Item 4: Office Timings -->
                            <div class="info-card-item">
                                <div class="info-icon-badge badge-purple">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="info-text-content">
                                    <span class="info-item-title">Support Hours</span>
                                    <p class="info-item-desc">Available 7 Days: 09:00 AM – 11:00 PM IST</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Assistance Options -->
                        <div class="quick-assistance-bottom">
                            <h6 class="fw-bold mb-3" style="color: #0f172a; font-size: 14.5px;">Quick Assistance Options
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('customer.reportIssue') }}" class="assistance-pill assistance-pill-green">
                                    🎫 Report Issue in My Account
                                </a>
                                <a href="{{ route('faqs') }}" class="assistance-pill assistance-pill-yellow">
                                    ❓ View Dewa FAQs
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: CONTACT FORM -->
                <div class="col-lg-7 col-md-6 mb-4 d-flex">
                    <div class="contact-card-box">
                        <div>
                            <div class="card-header-bar">
                                <h4 class="fw-bold m-0 d-flex align-items-center" style="color: #0f172a; font-size: 20px; margin-left: 10px;">
                                    <i class="fa fa-paper-plane text-success me-2 pe-1" style="margin-right: 10px;"></i> Send us a Message
                                </h4>
                                <span class="header-badge-green">
                                    ⚡ Quick Response
                                </span>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4"
                                    role="alert"
                                    style="background: #dcfce7; color: #15803d; border: 1.5px solid #86efac; padding: 15px 20px;">
                                    <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger rounded-3 shadow-sm mb-4"
                                    style="background: #fef2f2; color: #991b1b; border: 1.5px solid #fca5a5; padding: 15px 20px;">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('contact.store') }}" method="POST" class="contact-form-wrapper">
                            @csrf

                            <div>
                                <div class="row form-row-space">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-custom-label">Your Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" required class="form-control form-custom-input"
                                            placeholder="Enter full name" value="{{ old('name') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-custom-label">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" required class="form-control form-custom-input"
                                            placeholder="name@domain.com" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="row form-row-space">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-custom-label">Mobile / Phone No. <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="mobile" required class="form-control form-custom-input"
                                            placeholder="+91 XXXXX XXXXX" value="{{ old('mobile') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-custom-label">Subject <span class="text-danger">*</span></label>
                                        <input type="text" name="subject" required class="form-control form-custom-input"
                                            placeholder="Subject / Topic of inquiry"
                                            value="{{ old('subject', request('subject')) }}">
                                    </div>
                                </div>

                                <div class="form-row-space mb-0">
                                    <label class="form-custom-label">Message Details <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" required class="form-control form-custom-textarea" rows="5"
                                        placeholder="Describe your request or question in detail...">{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <div class="submit-btn-wrapper">
                                <button type="submit" class="btn-submit-hero">
                                    <i class="fa fa-paper-plane me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection