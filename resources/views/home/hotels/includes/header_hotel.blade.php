<header class="hotel-header" style="position: fixed; top: 0; left: 0; width: 100%; height: 72px; z-index: 99999; background: #ffffff; border-bottom: 3px solid #074121; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <div class="container-fluid" style="display: flex; align-items: center; justify-content: space-between; height: 100%; padding: 0 25px; gap: 15px; flex-wrap: nowrap;">
        
        <!-- Logo & Title -->
        <a href="{{ route('hotels') }}" style="text-decoration: none; display: flex; align-items: center; gap: 10px; white-space: nowrap; flex-shrink: 0;">
            <img src="{{ asset('home/images/dewasharif/dewalogos.png') }}" alt="Dewa Stays" style="height: 44px; width: auto;">
            <div>
                <span style="font-size: 18px; font-weight: 900; color: #074121; display: block; line-height: 1.1; letter-spacing: -0.3px; white-space: nowrap;">
                    🏨 DEWA SHARIF
                </span>
                <span style="font-size: 10.5px; color: #555; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">
                    Hotels & Guest House Booking
                </span>
            </div>
        </a>

        <!-- Desktop Navigation (Strict 1 Single Row) -->
        <nav class="d-none d-md-block" style="flex-shrink: 0;">
            <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 12px; align-items: center; font-weight: 700; font-size: 13px; white-space: nowrap; flex-wrap: nowrap;">
                <li style="white-space: nowrap;">
                    <a href="{{ route('hotels') }}" style="color: #074121; text-decoration: none; padding: 6px 12px; border-radius: 6px; background: rgba(7,65,33,0.08); white-space: nowrap; font-weight: 800;">
                        Hotels Booking
                    </a>
                </li>
                <!-- <li style="white-space: nowrap;">
                    <a href="javascript:void(0)" onclick="triggerHotelCategory('ac')" style="color: #333; text-decoration: none; padding: 6px 8px; white-space: nowrap;">
                        Deluxe AC
                    </a>
                </li>
                <li style="white-space: nowrap;">
                    <a href="javascript:void(0)" onclick="triggerHotelCategory('non_ac')" style="color: #333; text-decoration: none; padding: 6px 8px; white-space: nowrap;">
                        Standard Non-AC
                    </a>
                </li>
                <li style="white-space: nowrap;">
                    <a href="javascript:void(0)" onclick="triggerHotelCategory('family')" style="color: #333; text-decoration: none; padding: 6px 8px; white-space: nowrap;">
                        Family Halls
                    </a>
                </li> -->
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