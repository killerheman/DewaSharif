@extends('home.includes.master')

@section('title', 'Dewa Sharif Online Store | Degh Niyaz, Pure Warsi Attar, Janamaz & Tasbih')
@section('meta_title', 'Online Degh Niyaz & Sacred Bazaar | Dewa Sharif Store')
@section('meta_description', 'Book authentic Biryani & Zarda Degh Niyaz, pure Warsi Attar, Janamaz, Tasbih, and sacred tabarruk online with verified direct delivery across India.')
@section('meta_keywords', 'Dewa Sharif Store, Degh Niyaz Booking, Biryani Degh Dewa, Warsi Attar, Chadar peshi Dewa Sharif, Janamaz, Islamic Store Barabanki')
@section('og_title', 'Dewa Sharif Online Store & Sacred Bazaar')
@section('og_description', 'Authentic Biryani Degh Niyaz, pure Warsi Attar, Janamaz, and Sufi tabarruk delivered across India.')


@section('content')
    <div style="background: #f8fafc; min-height: 100vh; padding-bottom: 80px;">

        <!-- TOP HEADER SPACER -->
        <div style="height: 60px; width: 100%;"></div>

        <!-- TOP ANNOUNCEMENT BAR -->
        <div
            style="background: #111827; color: #f59e0b; padding: 10px 0; font-size: 13px; font-weight: 700; text-align: center; border-bottom: 2px solid #f59e0b; letter-spacing: 0.5px;">
            🚚 Shipping Across India on Orders | 100% Guaranteed Sacred &amp; Original Quality
        </div>

        <!-- HERO BANNER WITH REAL ORIENTAL SACRED BAZAAR IMAGE BACKGROUND -->
        <div
            style="background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(17, 24, 39, 0.88)), url('{{ asset('home/images/dewasharif/dewapage/hero_shop_bg.jpg') }}') center/cover no-repeat; color: #ffffff; padding: 60px 0 75px 0; text-align: center; position: relative; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
            <div class="container">
                <span
                    style="background: #f59e0b; color: #ffffffff; padding: 6px 18px; border-radius: 20px; font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; display: inline-block; box-shadow: 0 2px 8px rgba(245,158,11,0.4);">
                    ⭐ Hazrat Waris-e-Pak - Sacred Bazaar
                </span>
                <h1
                    style="font-weight: 900; font-size: 36px; margin-top: 14px; margin-bottom: 12px; background: linear-gradient(135deg, #0db161ff, #22c55e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 3px 6px rgba(0,0,0,0.3);">
                    Dewa Sharif Online E-Commerce Store
                </h1>
                <p
                    style="font-size: 16px; color: #e2e8f0; max-width: 760px; margin: 0 auto 24px auto; line-height: 1.6; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                    Sarkar Waris-e-Pak ke tabarrukat, khushbu-e-attar, chaadar with good fragrance aur mitti ke bartan etc sidhe order karein.
                </p>

                <!-- SEARCH BAR IN HERO -->
                <div style="max-width: 580px; margin: 0 auto; position: relative;">
                    <input type="text" id="shopSearchInput" onkeyup="filterShopProducts()"
                        placeholder="🔍 Search Attar, Clay Pots, Toys, Sufi Kurta, Tasbeeh..."
                        style="width: 100%; height: 50px; border-radius: 30px; border: 2px solid #f59e0b; padding: 0 25px; font-size: 15px; font-weight: 600; outline: none; box-shadow: 0 6px 20px rgba(0,0,0,0.25); color: #0f172a;">
                </div>

                <!-- COLORFUL CATEGORY IMAGE SHOWCASE ROW (100% Dynamic from Database) -->
                <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; margin-top: 30px; max-width: 1100px; margin-left: auto; margin-right: auto;">
                    @foreach(($categories ?? \Illuminate\Support\Facades\DB::table('shop_categories')->where('status', 'active')->orderBy('order_num', 'asc')->get()) as $catCircle)
                        @php
                            $isDeghCircle = in_array(strtolower($catCircle->slug ?? ''), ['degh', 'degh-niyaz']);
                        @endphp
                        @if(!empty($shopDeghOnlyMode) && !$isDeghCircle)
                            <a href="javascript:void(0)" onclick="showComingSoonModal('{{ addslashes($catCircle->name) }}')"
                                style="text-decoration: none; color: #ffffff; text-align: center; transition: transform 0.25s ease;"
                                onmouseenter="this.style.transform='scale(1.09)'" onmouseleave="this.style.transform='scale(1)'">
                                <div
                                    style="width: 72px; height: 72px; border-radius: 50%; overflow: hidden; border: 3px solid {{ $catCircle->theme_color ?? '#f59e0b' }}; box-shadow: 0 4px 15px {{ $catCircle->theme_color ?? '#f59e0b' }}77; margin: 0 auto 6px auto; background: #ffffff; position: relative;">
                                    <img src="{{ asset($catCircle->image ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg') }}"
                                        onerror="this.onerror=null; this.src='/home/images/dewasharif/dewapage/attar_bottle.jpg';"
                                        alt="{{ $catCircle->name }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85;">
                                    <span style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.75); color: #f59e0b; font-size: 8.5px; font-weight: 800; text-transform: uppercase;">Soon</span>
                                </div>
                                <span style="font-size: 11.5px; font-weight: 800; display: block; text-shadow: 0 2px 4px rgba(0,0,0,0.85); max-width: 78px; margin: 0 auto; line-height: 1.15;">
                                    {{ $catCircle->name }}
                                </span>
                            </a>
                        @else
                            <a href="{{ route('shops.category', $catCircle->slug) }}"
                                style="text-decoration: none; color: #ffffff; text-align: center; transition: transform 0.25s ease;"
                                onmouseenter="this.style.transform='scale(1.09)'" onmouseleave="this.style.transform='scale(1)'">
                                <div
                                    style="width: 72px; height: 72px; border-radius: 50%; overflow: hidden; border: 3px solid {{ $catCircle->theme_color ?? '#f59e0b' }}; box-shadow: 0 4px 15px {{ $catCircle->theme_color ?? '#f59e0b' }}77; margin: 0 auto 6px auto; background: #ffffff;">
                                    <img src="{{ asset($catCircle->image ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg') }}"
                                        onerror="this.onerror=null; this.src='/home/images/dewasharif/dewapage/attar_bottle.jpg';"
                                        alt="{{ $catCircle->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <span style="font-size: 11.5px; font-weight: 800; display: block; text-shadow: 0 2px 4px rgba(0,0,0,0.85); max-width: 78px; margin: 0 auto; line-height: 1.15;">
                                    {{ $catCircle->name }}
                                </span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- MAIN DYNAMIC PRODUCT CATALOGUE -->
        <div class="container-fluid" style="margin-top: 25px; width: 100%; max-width: 100%; padding-left: 20px; padding-right: 20px;">

            <!-- UNIFIED LUXURY DEGH NIYAZ HIGHLIGHT CARD -->
            <div id="deghNiyazBannerBox" class="rounded-4 shadow-sm" style="{{ ($selectedCategory ?? '') == 'degh' ? 'display: block;' : 'display: none;' }} width: 100%; background: linear-gradient(135deg, #074121 0%, #047857 55%, #064e3b 100%); color: #ffffff; border: 2px solid #10b981; position: relative; overflow: hidden; margin-bottom: 30px; padding: 35px 40px; box-sizing: border-box;">
                <style>
                    @media (max-width: 991px) {
                        .warsi-watermark-wrapper { right: 20px !important; }
                        .warsi-watermark-text span { font-size: 18px !important; letter-spacing: 2px !important; }
                        .warsi-degh-icon { font-size: 85px !important; }
                    }
                    @media (max-width: 576px) {
                        .warsi-watermark-wrapper { display: none !important; }
                    }
                </style>

                <!-- WATERMARK WRAPPER: DEGH ON TOP + TEXT BELOW (LEVEL WITH PILL BUTTONS) -->
                <div class="warsi-watermark-wrapper" style="position: absolute; right: 40px; top: 25px; bottom: 38px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; pointer-events: none; user-select: none; z-index: 0;">
                    <div class="warsi-degh-icon" style="font-size: 110px; opacity: 0.09; color: #fff; line-height: 1;">
                        🍲
                    </div>
                    <div class="warsi-watermark-text" style="opacity: 0.14; text-align: center; display: flex; align-items: center;">
                        <span style="font-size: 26px; font-weight: 900; letter-spacing: 3.5px; text-transform: uppercase; color: #ffffff; white-space: nowrap; display: block; text-shadow: 0 0 10px rgba(255,255,255,0.3); line-height: 1;">
                            Warsi Degh &amp; Niyaz
                        </span>
                    </div>
                </div>
                <div class="row align-items-center g-3" style="margin: 0;">
                    <div class="col-lg-8 col-12 mb-3 mb-lg-0 p-0" style="padding-left: 5px !important;">
                        <div style="text-align: center; width: 100%;">
                                <!-- BADGE -->
                                <span class="badge" style="background: #fbbf24; color: rgba(3, 3, 3, 1); font-weight: 800; font-size: 12.5px; padding: 7px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); display: inline-block;">
                                    🍲 Sarkar Waris-e-Pak (R.A.) - Sacred Degh Niyaz 
                                </span>
                                
                                <!-- HEADING -->
                                <h2 class="fw-bold text-white mt-2 mb-2" style="font-size: 27px; letter-spacing: -0.3px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); text-align: center;">
                                    Degh Niyaz Booking &amp; Tabarruk Taqseem
                                </h2>
                        </div>
                        <p class="mb-3 text-white" style="font-size: 15px; line-height: 1.6; opacity: 0.95; max-width: 780px;">
                            Dargah Sharif me 100% Warsi Zaiqa aur Shuddh desi ingredients ke sath Niyaz banwayein. Aap chahein to Tabarruk Dargah par Zaayreen aur miskeenon me taqseem karwayein.
                        </p>
                        <!-- 4 Clean Highlights Inside the Card -->
                        <div class="d-flex flex-wrap gap-2 pt-1">
                            <span style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px); color: #ffffff; font-weight: 700; font-size: 13px; padding: 7px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.25); display: inline-flex; align-items: center; gap: 6px;">
                                <span>🤲</span> Niyaz Ba-Naam Fateha
                            </span>
                            <span style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px); color: #ffffff; font-weight: 700; font-size: 13px; padding: 7px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.25); display: inline-flex; align-items: center; gap: 6px;">
                                <span>📦</span> Sealed Parcel Packets Ready
                            </span>
                            <span style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px); color: #ffffff; font-weight: 700; font-size: 13px; padding: 7px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.25); display: inline-flex; align-items: center; gap: 6px;">
                                <span>📅</span> Scheduled Niyaz Date
                            </span>
                            <span style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px); color: #ffffff; font-weight: 700; font-size: 13px; padding: 7px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.25); display: inline-flex; align-items: center; gap: 6px;">
                                <span>💬</span> WhatsApp Invoice &amp; Receipt
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION TITLE BEFORE CARDS -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #074121; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <span>🍲</span> Available Degh Niyaz Packages
                    </h3>
                    <p style="margin: 3px 0 0 0; color: #64748b; font-size: 13px; font-weight: 600;">
                        Showing {{ count($products) }} verified sacred degh offerings direct from Dewa Sharif
                    </p>
                </div>
            </div>

            <div class="row g-3 g-xl-4" id="allProductsContainer" style="margin-top: 20px; padding-top: 10px;">
                @foreach($products as $prod)
                    @if(strtolower($prod['status'] ?? 'active') === 'active')
                        @php
                            $cat = $prod['category'] ?? 'attar';
                            $isDegh = $cat === 'degh';
                            
                            $imgSrc = $prod['image'] ?? '';
                            $imgSrc = preg_replace('#^https?://[^/]+#', '', $imgSrc);
                            $imgSrc = '/' . ltrim($imgSrc, '/');

                            if ($isDegh) {
                                $cardBorder = '2px solid #10b981';
                                $imgBackdrop = 'linear-gradient(135deg, #064e3b 0%, #047857 50%, #10b981 100%)';
                                $cardShadow = '0 10px 25px rgba(16, 185, 129, 0.22)';
                                $hoverShadow = '0 14px 30px rgba(16, 185, 129, 0.32)';
                                $badgeClass = 'btn-gradient-green text-white';
                                $badgeText = '🍲 DEGH NIYAZ';
                                $subColor = '#047857';
                                $priceColor = '#047857';
                                $btnText = '🍲 Book Degh Niyaz';
                            } elseif ($cat === 'attar') {
                                $cardBorder = '1.5px solid #0284c7';
                                $imgBackdrop = 'linear-gradient(135deg, #0b132b 0%, #1e3a8a 50%, #0284c7 100%)';
                                $cardShadow = '0 8px 22px rgba(2, 132, 199, 0.15)';
                                $hoverShadow = '0 12px 28px rgba(2, 132, 199, 0.25)';
                                $badgeClass = 'btn-gradient-navy text-white';
                                $badgeText = '🌸 WARSI ATTAR';
                                $subColor = '#0284c7';
                                $priceColor = '#0369a1';
                                $btnText = '🛒 Add to Cart';
                            } elseif ($cat === 'islamic') {
                                $cardBorder = '1.5px solid #f59e0b';
                                $imgBackdrop = 'linear-gradient(135deg, #78350f 0%, #b45309 50%, #f59e0b 100%)';
                                $cardShadow = '0 8px 22px rgba(245, 158, 11, 0.18)';
                                $hoverShadow = '0 12px 28px rgba(245, 158, 11, 0.28)';
                                $badgeClass = 'btn-gradient-yellow text-dark';
                                $badgeText = '🌙 SACRED TABARRUK';
                                $subColor = '#b45309';
                                $priceColor = '#b45309';
                                $btnText = '🛒 Add to Cart';
                            } elseif ($cat === 'clothing') {
                                $cardBorder = '1.5px solid #ef4444';
                                $imgBackdrop = 'linear-gradient(135deg, #881337 0%, #be123c 50%, #ef4444 100%)';
                                $cardShadow = '0 8px 22px rgba(239, 68, 68, 0.18)';
                                $hoverShadow = '0 12px 28px rgba(239, 68, 68, 0.28)';
                                $badgeClass = 'btn-gradient-red text-white';
                                $badgeText = '👕 SUFI CLOTHING';
                                $subColor = '#be123c';
                                $priceColor = '#b91c1c';
                                $btnText = '🛒 Add to Cart';
                            } elseif ($cat === 'clay') {
                                $cardBorder = '1.5px solid #d97706';
                                $imgBackdrop = 'linear-gradient(135deg, #451a03 0%, #9a3412 50%, #ea580c 100%)';
                                $cardShadow = '0 8px 22px rgba(217, 119, 6, 0.18)';
                                $hoverShadow = '0 12px 28px rgba(217, 119, 6, 0.28)';
                                $badgeClass = 'btn-gradient-yellow text-dark';
                                $badgeText = '🏺 MITTI BARTAN';
                                $subColor = '#9a3412';
                                $priceColor = '#9a3412';
                                $btnText = '🛒 Add to Cart';
                            } elseif ($cat === 'pets') {
                                $cardBorder = '1.5px solid #10b981';
                                $imgBackdrop = 'linear-gradient(135deg, #064e3b 0%, #059669 50%, #10b981 100%)';
                                $cardShadow = '0 8px 22px rgba(16, 185, 129, 0.18)';
                                $hoverShadow = '0 12px 28px rgba(16, 185, 129, 0.28)';
                                $badgeClass = 'btn-gradient-green text-white';
                                $badgeText = '🐱 CAT FOOD & PET CARE';
                                $subColor = '#059669';
                                $priceColor = '#047857';
                                $btnText = '🛒 Add to Cart';
                            } else {
                                $matchedCategory = collect($categories ?? [])->firstWhere('slug', $cat);
                                $themeCol = $matchedCategory->theme_color ?? '#7c3aed';
                                $cardBorder = '1.5px solid ' . $themeCol;
                                $imgBackdrop = 'linear-gradient(135deg, #1e293b 0%, ' . $themeCol . ' 100%)';
                                $cardShadow = '0 8px 22px ' . $themeCol . '22';
                                $hoverShadow = '0 12px 28px ' . $themeCol . '35';
                                $badgeClass = 'btn-gradient-navy text-white';
                                $badgeText = strtoupper($matchedCategory->badge_text ?? ($matchedCategory->name ?? '⭐ SPECIAL STORE'));
                                $subColor = $themeCol;
                                $priceColor = $themeCol;
                                $btnText = '🛒 Add to Cart';
                            }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 prod-card-item" data-name="{{ strtolower($prod['name']) }}"
                            data-category="{{ $prod['category'] ?? 'attar' }}" style="margin-top: 10px; margin-bottom: 30px; scroll-margin-top: 95px;">
                            <div style="background: #ffffff; border-radius: 14px; border: {{ $cardBorder }}; overflow: hidden; box-shadow: {{ $cardShadow }}; height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease;"
                                onmouseenter="this.style.transform='translateY(-5px)'; this.style.boxShadow='{{ $hoverShadow }}';"
                                onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='{{ $cardShadow }}';">
                                <div>
                                    <div style="position: relative; height: 205px; overflow: hidden; background: {{ $imgBackdrop }};">
                                        <a href="{{ route('shops.product', $prod['slug'] ?? ($prod['id'] ?? 1)) }}" style="display: block; width: 100%; height: 100%;">
                                            <img src="{{ $imgSrc }}" alt="{{ $prod['name'] }}"
                                                onerror="this.onerror=null; this.src='/home/images/dewasharif/dewapage/{{ $isDegh ? 'degh_niyaz.jpg' : 'attar_bottle.jpg' }}';"
                                                style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                                                onmouseenter="this.style.transform='scale(1.06)'" onmouseleave="this.style.transform='scale(1)'">
                                        </a>
                                        <span class="badge {{ $badgeClass }}"
                                            style="position: absolute; top: 10px; left: 10px; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.3px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                                            {{ $badgeText }}
                                        </span>
                                        <span
                                            style="position: absolute; top: 10px; right: 10px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%); color: #fff; font-size: 11px; font-weight: 900; padding: 4px 9px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                                            {{ $isDegh ? 'PARCEL READY' : 'OFFER' }}
                                        </span>
                                    </div>
                                    <div style="padding: 18px 18px 10px 18px;">
                                        <h5
                                            style="font-size: 15px; font-weight: 900; color: #0f172a; margin-bottom: 6px; line-height: 1.35; height: 42px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $prod['name'] }}">
                                            <a href="{{ route('shops.product', $prod['slug'] ?? ($prod['id'] ?? 1)) }}" style="color: inherit; text-decoration: none; transition: color 0.2s;" onmouseenter="this.style.color='#03a64a';" onmouseleave="this.style.color='#0f172a';">
                                                {{ $prod['name'] }}
                                            </a>
                                        </h5>
                                        <p
                                            style="font-size: 12.5px; color: #475569; margin-bottom: 10px; line-height: 1.4; height: 38px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $prod['description'] ?? '' }}">
                                            {{ $prod['description'] ?? 'Original handcrafted quality product for Dargah Ziyarat.' }}
                                        </p>
                                        <div style="height: 28px; margin-bottom: 8px; display: flex; align-items: center;">
                                            @if(!empty($prod['volume_ml']))
                                                <span style="background: {{ $isDegh ? '#dcfce7' : '#f1f5f9' }}; color: {{ $isDegh ? '#166534' : '#334155' }}; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid {{ $isDegh ? '#bbf7d0' : '#e2e8f0' }};">
                                                    ⚖️ {{ $prod['volume_ml'] }}
                                                </span>
                                            @else
                                                <span style="background: #f8fafc; color: #64748b; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px; border: 1px solid #f1f5f9;">
                                                    ✨ 100% Sacred Quality
                                                </span>
                                            @endif
                                        </div>
                                        @php
                                            $prodRating = !empty($prod['rating']) ? (float)$prod['rating'] : 5.0;
                                            $prodReviewText = !empty($prod['reviews_count']) ? $prod['reviews_count'] : ($isDegh ? '240+ Niyaz Bookings' : '150+ Devotee Reviews');
                                        @endphp
                                        <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 8px; flex-wrap: nowrap; white-space: nowrap;">
                                            <span style="color: #f59e0b; font-size: 13.5px; letter-spacing: 0.5px; flex-shrink: 0; white-space: nowrap;">
                                                @for($s = 1; $s <= 5; $s++)
                                                    {{ $s <= round($prodRating) ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                            <span style="font-size: 11.5px; color: #64748b; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">({{ number_format($prodRating, 1) }} / {{ $prodReviewText }})</span>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $prodStock = (int)($prod['stock_quantity'] ?? ($prod['stock'] ?? 0));
                                    $isOutOfStock = $prodStock <= 0;
                                    $isLowStock = ($prodStock > 0 && $prodStock <= 5);
                                @endphp
                                <div style="padding: 0 18px 18px 18px; margin-top: auto;">
                                    <div
                                        style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 12px;">
                                        <div>
                                            <span
                                                style="font-size: 20px; font-weight: 900; color: {{ $priceColor }};">₹{{ number_format($prod['price']) }}</span>
                                            <span
                                                style="font-size: 13px; color: #94a3b8; text-decoration: line-through; margin-left: 6px;">₹{{ number_format($prod['mrp'] ?? ($prod['price'] * 1.2)) }}</span>
                                        </div>
                                        @if($isOutOfStock)
                                            <span style="font-size: 11.5px; color: #dc2626; font-weight: 900; background: #fee2e2; padding: 3px 8px; border-radius: 6px; border: 1px solid #fca5a5;">✕ Out of Stock</span>
                                        @endif
                                    </div>
                                    @if($isOutOfStock)
                                        <button type="button" disabled
                                            class="btn w-100"
                                            style="font-weight: 800; font-size: 14px; border-radius: 8px; padding: 11px 20px; border: 1.5px solid #cbd5e1; background: #f1f5f9; color: #94a3b8; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                            🚫 Out of Stock
                                        </button>
                                    @elseif(($serviceShopStatus ?? 'whatsapp_only') === 'whatsapp_only')
                                        @php
                                            $waItemMsg = "Assalamu Alaikum! Main Dewa Sharif Portal se '" . ($prod['name'] ?? 'Product') . "' (Price: ₹" . number_format($prod['price']) . ") order karna chahta hoon. Kripya details aur payment batayein.";
                                            $waItemUrl = "https://wa.me/919648777223?text=" . urlencode($waItemMsg);
                                        @endphp
                                        <div style="display: flex; flex-direction: column; gap: 8px;">
                                            <a href="{{ route('shops.product', $prod['slug'] ?? ($prod['id'] ?? 1)) }}"
                                                class="btn w-100 text-decoration-none"
                                                style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%); color: #111827; font-weight: 800; font-size: 13.5px; border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 3px 10px rgba(245, 158, 11, 0.35); border: none; transition: transform 0.2s;"
                                                onmouseenter="this.style.transform='translateY(-1px)';" onmouseleave="this.style.transform='translateY(0)';">
                                                <i class="bi bi-eye-fill"></i> View in Detail →
                                            </a>
                                            <a href="{{ $waItemUrl }}" target="_blank"
                                                class="btn w-100 text-decoration-none"
                                                style="background: #25D366; color: #ffffff; font-weight: 800; font-size: 13px; border-radius: 8px; padding: 9px 14px; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 3px 8px rgba(37, 211, 102, 0.3); border: 1px solid #1ebe5d; transition: transform 0.2s;"
                                                onmouseenter="this.style.transform='translateY(-1px)';" onmouseleave="this.style.transform='translateY(0)';">
                                                <i class="fa fa-whatsapp" style="font-size: 16px;"></i> Order on WhatsApp
                                            </a>
                                        </div>
                                    @else
                                        @if($cat === 'degh')
                                            <button type="button"
                                                onclick="bookDeghDirect({{ $prod['id'] }}, '{{ addslashes($prod['name']) }}', {{ $prod['price'] }}, '{{ $imgSrc }}', {{ $prodStock }})"
                                                class="btn w-100 btn-gradient-green"
                                                style="font-weight: 900; font-size: 14px; border-radius: 8px; padding: 11px 20px; border: none; display: flex; align-items: center; justify-content: center; gap: 6px; transition: transform 0.2s;"
                                                onmouseenter="this.style.transform='translateY(-1px)'" onmouseleave="this.style.transform='translateY(0)'">
                                                {{ $btnText }}
                                            </button>
                                        @else
                                            <button type="button"
                                                onclick="addToCart({{ $prod['id'] }}, '{{ addslashes($prod['name']) }}', {{ $prod['price'] }}, '{{ $imgSrc }}', {{ $prodStock }}, this)"
                                                class="btn w-100 btn-gradient-green"
                                                style="font-weight: 900; font-size: 14px; border-radius: 8px; padding: 11px 20px; border: none; display: flex; align-items: center; justify-content: center; gap: 6px; transition: transform 0.2s;"
                                                onmouseenter="this.style.transform='translateY(-1px)'" onmouseleave="this.style.transform='translateY(0)'">
                                                {{ $btnText }}
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- REVIEWS & RATINGS SECTION -->
            <div style="margin-top: 60px; padding-top: 30px; border-top: 2px solid #e2e8f0;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <div>
                        <h4 style="font-weight: 900; color: #074121; margin: 0; font-size: 22px;">
                            ⭐ Devotee Reviews &amp; Blessed Experiences
                        </h4>
                        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13.5px; font-weight: 600;">
                            Real customer ratings direct from Dewa Sharif Pilgrims &amp; Zaireen
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-gradient-green text-white font-weight-bold px-3 py-2 rounded-pill shadow-xs" data-toggle="modal" data-target="#writeReviewModal">
                            ✍️ Write a Review
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success font-weight-bold px-3 py-2 rounded-pill" data-toggle="modal" data-target="#sendFeedbackModal">
                            💬 Send Feedback
                        </button>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($shopReviews ?? [] as $rev)
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-1">
                                            <span style="color: #f59e0b; font-size: 15px;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $rev->rating ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                            <strong style="font-size: 13px; color: #0f172a; margin-left: 4px;">{{ $rev->rating }}.0</strong>
                                        </div>
                                        <small style="color: #94a3b8; font-size: 11.5px;">{{ date('d M Y', strtotime($rev->created_at ?? now())) }}</small>
                                    </div>
                                    @if(!empty($rev->title))
                                        <h6 style="font-weight: 800; color: #0f172a; margin-bottom: 6px; font-size: 14.5px;">{{ $rev->title }}</h6>
                                    @endif
                                    <p style="font-size: 13px; color: #475569; line-height: 1.5; margin-bottom: 10px;">
                                        "{{ $rev->comment }}"
                                    </p>
                                </div>
                                <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 800; font-size: 12.5px; color: #0f172a;">👤 {{ $rev->customer_name }}</span>
                                    <span style="font-size: 11px; color: #16a34a; font-weight: 700; background: #dcfce7; padding: 2px 8px; border-radius: 4px;">Verified Devotee</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 text-muted">
                            <p>Be the first devotee to share your experience with Dewa Sharif Sacred Store!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- WRITE REVIEW MODAL -->
    <div class="modal fade" id="writeReviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <form id="publicReviewForm" onsubmit="submitPublicReview(event)">
                    <div class="modal-header" style="background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #10b981 100%); color: #fff;">
                        <h5 class="modal-title font-weight-bold"><i class="fa fa-star text-warning mr-2"></i>Write a Customer Review</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="service_type" value="shop">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Select Product / Item*</label>
                            <select name="item_name" class="form-control" required>
                                @foreach($products as $p)
                                    <option value="{{ $p['name'] }}">{{ $p['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Rating*</label>
                            <select name="rating" class="form-control font-weight-bold">
                                <option value="5" selected>★★★★★ 5 Stars (Outstanding Quality)</option>
                                <option value="4">★★★★☆ 4 Stars (Very Good)</option>
                                <option value="3">★★★☆☆ 3 Stars (Average)</option>
                                <option value="2">★★☆☆☆ 2 Stars (Needs Improvement)</option>
                                <option value="1">★☆☆☆☆ 1 Star (Not Satisfied)</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Name*</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Mohd Rashid" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. 9876543210">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Headline / Short Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Best quality attar received!">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Blessed Experience / Review*</label>
                            <textarea name="comment" class="form-control" rows="4" placeholder="Share how the sacred product or degh was..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="btnSubmitReview" class="btn btn-success font-weight-bold px-4" style="background: #16a34a; border-color: #16a34a;">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SEND FEEDBACK MODAL -->
    <div class="modal fade" id="sendFeedbackModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <form id="publicFeedbackForm" onsubmit="submitPublicFeedback(event)">
                    <div class="modal-header" style="background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 50%, #2563eb 100%); color: #fff;">
                        <h5 class="modal-title font-weight-bold"><i class="fa fa-commenting text-warning mr-2"></i>Send Feedback to Administration</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="service_type" value="shop">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Name*</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Fatima Warsi" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Phone Number*</label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. 9876543210" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Email (Optional)</label>
                            <input type="email" name="email" class="form-control" placeholder="you@domain.com">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Subject*</label>
                            <input type="text" name="subject" class="form-control" placeholder="e.g. Packaging feedback / Question" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Feedback / Suggestion*</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="How can we serve you better?" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="btnSubmitFeedback" class="btn btn-primary font-weight-bold px-4" style="background: #2563eb; border-color: #2563eb;">
                            Send Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- FLOATING TOAST NOTIFICATION FOR ADD TO CART -->
    <div id="addToCartToast"
        style="position: fixed; bottom: 25px; right: 25px; z-index: 109000; background: #111827; color: #ffffff; padding: 12px 22px; border-radius: 30px; border: 2px solid #10b981; box-shadow: 0 10px 30px rgba(0,0,0,0.35); font-weight: 800; font-size: 13.5px; display: none; align-items: center; gap: 10px;">
        <span style="font-size: 18px;">✅</span> 
        <span id="toastItemName">Item added to cart!</span>
        <a href="{{ route('shops.cart') }}" style="background: #10b981; color: #ffffff; padding: 5px 14px; border-radius: 20px; text-decoration: none; font-size: 12.5px; font-weight: 900; margin-left: 6px;">View Cart ↗</a>
    </div>

    <style>
        .btn-gradient-green {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4) !important;
            transition: all 0.25s ease-in-out;
        }
        .btn-gradient-green:hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.5) !important;
        }
        .btn-gradient-navy {
            background: linear-gradient(135deg, #0b132b 0%, #1c2541 45%, #1e40af 85%, #3b82f6 100%) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.35);
            transition: all 0.25s ease-in-out;
        }
        .btn-gradient-navy:hover {
            background: linear-gradient(135deg, #1c2541 0%, #1e40af 50%, #2563eb 100%) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.45);
        }
        .btn-gradient-red {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
            transition: all 0.25s ease-in-out;
        }
        .btn-gradient-yellow {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #ee8916 100%) !important;
            color: #1e1b4b !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
            transition: all 0.25s ease-in-out;
        }
        .badge-gradient-green {
            background: linear-gradient(135deg, #059669 0%, #10b981 60%, #047857 100%) !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.35);
        }
        .badge-gradient-blue {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 50%, #1d4ed8 100%) !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
        }
        .badge-gradient-red {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%) !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(220, 38, 38, 0.35);
        }
        .badge-gradient-yellow {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #ee8916 100%) !important;
            color: #1e1b4b !important;
            font-weight: 800;
            box-shadow: 0 2px 5px rgba(245, 158, 11, 0.35);
        }
        .cat-pill-btn {
            background: #f1f5f9;
            color: #475569;
            transition: all 0.2s ease;
        }

        .cat-pill-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .cat-pill-btn.active {
            background: linear-gradient(135deg, #0b132b 0%, #1c2541 45%, #1e40af 85%, #3b82f6 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(30, 64, 175, 0.35);
        }
        .cat-pill-btn.active-degh {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.45);
        }

        /* GRID ROW ALIGNMENT - NO EMPTY SPACES / NO FLOAT JAGGED WRAPPING */
        #allProductsContainer {
            display: flex !important;
            flex-wrap: wrap !important;
        }
        #allProductsContainer::before,
        #allProductsContainer::after {
            display: none !important;
        }
        .prod-card-item {
            display: flex !important;
            flex-direction: column !important;
            float: none !important;
            margin-bottom: 30px;
        }
        @media (min-width: 992px) {
            .prod-card-item:nth-child(4n+1) {
                clear: both !important;
            }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .prod-card-item:nth-child(3n+1) {
                clear: both !important;
            }
        }
        @media (min-width: 576px) and (max-width: 767px) {
            .prod-card-item:nth-child(2n+1) {
                clear: both !important;
            }
        }
    </style>

    <script>
        var cart = [];
        try {
            cart = JSON.parse(localStorage.getItem('dewa_cart') || '[]');
        } catch (e) {
            cart = [];
        }

        function bookDeghDirect(id, name, price, image, maxStock) {
            maxStock = parseInt(maxStock);
            if (isNaN(maxStock)) maxStock = 999;
            if (maxStock <= 0) {
                alert("Sorry, '" + name + "' is currently Out of Stock!");
                return;
            }

            id = String(id);
            var currentCart = [];
            try {
                currentCart = JSON.parse(localStorage.getItem('dewa_cart') || '[]');
            } catch (e) {
                currentCart = [];
            }
            if (!Array.isArray(currentCart)) currentCart = [];

            var existing = currentCart.find(function (item) { return String(item.id) === id; });
            if (!existing) {
                currentCart.push({
                    id: id,
                    name: name,
                    price: parseFloat(price) || 0,
                    image: image,
                    qty: 1,
                    maxStock: maxStock
                });
            }
            try {
                localStorage.setItem('dewa_cart', JSON.stringify(currentCart));
            } catch(e) {}
            window.location.href = "{{ route('shops.checkout') }}";
        }

        function addToCart(id, name, price, image, maxStock, btn) {
            // Handle optional maxStock if called with 5 params (id, name, price, image, btn)
            if (typeof maxStock === 'object' && maxStock !== null) {
                btn = maxStock;
                maxStock = 999;
            }
            maxStock = parseInt(maxStock);
            if (isNaN(maxStock)) maxStock = 999;

            if (maxStock <= 0) {
                alert("Sorry, '" + name + "' is currently Out of Stock!");
                return;
            }

            id = String(id);
            var existing = cart.find(function (item) { return String(item.id) === id; });
            if (existing) {
                var currentQty = parseInt(existing.qty) || 1;
                if (currentQty >= maxStock) {
                    alert("Sorry! Only " + maxStock + " unit(s) are available in stock for '" + name + "'.");
                    return;
                }
                existing.qty = currentQty + 1;
                existing.maxStock = maxStock;
            } else {
                cart.push({ id: id, name: name, price: parseFloat(price) || 0, image: image, qty: 1, maxStock: maxStock });
            }
            try {
                localStorage.setItem('dewa_cart', JSON.stringify(cart));
            } catch(e) {}
            
            updateCartBadge();

            // Button visual feedback
            if (btn) {
                var origText = btn.innerHTML;
                btn.innerHTML = '✔ Added!';
                setTimeout(function() {
                    btn.innerHTML = origText;
                }, 1200);
            }

            // Toast feedback
            var toastName = document.getElementById('toastItemName');
            var toastBox = document.getElementById('addToCartToast');
            if (toastName) toastName.textContent = name + ' added to cart!';
            if (toastBox) {
                toastBox.style.display = 'flex';
                toastBox.style.opacity = '1';
                clearTimeout(window.cartToastTimer);
                window.cartToastTimer = setTimeout(function() {
                    toastBox.style.transition = 'opacity 0.4s ease';
                    toastBox.style.opacity = '0';
                    setTimeout(function() {
                        toastBox.style.display = 'none';
                        toastBox.style.opacity = '1';
                    }, 400);
                }, 2400);
            }
        }

        function updateCartBadge() {
            var totalQty = cart.reduce(function (sum, item) { return sum + (parseInt(item.qty) || 0); }, 0);
            var badges = document.querySelectorAll('.cart-count-badge');
            badges.forEach(function(b) { b.textContent = totalQty; });
            if (window.jQuery) {
                $('.cart-count-badge').text(totalQty);
            }
        }

        function filterCategory(cat, btn) {
            $('.cat-pill-btn').removeClass('active active-degh');
            var targetBtn = btn ? $(btn) : $('.cat-pill-btn[href*="' + cat + '"]');
            
            if (cat === 'degh') {
                targetBtn.addClass('active active-degh');
                $('#deghNiyazBannerBox').fadeIn(250);
            } else {
                targetBtn.addClass('active');
                $('#deghNiyazBannerBox').hide();
            }

            if (cat === 'all' || !cat) {
                $('.prod-card-item').fadeIn(200);
            } else {
                $('.prod-card-item').hide();
                $('.prod-card-item[data-category="' + cat + '"]').fadeIn(200);
            }
        }

        function filterShopProducts() {
            var query = $('#shopSearchInput').val().toLowerCase().trim();
            $('.prod-card-item').each(function () {
                var name = $(this).attr('data-name');
                if (name && name.indexOf(query) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        function submitPublicReview(e) {
            e.preventDefault();
            var form = document.getElementById('publicReviewForm');
            var btn = document.getElementById('btnSubmitReview');
            btn.disabled = true;
            btn.innerText = 'Submitting...';

            var formData = new FormData(form);
            var dataObj = {};
            formData.forEach(function(val, key) { dataObj[key] = val; });

            fetch("{{ route('reviews.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(dataObj)
            })
            .then(function(res) { return res.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.innerText = 'Submit Review';
                if (res.success) {
                    alert('🎉 ' + res.message);
                    $('#writeReviewModal').modal('hide');
                    form.reset();
                    location.reload();
                } else {
                    alert('❌ ' + (res.message || 'Error submitting review'));
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.innerText = 'Submit Review';
                alert('Server error while submitting review.');
            });
        }

        function submitPublicFeedback(e) {
            e.preventDefault();
            var form = document.getElementById('publicFeedbackForm');
            var btn = document.getElementById('btnSubmitFeedback');
            btn.disabled = true;
            btn.innerText = 'Sending...';

            var formData = new FormData(form);
            var dataObj = {};
            formData.forEach(function(val, key) { dataObj[key] = val; });

            fetch("{{ route('feedback.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(dataObj)
            })
            .then(function(res) { return res.json(); })
            .then(function(res) {
                btn.disabled = false;
                btn.innerText = 'Send Feedback';
                if (res.success) {
                    alert('🎉 ' + res.message);
                    $('#sendFeedbackModal').modal('hide');
                    form.reset();
                } else {
                    alert('❌ ' + (res.message || 'Error submitting feedback'));
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.innerText = 'Send Feedback';
                alert('Server error while sending feedback.');
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            updateCartBadge();
            var serverCat = "{{ $selectedCategory ?? '' }}";
            if (serverCat && serverCat !== 'all') {
                filterCategory(serverCat);
                setTimeout(function() {
                    var container = document.getElementById('allProductsContainer');
                    if (container) {
                        var topPos = container.getBoundingClientRect().top + window.pageYOffset - 120;
                        window.scrollTo({ top: topPos, behavior: 'smooth' });
                    }
                }, 150);
            } else {
                var hash = window.location.hash.replace('#', '').replace('-section', '');
                if (hash) {
                    if (hash === 'islamic' || hash === 'tabarrukat') hash = 'islamic';
                    if (hash === 'clay' || hash === 'mitti') hash = 'clay';
                    filterCategory(hash);
                }
            }
        });
    </script>
@endsection