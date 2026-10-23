@extends('home.includes.master')

@section('title', 'Book Hotels & Guest Houses in Dewa Sharif | Near Waris Pak Dargah')
@section('meta_title', 'Best Hotels & AC Rooms in Dewa Sharif | Near Dargah Waris Pak')
@section('meta_description', 'Book verified hotels, guest houses, and deluxe AC/Non-AC family rooms in Dewa Sharif near
    Hazrat Haji Waris Ali Shah Dargah. Best rates for Dewa Mela 2026.')
@section('meta_keywords', 'Dewa Sharif Hotels, Dewa Guest House, Rooms in Dewa Sharif, Stay near Waris Pak Dargah, Dewa
    Mela accommodation, cheap hotel Dewa')
@section('og_title', 'Dewa Sharif Hotels & Guest House Booking | Near Dargah')
@section('og_description', 'Book verified rooms, family suites, and guest houses near Hazrat Waris Ali Shah Dargah with
    24/7 assistance.')


    @php
        if (!function_exists('safeHotelAsset')) {
            function safeHotelAsset($path, $fallback)
            {
                if (empty($path)) {
                    return asset($fallback);
                }
                if (is_string($path) && (str_starts_with($path, 'http://') || str_starts_with($path, 'https://'))) {
                    if (
                        str_contains($path, 'dewasharif.com/') ||
                        str_contains($path, '127.0.0.1') ||
                        str_contains($path, 'localhost')
                    ) {
                        $parsed = parse_url($path, PHP_URL_PATH);
                        if (!empty($parsed)) {
                            return asset(ltrim($parsed, '/'));
                        }
                    }
                    return $path;
                }
                return asset(ltrim($path, '/'));
            }
        }
    @endphp

@section('content')
    <div style="background: #f4f6f8; padding-bottom: 60px; min-height: 90vh;">

        <style>
            .hotel-hero-section {
                background: linear-gradient(180deg, rgba(5, 44, 22, 0.48) 0%, rgba(3, 25, 13, 0.72) 100%), url('{{ asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg') }}') center/cover no-repeat;
                color: #ffffff;
                padding: 55px 16px 70px 16px;
                text-align: center;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
                position: relative;
                box-sizing: border-box;
            }

            .hotel-hero-title {
                font-weight: 900;
                font-size: 36px;
                margin-top: 10px;
                margin-bottom: 12px;
                color: #00e676;
                text-shadow: 0 3px 8px rgba(0, 0, 0, 0.95);
                word-break: break-word;
            }

            .hotel-hero-desc {
                font-size: 16px;
                color: #f1f5f9;
                max-width: 740px;
                margin: 0 auto;
                line-height: 1.6;
                font-weight: 600;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
                padding: 0 8px;
                word-break: break-word;
            }

            .hotel-mela-box {
                background-color: #f8ea6dff;
                padding: 20px 16px;
                text-align: center;
                border-radius: 8px;
                margin: 10px auto 14px auto;
                max-width: 900px;
                width: 100%;
                box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
                box-sizing: border-box;
            }

            .hotel-mela-title {
                font-weight: 900;
                font-size: 30px;
                color: #226902ff;
                margin: 0 0 8px 0;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
                word-break: break-word;
            }

            .hotel-mela-subtitle {
                font-weight: 700;
                font-size: 17px;
                text-align: center;
                color: #046912ff;
                margin: 0;
                text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
                word-break: break-word;
            }

            .hotel-custom-box {
                background: #ffffff;
                border-radius: 14px;
                padding: 25px 28px;
                color: #111827;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                margin-top: 25px;
                margin-bottom: 25px;
                border: 1.5px solid #cbd5e1;
                box-sizing: border-box;
            }

            @media (max-width: 768px) {
                .hotel-hero-section {
                    padding: 38px 12px 55px 12px !important;
                }

                .hotel-hero-title {
                    font-size: 21px !important;
                    line-height: 1.35 !important;
                }

                .hotel-hero-desc {
                    font-size: 13.5px !important;
                    line-height: 1.5 !important;
                    padding: 0 4px !important;
                }

                .hotel-mela-box {
                    padding: 14px 10px !important;
                }

                .hotel-mela-title {
                    font-size: 18px !important;
                    line-height: 1.35 !important;
                }

                .hotel-mela-subtitle {
                    font-size: 13px !important;
                    line-height: 1.45 !important;
                }

                .hotel-custom-box {
                    padding: 16px 12px !important;
                }
            }

            @media (max-width: 360px) {
                .hotel-hero-section {
                    padding: 30px 8px 45px 8px !important;
                }

                .hotel-hero-title {
                    font-size: 18px !important;
                }

                .hotel-hero-desc {
                    font-size: 12.5px !important;
                }

                .hotel-mela-box {
                    padding: 10px 6px !important;
                }

                .hotel-mela-title {
                    font-size: 15.5px !important;
                }

                .hotel-mela-subtitle {
                    font-size: 12px !important;
                }

                .hotel-custom-box {
                    padding: 12px 8px !important;
                }
            }
        </style>

        <!-- TOP HERO BANNER FOR DEWA STAYS WITH REAL LUXURY HOTEL IMAGE BACKGROUND -->
        <div class="hotel-hero-section">
            <div class="container">
                <div style="margin-bottom: 12px;">
                    <span
                        style="background: #00e676; color: #052c16; border: 1.5px solid #ffffff; padding: 6px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; display: inline-block; box-shadow: 0 2px 10px rgba(0,230,118,0.4);">
                        🏨 Dargah Waris-e-Pak Near by Stays
                    </span>
                </div>
                <h1 class="hotel-hero-title">
                    Hotels &amp; Guest Houses in Dewa Sharif
                </h1>
                <p class="hotel-hero-desc">
                    Book AC Rooms, Non-AC Rooms, Hotels, Guest Houses, Halls, Party Halls & Marriage Halls.
                </p>
            </div>
        </div>

        <div class="container" style="margin-top: -35px; position: relative; z-index: 10;">

            <!-- SEARCH ENGINE BOX (PERFECTLY ALIGNED ROW) -->
            <!-- <div
                        style="background: #ffffff; border-radius: 14px; padding: 25px 28px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1.5px solid #e2e8f0;">
                        <h5
                            style="color: #074121; font-weight: 900; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 18px;">
                            🔍 Check Room Availability &amp; Reserve Stays
                        </h5>
                        <form id="hotelSearchForm" class="row g-3 align-items-end">
                            <div class="col-md-3 col-sm-6">
                                <label
                                    style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block; height: 20px; line-height: 20px;">📅
                                    Check-In Date</label>
                                <input type="date" id="search_check_in" class="form-control"
                                    style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-weight: 600;"
                                    required>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label
                                    style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block; height: 20px; line-height: 20px;">📅
                                    Check-Out Date</label>
                                <input type="date" id="search_check_out" class="form-control"
                                    style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-weight: 600;"
                                    required>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label
                                    style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block; height: 20px; line-height: 20px;">🛏️
                                    Room Type</label>
                                <select id="search_category" class="form-control"
                                    style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-weight: 600;">
                                    <option value="all">Rooms (All Categories)</option>
                                    <optgroup label="❄️ AC Rooms">
                                        <option value="single_ac">Single Bedroom AC</option>
                                        <option value="queen_ac">Queen Size AC</option>
                                        <option value="king_ac">King Size AC</option> -->
            <!-- <option value="hall_ac">AC Hall (5+ Persons)</option> -->
            <!-- </optgroup>
                                    <optgroup label="🌿 Non-AC Rooms">
                                        <option value="single_non_ac">Single Non-AC</option>
                                        <option value="queen_non_ac">Queen Size Non-AC</option>
                                        <option value="king_non_ac">King Size Non-AC</option> -->
            <!-- <option value="hall_non_ac">Non-AC Hall (5+ Persons)</option> -->
            <!-- </optgroup>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label
                                    style="font-size: 13px; font-weight: 700; color: transparent; margin-bottom: 6px; display: block; height: 20px; line-height: 20px; user-select: none;">&nbsp;</label>
                                <button type="button" onclick="filterHotels()" class="btn w-100"
                                    style="background: #074121; color: #ffffff; font-weight: 800; height: 46px; border-radius: 8px; font-size: 15px; border: none; box-shadow: 0 4px 12px rgba(7, 65, 33, 0.35); display: flex; align-items: center; justify-content: center; margin: 0;">
                                    Search Available Rooms
                                </button>
                            </div>
                        </form>
                    </div> -->

            <!-- SEPARATE CUSTOM GROUP & FAMILY HALL STAY BOX -->
            <div class="hotel-custom-box">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">

                    <div class="hotel-mela-box">
                        <h2 class="hotel-mela-title">
                            Special Package for Dewa Sharif Urs (Mela) 2026
                        </h2>
                        <p class="hotel-mela-subtitle">
                            Package available 3 Days, 4 Days, 5 Days, 10 Days or More — Prebooking Start Now
                        </p>
                    </div>

                    <div
                        style="margin-top: 30px; padding: 22px 25px; background: linear-gradient(135deg, #fff9db 0%, #fff3cd 100%); border-radius: 12px; border: 2px solid #ffc107; box-shadow: 0 0 25px rgba(255, 193, 7, 0.8); animation: pulseGlow 2s infinite alternate;">
                        <p
                            style="font-size: 16px; color: #533f00; line-height: 1.6; font-weight: 900; margin: 0; text-align: center;">
                            ✨ Hum aise rooms bhi provide karte hain jinki Roof se Dargah aur Dargah ka Ground aur dargah
                            poori dikhayi deti hai and just attached rooms bhi available hain sirf 10-20-50 kadam ki distance aur 50/100/202/300/400 meter distance par bhi 
                            par.
                            <center style="margin: 20px 0;">
                                <a href="https://wa.me/919648777223?text=Hello,%20mujhe%20room%20booking%20ki%20jaankari%20chahiye"
                                    target="_blank"
                                    style="background-color: #25d366; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4); font-size: 16px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.558 6.558 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.012-.304.088-.403.087-.088.197-.232.296-.348.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34l-.38-.008c-.133 0-.348.048-.53.247-.182.198-.694.678-.694 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.078.38-.057 1.17-.478 1.338-.94.17-.46.17-.855.119-.94-.05-.085-.183-.138-.38-.235z" />
                                    </svg>
                                    CONTACT NOW
                                </a>
                            </center>
                        </p>

                    <style>
                        @keyframes pulseGlow {
                            0% {
                                box-shadow: 0 0 15px rgba(255, 193, 7, 0.4);
                                border-color: #ffc107;
                            }

                            100% {
                                box-shadow: 0 0 30px rgba(255, 152, 0, 0.9), inset 0 0 10px rgba(255, 193, 7, 0.5);
                                border-color: #ff9800;
                            }
                        }
                    </style>





                    <h5 style="color: #0f172a; font-weight: 900; margin: 0; font-size: 17.5px;">
                        🏨 Want to Book Rooms, Family Hall, Party Hall, Marriage hall, Lawn, Large Group Stay in Dewa Sharif
                        ?
                    </h5>
                    <span
                        style="font-size: 12px;  background: #fef3c7; color: #b45309; margin-top: 8px; padding: 5px 14px; border-radius: 160px; font-weight: 800; border: 1px solid #fde68a;">
                        We Provide AC/Non AC Services & Special Group Rates Available for Urs, Mela &amp; Big Families
                    </span>
                </div>

                <form class="row g-3 align-items-end" onsubmit="event.preventDefault(); submitCustomWhatsAppHotelStay();">
                    <div class="col-md-3  col-sm-6">
                        <label
                            style="font-size: 12.5px; margin-top: 8px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🏨
                            Stay Requirement</label>
                        <input type="text" id="custom_hotel_req" class="form-control"
                            placeholder="E.g., Full AC/Non Ac  Hall / Rooms / Party"
                            style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label
                            style="font-size: 12.5px; margin-top: 8px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">👥
                            Total Guests / Persons</label>
                        <input type="text" id="custom_hotel_guests" class="form-control"
                            placeholder="E.g., 2-4-6-8... Persons, Group / Families"
                            style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label
                            style="font-size: 12.5px; margin-top: 8px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📅
                            Expected Dates </label>
                        <input type="text" id="custom_hotel_dates" class="form-control"
                            placeholder="E.g., 20 Oct to 28 Oct (8 Nights)"
                            style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label
                            style="font-size: 12.5px; margin-top: 8px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📅
                            Days</label>
                        <input type="text" id="custom_hotel_dates" class="form-control"
                            placeholder="E.g., 1 - 2 - 3 - 4 - 5 - 6 - 7... Days"
                            style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label
                            style="font-size: 12.5px; margin-top: 8px; font-weight: 700; color: transparent; margin-bottom: 6px; display: block; user-select: none;">Action</label>
                        <button type="button" onclick="submitCustomWhatsAppHotelStay()" class="btn w-100 font-extrabold"
                            style="background: #25D366; color: #ffffff; font-weight: 900; height: 46px; border-radius: 8px; font-size: 13.5px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35); display: flex; align-items: center; justify-content: center; gap: 6px; white-space: nowrap; padding: 0 8px; margin: 0;">
                            <i class="fa fa-whatsapp" style="font-size: 18px;"></i>
                            Connect With WhatsApp
                        </button>
                    </div>
                </form>
            </div>

            <!-- CATEGORY FILTER BUTTONS (DYNAMIC AC & NON-AC ROOM TYPES) -->
            <div style="display: flex; gap: 8px; margin-top: 28px; margin-bottom: 24px; flex-wrap: wrap; width: 100%;">
                <button onclick="filterCategory('all', this)" class="btn filter-btn active"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #074121; color: #fff; box-shadow: 0 2px 8px rgba(7,65,33,0.25);">
                    All Hotels
                </button>
                <button onclick="filterCategory('single_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    ❄️ Single AC
                </button>
                <button onclick="filterCategory('queen_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    👑 Queen Size AC
                </button>
                <button onclick="filterCategory('king_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    🏰 King Size AC
                </button>
                <button onclick="filterCategory('hall_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    🏢 AC Hall (5+)
                </button>
                <button onclick="filterCategory('single_non_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    🌿 Single Non-AC
                </button>
                <button onclick="filterCategory('queen_non_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    🌿 Queen Non-AC
                </button>
                <button onclick="filterCategory('king_non_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    🌿 King Non-AC
                </button>
                <button onclick="filterCategory('hall_non_ac', this)" class="btn filter-btn"
                    style="border-radius: 25px; font-weight: 800; font-size: 13px; padding: 8px 16px; border: 1.5px solid #074121; background: #fff; color: #074121;">
                    🏠 Non-AC Hall
                </button>
            </div>

            <!-- DYNAMIC HOTEL LISTINGS GRID -->
            <style>
                .hotel-card-item {
                    display: flex !important;
                    align-items: stretch !important;
                    margin-bottom: 30px;
                    box-sizing: border-box !important;
                    padding-left: 10px !important;
                    padding-right: 10px !important;
                }

                @media (max-width: 768px) {
                    .hotel-card-item {
                        padding-left: 6px !important;
                        padding-right: 6px !important;
                        margin-bottom: 20px !important;
                    }
                }

                @media (max-width: 360px) {
                    .hotel-card-item {
                        padding-left: 4px !important;
                        padding-right: 4px !important;
                        margin-bottom: 16px !important;
                    }
                }

                .hotel-card-item[style*="display: none"] {
                    display: none !important;
                }

                .hotel-card-box {
                    background: #ffffff;
                    border-radius: 14px;
                    overflow: hidden;
                    border: 1.5px solid #cbd5e1;
                    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
                    width: 100%;
                    height: 100% !important;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                }

                .hotel-card-box:hover {
                    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
                    transform: translateY(-2px);
                }

                .hotel-card-title {
                    font-size: 18.5px;
                    font-weight: 900;
                    margin-bottom: 6px;
                    height: 48px;
                    line-height: 1.3;
                    overflow: hidden;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                }

                .hotel-card-desc {
                    font-size: 13px;
                    color: #64748b;
                    margin-bottom: 12px;
                    height: 38px;
                    overflow: hidden;
                    line-height: 1.45;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                }

                .hotel-card-badges {
                    display: flex;
                    gap: 6px;
                    flex-wrap: wrap;
                    margin-bottom: 14px;
                    height: 58px;
                    overflow: hidden;
                    align-content: flex-start;
                }
            </style>
            <div class="row" id="hotelsGrid" style="display: flex; flex-wrap: wrap;">

                <!-- @foreach ($hotels as $hotel)
    @php
        $hAc =
            $hotel['ac_type'] ??
            (str_contains(strtolower($hotel['room_type'] ?? ''), 'ac') &&
            !str_contains(strtolower($hotel['room_type'] ?? ''), 'non')
                ? 'AC'
                : 'Non-AC');
        $hBed = $hotel['bed_type'] ?? 'Double Bed';
        $hBath = $hotel['bath_type'] ?? 'Attached Western Bath';
        $hAdults = $hotel['max_adults'] ?? 2;
        $hAvail = (int) ($hotel['available_rooms'] ?? 0);

        $rawCat = strtolower($hotel['category'] ?? '');
        $rawRoomType = strtolower($hotel['room_type'] ?? '');
        $isAc = (strtolower($hAc) === 'ac' || str_contains($rawRoomType, 'ac')) && !str_contains($rawRoomType, 'non');

        $catTags = [];
        if ($isAc) {
            $catTags[] = 'ac';
            if ($rawCat === 'single_ac' || str_contains($rawRoomType, 'single')) {
                $catTags[] = 'single_ac';
            }
            if ($rawCat === 'queen_ac' || str_contains($rawRoomType, 'queen')) {
                $catTags[] = 'queen_ac';
            }
            if ($rawCat === 'king_ac' || str_contains($rawRoomType, 'king')) {
                $catTags[] = 'king_ac';
            }
            if (
                $rawCat === 'hall_ac' ||
                str_contains($rawRoomType, 'hall') ||
                str_contains($rawRoomType, 'family') ||
                str_contains($rawRoomType, 'group')
            ) {
                $catTags[] = 'hall_ac';
            }
            if (count($catTags) === 1) {
                $catTags[] = 'single_ac';
                $catTags[] = 'queen_ac';
                $catTags[] = 'king_ac';
                $catTags[] = 'hall_ac';
            }
        } else {
            $catTags[] = 'non_ac';
            if ($rawCat === 'single_non_ac' || str_contains($rawRoomType, 'single')) {
                $catTags[] = 'single_non_ac';
            }
            if ($rawCat === 'queen_non_ac' || str_contains($rawRoomType, 'queen')) {
                $catTags[] = 'queen_non_ac';
            }
            if ($rawCat === 'king_non_ac' || str_contains($rawRoomType, 'king')) {
                $catTags[] = 'king_non_ac';
            }
            if (
                $rawCat === 'hall_non_ac' ||
                str_contains($rawRoomType, 'hall') ||
                str_contains($rawRoomType, 'family') ||
                str_contains($rawRoomType, 'group')
            ) {
                $catTags[] = 'hall_non_ac';
            }
            if (count($catTags) === 1) {
                $catTags[] = 'single_non_ac';
                $catTags[] = 'queen_non_ac';
                $catTags[] = 'king_non_ac';
                $catTags[] = 'hall_non_ac';
            }
        }
        $dataCategoryStr = implode(' ', $catTags);
        $rawHPrice = (float) ($hotel['price_per_night'] ?? ($hotel['price'] ?? 0));
        if ($rawHPrice <= 0) {
            $rawHMrp = (float) ($hotel['mrp'] ?? 0);
            $rawHPrice = $rawHMrp > 0 ? round($rawHMrp * 0.85) : 1499;
        }
        $hCardImg = safeHotelAsset(
            $hotel['image'] ?? ($hotel['image_main'] ?? null),
            'home/images/dewasharif/dewapage/hero_hotel_bg.jpg',
        );
    @endphp
                            <div class="col-md-4 col-sm-6 col-xs-12 hotel-card-item mb-4"
                                data-category="{{ $dataCategoryStr }} near_dargah family mela">
                                <div class="hotel-card-box">
                                    <div>
                                        <a href="{{ route('hotel.detail', ['id' => $hotel['id']]) }}"
                                            style="display: block; position: relative; height: 210px; overflow: hidden; background: #e2e8f0;">
                                            <img src="{{ $hCardImg }}"
                                                onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg') }}'"
                                                alt="{{ $hotel['name'] }}"
                                                style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                            <span
                                                style="position: absolute; top: 12px; left: 12px; background: #16a34a; color: #fff; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 20px; text-transform: uppercase; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                                                ✔ Verified Stay
                                            </span>
                                            <span
                                                style="position: absolute; bottom: 12px; right: 12px; background: rgba(0,0,0,0.85); color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 6px; backdrop-filter: blur(4px); max-width: 85%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                📍 {{ $hotel['location'] ?? ($hotel['distance'] ?? 'Near Dewa Sharif Dargah') }}
                                            </span>
                                        </a>

                                        <div style="padding: 20px 20px 10px 20px;">
                                            <h4 class="hotel-card-title">
                                                <a href="{{ route('hotel.detail', ['id' => $hotel['id']]) }}"
                                                    style="color: #0f172a; text-decoration: none;">
                                                    {{ $hotel['name'] }} ↗
                                                </a>
                                            </h4>
                                            <p class="hotel-card-desc">
                                                {{ $hotel['room_type'] ?? 'Deluxe Room' }} — {{ $hBed }} with {{ $hBath }}.
                                            </p>

                                            <div class="hotel-card-badges">
                                                <span
                                                    style="font-size: 11px; background: {{ strtolower($hAc) == 'ac' ? '#e0f2fe' : '#fef3c7' }}; color: {{ strtolower($hAc) == 'ac' ? '#0369a1' : '#b45309' }}; padding: 4px 8px; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center;">
                                                    {{ strtolower($hAc) == 'ac' ? '❄️ AC Room' : '🌿 Non-AC Room' }}
                                                </span>
                                                <span
                                                    style="font-size: 11px; background: #f0fdf4; color: #15803d; padding: 4px 8px; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center;">
                                                    🛏️ {{ $hBed }}
                                                </span>
                                                <span
                                                    style="font-size: 11px; background: #f1f5f9; color: #334155; padding: 4px 8px; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center;">
                                                    👥 Max {{ $hAdults }} Persons
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="padding: 0 20px 20px 20px;">
                                        <div
                                            style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                                            <div>
                                                <span
                                                    style="font-size: 24px; font-weight: 900; color: #074121;">₹{{ number_format($rawHPrice) }}</span>
                                                <span style="font-size: 12.5px; color: #64748b; font-weight: 600;"> / night</span>
                                            </div>
                                            @if ($hAvail > 0)
    <span
                                                    style="font-size: 11px; color: #16a34a; font-weight: 800; background: #dcfce7; padding: 3px 8px; border-radius: 6px;">{{ $hAvail }}
                                                    Rooms Left</span>
@else
    <span
                                                    style="font-size: 11px; color: #dc2626; font-weight: 800; background: #fee2e2; padding: 3px 8px; border-radius: 6px;">🚨
                                                    HOUSEFULL</span>
    @endif
                                        </div>

                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('hotel.detail', ['id' => $hotel['id']]) }}"
                                                class="btn w-100 font-extrabold"
                                                style="background: {{ $hAvail > 0 ? '#074121' : '#475569' }}; color: #ffffff; font-weight: 900; font-size: 14.5px; height: 46px; border-radius: 8px; padding: 0 20px; border: none; box-shadow: 0 3px 10px rgba(7,65,33,0.3); display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                                {{ $hAvail > 0 ? 'View Rooms & Reserve Stay' : 'View Hotel Details & Availability' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
    @endforeach -->

                <!-- EMPTY STATE IF NO HOTELS MATCH FILTER -->
                <!-- <div id="noHotelsNotice" class="col-12 py-5 text-center" style="display: none;">
                            <div
                                style="background: #ffffff; border-radius: 16px; padding: 40px 20px; border: 2px dashed #cbd5e1; max-width: 500px; margin: 0 auto;">
                                <div style="font-size: 48px; margin-bottom: 12px;">🏨</div>
                                <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 8px;">No Hotels Found</h4>
                                <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Is category me abhi koi hotel
                                    listed nahi hai ya sabhi book hain.</p>
                                <button onclick="filterCategory('all', $('.filter-btn').first()[0])" class="btn font-extrabold"
                                    style="background: #074121; color: #fff; border-radius: 8px; padding: 10px 24px;">
                                    🔄 View All Hotels & Guest Houses
                                </button>
                            </div>
                        </div> -->

            </div>

            <!-- HOTEL REVIEWS & GUEST EXPERIENCES SECTION -->
            <style>
                .hotel-reviews-container {
                    margin-top: 50px;
                    padding-top: 30px;
                    border-top: 2px solid #e2e8f0;
                    padding-left: 10px;
                    padding-right: 10px;
                    box-sizing: border-box;
                }

                .hotel-reviews-header-box {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 15px;
                    margin-bottom: 24px;
                    width: 100%;
                    box-sizing: border-box;
                }

                .hotel-reviews-title-box {
                    flex: 1 1 auto;
                }

                .hotel-reviews-title {
                    font-weight: 900;
                    color: #074121;
                    margin: 0;
                    font-size: 22px;
                    word-break: break-word;
                }

                .hotel-reviews-desc {
                    margin: 4px 0 0 0;
                    color: #64748b;
                    font-size: 13.5px;
                    font-weight: 600;
                    word-break: break-word;
                }

                .hotel-reviews-actions {
                    display: flex;
                    gap: 10px;
                    flex-wrap: wrap;
                    align-items: center;
                    flex-shrink: 0;
                }

                .hotel-reviews-btn {
                    font-weight: 800;
                    font-size: 13px;
                    padding: 8px 16px;
                    border-radius: 25px;
                    white-space: nowrap;
                    text-align: center;
                    cursor: pointer;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                }

                @media (max-width: 768px) {
                    .hotel-reviews-container {
                        padding-left: 4px;
                        padding-right: 4px;
                        margin-top: 35px;
                        padding-top: 20px;
                    }

                    .hotel-reviews-header-box {
                        flex-direction: column !important;
                        align-items: flex-start !important;
                        gap: 12px !important;
                        margin-bottom: 18px !important;
                    }

                    .hotel-reviews-title-box {
                        width: 100% !important;
                    }

                    .hotel-reviews-title {
                        font-size: 18px !important;
                        line-height: 1.3 !important;
                    }

                    .hotel-reviews-desc {
                        font-size: 12.5px !important;
                        line-height: 1.4 !important;
                    }

                    .hotel-reviews-actions {
                        width: 100% !important;
                        display: flex !important;
                        gap: 8px !important;
                    }

                    .hotel-reviews-btn {
                        flex: 1 1 0% !important;
                        width: 48% !important;
                        font-size: 11.5px !important;
                        padding: 8px 8px !important;
                        box-sizing: border-box !important;
                    }
                }

                @media (max-width: 340px) {
                    .hotel-reviews-actions {
                        flex-direction: column !important;
                    }

                    .hotel-reviews-btn {
                        width: 100% !important;
                    }
                }
            </style>

            <div class="hotel-reviews-container">
                <div class="hotel-reviews-header-box">
                    <div class="hotel-reviews-title-box">
                        <h4 class="hotel-reviews-title">
                            ⭐ Guest Reviews &amp; Stay Experiences
                        </h4>
                        <p class="hotel-reviews-desc">
                            Verified reviews from pilgrims staying near Dewa Sharif Dargah
                        </p>
                    </div>
                    <div class="hotel-reviews-actions">
                        <button type="button" class="btn btn-success hotel-reviews-btn"
                            onclick="$('#writeHotelReviewModal').modal('show')" data-toggle="modal"
                            data-target="#writeHotelReviewModal" data-bs-toggle="modal"
                            data-bs-target="#writeHotelReviewModal"
                            style="background: #16a34a; border: none; color: #ffffff;">
                            ✍️ Write Hotel Review
                        </button>
                        <button type="button" class="btn btn-outline-success hotel-reviews-btn"
                            onclick="$('#sendHotelFeedbackModal').modal('show')" data-toggle="modal"
                            data-target="#sendHotelFeedbackModal" data-bs-toggle="modal"
                            data-bs-target="#sendHotelFeedbackModal"
                            style="border: 1.5px solid #16a34a; color: #16a34a; background: #ffffff;">
                            💬 Send Feedback
                        </button>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($hotelReviews ?? [] as $rev)
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <div
                                style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-1">
                                            <span style="color: #f59e0b; font-size: 15px; white-space: nowrap !important; display: inline-flex; align-items: center; letter-spacing: 2px;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $rev->rating ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                            <strong
                                                style="font-size: 13px; color: #0f172a; margin-left: 4px; white-space: nowrap;">{{ $rev->rating }}.0</strong>
                                        </div>
                                        <small
                                            style="color: #94a3b8; font-size: 11.5px;">{{ date('d M Y', strtotime($rev->created_at ?? now())) }}</small>
                                    </div>
                                    @if (!empty($rev->title))
                                        <h6
                                            style="font-weight: 800; color: #0f172a; margin-bottom: 6px; font-size: 14.5px;">
                                            {{ $rev->title }}</h6>
                                    @endif
                                    <p style="font-size: 13px; color: #475569; line-height: 1.5; margin-bottom: 10px; text-align: left !important; word-break: break-word;">
                                        "{{ $rev->comment }}"
                                    </p>
                                </div>
                                <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 800; font-size: 12.5px; color: #0f172a;">👤
                                        {{ $rev->customer_name }}</span>
                                    <span
                                        style="font-size: 11px; color: #0284c7; font-weight: 700; background: #e0f2fe; padding: 2px 8px; border-radius: 4px;">Verified
                                        Guest</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 text-muted">
                            <p>Be the first pilgrim to review Dewa Sharif hotel stays!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- WRITE HOTEL REVIEW MODAL -->
    <div class="modal fade" id="writeHotelReviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <form onsubmit="submitHotelReview(event)">
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #10b981 100%); color: #fff;">
                        <h5 class="modal-title font-weight-bold"><i class="fa fa-star text-warning mr-2"></i>Write a Hotel
                            Review</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="service_type" value="hotel">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Select Hotel / Guest House*</label>
                            <select name="item_name" class="form-control" required>
                                @foreach ($hotels as $h)
                                    <option value="{{ is_array($h) ? $h['name'] ?? 'Hotel' : $h->name }}">
                                        {{ is_array($h) ? $h['name'] ?? 'Hotel' : $h->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Rating*</label>
                            <select name="rating" class="form-control font-weight-bold">
                                <option value="5" selected>★★★★★ 5 Stars (Excellent Experience)</option>
                                <option value="4">★★★★☆ 4 Stars (Very Good)</option>
                                <option value="3">★★★☆☆ 3 Stars (Average)</option>
                                <option value="2">★★☆☆☆ 2 Stars (Needs Improvement)</option>
                                <option value="1">★☆☆☆☆ 1 Star (Not Satisfied)</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Name*</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Mohd Imran"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. 9876543210">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Headline / Short Title</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="e.g. Very clean room near Dargah">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Stay Experience / Comments*</label>
                            <textarea name="comment" class="form-control" rows="4"
                                placeholder="How was your room, AC, cleanliness and service?" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary font-weight-bold"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success font-weight-bold px-4"
                            style="background: #16a34a; border-color: #16a34a;">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SEND HOTEL FEEDBACK MODAL -->
    <div class="modal fade" id="sendHotelFeedbackModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <form onsubmit="submitHotelFeedback(event)">
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 50%, #2563eb 100%); color: #fff;">
                        <h5 class="modal-title font-weight-bold"><i class="fa fa-commenting text-warning mr-2"></i>Send
                            Hotel Feedback</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="service_type" value="hotel">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Name*</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Zaid Khan"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Phone Number*</label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. 9876543210"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Subject*</label>
                            <input type="text" name="subject" class="form-control"
                                placeholder="e.g. Room suggestion / Issue" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Your Feedback / Suggestion*</label>
                            <textarea name="message" class="form-control" rows="4"
                                placeholder="Share your suggestions with administration..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary font-weight-bold"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary font-weight-bold px-4"
                            style="background: #2563eb; border-color: #2563eb;">
                            Send Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function checkEmptyState() {
            var visibleCount = $('.hotel-card-item:visible').length;
            if (visibleCount === 0) {
                $('#noHotelsNotice').fadeIn(200);
            } else {
                $('#noHotelsNotice').hide();
            }
        }

        function filterCategory(cat, btn) {
            $('.filter-btn').removeClass('active').css({
                'background': '#fff',
                'color': '#074121'
            });
            if (btn) {
                $(btn).addClass('active').css({
                    'background': '#074121',
                    'color': '#fff'
                });
            }

            if (cat === 'all') {
                $('.hotel-card-item').fadeIn(200, function() {
                    $(this).css('display', 'flex');
                    checkEmptyState();
                });
            } else {
                $('.hotel-card-item').hide();
                $('.hotel-card-item[data-category*="' + cat + '"]').fadeIn(200, function() {
                    $(this).css('display', 'flex');
                    checkEmptyState();
                });
            }
            setTimeout(function() {
                $('.hotel-card-item:visible').css('display', 'flex');
                checkEmptyState();
            }, 250);
        }

        function filterHotels() {
            var cat = $('#search_category').val();
            var matchingBtn = $('.filter-btn').filter(function() {
                var onclickAttr = $(this).attr('onclick') || '';
                return onclickAttr.indexOf("'" + cat + "'") !== -1;
            })[0];
            filterCategory(cat, matchingBtn);
            var grid = document.getElementById('hotelsGrid');
            if (grid) {
                grid.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function submitHotelReview(e) {
            e.preventDefault();
            var form = e.target;
            var formData = new FormData(form);
            var dataObj = {};
            formData.forEach(function(val, key) {
                dataObj[key] = val;
            });

            fetch("{{ route('reviews.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(dataObj)
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(res) {
                    if (res.success) {
                        alert('🎉 ' + res.message);
                        $('#writeHotelReviewModal').modal('hide');
                        form.reset();
                        location.reload();
                    } else {
                        alert('❌ ' + (res.message || 'Error submitting review'));
                    }
                })
                .catch(function() {
                    alert('Server error while submitting review.');
                });
        }

        function submitHotelFeedback(e) {
            e.preventDefault();
            var form = e.target;
            var formData = new FormData(form);
            var dataObj = {};
            formData.forEach(function(val, key) {
                dataObj[key] = val;
            });

            fetch("{{ route('feedback.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(dataObj)
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(res) {
                    if (res.success) {
                        alert('🎉 ' + res.message);
                        $('#sendHotelFeedbackModal').modal('hide');
                        form.reset();
                    } else {
                        alert('❌ ' + (res.message || 'Error submitting feedback'));
                    }
                })
                .catch(function() {
                    alert('Server error while sending feedback.');
                });
        }

        function submitCustomWhatsAppHotelStay() {
            var req = ($('#custom_hotel_req').val() || '').trim();
            var guests = ($('#custom_hotel_guests').val() || '').trim();
            var dates = ($('#custom_hotel_dates').val() || '').trim();

            if (!req && !guests) {
                alert('Kripya Stay Requirement (jaise Hall ya Rooms) aur Guests count type karein!');
                return;
            }

            var safeReq = req || 'Custom Family Hall / Group Stay';
            var safeGuests = guests || '6-10 Persons';
            var safeDates = dates || 'Upcoming Ziyarat Stay';

            var text = "Assalamu Alaikum Dewa Sharif Hotel Desk!\n\n" +
                "I want to book a Custom Family Hall / Group Stay near Dewa Sharif Dargah:\n" +
                "🏨 Stay Requirement: " + safeReq + "\n" +
                "👥 Total Guests / Persons: " + safeGuests + "\n" +
                "📅 Expected Dates / Duration: " + safeDates + "\n\n" +
                "Please share available guest houses, halls & best custom quote. Thank you!";

            var waUrl = "https://wa.me/919648777223?text=" + encodeURIComponent(text);
            window.open(waUrl, '_blank');

            $.post("{{ route('hotels.custom-enquiry') }}", {
                _token: "{{ csrf_token() }}",
                requirement: safeReq,
                guests: safeGuests,
                dates: safeDates
            });
        }
    </script>

@endsection
