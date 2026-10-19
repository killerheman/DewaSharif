@extends('home.includes.master')

@section('title', ($product['name'] ?? 'Sacred Item') . ' - Dewa Sharif Sacred Online Shop')

@section('content')
@php
    $catSlug = strtolower($product['category'] ?? ($product['category_slug'] ?? 'attar'));
    $isDegh = in_array($catSlug, ['degh', 'degh-niyaz']);
    $themeCol = $category->theme_color ?? ($isDegh ? '#10b981' : '#0284c7');
    $rawImg = $product['image'] ?? ($product['thumbnail'] ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg');
    $imgSrc = preg_replace('#^https?://[^/]+#', '', $rawImg);
    $imgSrc = '/' . ltrim($imgSrc, '/');

    $stock = (int)($product['stock_quantity'] ?? ($product['stock'] ?? 50));
    $isOut = $stock <= 0;
    $isLow = $stock > 0 && $stock <= 5;

    $price = (float)($product['price'] ?? 299);
    $mrp = (float)($product['mrp'] ?? round($price * 1.35));
    $discountPct = ($mrp > $price) ? round((($mrp - $price) / $mrp) * 100) : 0;

    if ($isDegh) {
        $waMessage = "Assalamu Alaikum! Main Dewa Sharif Portal se Degh Niyaz: '" . ($product['name'] ?? 'Degh') . "' (Price: ₹" . number_format($price) . ") book karna chahta hoon. Kripya Fateha aur Taqseem ki details batayein.";
    } else {
        $waMessage = "Assalamu Alaikum! Main Dewa Sharif Portal se '" . ($product['name'] ?? 'Product') . "' (Price: ₹" . number_format($price) . ") order karna chahta hoon. Kripya payment aur delivery details batayein.";
    }
    $waUrl = "https://wa.me/919648777223?text=" . urlencode($waMessage);
@endphp

<style>
    .prod-detail-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding-top: 30px;
        padding-bottom: 80px;
    }
    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        font-size: 13.5px;
    }
    .breadcrumb-item a:hover {
        color: #0b5e36;
    }
    .breadcrumb-item.active {
        color: #0f172a;
        font-weight: 700;
        font-size: 13.5px;
    }
    .prod-main-img-box {
        background: #ffffff;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
        padding: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        text-align: center;
        margin-top: 0;
    }
    .prod-info-box {
        background: #ffffff;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
        padding: 24px 28px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-top: 0;
    }
    .prod-main-img {
        max-width: 100%;
        max-height: 480px;
        height: auto;
        object-fit: contain;
        border-radius: 12px;
        transition: transform 0.35s ease;
    }
    .prod-main-img-box:hover .prod-main-img {
        transform: scale(1.05);
    }
    .btn-action-full {
        display: block !important;
        width: 100% !important;
        box-sizing: border-box !important;
        padding: 13px 20px !important;
        font-size: 15px !important;
        font-weight: 800 !important;
        border-radius: 8px !important;
        text-align: center !important;
        text-decoration: none !important;
        line-height: 1.4 !important;
        cursor: pointer !important;
        margin-bottom: 10px !important;
        border: none !important;
        transition: all 0.25s ease !important;
    }
    .btn-cart-gray {
        background: linear-gradient(135deg, #475569 0%, #334155 50%, #1e293b 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(30, 41, 59, 0.35) !important;
    }
    .btn-cart-gray:hover {
        background: linear-gradient(135deg, #334155 0%, #1e293b 50%, #0f172a 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(30, 41, 59, 0.45) !important;
    }
    .btn-buy-now {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%) !important;
        color: #111827 !important;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4) !important;
    }
    .btn-buy-now:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(217, 119, 6, 0.5) !important;
    }
    .btn-whatsapp-order {
        background: #25D366 !important;
        color: #ffffff !important;
        border: 1.5px solid #1ebe5d !important;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35) !important;
    }
    .btn-whatsapp-order:hover {
        background: #1eb956 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 211, 102, 0.45) !important;
    }
    .spec-table th {
        width: 35%;
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 13.5px;
        border-color: #e2e8f0;
    }
    .spec-table td {
        color: #0f172a;
        font-weight: 600;
        font-size: 13.5px;
        border-color: #e2e8f0;
    }
    .highlight-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .qty-btn {
        width: 36px;
        height: 36px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        border-radius: 8px;
        font-weight: 900;
        font-size: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .qty-btn:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
    .qty-input {
        width: 55px;
        height: 36px;
        text-align: center;
        font-weight: 800;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        margin: 0 6px;
    }
</style>

<div class="prod-detail-wrapper">
    <div class="container">

        <!-- BREADCRUMB NAVIGATION (CENTERED) -->
        <div style="text-align: center; margin-bottom: 15px; width: 100%;">
            <ol class="breadcrumb" style="display: inline-block; background: transparent; padding: 0; margin: 0; text-align: center;">
                <li style="display: inline;"><a href="{{ route('index') }}" style="color: #64748b; font-weight: 600; text-decoration: none;"><i class="fa fa-home"></i> Home</a></li>
                <li style="display: inline; margin: 0 8px; color: #cbd5e1;">/</li>
                <li style="display: inline;"><a href="{{ route('shops') }}" style="color: #64748b; font-weight: 600; text-decoration: none;">Sacred Shop</a></li>
                @if(!empty($category))
                    <li style="display: inline; margin: 0 8px; color: #cbd5e1;">/</li>
                    <li style="display: inline;"><a href="{{ route('shops.category', $category->slug) }}" style="color: #64748b; font-weight: 600; text-decoration: none;">{{ $category->name }}</a></li>
                @endif
                <li style="display: inline; margin: 0 8px; color: #cbd5e1;">/</li>
                <li style="display: inline; color: #0f172a; font-weight: 700;">{{ $product['name'] }}</li>
            </ol>
        </div>

        <!-- CENTERED SACRED BAZAAR HEADER (FULL WIDTH & BALANCED ON BOTH SIDES) -->
        <div class="prod-center-header" style="text-align: center; margin: 0 auto 30px auto; width: 100%; max-width: 950px; padding: 0 15px;">
            <!-- Sacred Bazaar Golden Amber Pill Badge -->
            <div style="display: inline-block; margin-bottom: 12px;">
                <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #000000; font-weight: 800; font-size: 13px; padding: 7px 26px; border-radius: 25px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.4); display: inline-block;">
                    ⭐ SARKAR WARIS-E-PAK SACRED BAZAAR
                </div>
            </div>

            <!-- Main Vibrant Green Title -->
            <h1 style="color: #03a64a; font-size: 34px; font-weight: 900; line-height: 1.3; letter-spacing: -0.5px; margin: 0 0 10px 0; text-align: center;">
                {{ $product['name'] }}
            </h1>

            <!-- Subtitle / Meta Info (Centered) -->
            <div style="text-align: center; font-size: 14px; color: #64748b; line-height: 1.6;">
                <span style="display: inline-block; margin: 0 8px;">Item Code: <strong style="color: #0f172a; font-family: monospace;">#PRD-{{ $product['id'] }}</strong></span>
                <span style="display: inline-block; color: #cbd5e1;">•</span>
                <span style="display: inline-block; margin: 0 8px;">Category: <strong style="color: #047857;">{{ $category->name ?? ucfirst($catSlug) }}</strong></span>
                <span style="display: inline-block; color: #cbd5e1;">•</span>
                <span style="display: inline-block; margin: 0 8px; color: #16a34a; font-weight: 700;"><i class="fa fa-shield"></i> 100% Authentic Dewa Tabarruk</span>
            </div>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start; margin-left: -15px; margin-right: -15px;">

            <!-- LEFT COLUMN: PRODUCT IMAGE GALLERY & ACTION BUTTONS -->
            <div class="col-md-5 col-sm-12" style="padding-left: 15px; padding-right: 15px; margin-bottom: 30px;">
                <div class="prod-main-img-box" style="margin-top: 0;">
                    
                    <!-- Top Category & Offer Badges -->
                    <span class="badge" style="position: absolute; top: 16px; left: 16px; background: {{ $themeCol }}; color: #ffffff; font-weight: 800; font-size: 12px; padding: 6px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $category->name ?? 'Sacred Item' }}
                    </span>

                    @if($discountPct > 0)
                        <span class="badge bg-danger" style="position: absolute; top: 16px; right: 16px; font-weight: 900; font-size: 12px; padding: 6px 12px; border-radius: 8px; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);">
                            {{ $discountPct }}% OFF
                        </span>
                    @endif

                    <div style="min-height: 340px; display: flex; align-items: center; justify-content: center; padding: 30px 10px;">
                        <img id="mainProductImage" src="{{ $imgSrc }}" alt="{{ $product['name'] }}" class="prod-main-img"
                            onerror="this.onerror=null; this.src='/home/images/dewasharif/dewapage/attar_bottle.jpg';">
                    </div>

                    <!-- ACTION BUTTONS: ALL 3 100% FULL-WIDTH IDENTICAL TO WHATSAPP -->
                    <div style="width: 100%; margin-top: 18px; display: block;">
                        
                        <!-- 1. Add to Cart Button (Full Width, Gray Gradient) -->
                        @if($isOut)
                            <button type="button" disabled class="btn btn-action-full" style="background: #94a3b8 !important; color: #ffffff !important; cursor: not-allowed !important;">
                                ✕ Out of Stock
                            </button>
                        @else
                            <button type="button" onclick="addToCartDetail({{ $product['id'] }}, '{{ addslashes($product['name']) }}', {{ $price }}, '{{ $imgSrc }}', {{ $stock }})" class="btn btn-action-full btn-cart-gray">
                                <i class="fa fa-shopping-cart" style="margin-right: 8px; font-size: 16px;"></i>
                                <span>Add to Cart</span>
                            </button>
                        @endif

                        <!-- 2. Buy Now Button (Full Width, Yellow Gradient) -->
                        @if($isOut)
                            <button type="button" disabled class="btn btn-action-full" style="background: #e2e8f0 !important; color: #94a3b8 !important; cursor: not-allowed !important;">
                                Unavailable
                            </button>
                        @else
                            <button type="button" onclick="buyNowDirect({{ $product['id'] }}, '{{ addslashes($product['name']) }}', {{ $price }}, '{{ $imgSrc }}', {{ $stock }})" class="btn btn-action-full btn-buy-now">
                                <i class="fa fa-bolt" style="margin-right: 8px; font-size: 16px;"></i>
                                <span>Buy Now</span>
                            </button>
                        @endif

                        <!-- 3. Instant WhatsApp Order Button (Full Width, Green) -->
                        <a href="{{ $waUrl }}" target="_blank" class="btn btn-action-full btn-whatsapp-order" style="margin-bottom: 0 !important;">
                            <i class="fa fa-whatsapp" style="margin-right: 8px; font-size: 18px;"></i>
                            <span>Order via WhatsApp</span>
                        </a>

                    </div>

                    <!-- Trust & Authenticity Badges (Positioned cleanly under WhatsApp button) -->
                    @if($isDegh)
                        <div class="text-center mt-3 pt-3 border-top text-muted small" style="margin-top: 15px; padding-top: 12px; border-top: 1px solid #e2e8f0; font-size: 12.5px; color: #16a34a; font-weight: 700;">
                            <span><i class="fa fa-shield text-success" style="color: #16a34a; margin-right: 4px;"></i> 100% Authentic Dewa Sharif Tabarruk Khidmat</span>
                        </div>
                    @else
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top text-muted small" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 12px; border-top: 1px solid #e2e8f0; font-size: 12.5px; color: #64748b;">
                            <span><i class="fa fa-shield text-success" style="color: #16a34a; margin-right: 4px;"></i> 100% Authentic Dewa Tabarruk</span>
                            <span><i class="fa fa-truck text-primary" style="color: #0284c7; margin-right: 4px;"></i> All-India Safe Delivery</span>
                        </div>
                    @endif

                </div>
            </div>

            <!-- RIGHT COLUMN: PRODUCT INFO, DETAILS, SPECIFICATIONS & REVIEWS -->
            <div class="col-md-7 col-sm-12" style="padding-left: 15px; padding-right: 15px; margin-bottom: 30px;">
                <div class="prod-info-box" style="margin-top: 0;">

                    <!-- Ratings & Devotee Feedback -->
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="badge" style="background: #16a34a; color: #ffffff; font-weight: 800; font-size: 13px; padding: 5px 12px; border-radius: 20px;">
                                {{ number_format($product['rating'] ?? 5.0, 1) }} ★
                            </span>
                            @if(!$isDegh)
                                <span style="font-weight: 600; color: #475569; font-size: 13.5px;">
                                    {{ $product['reviews_count'] ?? '150+ Devotee Reviews' }}
                                </span>
                            @endif
                        </div>
                        <span style="color: #16a34a; font-weight: 700; font-size: 13px;">
                            <i class="fa fa-check-circle"></i> 100% Quality Verified
                        </span>
                    </div>

                    <!-- Price Block -->
                    <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; padding: 20px 22px; border-radius: 14px; margin-bottom: 25px;">
                        <div class="d-flex align-items-baseline gap-3">
                            <span class="fw-bold fs-2" style="color: {{ $themeCol }}; font-weight: 900;">
                                ₹{{ number_format($price, 2) }}
                            </span>
                            @if($mrp > $price)
                                <span class="text-muted text-decoration-line-through fs-5">
                                    ₹{{ number_format($mrp, 2) }}
                                </span>
                                <span class="badge bg-danger-subtle text-danger fw-bold px-2.5 py-1 rounded-pill">
                                    Save ₹{{ number_format($mrp - $price, 2) }} ({{ $discountPct }}% OFF)
                                </span>
                            @endif
                        </div>
                        @if($isDegh)
                            <div class="mt-2 text-success fw-bold" style="font-size: 13.5px;">
                                <i class="fa fa-check-circle me-1"></i> Ba-Naam Fateha, Dargah Sharif Tabarruk Taqseem &amp; Parcel Booking Khidmat
                            </div>
                        @else
                            <div class="mt-1 small text-muted">
                                <i class="fa fa-info-circle text-primary"></i> Inclusive of all taxes. Free shipping on orders above ₹499 across India.
                            </div>
                        @endif
                    </div>

                    <!-- Quantity Selector & Size Info (Always visible so customer can pick quantity) -->
                    @if(!$isOut)
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 25px; padding: 14px 18px; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="font-weight: 800; color: #0f172a; font-size: 15px;">Quantity:</span>
                                <div style="display: flex; align-items: center;">
                                    <button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                                    <input type="number" id="detailQtyInput" class="qty-input" value="1" min="1" max="{{ $stock }}" readonly>
                                    <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                                </div>
                            </div>
                            @if(!empty($product['volume_ml']))
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-3 fw-bold" style="font-size: 13px; border-color: #cbd5e1 !important;">
                                    {{ ($isDegh) ? '🍲 Degh Weight / Size: ' : '📏 Pack / Size: ' }}{{ $product['volume_ml'] }}
                                </span>
                            @endif
                        </div>
                    @endif

                    @if($isDegh)
                        <!-- ================= DEGH NIYAZ SPECIFIC CLEAN SECTION ================= -->
                        <!-- 100% Sacred Quality Dewa Sharif Badge -->
                        <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 12px; padding: 16px 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 16px;">
                            <i class="fa fa-certificate text-success" style="font-size: 26px;"></i>
                            <div>
                                <strong style="color: #14532d; font-size: 15px; display: block; margin-bottom: 3px;">100% Sacred Quality &amp; Shuddh Desi Ingredients</strong>
                                <span style="color: #166534; font-size: 13.5px;">Dewa Sharif me taza tayyar aur ba-adab taqseem karwaya jata hai.</span>
                            </div>
                        </div>

                        <!-- Clean Separator Line -->
                        <hr style="border: 0; border-top: 2px solid #e2e8f0; margin: 30px 0 25px 0;">

                        <!-- Description & Khidmat Details (Clean, well-spaced) -->
                        <div style="margin-top: 10px;">
                            <h5 style="color: #03a64a; font-weight: 900; font-size: 20px; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                                <span>📖</span> About {{ $product['name'] }}
                            </h5>
                            <p class="text-secondary" style="font-size: 15px; line-height: 1.8; margin-bottom: 16px;">
                                {{ $product['description'] ?? 'Original handcrafted and carefully curated sacred degh offering from the holy bazaar of Dewa Sharif.' }}
                            </p>
                            <p class="text-secondary" style="font-size: 14.5px; line-height: 1.8; margin-bottom: 0;">
                                Dewa Sharif me taza tayyar aur ba-adab taqseem karwaya jata hai. Niyaz aapke naam se fateha dila kar barkat ke sath ada ki jaati hai.
                            </p>
                        </div>
                    @else
                        <!-- ================= ALL OTHER STORE ITEMS (Attar, Bartan, Tasbeeh, Chadar, etc.) ================= -->
                        <!-- Live Stock & Availability Status -->
                        <div class="mb-4">
                            @if($isOut)
                                <div class="alert alert-danger d-inline-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-0">
                                    <i class="fa fa-times-circle fs-5"></i>
                                    <strong>Currently Out of Stock.</strong> Please contact us on WhatsApp for pre-booking.
                                </div>
                            @elseif($isLow)
                                <div class="alert alert-warning text-dark d-inline-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-0" style="background:#fef3c7; border-color:#fde68a;">
                                    <i class="fa fa-exclamation-triangle fs-5 text-warning"></i>
                                    <strong>Hurry! Only {{ $stock }} left in stock!</strong>
                                </div>
                            @else
                                <div class="alert alert-success d-inline-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-0" style="background:#dcfce7; color:#166534; border-color:#bbf7d0;">
                                    <i class="fa fa-check-circle fs-5"></i>
                                    <strong>In Stock ({{ $stock }} available for immediate dispatch)</strong>
                                </div>
                            @endif
                        </div>

                        <!-- Pincode Check Delivery -->
                        <div class="mb-4 p-3 rounded-3 border" style="background: #fafafa;">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="fa fa-map-marker text-danger me-1"></i> Check Delivery to Your Pincode:
                            </label>
                            <div class="input-group" style="max-width: 380px;">
                                <input type="text" id="pincodeInput" class="form-control font-monospace" placeholder="Enter 6-digit Pincode" maxlength="6" value="225301">
                                <button class="btn btn-dark fw-bold px-3" type="button" onclick="checkPincode()">Check</button>
                            </div>
                            <div id="pincodeResult" class="small text-success fw-bold mt-2">
                                ✓ Express Delivery Available: Expected delivery within 3 to 5 business days via DTDC / Blue Dart.
                            </div>
                        </div>

                        <!-- Key Trust Highlights Grid -->
                        <div class="row g-2 mb-4">
                            <div class="col-sm-6">
                                <div class="highlight-card">
                                    <i class="fa fa-certificate text-success fs-3"></i>
                                    <div>
                                        <strong class="d-block text-dark small">100% Sacred Quality</strong>
                                        <small class="text-muted">Blessed at Dewa Dargah</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="highlight-card">
                                    <i class="fa fa-shield text-primary fs-3"></i>
                                    <div>
                                        <strong class="d-block text-dark small">Secure Packaging</strong>
                                        <small class="text-muted">Bubble wrapped &amp; sealed</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="highlight-card">
                                    <i class="fa fa-truck text-warning fs-3"></i>
                                    <div>
                                        <strong class="d-block text-dark small">Fast All-India Dispatch</strong>
                                        <small class="text-muted">Dispatched within 24 hours</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="highlight-card">
                                    <i class="fa fa-undo text-info fs-3"></i>
                                    <div>
                                        <strong class="d-block text-dark small">Customer Support</strong>
                                        <small class="text-muted">24/7 WhatsApp help</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABBED SPECIFICATIONS & DESCRIPTIONS (AMAZON / FLIPKART STYLE) -->
                        <div class="mt-4">
                            <ul class="nav nav-tabs fw-bold" id="prodDetailTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active text-dark" id="desc-tab" data-bs-toggle="tab" data-bs-target="#descPane" type="button" role="tab">
                                        📜 Description
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link text-dark" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specsPane" type="button" role="tab">
                                        🔍 Specifications
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link text-dark" id="tabarruk-tab" data-bs-toggle="tab" data-bs-target="#tabarrukPane" type="button" role="tab">
                                        🕌 Sacred Authenticity
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content border-start border-end border-bottom p-4 rounded-bottom-3 bg-white" id="prodDetailTabsContent">
                                
                                <!-- Tab 1: Description -->
                                <div class="tab-pane fade show active" id="descPane" role="tabpanel">
                                    <h5 class="fw-bold mb-3" style="color: #03a64a; font-weight: 900; font-size: 20px;">About {{ $product['name'] }}</h5>
                                    <p class="text-secondary" style="font-size: 14.5px; line-height: 1.7;">
                                        {{ $product['description'] ?? 'Original handcrafted and carefully curated sacred item from the holy bazaar of Dewa Sharif. Specially prepared for Zaireen, devotees and homes seeking spiritual fragrance and auspicious blessings of Sarkar Waris-e-Pak.' }}
                                    </p>
                                    <p class="text-secondary" style="font-size: 14.5px; line-height: 1.7;">
                                        Every item is sourced directly from certified heritage artisans and traditional perfumers in Dewa Sharif, Barabanki (Uttar Pradesh). It makes an ideal gift for spiritual occasions, Milad, Urs gatherings, Dargah offerings, or personal peace.
                                    </p>
                                </div>

                                <!-- Tab 2: Specifications Table -->
                                <div class="tab-pane fade" id="specsPane" role="tabpanel">
                                    <h5 class="fw-bold text-dark mb-3">Product Specifications</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered spec-table mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <td>{{ $product['name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td>{{ $category->name ?? ucfirst($catSlug) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Origin / Source</th>
                                                    <td>Dewa Sharif, Barabanki, Uttar Pradesh (India)</td>
                                                </tr>
                                                <tr>
                                                    <th>Net Content / Size</th>
                                                    <td>{{ $product['volume_ml'] ?? ($product['fabric_material'] ?? 'Standard Authentic Pack') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alcohol Content</th>
                                                    <td>0.0% (100% Non-Alcoholic / Halal Standard)</td>
                                                </tr>
                                                <tr>
                                                    <th>Packaging Type</th>
                                                    <td>Sealed Traditional Bottle / Box with Bubble Shield</td>
                                                </tr>
                                                <tr>
                                                    <th>Shelf Life</th>
                                                    <td>36 Months from Date of Dispatch</td>
                                                </tr>
                                                <tr>
                                                    <th>Usage &amp; Occasion</th>
                                                    <td>Dargah Ziyarat, Namaz, Daily Fragrance, Home Decor, Spiritual Gifts</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab 3: Sacred Authenticity -->
                                <div class="tab-pane fade" id="tabarrukPane" role="tabpanel">
                                    <h5 class="fw-bold text-dark mb-3">Hazrat Waris Ali Shah (R.A.) Sacred Assurance</h5>
                                    <p class="text-secondary" style="font-size: 14.5px; line-height: 1.7;">
                                        Dewa Sharif portal was founded with the singular objective of serving devotees worldwide who cannot travel in person. All tabarrukat, chadar, fragrance attar, and handmade pottery are packed with reverence and devotion by our dedicated team right at Dewa Sharif.
                                    </p>
                                    <div class="p-3 rounded-3 bg-light border">
                                        <strong class="text-dark"><i class="fa fa-phone text-success me-1"></i> Special Requests &amp; Bulk Orders:</strong>
                                        <p class="mb-0 text-muted small mt-1">If you require bulk quantities for Urs, Milad, or special chadar peshi with custom embroidery, please WhatsApp our direct coordinator at <a href="https://wa.me/919648777223" target="_blank" class="text-success fw-bold">+91 9648777223</a>.</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>

        <!-- RELATED PRODUCTS SECTION -->
        @if(!empty($relatedProducts) && count($relatedProducts) > 0)
            <div class="mt-5 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">
                            More from {{ $category->name ?? 'This Collection' }}
                        </h3>
                        <p class="text-muted small mb-0">Devotees who viewed this item also explored these sacred offerings</p>
                    </div>
                    <a href="{{ route('shops.category', $catSlug) }}" class="btn btn-outline-success btn-sm fw-bold rounded-pill px-3">
                        View All {{ $category->name ?? 'Items' }} →
                    </a>
                </div>

                <div class="row g-4">
                    @foreach(array_slice($relatedProducts, 0, 4) as $rel)
                        @php
                            $relImg = $rel['image'] ?? ($rel['thumbnail'] ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg');
                            $relImgSrc = '/' . ltrim(preg_replace('#^https?://[^/]+#', '', $relImg), '/');
                            $relPrice = (float)($rel['price'] ?? 299);
                        @endphp
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid #e2e8f0 !important; transition: transform 0.25s ease;" onmouseenter="this.style.transform='translateY(-4px)'" onmouseleave="this.style.transform='translateY(0)'">
                                <a href="{{ route('shops.product', $rel['slug'] ?? $rel['id']) }}" style="height: 180px; overflow: hidden; display: block; background: #f8fafc;">
                                    <img src="{{ $relImgSrc }}" alt="{{ $rel['name'] }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='/home/images/dewasharif/dewapage/attar_bottle.jpg';">
                                </a>
                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="fw-bold mb-1" style="height: 38px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            <a href="{{ route('shops.product', $rel['slug'] ?? $rel['id']) }}" class="text-dark text-decoration-none">
                                                {{ $rel['name'] }}
                                            </a>
                                        </h6>
                                        <div class="text-muted small mb-2">★★★★★ (5.0)</div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-2">
                                        <span class="fw-bold text-success fs-6">₹{{ number_format($relPrice) }}</span>
                                        <a href="{{ route('shops.product', $rel['slug'] ?? $rel['id']) }}" class="btn btn-sm btn-outline-dark fw-bold rounded-pill px-3">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

<!-- FLOATING TOAST NOTIFICATION FOR ADD TO CART -->
<div id="addToCartToast"
    style="position: fixed; bottom: 28px; right: 28px; z-index: 109000; background: #0f172a; color: #ffffff; padding: 13px 22px; border-radius: 50px; border: 2px solid #10b981; box-shadow: 0 12px 35px rgba(0,0,0,0.4); font-weight: 800; font-size: 13.5px; display: none; align-items: center; gap: 10px; transition: opacity 0.35s ease, transform 0.35s ease; transform: translateY(10px); opacity: 0;">
    <span style="font-size: 18px;">✅</span> 
    <span id="toastItemName">Item added to your Cart!</span>
    <a href="{{ route('shops.cart') }}" style="background: #10b981; color: #ffffff; padding: 5px 15px; border-radius: 20px; text-decoration: none; font-size: 12.5px; font-weight: 900; margin-left: 8px; box-shadow: 0 2px 8px rgba(16,185,129,0.35); white-space: nowrap;">View Cart ↗</a>
</div>

<script>
    function changeQty(delta) {
        var input = document.getElementById('detailQtyInput');
        if (!input) return;
        var current = parseInt(input.value) || 1;
        var max = parseInt(input.getAttribute('max')) || 99;
        var newVal = current + delta;
        if (newVal >= 1 && newVal <= max) {
            input.value = newVal;
        }
    }

    function checkPincode() {
        var pin = (document.getElementById('pincodeInput').value || '').trim();
        var res = document.getElementById('pincodeResult');
        if (pin.length === 6 && !isNaN(pin)) {
            res.innerHTML = '<span class="text-success"><i class="fa fa-check-circle"></i> Serviceable! Express courier available to <strong>' + pin + '</strong> (Delivery in 3-5 business days).</span>';
        } else {
            res.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> Please enter a valid 6-digit Indian Postal Pincode.</span>';
        }
    }

    function showToast(message, isError) {
        var toastBox = document.getElementById('addToCartToast');
        var toastName = document.getElementById('toastItemName');
        if (!toastBox) return;

        if (toastName) toastName.textContent = message;
        if (isError) {
            toastBox.style.borderColor = '#ef4444';
        } else {
            toastBox.style.borderColor = '#10b981';
        }

        toastBox.style.display = 'flex';
        setTimeout(function() {
            toastBox.style.opacity = '1';
            toastBox.style.transform = 'translateY(0)';
        }, 10);

        clearTimeout(window.cartToastTimer);
        window.cartToastTimer = setTimeout(function() {
            toastBox.style.opacity = '0';
            toastBox.style.transform = 'translateY(10px)';
            setTimeout(function() {
                toastBox.style.display = 'none';
            }, 350);
        }, 3000);
    }

    function addToCartDetail(id, name, price, image, maxStock, isSilent) {
        var inputEl = document.getElementById('detailQtyInput');
        var qty = inputEl ? (parseInt(inputEl.value) || 1) : 1;
        maxStock = parseInt(maxStock) || 999;

        var cart = JSON.parse(localStorage.getItem('dewa_cart') || '[]');
        var found = cart.find(item => item.id === id);

        if (found) {
            var currentQty = parseInt(found.qty || found.quantity) || 1;
            if (currentQty + qty > maxStock) {
                if (!isSilent) {
                    showToast('Cannot add more than ' + maxStock + ' units in stock.', true);
                }
                return false;
            }
            found.qty = currentQty + qty;
            found.quantity = found.qty;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                image: image,
                qty: qty,
                quantity: qty,
                stock: maxStock,
                maxStock: maxStock
            });
        }
        localStorage.setItem('dewa_cart', JSON.stringify(cart));
        window.dispatchEvent(new Event('dewa-cart-updated'));
        updateCartCount();

        if (!isSilent) {
            showToast('Added ' + qty + ' unit(s) of "' + name + '" to your Cart!');
        }
        return true;
    }

    function buyNowDirect(id, name, price, image, maxStock) {
        var added = addToCartDetail(id, name, price, image, maxStock, true);
        if (added !== false) {
            window.location.href = "{{ route('shops.checkout') }}";
        }
    }

    function updateCartCount() {
        var cart = JSON.parse(localStorage.getItem('dewa_cart') || '[]');
        var totalCount = cart.reduce((sum, item) => sum + (parseInt(item.qty || item.quantity) || 1), 0);
        document.querySelectorAll('.cart-count-badge').forEach(function(badge) {
            badge.textContent = totalCount;
        });
        var badge = document.getElementById('cartBadgeCount');
        if (badge) badge.innerText = totalCount;
    }
</script>
@endsection
