<header>
    <section class="logo-section">
        <div class="container-fluid p0">
            <div class="row g-0">

                <!-- LOGO -->
                <div class="col-md-3 col-xs-12">
                    <div class="logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('home/images/dewasharif/anim_dewa_logo2.gif') }}" class="img-responsive"
                                alt="Logo of Dewa sharif Dot Com" title="Dewa Sharif" />
                        </a>
                    </div>
                </div>

                <!-- MENU + TRANSLATE -->
                <div class="col-md-9 col-xs-12">
                    <div class="menu">
                        <nav class="navbar navbar-inverse">

                            <div class="navbar-header">
                                <button class="navbar-toggle" type="button" data-toggle="collapse"
                                    data-target="#navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse" id="navbar-collapse">
                                <ul class="nav navbar-nav coimncount">

                                    <!-- ABOUT -->
                                    <li
                                        class="dropdown mega-dropdown {{ request()->routeIs('ziyarat', 'gallery') ? 'active' : '' }}">
                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">About US</a>
                                        <ul class="dropdown-menu mega-dropdown-menu about-tag">
                                            <li class="col-md-4"><a href="{{ route('about') }}">Dewa Sharif</a></li>
                                            <li class="col-md-4"><a href="{{ route('artandcraft') }}">Art & Craft</a>
                                            </li>
                                            <li class="col-md-4"><a href="{{ route('artandculture') }}">Art &
                                                    Culture</a></li>
                                            <li class="col-md-4"><a href="{{ route('auditorium') }}">Auditorium</a></li>
                                            <li class="col-md-4"><a href="{{ route('bank') }}">Banks</a></li>
                                            <li class="col-md-4"><a href="{{ route('collegeslist') }}">Educations</a>
                                            </li>
                                            <li class="col-md-4"><a href="{{ route('docters') }}">Docters</a></li>
                                            <li class="col-md-4"><a href="{{ route('eidgaah') }}">Eidgaah</a></li>
                                            <li class="col-md-4"><a href="{{ route('hotels') }}">Guest House &
                                                    Hotels</a></li>
                                            <li class="col-md-4"><a href="{{ route('hajiwarisalishah') }}">Hazrat Haji
                                                    Waris Ali Shah</a></li>
                                            <li class="col-md-4"><a href="{{ route('history') }}">History</a></li>
                                            <li class="col-md-4"><a href="{{ route('hospitals') }}">Hospitals</a></li>
                                            <li class="col-md-4"><a href="{{ route('langarkhana') }}">Langarkhana</a>
                                            </li>
                                            <li class="col-md-4"><a href="{{ route('mazar') }}">Mazaar</a></li>
                                            <li class="col-md-4 {{ request()->routeIs('ziyarat') ? 'active' : '' }}"><a
                                                    href="{{ route('ziyarat') }}">Ziyarat</a></li>
                                            <li class="col-md-4 {{ request()->routeIs('gallery') ? 'active' : '' }}"><a
                                                    href="{{ route('gallery') }}">Gallery</a></li>
                                            <li class="col-md-4"><a href="{{ route('mela') }}">Mela</a></li>
                                            <li class="col-md-4"><a
                                                    href="{{ route('mosquedargah') }}">Masjid-Al-Waris</a></li>
                                            <li class="col-md-4"><a href="{{ route('numaisground') }}">Numais</a></li>
                                            <li class="col-md-4"><a href="{{ route('postoffice') }}">Post Office</a>
                                            </li>
                                            <li class="col-md-4"><a href="{{ route('qawwaliplace') }}">Qawwali
                                                    Place</a></li>
                                            <li class="col-md-4"><a href="{{ route('qurbanalishah') }}">Hazrat Qurban
                                                    Ali Shah</a></li>
                                            <li class="col-md-4"><a href="{{ route('safayiheroes') }}">Cleaners
                                                    Staff</a></li>
                                            <li class="col-md-4"><a href="{{ route('samakhana') }}">Samakhana</a></li>
                                            <li class="col-md-4"><a href="{{ route('shahwilayatshah') }}">Hazrat Shah
                                                    Wilayat Shah</a></li>
                                            <li class="col-md-4"><a href="{{ route('sufism') }}">Sufism</a></li>
                                            <li class="col-md-4"><a href="{{ route('thana') }}">Thana</a></li>
                                            <li class="col-md-4"><a href="{{ route('townarea') }}">Town Area</a></li>
                                            <li class="col-md-4"><a href="{{ route('trustoffice') }}">Trust Office</a>
                                            </li>
                                            <li class="col-md-4"><a href="{{ route('wazukhana') }}">Wazukhana</a></li>
                                        </ul>
                                    </li>

                                    <!-- Buzurgan-E-Islam -->
                                    <li class="dropdown mega-dropdown">
                                        <a class="dropdown-toggle" href="#"
                                            data-toggle="dropdown">Buzurgan-E-Islam</a>
                                        <ul class="dropdown-menu mega-dropdown-menu dest-tag">
                                            <li class="col-md-6 menu-heading">
                                                <a href="#">Awlia-Allah</a>
                                                <ul>
                                                    <li><a href="{{ route('aalahazrat') }}">A'ala Hazrat</a></li>
                                                    <li><a href="{{ route('abdulqadirgilani') }}">Abdul Qadir
                                                            Jilani</a></li>
                                                    <li><a href="{{ route('dataganjbaksh') }}">DataGanj Baksh</a></li>
                                                    <li><a href="{{ route('hajiali') }}">Haji Ali</a></li>
                                                    <li><a href="{{ route('hazratbal') }}">HazratBal</a></li>
                                                    <li><a href="{{ route('hazratnizamuddin') }}">Hazrat
                                                            Nizamuddin</a>
                                                    </li>
                                                    <li><a href="{{ route('hazrattajuddin') }}">Hazrat Tajuddin</a>
                                                    </li>
                                                    <li><a href="{{ route('khammanpeer') }}">Khamman Peer</a></li>
                                                    <li><a href="{{ route('muinuddinchisti') }}">Khwaja Muinuddin
                                                            Chisti</a>
                                                    </li>
                                                    <li><a href="{{ route('syedmasoodghazi') }}">Syed Masood Ghazi</a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="col-md-6 menu-heading">
                                                <a href="#">Ahlebayt-Sahaba</a>
                                                <ul>
                                                    <li><a href="{{ route('muhammad') }}">Prophet Muhammad (PBUH)</a>
                                                    </li>
                                                    <li><a href="{{ route('fatima') }}">Fatima Al-Zahra</a></li>
                                                    <li><a href="{{ route('ali') }}">Ali Ibn Abi Talib</a></li>
                                                    <li><a href="{{ route('hasan') }}">Hasan Ibn Ali</a></li>
                                                    <li><a href="{{ route('husain') }}">Husayn Ibn Ali</a></li>
                                                    <li><a href="{{ route('khadija') }}">Khadijah</a></li>
                                                    <li><a href="{{ route('aisha') }}">Aisha</a></li>
                                                    <li><a href="{{ route('hafsa') }}">Hafsa</a></li>
                                                    <li><a href="{{ route('ummesalma') }}">Umme Salmah</a></li>
                                                    <li><a href="{{ route('abbas') }}">Abbas</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Islam -->
                                    <li class="dropdown mega-dropdown">
                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Islam</a>
                                        <ul class="dropdown-menu mega-dropdown-menu exp-tag">

                                            <li class="col-md-3 menu-heading">
                                                <a href="#">Mecca</a>
                                                <ul>
                                                    <li><a href="{{ route('aishaalrajhimosque') }}">Aisha-Al-Rajhi
                                                            Mosque</a></li>
                                                    <li><a href="{{ route('aishamosque') }}">Aisha Mosque</a></li>
                                                    <li><a href="{{ route('alhajaralaswad') }}">Al-Hajar-Al-Aswad</a>
                                                    </li>
                                                    <li><a href="{{ route('alharammosque') }}">Al-Haram Mosque</a>
                                                    </li>
                                                    <li><a href="{{ route('aljinnmosque') }}">Al-Jinn Mosque</a></li>
                                                    <li><a href="{{ route('alkhaifmosque') }}">Al-Khaif Mosque</a>
                                                    </li>
                                                    <li><a href="{{ route('allah') }}">Allah</a></li>
                                                    <li><a href="{{ route('alnoormountain') }}">Al-Noor Mountain</a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="col-md-3 menu-heading">
                                                <a href="#">Madina</a>
                                                <ul>
                                                    <li><a href="{{ route('abubakrmosque') }}">Abubakr Mosque</a></li>
                                                    <li><a href="{{ route('almadinahmuseum') }}">Al-Madinah Museum</a>
                                                    </li>
                                                    <li><a href="{{ route('almasjidalnabawi') }}">Al-Masjid Nabawi</a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="col-md-3 menu-heading">
                                                <a href="#">Quran</a>
                                                <ul>
                                                    <li><a href="https://quran.com" target="_blank">Read Quran
                                                            Online</a></li>
                                                </ul>
                                            </li>

                                            <li class="col-md-3 menu-heading">
                                                <a href="#">Good Thoughts</a>
                                                <ul>
                                                    <li><a href="{{ route('goodthoughts') }}">Good Thoughts</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Online Booking -->
                                    <!-- Online Booking & Sacred Services (Dynamic Master Switch) -->
                                    <li class="dropdown {{ request()->is('hotels*') ? 'active' : '' }}">
                                        @if (($serviceHotelsStatus ?? 'active') === 'active')
                                            <a href="{{ route('hotels') }}">Hotels</a>
                                        @else
                                            <a href="javascript:void(0)"
                                                onclick="showComingSoonModal('Hotels &amp; Guest Houses')">
                                                Hotels <span class="badge"
                                                    style="background:#f59e0b;color:#111;font-size:9px;padding:2px 5px;border-radius:10px;">Soon</span>
                                            </a>
                                        @endif
                                    </li>

                                    <li class="dropdown {{ request()->is('cabs*') ? 'active' : '' }}">
                                        @if (($serviceCabsStatus ?? 'active') === 'active')
                                            <a href="{{ route('cabs') }}">Cabs</a>
                                        @else
                                            <a href="javascript:void(0)"
                                                onclick="showComingSoonModal('Auto &amp; Cab Booking')">
                                                Cabs <span class="badge"
                                                    style="background:#f59e0b;color:#111;font-size:9px;padding:2px 5px;border-radius:10px;">Soon</span>
                                            </a>
                                        @endif
                                    </li>

                                    <li class="dropdown {{ request()->is('shops*') ? 'active' : '' }}">
                                        <a href="{{ route('shops') }}">Shop</a>
                                    </li>

                                    <li class="dropdown {{ request()->routeIs('contact') ? 'active' : '' }}">
                                        <a href="{{ route('contact') }}">Contact Us</a>
                                    </li>

                                    <!-- Services -->
                                    <!-- Services -->
                                    <li class="dropdown mega-dropdown">
                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Services</a>

                                        <ul class="dropdown-menu mega-dropdown-menu exp-tag">
                                            <!-- Web Development -->
                                            <li class="col-md-3 menu-heading">
                                                <a href="{{ route('contact', ['subject' => 'Web Development']) }}">Web
                                                    Development</a>
                                                <ul>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Business Website']) }}">Business
                                                            Website</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'E-Commerce Website']) }}">E-Commerce
                                                            Website</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'News Portal']) }}">News
                                                            Portal</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'School Website']) }}">School
                                                            Website</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Coaching Website']) }}">Coaching
                                                            Website</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Custom Web App']) }}">Custom
                                                            Web App</a></li>
                                                </ul>
                                            </li>

                                            <!-- Software Solutions -->
                                            <li class="col-md-3 menu-heading">
                                                <a href="{{ route('contact', ['subject' => 'Software Solutions']) }}">Software
                                                    Solutions</a>
                                                <ul>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'CRM Development']) }}">CRM
                                                            Development</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'ERP Solutions']) }}">ERP
                                                            Solutions</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Billing Software']) }}">Billing
                                                            Software</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Inventory System']) }}">Inventory
                                                            System</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'HRMS Software']) }}">HRMS
                                                            Software</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'School Management']) }}">School
                                                            Management</a></li>
                                                </ul>
                                            </li>

                                            <!-- Mobile & Design -->
                                            <li class="col-md-3 menu-heading">
                                                <a href="{{ route('contact', ['subject' => 'Mobile and Design']) }}">Mobile
                                                    & Design</a>
                                                <ul>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Android App']) }}">Android
                                                            App</a></li>
                                                    <li><a href="{{ route('contact', ['subject' => 'iOS App']) }}">iOS
                                                            App</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Flutter App']) }}">Flutter
                                                            App</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'UI/UX Design']) }}">UI/UX
                                                            Design</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Figma Design']) }}">Figma
                                                            Design</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Logo Design']) }}">Logo
                                                            Design</a></li>
                                                </ul>
                                            </li>

                                            <!-- Marketing & Support -->
                                            <li class="col-md-3 menu-heading">
                                                <a
                                                    href="{{ route('contact', ['subject' => 'Marketing and Support']) }}">Marketing
                                                    & Support</a>
                                                <ul>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'SEO Services']) }}">SEO
                                                            Services</a></li>
                                                    <li><a href="{{ route('contact', ['subject' => 'Google Ads']) }}">Google
                                                            Ads</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Social Media Marketing']) }}">Social
                                                            Media Marketing</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Domain and Hosting']) }}">Domain
                                                            & Hosting</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Website Maintenance']) }}">Website
                                                            Maintenance</a></li>
                                                    <li><a
                                                            href="{{ route('contact', ['subject' => 'Technical Support']) }}">Technical
                                                            Support</a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>

                                    <!-- My Account -->
                                    <li>
                                        <a href="{{ route('customer.dashboard') }}">👤 My Account</a>
                                    </li>

                                </ul>
                            </div>

                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>
