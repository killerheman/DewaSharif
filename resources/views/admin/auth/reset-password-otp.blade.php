@extends('home.includes.master')

@section('head-area')
    <title>Set New Password | DewaSharif</title>

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

        <div class="dewa-logo-header">
            <a href="{{ url('/') }}" style="text-decoration: none;">
                <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="DewaSharif Logo" onerror="this.src='{{ asset('home/images/dewasharif/dewalogos.png') }}'">
                <div class="dewa-title">Reset Password</div>
            </a>
            <p class="dewa-subtitle">Create a new secure password for your account</p>
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

        <form action="{{ route('forgot.password.reset.submit') }}" method="POST">
            @csrf

            <!-- New Password -->
            <div class="input-field">
                <input type="password" name="password" id="password"
                    placeholder=" " required>
                <label for="password">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                        <defs>
                            <linearGradient id="resetPassGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#fbbf24"/>
                                <stop offset="100%" stop-color="#d97706"/>
                            </linearGradient>
                            <linearGradient id="resetShackleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#38bdf8"/>
                                <stop offset="100%" stop-color="#0284c7"/>
                            </linearGradient>
                        </defs>
                        <rect x="4" y="10" width="16" height="11" rx="3" fill="url(#resetPassGrad)"/>
                        <path d="M7 10V6C7 3.24 9.24 1 12 1C14.76 1 17 3.24 17 6V10" stroke="url(#resetShackleGrad)" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="12" cy="15" r="1.8" fill="#ffffff"/>
                    </svg>
                    New Password*
                </label>
            </div>

            <!-- Confirm Password -->
            <div class="input-field">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder=" " required>
                <label for="password_confirmation">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                        <defs>
                            <linearGradient id="resetPassGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#fbbf24"/>
                                <stop offset="100%" stop-color="#d97706"/>
                            </linearGradient>
                            <linearGradient id="resetShackleGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#38bdf8"/>
                                <stop offset="100%" stop-color="#0284c7"/>
                            </linearGradient>
                        </defs>
                        <rect x="4" y="10" width="16" height="11" rx="3" fill="url(#resetPassGrad2)"/>
                        <path d="M7 10V6C7 3.24 9.24 1 12 1C14.76 1 17 3.24 17 6V10" stroke="url(#resetShackleGrad2)" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="12" cy="15" r="1.8" fill="#ffffff"/>
                    </svg>
                    Confirm New Password*
                </label>
            </div>

            <div style="margin-top: 24px;">
                <!-- Reset Password Button -->
                <button type="submit" class="btn-glass-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="margin-right: 6px; vertical-align: middle;">
                        <path d="M21 2L11 12" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="7" cy="16" r="4" fill="#ffeb3b" stroke="#ffffff" stroke-width="1.5"/>
                        <path d="M10 13L15 18M13 16L16 19" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg> Reset Password
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="register-footer" style="margin-top: 24px;">
            <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i> Back to Login</a>
        </div>

    </div>
</section>
@endsection
