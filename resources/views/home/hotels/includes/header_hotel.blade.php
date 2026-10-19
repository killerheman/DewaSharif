<header class="hotel-header" style="position: fixed; top: 0; left: 0; width: 100%; height: 72px; z-index: 99999; background: #ffffff; border-bottom: 3px solid #074121; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <style>
        .hotel-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding: 0 20px;
            gap: 12px;
            flex-wrap: nowrap;
            box-sizing: border-box;
            width: 100%;
        }
        .hotel-desktop-nav {
            display: block;
            flex-shrink: 0;
        }
        .hotel-mobile-nav {
            display: none;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        .hotel-header-logo-title {
            font-size: 18px;
            font-weight: 900;
            color: #074121;
            display: block;
            line-height: 1.1;
            letter-spacing: -0.3px;
            white-space: nowrap;
        }
        .hotel-header-logo-sub {
            font-size: 10.5px;
            color: #555;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .hotel-header-logo-img {
            height: 44px;
            width: auto;
        }
        @media (max-width: 860px) {
            .hotel-header-inner {
                padding: 0 12px !important;
                gap: 8px !important;
            }
            .hotel-desktop-nav {
                display: none !important;
            }
            .hotel-mobile-nav {
                display: flex !important;
            }
            .hotel-header-logo-title {
                font-size: 15px !important;
            }
            .hotel-header-logo-sub {
                font-size: 9px !important;
            }
            .hotel-header-logo-img {
                height: 38px !important;
            }
        }
        @media (max-width: 420px) {
            .hotel-header-inner {
                padding: 0 8px !important;
                gap: 6px !important;
            }
            .hotel-header-logo-title {
                font-size: 13.5px !important;
            }
            .hotel-header-logo-sub {
                display: none !important;
            }
            .hotel-header-logo-img {
                height: 32px !important;
            }
            .hotel-mobile-help-btn {
                padding: 5px 8px !important;
                font-size: 11px !important;
            }
            .hotel-mobile-home-btn {
                padding: 5px 7px !important;
                font-size: 10.5px !important;
            }
        }
        @media (max-width: 280px) {
            .hotel-header-inner {
                padding: 0 4px !important;
                gap: 3px !important;
            }
            .hotel-header-logo-title {
                font-size: 11px !important;
            }
            .hotel-header-logo-img {
                height: 25px !important;
            }
            .hotel-mobile-help-btn {
                padding: 4px 5px !important;
                font-size: 9.5px !important;
            }
            .hotel-mobile-home-btn {
                padding: 4px 5px !important;
                font-size: 9px !important;
            }
        }
    </style>

    <div class="hotel-header-inner">
        <!-- Logo & Title -->
        <a href="{{ route('hotels') }}" style="text-decoration: none; display: flex; align-items: center; gap: 8px; white-space: nowrap; flex-shrink: 0;">
            <img src="{{ asset('home/images/dewasharif/dewalogos.png') }}" alt="Dewa Stays" class="hotel-header-logo-img">
            <div>
                <span class="hotel-header-logo-title">
                    🏨 DEWA SHARIF
                </span>
                <span class="hotel-header-logo-sub">
                    Hotels &amp; Guest House
                </span>
            </div>
        </a>

        <!-- Desktop Navigation (Strict 1 Single Row) -->
        <nav class="hotel-desktop-nav">
            <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 12px; align-items: center; font-weight: 700; font-size: 13px; white-space: nowrap; flex-wrap: nowrap;">
                <li style="white-space: nowrap;">
                    <a href="{{ route('hotels') }}" style="color: #074121; text-decoration: none; padding: 6px 12px; border-radius: 6px; background: rgba(7,65,33,0.08); white-space: nowrap; font-weight: 800;">
                        Hotels Booking
                    </a>
                </li>
                <li style="white-space: nowrap;">
                    <a href="https://wa.me/919648777223?text=Assalam%20Alaikum,%20Mujhe%20Dewa%20Sharif%20me%20Hotel%20Room%20book%20karna%20hai" target="_blank" style="background: #25D366; color: #ffffff; padding: 7px 14px; border-radius: 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-weight: 800; box-shadow: 0 2px 8px rgba(37,211,102,0.3); white-space: nowrap;">
                        <i class="fa fa-whatsapp" style="font-size: 15px;"></i> Helpline
                    </a>
                </li>
                <li style="white-space: nowrap;">
                    <a href="{{ route('customer.dashboard') }}" style="background: #dcfce7; color: #052c16; padding: 7px 14px; border-radius: 6px; text-decoration: none; font-weight: 800; white-space: nowrap;">
                        👤 My Account
                    </a>
                </li>
                <li style="white-space: nowrap;">
                    <a href="{{ route('index') }}" style="background: #074121; color: #ffffff; padding: 7px 14px; border-radius: 6px; text-decoration: none; font-weight: 700; white-space: nowrap;">
                        ← Main Site
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Mobile Navigation (Compact, Never Cut Off) -->
        <div class="hotel-mobile-nav">
            <a href="https://wa.me/919648777223?text=Assalam%20Alaikum,%20Mujhe%20Dewa%20Sharif%20me%20Hotel%20Room%20book%20karna%20hai" target="_blank"
                class="hotel-mobile-help-btn"
                style="background: #25D366; color: #ffffff; padding: 6px 11px; border-radius: 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-weight: 800; font-size: 11.5px; box-shadow: 0 2px 6px rgba(37,211,102,0.3); white-space: nowrap;">
                <i class="fa fa-whatsapp" style="font-size: 14px;"></i> Help
            </a>
            <a href="{{ route('index') }}"
                class="hotel-mobile-home-btn"
                style="background: #074121; color: #ffffff; padding: 6px 9px; border-radius: 6px; text-decoration: none; font-weight: 700; font-size: 11px; white-space: nowrap;">
                ← Home
            </a>
        </div>

    </div>
</header>
<div style="height: 72px; width: 100%;"></div>

<script>
    function triggerHotelCategory(cat) {
        if (typeof filterCategory === 'function') {
            filterCategory(cat);
            var gridElem = document.getElementById('hotelsGrid');
            if (gridElem) {
                gridElem.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        } else {
            window.location.href = "{{ route('hotels') }}#" + cat;
        }
    }
</script>