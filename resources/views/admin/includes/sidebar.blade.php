<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('admin.dashboard') }}" class="brand-link text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" alt="DewaSharif Logo" style="height: 38px; width: 38px; object-fit: cover; border-radius: 50%;">
            <span class="brand-text fw-bold text-success fs-4">DewaSharif <small class="fs-6 text-white-50">Admin</small></span>
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">
                
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Hotels & Rooms Management --}}
                <li class="nav-item {{ Route::is('admin.hotels.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.hotels.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-building"></i>
                        <p>
                            Hotels &amp; Rooms
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.hotels.index') }}" class="nav-link {{ Route::is('admin.hotels.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-house-door-fill"></i>
                                <p>Hotels Catalogue</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.hotels.bookings') }}" class="nav-link {{ Route::is('admin.hotels.bookings') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-calendar-check-fill"></i>
                                <p>Room Reservations</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Cabs & Taxi Services --}}
                <li class="nav-item {{ Route::is('admin.cabs.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.cabs.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-taxi-front-fill"></i>
                        <p>
                            Cab &amp; Taxi Services
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.cabs.index') }}" class="nav-link {{ Route::is('admin.cabs.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-geo-alt-fill"></i>
                                <p>Routes &amp; Fleet</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.cabs.bookings') }}" class="nav-link {{ Route::is('admin.cabs.bookings') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-card-checklist"></i>
                                <p>Duty Bookings</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Sacred Shop & Products --}}
                <li class="nav-item {{ Route::is('admin.shop.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.shop.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shop"></i>
                        <p>
                            Sacred Store &amp; Shop
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.shop.index') }}" class="nav-link {{ Route::is('admin.shop.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bag-check-fill"></i>
                                <p>Store Inventory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.shop.categories') }}" class="nav-link {{ Route::is('admin.shop.categories*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-tags-fill"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.shop.orders') }}" class="nav-link {{ Route::is('admin.shop.orders') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p>Customer Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Users Management --}}
                <li class="nav-item {{ Route::is('admin.users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Users Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Invoices & Billing --}}
                <li class="nav-item {{ Route::is('admin.invoices.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.invoices.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-receipt-cutoff"></i>
                        <p>
                            Invoice &amp; Billing
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.invoices.index') }}" class="nav-link {{ Route::is('admin.invoices.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid-3x3-gap-fill"></i>
                                <p>All Invoices</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Coupons Dropdown --}}
                <li class="nav-item {{ Route::is('admin.coupons.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.coupons.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>
                            Coupons
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.coupons.create') }}" class="nav-link {{ Route::is('admin.coupons.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Add Coupon</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ Route::is('admin.coupons.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid-3x3-gap"></i>
                                <p>All Coupons</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Payments Dropdown --}}
                <li class="nav-item {{ Route::is('admin.payment-settings.*') || Route::is('admin.transactions.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.payment-settings.*') || Route::is('admin.transactions.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-credit-card-fill"></i>
                        <p>
                            Payments
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.payment-settings.create') }}" class="nav-link {{ Route::is('admin.payment-settings.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Add Gateway</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.payment-settings.index') }}" class="nav-link {{ Route::is('admin.payment-settings.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid"></i>
                                <p>All Gateways</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ Route::is('admin.transactions.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-receipt"></i>
                                <p>All Transactions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Support Dropdown --}}
                <li class="nav-item {{ Route::is('admin.support-tickets.*') || Route::is('admin.tickets.*') || Route::is('admin.contacts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.support-tickets.*') || Route::is('admin.tickets.*') || Route::is('admin.contacts*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-headset"></i>
                        <p>
                            Support
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.tickets.index') }}" class="nav-link {{ Route::is('admin.tickets.*') || Route::is('admin.support-tickets.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-ticket-detailed"></i>
                                <p>Support Tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts') }}" class="nav-link {{ Route::is('admin.contacts*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-envelope-paper"></i>
                                <p>Contact Inquiries</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Customer Reviews & Ratings --}}
                <li class="nav-item">
                    <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ Route::is('admin.reviews.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-star-fill text-warning"></i>
                        <p>Customer Reviews</p>
                    </a>
                </li>

                {{-- Customer Feedbacks --}}
                <li class="nav-item">
                    <a href="{{ route('admin.feedbacks.index') }}" class="nav-link {{ Route::is('admin.feedbacks.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-chat-right-text-fill text-info"></i>
                        <p>Customer Feedbacks</p>
                    </a>
                </li>

                {{-- My Account Dropdown --}}
                <li class="nav-item {{ Route::is('admin.profile.*') || Route::is('admin.change.password*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.profile.*') || Route::is('admin.change.password*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>
                            My Account
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ Route::is('admin.profile.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-vcard"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.change.password') }}" class="nav-link {{ Route::is('admin.change.password*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-key"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" class="nav-link text-danger">
                                <i class="nav-icon bi bi-box-arrow-right text-danger"></i>
                                <p>Log Out</p>
                            </a>
                            <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

                {{-- Settings Dropdown --}}
                <li class="nav-item {{ Route::is('admin.settings.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.settings.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>
                            Settings
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.general') }}" class="nav-link {{ Route::is('admin.settings.general') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-sliders"></i>
                                <p>General Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.company') }}" class="nav-link {{ Route::is('admin.settings.company') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building-gear"></i>
                                <p>Company Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.contact') }}" class="nav-link {{ Route::is('admin.settings.contact') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>Contact Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>