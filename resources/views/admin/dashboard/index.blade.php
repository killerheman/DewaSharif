@extends('admin.includes.master')

@section('title', 'Dashboard - DewaSharif Admin')

@section('content')

<style>
    /* MODERN PREMIUM DASHBOARD CARD STYLES */
    .stat-card {
        border-radius: 16px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
        min-height: 180px;
        border: 1px solid rgba(255, 255, 255, 0.18) !important;
    }
    /* Top-Left Corner Light Spotlight Overlay */
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 10% 10%, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0) 65%);
        pointer-events: none;
        z-index: 1;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px -6px rgba(0, 0, 0, 0.35) !important;
    }
    
    /* Vibrant Diagonal Top-Left Light to Bottom-Right Dark Gradients */
    .card-gradient-orange {
        background: linear-gradient(135deg, #fb923c 0%, #ea580c 48%, #7c2d12 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(234, 88, 12, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-brown {
        background: linear-gradient(135deg, #c4886e 0%, #8c533e 48%, #4a2618 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(140, 83, 62, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-dark {
        background: linear-gradient(135deg, #64748b 0%, #334155 48%, #111827 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(51, 65, 85, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-blue {
        background: linear-gradient(135deg, #38bdf8 0%, #0d6efd 48%, #032b69 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(13, 110, 253, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-green {
        background: linear-gradient(135deg, #34d399 0%, #198754 48%, #064e3b 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(25, 135, 84, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-amber {
        background: linear-gradient(135deg, #fde047 0%, #d97706 50%, #78350f 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(217, 119, 6, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-red {
        background: linear-gradient(135deg, #ff6b6b 0%, #dc3545 48%, #7f1d1d 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(220, 53, 69, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-cyan {
        background: linear-gradient(135deg, #67e8f9 0%, #0dcaf0 48%, #086678 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(13, 202, 240, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-purple {
        background: linear-gradient(135deg, #c084fc 0%, #7c3aed 48%, #3b0764 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(124, 58, 237, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-pink {
        background: linear-gradient(135deg, #f472b6 0%, #ec4899 48%, #831843 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(236, 72, 153, 0.4);
        color: #ffffff !important;
    }
    .card-gradient-coral {
        background: linear-gradient(135deg, #ff9ff3 0%, #ff6b6b 48%, #9e1c1c 100%) !important;
        box-shadow: 0 10px 24px -4px rgba(255, 107, 107, 0.4);
        color: #ffffff !important;
    }

    .stat-card .card-inner {
        padding: 26px 24px 18px 24px;
        z-index: 2;
        position: relative;
    }
    .stat-card .card-inner h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 6px;
        line-height: 1.1;
        letter-spacing: -0.5px;
    }
    .stat-card .card-inner p {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0;
        opacity: 0.94;
        letter-spacing: 0.2px;
    }
    .stat-card .card-icon {
        position: absolute;
        top: 18px;
        right: 22px;
        z-index: 1;
        font-size: 4.2rem;
        opacity: 0.22;
        transition: transform 0.3s ease, opacity 0.3s ease;
        pointer-events: none;
        line-height: 1;
    }
    .stat-card:hover .card-icon {
        transform: scale(1.12) rotate(-6deg);
        opacity: 0.38;
    }
    .stat-card-footer {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 15px;
        color: rgba(255, 255, 255, 0.92) !important;
        background: rgba(0, 0, 0, 0.16);
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none !important;
        z-index: 3;
        transition: background 0.25s ease, color 0.25s ease;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        border-bottom-left-radius: 14px;
        border-bottom-right-radius: 14px;
    }
    .stat-card-footer:hover {
        background: rgba(0, 0, 0, 0.28);
        color: #ffffff !important;
    }
    .stat-card-footer i {
        transition: transform 0.2s ease;
    }
    .stat-card-footer:hover i {
        transform: translateX(4px);
    }

    /* Yellow Card Dark Footer */
    .card-gradient-amber .stat-card-footer {
        color: rgba(30, 41, 59, 0.9) !important;
        background: rgba(0, 0, 0, 0.08);
        border-top: 1px solid rgba(0, 0, 0, 0.08);
    }
    .card-gradient-amber .stat-card-footer:hover {
        background: rgba(0, 0, 0, 0.18);
        color: #000000 !important;
    }
</style>

<main class="app-main">

    <!-- BREADCRUMB HEADER -->
    <div class="app-content-header py-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h2 class="mb-0 fw-bold text-dark fs-3">Dashboard</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-primary fw-semibold">Home</a></li>
                        <li class="breadcrumb-item active text-muted">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT BODY -->
    <div class="app-content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- MASTER SERVICES LIVE CONTROL SWITCH -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border: 1.5px solid #e2e8f0 !important;">
                <div class="card-header bg-gradient text-white py-3 px-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <div>
                        <h5 class="mb-0 fw-bold"><i class="bi bi-toggles2 me-2 text-warning"></i>Public Services Master Live Switch</h5>
                        <small class="text-white-50">Control whether each service is fully LIVE, Coming Soon, or WhatsApp Enquiry on the main site &amp; header.</small>
                    </div>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill font-bold"><i class="bi bi-lightning-charge-fill me-1"></i>Real-Time Sync</span>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-4">
                        
                        <!-- 1. Hotels & Guest Houses Switch -->
                        <div class="col-lg-4 col-md-6">
                            <div class="bg-white p-3.5 rounded-3 border h-100 d-flex flex-column justify-content-between shadow-xs">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 p-2 bg-success-subtle text-success me-2">
                                                <i class="bi bi-building fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">Hotels &amp; Guest Houses</h6>
                                                <small class="text-muted">Rooms &amp; Hall Bookings</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        @if(($serviceHotelsStatus ?? 'active') === 'active')
                                            <span class="badge bg-success px-3 py-2 rounded-pill shadow-xs"><i class="bi bi-check-circle-fill me-1"></i> LIVE &amp; ACCEPTING BOOKINGS</span>
                                            <p class="small text-muted mt-2 mb-0">Public can search, view rooms and book online right now.</p>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-xs"><i class="bi bi-clock-history me-1"></i> COMING SOON</span>
                                            <p class="small text-muted mt-2 mb-0">Header &amp; Home cards show 'Coming Soon' notice to visitors.</p>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('admin.services.status.update') }}" method="POST" class="mt-2 pt-2 border-top">
                                    @csrf
                                    <input type="hidden" name="service" value="hotels">
                                    <div class="btn-group w-100 shadow-xs" role="group">
                                        <button type="submit" name="status" value="active" class="btn btn-sm {{ ($serviceHotelsStatus ?? 'active') === 'active' ? 'btn-success fw-bold' : 'btn-outline-success' }}">
                                            <i class="bi bi-broadcast me-1"></i> Set Live
                                        </button>
                                        <button type="submit" name="status" value="coming_soon" class="btn btn-sm {{ ($serviceHotelsStatus ?? 'active') === 'coming_soon' ? 'btn-warning fw-bold text-dark' : 'btn-outline-warning text-dark' }}">
                                            <i class="bi bi-pause-circle me-1"></i> Coming Soon
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- 2. Auto & Cabs Switch -->
                        <div class="col-lg-4 col-md-6">
                            <div class="bg-white p-3.5 rounded-3 border h-100 d-flex flex-column justify-content-between shadow-xs">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 p-2 bg-danger-subtle text-danger me-2">
                                                <i class="bi bi-taxi-front-fill fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">Auto &amp; Cab Booking</h6>
                                                <small class="text-muted">Station &amp; Airport Routes</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        @if(($serviceCabsStatus ?? 'active') === 'active')
                                            <span class="badge bg-success px-3 py-2 rounded-pill shadow-xs"><i class="bi bi-check-circle-fill me-1"></i> LIVE &amp; ACCEPTING BOOKINGS</span>
                                            <p class="small text-muted mt-2 mb-0">Vehicles &amp; route booking open for all pilgrims.</p>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-xs"><i class="bi bi-clock-history me-1"></i> COMING SOON</span>
                                            <p class="small text-muted mt-2 mb-0">Header &amp; Home cards show 'Coming Soon' notice to visitors.</p>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('admin.services.status.update') }}" method="POST" class="mt-2 pt-2 border-top">
                                    @csrf
                                    <input type="hidden" name="service" value="cabs">
                                    <div class="btn-group w-100 shadow-xs" role="group">
                                        <button type="submit" name="status" value="active" class="btn btn-sm {{ ($serviceCabsStatus ?? 'active') === 'active' ? 'btn-success fw-bold' : 'btn-outline-success' }}">
                                            <i class="bi bi-broadcast me-1"></i> Set Live
                                        </button>
                                        <button type="submit" name="status" value="coming_soon" class="btn btn-sm {{ ($serviceCabsStatus ?? 'active') === 'coming_soon' ? 'btn-warning fw-bold text-dark' : 'btn-outline-warning text-dark' }}">
                                            <i class="bi bi-pause-circle me-1"></i> Coming Soon
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- 3. Sacred Online Shop Switch -->
                        <div class="col-lg-4 col-md-12">
                            <div class="bg-white p-3.5 rounded-3 border h-100 d-flex flex-column justify-content-between shadow-xs">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 p-2 bg-warning-subtle text-warning-emphasis me-2">
                                                <i class="bi bi-shop fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">Dewa Sacred Shop</h6>
                                                <small class="text-muted">Attar, Chadar, Bartan &amp; Tabarrukat</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        @if(($serviceShopStatus ?? 'whatsapp_only') === 'whatsapp_only')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill shadow-xs"><i class="bi bi-whatsapp me-1"></i> WHATSAPP ORDER MODE (Active)</span>
                                            <p class="small text-muted mt-2 mb-0">Customers order via 1-click WhatsApp while descriptions are being completed.</p>
                                        @elseif(($serviceShopStatus ?? 'whatsapp_only') === 'active')
                                            <span class="badge bg-success px-3 py-2 rounded-pill shadow-xs"><i class="bi bi-cart-check-fill me-1"></i> FULL E-COMMERCE LIVE</span>
                                            <p class="small text-muted mt-2 mb-0">Cart checkout, coupons &amp; direct payment active.</p>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-xs"><i class="bi bi-clock-history me-1"></i> COMING SOON</span>
                                            <p class="small text-muted mt-2 mb-0">Store is paused with 'Coming Soon' badge for visitors.</p>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('admin.services.status.update') }}" method="POST" class="mt-2 pt-2 border-top">
                                    @csrf
                                    <input type="hidden" name="service" value="shop">
                                    <div class="btn-group w-100 shadow-xs" role="group">
                                        <button type="submit" name="status" value="whatsapp_only" class="btn btn-sm {{ ($serviceShopStatus ?? 'whatsapp_only') === 'whatsapp_only' ? 'btn-primary fw-bold' : 'btn-outline-primary' }}" title="Order via WhatsApp directly">
                                            <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                        </button>
                                        <button type="submit" name="status" value="active" class="btn btn-sm {{ ($serviceShopStatus ?? 'whatsapp_only') === 'active' ? 'btn-success fw-bold' : 'btn-outline-success' }}" title="Full Cart & Checkout">
                                            <i class="bi bi-cart-check me-1"></i> Full Live
                                        </button>
                                        <button type="submit" name="status" value="coming_soon" class="btn btn-sm {{ ($serviceShopStatus ?? 'whatsapp_only') === 'coming_soon' ? 'btn-warning fw-bold text-dark' : 'btn-outline-warning text-dark' }}" title="Set Coming Soon">
                                            <i class="bi bi-pause-circle me-1"></i> Soon
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- 6 STAT CARDS WITH CUSTOMIZED ROW LAYOUT AND VIBRANT GRADIENTS -->
            <div class="row g-4 mb-4">
                
                <!-- ROW 1: CARD 1 - VIBRANT ORANGE (Total Users) -->
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="stat-card card-gradient-orange w-100">
                        <div class="card-inner">
                            <h3>{{ $stats['users_count'] ?? 2 }}</h3>
                            <p>Total Users</p>
                        </div>
                        <div class="card-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="stat-card-footer">
                            <span>View Details</span> <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- ROW 1: CARD 2 - GRAY / DARK SLATE (Support Tickets & Issues) -->
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="stat-card card-gradient-dark w-100">
                        <div class="card-inner">
                            <h3>{{ $stats['tickets_count'] ?? 1 }}</h3>
                            <p>Support Tickets &amp; Issues</p>
                        </div>
                        <div class="card-icon">
                            <i class="bi bi-ticket-detailed-fill"></i>
                        </div>
                        <a href="{{ route('admin.tickets.index') }}" class="stat-card-footer">
                            <span>View Details</span> <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- ROW 1: CARD 3 - BLUE (Total Revenue) -->
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="stat-card card-gradient-blue w-100">
                        <div class="card-inner">
                            <h3 class="text-nowrap" style="font-size: 2.2rem;">₹ {{ $stats['total_revenue'] ?? '12,083.00' }}</h3>
                            <p>Total Revenue</p>
                        </div>
                        <div class="card-icon">
                            <i class="bi bi-currency-rupee"></i>
                        </div>
                        <a href="{{ route('admin.invoices.index') }}" class="stat-card-footer">
                            <span>View Details</span> <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- ROW 2: CARD 4 - GREEN (Hotels & Stays) -->
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="stat-card card-gradient-green w-100">
                        <div class="card-inner">
                            <h3>{{ $stats['hotels_count'] ?? 51 }}</h3>
                            <p>Hotels &amp; Stays</p>
                        </div>
                        <div class="card-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <a href="{{ route('admin.hotels.index') }}" class="stat-card-footer">
                            <span>View Details</span> <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- ROW 2: CARD 5 - YELLOW / AMBER (Cab & Taxi Duties) -->
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="stat-card card-gradient-amber w-100">
                        <div class="card-inner">
                            <h3>{{ $stats['cabs_count'] ?? 22 }}</h3>
                            <p>Cab &amp; Taxi Duties</p>
                        </div>
                        <div class="card-icon">
                            <i class="bi bi-taxi-front-fill"></i>
                        </div>
                        <a href="{{ route('admin.cabs.index') }}" class="stat-card-footer">
                            <span>View Details</span> <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- ROW 2: CARD 6 - RED (Sacred Store Orders) -->
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="stat-card card-gradient-red w-100">
                        <div class="card-inner">
                            <h3>{{ $stats['shop_orders_count'] ?? 6 }}</h3>
                            <p>Sacred Store Orders</p>
                        </div>
                        <div class="card-icon">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <a href="{{ route('admin.shop.orders') }}" class="stat-card-footer">
                            <span>View Details</span> <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- RECENT RESERVATIONS & DUTIES TABLES -->
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-0">
                            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-house-door-fill text-warning me-2"></i> Recent Hotel Reservations</h5>
                            <a href="{{ route('admin.hotels.bookings') }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold px-3">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Guest Name</th>
                                        <th>Hotel &amp; Stay</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hotelBookings as $b)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $b['customer_name'] ?? 'Guest' }}</div>
                                                <small class="text-muted">{{ $b['customer_phone'] ?? '9648777223' }}</small>
                                            </td>
                                            <td>
                                                <span class="d-block text-truncate fw-semibold" style="max-width: 160px;">{{ $b['hotel_name'] ?? 'Dewa Guest House' }}</span>
                                                <small class="badge bg-light text-dark border">{{ $b['room_name'] ?? 'Deluxe AC' }}</small>
                                            </td>
                                            <td class="fw-bold text-success">₹{{ number_format($b['amount'] ?? ($b['total_amount'] ?? 1499)) }}</td>
                                            <td><span class="badge bg-success">Confirmed</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-3 text-muted">No hotel bookings found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-0">
                            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-taxi-front-fill text-primary me-2"></i> Cab / Taxi Duty Dispatches</h5>
                            <a href="{{ route('admin.cabs.bookings') }}" class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-3">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Passenger</th>
                                        <th>Route &amp; Vehicle</th>
                                        <th>Fare</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cabBookings as $c)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $c['customer_name'] ?? 'Pilgrim' }}</div>
                                                <small class="text-muted">{{ $c['customer_phone'] ?? '9648777223' }}</small>
                                            </td>
                                            <td>
                                                <span class="d-block text-truncate fw-semibold" style="max-width: 160px;">{{ $c['route'] ?? 'Lucknow ↔ Dewa Sharif' }}</span>
                                                <small class="badge bg-light text-dark border">{{ $c['vehicle_type'] ?? 'Swift Dzire' }}</small>
                                            </td>
                                            <td class="fw-bold text-primary">₹{{ number_format($c['fare'] ?? 1400) }}</td>
                                            <td><span class="badge bg-info text-dark">Dispatched</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-3 text-muted">No cab bookings found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>

@endsection