<header class="cab-header" style="position: fixed; top: 0; left: 0; width: 100%; height: 72px; z-index: 99999; background: #ffffff; border-bottom: 3px solid #074121; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <style>
        .cab-header-inner {
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
        .cab-desktop-nav {
            display: block;
            flex-shrink: 0;
        }
        .cab-mobile-nav {
            display: none;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        .cab-header-logo-title {
            font-size: 18px;
            font-weight: 900;
            color: #074121;
            display: block;
            line-height: 1.1;
            letter-spacing: -0.3px;
            white-space: nowrap;
        }
        .cab-header-logo-sub {
            font-size: 10.5px;
            color: #555;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .cab-header-logo-img {
            height: 44px;
            width: auto;
        }
        @media (max-width: 860px) {
            .cab-header-inner {
                padding: 0 12px !important;
                gap: 8px !important;
            }
            .cab-desktop-nav {
                display: none !important;
            }
            .cab-mobile-nav {
                display: flex !important;
            }
            .cab-header-logo-title {
                font-size: 15px !important;
            }
            .cab-header-logo-sub {
                font-size: 9px !important;
            }
            .cab-header-logo-img {
                height: 38px !important;
            }
        }
        @media (max-width: 420px) {
            .cab-header-inner {
                padding: 0 8px !important;
                gap: 6px !important;
            }
            .cab-header-logo-title {
                font-size: 13.5px !important;
            }
            .cab-header-logo-sub {
                display: none !important;
            }
            .cab-header-logo-img {
                height: 32px !important;
            }
            .cab-mobile-help-btn {
                padding: 5px 8px !important;
                font-size: 11px !important;
            }
            .cab-mobile-home-btn {
                padding: 5px 7px !important;
                font-size: 10.5px !important;
            }
        }
        @media (max-width: 280px) {
            .cab-header-inner {
                padding: 0 4px !important;
                gap: 3px !important;
            }
            .cab-header-logo-title {
                font-size: 11px !important;
            }
            .cab-header-logo-img {
                height: 25px !important;
            }
            .cab-mobile-help-btn {
                padding: 4px 5px !important;
                font-size: 9.5px !important;
            }
            .cab-mobile-home-btn {
                padding: 4px 5px !important;
                font-size: 9px !important;
            }
        }
    </style>

    <div class="cab-header-inner">
        <!-- Logo & Title -->
        <a href="{{ route('cabs') }}" style="text-decoration: none; display: flex; align-items: center; gap: 8px; white-space: nowrap; flex-shrink: 0;">
            <img src="{{ asset('home/images/dewasharif/dewalogos.png') }}" alt="Dewa Cabs" class="cab-header-logo-img">
            <div>
                <span class="cab-header-logo-title">
                    🚕 DEWA SHARIF
                </span>
                <span class="cab-header-logo-sub">
                    Cabs &amp; Taxi Service
                </span>
            </div>
        </a>

        <!-- Desktop Navigation (100% Single Line - Green Theme) -->
        <nav class="cab-desktop-nav">
            <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 12px; align-items: center; font-weight: 700; font-size: 13px; white-space: nowrap; flex-wrap: nowrap;">
                <li style="white-space: nowrap;">
                    <a href="{{ route('cabs') }}" style="color: #074121; text-decoration: none; padding: 6px 10px; border-radius: 4px; background: rgba(7,65,33,0.08); white-space: nowrap; font-weight: 800;">
                        🚕 Cabs Booking
                    </a>
                </li>
                <li style="white-space: nowrap;">
                    <a href="{{ route('cabs') }}#fixed-routes" onclick="if(window.selectLucknowTour){ selectLucknowTour(); }" style="color: #333333; text-decoration: none; padding: 6px 8px; white-space: nowrap;">
                        🌆 Lucknow Tour
                    </a>
                </li>
                <li style="white-space: nowrap;">
                    <a href="https://wa.me/919648777223?text=Assalam%20Alaikum,%20Mujhe%20Cab%20/%20Taxi%20booking%20chahiye" target="_blank" style="background: #25D366; color: #ffffff; padding: 7px 14px; border-radius: 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-weight: 800; box-shadow: 0 2px 8px rgba(37,211,102,0.3); white-space: nowrap;">
                        <i class="fa fa-whatsapp" style="font-size: 15px;"></i> Helpline Desk
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
        <div class="cab-mobile-nav">
            <a href="https://wa.me/919648777223?text=Assalam%20Alaikum,%20Mujhe%20Cab%20/%20Taxi%20booking%20chahiye" target="_blank"
                class="cab-mobile-help-btn"
                style="background: #25D366; color: #ffffff; padding: 6px 11px; border-radius: 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-weight: 800; font-size: 11.5px; box-shadow: 0 2px 6px rgba(37,211,102,0.3); white-space: nowrap;">
                <i class="fa fa-whatsapp" style="font-size: 14px;"></i> Help
            </a>
            <a href="{{ route('index') }}"
                class="cab-mobile-home-btn"
                style="background: #074121; color: #ffffff; padding: 6px 9px; border-radius: 6px; text-decoration: none; font-weight: 700; font-size: 11px; white-space: nowrap;">
                ← Home
            </a>
        </div>

    </div>
</header>
<div style="height: 72px; width: 100%;"></div>