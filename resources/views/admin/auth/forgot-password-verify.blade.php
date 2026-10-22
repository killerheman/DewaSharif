@extends('home.includes.master')

@section('head-area')
    <title>Verify OTP | DewaSharif</title>

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
                <div class="dewa-title">Verify OTP Code</div>
            </a>
            <p class="dewa-subtitle">
                OTP sent to <strong style="color: var(--dewagreen-bright);">{{ $user->email ?? 'your email' }}</strong>
            </p>
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

        <form action="{{ route('forgot.password.verify.check', $user->id ?? 1) }}" method="POST">
            @csrf

            <!-- 6-digit OTP -->
            <div class="input-field">
                <label for="email_otp">
                    <svg width="18" height="18" viewBox="0 0 24 24" style="margin-right: 4px; vertical-align: text-bottom;"><path fill="#34A853" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    Enter 6-Digit OTP Code
                </label>
                <div class="input-box-inner">
                    <input type="text" name="email_otp" id="email_otp"
                        placeholder="Enter 6-digit OTP" maxlength="6" required autocomplete="off" style="letter-spacing: 4px; font-size: 18px; font-weight: 700; text-align: center;">
                </div>
            </div>

            <div style="margin-top: 16px;">
                <!-- Verify Button -->
                <button type="submit" class="btn-glass-primary">
                    <i class="bi bi-shield-check me-1"></i> Verify Code
                </button>
            </div>
        </form>

        <!-- Resend Link -->
        <div class="register-footer" style="margin-top: 16px;">
            Didn't receive the code? <a href="{{ route('forgot.password') }}">Resend OTP</a>
        </div>

    </div>
</section>
@endsection
