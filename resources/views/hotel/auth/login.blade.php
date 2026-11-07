<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Partner Login - www.dewasharif.com</title>
    <link rel="icon" href="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" type="image/png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #052c16 0%, #031c0e 50%, #021208 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 20% 80%, rgba(217, 119, 6, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 20px;
            padding: 36px 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            position: relative;
            z-index: 10;
        }
        .logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .logo-wrap img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 2px solid #10b981;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            border: 1.5px solid #cbd5e1;
        }
        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        .btn-partner-login {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 800;
            padding: 13px;
            border-radius: 10px;
            font-size: 15px;
            border: none;
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
            transition: all 0.2s;
        }
        .btn-partner-login:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(16, 185, 129, 0.45);
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-wrap">
            <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="Logo">
            <div>
                <h4 class="mb-0 fw-bold text-dark">www.dewasharif.com</h4>
                <small class="text-success fw-bold text-uppercase" style="letter-spacing: 1px;">Hotel Partner Portal</small>
            </div>
        </div>

        <h5 class="fw-bold text-dark mb-1">Partner Sign In</h5>
        <p class="text-muted mb-4" style="font-size: 13px;">Manage guest room bookings, check-in PINs &amp; direct 80% payouts.</p>

        @if(session('success'))
            <div class="alert alert-success py-2 px-3 mb-3 border-0" style="border-radius: 8px; font-size: 13px;">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger py-2 px-3 mb-3 border-0" style="border-radius: 8px; font-size: 13px;">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
            </div>
        @endif

        <form action="{{ route('hotel.login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold text-dark" style="font-size: 13px;">Email or Registered Mobile Number</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                    <input type="text" name="login" class="form-control border-start-0" placeholder="e.g. partner@hotel.com or 9648777223" value="{{ old('login') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 13px;">Password</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" id="passwordInput" name="password" class="form-control border-start-0 border-end-0" placeholder="••••••••" required>
                    <button type="button" class="input-group-text bg-light border-start-0 text-muted" id="togglePassword">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                    <label class="form-check-label text-muted" for="rememberMe" style="font-size: 13px;">Remember me</label>
                </div>
                <a href="{{ route('contact') }}" class="text-success text-decoration-none fw-semibold" style="font-size: 13px;">Need help?</a>
            </div>

            <button type="submit" class="btn btn-partner-login w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Access Hotel Panel
            </button>
        </form>

        <div class="text-center pt-3 border-top mt-3">
            <span class="text-muted" style="font-size: 13px;">Own a Guest House in Dewa Sharif?</span><br>
            <a href="{{ route('hotel.register') }}" class="text-success fw-bold text-decoration-none" style="font-size: 13.5px;">
                Register Your Hotel / Guest House <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            });
        }
    </script>
</body>
</html>
