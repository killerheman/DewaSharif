@extends('home.includes.master')

@section('content')
    <div style="background: #f1f5f9; padding: 40px 0 70px 0; min-height: 85vh;">
        <div class="container">

            <div style="margin-bottom: 25px;">
                <a href="{{ route('cabs') }}" class="btn btn-sm btn-outline-secondary font-weight-bold"
                    style="border-radius: 6px;">
                    ← Back to Cabs Landing Page
                </a>
            </div>

            <div class="row g-4">

                <!-- LEFT COLUMN: RIDE SUMMARY & FARE BREAKDOWN -->
                <div class="col-md-5 col-12 mb-4">
                    <div
                        style="background: #ffffff; border-radius: 16px; padding: 28px; border: 1.5px solid #cbd5e1; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                        <span
                            style="background: #f59e0b; color: #111827; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 900; text-transform: uppercase;">
                            🚕 Cabs Summary
                        </span>

                        <h3
                            style="font-weight: 900; color: #0f172a; margin-top: 12px; margin-bottom: 6px; font-size: 22px;">
                            {{ $vehicle }}
                        </h3>

                        <p
                            style="font-size: 13.5px; color: #64748b; margin-bottom: 20px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 15px;">
                            Fixed fare station &amp; airport dispatch package under dewasharif.com
                        </p>

                        <div style="margin-bottom: 16px;">
                            <span
                                style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 2px;">📍
                                Pickup Location:</span>
                            <strong style="font-size: 14.5px; color: #0f172a;">{{ $pickup }}</strong>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <span
                                style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 2px;">📍
                                Destination Drop:</span>
                            <strong style="font-size: 14.5px; color: #0f172a;">{{ $drop }}</strong>
                        </div>

                        <div
                            style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 18px; margin-top: 20px;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-size: 13.5px; color: #475569; font-weight: 600;">Selected Vehicles:</span>
                                <strong style="font-size: 14.5px; color: #052c16;"><span id="display_left_cab_qty">1</span> Cab(s)</strong>
                            </div>
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-size: 13.5px; color: #475569; font-weight: 600;">Base Package Fare:</span>
                                <strong style="font-size: 15px; color: #0f172a;">₹<span
                                        id="display_base_fare">{{ number_format($fare) }}</span></strong>
                            </div>
                            <div id="night_surcharge_row"
                                style="display: none; justify-content: space-between; align-items: center; margin-bottom: 8px; background: #fef2f2; padding: 6px 10px; border-radius: 6px; border: 1px solid #fecaca;">
                                <span style="font-size: 13px; color: #dc2626; font-weight: 800;">🌙 Night Travel Surcharge
                                    (10 PM - 5 AM):</span>
                                <strong style="font-size: 14.5px; color: #dc2626;">+₹<span id="display_night_surcharge">100</span></strong>
                            </div>
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-size: 13.5px; color: #475569; font-weight: 600;">Luggage &amp; Toll
                                    Assistance:</span>
                                <strong style="font-size: 13.5px; color: #16a34a;">INCLUDED</strong>
                            </div>
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 10px;">
                                <span style="font-size: 16px; color: #0f172a; font-weight: 900;">Total Payable:</span>
                                <span style="font-size: 24px; color: #052c16; font-weight: 900;">₹<span
                                        id="display_total_fare">{{ number_format($fare) }}</span></span>
                            </div>
                        </div>

                        <!-- AIRPORT & SIGHTSEEING PARKING INSTRUCTION NOTE -->
                        @php
                            $parkingPol = \App\Helpers\DataStore::getItem('cab_parking_policy', 1) ?? ['status' => 'Active'];
                            $isPolActive = ($parkingPol['status'] ?? 'Active') === 'Active';
                            $pLow = strtolower($pickup);
                            $dLow = strtolower($drop);
                            $isAirport = str_contains($pLow, 'airport') || str_contains($dLow, 'airport') || str_contains($pLow, 'ccsi') || str_contains($dLow, 'ccsi');
                            $isSightseeing = str_contains($pLow, 'tour') || str_contains($dLow, 'tour') || str_contains($pLow, 'sightseeing') || str_contains($dLow, 'sightseeing') || str_contains($pLow, 'city') || str_contains($dLow, 'city');
                        @endphp

                        @if($isPolActive)
                            <div
                                style="background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; padding: 16px; margin-top: 18px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.08);">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    <span style="font-size: 18px;">🅿️</span>
                                    <strong
                                        style="color: #92400e; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px;">Important
                                        Parking Policy Instruction</strong>
                                </div>
                                <ul
                                    style="margin: 0; padding-left: 20px; color: #78350f; font-size: 12.5px; font-weight: 600; line-height: 1.6;">
                                    @if($isAirport)
                                        <li style="margin-bottom: 4px;"><strong>✈️ Airport Duty:</strong>
                                            {{ $parkingPol['airport_note'] ?? 'Airport entry & waiting: Initial 10 minutes free. Exceeding 10 mins parking charges payable by passenger directly as per actual airport parking receipt.' }}
                                        </li>
                                    @endif
                                    @if($isSightseeing)
                                        <li style="margin-bottom: 4px;"><strong>🏛️ Sightseeing Tour:</strong>
                                            {{ $parkingPol['sightseeing_note'] ?? 'City Sightseeing Tour: Historical monument & tourist spot parking charges payable by passenger as per actual receipt.' }}
                                        </li>
                                    @endif
                                    @if(!$isAirport && !$isSightseeing)
                                        <li style="margin-bottom: 4px;"><strong>Airport / Monument Parking:</strong> Airport entry
                                            includes initial 10 mins free. Extra airport waiting or monument sightseeing parking
                                            charges are payable directly by passenger as per actual receipt.</li>
                                    @endif
                                    <li
                                        style="color: #b45309; font-size: 11.5px; list-style-type: none; margin-left: -20px; margin-top: 6px;">
                                        <em>*Yeh parking charge online billing fare mein shamil nahi hai, yeh actual receipt par
                                            passenger directly driver/toll par pay karega.</em>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN: PASSENGER DETAILS & PAYMENT CHECKOUT -->
                <div class="col-md-7 col-12">
                    <div
                        style="background: #ffffff; border-radius: 16px; padding: 32px; border: 1.5px solid #cbd5e1; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                        <h4 style="font-weight: 900; color: #0f172a; margin-bottom: 6px; font-size: 20px;">
                            👤 Passenger &amp; Pickup Details
                        </h4>
                        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 24px;">
                            Enter passenger contact &amp; Govt ID info for slip assignment.
                        </p>

                        <form id="cabCheckoutForm">
                            <input type="hidden" id="chk_pickup" value="{{ $pickup }}">
                            <input type="hidden" id="chk_drop" value="{{ $drop }}">
                            <input type="hidden" id="chk_vehicle" value="{{ $vehicle }}">
                            <input type="hidden" id="chk_base_fare" value="{{ $fare }}">
                            <input type="hidden" id="chk_fare" value="{{ $fare }}">
                            <input type="hidden" id="chk_cab_qty" value="1">

                            <!-- CAB QUANTITY SELECTOR (ADD / REMOVE VEHICLES) -->
                            <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                                <div>
                                    <label style="font-size: 13.5px; font-weight: 800; color: #166534; margin: 0; display: flex; align-items: center; gap: 6px;">
                                        <span>🚕</span> Number of Cabs / Vehicles
                                    </label>
                                    <small style="color: #15803d; font-size: 12px; font-weight: 600;">(Agar aapke saath zyada family members ya group hai to zyada gaadi select karein)</small>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; background: #ffffff; padding: 4px; border-radius: 10px; border: 1.5px solid #bbf7d0;">
                                    <button type="button" onclick="changeCabQty(-1)" class="btn btn-sm btn-light" style="width: 36px; height: 36px; border-radius: 8px; font-weight: 900; font-size: 18px; line-height: 1; border: 1px solid #cbd5e1; color: #0f172a; display: flex; align-items: center; justify-content: center; background: #f8fafc; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'">−</button>
                                    <span id="display_cab_qty" style="min-width: 38px; text-align: center; font-size: 17px; font-weight: 900; color: #052c16;">1</span>
                                    <button type="button" onclick="changeCabQty(1)" class="btn btn-sm btn-light" style="width: 36px; height: 36px; border-radius: 8px; font-weight: 900; font-size: 18px; line-height: 1; border: 1px solid #cbd5e1; color: #0f172a; display: flex; align-items: center; justify-content: center; background: #f8fafc; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'">+</button>
                                </div>
                            </div>

                            <!-- ROW 1: PASSENGER NAME & MOBILE -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6 col-12">
                                    <label
                                        style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">👤
                                        Passenger Full Name <span style="color: #ef4444;">*</span></label>
                                    <input type="text" id="chk_name" class="form-control"
                                        value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                        placeholder="Enter Passenger Full Name" required minlength="2"
                                        style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label
                                        style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📱
                                        Mobile Number <span style="color: #ef4444;">*</span></label>
                                    <input type="tel" id="chk_phone" class="form-control"
                                        value="{{ auth()->check() ? (auth()->user()->phone ?? auth()->user()->mobile ?? '') : '' }}"
                                        placeholder="10-digit Mobile (e.g. 9876543210)" required maxlength="10"
                                        pattern="[0-9]{10}"
                                        style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                                </div>
                            </div><br>
                            <input type="hidden" id="chk_alt_phone" value="">

                            <!-- ROW 2: PICKUP DATE & PICKUP TIME -->
                            <div class="row g-3 mb-3 align-items-center">
                                <div class="col-md-6 col-12">
                                    <label
                                        style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📅
                                        Pickup Date <span style="color: #ef4444;">*</span></label>
                                    <input type="date" id="chk_date" class="form-control" required
                                        style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label
                                        style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">⏰
                                        Pickup Time <span style="color: #ef4444;">*</span></label>
                                    <select id="chk_time" onchange="recalculateCabCheckoutFare()" class="form-control"
                                        required
                                        style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 13.5px; background-color: #ffffff;">
                                        <!-- MORNING / DAY TIMINGS -->
                                        <option value="05:00 AM" selected>05:00 AM (Standard Day Fare)</option>
                                        <option value="05:30 AM">05:30 AM (Standard Day Fare)</option>
                                        <option value="06:00 AM">06:00 AM (Standard Day Fare)</option>
                                        <option value="06:30 AM">06:30 AM (Standard Day Fare)</option>
                                        <option value="07:00 AM">07:00 AM (Standard Day Fare)</option>
                                        <option value="07:30 AM">07:30 AM (Standard Day Fare)</option>
                                        <option value="08:00 AM">08:00 AM (Standard Day Fare)</option>
                                        <option value="08:30 AM">08:30 AM (Standard Day Fare)</option>
                                        <option value="09:00 AM">09:00 AM (Standard Day Fare)</option>
                                        <option value="09:30 AM">09:30 AM (Standard Day Fare)</option>
                                        <option value="10:00 AM">10:00 AM (Standard Day Fare)</option>
                                        <option value="10:30 AM">10:30 AM (Standard Day Fare)</option>
                                        <option value="11:00 AM">11:00 AM (Standard Day Fare)</option>
                                        <option value="11:30 AM">11:30 AM (Standard Day Fare)</option>

                                        <!-- AFTERNOON / EVENING TIMINGS -->
                                        <option value="12:00 PM">12:00 PM Noon (Standard Day Fare)</option>
                                        <option value="12:30 PM">12:30 PM (Standard Day Fare)</option>
                                        <option value="01:00 PM">01:00 PM (Standard Day Fare)</option>
                                        <option value="01:30 PM">01:30 PM (Standard Day Fare)</option>
                                        <option value="02:00 PM">02:00 PM (Standard Day Fare)</option>
                                        <option value="02:30 PM">02:30 PM (Standard Day Fare)</option>
                                        <option value="03:00 PM">03:00 PM (Standard Day Fare)</option>
                                        <option value="03:30 PM">03:30 PM (Standard Day Fare)</option>
                                        <option value="04:00 PM">04:00 PM (Standard Day Fare)</option>
                                        <option value="04:30 PM">04:30 PM (Standard Day Fare)</option>
                                        <option value="05:00 PM">05:00 PM (Standard Day Fare)</option>
                                        <option value="05:30 PM">05:30 PM (Standard Day Fare)</option>
                                        <option value="06:00 PM">06:00 PM (Standard Day Fare)</option>
                                        <option value="06:30 PM">06:30 PM (Standard Day Fare)</option>
                                        <option value="07:00 PM">07:00 PM (Standard Day Fare)</option>
                                        <option value="07:30 PM">07:30 PM (Standard Day Fare)</option>
                                        <option value="08:00 PM">08:00 PM (Standard Day Fare)</option>
                                        <option value="08:30 PM">08:30 PM (Standard Day Fare)</option>
                                        <option value="09:00 PM">09:00 PM (Standard Day Fare)</option>
                                        <option value="09:30 PM">09:30 PM (Standard Day Fare)</option>

                                        <!-- NIGHT SERVICE TIMINGS (+$100 Night Charge) -->
                                        <option value="10:00 PM">10:00 PM (🌙 Night Service Charge +₹100)</option>
                                        <option value="10:30 PM">10:30 PM (🌙 Night Service Charge +₹100)</option>
                                        <option value="11:00 PM">11:00 PM (🌙 Night Service Charge +₹100)</option>
                                        <option value="11:30 PM">11:30 PM (🌙 Night Service Charge +₹100)</option>
                                        <option value="12:00 AM">12:00 AM Midnight (🌙 Night Service Charge +₹100)</option>
                                        <option value="12:30 AM">12:30 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="01:00 AM">01:00 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="01:30 AM">01:30 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="02:00 AM">02:00 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="02:30 AM">02:30 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="03:00 AM">03:00 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="03:30 AM">03:30 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="04:00 AM">04:00 AM (🌙 Night Service Charge +₹100)</option>
                                        <option value="04:30 AM">04:30 AM (🌙 Night Service Charge +₹100)</option>
                                    </select>
                                </div>
                            </div><br>

                            <!-- ROW 3: GOVT APPROVED ID TYPE & ID NUMBER -->
                            <div class="row g-3 mb-2">
                                <div class="col-md-6 col-12">
                                    <label
                                        style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🪪
                                        Govt Approved ID Type <span style="color: #ef4444;">*</span></label>
                                    <select id="chk_id_type" onchange="handleIdTypeChange()" class="form-control" required
                                        style="border-radius: 8px; height: 46px; font-weight: 600; font-size: 14px; border: 1.5px solid #cbd5e1; background-color: #ffffff;">
                                        <option value="Aadhaar Card" selected>Aadhaar Card</option>
                                        <option value="PAN Card">PAN Card</option>
                                        <option value="Voter ID Card">Voter ID Card</option>
                                        <option value="Driving License">Driving License</option>
                                        <option value="Passport">Passport</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label
                                        style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🔢
                                        Govt ID Number <span style="color: #ef4444;">*</span></label>
                                    <input type="text" id="chk_id_no" oninput="formatIdInput(this)"
                                        onblur="validateCurrentId(true)" class="form-control" value=""
                                        placeholder="12-digit Aadhaar (e.g. 5482 9102 3841)" required maxlength="14"
                                        style="border-radius: 8px; height: 46px; font-weight: 600; font-size: 14px; border: 1.5px solid #cbd5e1; letter-spacing: 0.5px;">
                                    <small id="idHelpText"
                                        style="display: block; font-size: 11px; font-weight: 700; color: #64748b; margin-top: 4px;">
                                        Format: 12-digit number (e.g. 5482 9102 3841)
                                    </small>
                                </div>
                                <div class="col-md-12 col-12" style="margin-top: 16px !important;">
                                    <div
                                        style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 16px;">🪪</span>
                                        <span style="font-size: 12px; font-weight: 700; color: #166534; line-height: 1.4;">
                                            <strong>Boarding Rule:</strong> "Passengers must show the same original
                                            government-issued ID to the driver before boarding the vehicle (required for
                                            police and toll verification)."
                                        </span>
                                    </div>
                                </div>
                            </div><br>

                            <!-- TERMS & CANCELLATION AGREEMENT CHECKBOX -->
                            <div class="mb-4" style="padding-left: 4px;">
                                <div class="form-check" style="display: flex; align-items: flex-start; gap: 10px;">
                                    <input class="form-check-input" type="checkbox" id="termsAgree" required checked
                                        style="width: 19px; height: 19px; cursor: pointer; margin-top: 2px;">
                                    <label class="form-check-label" for="termsAgree"
                                        style="font-size: 12.5px; color: #334155; cursor: pointer; font-weight: 600; line-height: 1.45;">
                                        "I agree to dewasharif.com Cabs Terms &amp; Mela Periods Refund Policy (50% refund
                                        prior to 2 days, 15% refund within 2 days of booking, and 10% refund for same-day
                                        booking cancellations)." <span style="color: #ef4444;">*</span>
                                    </label>
                                </div>
                            </div>

                            <!-- ACTION BUTTONS CONTAINER -->
                            <div
                                style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 20px;">
                                <span
                                    style="font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 14px;">
                                    Confirm &amp; Proceed:
                                </span>

                                <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
                                    <!-- BUTTON 1: RAZORPAY ONLINE PAYMENT (DISABLED - COMING SOON) -->
                                    <button type="button" id="btnChkPay" disabled
                                        class="btn w-100"
                                        style="background: #f1f5f9; color: #64748b; font-weight: 700; border-radius: 8px; padding: 13px; font-size: 14px; border: 1.5px dashed #cbd5e1; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 8px; opacity: 0.9;"
                                        title="Online Gateway verification underway. Please use UPI QR.">
                                        <i class="fa fa-credit-card" style="font-size: 16px; color: #94a3b8;"></i>
                                        <span>Pay Online (Razorpay / Cards) — ₹<span id="btnPayOnlineAmount">{{ number_format($fare) }}</span></span>
                                        <span class="badge" style="background: #f59e0b; color: #111; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px; text-transform: uppercase;">Soon</span>
                                    </button>

                                    <!-- BUTTON 2: PHONEPE / UPI QR CODE PAYMENT (DEFAULT & PRIMARY) -->
                                    <button type="button" id="btnChkQr" onclick="openCabQrModal()"
                                        class="btn w-100 font-extrabold"
                                        style="background: #052c16; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 14px; font-size: 15px; border: none; box-shadow: 0 4px 14px rgba(5, 44, 22, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px;">
                                        <i class="fa fa-qrcode" style="font-size: 20px; color: #4ade80;"></i>
                                        Pay via UPI QR (PhonePe / GPay / Paytm) — ₹<span id="btnPayQrAmount">{{ number_format($fare) }}</span>
                                    </button>

                                    <!-- BUTTON 3: DIRECT COMPANY WHATSAPP CHAT -->
                                    <button type="button" onclick="processCabCheckoutWhatsApp()"
                                        class="btn w-100 font-extrabold"
                                        style="background: #25D366; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 14px; font-size: 14.5px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
                                        <i class="fa fa-whatsapp" style="font-size: 20px;"></i>
                                        Book Cabs via WhatsApp
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- RAZORPAY CHECKOUT SDK -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        function isNightTime(timeStr) {
            if (!timeStr) return false;
            timeStr = timeStr.trim().toLowerCase();
            var hour = -1;
            var isPM = timeStr.includes('pm');
            var isAM = timeStr.includes('am');

            var match = timeStr.match(/(\d{1,2}):?(\d{2})?/);
            if (match) {
                hour = parseInt(match[1]);
                if (isPM && hour < 12) hour += 12;
                if (isAM && hour === 12) hour = 0;
            }

            return (hour >= 22 || (hour >= 0 && hour < 5));
        }

        function changeCabQty(delta) {
            var cur = parseInt($('#chk_cab_qty').val()) || 1;
            var next = cur + delta;
            if (next < 1) next = 1;
            if (next > 10) next = 10;
            $('#chk_cab_qty').val(next);
            $('#display_cab_qty').text(next);
            $('#display_left_cab_qty').text(next);
            recalculateCabCheckoutFare();
        }

        function recalculateCabCheckoutFare() {
            var singleBaseFare = parseFloat($('#chk_base_fare').val()) || 1400;
            var qty = parseInt($('#chk_cab_qty').val()) || 1;
            var timeVal = $('#chk_time').val();
            var nightPerCab = 0;

            if (isNightTime(timeVal)) {
                nightPerCab = 100;
                $('#night_surcharge_row').css('display', 'flex');
                $('#display_night_surcharge').text((nightPerCab * qty).toLocaleString('en-IN') + (qty > 1 ? ' (' + qty + ' Cabs)' : ''));
            } else {
                $('#night_surcharge_row').hide();
            }

            var totalBaseFare = singleBaseFare * qty;
            var totalNight = nightPerCab * qty;
            var totalFare = totalBaseFare + totalNight;

            $('#chk_fare').val(totalFare);
            $('#display_base_fare').text(totalBaseFare.toLocaleString('en-IN') + (qty > 1 ? ' (' + qty + ' × ₹' + singleBaseFare.toLocaleString('en-IN') + ')' : ''));
            $('#display_total_fare').text(totalFare.toLocaleString('en-IN'));
            $('#btnPayOnlineAmount').text(totalFare.toLocaleString('en-IN'));
            $('#btnPayQrAmount').text(totalFare.toLocaleString('en-IN'));

            var formattedTotal = '₹' + totalFare.toLocaleString('en-IN');
            if ($('#cabQrPayAmountText').length) $('#cabQrPayAmountText').text(formattedTotal);
            if ($('#cabDirectUpiAmount').length) $('#cabDirectUpiAmount').text(formattedTotal);
            if (typeof generateDynamicUpi === 'function') {
                var upiData = generateDynamicUpi(totalFare, 'Dewa Sharif Cab Booking (' + qty + ' Cabs)');
                if ($('#cabDynamicQrImg').length) $('#cabDynamicQrImg').attr('src', upiData.qr);
                if ($('#cabDirectUpiBtn').length) $('#cabDirectUpiBtn').attr('href', upiData.uri);
            }
        }

        $(document).ready(function () {
            var today = new Date().toISOString().split('T')[0];
            $('#chk_date').val(today);
            recalculateCabCheckoutFare();

            // Enforce 10 digits only on mobile number input
            $('#chk_phone').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            });
        });

        function showCabValidationAlert(msg, fieldSelector) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required Field Missing',
                    text: msg,
                    confirmButtonColor: '#052c16'
                }).then(function () {
                    if (fieldSelector) {
                        var el = $(fieldSelector);
                        el.focus();
                        el.css('border', '2px solid #ef4444');
                        setTimeout(function () {
                            el.css('border', '1.5px solid #cbd5e1');
                        }, 3500);
                    }
                });
            } else {
                alert('⚠️ ' + msg);
                if (fieldSelector) {
                    $(fieldSelector).focus();
                }
            }
        }

        // Verhoeff Algorithm for Aadhaar Checksum Validation
        function validateVerhoeffAadhaar(aadhaarString) {
            var clean = (aadhaarString || '').replace(/[\s-]/g, '');
            if (!/^\d{12}$/.test(clean)) return false;
            if (clean[0] === '0' || clean[0] === '1') return false;
            if (/^(\d)\1{11}$/.test(clean)) return false;

            var d = [
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
                [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
                [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
                [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
                [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
                [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
                [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
                [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
                [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]
            ];
            var p = [
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
                [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
                [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
                [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
                [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
                [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
                [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]
            ];

            var c = 0;
            var invertedArray = clean.split('').reverse();
            for (var i = 0; i < invertedArray.length; i++) {
                c = d[c][p[(i % 8)][parseInt(invertedArray[i], 10)]];
            }
            return (c === 0);
        }

        function handleIdTypeChange() {
            var type = $('#chk_id_type').val();
            var el = $('#chk_id_no');
            var help = $('#idHelpText');
            el.val('');
            el.css('border', '1.5px solid #cbd5e1');

            if (type === 'Aadhaar Card') {
                el.attr('placeholder', '12-digit Aadhaar (e.g. 5482 9102 3841)');
                el.attr('maxlength', '14');
                help.text('Format: 12-digit number (e.g. 5482 9102 3841)').css('color', '#64748b');
            } else if (type === 'PAN Card') {
                el.attr('placeholder', '10-character PAN (e.g. ABCDE1234F)');
                el.attr('maxlength', '10');
                help.text('Format: 5 letters + 4 digits + 1 letter (e.g. ABCDE1234F)').css('color', '#64748b');
            } else if (type === 'Voter ID Card') {
                el.attr('placeholder', 'Voter ID (EPIC) (e.g. ABC1234567)');
                el.attr('maxlength', '12');
                help.text('Format: 3 letters + 7 digits (e.g. ABC1234567)').css('color', '#64748b');
            } else if (type === 'Driving License') {
                el.attr('placeholder', 'Driving License (e.g. UP3220180012345)');
                el.attr('maxlength', '16');
                help.text('Format: State code + DL number (e.g. UP3220180012345)').css('color', '#64748b');
            } else if (type === 'Passport') {
                el.attr('placeholder', 'Passport Number (e.g. A1234567)');
                el.attr('maxlength', '9');
                help.text('Format: 1 letter + 7-8 digits (e.g. A1234567)').css('color', '#64748b');
            }
        }

        function formatIdInput(input) {
            var type = $('#chk_id_type').val();
            var val = input.value;

            if (type === 'Aadhaar Card') {
                var digits = val.replace(/\D/g, '').substring(0, 12);
                var parts = [];
                for (var i = 0; i < digits.length; i += 4) {
                    parts.push(digits.substring(i, i + 4));
                }
                input.value = parts.join(' ');
            } else {
                input.value = val.toUpperCase().replace(/[^A-Z0-9]/g, '');
            }
        }

        function validateCurrentId(showVisualOnly) {
            var type = $('#chk_id_type').val();
            var raw = ($('#chk_id_no').val() || '').trim();
            var clean = raw.replace(/\s+/g, '');
            var el = $('#chk_id_no');
            var help = $('#idHelpText');

            if (!clean) {
                if (showVisualOnly) {
                    el.css('border', '1.5px solid #cbd5e1');
                }
                return { valid: false, message: 'Kripya Govt ID Number darj karein!' };
            }

            if (type === 'Aadhaar Card') {
                if (clean.length !== 12) {
                    if (showVisualOnly) {
                        el.css('border', '2px solid #ef4444');
                        help.text('⚠️ Aadhaar number me poore 12 digits hone chahiye!').css('color', '#ef4444');
                    }
                    return { valid: false, message: 'Aadhaar Card me poore 12-digits hone chahiye (format: XXXX XXXX XXXX)!' };
                }
                if (!validateVerhoeffAadhaar(clean)) {
                    if (showVisualOnly) {
                        el.css('border', '2px solid #ef4444');
                        help.text('⚠️ Invalid Aadhaar number! Kripya apna sahi 12-digit Aadhaar number check karein.').css('color', '#ef4444');
                    }
                    return { valid: false, message: 'Darj kiya gaya Aadhaar number invalid lag raha hai! Kripya apna sahi 12-digit Aadhaar number check karein.' };
                }
            } else if (type === 'PAN Card') {
                if (!/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(clean)) {
                    if (showVisualOnly) {
                        el.css('border', '2px solid #ef4444');
                        help.text('⚠️ Invalid PAN! Format: 5 letters + 4 digits + 1 letter (e.g. ABCDE1234F)').css('color', '#ef4444');
                    }
                    return { valid: false, message: 'Kripya valid PAN Card number darj karein (e.g. ABCDE1234F)!' };
                }
            } else if (type === 'Voter ID Card') {
                if (clean.length < 8 || clean.length > 12) {
                    if (showVisualOnly) {
                        el.css('border', '2px solid #ef4444');
                        help.text('⚠️ Invalid Voter ID! e.g. ABC1234567').css('color', '#ef4444');
                    }
                    return { valid: false, message: 'Kripya valid Voter ID (EPIC) number darj karein (e.g. ABC1234567)!' };
                }
            } else if (type === 'Driving License') {
                if (clean.length < 10 || clean.length > 16) {
                    if (showVisualOnly) {
                        el.css('border', '2px solid #ef4444');
                        help.text('⚠️ Invalid Driving License number! e.g. UP3220180012345').css('color', '#ef4444');
                    }
                    return { valid: false, message: 'Kripya valid Driving License number darj karein (e.g. UP3220180012345)!' };
                }
            } else if (type === 'Passport') {
                if (!/^[A-Z]{1}[0-9]{7,8}$/.test(clean)) {
                    if (showVisualOnly) {
                        el.css('border', '2px solid #ef4444');
                        help.text('⚠️ Invalid Passport! Format: 1 letter + 7 digits (e.g. A1234567)').css('color', '#ef4444');
                    }
                    return { valid: false, message: 'Kripya valid Passport number darj karein (e.g. A1234567)!' };
                }
            }

            el.css('border', '2px solid #16a34a');
            help.text('✔ Valid ' + type + ' format').css('color', '#16a34a');
            return { valid: true };
        }

        function validateCabCheckoutForm() {
            var name = ($('#chk_name').val() || '').trim();
            var phone = ($('#chk_phone').val() || '').trim().replace(/[^0-9]/g, '');
            var date = ($('#chk_date').val() || '').trim();
            var time = ($('#chk_time').val() || '').trim();
            var idType = ($('#chk_id_type').val() || '').trim();
            var idNo = ($('#chk_id_no').val() || '').trim();
            var termsChecked = $('#termsAgree').is(':checked');

            if (!name || name.length < 2) {
                showCabValidationAlert('Kripya Passenger Full Name darj karein!', '#chk_name');
                return false;
            }

            if (!phone || phone.length !== 10) {
                showCabValidationAlert('Kripya valid 10-digit Mobile Number darj karein!', '#chk_phone');
                return false;
            }

            if (!date) {
                showCabValidationAlert('Kripya Pickup Date select karein!', '#chk_date');
                return false;
            }

            if (!time) {
                showCabValidationAlert('Kripya Pickup Time select karein!', '#chk_time');
                return false;
            }

            if (!idType) {
                showCabValidationAlert('Kripya Govt Approved ID Type select karein!', '#chk_id_type');
                return false;
            }

            var idCheck = validateCurrentId(false);
            if (!idCheck.valid) {
                showCabValidationAlert(idCheck.message, '#chk_id_no');
                return false;
            }

            if (!termsChecked) {
                showCabValidationAlert('Kripya Terms & Mela Periods Refund Policy checkbox ko agree (tick) karein!', '#termsAgree');
                return false;
            }

            return true;
        }

        function processCabCheckoutPayment() {
            if (!validateCabCheckoutForm()) {
                return;
            }

            var name = $('#chk_name').val().trim();
            var phone = $('#chk_phone').val().trim();
            var date = $('#chk_date').val();
            var time = $('#chk_time').val().trim();
            var pickup = $('#chk_pickup').val();
            var drop = $('#chk_drop').val();
            var vehicle = $('#chk_vehicle').val();
            var qty = parseInt($('#chk_cab_qty').val()) || 1;
            var fare = $('#chk_fare').val();
            var idType = $('#chk_id_type').val();
            var idNo = $('#chk_id_no').val().trim();

            var cabBookingSaveDone = false;
            var farePaise = Math.round(parseFloat(fare) * 100);

            var $payBtn = $('#btnChkPay');
            var originalBtnHtml = '<i class="fa fa-credit-card" style="font-size: 18px;"></i> Pay Online — ₹<span id="btnPayOnlineAmount">' + parseFloat(fare).toLocaleString('en-IN') + '</span>';
            $payBtn.prop('disabled', true).html('⏳ Opening Razorpay Gateway...');

            function resetCabPayButton() {
                $payBtn.prop('disabled', false).html(originalBtnHtml);
            }

            var vehicleDesc = vehicle + (qty > 1 ? " (×" + qty + " Cabs)" : "");
            var options = {
                "key": "{{ env('RAZORPAY_KEY', env('KEY_ID', 'rzp_test_TLc5br8H5K6aTI')) }}",
                "amount": farePaise,
                "currency": "INR",
                "name": "DewaSharif.com Cabs",
                "description": "Cab Booking Payment (" + vehicleDesc + ")",
                "image": "{{ asset('home/images/dewasharif/dewalogos.png') }}",
                "handler": function (response) {
                    if (!cabBookingSaveDone) {
                        cabBookingSaveDone = true;
                        executeCabBookingSave(response.razorpay_payment_id || 'RZP_SUCCESS');
                    }
                },
                "modal": {
                    "ondismiss": function () {
                        resetCabPayButton();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'info',
                                title: 'Payment Cancelled',
                                text: 'Aapne payment cancel kar di hai. Koi booking confirm nahi hui hai.',
                                confirmButtonColor: '#052c16'
                            });
                        } else {
                            alert('Aapne payment cancel kar di hai. Koi booking confirm nahi hui hai.');
                        }
                    }
                },
                "prefill": {
                    "name": name,
                    "contact": phone
                },
                "theme": {
                    "color": "#052c16"
                }
            };

            try {
                var rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response) {
                    resetCabPayButton();
                    var errMsg = (response.error && response.error.description) ? response.error.description : 'Payment complete nahi ho saki. Kripya punah prayas karein.';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Failed',
                            text: errMsg,
                            confirmButtonColor: '#052c16'
                        });
                    } else {
                        alert('Payment Failed: ' + errMsg);
                    }
                });
                rzp.open();
            } catch (e) {
                resetCabPayButton();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gateway Error',
                        text: 'Razorpay Gateway load nahi ho saka. Kripya apna internet connection check karein ya QR payment option use karein.',
                        confirmButtonColor: '#052c16'
                    });
                } else {
                    alert('Razorpay Gateway load nahi ho saka. Kripya QR payment use karein.');
                }
            }
        }

        function confirmCabQrPayment() {
            var utr = ($('#cab_utr_input').val() || '').trim();
            if (!utr || utr.length < 10) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: '12-Digit UTR Number Required',
                        text: 'Kripya payment karne ke baad apna 12-digit UPI / UTR Reference Number daalein (PhonePe / GPay receipt se).',
                        confirmButtonColor: '#052c16'
                    });
                } else {
                    alert('⚠️ Kripya payment karne ke baad apna 12-digit UPI / UTR Reference Number daalein.');
                }
                $('#cab_utr_input').focus();
                $('#cab_utr_input').css('border', '2px solid #ef4444');
                setTimeout(function () {
                    $('#cab_utr_input').css('border', '1.5px solid #cbd5e1');
                }, 3000);
                return;
            }

            var paymentId = 'PhonePe QR (UTR: ' + utr + ')';
            closeCabQrModal();
            executeCabBookingSave(paymentId, utr);
        }

        function executeCabBookingSave(paymentId, utr) {
            var name = $('#chk_name').val().trim();
            var phone = $('#chk_phone').val().trim();
            var altPhone = $('#chk_alt_phone').val() ? $('#chk_alt_phone').val().trim() : '';
            var date = $('#chk_date').val();
            var time = $('#chk_time').val().trim();
            var pickup = $('#chk_pickup').val();
            var drop = $('#chk_drop').val();
            var vehicle = $('#chk_vehicle').val();
            var qty = parseInt($('#chk_cab_qty').val()) || 1;
            var fare = $('#chk_fare').val();
            var idType = $('#chk_id_type').val();
            var idNo = $('#chk_id_no').val().trim();
            var utrNo = utr || ($('#cab_utr_input').val() || '').trim();

            $('#btnChkPay').prop('disabled', true).html('⏳ Processing Ride & Generating Invoice...');
            if ($('#btnConfirmCabQrPayment').length) {
                $('#btnConfirmCabQrPayment').prop('disabled', true).html('⏳ Confirming Booking...');
            }

            $.ajax({
                url: "{{ route('cabs.book') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                    phone: phone,
                    alternate_phone: altPhone,
                    pickup: pickup,
                    drop: drop,
                    vehicle: vehicle,
                    vehicle_count: qty,
                    fare: fare,
                    date: date,
                    time: time,
                    id_type: idType,
                    id_no: idNo,
                    payment_id: paymentId,
                    utr_number: utrNo
                },
                success: function (response) {
                    if (response.success) {
                        var displayCust = name + ' (' + phone + (altPhone ? ' / Alt: ' + altPhone : '') + ')';
                        triggerCabSuccessOverlay(response, fare, displayCust);
                    } else {
                        window.location.href = "{{ route('customer.cabs') }}";
                    }
                },
                error: function (err) {
                    window.location.href = "{{ route('customer.cabs') }}";
                }
            });
        }

        function triggerCabSuccessOverlay(response, amount, custInfo) {
            $('#succBookingCode').text('#' + (response.booking_code || 'DWS-CAB-2026'));
            $('#succAmountPaid').text('₹' + parseFloat(amount).toLocaleString('en-IN'));
            $('#succCustomerInfo').text(custInfo);

            $('#paymentSuccessOverlay').css('display', 'flex');

            var secondsLeft = 5;
            $('#succCountdown').text(secondsLeft);
            $('#succProgressBar').css('width', '100%');

            var targetUrl = response.redirect_url || "{{ route('customer.cabs') }}";

            $('#btnGoDashboard').off('click').on('click', function () {
                window.location.href = targetUrl;
            });

            var timerInt = setInterval(function () {
                secondsLeft--;
                if (secondsLeft < 0) secondsLeft = 0;
                $('#succCountdown').text(secondsLeft);
                var pct = (secondsLeft / 5) * 100;
                $('#succProgressBar').css('width', pct + '%');

                if (secondsLeft <= 0) {
                    clearInterval(timerInt);
                    window.location.href = targetUrl;
                }
            }, 1000);
        }

        function processCabCheckoutWhatsApp() {
            var name = ($('#chk_name').val() || '').trim();
            var phone = ($('#chk_phone').val() || '').trim().replace(/[^0-9]/g, '');
            var altPhone = ($('#chk_alt_phone').val() || '').trim();
            var date = ($('#chk_date').val() || '').trim();
            var time = ($('#chk_time').val() || '').trim();
            var pickup = ($('#chk_pickup').val() || '').trim() || 'Dewa Sharif Dargah Gate';
            var drop = ($('#chk_drop').val() || '').trim() || 'Lucknow Charbagh Railway Station';
            var vehicle = ($('#chk_vehicle').val() || '').trim() || 'Swift Dzire (AC)';
            var qty = parseInt($('#chk_cab_qty').val()) || 1;
            var fare = parseFloat($('#chk_fare').val()) || 1400;
            var idType = ($('#chk_id_type').val() || '').trim() || 'Aadhaar Card';
            var idNo = ($('#chk_id_no').val() || '').trim();

            if (!name || name.length < 2) {
                showCabValidationAlert('Kripya Passenger Full Name darj karein!', '#chk_name');
                return;
            }

            if (!phone || phone.length < 10) {
                showCabValidationAlert('Kripya valid 10-digit Mobile Number darj karein!', '#chk_phone');
                return;
            }

            if (!date) {
                showCabValidationAlert('Kripya Pickup Date select karein!', '#chk_date');
                return;
            }

            if (!time) {
                showCabValidationAlert('Kripya Pickup Time select karein!', '#chk_time');
                return;
            }

            // Auto agree terms for WhatsApp booking
            $('#termsAgree').prop('checked', true);

            // Pre-generate unique booking code so message & backend inquiry match
            var code = 'DWS-CAB-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000);
            var passengerStr = name + " (" + phone + (altPhone ? " / Alt: " + altPhone : "") + ")";
            var idStr = idNo ? (idType + " (" + idNo + ")") : "Will share on WhatsApp / Check before Boarding";
            var vehicleStr = vehicle + (qty > 1 ? " (×" + qty + " Cabs)" : "");

            var text = "Assalamu Alaikum DewaSharif Cabs!\n\n" +
                "Main Cab Book karna chahta hun:\n" +
                "🎫 Booking Ref: #" + code + "\n" +
                "🚕 Vehicle: " + vehicleStr + "\n" +
                "📍 Pickup: " + pickup + "\n" +
                "📍 Drop: " + drop + "\n" +
                "📅 Date & Time: " + date + " @ " + time + "\n" +
                "🪪 Govt ID: " + idStr + "\n" +
                "💰 Estimated Fare: ₹" + Number(fare).toLocaleString('en-IN') + (qty > 1 ? " (for " + qty + " Cabs)" : "") + "\n" +
                "👤 Passenger: " + passengerStr + "\n\n" +
                "🅿️ Parking Note: Airport 10m free; extra parking on actual slip.\n" +
                "Kripya confirmation aur driver duty slip bhejein. Shukriya!";

            var waUrl = "https://wa.me/919648777223?text=" + encodeURIComponent(text);

            // CRITICAL: Open WhatsApp immediately and synchronously (never blocked by popup blocker!)
            window.open(waUrl, '_blank');

            // Simultaneously save inquiry in backend
            $.ajax({
                url: "{{ route('cabs.book') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    booking_code: code,
                    name: name,
                    phone: phone,
                    alternate_phone: altPhone,
                    pickup: pickup,
                    drop: drop,
                    vehicle: vehicle,
                    vehicle_count: qty,
                    fare: fare,
                    date: date,
                    time: time,
                    id_type: idType,
                    id_no: idNo || 'N/A',
                    booking_mode: 'whatsapp'
                },
                success: function (response) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'WhatsApp Chat Opened!',
                            html: '<p style="font-size:14px;color:#475569;">Aapka Cab Booking Request Ref <b>#' + code + '</b> register ho gaya hai. Humne WhatsApp khol diya hai, kripya wahan Send button press karein.</p>',
                            confirmButtonColor: '#052c16'
                        });
                    }
                },
                error: function (err) {
                    // WhatsApp window is already opened
                }
            });
        }

        function generateDynamicUpi(amount, note) {
            var upiId = '9648777223@ybl';
            var payeeName = 'SHAHZADE ALAM';
            var cleanAmount = (parseFloat(amount) || 0).toFixed(2);
            var noteText = note || 'Dewa Sharif Booking';

            var upiUri = 'upi://pay?pa=' + encodeURIComponent(upiId) +
                '&pn=' + encodeURIComponent(payeeName) +
                '&am=' + encodeURIComponent(cleanAmount) +
                '&cu=INR' +
                '&tn=' + encodeURIComponent(noteText);

            var qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=8&data=' + encodeURIComponent(upiUri);
            return {
                uri: upiUri,
                qr: qrImgUrl,
                amount: cleanAmount
            };
        }

        function openCabQrModal() {
            if (!validateCabCheckoutForm()) {
                return;
            }

            var fare = $('#chk_fare').val() || '{{ $fare }}';
            var qty = parseInt($('#chk_cab_qty').val()) || 1;
            var numericFare = parseFloat(fare) || 0;
            var formattedFare = numericFare.toLocaleString('en-IN');
            $('#cabQrPayAmountText').text('₹' + formattedFare);

            var upiData = generateDynamicUpi(numericFare, 'Dewa Sharif Cab Booking (' + qty + ' Cabs)');
            $('#cabDynamicQrImg').attr('src', upiData.qr);
            $('#cabDirectUpiBtn').attr('href', upiData.uri);
            $('#cabDirectUpiAmount').text('₹' + formattedFare);

            $('#cabQrModalOverlay').css('display', 'flex');
        }

        function closeCabQrModal() {
            $('#cabQrModalOverlay').hide();
        }

        function copyUpiId(btn) {
            var upi = '9648777223@ybl';
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(upi);
            } else {
                var tempInput = document.createElement('input');
                tempInput.value = upi;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
            }
            if (btn) {
                var originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
                btn.style.background = '#16a34a';
                setTimeout(function () {
                    btn.innerHTML = originalHtml;
                    btn.style.background = '#0f172a';
                }, 2000);
            }
        }

        function sendCabQrWhatsApp() {
            var name = $('#chk_name').val().trim();
            var phone = $('#chk_phone').val().trim();
            var altPhone = $('#chk_alt_phone').val() || '';
            var pickup = '{{ $pickup }}';
            var drop = '{{ $drop }}';
            var vehicle = '{{ $vehicle }}';
            var qty = parseInt($('#chk_cab_qty').val()) || 1;
            var date = $('#chk_date').val();
            var time = $('#chk_time').val();
            var fare = $('#chk_fare').val() || '{{ $fare }}';
            var idType = $('#chk_id_type').val() || 'Aadhaar Card';
            var idNo = $('#chk_id_no').val().trim();

            var utr = ($('#cab_utr_input').val() || '').trim();
            var paymentId = utr ? ('PhonePe QR (UTR: ' + utr + ')') : 'PhonePe QR (Screenshot on WhatsApp)';
            executeCabBookingSave(paymentId, utr);

            var passengerStr = name + " (" + phone + ")" + (altPhone ? " / Alt: " + altPhone : "");
            var vehicleStr = vehicle + (qty > 1 ? " (×" + qty + " Cabs)" : "");
            var text = "Assalamu Alaikum Dewa Sharif Cabs!\n\n" +
                "Maine PhonePe QR se payment kar diya hai:\n" +
                "💰 Total Fare: ₹" + Number(fare).toLocaleString('en-IN') + (qty > 1 ? " (" + qty + " Cabs)" : "") + "\n" +
                "🚕 Vehicle: " + vehicleStr + "\n" +
                "📍 Pickup: " + pickup + "\n" +
                "📍 Drop: " + drop + "\n" +
                "📅 Date & Time: " + date + " @ " + time + "\n" +
                "🪪 Govt ID: " + idType + " (" + idNo + ")\n" +
                "⚠️ Boarding Rule: Original ID gaadi me baithne se pehle driver ko dikhana anivarya hai.\n" +
                "🅿️ Parking Note: Airport 10m free; extra airport/monument parking on actual slip.\n" +
                "👤 Passenger: " + passengerStr + "\n\n" +
                "Maine payment ka screenshot WhatsApp par attach kar diya hai. Kripya booking confirm karke driver duty slip bhejein. Shukriya!";

            window.open("https://wa.me/919648777223?text=" + encodeURIComponent(text), '_blank');
        }
    </script>

    <!-- PHONEPE / UPI QR PAYMENT MODAL OVERLAY -->
    <div id="cabQrModalOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(6px); z-index: 999998; align-items: center; justify-content: center; padding: 16px; overflow-y: auto;">
        <div
            style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 20px; padding: 26px 24px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; max-height: 94vh; overflow-y: auto;">

            <!-- CLOSE BUTTON -->
            <button type="button" onclick="closeCabQrModal()"
                style="position: absolute; top: 16px; right: 18px; background: #f1f5f9; border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 20px; font-weight: 700; color: #475569; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1;">
                ✕
            </button>

            <!-- WEBSITE BRANDING HEADER -->
            <div style="margin-bottom: 14px;">
                <span
                    style="font-size: 13px; font-weight: 800; color: #047857; background: #ecfdf5; padding: 4px 12px; border-radius: 20px; border: 1px solid #d1fae5; letter-spacing: 0.3px;">
                    🌐 www.dewasharif.com
                </span>
            </div>

            <!-- HEADER -->
            <div
                style="display: inline-flex; align-items: center; gap: 8px; background: #fef3c7; border: 1.5px solid #fde68a; padding: 6px 16px; border-radius: 30px; margin-bottom: 12px;">
                <i class="fa fa-qrcode" style="color: #b45309; font-size: 16px;"></i>
                <span
                    style="font-size: 12px; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">PhonePe
                    &amp; All UPI Apps Accepted</span>
            </div>

            <h4
                style="font-weight: 900; color: #0f172a; margin-bottom: 4px; font-size: 20px; text-align: center !important;">
                Scan &amp; Pay via QR Code
            </h4>
            <p
                style="font-size: 13.5px; color: #64748b; margin-bottom: 14px; text-align: center !important; width: 100%; display: block; margin-left: auto; margin-right: auto;">
                Pay directly to Merchant: <strong style="color: #0f172a;">SHAHZADE ALAM</strong>
            </p>

            <!-- AMOUNT TO PAY BANNER -->
            <div
                style="background: linear-gradient(135deg, #052c16 0%, #074121 100%); color: #ffffff; border-radius: 12px; padding: 12px; margin-bottom: 14px;">
                <span
                    style="font-size: 11.5px; font-weight: 700; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Total
                    Amount to Pay</span>
                <span style="font-size: 26px; font-weight: 900; color: #4ade80;"
                    id="cabQrPayAmountText">₹{{ number_format($fare) }}</span>
            </div>

            <!-- DYNAMIC QR IMAGE WITH AUTO AMOUNT EMBEDDED -->
            <div
                style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 12px; margin-bottom: 14px; display: inline-block; max-width: 290px; width: 100%; box-sizing: border-box;">
                <div
                    style="position: relative; width: 230px; height: 230px; margin: 0 auto; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.06); overflow: hidden;">
                    <img id="cabDynamicQrImg"
                        src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=8&data={{ urlencode('upi://pay?pa=9648777223@ybl&pn=SHAHZADE%20ALAM&am=' . number_format($fare, 2, '.', '') . '&cu=INR&tn=Dewa%20Sharif%20Cab%20Booking') }}"
                        alt="PhonePe Dynamic QR Code"
                        onerror="this.src='{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}'"
                        style="width: 100%; height: 100%; object-fit: contain; display: block;">
                </div>
                <div
                    style="margin-top: 8px; font-size: 11px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                    ✔ Amount Pre-filled on Scan
                </div>
                <div style="margin-top: 6px; font-size: 11.5px; font-weight: 700; color: #475569; text-align: center;">
                    📱 PhonePe • Google Pay • Paytm • BHIM
                </div>

                <!-- UPI ID BOX WITH 1-CLICK COPY -->
                <div
                    style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 7px 10px; margin-top: 10px; display: flex; align-items: center; justify-content: space-between; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                    <div style="text-align: left; overflow: hidden;">
                        <span
                            style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase; display: block; line-height: 1;">UPI
                            ID</span>
                        <span
                            style="font-size: 13px; font-weight: 900; color: #0f172a; font-family: monospace; letter-spacing: 0.2px;">9648777223@ybl</span>
                    </div>
                    <button type="button" onclick="copyUpiId(this)"
                        style="background: #0f172a; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s; white-space: nowrap;">
                        <i class="fa fa-clone"></i> <span>Copy</span>
                    </button>
                </div>
            </div>

            <!-- 1-TAP DIRECT UPI APP PAYMENT BUTTON (MOBILE FRIENDLY WITH DESKTOP CHECK) -->
            <div style="margin-bottom: 12px;">
                <a id="cabDirectUpiBtn"
                    href="upi://pay?pa=9648777223@ybl&pn=SHAHZADE%20ALAM&am={{ number_format($fare, 2, '.', '') }}&cu=INR&tn=Dewa%20Sharif%20Cab%20Booking"
                    onclick="return handleUpiClick(event)" class="btn w-100 font-extrabold"
                    style="background: linear-gradient(135deg, #5f259f 0%, #3f156d 100%); color: #ffffff; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(95, 37, 159, 0.35);">
                    <i class="fa fa-mobile" style="font-size: 22px;"></i>
                    <span>Tap to Pay <strong id="cabDirectUpiAmount">₹{{ number_format($fare) }}</strong> via PhonePe /
                        GPay</span>
                </a>
                <small style="color: #64748b; font-size: 11px; display: block; margin-top: 4px;">(If on mobile, tap above to
                    open UPI app directly without scanning)</small>
            </div>

            <!-- UTR / PAYMENT CONFIRMATION SECTION -->
            <div
                style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 14px; padding: 14px 16px; margin-bottom: 12px; text-align: left;">
                <label style="font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 5px; display: block;">
                    🔢 Enter 12-Digit UPI Ref / UTR No. (from PhonePe/GPay Receipt):
                </label>
                <input type="text" id="cab_utr_input" maxlength="12" placeholder="e.g. 428910482910"
                    style="width: 100%; height: 44px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 0 12px; font-size: 14px; font-weight: 700; letter-spacing: 0.5px; font-family: monospace; background: #ffffff;"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)">
                <small style="font-size: 11px; color: #64748b; font-weight: 600; display: block; margin-top: 4px;">
                    💡 Payment successful screen par 12-digit UTR/UPI Ref No. hota hai.
                </small>
            </div>

            <!-- ACTION BUTTONS CONTAINER (EXACT MATCHED WIDTH) -->
            <div style="width: 100%;">
                <!-- PRIMARY ACTION: CONFIRM BOOKING & GENERATE DUTY SLIP -->
                <div style="margin-bottom: 12px; width: 100%;">
                    <button type="button" id="btnConfirmCabQrPayment" onclick="confirmCabQrPayment()" class="btn btn-block"
                        style="width: 100%; background: #052c16; color: #ffffff; font-weight: 800; border-radius: 12px; height: 50px; padding: 0 16px; font-size: 14px; border: none; box-shadow: 0 4px 14px rgba(5, 44, 22, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; box-sizing: border-box;">
                        <i class="fa fa-check-circle" style="font-size: 18px; color: #4ade80;"></i>
                        <span>Maine Payment Kar Diya — Confirm Booking</span>
                    </button>
                </div>

                <!-- SECONDARY ACTION: WHATSAPP SCREENSHOT DISPATCH -->
                <div style="width: 100%;">
                    <button type="button" onclick="sendCabQrWhatsApp()" class="btn btn-block"
                        style="width: 100%; background: #25D366; color: #ffffff; font-weight: 800; border-radius: 12px; height: 50px; padding: 0 16px; font-size: 14px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; box-sizing: border-box;">
                        <i class="fa fa-whatsapp" style="font-size: 19px;"></i>
                        <span>Send Screenshot on WhatsApp (Optional)</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- DESKTOP SMART CHECK SCRIPT FOR UPI LINK -->
    <script>
        function handleUpiClick(event) {
            const isDesktop = !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
            if (isDesktop) {
                event.preventDefault();
                alert("💻 Desktop Notice:\n\nDirect UPI app buttons only work on mobile phones. Please scan the QR Code given above using your phone or copy the UPI ID to make the payment!");
                return false;
            }
            return true;
        }
    </script>

    <!-- HOSTLOK STYLE PAYMENT SUCCESS MODAL OVERLAY -->
    <div id="paymentSuccessOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(5, 44, 22, 0.88); backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 20px;">
        <div
            style="background: #ffffff; width: 100%; max-width: 500px; border-radius: 24px; padding: 35px 30px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">

            <!-- Animated Green Success Checkmark Badge -->
            <div
                style="width: 85px; height: 85px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 42px; box-shadow: 0 10px 25px rgba(22,163,74,0.3); border: 3.5px solid #22c55e;">
                ✓
            </div>

            <h3 style="font-weight: 900; color: #052c16; margin-bottom: 6px; font-size: 24px; letter-spacing: -0.3px;">
                🎉 Payment Successful!
            </h3>
            <p style="color: #64748b; font-weight: 600; font-size: 14px; margin-bottom: 20px;">
                Money Credited to Dewa Sharif Trust (SBI A/C). Booking confirmed!
            </p>

            <!-- Details Summary Box -->
            <div
                style="background: #f8fafc; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 18px; margin-bottom: 22px; text-align: left; font-size: 13.5px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-weight: 700;">Booking Reference:</span>
                    <span style="font-weight: 900; color: #0f172a;" id="succBookingCode">#DWS-2026</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-weight: 700;">Amount Paid:</span>
                    <span style="font-weight: 900; color: #16a34a; font-size: 16px;" id="succAmountPaid">₹0</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b; font-weight: 700;">Passenger / Contact:</span>
                    <span style="font-weight: 800; color: #334155;" id="succCustomerInfo">-</span>
                </div>
            </div>

            <!-- 5-Second Countdown Bar -->
            <div style="margin-bottom: 22px;">
                <p style="font-weight: 800; color: #074121; font-size: 14px; margin-bottom: 10px;">
                    ⌛ Redirecting to your Customer Dashboard in <span id="succCountdown"
                        style="color: #e11d48; font-size: 18px; font-weight: 900;">5</span> seconds...
                </p>
                <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                    <div id="succProgressBar"
                        style="width: 100%; height: 100%; background: linear-gradient(90deg, #16a34a, #22c55e); transition: width 1s linear;">
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" id="btnGoDashboard" class="btn"
                    style="background: #052c16; color: #ffffff; font-weight: 800; font-size: 14px; padding: 12px 24px; border-radius: 10px; flex: 1; border: none; box-shadow: 0 4px 12px rgba(5,44,22,0.3);">
                    🚀 Go to Dashboard Now
                </button>
            </div>

        </div>
    </div>

    <style>
        @keyframes popIn {
            0% {
                transform: scale(0.7);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection