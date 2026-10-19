<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Change Password | HostLok</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/adminlte.css') }}">

    <style>
        :root {
            --hostlok: #22C55E;
            --hostlok-dark: #16A34A;
        }

        .card-outline.card-primary {
            border-top: 4px solid var(--hostlok) !important;
        }

        .btn-hostlok {
            background: var(--hostlok);
            border-color: var(--hostlok);
            color: #fff;
        }

        .btn-hostlok:hover {
            background: var(--hostlok-dark);
            border-color: var(--hostlok-dark);
            color: #fff;
        }

        a {
            color: var(--hostlok);
        }

        .login-title {
            color: var(--hostlok);
            font-weight: 700;
            font-size: 34px;
        }

        .form-control:focus {
            border-color: var(--hostlok);
            box-shadow: 0 0 0 .2rem rgba(34, 197, 94, .25);
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
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <p class="login-box-msg">Verify Change Password</p>
                <p class="text-center small text-muted">A verification code has been sent to <strong>{{ auth()->user()->email }}</strong></p>

                <form action="{{ route('admin.change.password.verify.check') }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="text" name="email_otp" class="form-control" placeholder="Enter 6-digit OTP"
                                maxlength="6" autocomplete="off" required>
                            <label>Enter 6-Digit OTP</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-shield-lock-fill"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-hostlok w-100 fw-bold">
                        <i class="bi bi-shield-check me-1"></i> Verify & Update
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="{{ asset('admin/assets/js/adminlte.js') }}"></script>
</body>
</html>