</header>


<!-- ===================== CSS FIX ===================== -->
<style>
    .p0 {
        padding: 0;
    }

    .g-0 {
        margin: 0;
    }

    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
        background: #fff;
    }

    body {
        padding-top: 0;
    }

    .cart-count-badge {
        display: inline-flex;
        min-width: 18px;
        height: 18px;
        align-items: center;
        justify-content: center;
        margin-left: 3px;
        padding: 0 5px;
        border-radius: 9px;
        background: #f2c230;
        color: #173d27;
        font-size: 11px;
        font-weight: 700;
        line-height: 1;
    }

    .logo {
        padding: 15px;
    }

    .logo img {
        max-height: 60px;
    }

    /* NAV HOVER FIX (Universal) */
    .navbar-nav>li:hover>a,
    .navbar-nav>li>a:hover {
        background-color: #074121 !important;
        color: #fff !important;
    }

    /* Mega menu inside link hover */
    .mega-dropdown-menu li a:hover {
        background-color: #074121 !important;
        color: #fff !important;
    }

    /* Mega menu heading hover */
    .mega-dropdown-menu .menu-heading>a:hover {
        background-color: #074121 !important;
        color: #fff !important;
    }

    /* Dropdown on hover for desktop */
    @media (min-width: 768px) {
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    }

    @media (min-width: 768px) and (max-width: 1500px) {
        .logo-section>.container-fluid>.row {
            display: flex;
            align-items: center;
        }

        .logo-section>.container-fluid>.row>.col-md-3 {
            width: 26%;
        }

        .logo-section>.container-fluid>.row>.col-md-9 {
            width: 74%;
        }

        .logo {
            padding: 12px;
        }

        .logo img {
            max-width: 100%;
        }

        .navbar {
            min-height: 0;
            margin-bottom: 0;
            border: 0;
        }

        .menu .navbar-nav {
            display: flex;
            float: none;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            border-bottom: 0;
        }

        .menu .navbar-nav>li {
            float: none;
            flex: 0 0 auto;
        }

        .menu .navbar-inverse .navbar-nav>li>a {
            padding: 12px 5px;
            line-height: 20px;
            float: none;
            white-space: nowrap;
        }

        .menu .navbar-nav>li.dropdown>a:after {
            top: 50%;
            transform: translateY(-50%);
        }
    }

    @media (min-width: 768px) and (max-width: 1100px) {
        .logo-section>.container-fluid>.row>.col-md-3 {
            width: 22%;
        }

        .logo-section>.container-fluid>.row>.col-md-9 {
            width: 78%;
        }

        .menu .navbar-inverse .navbar-nav>li>a {
            padding-right: 6px;
            padding-left: 6px;
            font-size: 13px;
        }
    }
