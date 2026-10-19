<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HostLok | Email Verification</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/adminlte.css') }}">

    <style>
        :root {
            --hostlok: #22C55E;
            --hostlok-dark: #16A34A
        }

        .card-outline.card-primary {
            border-top: 4px solid var(--hostlok) !important
        }

        .btn-hostlok {
            background: var(--hostlok);
            border-color: var(--hostlok);
            color: #fff
        }

        .btn-hostlok:hover {
            background: var(--hostlok-dark);
            border-color: var(--hostlok-dark);
            color: #fff
        }

        a {
            color: var(--hostlok)
        }

        .login-title {
            color: var(--hostlok);
            font-weight: 700;
            font-size: 34px
        }

        .form-control:focus {
            border-color: var(--hostlok);
            box-shadow: 0 0 0 .2rem rgba(34, 197, 94, .25)
        }
    </style>
</head>

<body class="login-page bg-body-secondary">

    <main class="login-box">
        <div class="card card-outline card-primary">

            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <div class="login-title">HostLok</div>
                </a>
            </div>

            <div class="card-body login-card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <p class="login-box-msg mb-1">Verify your email address</p>

                <p class="text-center text-muted small mb-3">
                    OTP sent to <strong>{{ $user->email }}</strong><br>
                    <span class="text-secondary">(Valid for 10 minutes)</span>
                </p>

                <form action="{{ request()->is('admin/*') ? route('admin.verify.otp.check', $user->id) : route('verify.otp.check', $user->id) }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="text" name="email_otp" class="form-control text-center fs-5 fw-bold letter-spacing" placeholder="Enter OTP"
                                maxlength="6" autofocus required>
                            <label>Enter 6-Digit OTP</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-shield-lock-fill"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-hostlok w-100 py-2">
                        <i class="bi bi-check-circle me-1"></i> Verify OTP
                    </button>

                </form>

                <div class="text-center mt-3">
                    <form id="resend-form" action="{{ request()->is('admin/*') ? route('admin.verify.otp.resend', $user->id) : route('verify.otp.resend', $user->id) }}" method="POST">
                        @csrf
                        <span class="text-muted small">Didn't receive the OTP?</span><br>
                        <button type="submit" id="resend-btn" class="btn btn-link text-decoration-none text-success fw-semibold p-0 mt-1">
                            <i class="bi bi-arrow-clockwise"></i> Resend OTP
                        </button>
                    </form>
                </div>

                <hr class="my-3">

                <p class="mb-0 text-center">
                    <a href="{{ request()->is('admin/*') ? route('admin.login') : route('login') }}" class="text-decoration-none">← Back to Login</a>
                </p>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/assets/js/adminlte.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resendBtn = document.getElementById('resend-btn');
            const resendForm = document.getElementById('resend-form');
            const timerText = document.getElementById('timer-text');
            const countdownEl = document.getElementById('countdown');

            // On click, show loading state
            if (resendForm) {
                resendForm.addEventListener('submit', function() {
                    resendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending OTP...';
                    resendBtn.disabled = true;
                });
            }
        });
    </script>

</body>

</html>
