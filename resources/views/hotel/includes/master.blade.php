<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hotel Partner Portal') - DewaSharif.com</title>
    <link rel="icon" href="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" type="image/png">
    
    <!-- Google Fonts & Bootstrap 5 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --ds-green: #052c16;
            --ds-emerald: #10b981;
            --ds-gold: #d97706;
            --ds-dark: #0f172a;
            --ds-sidebar-w: 270px;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .partner-sidebar {
            width: var(--ds-sidebar-w);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background: linear-gradient(180deg, #052c16 0%, #031c0e 100%);
            color: #ffffff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
        }
        .partner-brand {
            padding: 22px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
        }
        .partner-brand img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid #10b981;
        }
        .partner-brand-text h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.3px;
        }
        .partner-brand-text span {
            font-size: 11px;
            color: #10b981;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .partner-nav {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
        }
        .nav-category {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 800;
            padding: 12px 14px 6px;
        }
        .partner-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }
        .partner-nav-link i {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.2s;
        }
        .partner-nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }
        .partner-nav-link:hover i {
            color: #10b981;
        }
        .partner-nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }
        .partner-nav-link.active i {
            color: #ffffff;
        }
        .partner-footer-card {
            padding: 16px;
            margin: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            font-size: 12px;
        }

        /* Top Navbar */
        .partner-header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--ds-sidebar-w);
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            z-index: 1030;
            transition: left 0.3s;
        }
        .partner-main {
            margin-left: var(--ds-sidebar-w);
            padding-top: 70px;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }
        .content-body {
            padding: 28px;
        }

        /* Gradient Dashboard Cards (Green, Yellow, Blue, Red) */
        .stat-box {
            border-radius: 16px;
            padding: 22px 20px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #ffffff;
            height: 100%;
            min-height: 185px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .stat-box:hover {
            transform: translateY(-4px);
        }
        .stat-box::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.28) 0%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
            border-radius: 50%;
        }
        .stat-box .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            letter-spacing: -0.2px;
            margin-bottom: 0;
        }
        .stat-box .stat-badge {
            font-size: 11px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(4px);
            color: #ffffff;
            border-radius: 20px;
            padding: 4px 10px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            white-space: nowrap;
        }
        .stat-box .stat-value {
            font-size: 30px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            line-height: 1.15;
            margin: 0;
            text-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }
        .stat-box .stat-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            gap: 5px;
            margin: 0;
        }

        /* 1. GREEN (Gross Bookings) */
        .bg-card-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #044e32 100%);
            box-shadow: 0 10px 24px -4px rgba(16, 185, 129, 0.42);
        }
        .bg-card-green:hover {
            box-shadow: 0 14px 28px -2px rgba(16, 185, 129, 0.52);
        }

        /* 2. YELLOW (Platform Commission) */
        .bg-card-yellow {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #78350f 100%);
            box-shadow: 0 10px 24px -4px rgba(217, 119, 6, 0.42);
        }
        .bg-card-yellow:hover {
            box-shadow: 0 14px 28px -2px rgba(217, 119, 6, 0.52);
        }

        /* 3. BLUE (Partner Net Take-Home) */
        .bg-card-blue {
            background: linear-gradient(135deg, #38bdf8 0%, #0284c7 50%, #034875 100%);
            box-shadow: 0 10px 24px -4px rgba(2, 132, 199, 0.42);
        }
        .bg-card-blue:hover {
            box-shadow: 0 14px 28px -2px rgba(2, 132, 199, 0.52);
        }

        /* 4. RED (Current Unpaid Balance) */
        .bg-card-red {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #7f1d1d 100%);
            box-shadow: 0 10px 24px -4px rgba(220, 38, 38, 0.42);
        }
        .bg-card-red:hover {
            box-shadow: 0 14px 28px -2px rgba(220, 38, 38, 0.52);
        }

        /* Legacy palette fallbacks */
        .bg-card-purple {
            background: linear-gradient(135deg, #c084fc 0%, #7c3aed 48%, #3b0764 100%);
            box-shadow: 0 8px 20px -3px rgba(124, 58, 237, 0.35);
        }
        .bg-card-gold {
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 48%, #78350f 100%);
            box-shadow: 0 8px 20px -3px rgba(217, 119, 6, 0.35);
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .partner-sidebar {
                transform: translateX(-100%);
            }
            .partner-sidebar.show {
                transform: translateX(0);
            }
            .partner-header {
                left: 0;
            }
            .partner-main {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="partner-sidebar" id="partnerSidebar">
        <a href="{{ route('hotel.dashboard') }}" class="partner-brand">
            <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="Logo">
            <div class="partner-brand-text">
                <h5>{{ auth('hotel')->user()->hotel_name ?: 'Dewa Partner' }}</h5>
                <span>Vendor Portal</span>
            </div>
        </a>

        <div class="partner-nav">
            <div class="nav-category">Main Operations</div>
            <a href="{{ route('hotel.dashboard') }}" class="partner-nav-link {{ Route::is('hotel.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard Overview</span>
            </a>
            <a href="{{ route('hotel.bookings') }}" class="partner-nav-link {{ Route::is('hotel.bookings*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Guest Reservations</span>
            </a>

            <div class="nav-category">Room Master (CRUD)</div>
            <a href="{{ route('hotel.rooms') }}" class="partner-nav-link {{ Route::is('hotel.rooms') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Manage Rooms</span>
            </a>
            <a href="{{ route('hotel.rooms.create') }}" class="partner-nav-link {{ Route::is('hotel.rooms.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span>List New Room</span>
            </a>

            <div class="nav-category">Financials &amp; Settlements</div>
            <a href="{{ route('hotel.settlements') }}" class="partner-nav-link {{ Route::is('hotel.settlements*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i>
                <span>Payouts Passbook</span>
            </a>
            <a href="{{ route('hotel.profile') }}" class="partner-nav-link {{ Route::is('hotel.profile*') ? 'active' : '' }}">
                <i class="bi bi-bank"></i>
                <span>Bank &amp; UPI Account</span>
            </a>
        </div>

        <div class="partner-footer-card">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-shield-check text-success fs-5"></i>
                <strong class="text-white">Admin Settlement Desk</strong>
            </div>
            <p class="text-white-50 mb-0" style="font-size: 11px;">
                Payments reconciled &amp; paid every 3 days by DewaSharif Admin.
            </p>
        </div>
    </aside>

    <!-- HEADER -->
    <header class="partner-header">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-lg-none" id="sidebarToggleBtn">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <h6 class="mb-0 fw-bold text-dark d-none d-sm-block">
                    🏨 {{ auth('hotel')->user()->hotel_name ?: 'Dewa Sharif Guest House Partner' }}
                </h6>
                <small class="text-muted" style="font-size: 12px;">Partner ID: #HTL-PTR-{{ auth('hotel')->id() }}</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('hotel.rooms.create') }}" class="btn btn-sm btn-success fw-bold d-none d-md-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-plus-lg"></i> Add Room
            </a>

            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 10px;">
                    <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">
                        {{ strtoupper(substr(auth('hotel')->user()->name, 0, 1)) }}
                    </div>
                    <span class="fw-semibold text-dark d-none d-sm-inline">{{ auth('hotel')->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 12px;">
                    <li><a class="dropdown-item py-2" href="{{ route('hotel.profile') }}"><i class="bi bi-person me-2 text-primary"></i>My Profile</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('hotel.profile') }}"><i class="bi bi-bank me-2 text-success"></i>Bank Payout Details</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('hotel.settlements') }}"><i class="bi bi-journal-text me-2 text-warning"></i>Settlements Ledger</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('hotel.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="partner-main">
        <div class="content-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center gap-2" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-center gap-2" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('partnerSidebar');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