</style>


<!-- ===================== JS ===================== -->
<script>
    (function() {
        function syncCartBadge() {
            var totalCount = 0;

            try {
                var rawCart = localStorage.getItem('dewa_cart');
                var parsed = rawCart ? JSON.parse(rawCart) : [];
                totalCount = Array.isArray(parsed) ? parsed.reduce(function(total, item) {
                    return total + (parseInt(item.qty, 10) || parseInt(item.quantity, 10) || 1);
                }, 0) : 0;
            } catch (error) {}

            document.querySelectorAll('.cart-count-badge').forEach(function(badge) {
                badge.textContent = totalCount;
            });
        }

        window.showComingSoonModal = function(serviceName) {
            var modal = document.getElementById('serviceComingSoonModal');
            var title = document.getElementById('comingSoonServiceName');
            var btn = document.getElementById('comingSoonWhatsAppBtn');
            var cleanName = serviceName ? serviceName.replace(/&amp;/g, '&') : 'Service';
            if (title) title.textContent = cleanName + ' - Coming Soon';
            if (btn) {
                btn.href = 'https://wa.me/919648777223?text=' + encodeURIComponent(
                    'Assalamu Alaikum! Main Dewa Sharif Portal par "' + cleanName +
                    '" service ke baare me jaanna chahta hoon.');
            }
            if (modal) {
                modal.style.display = 'flex';
            }
        };

        window.closeComingSoonModal = function() {
            var modal = document.getElementById('serviceComingSoonModal');
            if (modal) modal.style.display = 'none';
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') window.closeComingSoonModal();
        });

        function initializeHeader() {
            function syncHeaderOffset() {
                var header = document.querySelector('header');
                if (header) {
                    document.body.style.paddingTop = Math.ceil(header.getBoundingClientRect().height) + 'px';
                }
            }

            syncHeaderOffset();

            var header = document.querySelector('header');
            if (header && 'ResizeObserver' in window) {
                new ResizeObserver(syncHeaderOffset).observe(header);
            }
            window.addEventListener('resize', syncHeaderOffset);

            if (window.innerWidth >= 768) {
                document.querySelectorAll('.dropdown').forEach(function(dropdown) {
                    dropdown.addEventListener('mouseenter', function() {
                        dropdown.classList.add('open');
                    });
                    dropdown.addEventListener('mouseleave', function() {
                        dropdown.classList.remove('open');
                    });
                });
            } else {
                document.querySelectorAll('.dropdown > a').forEach(function(link) {
                    if (link.nextElementSibling && link.nextElementSibling.classList.contains(
                            'dropdown-menu')) {
                        link.addEventListener('click', function(event) {
                            event.preventDefault();
                            link.parentElement.classList.toggle('open');
                            window.setTimeout(syncHeaderOffset, 0);
                        });
                    }
                });
            }

            syncCartBadge();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeHeader, {
                once: true
            });
        } else {
            initializeHeader();
        }

        window.addEventListener('storage', function(event) {
            if (event.key === 'dewa_cart') syncCartBadge();
        });
        window.addEventListener('dewa-cart-updated', syncCartBadge);
    })();
