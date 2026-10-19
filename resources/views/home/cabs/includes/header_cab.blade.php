<header class="cab-header" style="position: fixed; top: 0; left: 0; width: 100%; height: 72px; z-index: 99999; background: #ffffff; border-bottom: 3px solid #074121; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <div class="container-fluid" style="display: flex; align-items: center; justify-content: space-between; height: 100%; padding: 0 25px; gap: 15px; flex-wrap: nowrap;">
        
        <!-- Logo & Title -->
        <a href="{{ route('cabs') }}" style="text-decoration: none; display: flex; align-items: center; gap: 10px; white-space: nowrap; flex-shrink: 0;">
            <img src="{{ asset('home/images/dewasharif/dewalogos.png') }}" alt="Dewa Cabs" style="height: 44px; width: auto;">
            <div>
                <span style="font-size: 18px; font-weight: 900; color: #074121; display: block; line-height: 1.1; letter-spacing: -0.3px; white-space: nowrap;">
                    🚕 DEWA SHARIF
                </span>
                <span style="font-size: 10.5px; color: #555555; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">
                    Cabs- Station, Airport &amp; Custom Dispatch
                </span>
            </div>
        </a>

        <!-- Desktop Navigation (100% Single Line - Green Theme) -->
        <nav class="d-none d-md-block" style="flex-shrink: 0;">
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

    </div>
</header>
<div style="height: 72px; width: 100%;"></div>