<header class="shop-header"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 72px; z-index: 99999; background: #ffffff; border-bottom: 3px solid #074121; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding: 0;">
    <div
        style="display: flex; align-items: center; justify-content: space-between; height: 100%; width: 100%; max-width: 100%; padding: 0 16px; box-sizing: border-box; flex-wrap: nowrap;">

        <!-- Logo & Title -->
        <a href="{{ !empty($shopDeghOnlyMode) ? route('shops.category', 'degh') : route('shops') }}"
            style="text-decoration: none; display: flex; align-items: center; gap: 8px; white-space: nowrap; flex-shrink: 0;">
            <img src="{{ asset('home/images/dewasharif/dewalogos.png') }}" alt="Dewa Shop"
                style="height: 40px; width: auto;">
            <div>
                <span
                    style="font-size: 17px; font-weight: 900; color: #074121; display: block; line-height: 1.1; letter-spacing: -0.3px; white-space: nowrap;">
                    🛍️ DEWA SHARIF
                </span>
                <span
                    style="font-size: 9.5px; color: #555555; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; white-space: nowrap;">
                    Attar, Bartan &amp; Sacred Items
                </span>
            </div>
        </a>

        <!-- Desktop Navigation (Strict 1 Single Row - 100% Guaranteed Right Visibility) -->
        <nav class="d-none d-md-block" style="flex-shrink: 0;">
            <ul class="shop-nav-list"
                style="list-style: none; margin: 0; padding: 0; display: flex; gap: 8px; align-items: center; font-weight: 750; font-size: 12px; white-space: nowrap; flex-wrap: nowrap;">

                @if(!empty($shopDeghOnlyMode))
                    <!-- Degh-Only Mode: Clean, Spacious & Focused Header -->
                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops.category', 'degh') }}"
                            style="color: #074121; background: #dcfce7; font-weight: 800; text-decoration: none; padding: 7px 14px; border-radius: 8px; white-space: nowrap; border: 1.5px solid #16a34a; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(22,163,74,0.15); transition: all 0.2s;"
                            onmouseenter="this.style.background='#bbf7d0'"
                            onmouseleave="this.style.background='#dcfce7'">
                            <span>🍲</span>
                            <span>Degh Niyaz Booking</span>
                            <span style="background: #16a34a; color: #ffffff; font-size: 9.5px; font-weight: 800; padding: 2px 6px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Active</span>
                        </a>
                    </li>

                    <li style="white-space: nowrap;">
                        <a href="javascript:void(0)" onclick="showComingSoonModal('Other Sacred Store Categories')"
                            style="color: #64748b; background: #f8fafc; font-weight: 650; text-decoration: none; padding: 7px 12px; border-radius: 8px; white-space: nowrap; border: 1px dashed #cbd5e1; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;"
                            onmouseenter="this.style.borderColor='#94a3b8'; this.style.color='#334155'; this.style.background='#f1f5f9';"
                            onmouseleave="this.style.borderColor='#cbd5e1'; this.style.color='#64748b'; this.style.background='#f8fafc';">
                            <span>🛍️</span>
                            <span>Other Store Items</span>
                            <span style="background: #f59e0b; color: #111111; font-size: 9.5px; font-weight: 800; padding: 1px 5px; border-radius: 4px;">Soon</span>
                        </a>
                    </li>
                @else
                    <!-- Full Shop Mode: All Categories (Active when Shop is Fully Launched) -->
                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops') }}"
                            style="{{ empty($selectedCategory) || $selectedCategory == 'all' ? 'color: #074121; background: rgba(7,65,33,0.1);' : 'color: #333333; background: transparent;' }} text-decoration: none; padding: 5px 8px; border-radius: 5px; white-space: nowrap; font-weight: 800; transition: all 0.2s;"
                            onmouseenter="this.style.color='#074121'; this.style.background='rgba(7,65,33,0.06)'"
                            onmouseleave="if('{{ $selectedCategory ?? '' }}' !== '' && '{{ $selectedCategory ?? '' }}' !== 'all'){ this.style.color='#333333'; this.style.background='transparent'; }">
                            ✨ All Products
                        </a>
                    </li>

                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops.category', 'islamic') }}"
                            style="{{ ($selectedCategory ?? '') == 'islamic' ? 'color: #074121; background: rgba(7,65,33,0.1); font-weight: 800;' : 'color: #333333; background: transparent;' }} text-decoration: none; padding: 5px 6px; border-radius: 5px; white-space: nowrap; transition: all 0.2s;"
                            onmouseenter="this.style.color='#074121'; this.style.background='rgba(7,65,33,0.06)'"
                            onmouseleave="if('{{ $selectedCategory ?? '' }}' !== 'islamic'){ this.style.color='#333333'; this.style.background='transparent'; }">
                            🌙 Islamic Products
                        </a>
                    </li>

                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops.category', 'attar') }}"
                            style="{{ ($selectedCategory ?? '') == 'attar' ? 'color: #074121; background: rgba(7,65,33,0.1); font-weight: 800;' : 'color: #333333; background: transparent;' }} text-decoration: none; padding: 5px 6px; border-radius: 5px; white-space: nowrap; transition: all 0.2s;"
                            onmouseenter="this.style.color='#074121'; this.style.background='rgba(7,65,33,0.06)'"
                            onmouseleave="if('{{ $selectedCategory ?? '' }}' !== 'attar'){ this.style.color='#333333'; this.style.background='transparent'; }">
                            🌸 Warsi Attar
                        </a>
                    </li>

                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops.category', 'degh') }}"
                            style="color: #074121; background: rgba(7,65,33,0.15); font-weight: 850; text-decoration: none; padding: 5px 8px; border-radius: 5px; white-space: nowrap; border: 1px solid rgba(7,65,33,0.25); transition: all 0.2s;"
                            onmouseenter="this.style.background='rgba(7,65,33,0.22)'"
                            onmouseleave="this.style.background='rgba(7,65,33,0.15)'">
                            🍲 Degh Niyaz
                        </a>
                    </li>

                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops.category', 'clay') }}"
                            style="{{ ($selectedCategory ?? '') == 'clay' ? 'color: #074121; background: rgba(7,65,33,0.1); font-weight: 800;' : 'color: #333333; background: transparent;' }} text-decoration: none; padding: 5px 6px; border-radius: 5px; white-space: nowrap; transition: all 0.2s;"
                            onmouseenter="this.style.color='#074121'; this.style.background='rgba(7,65,33,0.06)'"
                            onmouseleave="if('{{ $selectedCategory ?? '' }}' !== 'clay'){ this.style.color='#333333'; this.style.background='transparent'; }">
                            🏺 Mitti Bartan
                        </a>
                    </li>

                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops.category', 'clothing') }}"
                            style="{{ ($selectedCategory ?? '') == 'clothing' ? 'color: #074121; background: rgba(7,65,33,0.1); font-weight: 800;' : 'color: #333333; background: transparent;' }} text-decoration: none; padding: 5px 6px; border-radius: 5px; white-space: nowrap; transition: all 0.2s;"
                            onmouseenter="this.style.color='#074121'; this.style.background='rgba(7,65,33,0.06)'"
                            onmouseleave="if('{{ $selectedCategory ?? '' }}' !== 'clothing'){ this.style.color='#333333'; this.style.background='transparent'; }">
                            👕 Clothing
                        </a>
                    </li>

                    <li style="white-space: nowrap;">
                        <a href="{{ route('shops.category', 'toys') }}"
                            style="{{ ($selectedCategory ?? '') == 'toys' ? 'color: #074121; background: rgba(7,65,33,0.1); font-weight: 800;' : 'color: #333333; background: transparent;' }} text-decoration: none; padding: 5px 6px; border-radius: 5px; white-space: nowrap; transition: all 0.2s;"
                            onmouseenter="this.style.color='#074121'; this.style.background='rgba(7,65,33,0.06)'"
                            onmouseleave="if('{{ $selectedCategory ?? '' }}' !== 'toys'){ this.style.color='#333333'; this.style.background='transparent'; }">
                            🧸 Toys
                        </a>
                    </li>
                @endif

                <!-- 8. My Account -->
                <li style="white-space: nowrap;">
                    <a href="{{ route('customer.dashboard') }}"
                        style="background: #dcfce7; color: #052c16; padding: 5px 10px; border-radius: 6px; text-decoration: none; font-weight: 800; white-space: nowrap; font-size: 12px; transition: all 0.2s;"
                        onmouseenter="this.style.background='#bbf7d0'" onmouseleave="this.style.background='#dcfce7'">
                        👤 My Account
                    </a>
                </li>

                <!-- 9. Cart -->
                <li style="white-space: nowrap;">
                    <a href="{{ route('shops.cart') }}"
                        style="position: relative; background: #074121; color: #ffffff; padding: 5px 13px; border-radius: 20px; text-decoration: none; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px; box-shadow: 0 3px 10px rgba(7,65,33,0.25); white-space: nowrap; transition: all 0.2s;"
                        onmouseenter="this.style.background='#047857'" onmouseleave="this.style.background='#074121'">
                        <span style="font-size: 13px;">🛒</span>
                        <span style="color: #ffffff;">Cart</span>
                        <span class="cart-count-badge"
                            style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: #ffffff; font-size: 9.5px; font-weight: 900; width: 17px; height: 17px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">0</span>
                    </a>
                </li>

                <!-- 10. Main Site (With Guaranteed Safe Breathing Margin) -->
                <li style="white-space: nowrap; margin-right: 8px;">
                    <a href="{{ route('index') }}"
                        style="background: #074121; color: #ffffff; padding: 5px 12px; border-radius: 6px; text-decoration: none; font-weight: 700; white-space: nowrap; font-size: 12px; transition: all 0.2s;"
                        onmouseenter="this.style.background='#047857'" onmouseleave="this.style.background='#074121'">
                        ← Main Site
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</header>
<div style="height: 72px; width: 100%;"></div>

