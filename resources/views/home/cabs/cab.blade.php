@extends('home.includes.master')

@section('title', 'Direct Cab Booking: Lucknow to Dewa Sharif Taxi | Airport & Railway Station')
@section('meta_title', 'Lucknow to Dewa Sharif Cab Booking | Fixed Rate Taxi Service')
@section('meta_description', 'Book guaranteed direct cabs and taxis between Lucknow Airport (CCS), Charbagh Railway Station, and Dewa Sharif Dargah. Fixed fare Sedan, SUV, and Auto for Dewa Mela 2026.')
@section('meta_keywords', 'Lucknow to Dewa Sharif Cab, Dewa Sharif Taxi, Charbagh to Dewa Cab, Lucknow Airport to Dewa Sharif Taxi, Dewa Cab Booking, Dewa Mela Taxi')
@section('og_title', 'Direct Cab Booking: Lucknow to Dewa Sharif Taxi')
@section('og_description', 'Guaranteed direct cabs & fixed rate taxis between Lucknow and Dewa Sharif Dargah with 24/7 instant booking.')


@section('content')
    <div style="background: #f4f6f8; padding-bottom: 60px; min-height: 90vh;">

        <style>
            .cab-hero-section {
                background: linear-gradient(180deg, rgba(5, 44, 22, 0.48) 0%, rgba(3, 25, 13, 0.72) 100%), url('{{ asset('home/images/dewasharif/dewapage/hero_cab_bg.jpg') }}') center/cover no-repeat;
                color: #ffffff;
                padding: 50px 16px 70px 16px;
                text-align: center;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                position: relative;
                box-sizing: border-box;
            }
            .cab-hero-title {
                font-weight: 900;
                font-size: 38px;
                margin-top: 10px;
                margin-bottom: 8px;
                color: #ffea00;
                text-shadow: 0 3px 8px rgba(0,0,0,0.95);
                letter-spacing: -0.5px;
                word-break: break-word;
            }
            .cab-hero-sub {
                font-size: 20.5px;
                font-weight: 900;
                color: #ffffff;
                margin-bottom: 6px;
                text-shadow: 0 3px 8px rgba(0,0,0,0.95);
                letter-spacing: 0.4px;
                word-break: break-word;
            }
            .cab-hero-desc {
                font-size: 15.5px;
                color: #ffffff;
                max-width: 780px;
                margin: 10px auto 0 auto;
                line-height: 1.6;
                font-weight: 600;
                text-shadow: 0 2px 6px rgba(0,0,0,0.85);
                padding: 0 8px;
                word-break: break-word;
            }
            .cab-booking-box {
                background: #ffffff;
                border-radius: 14px;
                padding: 25px 28px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.12);
                border: 1.5px solid #cbd5e1;
                margin-bottom: 30px;
                box-sizing: border-box;
            }
            @media (max-width: 768px) {
                .cab-hero-section {
                    padding: 38px 12px 55px 12px !important;
                }
                .cab-hero-title {
                    font-size: 22px !important;
                    line-height: 1.35 !important;
                }
                .cab-hero-sub {
                    font-size: 14.5px !important;
                    line-height: 1.45 !important;
                }
                .cab-hero-desc {
                    font-size: 13px !important;
                    line-height: 1.5 !important;
                    padding: 0 4px !important;
                }
                .cab-booking-box {
                    padding: 16px 12px !important;
                }
            }
            @media (max-width: 360px) {
                .cab-hero-section {
                    padding: 30px 8px 45px 8px !important;
                }
                .cab-hero-title {
                    font-size: 19px !important;
                }
                .cab-hero-sub {
                    font-size: 13px !important;
                }
                .cab-hero-desc {
                    font-size: 12px !important;
                }
                .cab-booking-box {
                    padding: 12px 8px !important;
                }
            }
        </style>

        <!-- TOP HERO BANNER -->
        <div class="cab-hero-section">
            <div class="container">
                <div style="margin-bottom: 12px;">
                    <span
                        style="background: #f1ce02ff; color: #f4f6f8; border: 1.5px solid #ffffff; padding: 6px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; display: inline-block; box-shadow: 0 2px 10px rgba(0,230,118,0.4);">
                        🚕 GUARANTEED FIXED-FARE CABS &amp; AUTOS
                    </span>
                </div>

                <h1 class="cab-hero-title">
                    Dewa Sharif - Lucknow - Dewa Sharif
                </h1>
                <div class="cab-hero-sub">
                    Station , Airport &amp; Outstation Cabs | Lucknow &amp; Outstation Tour Booking Cabs
                </div>
                <p class="cab-hero-desc">
                    <span style="color: #ffffff; font-weight: 700; text-shadow: 0 2px 6px rgba(0,0,0,0.85);">24/7 fixed fare cab &amp; auto booking. Zero surge pricing also in Dewa Sharif Urs/mela season.</span>
                </p>
            </div>
        </div>

        <div class="container" style="margin-top: -35px; position: relative; z-index: 10;">

            <!-- STANDARD FARE CALCULATOR & BOOKING BOX -->
            <div class="cab-booking-box">
                @php
                    $standardLocations = [
                        'Dewa Sharif',
                        'Lucknow Airport',
                        'Lucknow Railway Station',
                        'Lucknow City Tour',
                        'Barabanki Railway Station',
                        'Barabanki Highway By-Pass',
                        'Bahraich Sharif',
                        'Bansa Sharif'
                    ];

                    $cleanLoc = function($name) {
                        $n = trim($name);
                        if (empty($n)) return '';
                        if (stripos($n, 'airport') !== false || stripos($n, 'ccsi') !== false) {
                            return 'Lucknow Airport';
                        }
                        if (stripos($n, 'charbagh') !== false || stripos($n, 'lucknow railway') !== false) {
                            return 'Lucknow Railway Station';
                        }
                        if (stripos($n, 'city tour') !== false) {
                            return 'Lucknow City Tour';
                        }
                        if (stripos($n, 'barabanki') !== false && (stripos($n, 'railway') !== false || stripos($n, 'junction') !== false)) {
                            return 'Barabanki Railway Station';
                        }
                        if (stripos($n, 'bypass') !== false || stripos($n, 'by-pass') !== false) {
                            return 'Barabanki Highway By-Pass';
                        }
                        if (stripos($n, 'bahraich') !== false) {
                            return 'Bahraich Sharif';
                        }
                        if (stripos($n, 'bansa') !== false) {
                            return 'Bansa Sharif';
                        }
                        if (stripos($n, 'dewa') !== false) {
                            return 'Dewa Sharif';
                        }
                        return $n;
                    };

                    $pickupsList = $standardLocations;
                    $dropsList = $standardLocations;

                    if (isset($locations) && (is_array($locations) || is_object($locations))) {
                        foreach($locations as $l) {
                            $rawNm = trim(is_array($l) ? ($l['name'] ?? '') : ($l->name ?? ''));
                            $nm = $cleanLoc($rawNm);
                            $tp = strtolower(is_array($l) ? ($l['type'] ?? 'both') : ($l->type ?? 'both'));
                            if ($nm) {
                                if (($tp === 'pickup' || $tp === 'both') && !in_array($nm, $pickupsList)) {
                                    $pickupsList[] = $nm;
                                }
                                if (($tp === 'drop' || $tp === 'both') && !in_array($nm, $dropsList)) {
                                    $dropsList[] = $nm;
                                }
                            }
                        }
                    }

                    $pickupsList = array_values(array_unique($pickupsList));
                    $dropsList = array_values(array_unique($dropsList));

                    $initPickup = in_array('Dewa Sharif', $pickupsList) ? 'Dewa Sharif' : ($pickupsList[0] ?? '');
                    $initDrop = in_array('Lucknow Airport', $dropsList) ? 'Lucknow Airport' : ($dropsList[1] ?? ($dropsList[0] ?? ''));

                    // Precalculate initial fare so badge is never stuck on 'Checking Fare...'
                    $initFare = 0;
                    foreach($cabs as $c) {
                        $cP = $cleanLoc(is_array($c) ? ($c['pickup'] ?? '') : ($c->pickup ?? ''));
                        $cD = $cleanLoc(is_array($c) ? ($c['destination'] ?? '') : ($c->destination ?? ''));
                        $cF = (float)(is_array($c) ? ($c['fare'] ?? ($c['price'] ?? 0)) : ($c->fare ?? ($c->price ?? 0)));

                        $pOk = (strcasecmp($cP, $initPickup) === 0 || stripos($cP, $initPickup) !== false || stripos($initPickup, $cP) !== false);
                        $dOk = (strcasecmp($cD, $initDrop) === 0 || stripos($cD, $initDrop) !== false || stripos($initDrop, $cD) !== false);
                        $revPOk = (strcasecmp($cP, $initDrop) === 0 || stripos($cP, $initDrop) !== false || stripos($initDrop, $cP) !== false);
                        $revDOk = (strcasecmp($cD, $initPickup) === 0 || stripos($cD, $initPickup) !== false || stripos($initPickup, $cD) !== false);

                        if (($pOk && $dOk) || ($revPOk && $revDOk)) {
                            if ($cF > 0) {
                                $initFare = $cF;
                                break;
                            }
                        }
                    }
                @endphp

                <div
                    style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <h5 style="color: #074121; font-weight: 900; margin: 0; font-size: 18px;">
                        🔍 Calculate Fixed Fare &amp; Book Cabs
                    </h5>
                    <span id="liveFareBadge"
                        style="font-size: 14px; background: {{ $initFare > 0 ? '#ecfdf5' : '#fef3c7' }}; color: {{ $initFare > 0 ? '#047857' : '#b45309' }}; padding: 5px 14px; border-radius: 6px; font-weight: 800; border: 1px solid {{ $initFare > 0 ? '#a7f3d0' : '#fde68a' }};">
                        {{ $initFare > 0 ? 'Estimated Fare: ₹' . number_format($initFare) : 'Custom Quote on WhatsApp' }}
                    </span>
                </div>

                <form id="cabBookingFormSearch" autocomplete="off" class="row g-3 align-items-end">

                    <!-- PICKUP LOCATION -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <label
                            style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📍
                            Pickup Location</label>
                        <select id="pickup_select" autocomplete="off" onchange="updateLiveFare('pickup')" class="form-control"
                            style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-weight: 600; font-size: 13.5px;">
                            @foreach($pickupsList as $pk)
                                <option value="{{ $pk }}" {{ (strcasecmp($pk, $initPickup) === 0) ? 'selected' : '' }}>{{ $pk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- DROP LOCATION -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin: 0; display: block;">📍 Drop Location</label>
                            <button type="button" onclick="swapPickupDrop()" title="Swap Pickup &amp; Drop Route" style="background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #047857; font-size: 11.5px; font-weight: 800; border-radius: 6px; padding: 2px 9px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='#047857'; this.style.color='#fff';" onmouseout="this.style.background='#ecfdf5'; this.style.color='#047857';">
                                ⇄ Swap
                            </button>
                        </div>
                        <select id="drop_select" autocomplete="off" onchange="updateLiveFare('drop')" class="form-control"
                            style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-weight: 600; font-size: 13.5px;">
                            @foreach($dropsList as $dp)
                                <option value="{{ $dp }}" {{ (strcasecmp($dp, $initDrop) === 0) ? 'selected' : '' }}>{{ $dp }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- VEHICLE CHOICE DROPDOWN (DYNAMIC FROM ADMIN VEHICLES / ROUTES) -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <label
                            style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🚕
                            Vehicle Choice</label>
                        <select id="vehicle_type_select" autocomplete="off" onchange="updateLiveFare('vehicle')" class="form-control"
                            style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-weight: 600; font-size: 13.5px; background: #ffffff !important; background-image: none !important;">
                            @php
                                $availableVehicles = $vehicles;
                                if (empty($availableVehicles) || count($availableVehicles) === 0) {
                                    $routeVehicles = [];
                                    foreach($cabs as $c) {
                                        $vt = trim(is_array($c) ? ($c['vehicle_type'] ?? ($c['vehicle_name'] ?? '')) : ($c->vehicle_type ?? ($c->vehicle_name ?? '')));
                                        $fp = (float)(is_array($c) ? ($c['fare'] ?? ($c['price'] ?? 0)) : ($c->fare ?? ($c->price ?? 0)));
                                        if ($vt && !isset($routeVehicles[$vt])) {
                                            $routeVehicles[$vt] = ['name' => $vt, 'price' => $fp];
                                        }
                                    }
                                    $availableVehicles = array_values($routeVehicles);
                                }
                                if (empty($availableVehicles)) {
                                    $availableVehicles = [
                                        ['name' => 'Ertiga etc which is available (SUV)', 'price' => 2600],
                                        ['name' => 'Dzire etc which is available (Semi Deluxe - Sedan)', 'price' => 2200],
                                        ['name' => 'Verna etc which is available (Deluxe - Sedan)', 'price' => 2300]
                                    ];
                                }
                            @endphp
                            @foreach($availableVehicles as $v)
                                @php
                                    $vName = is_array($v) ? ($v['name'] ?? 'Car') : ($v->name ?? 'Car');
                                    $vPrice = (float)(is_array($v) ? ($v['price'] ?? ($v['fare'] ?? 0)) : ($v->price ?? 0));
                                    $isSel = (stripos($vName, 'ertiga') !== false);
                                @endphp
                                <option value="{{ $vName }}" data-price="{{ $vPrice }}" {{ $isSel ? 'selected' : '' }}>{{ $vName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- ACTION BUTTON: GET FARE & BOOK CABS -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <label style="font-size: 13px; font-weight: 700; color: transparent; margin-bottom: 6px; display: block; user-select: none;">Action</label>
                        <button type="button" id="btnGetFareBook" onclick="openCabBookingModal()" class="btn w-100 font-extrabold"
                            style="background: #074121; color: #ffffff; font-weight: 900; height: 46px; border-radius: 8px; font-size: 14.5px; border: none; box-shadow: 0 4px 12px rgba(7, 65, 33, 0.35); display: flex; align-items: center; justify-content: center; white-space: nowrap; padding: 0 12px; margin: 0;">
                            Get Fare &amp; Book Cabs
                        </button>
                    </div>
                </form>
            </div>

            <!-- SEPARATE CUSTOM LOCATION ROUTE BOX -->
            <div
                style="background: #ffffff; border-radius: 14px; padding: 25px 28px; color: #111827; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 30px; border: 1.5px solid #cbd5e1;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                    <h5 style="color: #0f172a; font-weight: 900; margin: 0; font-size: 17.5px;">
                        📍 Want to Book a Custom Outstation / Local Route?
                    </h5>
                    <span
                        style="font-size: 12px; background: #fef3c7; color: #b45309; padding: 5px 14px; border-radius: 20px; font-weight: 800; border: 1px solid #fde68a;">
                         We Also Provide Vehicles for Transport Goods & Luggage.
                    </span>
                </div>

                <form class="row g-3 align-items-end">
                    <div class="col-md-3 col-sm-6">
                        <label
                            style="font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📍
                            Your Pickup Point</label>
                        <input type="text" id="custom_pickup" class="form-control"
                            placeholder="E.g., Dewa Sharif / Any Hotel / Add."
                            style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label
                            style="font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📍
                            Destination Place</label>
                        <input type="text" id="custom_drop" class="form-control"
                            placeholder="E.g., Any City / Station / Landmark"
                            style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label
                            style="font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🚕
                            Preferred Vehicle</label>
                        <input type="text" id="custom_vehicle" class="form-control"
                            placeholder="E.g., Ertiga/Pickup-Dala/Van/Dzire etc"
                            style="border-radius: 8px; height: 46px; font-weight: 600; border: 1.5px solid #cbd5e1; background: #ffffff; color: #0f172a;">
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label style="font-size: 12.5px; font-weight: 700; color: transparent; margin-bottom: 6px; display: block; user-select: none;">Action</label>
                        <button type="button" onclick="submitCustomWhatsAppRoute()" class="btn w-100 font-extrabold"
                            style="background: #25D366; color: #ffffff; font-weight: 900; height: 46px; border-radius: 8px; font-size: 13.5px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35); display: flex; align-items: center; justify-content: center; gap: 6px; white-space: nowrap; padding: 0 8px; margin: 0;">
                            <i class="fa fa-whatsapp" style="font-size: 18px;"></i>
                            Connect With WhatsApp 
                        </button>
                    </div>
                </form>
            </div>

            <!-- DEDICATED E-RICKSHAW DEWA LOCAL SIGHTSEEING CARD -->
            @php
                $eStatus = strtolower($erickshaw['status'] ?? 'active');
            @endphp
            <div class="col-12 mb-5">
                <style>
                    .cab-erickshaw-box {
                        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
                        border-radius: 16px;
                        border: 2px solid #f59e0b;
                        padding: 28px 32px;
                        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.18);
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: space-between;
                        align-items: center;
                        gap: 20px;
                        box-sizing: border-box;
                    }
                    .cab-erickshaw-content {
                        flex: 1;
                        min-width: 280px;
                    }
                    @media (max-width: 768px) {
                        .cab-erickshaw-box {
                            padding: 20px 14px !important;
                            gap: 14px !important;
                        }
                        .cab-erickshaw-content {
                            min-width: 0 !important;
                            width: 100% !important;
                        }
                    }
                </style>
                <div class="cab-erickshaw-box">
                    <div class="cab-erickshaw-content">
                        <div style="display: inline-block; background: #ffffff; color: #15803d; border: 1.5px solid #16a34a; font-size: 11.5px; font-weight: 900; padding: 5px 16px; border-radius: 20px; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px; box-shadow: 0 2px 6px rgba(22,163,74,0.12);">
                            🛺 LOCAL TRANSPORT (ONLY DEWA SHARIF SHRINE)
                        </div>
                        <h3 style="font-size: 22px; font-weight: 900; color: #78350f; margin-bottom: 8px;">
                            Local Dewa Shrine E-Rickshaw Sightseeing Service
                        </h3>
                        <p style="font-size: 14.5px; color: #92400e; margin: 0 0 14px 0; font-weight: 600; line-height: 1.5;">
                            Auto & Electric E-Rickshaw service for local shrine visits.
                        </p>
                        <div class="d-flex gap-3 align-items-center">
                            <span style="background: #ffffff; color: #15803d; border: 1.5px solid #16a34a; font-size: 15px; font-weight: 900; padding: 7px 18px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(22,163,74,0.12);">
                                🛺 Full Reserve: ₹{{ $erickshaw['full_rickshaw_fare'] ?? 150 }}
                            </span>
                        </div>
                    </div>
                    <div>
                        @if($eStatus === 'active')
                            <a href="https://wa.me/919648777223?text={{ urlencode('Assalamu Alaikum! Main Dewa Sharif Local E-Rickshaw (Only Dewa Ghoomne Ke Liye) book karna chahta hun.') }}" target="_blank" class="btn font-extrabold" style="background: #16a34a; color: #ffffff; font-weight: 900; padding: 14px 28px; font-size: 15px; border-radius: 10px; text-transform: uppercase; box-shadow: 0 4px 14px rgba(22, 163, 74, 0.4); display: inline-flex; align-items: center; gap: 8px;">
                                <i class="fa fa-whatsapp" style="font-size: 20px;"></i> Book Local E-Rickshaw →
                            </a>
                        @else
                            <button class="btn btn-secondary fw-bold" disabled style="padding: 14px 28px; font-size: 15px; border-radius: 10px;">
                                ⚠️ Service Currently Offline / Closed
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FIXED FARE ROUTE CARDS GRID -->
            <h3 style="font-weight: 900; color: #111827; margin-bottom: 24px; font-size: 22px;" id="fixed-routes">
                ⚡ Popular Fixed Fare Route Packages
            </h3>
            <div style="height: 1px; width: 100%; background: linear-gradient(90deg, #16a34a, #22c55e); border-radius: 10px; margin-bottom: 25px;"></div>

            <div class="row g-4" id="routesGrid" style="display: flex; flex-wrap: wrap;">
                @forelse($cabs as $cab)
                    @php
                        $cRoute = is_array($cab) ? ($cab['route_name'] ?? ($cab['route'] ?? 'Cab Route')) : ($cab->route_name ?? 'Cab Route');
                        $cPickup = is_array($cab) ? ($cab['pickup'] ?? 'Pickup Point') : ($cab->pickup ?? 'Pickup Point');
                        $cDest = is_array($cab) ? ($cab['destination'] ?? 'Destination') : ($cab->destination ?? 'Destination');
                        $cType = is_array($cab) ? ($cab['vehicle_type'] ?? ($cab['title'] ?? 'Car')) : ($cab->vehicle_type ?? 'Car');
                        $cFare = is_array($cab) ? ($cab['price'] ?? ($cab['fare'] ?? 0)) : ($cab->price ?? 0);
                        $rawImg = is_array($cab) ? ($cab['image'] ?? '') : ($cab->image ?? '');
                        if (empty($rawImg)) {
                            $vLow = strtolower($cType);
                            if (str_contains($vLow, 'omni') || str_contains($vLow, 'van')) {
                                $rawImg = 'home/images/dewasharif/dewapage/cab_omni.jpg';
                            } elseif (str_contains($vLow, 'pickup') || str_contains($vLow, 'mahindra') || str_contains($vLow, 'dala')) {
                                $rawImg = 'home/images/dewasharif/dewapage/cab_pickup.jpg';
                            } elseif (str_contains($vLow, 'verna')) {
                                $rawImg = 'home/images/dewasharif/dewapage/cab_verna.jpg';
                            } elseif (str_contains($vLow, 'ertiga') || str_contains($vLow, 'suv') || str_contains($vLow, 'tempo')) {
                                $rawImg = 'home/images/dewasharif/dewapage/suv_ertiga.jpg';
                            } else {
                                $rawImg = 'home/images/dewasharif/dewapage/cab_dzire.jpg';
                            }
                        } else {
                            if (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://')) {
                                $parsed = parse_url($rawImg, PHP_URL_PATH);
                                if ($parsed) {
                                    $rawImg = ltrim($parsed, '/');
                                }
                            }
                        }
                        $cImg = asset($rawImg);
                        $cCapacity = is_array($cab) ? ($cab['seating_capacity'] ?? ($cab['capacity'] ?? '4 Passengers')) : ($cab->seating_capacity ?? '4 Passengers');
                        $cAc = is_array($cab) ? ($cab['ac_option'] ?? 'AC') : ($cab->ac_option ?? 'AC');
                    @endphp
                   <div class="col-md-6 col-12" style="margin-bottom: 32px; display: flex;">
                        <div
                            style="background: #ffffff; border-radius: 14px; overflow: hidden; border: 1.5px solid #cbd5e1; box-shadow: 0 8px 24px rgba(0,0,0,0.08); width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                            
                            <!-- TOP 2PX DARK-TO-LIGHT GREEN GRADIENT LINE WITH SHADOW -->
                            <div style="height: 2.5px; width: 100%; background: linear-gradient(90deg, #052c16 0%, #16a34a 50%, #4ade80 100%); box-shadow: 0 2px 8px rgba(22, 163, 74, 0.4);"></div>

                            <div>
                                <div style="position: relative; height: 260px; overflow: hidden; background: #f8fafc;">
                                    <img src="{{ $cImg }}"
                                        alt="{{ $cRoute }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                    <span
                                        style="position: absolute; top: 14px; left: 14px; background: #052c16; color: #22c55e; font-size: 11px; font-weight: 900; padding: 6px 14px; border-radius: 20px; text-transform: uppercase; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                                        🚕 dewasharif.com Cabs Booking
                                    </span>
                                </div>

                                <div style="padding: 20px;">
                                    <h4 style="font-size: 19px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">
                                        {{ $cRoute }}
                                    </h4>
                                    <p style="font-size: 13.5px; color: #64748b; margin-bottom: 16px; line-height: 1.5;">
                                        {{ $cType }} ({{ $cAc }}) — {{ $cCapacity }}. <br> 
                                        Flexible Point Pickup with luggage assistance & fixed rates
                                    </p>

                                    <div
                                        style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                        <div>
                                            <span
                                                style="font-size: 12px; color: #64748b; font-weight: 700; display: block;">Fixed
                                                Package Fare:</span>
                                            @if($cFare > 0)
                                                <span style="font-size: 24px; font-weight: 900; color: #074121;">₹{{ number_format($cFare) }}</span>
                                            @else
                                                <span style="font-size: 16px; font-weight: 900; color: #b45309;">Custom Quote on WhatsApp</span>
                                            @endif
                                        </div>
                                        <span
                                            style="font-size: 11.5px; background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 6px; font-weight: 800;">
                                            ✔ Zero Surge Pricing
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div style="padding: 0 20px 20px 20px;">
                                @if($cFare > 0)
                                    <button type="button"
                                        onclick="presetCabBooking('{{ addslashes($cPickup) }}', '{{ addslashes($cDest) }}', '{{ addslashes($cType) }}', {{ $cFare }})"
                                        class="btn font-extrabold"
                                        style="background: #f59e0b; color: #111827; font-weight: 900; font-size: 14px; border-radius: 8px; padding: 12px 28px; border: none; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35); text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">
                                        RESERVE CABS →
                                    </button>
                                @else
                                    <a href="https://wa.me/919648777223?text={{ urlencode('Assalamu Alaikum Dewa Sharif Cabs! Kripya is route ka custom quote confirm karein: ' . $cPickup . ' ➔ ' . $cDest . ' (' . $cType . ').') }}" target="_blank"
                                        class="btn font-extrabold"
                                        style="background: #25D366; color: #ffffff; font-weight: 900; font-size: 14px; border-radius: 8px; padding: 12px 24px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35); display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                                        <i class="fa fa-whatsapp" style="font-size: 18px;"></i> Get Quote on WhatsApp →
                                    </a>
                                @endif
                            </div>

                            <!-- BOTTOM 2PX LIGHT-TO-DARK GREEN GRADIENT LINE WITH SHADOW -->
                            <div style="height: 2.5px; width: 100%; background: linear-gradient(90deg, #4ade80 0%, #16a34a 50%, #052c16 100%); box-shadow: 0 -2px 8px rgba(22, 163, 74, 0.4);"></div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 text-muted">
                        No active fixed routes available. Please use the calculator or WhatsApp quote above!
                    </div>
                @endforelse
            </div>

            <!-- CAB REVIEWS & PASSENGER EXPERIENCES SECTION -->
            <style>
                .cab-reviews-container {
                    margin-top: 50px;
                    padding-top: 30px;
                    border-top: 2px solid #e2e8f0;
                    padding-left: 10px;
                    padding-right: 10px;
                    box-sizing: border-box;
                }
                .cab-reviews-header-box {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 15px;
                    margin-bottom: 24px;
                    width: 100%;
                    box-sizing: border-box;
                }
                .cab-reviews-title-box {
                    flex: 1 1 auto;
                }
                .cab-reviews-title {
                    font-weight: 900;
                    color: #074121;
                    margin: 0;
                    font-size: 22px;
                    word-break: break-word;
                }
                .cab-reviews-desc {
                    margin: 4px 0 0 0;
                    color: #64748b;
                    font-size: 13.5px;
                    font-weight: 600;
                    word-break: break-word;
                }
                .cab-reviews-actions {
                    display: flex;
                    gap: 10px;
                    flex-wrap: wrap;
                    align-items: center;
                    flex-shrink: 0;
                }
                .cab-reviews-btn {
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
                    .cab-reviews-container {
                        padding-left: 4px;
                        padding-right: 4px;
                        margin-top: 35px;
                        padding-top: 20px;
                    }
                    .cab-reviews-header-box {
                        flex-direction: column !important;
                        align-items: flex-start !important;
                        gap: 12px !important;
                        margin-bottom: 18px !important;
                    }
                    .cab-reviews-title-box {
                        width: 100% !important;
                    }
                    .cab-reviews-title {
                        font-size: 18px !important;
                        line-height: 1.3 !important;
                    }
                    .cab-reviews-desc {
                        font-size: 12.5px !important;
                        line-height: 1.4 !important;
                    }
                    .cab-reviews-actions {
                        width: 100% !important;
                        display: flex !important;
                        gap: 8px !important;
                    }
                    .cab-reviews-btn {
                        flex: 1 1 0% !important;
                        width: 48% !important;
                        font-size: 11.5px !important;
                        padding: 8px 8px !important;
                        box-sizing: border-box !important;
                    }
                }
                @media (max-width: 340px) {
                    .cab-reviews-actions {
                        flex-direction: column !important;
                    }
                    .cab-reviews-btn {
                        width: 100% !important;
                    }
                }
            </style>

            <div class="cab-reviews-container">
                <div class="cab-reviews-header-box">
                    <div class="cab-reviews-title-box">
                        <h4 class="cab-reviews-title">
                            ⭐ Passenger Reviews &amp; Taxi Experiences
                        </h4>
                        <p class="cab-reviews-desc">
                            Verified reviews from pilgrims using Dewa Sharif airport, station &amp; local cab duties
                        </p>
                    </div>
                    <div class="cab-reviews-actions">
                        <button type="button" class="btn btn-warning cab-reviews-btn text-dark" onclick="openCabReviewModal()" data-toggle="modal" data-target="#writeCabReviewModal" data-bs-toggle="modal" data-bs-target="#writeCabReviewModal" style="background: #f59e0b; border: none; font-weight: 800;">
                            ✍️ Write Cab Review
                        </button>
                        <button type="button" class="btn btn-outline-warning cab-reviews-btn text-dark" onclick="openCabFeedbackModal()" data-toggle="modal" data-target="#sendCabFeedbackModal" data-bs-toggle="modal" data-bs-target="#sendCabFeedbackModal" style="border: 1.5px solid #f59e0b; background: #ffffff; font-weight: 800;">
                            💬 Send Feedback
                        </button>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($cabReviews ?? [] as $rev)
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
                                    <span style="font-size: 11px; color: #b45309; font-weight: 700; background: #fef3c7; padding: 2px 8px; border-radius: 4px;">Verified Passenger</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 text-muted">
                            <p>Be the first passenger to review Dewa Sharif cab services!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- WRITE CAB REVIEW MODAL -->
    <div class="modal fade" id="writeCabReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 520px; margin: 30px auto;">
            <div class="modal-content" style="border-radius: 22px; overflow: hidden; border: none; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35); background: #ffffff;">
                <form onsubmit="submitCabReview(event)">
                    <!-- MODAL HEADER -->
                    <div style="background: linear-gradient(135deg, #091e13 0%, #064e3b 55%, #b45309 100%); color: #ffffff; padding: 22px 24px; position: relative;">
                        <div style="display: inline-block; background: rgba(255,255,255,0.18); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 6px;">
                            ⭐ Verified Pilgrim Experience
                        </div>
                        <h4 style="font-weight: 900; font-size: 20px; margin: 0; color: #ffffff; display: flex; align-items: center; gap: 8px;">
                            ✍️ Write a Taxi / Cab Review
                        </h4>
                        <p style="font-size: 12.5px; opacity: 0.85; margin: 4px 0 0 0; color: #f1f5f9;">
                            Share your pickup, driving and car cleanliness feedback with pilgrims
                        </p>
                        <button type="button" onclick="$('#writeCabReviewModal').modal('hide')" data-dismiss="modal" data-bs-dismiss="modal" style="position: absolute; top: 18px; right: 18px; width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,0.18); border: none; color: #ffffff; font-size: 20px; line-height: 1; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.32)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
                            &times;
                        </button>
                    </div>

                    <!-- MODAL BODY -->
                    <div style="padding: 24px; background: #ffffff;">
                        <input type="hidden" name="service_type" value="cab">
                        
                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                🚕 Vehicle / Route Taken*
                            </label>
                            <input type="text" name="item_name" class="form-control" placeholder="e.g. Dewa Sharif to Lucknow Airport / Sedan Taxi" required style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 600; color: #0f172a; height: 44px; width: 100%; box-sizing: border-box; background: #f8fafc;">
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                ⭐ Your Rating*
                            </label>
                            <select name="rating" class="form-control" style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 700; color: #b45309; height: 44px; width: 100%; box-sizing: border-box; background-color: #f8fafc !important; background-image: none !important; -webkit-appearance: menulist !important; -moz-appearance: menulist !important; appearance: menulist !important;">
                                <option value="5" selected>★★★★★ 5 Stars (Prompt &amp; Professional)</option>
                                <option value="4">★★★★☆ 4 Stars (Good Ride)</option>
                                <option value="3">★★★☆☆ 3 Stars (Average)</option>
                                <option value="2">★★☆☆☆ 2 Stars (Needs Improvement)</option>
                                <option value="1">★☆☆☆☆ 1 Star (Not Satisfied)</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                👤 Your Name*
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Aslam Khan" required style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 600; color: #0f172a; height: 44px; width: 100%; box-sizing: border-box; background: #f8fafc;">
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                📱 Phone Number
                            </label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. 9876543210" style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 600; color: #0f172a; height: 44px; width: 100%; box-sizing: border-box; background: #f8fafc;">
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                🏷️ Headline / Short Title
                            </label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Driver was polite &amp; on time" style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 600; color: #0f172a; height: 44px; width: 100%; box-sizing: border-box; background: #f8fafc;">
                        </div>

                        <div class="form-group mb-2">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                ✍️ Your Ride Experience / Comments*
                            </label>
                            <textarea name="comment" class="form-control" rows="3" placeholder="How was the driver, vehicle cleanliness, AC and route?" required style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 12px 14px; font-size: 13.5px; font-weight: 500; color: #0f172a; width: 100%; box-sizing: border-box; resize: vertical; min-height: 90px; background: #f8fafc;"></textarea>
                        </div>
                    </div>

                    <!-- MODAL FOOTER -->
                    <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button type="button" onclick="$('#writeCabReviewModal').modal('hide')" data-dismiss="modal" data-bs-dismiss="modal" style="background: #e2e8f0; color: #475569; border: none; border-radius: 10px; font-weight: 800; padding: 10px 22px; font-size: 13.5px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#cbd5e1'" onmouseout="this.style.background='#e2e8f0'">
                            Cancel
                        </button>
                        <button type="submit" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; border: none; border-radius: 10px; font-weight: 800; padding: 10px 26px; font-size: 14px; cursor: pointer; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.4); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                            ⭐ Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SEND CAB FEEDBACK MODAL -->
    <div class="modal fade" id="sendCabFeedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 520px; margin: 30px auto;">
            <div class="modal-content" style="border-radius: 22px; overflow: hidden; border: none; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35); background: #ffffff;">
                <form onsubmit="submitCabFeedback(event)">
                    <!-- MODAL HEADER -->
                    <div style="background: linear-gradient(135deg, #091e13 0%, #1e3a8a 55%, #2563eb 100%); color: #ffffff; padding: 22px 24px; position: relative;">
                        <div style="display: inline-block; background: rgba(255,255,255,0.18); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 6px;">
                            💬 Direct Administration Desk
                        </div>
                        <h4 style="font-weight: 900; font-size: 20px; margin: 0; color: #ffffff; display: flex; align-items: center; gap: 8px;">
                            💬 Send Cab Service Feedback
                        </h4>
                        <p style="font-size: 12.5px; opacity: 0.85; margin: 4px 0 0 0; color: #f1f5f9;">
                            Suggestions, driver inquiries or private feedback for shrine taxi staff
                        </p>
                        <button type="button" onclick="$('#sendCabFeedbackModal').modal('hide')" data-dismiss="modal" data-bs-dismiss="modal" style="position: absolute; top: 18px; right: 18px; width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,0.18); border: none; color: #ffffff; font-size: 20px; line-height: 1; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.32)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
                            &times;
                        </button>
                    </div>

                    <!-- MODAL BODY -->
                    <div style="padding: 24px; background: #ffffff;">
                        <input type="hidden" name="service_type" value="cab">
                        
                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                👤 Your Name*
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Salman Qureshi" required style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 600; color: #0f172a; height: 44px; width: 100%; box-sizing: border-box; background: #f8fafc;">
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                📱 Phone Number*
                            </label>
                            <input type="text" name="phone" class="form-control" placeholder="e.g. 9876543210" required style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 600; color: #0f172a; height: 44px; width: 100%; box-sizing: border-box; background: #f8fafc;">
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                📌 Subject*
                            </label>
                            <input type="text" name="subject" class="form-control" placeholder="e.g. Driver suggestion / Route inquiry" required style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 10px 14px; font-size: 13.5px; font-weight: 600; color: #0f172a; height: 44px; width: 100%; box-sizing: border-box; background: #f8fafc;">
                        </div>

                        <div class="form-group mb-2">
                            <label style="font-size: 12px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block;">
                                💬 Your Feedback / Suggestion*
                            </label>
                            <textarea name="message" class="form-control" rows="3" placeholder="How was your taxi experience or what would you like improved?" required style="border-radius: 10px; border: 1.5px solid #cbd5e1; padding: 12px 14px; font-size: 13.5px; font-weight: 500; color: #0f172a; width: 100%; box-sizing: border-box; resize: vertical; min-height: 90px; background: #f8fafc;"></textarea>
                        </div>
                    </div>

                    <!-- MODAL FOOTER -->
                    <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button type="button" onclick="$('#sendCabFeedbackModal').modal('hide')" data-dismiss="modal" data-bs-dismiss="modal" style="background: #e2e8f0; color: #475569; border: none; border-radius: 10px; font-weight: 800; padding: 10px 22px; font-size: 13.5px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#cbd5e1'" onmouseout="this.style.background='#e2e8f0'">
                            Cancel
                        </button>
                        <button type="submit" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; border: none; border-radius: 10px; font-weight: 800; padding: 10px 26px; font-size: 14px; cursor: pointer; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                            💬 Send Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script-area')
    <script>
        const activeCabRoutes = @json($cabs);

        function normalizeLoc(s) {
            if (!s) return '';
            var str = s.trim().toLowerCase();
            if (str.indexOf('airport') !== -1 || str.indexOf('ccsi') !== -1) {
                return 'lucknow airport';
            }
            if (str.indexOf('charbagh') !== -1 || str.indexOf('lucknow railway') !== -1) {
                return 'lucknow railway station';
            }
            if (str.indexOf('city tour') !== -1) {
                return 'lucknow city tour';
            }
            if (str.indexOf('barabanki') !== -1 && (str.indexOf('railway') !== -1 || str.indexOf('junction') !== -1)) {
                return 'barabanki railway station';
            }
            if (str.indexOf('bypass') !== -1 || str.indexOf('by-pass') !== -1) {
                return 'barabanki highway by-pass';
            }
            if (str.indexOf('bahraich') !== -1) {
                return 'bahraich sharif';
            }
            if (str.indexOf('bansa') !== -1) {
                return 'bansa sharif';
            }
            if (str.indexOf('dewa') !== -1) {
                return 'dewa sharif';
            }
            return str;
        }

        const HUB_NAME = 'Dewa Sharif';

        function calculateCabFare(pickup, drop, vehicleName) {
            if (!pickup || !drop) return 0;
            var pLow = normalizeLoc(pickup);
            var dLow = normalizeLoc(drop);

            if (pLow === dLow) return 0;
            if (pLow !== 'dewa sharif' && dLow !== 'dewa sharif') return 0;

            var vLow = vehicleName ? vehicleName.trim().toLowerCase() : '';

            // 1. Match route with pickup, drop and vehicle type (both forward & reverse)
            var matched = activeCabRoutes.find(function(r) {
                var rPk = normalizeLoc(r.pickup || '');
                var rDp = normalizeLoc(r.destination || r.drop || '');
                var rType = (r.vehicle_type || r.title || r.vehicle_name || '').trim().toLowerCase();

                var pOk = (rPk === pLow) || rPk.includes(pLow) || pLow.includes(rPk);
                var dOk = (rDp === dLow) || rDp.includes(dLow) || dLow.includes(rDp);
                var vOk = vLow ? ((rType === vLow) || rType.includes(vLow) || vLow.includes(rType)) : true;

                if (pOk && dOk && vOk) return true;

                var revPOk = (rPk === dLow) || rPk.includes(dLow) || dLow.includes(rPk);
                var revDOk = (rDp === pLow) || rDp.includes(pLow) || pLow.includes(rDp);
                if (revPOk && revDOk && vOk) return true;

                return false;
            });

            // 2. If not matched with vehicle, match by pickup and drop only (both directions)
            if (!matched) {
                matched = activeCabRoutes.find(function(r) {
                    var rPk = normalizeLoc(r.pickup || '');
                    var rDp = normalizeLoc(r.destination || r.drop || '');
                    var pOk = (rPk === pLow) || rPk.includes(pLow) || pLow.includes(rPk);
                    var dOk = (rDp === dLow) || rDp.includes(dLow) || dLow.includes(rDp);
                    if (pOk && dOk) return true;

                    var revPOk = (rPk === dLow) || rPk.includes(dLow) || dLow.includes(rPk);
                    var revDOk = (rDp === pLow) || rDp.includes(pLow) || pLow.includes(rDp);
                    return (revPOk && revDOk);
                });
            }

            if (matched && (matched.price || matched.fare)) {
                return Math.round(parseFloat(matched.price || matched.fare));
            }

            // 3. Fallback to vehicle price if set in Admin > Vehicles
            var selectedOpt = $('#vehicle_type_select option:selected');
            var directPrice = parseFloat(selectedOpt.attr('data-price'));

            if (directPrice && !isNaN(directPrice) && directPrice > 0) {
                return Math.round(directPrice);
            }

            return 0;
        }

        function handlePickupDropFilter(source) {
            var selectedPickup = $('#pickup_select').val();
            var selectedDrop = $('#drop_select').val();

            if (source === 'pickup' || !source) {
                if (selectedPickup === HUB_NAME) {
                    // Pickup is Dewa Sharif -> Drop can be ANY outside location, but NOT Dewa Sharif
                    $('#drop_select option').each(function() {
                        if ($(this).val() === HUB_NAME) {
                            $(this).prop('disabled', true).hide();
                        } else {
                            $(this).prop('disabled', false).show();
                        }
                    });
                    $('#pickup_select option').prop('disabled', false).show();

                    // If drop was Dewa Sharif or disabled, switch to first valid outside drop
                    if ($('#drop_select').val() === HUB_NAME || $('#drop_select option:selected').is(':disabled') || $('#drop_select option:selected').css('display') === 'none') {
                        var nextDrop = $('#drop_select option:not(:disabled)').first().val();
                        if (nextDrop) $('#drop_select').val(nextDrop);
                    }
                } else {
                    // Pickup is an OUTSIDE location (e.g. Airport) -> Drop MUST ONLY be Dewa Sharif!
                    $('#drop_select option').each(function() {
                        if ($(this).val() === HUB_NAME) {
                            $(this).prop('disabled', false).show();
                        } else {
                            $(this).prop('disabled', true).hide();
                        }
                    });
                    $('#drop_select').val(HUB_NAME);
                    $('#pickup_select option').prop('disabled', false).show();
                }
            }

            if (source === 'drop') {
                if (selectedDrop === HUB_NAME) {
                    // Drop is Dewa Sharif -> Pickup can be ANY outside location, but NOT Dewa Sharif
                    $('#pickup_select option').each(function() {
                        if ($(this).val() === HUB_NAME) {
                            $(this).prop('disabled', true).hide();
                        } else {
                            $(this).prop('disabled', false).show();
                        }
                    });
                    $('#drop_select option').prop('disabled', false).show();

                    // If pickup was Dewa Sharif or disabled, switch to first valid outside pickup
                    if ($('#pickup_select').val() === HUB_NAME || $('#pickup_select option:selected').is(':disabled') || $('#pickup_select option:selected').css('display') === 'none') {
                        var nextPickup = $('#pickup_select option:not(:disabled)').first().val();
                        if (nextPickup) $('#pickup_select').val(nextPickup);
                    }
                } else {
                    // Drop is an OUTSIDE location (e.g. Airport) -> Pickup MUST ONLY be Dewa Sharif!
                    $('#pickup_select option').each(function() {
                        if ($(this).val() === HUB_NAME) {
                            $(this).prop('disabled', false).show();
                        } else {
                            $(this).prop('disabled', true).hide();
                        }
                    });
                    $('#pickup_select').val(HUB_NAME);
                    $('#drop_select option').prop('disabled', false).show();
                }
            }

            // Guaranteed safety check: at least one side must be Dewa Sharif
            var curP = $('#pickup_select').val();
            var curD = $('#drop_select').val();
            if (curP !== HUB_NAME && curD !== HUB_NAME) {
                $('#pickup_select').val(HUB_NAME);
                $('#drop_select option[value="' + HUB_NAME + '"]').prop('disabled', true).hide();
            }
        }

        function swapPickupDrop() {
            var currentP = $('#pickup_select').val();
            var currentD = $('#drop_select').val();

            if (currentP === currentD) return;

            // Re-enable all options before setting swapped values
            $('#pickup_select option, #drop_select option').prop('disabled', false).show();

            $('#pickup_select').val(currentD);
            $('#drop_select').val(currentP);

            if (currentD === HUB_NAME) {
                handlePickupDropFilter('pickup');
            } else {
                handlePickupDropFilter('drop');
            }

            updateLiveFare();
        }

        function updateLiveFare(source) {
            handlePickupDropFilter(source);
            var pickup = $('#pickup_select').val();
            var drop = $('#drop_select').val();
            var vehicle = $('#vehicle_type_select').val();

            var fare = calculateCabFare(pickup, drop, vehicle);

            if (fare > 0) {
                $('#liveFareBadge').html('Estimated Fare: ₹' + fare.toLocaleString('en-IN'));
                $('#liveFareBadge').css({ 'background': '#ecfdf5', 'color': '#047857', 'border-color': '#a7f3d0' });
                $('#btnGetFareBook').html('Get Fare &amp; Book Cabs').prop('disabled', false).css('background', '#074121');
            } else {
                $('#liveFareBadge').html('Custom Quote on WhatsApp');
                $('#liveFareBadge').css({ 'background': '#fef3c7', 'color': '#b45309', 'border-color': '#fde68a' });
                $('#btnGetFareBook').html('Contact on WhatsApp for Fare').prop('disabled', false).css('background', '#166534');
            }
        }

        function openCabBookingModal() {
            var pickup = $('#pickup_select').val();
            var drop = $('#drop_select').val();
            var vehicle = $('#vehicle_type_select').val();

            if (!pickup || !drop) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Location Missing', text: 'Kripya Pickup aur Drop location select karein!' });
                } else {
                    alert('Kripya Pickup aur Drop location select karein!');
                }
                return;
            }

            if (normalizeLoc(pickup) === normalizeLoc(drop)) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Invalid Selection', text: 'Pickup aur Drop location same nahi ho sakti! Kripya alag alag location chunein.' });
                } else {
                    alert('Pickup aur Drop location same nahi ho sakti! Kripya alag alag location chunein.');
                }
                return;
            }

            if (normalizeLoc(pickup) !== 'dewa sharif' && normalizeLoc(drop) !== 'dewa sharif') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Dewa Sharif Route Required', text: 'Cab service ke liye Pickup ya Drop me se ek jagah Dewa Sharif hona zaroori hai!' });
                } else {
                    alert('Cab service ke liye Pickup ya Drop me se ek jagah Dewa Sharif hona zaroori hai!');
                }
                return;
            }

            var fare = calculateCabFare(pickup, drop, vehicle);

            if (fare <= 0) {
                var text = "Assalamu Alaikum Dewa Sharif Cabs!\n\n" +
                           "Main Cab book karna chahta hun:\n" +
                           "📍 Pickup: " + pickup + "\n" +
                           "📍 Drop: " + drop + "\n" +
                           "🚕 Vehicle: " + (vehicle || 'Standard Taxi') + "\n\n" +
                           "Kripya is route ka fare aur availability confirm karein. Shukriya!";
                window.open("https://wa.me/919648777223?text=" + encodeURIComponent(text), '_blank');
                return;
            }

            $.post("{{ route('cabs.checkout.init') }}", {
                _token: "{{ csrf_token() }}",
                pickup: pickup,
                drop: drop,
                vehicle: vehicle,
                fare: fare
            }, function(response) {
                if (response && response.redirect_url) {
                    window.location.href = response.redirect_url;
                } else {
                    window.location.href = "{{ route('cabs.checkout') }}";
                }
            }).fail(function() {
                window.location.href = "{{ route('cabs.checkout') }}";
            });
        }

        function presetCabBooking(pickup, drop, vehicle, fare) {
            $.post("{{ route('cabs.checkout.init') }}", {
                _token: "{{ csrf_token() }}",
                pickup: pickup,
                drop: drop,
                vehicle: vehicle,
                fare: fare
            }, function(response) {
                window.location.href = response.redirect_url || "{{ route('cabs.checkout') }}";
            }).fail(function() {
                window.location.href = "{{ route('cabs.checkout') }}";
            });
        }

        function submitCustomWhatsAppRoute() {
            var pickup = ($('#custom_pickup').val() || '').trim();
            var drop = ($('#custom_drop').val() || '').trim();
            var vehicle = ($('#custom_vehicle').val() || '').trim() || 'Any Suitable Cab / Taxi';

            if (!pickup || !drop) {
                alert('Kripya Pickup Point aur Destination Place type karein!');
                return;
            }

            var text = "Assalamu Alaikum Sir!\n\n" +
                "I want to book a Custom Route Taxi / Cab from dewasharif.com:\n" +
                "📍 Custom Pickup: " + pickup + "\n" +
                "📍 Custom Destination: " + drop + "\n" +
                "🚕 Vehicle Preferred: " + vehicle + "\n\n" +
                "Please let me know the best quote fare and availability. Thank you!";
            
            var waUrl = "https://wa.me/919648777223?text=" + encodeURIComponent(text);
            window.open(waUrl, '_blank');

            $.post("{{ route('cabs.custom-enquiry') }}", {
                _token: "{{ csrf_token() }}",
                pickup: pickup,
                drop: drop,
                vehicle: vehicle
            });
        }

        function openCabReviewModal() {
            $('#writeCabReviewModal').modal('show');
        }

        function openCabFeedbackModal() {
            $('#sendCabFeedbackModal').modal('show');
        }

        function submitCabReview(e) {
            e.preventDefault();
            var form = e.target;
            var submitBtn = $(form).find('button[type="submit"]');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Submitting...');

            var formData = new FormData(form);
            var dataObj = {};
            formData.forEach(function(val, key) { dataObj[key] = val; });

            fetch("{{ route('reviews.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify(dataObj)
            })
            .then(function(res) { return res.json(); })
            .then(function(res) {
                submitBtn.prop('disabled', false).text(originalText);
                if (res.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Review Submitted!',
                            text: res.message,
                            confirmButtonColor: '#074121'
                        }).then(function() {
                            $('#writeCabReviewModal').modal('hide');
                            form.reset();
                            location.reload();
                        });
                    } else {
                        alert('🎉 ' + res.message);
                        $('#writeCabReviewModal').modal('hide');
                        form.reset();
                        location.reload();
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'error', title: 'Oops...', text: res.message || 'Error submitting review' });
                    } else {
                        alert('❌ ' + (res.message || 'Error submitting review'));
                    }
                }
            })
            .catch(function(err) {
                submitBtn.prop('disabled', false).text(originalText);
                alert('Server error while submitting review.');
            });
        }

        function submitCabFeedback(e) {
            e.preventDefault();
            var form = e.target;
            var submitBtn = $(form).find('button[type="submit"]');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Sending...');

            var formData = new FormData(form);
            var dataObj = {};
            formData.forEach(function(val, key) { dataObj[key] = val; });

            fetch("{{ route('feedback.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify(dataObj)
            })
            .then(function(res) { return res.json(); })
            .then(function(res) {
                submitBtn.prop('disabled', false).text(originalText);
                if (res.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Feedback Sent!',
                            text: res.message,
                            confirmButtonColor: '#074121'
                        }).then(function() {
                            $('#sendCabFeedbackModal').modal('hide');
                            form.reset();
                        });
                    } else {
                        alert('🎉 ' + res.message);
                        $('#sendCabFeedbackModal').modal('hide');
                        form.reset();
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'error', title: 'Oops...', text: res.message || 'Error sending feedback' });
                    } else {
                        alert('❌ ' + (res.message || 'Error sending feedback'));
                    }
                }
            })
            .catch(function() {
                submitBtn.prop('disabled', false).text(originalText);
                alert('Server error while sending feedback.');
            });
        }

        $(document).ready(function () {
            var selectedVeh = $('#vehicle_type_select').val();
            if (!selectedVeh || selectedVeh.toLowerCase().indexOf('ertiga') === -1) {
                $('#vehicle_type_select option').each(function() {
                    if ($(this).val().toLowerCase().indexOf('ertiga') !== -1) {
                        $('#vehicle_type_select').val($(this).val());
                        return false;
                    }
                });
            }
            updateLiveFare();
        });
        window.addEventListener('load', function() { updateLiveFare(); });
        document.addEventListener('DOMContentLoaded', function() { updateLiveFare(); });
        setTimeout(function() { updateLiveFare(); }, 200);
    </script>

@endsection