@extends('home.includes.master')

@section('head-area')
    <title>Create an Account | DewaSharif</title>

    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Glassmorphism Auth CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/glass-auth.css') }}">
@endsection

@section('content')
    <section class="glass-auth-main-wrapper">
        <div class="glass-auth-wrapper register-box-wide">

            <div>
                <div class="dewa-logo-header">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="DewaSharif Logo"
                            onerror="this.src='{{ asset('home/images/dewasharif/dewalogos.png') }}'">
                        <div class="dewa-title">Create an Account</div>
                    </a>
                    <p class="dewa-subtitle">
                        Already have an account? <a href="{{ route('login') }}">Log In</a>
                    </p>
                </div>

                <div class="dewa-notice">
                    By creating an account, you agree to <a href="{{ url('/terms-of-use') }}"
                        target="_blank">www.dewasharif.com</a> Universal <a href="{{ url('/terms-of-use') }}"
                        target="_blank">Terms of Service</a> and <a href="{{ url('/privacy-policy') }}"
                        target="_blank">Privacy Policy</a>.
                </div>

                @if (session('success'))
                    <div class="alert-glass-success">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
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

                <form action="{{ route('admin.register.store') }}" method="POST">
                    @csrf

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 16px;">
                        <!-- First Name -->
                        <div class="input-field">
                            <input type="text" name="first_name" id="first_name" placeholder=" "
                                value="{{ old('first_name') }}" required autocomplete="off">
                            <label for="first_name">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                                    <defs>
                                        <linearGradient id="regUserHead" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#3b82f6"/>
                                            <stop offset="100%" stop-color="#1d4ed8"/>
                                        </linearGradient>
                                        <linearGradient id="regUserBody" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#60a5fa"/>
                                            <stop offset="100%" stop-color="#2563eb"/>
                                        </linearGradient>
                                    </defs>
                                    <circle cx="12" cy="7" r="4.5" fill="url(#regUserHead)"/>
                                    <path d="M4 19.5C4 15.91 7.58 13 12 13C16.42 13 20 15.91 20 19.5V20H4V19.5Z" fill="url(#regUserBody)"/>
                                </svg>
                                First Name*
                            </label>
                        </div>

                        <!-- Last Name -->
                        <div class="input-field">
                            <input type="text" name="last_name" id="last_name" placeholder=" "
                                value="{{ old('last_name') }}" autocomplete="off">
                            <label for="last_name">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                                    <defs>
                                        <linearGradient id="regUserHead2" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#3b82f6"/>
                                            <stop offset="100%" stop-color="#1d4ed8"/>
                                        </linearGradient>
                                        <linearGradient id="regUserBody2" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#60a5fa"/>
                                            <stop offset="100%" stop-color="#2563eb"/>
                                        </linearGradient>
                                    </defs>
                                    <circle cx="12" cy="7" r="4.5" fill="url(#regUserHead2)"/>
                                    <path d="M4 19.5C4 15.91 7.58 13 12 13C16.42 13 20 15.91 20 19.5V20H4V19.5Z" fill="url(#regUserBody2)"/>
                                </svg>
                                Last Name
                            </label>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 16px;">
                        <!-- Email Address -->
                        <div class="input-field">
                            <input type="email" name="email" id="email" placeholder=" " value="{{ old('email') }}" required
                                autocomplete="off">
                            <label for="email">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                                    <defs>
                                        <linearGradient id="regMailGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#ff4b4b"/>
                                            <stop offset="100%" stop-color="#dc2626"/>
                                        </linearGradient>
                                        <linearGradient id="regMailFlap" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#fbbf24"/>
                                            <stop offset="100%" stop-color="#f59e0b"/>
                                        </linearGradient>
                                    </defs>
                                    <rect x="2" y="4" width="20" height="16" rx="3.5" fill="url(#regMailGrad)"/>
                                    <path d="M2 7L12 13L22 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="13" r="2" fill="url(#regMailFlap)"/>
                                </svg>
                                Email Address*
                            </label>
                        </div>

                        <!-- Phone Number -->
                        <div class="input-field">
                            <input type="text" name="phone" id="phone" placeholder=" " value="{{ old('phone') }}" required
                                autocomplete="off">
                            <label for="phone">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                                    <defs>
                                        <linearGradient id="regPhoneGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#10b981"/>
                                            <stop offset="100%" stop-color="#047857"/>
                                        </linearGradient>
                                    </defs>
                                    <rect x="3" y="2" width="18" height="20" rx="3.5" fill="url(#regPhoneGrad)"/>
                                    <circle cx="12" cy="18" r="1.2" fill="#ffffff"/>
                                    <rect x="7" y="4" width="10" height="11" rx="1" fill="#ffffff" fill-opacity="0.2"/>
                                    <path d="M9.5 7.5C9.5 7.5 10.5 9 10.5 9.5C10.5 10 9.8 10.5 10.2 11.2C10.6 11.9 11.9 13.2 12.6 13.6C13.3 14 13.8 13.3 14.3 13.3" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"/>
                                </svg>
                                Phone Number*
                            </label>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="input-field">
                        <input type="text" name="address" id="address" placeholder=" " value="{{ old('address') }}"
                            autocomplete="off">
                        <label for="address">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                                <defs>
                                    <linearGradient id="regPinGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ef4444"/>
                                        <stop offset="100%" stop-color="#b91c1c"/>
                                    </linearGradient>
                                    <radialGradient id="regPinCore" cx="50%" cy="50%" r="50%">
                                        <stop offset="0%" stop-color="#fbbf24"/>
                                        <stop offset="100%" stop-color="#d97706"/>
                                    </radialGradient>
                                </defs>
                                <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z" fill="url(#regPinGrad)"/>
                                <circle cx="12" cy="9" r="3.5" fill="url(#regPinCore)"/>
                            </svg>
                            Address
                        </label>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 16px;">
                        <!-- Password -->
                        <div class="input-field">
                            <input type="password" name="password" id="password" placeholder=" " required>
                            <label for="password">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                                    <defs>
                                        <linearGradient id="regPassGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#fbbf24"/>
                                            <stop offset="100%" stop-color="#d97706"/>
                                        </linearGradient>
                                        <linearGradient id="regShackleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#38bdf8"/>
                                            <stop offset="100%" stop-color="#0284c7"/>
                                        </linearGradient>
                                    </defs>
                                    <rect x="4" y="10" width="16" height="11" rx="3" fill="url(#regPassGrad)"/>
                                    <path d="M7 10V6C7 3.24 9.24 1 12 1C14.76 1 17 3.24 17 6V10" stroke="url(#regShackleGrad)" stroke-width="2.5" stroke-linecap="round"/>
                                    <circle cx="12" cy="15" r="1.8" fill="#ffffff"/>
                                </svg>
                                Password*
                            </label>
                        </div>

                        <!-- Confirm Password -->
                        <div class="input-field">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" "
                                required>
                            <label for="password_confirmation">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                                    <defs>
                                        <linearGradient id="regPassGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#fbbf24"/>
                                            <stop offset="100%" stop-color="#d97706"/>
                                        </linearGradient>
                                        <linearGradient id="regShackleGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#38bdf8"/>
                                            <stop offset="100%" stop-color="#0284c7"/>
                                        </linearGradient>
                                    </defs>
                                    <rect x="4" y="10" width="16" height="11" rx="3" fill="url(#regPassGrad2)"/>
                                    <path d="M7 10V6C7 3.24 9.24 1 12 1C14.76 1 17 3.24 17 6V10" stroke="url(#regShackleGrad2)" stroke-width="2.5" stroke-linecap="round"/>
                                    <circle cx="12" cy="15" r="1.8" fill="#ffffff"/>
                                </svg>
                                Confirm Password*
                            </label>
                        </div>
                    </div>

                    <!-- Terms & Conditions Checkbox -->
                    <div class="forget-row" style="margin: 12px 0 14px 0;">
                        <label for="terms">
                            <input type="checkbox" name="terms" id="terms" required>
                            <p>I agree to the <a href="{{ url('/terms-of-use') }}" target="_blank">Terms and Conditions</a>
                                and <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy Policy</a>*</p>
                        </label>
                    </div>

                    <!-- Create Account Button -->
                    <button type="submit" class="btn-glass-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="margin-right: 6px; vertical-align: middle;">
                            <circle cx="10" cy="8" r="4" fill="#ffffff" fill-opacity="0.9"/>
                            <path d="M3 19C3 15.7 6.1 13 10 13C11.5 13 12.9 13.4 14 14.1" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <path d="M18 11V17M15 14H21" stroke="#ffeb3b" stroke-width="2.5" stroke-linecap="round"/>
                        </svg> Create Account
                    </button>

                </form>
            </div>

            <div>
                <div class="auth-divider">
                    <span>OR</span>
                </div>

                <!-- Google Register -->
                <a href="{{ route('google.login') }}" class="btn-glass-google">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                    </svg>
                    <span>Sign Up with Google</span>
                </a>
            </div>

        </div>

    </section>
@endsection