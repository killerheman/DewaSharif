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

            <form action="{{ route('forgot.password.store') }}" method="POST" style="margin-top: 10px;">
                @csrf

                <!-- Registered Email Address -->
                <div class="input-field">
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
                    <div class="input-box-inner">
                        <input type="email" name="email" id="email"
                            placeholder="Enter your registered email address" value="{{ old('email') }}" required autocomplete="off">
                    </div>
                </div>

                <div style="margin-top: 14px;">
                    <!-- Submit Button -->
                    <button type="submit" class="btn-glass-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="margin-right: 6px; vertical-align: middle;">
                            <path d="M22 2L11 13" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 2L15 22L11 13L2 9L22 2Z" fill="#ffeb3b" fill-opacity="0.3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg> Send Verification Code
                    </button>
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