</script>

<!-- Coming Soon Branded Modal -->
<div id="serviceComingSoonModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:999999; align-items:center; justify-content:center; padding:15px; box-sizing:border-box;"
    onclick="if(event.target === this) closeComingSoonModal();">
    <div
        style="background:#ffffff; border-radius:18px; max-width:480px; width:100%; padding:28px 24px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.35); text-align:center; position:relative;">
        <button type="button" onclick="closeComingSoonModal()"
            style="position:absolute; top:14px; right:16px; background:none; border:none; font-size:24px; line-height:1; color:#94a3b8; cursor:pointer; padding:4px 8px;">&times;</button>
        <div
            style="width:68px; height:68px; border-radius:50%; background:#fef3c7; color:#d97706; display:inline-flex; align-items:center; justify-content:center; font-size:32px; margin-bottom:16px;">
            ⏳
        </div>
        <h4 id="comingSoonServiceName" style="font-size:20px; font-weight:800; color:#0f172a; margin:0 0 10px 0;">
            Service Coming Soon</h4>
        <p style="color:#64748b; font-size:14px; line-height:1.6; margin:0 0 20px 0;">
            Yeh service abhi online portal ke liye tayyar ki ja rahi hai. Agar aapko turant booking ya jaankari chahiye
            to hamare WhatsApp coordinator se seedhe sampark karein.
        </p>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a id="comingSoonWhatsAppBtn"
                href="https://wa.me/919648777223?text=Assalamu%20Alaikum!%20Mujhe%20service%20ke%20bare%20me%20jaankari%20chahiye."
                target="_blank"
                style="background:#25D366; color:#ffffff; font-weight:700; font-size:15px; padding:12px 20px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 12px rgba(37,211,102,0.35);">
                <span>💬 Talk With WhatsApp</span>
            </a>
            <button type="button" onclick="closeComingSoonModal()"
                style="background:#fbbf24; color:#ffffff; font-weight:600; font-size:14px; padding:10px 18px; border-radius:10px; border:none; cursor:pointer;">
                Close
            </button>
        </div>
    </div>
</div>
