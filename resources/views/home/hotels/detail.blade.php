@extends('home.includes.master')

@section('title', ($hotel['name'] ?? 'Hotel Details') . ' - Dewa Sharif Hotel Booking')
@section('meta_title', ($hotel['name'] ?? 'Hotel') . ' | Verified Stay Near Waris Pak Dargah')
@section('meta_description', 'Book ' . ($hotel['name'] ?? 'Hotel') . ' in Dewa Sharif located ' . ($hotel['distance'] ?? 'near Dargah') . '. Rooms starting at ₹' . ($hotel['price_per_night'] ?? ($hotel['price'] ?? '999')) . ' per night. Family friendly with 24/7 service.')
@section('og_title', ($hotel['name'] ?? 'Hotel') . ' - Dewa Sharif')
@section('og_description', 'Book ' . ($hotel['name'] ?? 'Hotel') . ' in Dewa Sharif located ' . ($hotel['distance'] ?? 'near Dargah') . '. Best prices and verified bookings.')

@section('head-area')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LodgingBusiness",
  "name": "{{ $hotel['name'] ?? 'Dewa Sharif Hotel' }}",
  "description": "{{ $hotel['description'] ?? 'Comfortable and affordable stay in Dewa Sharif near Dargah Hazrat Haji Waris Ali Shah.' }}",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Dewa Sharif",
    "addressLocality": "Barabanki",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "225301",
    "addressCountry": "IN"
  },
  "priceRange": "₹{{ $hotel['price_per_night'] ?? ($hotel['price'] ?? '999') }}",
  "telephone": "+91-shahzade.alam707@gmail.com"
}
</script>
@endsection


