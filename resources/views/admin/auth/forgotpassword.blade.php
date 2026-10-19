@extends('home.includes.master')

@section('head-area')
    <title>Forgot Password | DewaSharif</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Glassmorphism Auth CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/glass-auth.css') }}">
@endsection

@section('content')
<section class="glass-auth-main-wrapper">
    <div class="glass-auth-wrapper">

        <div>
            <div class="dewa-logo-header">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="DewaSharif Logo" onerror="this.src='{{ asset('home/images/dewasharif/dewalogos.png') }}'">
                    <div class="dewa-title">Forgot Password</div>
                </a>
                <p class="dewa-subtitle">Enter your email address to receive a 6-digit verification OTP</p>
            </div>

            @if (session('success'))
                <div class="alert-glass-success">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-glass-danger">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-glass-danger">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="forgot-info-box">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" style="margin-bottom: 6px;">
                    <defs>
                        <linearGradient id="forgotShieldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#00e676"/>
                            <stop offset="100%" stop-color="#00b0ff"/>
                        </linearGradient>
                    </defs>
                    <path d="M12 2L4 5V11C4 16.55 7.4 21.74 12 23C16.6 21.74 20 16.55 20 11V5L12 2Z" fill="url(#forgotShieldGrad)" fill-opacity="0.3" stroke="url(#forgotShieldGrad)" stroke-width="2"/>
                    <rect x="9" y="11" width="6" height="5" rx="1" fill="#ffeb3b"/>
                    <path d="M10.5 11V9.5C10.5 8.67 11.17 8 12 8C12.83 8 13.5 8.67 13.5 9.5V11" stroke="#ffeb3b" stroke-width="1.5" stroke-linecap="round"/>
                </svg><br>
                <strong style="font-size: 17px;">Secure Account Recovery</strong>
                <p style="margin-top: 6px; font-size: 15px; color: rgba(255, 255, 255, 0.95); line-height: 1.45;">
                    Enter your registered email address below. We will send a confidential 6-digit OTP code to verify and safely reset your password.
                </p>
            </div>

            <form action="{{ route('forgot.password.store') }}" method="POST" style="margin-top: 14px;">
                @csrf

                <!-- Registered Email Address -->
                <div class="input-field">
                    <input type="email" name="email" id="email"
                        placeholder=" " value="{{ old('email') }}" required autocomplete="off">
                    <label for="email">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                            <defs>
                                <linearGradient id="forgotMailGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ff4b4b"/>
                                    <stop offset="100%" stop-color="#dc2626"/>
                                </linearGradient>
                                <linearGradient id="forgotMailFlap" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fbbf24"/>
                                    <stop offset="100%" stop-color="#f59e0b"/>
                                </linearGradient>
                            </defs>
                            <rect x="2" y="4" width="20" height="16" rx="3.5" fill="url(#forgotMailGrad)"/>
                            <path d="M2 7L12 13L22 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="13" r="2" fill="url(#forgotMailFlap)"/>
                        </svg>
                        Registered Email Address*
                    </label>
                </div>

                <div style="margin-top: 18px;">
                    <!-- Submit Button -->
                    <button type="submit" class="btn-glass-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="margin-right: 6px; vertical-align: middle;">
                            <path d="M22 2L11 13" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 2L15 22L11 13L2 9L22 2Z" fill="#ffeb3b" fill-opacity="0.3" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg> Send Verification Code
                    </button>
                </div>

                <div class="security-tips-box">
                    <span><i class="bi bi-shield-check me-1" style="color: #00e676;"></i> 256-bit Encrypted</span>
                    <span><i class="bi bi-clock-history me-1" style="color: #00e676;"></i> 10 Min OTP Expiry</span>
                </div>
            </form>
        </div>

        <div>
            <div class="auth-divider">
                <span>OR</span>
            </div>

            <!-- Back to Login -->
            <div class="register-footer">
                Remembered your password? <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i> Back to Login</a>
            </div>
        </div>

    </div>
</section>
@endsection