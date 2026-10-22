@extends('home.includes.master')

@section('head-area')
    <title>Login | DewaSharif</title>

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
    <div class="glass-auth-wrapper">

        <div>
            <div class="dewa-logo-header">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="DewaSharif Logo"
                        onerror="this.src='{{ asset('home/images/dewasharif/dewalogos.png') }}'">
                    <div class="dewa-title">Dewa Sharif</div>
                </a>
                <p class="dewa-subtitle">Login to your DewaSharif Account</p>
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

            <form action="{{ route('admin.login.store') }}" method="POST">
                @csrf

                <!-- Email or Phone -->
                <div class="input-field">
                    <label for="email_or_phone">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                            <defs>
                                <linearGradient id="loginMailGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ff4b4b"/>
                                    <stop offset="100%" stop-color="#dc2626"/>
                                </linearGradient>
                                <linearGradient id="loginMailFlap" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fbbf24"/>
                                    <stop offset="100%" stop-color="#f59e0b"/>
                                </linearGradient>
                            </defs>
                            <rect x="2" y="4" width="20" height="16" rx="3.5" fill="url(#loginMailGrad)"/>
                            <path d="M2 7L12 13L22 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="13" r="2" fill="url(#loginMailFlap)"/>
                        </svg>
                        Email Address / Phone Number
                    </label>
                    <div class="input-box-inner">
                        <input type="text" name="email_or_phone" id="email_or_phone" placeholder="Enter email or phone number"
                            value="{{ old('email_or_phone') }}" required autocomplete="off">
                    </div>
                </div>

                <!-- Password -->
                <div class="input-field">
                    <label for="password">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: sub; margin-right: 4px;">
                            <defs>
                                <linearGradient id="loginPassGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#fbbf24"/>
                                    <stop offset="100%" stop-color="#d97706"/>
                                </linearGradient>
                                <linearGradient id="loginShackleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#38bdf8"/>
                                    <stop offset="100%" stop-color="#0284c7"/>
                                </linearGradient>
                            </defs>
                            <rect x="4" y="10" width="16" height="11" rx="3" fill="url(#loginPassGrad)"/>
                            <path d="M7 10V6C7 3.24 9.24 1 12 1C14.76 1 17 3.24 17 6V10" stroke="url(#loginShackleGrad)" stroke-width="2.5" stroke-linecap="round"/>
                            <circle cx="12" cy="15" r="1.8" fill="#ffffff"/>
                        </svg>
                        Password
                    </label>
                    <div class="input-box-inner">
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-password-btn" data-target="password" title="Show / Hide Password" aria-label="Toggle password visibility">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="forget-row">
                    <label for="remember">
                        <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        <p>Remember me</p>
                    </label>
                    <a href="{{ route('forgot.password') }}">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-glass-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="margin-right: 6px; vertical-align: middle;">
                        <path d="M11 16L15 12L11 8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15 12H3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M14 4H18C19.1 4 20 4.9 20 6V18C20 19.1 19.1 20 18 20H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg> Log In
                </button>
            </form>
        </div>

        <div>
            <div class="auth-divider">
                <span>OR</span>
            </div>

            <!-- Google Login -->
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
                <span>Continue with Google</span>
            </a>

            <!-- Register Link -->
            <div class="register-footer">
                Don't have an account? <a href="{{ route('admin.register') }}">Register</a>
            </div>
        </div>

    </div>
</section>
@endsection