@php
    if (!function_exists('safeHotelAsset')) {
        function safeHotelAsset($path, $fallback) {
            if (empty($path)) {
                return asset($fallback);
            }
            if (is_string($path) && (str_starts_with($path, 'http://') || str_starts_with($path, 'https://'))) {
                if (str_contains($path, 'dewasharif.com/') || str_contains($path, '127.0.0.1') || str_contains($path, 'localhost')) {
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

    $rawPrice = (float)($hotel['price_per_night'] ?? ($hotel['price'] ?? 0));
    if ($rawPrice <= 0) {
        $rawMrp = (float)($hotel['mrp'] ?? 0);
        $rawPrice = $rawMrp > 0 ? round($rawMrp * 0.85) : 1499;
    }
    $primaryPrice = $rawPrice;

    $primaryRoom = $hotel['room_type'] ?? ($hotel['category_name'] ?? 'Queen Size AC');
    $primaryBed = $hotel['bed_type'] ?? 'Double Bed';
    $primaryBath = $hotel['bath_type'] ?? 'Attached Western Bath';
    $primaryAc = $hotel['ac_type'] ?? (str_contains(strtolower($primaryRoom), 'ac') && !str_contains(strtolower($primaryRoom), 'non') ? 'AC' : 'Non-AC');
    $primaryAdults = (int)($hotel['max_adults'] ?? 2);

    // Derived dynamic rates for other options based on this property's base rate:
    $familyPrice = $primaryPrice + 350;
    $hallPrice = $primaryPrice + 700;

    $nonAcPrice = max(699, round($primaryPrice * 0.65));
    $nonAcMid = $nonAcPrice + 250;
    $nonAcLarge = $nonAcPrice + 500;

    $acHallStandard = max(1999, round($primaryPrice * 1.65));
    $acHallMid = $acHallStandard + 500;
    $acHallLarge = $acHallStandard + 1000;

    $nonAcHallStandard = max(1499, round($nonAcPrice * 1.80));
    $nonAcHallMid = $nonAcHallStandard + 400;
    $nonAcHallLarge = $nonAcHallStandard + 800;

    $imgMain = safeHotelAsset($hotel['image_main'] ?? ($hotel['image'] ?? null), 'home/images/dewasharif/dewapage/hero_hotel_bg.jpg');
    $imgReception = safeHotelAsset($hotel['image_reception'] ?? null, 'home/images/dewasharif/dewapage/hero_hotel_bg.jpg');
    $imgRoom = safeHotelAsset($hotel['image_room'] ?? null, 'home/images/dewasharif/dewapage/deluxe_room.jpg');
    $imgBathroom = safeHotelAsset($hotel['image_bathroom'] ?? null, 'home/images/dewasharif/dewapage/standard_room.jpg');
    $imgExtra = safeHotelAsset($hotel['image_extra'] ?? null, 'home/images/dewasharif/dewapage/guesthouse.jpg');
@endphp

@section('content')
<div style="background: #f8fafc; padding: 35px 0 70px 0; min-height: 85vh;">
    <div class="container">

        <!-- BREADCRUMB -->
        <nav aria-label="breadcrumb" style="margin-bottom: 20px;">
            <ol class="breadcrumb" style="background: transparent; padding: 0; font-size: 13.5px; font-weight: 600;">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" style="color: #074121; text-decoration: none;">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hotels') }}" style="color: #074121; text-decoration: none;">Hotels</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #64748b;">{{ $hotel['name'] ?? 'Guest House Details' }}</li>
            </ol>
        </nav>

        <!-- HOTEL HEADER BANNER -->
        <div style="background: #ffffff; padding: 25px; border-radius: 14px; border: 1px solid #cbd5e1; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                <div>
                    <span style="background: #dcfce7; color: #15803d; font-size: 11.5px; font-weight: 800; padding: 5px 12px; border-radius: 20px; text-transform: uppercase;">
                        ✔ Dargah Verified Stay
                    </span>
                    <h2 style="font-weight: 900; color: #0f172a; margin-top: 10px; margin-bottom: 6px; font-size: 26px;">
                        {{ $hotel['name'] ?? 'Al-Waris Deluxe Guest House & Family Lodge' }}
                    </h2>
                    <p style="color: #64748b; font-size: 14px; margin: 0; font-weight: 500;">
                        📍 <strong>Location:</strong> {{ $hotel['location'] ?? ($hotel['distance'] ?? ($hotel['address'] ?? 'Mazar Gate Road, Town Dewa Sharif, Barabanki (120 meters from Dargah Gate)')) }}
                    </p>
                </div>
                <div style="text-align: right;">
                    <span style="background: #074121; color: #ffffff; font-size: 13px; font-weight: 800; padding: 8px 16px; border-radius: 8px; display: inline-block;">
                        ⭐ {{ $hotel['available_rooms'] ?? 10 }} Available Rooms
                    </span>
                </div>
            </div>
        </div>

        <!-- 5-PHOTO VERIFIED GALLERY SECTION -->
        <div style="background: #ffffff; padding: 22px; border-radius: 14px; border: 1px solid #cbd5e1; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 30px;">
            <h4 style="font-weight: 800; color: #074121; font-size: 18px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <span>📸 Verified 5-Photo Property Gallery (Exterior, Reception, Room &amp; Washroom)</span>
                <span style="background: #dcfce7; color: #15803d; font-size: 12px; padding: 4px 10px; border-radius: 6px; font-weight: 800;">100% Real Pictures</span>
            </h4>
            <div class="row g-3">
                <!-- 1. Main Exterior View -->
                <div class="col-md-4 col-12">
                    <div style="position: relative; height: 210px; border-radius: 10px; overflow: hidden; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #e2e8f0;">
                        <img src="{{ $imgMain }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="Main Exterior View">
                        <span style="position: absolute; bottom: 10px; left: 10px; background: rgba(5, 44, 22, 0.92); color: #ffffff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; backdrop-filter: blur(4px);">
                            🏢 1. Main Exterior / Outside View
                        </span>
                    </div>
                </div>

                <!-- 2. Reception / Lobby View -->
                <div class="col-md-4 col-6">
                    <div style="position: relative; height: 210px; border-radius: 10px; overflow: hidden; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #e2e8f0;">
                        <img src="{{ $imgReception }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="Reception View">
                        <span style="position: absolute; bottom: 10px; left: 10px; background: rgba(180, 83, 9, 0.92); color: #ffffff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; backdrop-filter: blur(4px);">
                            🛎️ 2. Reception &amp; Lobby
                        </span>
                    </div>
                </div>

                <!-- 3. Room Interior View -->
                <div class="col-md-4 col-6">
                    <div style="position: relative; height: 210px; border-radius: 10px; overflow: hidden; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #e2e8f0;">
                        <img src="{{ $imgRoom }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/deluxe_room.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="Room Interior">
                        <span style="position: absolute; bottom: 10px; left: 10px; background: rgba(3, 105, 161, 0.92); color: #ffffff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; backdrop-filter: blur(4px);">
                            🛏️ 3. Room Interior &amp; Bed
                        </span>
                    </div>
                </div>

                <!-- 4. Bathroom & Toilet View -->
                <div class="col-md-6 col-6">
                    <div style="position: relative; height: 180px; border-radius: 10px; overflow: hidden; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #e2e8f0;">
                        <img src="{{ $imgBathroom }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/standard_room.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="Bathroom View">
                        <span style="position: absolute; bottom: 10px; left: 10px; background: rgba(13, 148, 136, 0.92); color: #ffffff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; backdrop-filter: blur(4px);">
                            🚿 4. Bathroom &amp; Toilet View
                        </span>
                    </div>
                </div>

                <!-- 5. Balcony / Extra Amenities View -->
                <div class="col-md-6 col-6">
                    <div style="position: relative; height: 180px; border-radius: 10px; overflow: hidden; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #e2e8f0;">
                        <img src="{{ $imgExtra }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/guesthouse.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="Balcony View">
                        <span style="position: absolute; bottom: 10px; left: 10px; background: rgba(190, 18, 60, 0.92); color: #ffffff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; backdrop-filter: blur(4px);">
                            🌄 5. Balcony / Extra View
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 ROOM CARDS SECTION WITH BALANCED EQUAL HEIGHT CARDS & PROPER SPACING -->
        <style>
            /* Completely eliminate repeating arrow or zigzag patterns on dropdowns/inputs */
            .room-capacity-select,
            select.form-control {
                background-color: #ffffff !important;
                background-image: none !important;
                background-repeat: no-repeat !important;
                -webkit-appearance: menulist !important;
                -moz-appearance: menulist !important;
                appearance: menulist !important;
                cursor: pointer !important;
                height: 44px !important;
                line-height: 1.4 !important;
            }
            .room-card-col {
                margin-bottom: 35px !important;
                display: flex !important;
                align-items: stretch !important;
            }
            .room-card-box {
                background: #ffffff;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 8px 24px rgba(0,0,0,0.07);
                width: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .room-card-box:hover {
                box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            }
        </style>

        <h3 style="font-weight: 900; color: #074121; margin-bottom: 22px; font-size: 22px; display: flex; align-items: center; gap: 8px;">
            🛏️ Select Room Type &amp; Person Capacity (Available Options for {{ $hotel['name'] ?? 'This Property' }})
        </h3>

        <div class="row" style="margin-left: -15px; margin-right: -15px; margin-bottom: 40px;">
            
            <!-- ROOM CARD 1: PRIMARY CONFIGURED ROOM (DYNAMIC) -->
            <div class="col-lg-6 col-md-6 col-12 room-card-col">
                <div class="room-card-box" style="border: 2px solid #074121;">
                    <div>
                        <div style="position: relative; height: 220px; width: 100%; overflow: hidden; background: #e2e8f0;">
                            <img src="{{ $imgRoom }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/deluxe_room.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span style="position: absolute; top: 14px; left: 14px; background: #074121; color: #fff; font-size: 11.5px; font-weight: 800; padding: 5px 14px; border-radius: 20px; box-shadow: 0 3px 8px rgba(0,0,0,0.35); z-index: 5; text-transform: uppercase;">
                                ⭐ PRIMARY OPTION: {{ strtoupper($primaryRoom) }}
                            </span>
                        </div>

                        <div style="padding: 22px 22px 10px 22px;">
                            <h4 style="font-weight: 900; color: #0f172a; font-size: 19px; margin-bottom: 6px; height: 26px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $primaryRoom }}
                            </h4>
                            <p style="font-size: 13px; color: #64748b; margin-bottom: 15px; height: 38px; overflow: hidden; line-height: 1.45;">
                                {{ $primaryBed }} with {{ $primaryBath }}, high-speed WiFi, {{ $primaryAc }} &amp; 24-hr generator backup.
                            </p>

                            <!-- PERSON CAPACITY DROP-DOWN WITH DYNAMIC REAL-TIME PRICE UPDATE -->
                            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                                <label style="font-size: 12px; font-weight: 800; color: #074121; text-transform: uppercase; display: block; margin-bottom: 6px;">
                                    👥 Select Guests / Persons Capacity:
                                </label>
                                <select onchange="updateRoomCalculatedPrice('price_deluxe_ac', this.value)" class="form-control room-capacity-select" style="border-radius: 8px; font-weight: 700; height: 44px; font-size: 13.5px; border: 1.5px solid #074121; background-color: #ffffff !important; background-image: none !important; background-repeat: no-repeat !important; appearance: menulist !important; -webkit-appearance: menulist !important; -moz-appearance: menulist !important; cursor: pointer; padding: 0 10px;">
                                    <option value="{{ $primaryPrice }}" selected>2 Persons — ₹{{ number_format($primaryPrice) }} / night</option>
                                    <option value="{{ $familyPrice }}">3–5 Persons — ₹{{ number_format($familyPrice) }} / night</option>
                                    <option value="{{ $hallPrice }}">6–7 Persons — ₹{{ number_format($hallPrice) }} / night</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 0 22px 22px 22px;">
                        <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                            <div>
                                <span style="font-size: 11.5px; color: #64748b; font-weight: 600; display: block;">Calculated Rate:</span>
                                <span style="font-size: 26px; font-weight: 900; color: #074121;" id="price_deluxe_ac">₹{{ number_format($primaryPrice) }}</span>
                                <span style="font-size: 12px; color: #64748b;"> / night</span>
                            </div>
                            <span style="font-size: 11px; color: #16a34a; font-weight: 800; background: #dcfce7; padding: 4px 10px; border-radius: 6px;">
                                Verified Room
                            </span>
                        </div>

                        <button type="button" onclick="triggerRoomBooking('{{ addslashes($primaryRoom) }}', 'price_deluxe_ac')" class="btn w-100" style="background: #074121; color: #ffffff; font-weight: 900; border-radius: 8px; height: 48px; padding: 0 20px; border: none; font-size: 14.5px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(7,65,33,0.3); cursor: pointer;">
                            Book {{ $primaryRoom }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- ROOM CARD 2: ECONOMY STANDARD NON-AC OPTION -->
            <div class="col-lg-6 col-md-6 col-12 room-card-col">
                <div class="room-card-box" style="border: 2px solid #0284c7;">
                    <div>
                        <div style="position: relative; height: 220px; width: 100%; overflow: hidden; background: #e2e8f0;">
                            <img src="{{ $imgBathroom }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/standard_room.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span style="position: absolute; top: 14px; left: 14px; background: #0284c7; color: #fff; font-size: 11.5px; font-weight: 800; padding: 5px 14px; border-radius: 20px; box-shadow: 0 3px 8px rgba(0,0,0,0.35); z-index: 5; text-transform: uppercase;">
                                🌿 OPTION 2: ECONOMY STANDARD NON-AC ROOM
                            </span>
                        </div>

                        <div style="padding: 22px 22px 10px 22px;">
                            <h4 style="font-weight: 900; color: #0f172a; font-size: 19px; margin-bottom: 6px; height: 26px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                Standard Economy Non-AC Room
                            </h4>
                            <p style="font-size: 13px; color: #64748b; margin-bottom: 15px; height: 38px; overflow: hidden; line-height: 1.45;">
                                Clean double bed room for budget pilgrims with attached bath, clean linen &amp; 24-hr water supply.
                            </p>

                            <!-- PERSON CAPACITY DROP-DOWN WITH DYNAMIC REAL-TIME PRICE UPDATE -->
                            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                                <label style="font-size: 12px; font-weight: 800; color: #0284c7; text-transform: uppercase; display: block; margin-bottom: 6px;">
                                    👥 Select Guests / Persons Capacity:
                                </label>
                                <select onchange="updateRoomCalculatedPrice('price_standard_non_ac', this.value)" class="form-control room-capacity-select" style="border-radius: 8px; font-weight: 700; height: 44px; font-size: 13.5px; border: 1.5px solid #0284c7; background-color: #ffffff !important; background-image: none !important; background-repeat: no-repeat !important; appearance: menulist !important; -webkit-appearance: menulist !important; -moz-appearance: menulist !important; cursor: pointer; padding: 0 10px;">
                                    <option value="{{ $nonAcPrice }}" selected>2 Persons — ₹{{ number_format($nonAcPrice) }} / night</option>
                                    <option value="{{ $nonAcMid }}">3–5 Persons — ₹{{ number_format($nonAcMid) }} / night</option>
                                    <option value="{{ $nonAcLarge }}">6–7 Persons — ₹{{ number_format($nonAcLarge) }} / night</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 0 22px 22px 22px;">
                        <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                            <div>
                                <span style="font-size: 11.5px; color: #64748b; font-weight: 600; display: block;">Calculated Rate:</span>
                                <span style="font-size: 26px; font-weight: 900; color: #0284c7;" id="price_standard_non_ac">₹{{ number_format($nonAcPrice) }}</span>
                                <span style="font-size: 12px; color: #64748b;"> / night</span>
                            </div>
                            <span style="font-size: 11px; color: #0284c7; font-weight: 800; background: #e0f2fe; padding: 4px 10px; border-radius: 6px;">
                                Budget Rate
                            </span>
                        </div>

                        <button type="button" onclick="triggerRoomBooking('Standard Economy Non-AC Room', 'price_standard_non_ac')" class="btn w-100" style="background: #0284c7; color: #ffffff; font-weight: 900; border-radius: 8px; height: 48px; padding: 0 20px; border: none; font-size: 14.5px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(2,132,199,0.3); cursor: pointer;">
                            Book Economy Room
                        </button>
                    </div>
                </div>
            </div>

            <!-- ROOM CARD 3: LUXURY AC FAMILY HALL -->
            <div class="col-lg-6 col-md-6 col-12 room-card-col">
                <div class="room-card-box" style="border: 2px solid #86198f;">
                    <div>
                        <div style="position: relative; height: 220px; width: 100%; overflow: hidden; background: #e2e8f0;">
                            <img src="{{ asset('home/images/dewasharif/dewapage/family_hall.jpg') }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/deluxe_room.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span style="position: absolute; top: 14px; left: 14px; background: #86198f; color: #fff; font-size: 11.5px; font-weight: 800; padding: 5px 14px; border-radius: 20px; box-shadow: 0 3px 8px rgba(0,0,0,0.35); z-index: 5; text-transform: uppercase;">
                                👨‍👩‍👧‍👦 OPTION 3: AC FAMILY HALL (6-8 BEDS)
                            </span>
                        </div>

                        <div style="padding: 22px 22px 10px 22px;">
                            <h4 style="font-weight: 900; color: #0f172a; font-size: 19px; margin-bottom: 6px; height: 26px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                Luxury AC Family Hall
                            </h4>
                            <p style="font-size: 13px; color: #64748b; margin-bottom: 15px; height: 38px; overflow: hidden; line-height: 1.45;">
                                Large 6 to 8 bed air-conditioned family hall lodge with dual attached bathrooms for group stays.
                            </p>

                            <!-- PERSON CAPACITY DROP-DOWN WITH DYNAMIC REAL-TIME PRICE UPDATE -->
                            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                                <label style="font-size: 12px; font-weight: 800; color: #86198f; text-transform: uppercase; display: block; margin-bottom: 6px;">
                                    👥 Select Guests / Persons Capacity:
                                </label>
                                <select onchange="updateRoomCalculatedPrice('price_ac_family_hall', this.value)" class="form-control room-capacity-select" style="border-radius: 8px; font-weight: 700; height: 44px; font-size: 13.5px; border: 1.5px solid #86198f; background-color: #ffffff !important; background-image: none !important; background-repeat: no-repeat !important; appearance: menulist !important; -webkit-appearance: menulist !important; -moz-appearance: menulist !important; cursor: pointer; padding: 0 10px;">
                                    <option value="{{ $acHallStandard }}" selected>2 Persons — ₹{{ number_format($acHallStandard) }} / night</option>
                                    <option value="{{ $acHallMid }}">3–5 Persons — ₹{{ number_format($acHallMid) }} / night</option>
                                    <option value="{{ $acHallLarge }}">6–7 Persons — ₹{{ number_format($acHallLarge) }} / night</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 0 22px 22px 22px;">
                        <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                            <div>
                                <span style="font-size: 11.5px; color: #64748b; font-weight: 600; display: block;">Calculated Rate:</span>
                                <span style="font-size: 26px; font-weight: 900; color: #86198f;" id="price_ac_family_hall">₹{{ number_format($acHallStandard) }}</span>
                                <span style="font-size: 12px; color: #64748b;"> / night</span>
                            </div>
                            <span style="font-size: 11px; color: #86198f; font-weight: 800; background: #fae8ff; padding: 4px 10px; border-radius: 6px;">
                                Group Hall
                            </span>
                        </div>

                        <button type="button" onclick="triggerRoomBooking('Luxury AC Family Hall (6-8 Beds)', 'price_ac_family_hall')" class="btn w-100" style="background: #86198f; color: #ffffff; font-weight: 900; border-radius: 8px; height: 48px; padding: 0 20px; border: none; font-size: 14.5px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(134,25,143,0.3); cursor: pointer;">
                            Book AC Family Hall
                        </button>
                    </div>
                </div>
            </div>

            <!-- ROOM CARD 4: STANDARD NON-AC FAMILY HALL -->
            <div class="col-lg-6 col-md-6 col-12 room-card-col">
                <div class="room-card-box" style="border: 2px solid #d97706;">
                    <div>
                        <div style="position: relative; height: 220px; width: 100%; overflow: hidden; background: #e2e8f0;">
                            <img src="{{ asset('home/images/dewasharif/dewapage/family_hall.jpg') }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/standard_room.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span style="position: absolute; top: 14px; left: 14px; background: #d97706; color: #fff; font-size: 11.5px; font-weight: 800; padding: 5px 14px; border-radius: 20px; box-shadow: 0 3px 8px rgba(0,0,0,0.35); z-index: 5; text-transform: uppercase;">
                                🏬 OPTION 4: NON-AC FAMILY HALL (6 BEDS)
                            </span>
                        </div>

                        <div style="padding: 22px 22px 10px 22px;">
                            <h4 style="font-weight: 900; color: #0f172a; font-size: 19px; margin-bottom: 6px; height: 26px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                Standard Non-AC Family Hall
                            </h4>
                            <p style="font-size: 13px; color: #64748b; margin-bottom: 15px; height: 38px; overflow: hidden; line-height: 1.45;">
                                Economical spacious group hall with 6 single beds, carpet flooring &amp; attached bathroom.
                            </p>

                            <!-- PERSON CAPACITY DROP-DOWN WITH DYNAMIC REAL-TIME PRICE UPDATE -->
                            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;">
                                <label style="font-size: 12px; font-weight: 800; color: #d97706; text-transform: uppercase; display: block; margin-bottom: 6px;">
                                    👥 Select Guests / Persons Capacity:
                                </label>
                                <select onchange="updateRoomCalculatedPrice('price_non_ac_family_hall', this.value)" class="form-control room-capacity-select" style="border-radius: 8px; font-weight: 700; height: 44px; font-size: 13.5px; border: 1.5px solid #d97706; background-color: #ffffff !important; background-image: none !important; background-repeat: no-repeat !important; appearance: menulist !important; -webkit-appearance: menulist !important; -moz-appearance: menulist !important; cursor: pointer; padding: 0 10px;">
                                    <option value="{{ $nonAcHallStandard }}" selected>2 Persons — ₹{{ number_format($nonAcHallStandard) }} / night</option>
                                    <option value="{{ $nonAcHallMid }}">3–5 Persons — ₹{{ number_format($nonAcHallMid) }} / night</option>
                                    <option value="{{ $nonAcHallLarge }}">6–7 Persons — ₹{{ number_format($nonAcHallLarge) }} / night</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 0 22px 22px 22px;">
                        <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                            <div>
                                <span style="font-size: 11.5px; color: #64748b; font-weight: 600; display: block;">Calculated Rate:</span>
                                <span style="font-size: 26px; font-weight: 900; color: #d97706;" id="price_non_ac_family_hall">₹{{ number_format($nonAcHallStandard) }}</span>
                                <span style="font-size: 12px; color: #64748b;"> / night</span>
                            </div>
                            <span style="font-size: 11px; color: #d97706; font-weight: 800; background: #fef3c7; padding: 4px 10px; border-radius: 6px;">
                                Budget Hall
                            </span>
                        </div>

                        <button type="button" onclick="triggerRoomBooking('Standard Non-AC Family Hall (6 Beds)', 'price_non_ac_family_hall')" class="btn w-100" style="background: #d97706; color: #ffffff; font-weight: 900; border-radius: 8px; height: 48px; padding: 0 20px; border: none; font-size: 14.5px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(217,119,6,0.3); cursor: pointer;">
                            Book Non-AC Family Hall
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- SEPARATE CUSTOM GROUP & FAMILY HALL STAY BOX -->
        <div
            style="background: #ffffff; border-radius: 14px; padding: 25px 28px; color: #111827; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 30px; border: 1.5px solid #cbd5e1;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                <h5 style="color: #0f172a; font-weight: 900; margin: 0; font-size: 17.5px;">
                    🏨 Want to Book a Custom Family Hall, Lodge or Large Group Stay?
                </h5>
                <span
                    style="font-size: 12px; background: #fef3c7; color: #b45309; padding: 5px 14px; border-radius: 20px; font-weight: 800; border: 1px solid #fde68a;">
                    Special Group Rates Available for Urs, Mela &amp; Big Families
                </span>
            </div>

            <form class="row g-3 align-items-end" onsubmit="event.preventDefault(); submitCustomWhatsAppHotelStay();">
                <div class="col-md-3 col-sm-6">
                    <label
                        style="font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🏨
                        Stay Requirement</label>
                    <input type="text" id="custom_hotel_req" class="form-control"
                        placeholder="E.g., Full AC Hall / 3 Rooms / Family Lodge"
                        style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                </div>

                <div class="col-md-3 col-sm-6">
                    <label
                        style="font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">👥
                        Total Guests / Persons</label>
                    <input type="text" id="custom_hotel_guests" class="form-control"
                        placeholder="E.g., 6-10 Persons Group / 2 Families"
                        style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                </div>

                <div class="col-md-3 col-sm-6">
                    <label
                        style="font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📅
                        Expected Dates / Duration</label>
                    <input type="text" id="custom_hotel_dates" class="form-control"
                        placeholder="E.g., 20 Oct to 22 Oct (2 Nights)"
                        style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                </div>

                <div class="col-md-3 col-sm-6">
                    <label style="font-size: 12.5px; font-weight: 700; color: transparent; margin-bottom: 6px; display: block; user-select: none;">Action</label>
                    <button type="button" onclick="submitCustomWhatsAppHotelStay()" class="btn w-100 font-extrabold"
                        style="background: #25D366; color: #ffffff; font-weight: 900; height: 46px; border-radius: 8px; font-size: 13.5px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35); display: flex; align-items: center; justify-content: center; gap: 6px; white-space: nowrap; padding: 0 8px; margin: 0;">
                        <i class="fa fa-whatsapp" style="font-size: 18px;"></i>
                        Connect With WhatsApp 
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    // Live Dynamic Price Update based on Person Capacity Dropdown Selection
    function updateRoomCalculatedPrice(elemId, priceValue) {
        var num = parseFloat(priceValue) || 0;
        $('#' + elemId).text('₹' + num.toLocaleString('en-IN'));
    }

    // Redirect to Dedicated Hotel Checkout Page for Selected Room
    function triggerRoomBooking(roomName, priceElemId) {
        var priceStr = $('#' + priceElemId).text();
        var numPrice = parseFloat(priceStr.replace(/[^0-9.]/g, '')) || 1499;
        var hotelName = "{{ addslashes($hotel['name'] ?? 'Hotel Room Stay') }}";
        var today = new Date().toISOString().split('T')[0];
        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var checkoutDate = tomorrow.toISOString().split('T')[0];

        $.ajax({
            url: "{{ route('hotels.checkout.init') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                hotel: hotelName,
                room: roomName,
                price: numPrice,
                checkin: today,
                checkout: checkoutDate
            },
            success: function(res) {
                window.location.href = res.redirect_url || "{{ route('hotels.checkout') }}";
            },
            error: function() {
                window.location.href = "{{ route('hotels.checkout') }}";
            }
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
        var safeGuests = guests || '8-15 Persons';
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
