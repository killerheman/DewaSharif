@php
    $cProfile = $profile ?? \App\Helpers\DataStore::getItem('customer_profile') ?? [
        'name' => 'User'
    ];
    $cName = $cProfile['name'] ?? 'User';
    $cAvatar = $cProfile['avatar'] ?? null;
    $words = array_values(array_filter(explode(' ', $cName)));
    $initials = strtoupper(substr($words[0] ?? 'M', 0, 1) . substr($words[1] ?? ($words[0] ?? 'W'), 0, 1));

    $sbHotelCount = count($hotelBookings ?? \App\Helpers\DataStore::getCollection('hotel_bookings'));
    $sbCabCount = count($cabBookings ?? \App\Helpers\DataStore::getCollection('cab_bookings'));
    $sbShopCount = count($shopOrders ?? \App\Helpers\DataStore::getCollection('shop_orders'));
@endphp
<div class="customer-sidebar-card" style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
    <div class="text-center pb-3 mb-3" style="border-bottom: 1px solid #f1f5f9;">
        @if($cAvatar)
            <img src="{{ $cAvatar }}" alt="{{ $cName }}" style="width: 65px; height: 65px; border-radius: 50%; object-fit: cover; margin: 0 auto 10px auto; border: 2.5px solid #16a34a; box-shadow: 0 4px 15px rgba(5,44,22,0.25); display: block;">
        @else
            <div style="width: 65px; height: 65px; background: linear-gradient(135deg, #052c16 0%, #16a34a 100%); color: #ffffff; font-size: 26px; font-weight: 900; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; box-shadow: 0 4px 15px rgba(5,44,22,0.25);">
                {{ $initials }}
            </div>
        @endif
        <h6 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 16px;">{{ $cName }}</h6>
        <span style="font-size: 11.5px; color: #16a34a; font-weight: 700; background: #dcfce7; padding: 2px 10px; border-radius: 12px; display: inline-block; margin-top: 4px;">
            ✔ Verified Pilgrim
        </span>
    </div>

    <div class="nav flex-column nav-pills customer-nav" role="tablist">
        <a href="{{ route('customer.dashboard') }}" class="customer-nav-item {{ Request::routeIs('customer.dashboard') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-tachometer"></i></div>
            <span class="nav-title">Dashboard</span>
        </a>

        <a href="{{ route('customer.hotels') }}" class="customer-nav-item {{ Request::routeIs('customer.hotels') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-building"></i></div>
            <span class="nav-title">Hotel Stays</span>
            @if($sbHotelCount > 0)
                <span class="badge ml-auto" style="background: #dcfce7; color: #16a34a; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 12px;">{{ $sbHotelCount }}</span>
            @endif
        </a>

        <a href="{{ route('customer.cabs') }}" class="customer-nav-item {{ Request::routeIs('customer.cabs') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-taxi"></i></div>
            <span class="nav-title">Cab Duties</span>
            @if($sbCabCount > 0)
                <span class="badge ml-auto" style="background: #e0f2fe; color: #0284c7; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 12px;">{{ $sbCabCount }}</span>
            @endif
        </a>

        <a href="{{ route('customer.orders') }}" class="customer-nav-item {{ Request::routeIs('customer.orders') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-shopping-bag"></i></div>
            <span class="nav-title">Store Orders</span>
            @if($sbShopCount > 0)
                <span class="badge ml-auto" style="background: #fae8ff; color: #86198f; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 12px;">{{ $sbShopCount }}</span>
            @endif
        </a>

        <a href="{{ route('customer.billing') }}" class="customer-nav-item {{ Request::routeIs('customer.billing') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-file-text-o"></i></div>
            <span class="nav-title">Billing &amp; Invoices</span>
        </a>

        <a href="{{ route('customer.reviews') }}" class="customer-nav-item {{ Request::routeIs('customer.reviews') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-star" style="color: #f59e0b;"></i></div>
            <span class="nav-title">My Reviews</span>
        </a>

        <a href="{{ route('customer.account') }}" class="customer-nav-item {{ Request::routeIs('customer.account') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-user"></i></div>
            <span class="nav-title">My Account</span>
        </a>

        <a href="{{ route('customer.reportIssue') }}" class="customer-nav-item {{ Request::routeIs('customer.reportIssue') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-flag"></i></div>
            <span class="nav-title">Report an Issue</span>
        </a>

        <a href="{{ route('customer.changePassword') }}" class="customer-nav-item {{ Request::routeIs('customer.changePassword') ? 'active' : '' }}">
            <div class="icon-box"><i class="fa fa-key"></i></div>
            <span class="nav-title">Change Password</span>
        </a>

        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();" class="customer-nav-item logout-btn">
            <div class="icon-box"><i class="fa fa-sign-out"></i></div>
            <span class="nav-title">Logout</span>
        </a>
        <form id="customer-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<style>
.customer-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    color: #475569;
    font-weight: 700;
    font-size: 14px;
    border-radius: 12px;
    text-decoration: none !important;
    margin-bottom: 6px;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.customer-nav-item .nav-title {
    flex-grow: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #475569;
}
.customer-nav-item .icon-box {
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    background: #f1f5f9;
    color: #475569;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    transition: all 0.2s ease;
}

/* UNIVERSAL HOVER & ACTIVE STATE FOR ALL NAV ITEMS (Dark Green Pill + White Text + White Icon Box + Green Icon) */
.customer-nav-item:hover,
.customer-nav-item.active {
    background: #052c16 !important;
    color: #ffffff !important;
    font-weight: 800;
    box-shadow: 0 4px 12px rgba(5, 44, 22, 0.2);
}
.customer-nav-item:hover .nav-title,
.customer-nav-item.active .nav-title {
    color: #ffffff !important;
}
.customer-nav-item:hover .icon-box,
.customer-nav-item.active .icon-box {
    background: #ffffff !important;
    color: #052c16 !important;
}

/* Logout button hover effect */
.customer-nav-item.logout-btn:hover {
    background: #ef4444 !important;
    color: #ffffff !important;
}
.customer-nav-item.logout-btn:hover .nav-title {
    color: #ffffff !important;
}
.customer-nav-item.logout-btn:hover .icon-box {
    background: #ffffff !important;
    color: #ef4444 !important;
}
</style>