<!-- Coming Soon Modal for Shop Header & Shop Page -->
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
            Yeh category abhi online portal ke liye tayyar ki ja rahi hai. Filhal <strong>Degh Niyaz Booking</strong>
            live aur active hai. Agar aapko is category ke baare me koi jaankari chahiye to hamare WhatsApp coordinator
            se seedhe sampark karein.
        </p>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a id="comingSoonWhatsAppBtn"
                href="https://wa.me/919648777223?text=Assalamu%20Alaikum!%20Mujhe%20is%20category%20ke%20bare%20me%20jaankari%20chahiye."
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

<script>
    window.showComingSoonModal = function (serviceName) {
        var modal = document.getElementById('serviceComingSoonModal');
        var title = document.getElementById('comingSoonServiceName');
        var btn = document.getElementById('comingSoonWhatsAppBtn');
        var cleanName = serviceName ? serviceName.replace(/&amp;/g, '&') : 'Service';
        if (title) title.textContent = cleanName + ' - Coming Soon';
        if (btn) {
            btn.href = 'https://wa.me/919648777223?text=' + encodeURIComponent('Assalamu Alaikum! Main Dewa Sharif Portal par "' + cleanName + '" category ke baare me jaanna chahta hoon.');
        }
        if (modal) {
            modal.style.display = 'flex';
        }
    };

    window.closeComingSoonModal = function () {
        var modal = document.getElementById('serviceComingSoonModal');
        if (modal) modal.style.display = 'none';
    };

    document.addEventListener("DOMContentLoaded", function () {
        try {
            var storedCart = JSON.parse(localStorage.getItem('dewa_cart') || '[]');
            var totalQty = storedCart.reduce(function (sum, item) { return sum + (parseInt(item.qty) || 0); }, 0);
            var badges = document.querySelectorAll('.cart-count-badge');
            badges.forEach(function (b) { b.textContent = totalQty; });
        } catch (e) { }
    });
</script>