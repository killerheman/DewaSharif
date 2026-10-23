@extends('home.includes.master')

@section('content')
<div style="background: #f1f5f9; padding: 40px 0 70px 0; min-height: 85vh;">
    <div class="container">
        
        <div style="margin-bottom: 25px;">
            <a href="{{ route('hotels') }}" class="btn btn-sm btn-outline-secondary font-weight-bold" style="border-radius: 6px;">
                ← Back to Hotels Landing Page
            </a>
        </div>

        <div class="row g-4">
            
            <!-- LEFT COLUMN: HOTEL STAY SUMMARY & TARIFF BREAKDOWN -->
            <div class="col-md-5 col-12 mb-4">
                <div style="background: #ffffff; border-radius: 16px; padding: 28px; border: 1.5px solid #cbd5e1; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                    <span style="background: #074121; color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 900; text-transform: uppercase;">
                        🏨 Hotel Stay Summary
                    </span>

                    <h3 style="font-weight: 900; color: #0f172a; margin-top: 12px; margin-bottom: 6px; font-size: 22px;">
                        {{ $hotel }}
                    </h3>

                    <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 15px;">
                        Verified Dargah Gate Nearby Stay under DewaSharif.com
                    </p>

                    <div style="margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 2px;">🛏️ Selected Room Category:</span>
                        <strong style="font-size: 15px; color: #074121;">{{ $room }}</strong>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 2px;">📅 Check-In Date:</span>
                        <strong style="font-size: 14.5px; color: #0f172a;" id="lbl_checkin">{{ $checkin }}</strong>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 2px;">📅 Check-Out Date:</span>
                        <strong style="font-size: 14.5px; color: #0f172a;" id="lbl_checkout">{{ $checkout }}</strong>
                    </div>

                    <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 18px; margin-top: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 13.5px; color: #475569; font-weight: 600;">Rooms Reserved:</span>
                            <strong style="font-size: 14.5px; color: #074121;" id="lbl_stay_rooms">1 Room(s)</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 13.5px; color: #475569; font-weight: 600;">Room Tariff:</span>
                            <strong style="font-size: 15px; color: #0f172a;" id="lbl_tariff_rate">₹{{ number_format($price) }} / night</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 13.5px; color: #475569; font-weight: 600;">Duration of Stay:</span>
                            <strong style="font-size: 14.5px; color: #074121;" id="lbl_stay_nights">{{ $nights ?? 1 }} Night(s)</strong>
                        </div>
                        @if(!empty($hotelAmenities) && count($hotelAmenities) > 0)
                            <div style="margin-top: 10px; margin-bottom: 10px; border-top: 1px dashed #cbd5e1; padding-top: 10px;">
                                <span style="font-size: 12.5px; color: #475569; font-weight: 700; display: block; margin-bottom: 8px;">✨ Included Room &amp; Hotel Amenities:</span>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                    @foreach($hotelAmenities as $am)
                                        <span style="font-size: 11px; background: #f0fdf4; color: #15803d; padding: 4px 10px; border-radius: 6px; font-weight: 700; border: 1px solid #bbf7d0;">
                                            ✔ {{ $am }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 10px;">
                            <span style="font-size: 16px; color: #0f172a; font-weight: 900;">Total Payable:</span>
                            <span style="font-size: 24px; color: #074121; font-weight: 900;" id="lbl_total_payable">₹{{ number_format($totalPrice ?? $price) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: GUEST DETAILS & PAYMENT CHECKOUT -->
            <div class="col-md-7 col-12">
                <div style="background: #ffffff; border-radius: 16px; padding: 32px; border: 1.5px solid #cbd5e1; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                    <h4 style="font-weight: 900; color: #0f172a; margin-bottom: 6px; font-size: 20px;">
                        👤 Guest &amp; Stay Reservation Details
                    </h4>
                    <p style="font-size: 13.5px; color: #64748b; margin-bottom: 24px;">
                        Enter guest contact &amp; Govt ID info for hotel check-in registration slip.
                    </p>

                    <form id="hotelCheckoutForm">
                        <input type="hidden" id="chk_hotel" value="{{ $hotel }}">
                        <input type="hidden" id="chk_room" value="{{ $room }}">
                        <input type="hidden" id="chk_base_price" value="{{ $price }}">
                        <input type="hidden" id="chk_price" value="{{ $totalPrice ?? $price }}">
                        <input type="hidden" id="chk_nights" value="{{ $nights ?? 1 }}">
                        <input type="hidden" id="chk_rooms" value="1">

                        <!-- ROOM QUANTITY SELECTOR (ADD / REMOVE ROOMS) -->
                        <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                            <div>
                                <label style="font-size: 13.5px; font-weight: 800; color: #166534; margin: 0; display: flex; align-items: center; gap: 6px;">
                                    <span>🛏️</span> Number of Rooms
                                </label>
                                <small style="color: #15803d; font-size: 12px; font-weight: 600;">(Agar aapke saath zyada family members / guests hain to zyada rooms select karein)</small>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; background: #ffffff; padding: 4px; border-radius: 10px; border: 1.5px solid #bbf7d0;">
                                <button type="button" onclick="changeHotelRoomQty(-1)" class="btn btn-sm btn-light" style="width: 36px; height: 36px; border-radius: 8px; font-weight: 900; font-size: 18px; line-height: 1; border: 1px solid #cbd5e1; color: #0f172a; display: flex; align-items: center; justify-content: center; background: #f8fafc; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'">−</button>
                                <span id="display_hotel_rooms" style="min-width: 38px; text-align: center; font-size: 17px; font-weight: 900; color: #074121;">1</span>
                                <button type="button" onclick="changeHotelRoomQty(1)" class="btn btn-sm btn-light" style="width: 36px; height: 36px; border-radius: 8px; font-weight: 900; font-size: 18px; line-height: 1; border: 1px solid #cbd5e1; color: #0f172a; display: flex; align-items: center; justify-content: center; background: #f8fafc; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'">+</button>
                            </div>
                        </div>

                        <!-- ROW 1: GUEST NAME & MOBILE -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">👤 Guest Full Name</label>
                                <input type="text" id="chk_name" class="form-control" value="{{ auth()->check() ? (auth()->user()->name ?? 'Guest User') : 'Guest User' }}" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📱 Mobile</label>
                                <input type="tel" id="chk_phone" class="form-control" value="{{ auth()->check() ? (auth()->user()->phone ?? (auth()->user()->mobile ?? '9648777223')) : '9648777223' }}" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                        </div><br>
                        <input type="hidden" id="chk_alt_phone" value="">

                        <!-- ROW 2: CHECKIN DATE & CHECKOUT DATE -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📅 Check-In Date</label>
                                <input type="date" id="chk_checkin" onchange="recalculateHotelPayable()" oninput="recalculateHotelPayable()" class="form-control" value="{{ $checkin }}" min="{{ date('Y-m-d') }}" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📅 Check-Out Date</label>
                                <input type="date" id="chk_checkout" onchange="recalculateHotelPayable()" oninput="recalculateHotelPayable()" class="form-control" value="{{ $checkout }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                        </div><br>

                        <!-- ROW 3: GOVT APPROVED ID TYPE & ID NUMBER -->
                        <div class="row g-3 mb-2">
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🪪 Govt Approved ID Type <span style="color: #ef4444;">*</span></label>
                                <select id="chk_id_type" onchange="handleHotelIdTypeChange()" class="form-control" style="border-radius: 8px; height: 46px; font-weight: 600; font-size: 14px; border: 1.5px solid #cbd5e1; background-color: #ffffff !important; background-image: none !important; appearance: menulist !important; -webkit-appearance: menulist !important; cursor: pointer;">
                                    <option value="Aadhaar Card" selected>Aadhaar Card (12 Digits)</option>
                                    <option value="PAN Card">PAN Card (10 Digits / Letters)</option>
                                    <option value="Voter ID Card">Voter ID Card (EPIC)</option>
                                    <option value="Driving License">Driving License (DL)</option>
                                    <option value="Passport">Passport</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🔢 Govt ID Number <span style="color: #ef4444;">*</span></label>
                                <input type="text" id="chk_id_no" oninput="formatHotelIdInput(this)" onblur="validateCurrentHotelId(true)" class="form-control" value="" placeholder="12-digit Aadhaar (e.g. 5482 9102 3841)" required maxlength="14" style="border-radius: 8px; height: 46px; font-weight: 600; font-size: 14px; border: 1.5px solid #cbd5e1; letter-spacing: 0.5px;">
                                <small id="hotelIdHelpText" style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 4px; display: block;">Format: 12 digit Aadhaar number (Auto-spaced)</small>
                            </div>
                            <div class="col-12 mt-2">
                                <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 8px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 16px;">🪪</span>
                                    <span style="font-size: 12px; font-weight: 700; color: #166534; line-height: 1.4;">
                                        <strong>Check-in Rule:</strong> Hotel reception par room keys lene se pehle wahi Original Govt ID physical form me verify karwana zaruri (compulsory) hai.
                                        (Guest Safety &amp; Police Verification)
                                    </span>
                                </div>
                            </div>
                        </div><br>

                        <!-- TERMS & CANCELLATION AGREEMENT CHECKBOX -->
                        <div class="mb-4" style="padding-left: 4px;">
                            <div class="form-check" style="display: flex; align-items: flex-start; gap: 10px;">
                                <input class="form-check-input" type="checkbox" id="termsAgree" checked style="width: 19px; height: 19px; cursor: pointer; margin-top: 2px;">
                                <label class="form-check-label" for="termsAgree" style="font-size: 12.5px; color: #334155; cursor: pointer; font-weight: 600; line-height: 1.45;">
                                   "I agree to dewasharif.com Hotel Terms & Mela Periods Refund Policy (50% refund prior to 2 days, 15% refund within 2 days of booking, and 10% refund for same-day booking cancellations)."
                                </label>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS CONTAINER -->
                        <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 20px;">
                            <span style="font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 14px;">
                                Confirm &amp; Proceed:
                            </span>

                            <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
                                <!-- BUTTON 1: RAZORPAY ONLINE PAYMENT (DISABLED - COMING SOON) -->
                                <button type="button" id="btnHtlPay" disabled class="btn w-100" style="background: #f1f5f9; color: #64748b; font-weight: 700; border-radius: 8px; padding: 12px 14px; font-size: 13.5px; border: 1.5px dashed #cbd5e1; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap; opacity: 0.95; white-space: normal !important; text-align: center; box-sizing: border-box;" title="Online Gateway verification underway. Please use UPI QR.">
                                    <i class="fa fa-credit-card" style="font-size: 16px; color: #94a3b8; flex-shrink: 0;"></i>
                                    <span>Pay Online (Cards / NetBanking) — <span id="btnPayOnlineText">₹{{ number_format($totalPrice ?? $price) }}</span></span>
                                    <span class="badge" style="background: #f59e0b; color: #111; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px; text-transform: uppercase; margin-left: 4px; flex-shrink: 0;">Soon</span>
                                </button>

                                <!-- BUTTON 2: PHONEPE / UPI QR CODE PAYMENT (DEFAULT & PRIMARY) -->
                                <button type="button" id="btnHtlQr" onclick="openHotelQrModal()" class="btn w-100 font-extrabold" style="background: #074121; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 14px rgba(7, 65, 33, 0.35); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px; white-space: normal !important; text-align: center; box-sizing: border-box;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap;">
                                        <i class="fa fa-qrcode" style="font-size: 18px; color: #4ade80;"></i>
                                        <span style="font-size: 14.5px; font-weight: 900;">Pay via UPI QR — <span id="btnPayQrText">₹{{ number_format($totalPrice ?? $price) }}</span></span>
                                    </div>
                                    <small style="font-size: 11px; opacity: 0.9; font-weight: 600; color: #dcfce7;">PhonePe • Google Pay • Paytm • BHIM</small>
                                </button>

                                <!-- BUTTON 3: DIRECT COMPANY WHATSAPP CHAT -->
                                <button type="button" onclick="processHotelCheckoutWhatsApp()" class="btn w-100 font-extrabold" style="background: #25D366; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px; white-space: normal !important; text-align: center; box-sizing: border-box;">
                                    <i class="fa fa-whatsapp" style="font-size: 19px; flex-shrink: 0;"></i>
                                    <span>Book Hotel via WhatsApp</span>
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
    var baseRatePerNight = parseFloat("{{ $price }}") || 0;

    function changeHotelRoomQty(delta) {
        var el = document.getElementById('chk_rooms');
        var cur = parseInt(el ? el.value : 1) || 1;
        var next = cur + delta;
        if (next < 1) next = 1;
        if (next > 20) next = 20;
        if (el) el.value = next;
        var disp = document.getElementById('display_hotel_rooms');
        if (disp) disp.innerText = next;
        var lblRooms = document.getElementById('lbl_stay_rooms');
        if (lblRooms) lblRooms.innerText = next + ' Room(s)';
        recalculateHotelPayable();
    }

    function recalculateHotelPayable() {
        var inEl = document.getElementById('chk_checkin');
        var outEl = document.getElementById('chk_checkout');
        if (!inEl || !outEl) return;

        var inVal = inEl.value;
        var outVal = outEl.value;
        if (!inVal || !outVal) return;

        var d1 = new Date(inVal + 'T00:00:00');
        var d2 = new Date(outVal + 'T00:00:00');

        if (isNaN(d1.getTime()) || isNaN(d2.getTime()) || d2.getTime() <= d1.getTime()) {
            d2 = new Date(d1.getTime() + 86400000);
            var yyyy = d2.getFullYear();
            var mm = String(d2.getMonth() + 1).padStart(2, '0');
            var dd = String(d2.getDate()).padStart(2, '0');
            outVal = yyyy + '-' + mm + '-' + dd;
            outEl.value = outVal;
        }

        var minCheckoutDate = new Date(d1.getTime() + 86400000);
        var minYYYY = minCheckoutDate.getFullYear();
        var minMM = String(minCheckoutDate.getMonth() + 1).padStart(2, '0');
        var minDD = String(minCheckoutDate.getDate()).padStart(2, '0');
        outEl.min = minYYYY + '-' + minMM + '-' + minDD;

        var diffTime = d2.getTime() - d1.getTime();
        var nights = Math.max(1, Math.round(diffTime / 86400000));

        var roomsEl = document.getElementById('chk_rooms');
        var rooms = parseInt(roomsEl ? roomsEl.value : 1) || 1;

        var totalAmount = Math.round(baseRatePerNight * nights * rooms);
        var formattedTotal = '₹' + totalAmount.toLocaleString('en-IN');

        var lblCheckin = document.getElementById('lbl_checkin');
        if (lblCheckin) lblCheckin.innerText = inVal;

        var lblCheckout = document.getElementById('lbl_checkout');
        if (lblCheckout) lblCheckout.innerText = outVal;

        var lblNights = document.getElementById('lbl_stay_nights');
        if (lblNights) lblNights.innerText = nights + ' Night(s)';

        var lblRooms = document.getElementById('lbl_stay_rooms');
        if (lblRooms) lblRooms.innerText = rooms + ' Room(s)';

        var lblTariff = document.getElementById('lbl_tariff_rate');
        if (lblTariff) {
            lblTariff.innerText = '₹' + baseRatePerNight.toLocaleString('en-IN') + ' / night' + (rooms > 1 ? ' (×' + rooms + ' Rooms)' : '');
        }

        var lblTotal = document.getElementById('lbl_total_payable');
        if (lblTotal) lblTotal.innerText = formattedTotal;

        var chkPrice = document.getElementById('chk_price');
        if (chkPrice) chkPrice.value = totalAmount;

        var chkNights = document.getElementById('chk_nights');
        if (chkNights) chkNights.value = nights;

        var btnPayText = document.getElementById('btnPayOnlineText');
        if (btnPayText) btnPayText.innerText = 'Pay Online — ' + formattedTotal;

        var btnQrText = document.getElementById('btnPayQrText');
        if (btnQrText) btnQrText.innerText = 'Pay via QR — ' + formattedTotal;

        var qrText = document.getElementById('htlQrPayAmountText');
        if (qrText) qrText.innerText = formattedTotal;

        var directUpiAmount = document.getElementById('htlDirectUpiAmount');
        if (directUpiAmount) directUpiAmount.innerText = formattedTotal;

        if (typeof generateDynamicUpi === 'function') {
            var upiData = generateDynamicUpi(totalAmount, 'Dewa Sharif Hotel Booking (' + rooms + ' Rooms)');
            var qrImg = document.getElementById('htlDynamicQrImg');
            if (qrImg) qrImg.src = upiData.qr;
            var directBtn = document.getElementById('htlDirectUpiBtn');
            if (directBtn) directBtn.href = upiData.uri;
        }
    }

    // Attach listeners immediately & on window load
    document.addEventListener('DOMContentLoaded', function() {
        var elIn = document.getElementById('chk_checkin');
        var elOut = document.getElementById('chk_checkout');
        if (elIn) {
            elIn.addEventListener('change', recalculateHotelPayable);
            elIn.addEventListener('input', recalculateHotelPayable);
        }
        if (elOut) {
            elOut.addEventListener('change', recalculateHotelPayable);
            elOut.addEventListener('input', recalculateHotelPayable);
        }
        recalculateHotelPayable();
    });

    window.addEventListener('load', recalculateHotelPayable);
    setTimeout(recalculateHotelPayable, 300);

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

    function handleHotelIdTypeChange() {
        var type = $('#chk_id_type').val();
        var el = $('#chk_id_no');
        var help = $('#hotelIdHelpText');
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

    function formatHotelIdInput(input) {
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

    function validateCurrentHotelId(showVisualOnly) {
        var type = $('#chk_id_type').val();
        var raw = ($('#chk_id_no').val() || '').trim();
        var clean = raw.replace(/\s+/g, '');
        var el = $('#chk_id_no');
        var help = $('#hotelIdHelpText');

        if (!clean) {
            if (showVisualOnly) {
                el.css('border', '1.5px solid #cbd5e1');
            }
            return { valid: false, message: 'Kripya Guest Govt ID Number darj karein!' };
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

    function showHotelValidationAlert(msg, focusSelector) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Kripya Dhyan Dein',
                text: msg,
                confirmButtonColor: '#074121'
            }).then(function() {
                if (focusSelector) $(focusSelector).focus();
            });
        } else {
            alert(msg);
            if (focusSelector) $(focusSelector).focus();
        }
    }

    function validateHotelCheckoutForm() {
        var name = ($('#chk_name').val() || '').trim();
        var phone = ($('#chk_phone').val() || '').trim().replace(/[^0-9]/g, '');
        var checkin = ($('#chk_checkin').val() || '').trim();
        var checkout = ($('#chk_checkout').val() || '').trim();
        var termsChecked = $('#termsAgree').is(':checked');

        if (!name) {
            showHotelValidationAlert('Kripya Guest ka Pura Naam (Full Name) darj karein!', '#chk_name');
            return false;
        }

        if (!phone || phone.length !== 10) {
            showHotelValidationAlert('Kripya valid 10-digit Mobile Number darj karein taaki hotel confirmation aur invoice receive ho sake!', '#chk_phone');
            return false;
        }

        if (!checkin || !checkout) {
            showHotelValidationAlert('Kripya Check-In aur Check-Out Dates select karein!', '#chk_checkin');
            return false;
        }

        var idCheck = validateCurrentHotelId(false);
        if (!idCheck.valid) {
            showHotelValidationAlert(idCheck.message, '#chk_id_no');
            return false;
        }

        if (!termsChecked) {
            showHotelValidationAlert('Kripya dewasharif.com Hotel Terms aur Refund Policy checkbox ko accept karein!', '#termsAgree');
            return false;
        }

        return true;
    }

    function processHotelCheckoutPayment() {
        if (!validateHotelCheckoutForm()) {
            return;
        }

        var name = $('#chk_name').val().trim();
        var phone = $('#chk_phone').val().trim();
        var checkin = $('#chk_checkin').val();
        var checkout = $('#chk_checkout').val();
        var hotel = $('#chk_hotel').val();
        var room = $('#chk_room').val();
        var rooms = parseInt($('#chk_rooms').val()) || 1;
        var price = $('#chk_price').val();
        var idType = $('#chk_id_type').val();
        var idNo = $('#chk_id_no').val().trim();

        var hotelBookingSaveDone = false;
        var farePaise = Math.round(parseFloat(price) * 100);

        var $payBtn = $('#btnHtlPay');
        var originalBtnHtml = $payBtn.html();
        $payBtn.prop('disabled', true).html('⏳ Opening Razorpay Gateway...');

        function resetHotelPayButton() {
            $payBtn.prop('disabled', false).html(originalBtnHtml);
        }

        var roomDesc = room + (rooms > 1 ? " (×" + rooms + " Rooms)" : "");
        var options = {
            "key": "{{ env('RAZORPAY_KEY', env('KEY_ID', 'rzp_test_TLc5br8H5K6aTI')) }}",
            "amount": farePaise,
            "currency": "INR",
            "name": "DewaSharif.com Stays & Hotels",
            "description": "Room Booking Payment (" + roomDesc + ")",
            "image": "{{ asset('home/images/dewasharif/dewalogos.png') }}",
            "handler": function (response){
                if (!hotelBookingSaveDone) {
                    hotelBookingSaveDone = true;
                    executeHotelBookingSave(response.razorpay_payment_id || 'RZP_HOTEL_SUCCESS');
                }
            },
            "modal": {
                "ondismiss": function() {
                    resetHotelPayButton();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Payment Cancelled',
                            text: 'Aapne payment cancel kar di hai. Koi hotel booking confirm nahi hui hai.',
                            confirmButtonColor: '#074121'
                        });
                    } else {
                        alert('Aapne payment cancel kar di hai. Koi hotel booking confirm nahi hui hai.');
                    }
                }
            },
            "prefill": {
                "name": name,
                "contact": phone
            },
            "theme": {
                "color": "#074121"
            }
        };

        try {
            var rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response){
                resetHotelPayButton();
                var errMsg = (response.error && response.error.description) ? response.error.description : 'Payment complete nahi ho saki. Kripya punah prayas karein.';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: errMsg,
                        confirmButtonColor: '#074121'
                    });
                } else {
                    alert('Payment Failed: ' + errMsg);
                }
            });
            rzp.open();
        } catch(e) {
            resetHotelPayButton();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gateway Error',
                    text: 'Razorpay Gateway load nahi ho saka. Kripya apna internet connection check karein ya QR payment option use karein.',
                    confirmButtonColor: '#074121'
                });
            } else {
                alert('Razorpay Gateway load nahi ho saka. Kripya QR payment use karein.');
            }
        }
    }

    function confirmHotelQrPayment() {
        var utr = ($('#htl_utr_input').val() || '').trim();
        if (!utr || utr.length < 10) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: '12-Digit UTR Number Required',
                    text: 'Kripya payment karne ke baad apna 12-digit UPI / UTR Reference Number daalein (PhonePe / GPay receipt se).',
                    confirmButtonColor: '#074121'
                });
            } else {
                alert('⚠️ Kripya payment karne ke baad apna 12-digit UPI / UTR Reference Number daalein.');
            }
            $('#htl_utr_input').focus();
            $('#htl_utr_input').css('border', '2px solid #ef4444');
            setTimeout(function() {
                $('#htl_utr_input').css('border', '1.5px solid #cbd5e1');
            }, 3000);
            return;
        }

        var paymentId = 'PhonePe QR (UTR: ' + utr + ')';
        closeHotelQrModal();
        executeHotelBookingSave(paymentId, utr);
    }

    function executeHotelBookingSave(paymentId, utr) {
        var name = $('#chk_name').val().trim();
        var phone = $('#chk_phone').val().trim();
        var altPhone = $('#chk_alt_phone').val() ? $('#chk_alt_phone').val().trim() : '';
        var checkin = $('#chk_checkin').val();
        var checkout = $('#chk_checkout').val();
        var hotel = $('#chk_hotel').val();
        var room = $('#chk_room').val();
        var rooms = parseInt($('#chk_rooms').val()) || 1;
        var price = $('#chk_price').val();
        var idType = $('#chk_id_type').val();
        var idNo = $('#chk_id_no').val().trim();
        var utrNo = utr || ($('#htl_utr_input').val() || '').trim();

        $('#btnHtlPay').prop('disabled', true).html('⏳ Processing Reservation & Generating Invoice...');
        if ($('#btnConfirmHtlQrPayment').length) {
            $('#btnConfirmHtlQrPayment').prop('disabled', true).html('⏳ Confirming Booking...');
        }

        $.ajax({
            url: "{{ route('hotels.book') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                name: name,
                phone: phone,
                alternate_phone: altPhone,
                hotel_name: hotel,
                room_name: room,
                rooms: rooms,
                rooms_count: rooms,
                base_price: $('#chk_base_price').val() || '{{ $price }}',
                price: price,
                nights: $('#chk_nights').val() || 1,
                checkin: checkin,
                checkout: checkout,
                id_type: idType,
                id_no: idNo,
                payment_id: paymentId,
                utr_number: utrNo
            },
            success: function(response) {
                if(response.success) {
                    var displayCust = name + ' (' + phone + (altPhone ? ' / Alt: ' + altPhone : '') + ')';
                    triggerHotelSuccessOverlay(response, price, displayCust);
                } else {
                    var errMsg = response.message || 'Hotel booking save nahi ho saki. Kripya punah prayas karein.';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Booking Failed',
                            text: errMsg,
                            confirmButtonColor: '#074121'
                        });
                    } else {
                        alert('⚠️ ' + errMsg);
                    }
                    $('#btnHtlPay').prop('disabled', false).html('Pay via UPI QR');
                    if ($('#btnConfirmHtlQrPayment').length) {
                        $('#btnConfirmHtlQrPayment').prop('disabled', false).html('Maine Payment Kar Diya — Confirm Booking');
                    }
                }
            },
            error: function(xhr) {
                var errMsg = 'Hotel reservation confirm karte samay server par dikkat aayi.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Booking Error',
                        text: errMsg,
                        confirmButtonColor: '#074121'
                    });
                } else {
                    alert('⚠️ ' + errMsg);
                }
                $('#btnHtlPay').prop('disabled', false).html('Pay via UPI QR');
                if ($('#btnConfirmHtlQrPayment').length) {
                    $('#btnConfirmHtlQrPayment').prop('disabled', false).html('Maine Payment Kar Diya — Confirm Booking');
                }
            }
        });
    }

    function triggerHotelSuccessOverlay(response, amount, custInfo) {
        $('#succBookingCode').text('#' + (response.booking_code || 'DWS-HOTEL-2026'));
        $('#succAmountPaid').text('₹' + parseFloat(amount).toLocaleString('en-IN'));
        $('#succCustomerInfo').text(custInfo);

        if (response.invoice_url) {
            $('#btnSuccHotelVoucher').attr('href', response.invoice_url).css('display', 'flex');
        }
        if (response.company_whatsapp_url || response.whatsapp_url) {
            $('#btnSuccHotelWhatsApp').attr('href', response.company_whatsapp_url || response.whatsapp_url).css('display', 'flex');
        }

        $('#paymentSuccessOverlay').css('display', 'flex');

        var secondsLeft = 10;
        $('#succCountdown').text(secondsLeft);
        $('#succProgressBar').css('width', '100%');

        var targetUrl = response.redirect_url || "{{ route('customer.hotels') }}";

        $('#btnGoDashboard').off('click').on('click', function() {
            window.location.href = targetUrl;
        });

        var timerInt = setInterval(function() {
            secondsLeft--;
            if (secondsLeft < 0) secondsLeft = 0;
            $('#succCountdown').text(secondsLeft);
            var pct = (secondsLeft / 10) * 100;
            $('#succProgressBar').css('width', pct + '%');

            if (secondsLeft <= 0) {
                clearInterval(timerInt);
                window.location.href = targetUrl;
            }
        }, 1000);
    }

    function processHotelCheckoutWhatsApp() {
        var name = ($('#chk_name').val() || '').trim();
        var phone = ($('#chk_phone').val() || '').trim().replace(/[^0-9]/g, '');
        var altPhone = ($('#chk_alt_phone').val() || '').trim();
        var checkin = ($('#chk_checkin').val() || '').trim();
        var checkout = ($('#chk_checkout').val() || '').trim();
        var hotel = ($('#chk_hotel').val() || '').trim() || 'Al-Waris Deluxe Guest House';
        var room = ($('#chk_room').val() || '').trim() || 'Deluxe Room';
        var rooms = parseInt($('#chk_rooms').val()) || 1;
        var price = parseFloat($('#chk_price').val()) || 1499;
        var nights = parseInt($('#chk_nights').val()) || 1;
        var idType = ($('#chk_id_type').val() || '').trim() || 'Aadhaar Card';
        var idNo = ($('#chk_id_no').val() || '').trim();

        if (!name || name.length < 2) {
            showHotelValidationAlert('Kripya Guest ka Pura Naam (Full Name) darj karein!', '#chk_name');
            return;
        }

        if (!phone || phone.length < 10) {
            showHotelValidationAlert('Kripya valid 10-digit Mobile Number darj karein!', '#chk_phone');
            return;
        }

        if (!checkin || !checkout) {
            showHotelValidationAlert('Kripya Check-In aur Check-Out Dates select karein!', '#chk_checkin');
            return;
        }

        // Auto agree terms for WhatsApp booking
        $('#termsAgree').prop('checked', true);

        // Pre-generate unique booking code so message & backend match
        var code = 'DWS-HTL-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000);
        var guestStr = name + " (" + phone + (altPhone ? " / Alt: " + altPhone : "") + ")";
        var idStr = idNo ? (idType + " (" + idNo + ")") : "Will verify at reception check-in / share on WhatsApp";
        var roomStr = room + (rooms > 1 ? " (×" + rooms + " Rooms)" : "");

        var text = "Assalamu Alaikum DewaSharif Hotels!\n\n" +
                   "Main Hotel Room Book karna chahta hun:\n" +
                   "🎫 Booking Ref: #" + code + "\n" +
                   "🏨 Hotel: " + hotel + "\n" +
                   "🛏️ Room: " + roomStr + "\n" +
                   "📅 Stay Dates: " + checkin + " to " + checkout + " (" + nights + " Night" + (nights > 1 ? "s" : "") + (rooms > 1 ? " × " + rooms + " Rooms" : "") + ")\n" +
                   "🪪 Govt ID: " + idStr + "\n" +
                   "⚠️ Check-in Rule: Hotel reception par room lene se pehle physical ID dikhana anivarya hai.\n" +
                   "💰 Total Payable: ₹" + Number(price).toLocaleString('en-IN') + "\n" +
                   "👤 Guest Name: " + guestStr + "\n\n" +
                   "Kripya confirmation aur room registration slip bhejein. Shukriya!";

        var waUrl = "https://wa.me/919648777223?text=" + encodeURIComponent(text);

        // Synchronously open WhatsApp window (never blocked by popup blocker!)
        window.open(waUrl, '_blank');

        // Simultaneously save inquiry in backend
        $.ajax({
            url: "{{ route('hotels.book') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                booking_code: code,
                name: name,
                phone: phone,
                alternate_phone: altPhone,
                hotel_name: hotel,
                room_name: room,
                rooms: rooms,
                rooms_count: rooms,
                checkin: checkin,
                checkout: checkout,
                price: price,
                base_price: $('#chk_base_price').val() || (price / (nights * rooms)),
                id_type: idType,
                id_no: idNo || 'N/A',
                booking_mode: 'whatsapp'
            },
            success: function(response) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'WhatsApp Chat Opened!',
                        html: '<p style="font-size:14px;color:#475569;">Aapka Hotel Stay Request Ref <b>#' + code + '</b> register ho gaya hai. Humne WhatsApp khol diya hai, kripya wahan Send button press karein.</p>',
                        confirmButtonColor: '#074121'
                    });
                }
            },
            error: function(err) {}
        });
    }

    function generateDynamicUpi(amount, note) {
        var upiId = '9648777223@ybl';
        var payeeName = 'SHAHZADE ALAM';
        var cleanAmount = (parseFloat(amount) || 0).toFixed(2);
        var noteText = note || 'Dewa Sharif Hotel Booking';
        
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

    function openHotelQrModal() {
        if (!validateHotelCheckoutForm()) {
            return;
        }

        var price = $('#chk_price').val() || '{{ $price }}';
        var numericPrice = parseFloat(price) || 0;
        var formattedPrice = numericPrice.toLocaleString('en-IN');
        $('#htlQrPayAmountText').text('₹' + formattedPrice);

        var upiData = generateDynamicUpi(numericPrice, 'Dewa Sharif Hotel Booking');
        $('#htlDynamicQrImg').attr('src', upiData.qr);
        $('#htlDirectUpiBtn').attr('href', upiData.uri);
        $('#htlDirectUpiAmount').text('₹' + formattedPrice);

        $('#hotelQrModalOverlay').css('display', 'flex');
    }

    function closeHotelQrModal() {
        $('#hotelQrModalOverlay').hide();
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
            setTimeout(function() {
                btn.innerHTML = originalHtml;
                btn.style.background = '#0f172a';
            }, 2000);
        }
    }

    function sendHotelQrWhatsApp() {
        var name = $('#chk_name').val().trim();
        var phone = $('#chk_phone').val().trim();
        var altPhone = $('#chk_alt_phone').val() || '';
        var hotel = '{{ $hotel }}';
        var room = '{{ $room }}';
        var rooms = parseInt($('#chk_rooms').val()) || 1;
        var checkin = $('#chk_checkin').val();
        var checkout = $('#chk_checkout').val();
        var price = $('#chk_price').val() || '{{ $price }}';
        var nights = $('#chk_nights').val() || 1;
        var idType = $('#chk_id_type').val() || 'Aadhaar Card';
        var idNo = $('#chk_id_no').val().trim();

        var utr = ($('#htl_utr_input').val() || '').trim();
        var paymentId = utr ? ('PhonePe QR (UTR: ' + utr + ')') : 'PhonePe QR (Screenshot on WhatsApp)';
        executeHotelBookingSave(paymentId, utr);

        var guestStr = name + " (" + phone + ")" + (altPhone ? " / Alt: " + altPhone : "");
        var roomStr = room + (rooms > 1 ? " (×" + rooms + " Rooms)" : "");
        var text = "Assalamu Alaikum Dewa Sharif Hotels!\n\n" +
                   "Maine PhonePe QR se payment kar diya hai:\n" +
                   "💰 Total Tariff Paid: ₹" + Number(price).toLocaleString('en-IN') + " (" + nights + " Night" + (nights > 1 ? "s" : "") + (rooms > 1 ? " × " + rooms + " Rooms" : "") + ")\n" +
                   "🏨 Hotel: " + hotel + "\n" +
                   "🛏️ Room: " + roomStr + "\n" +
                   "📅 Stay Dates: " + checkin + " to " + checkout + " (" + nights + " Night" + (nights > 1 ? "s" : "") + ")\n" +
                   "🪪 Govt ID: " + idType + " (" + idNo + ")\n" +
                   "⚠️ Check-in Rule: Hotel reception par room lene se pehle original physical ID dikhana anivarya hai.\n" +
                   "👤 Guest Name: " + guestStr + "\n\n" +
                   "Maine payment ka screenshot WhatsApp par attach kar diya hai. Kripya room reservation confirm karein. Shukriya!";

        window.open("https://wa.me/919648777223?text=" + encodeURIComponent(text), '_blank');
    }
</script>

<!-- PHONEPE / UPI QR PAYMENT MODAL OVERLAY -->
<div id="hotelQrModalOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(6px); z-index: 999998; align-items: center; justify-content: center; padding: 16px; overflow-y: auto;">
    <div style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 20px; padding: 26px 24px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; max-height: 94vh; overflow-y: auto;">
        
        <!-- CLOSE BUTTON -->
        <button type="button" onclick="closeHotelQrModal()" style="position: absolute; top: 16px; right: 18px; background: #f1f5f9; border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 20px; font-weight: 700; color: #475569; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1;">
            ✕
        </button>

        <!-- WEBSITE BRANDING HEADER -->
        <div style="margin-bottom: 14px;">
            <span style="font-size: 13px; font-weight: 800; color: #047857; background: #ecfdf5; padding: 4px 12px; border-radius: 20px; border: 1px solid #d1fae5; letter-spacing: 0.3px;">
                🌐 www.dewasharif.com
            </span>
        </div>

        <!-- HEADER -->
        <div style="display: inline-flex; align-items: center; gap: 8px; background: #fef3c7; border: 1.5px solid #fde68a; padding: 6px 16px; border-radius: 30px; margin-bottom: 12px;">
            <i class="fa fa-qrcode" style="color: #b45309; font-size: 16px;"></i>
            <span style="font-size: 12px; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">PhonePe &amp; All UPI Apps Accepted</span>
        </div>

        <h4 style="font-weight: 900; color: #0f172a; margin-bottom: 4px; font-size: 20px; text-align: center !important;">
            Scan &amp; Pay via QR Code
        </h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 14px; text-align: center !important; width: 100%; display: block; margin-left: auto; margin-right: auto;">
            Pay directly to Merchant: <strong style="color: #0f172a;">SHAHZADE ALAM</strong>
        </p>

        <!-- AMOUNT TO PAY BANNER -->
        <div style="background: linear-gradient(135deg, #074121 0%, #052c16 100%); color: #ffffff; border-radius: 12px; padding: 12px; margin-bottom: 14px;">
            <span style="font-size: 11.5px; font-weight: 700; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Total Tariff to Pay</span>
            <span style="font-size: 26px; font-weight: 900; color: #4ade80;" id="htlQrPayAmountText">₹{{ number_format($price) }}</span>
        </div>

        <!-- DYNAMIC QR IMAGE WITH AUTO AMOUNT EMBEDDED -->
        <div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 12px; margin-bottom: 14px; display: inline-block; max-width: 290px; width: 100%; box-sizing: border-box;">
            <div style="position: relative; width: 230px; height: 230px; margin: 0 auto; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.06); overflow: hidden;">
                <img id="htlDynamicQrImg" 
                     src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=8&data={{ urlencode('upi://pay?pa=9648777223@ybl&pn=SHAHZADE%20ALAM&am=' . number_format($price, 2, '.', '') . '&cu=INR&tn=Dewa%20Sharif%20Hotel%20Booking') }}" 
                     alt="PhonePe Dynamic QR Code" 
                     onerror="this.src='{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}'"
                     style="width: 100%; height: 100%; object-fit: contain; display: block;">
            </div>
            <div style="margin-top: 8px; font-size: 11px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                ✔ Amount Pre-filled on Scan
            </div>
            <div style="margin-top: 6px; font-size: 11.5px; font-weight: 700; color: #475569; text-align: center;">
                📱 PhonePe • Google Pay • Paytm • BHIM
            </div>
            
            <!-- UPI ID BOX WITH 1-CLICK COPY -->
            <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 7px 10px; margin-top: 10px; display: flex; align-items: center; justify-content: space-between; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                <div style="text-align: left; overflow: hidden;">
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase; display: block; line-height: 1;">UPI ID</span>
                    <span style="font-size: 13px; font-weight: 900; color: #0f172a; font-family: monospace; letter-spacing: 0.2px;">9648777223@ybl</span>
                </div>
                <button type="button" onclick="copyUpiId(this)" style="background: #0f172a; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s; white-space: nowrap;">
                    <i class="fa fa-clone"></i> <span>Copy</span>
                </button>
            </div>
        </div>

        <!-- 1-TAP DIRECT UPI APP PAYMENT BUTTON (MOBILE FRIENDLY WITH DESKTOP CHECK) -->
        <div style="margin-bottom: 12px;">
            <a id="htlDirectUpiBtn" 
               href="upi://pay?pa=9648777223@ybl&pn=SHAHZADE%20ALAM&am={{ number_format($price, 2, '.', '') }}&cu=INR&tn=Dewa%20Sharif%20Hotel%20Booking" 
               onclick="return handleUpiClick(event)"
               class="btn w-100 font-extrabold" 
               style="background: linear-gradient(135deg, #5f259f 0%, #3f156d 100%); color: #ffffff; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(95, 37, 159, 0.35); white-space: normal !important; text-align: center; flex-wrap: wrap; line-height: 1.35; box-sizing: border-box;">
                <i class="fa fa-mobile" style="font-size: 22px; flex-shrink: 0;"></i>
                <span>Tap to Pay <strong id="htlDirectUpiAmount">₹{{ number_format($price) }}</strong> via PhonePe / GPay</span>
            </a>
            <small style="color: #64748b; font-size: 11px; display: block; margin-top: 4px;">(If on mobile, tap above to open UPI app directly without scanning)</small>
        </div>

        <!-- UTR / PAYMENT CONFIRMATION SECTION -->
        <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 14px; padding: 14px 16px; margin-bottom: 12px; text-align: left;">
            <label style="font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 5px; display: block;">
                🔢 Enter 12-Digit UPI Ref / UTR No. (from PhonePe/GPay Receipt):
            </label>
            <input type="text" id="htl_utr_input" maxlength="12" placeholder="e.g. 428910482910"
                   style="width: 100%; height: 44px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 0 12px; font-size: 14px; font-weight: 700; letter-spacing: 0.5px; font-family: monospace; background: #ffffff;"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)">
            <small style="font-size: 11px; color: #64748b; font-weight: 600; display: block; margin-top: 4px;">
                💡 Payment successful screen par 12-digit UTR/UPI Ref No. hota hai.
            </small>
        </div>

        <!-- PRIMARY ACTION: CONFIRM BOOKING & GENERATE INVOICE -->
        <div style="margin-bottom: 12px;">
            <button type="button" id="btnConfirmHtlQrPayment" onclick="confirmHotelQrPayment()" style="background: #074121; color: #ffffff; width: 100% !important; font-weight: 800; border-radius: 12px; min-height: 48px; height: auto; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 14px rgba(7, 65, 33, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; box-sizing: border-box; white-space: normal !important; text-align: center; line-height: 1.35; flex-wrap: wrap;">
                <i class="fa fa-check-circle" style="font-size: 18px; color: #4ade80; flex-shrink: 0;"></i>
                <span>Maine Payment Kar Diya — Confirm Booking</span>
            </button>
        </div>

        <!-- SECONDARY ACTION: WHATSAPP SCREENSHOT DISPATCH -->
        <div>
            <button type="button" onclick="sendHotelQrWhatsApp()" style="background: #25D366; color: #ffffff; width: 100% !important; font-weight: 800; border-radius: 12px; min-height: 48px; height: auto; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; box-sizing: border-box; white-space: normal !important; text-align: center; line-height: 1.35; flex-wrap: wrap;">
                <i class="fa fa-whatsapp" style="font-size: 19px; flex-shrink: 0;"></i>
                <span>Send Screenshot on WhatsApp (Optional)</span>
            </button>
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
<div id="paymentSuccessOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(7, 65, 33, 0.88); backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 500px; border-radius: 24px; padding: 35px 30px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        
        <!-- Animated Green Success Checkmark Badge -->
        <div style="width: 85px; height: 85px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 42px; box-shadow: 0 10px 25px rgba(22,163,74,0.3); border: 3.5px solid #22c55e;">
            ✓
        </div>

        <h3 style="font-weight: 900; color: #074121; margin-bottom: 6px; font-size: 24px; letter-spacing: -0.3px;">
            🎉 Payment Successful!
        </h3>
        <p style="color: #64748b; font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            Money Credited to Dewa Sharif Stays. Hotel Reservation confirmed!
        </p>

        <!-- Details Summary Box -->
        <div style="background: #f8fafc; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 18px; margin-bottom: 22px; text-align: left; font-size: 13.5px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #64748b; font-weight: 700;">Booking Reference:</span>
                <span style="font-weight: 900; color: #0f172a;" id="succBookingCode">#DWS-2026</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #64748b; font-weight: 700;">Amount Paid:</span>
                <span style="font-weight: 900; color: #16a34a; font-size: 16px;" id="succAmountPaid">₹0</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #64748b; font-weight: 700;">Guest / Contact:</span>
                <span style="font-weight: 800; color: #334155;" id="succCustomerInfo">-</span>
            </div>
        </div>

        <!-- Countdown Bar -->
        <div style="margin-bottom: 20px;">
            <p style="font-weight: 800; color: #074121; font-size: 13.5px; margin-bottom: 8px;">
                ⌛ Auto-redirecting to Dashboard in <span id="succCountdown" style="color: #e11d48; font-size: 17px; font-weight: 900;">10</span> seconds...
            </p>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div id="succProgressBar" style="width: 100%; height: 100%; background: linear-gradient(90deg, #16a34a, #22c55e); transition: width 1s linear;"></div>
            </div>
        </div>

        <!-- Action Buttons Container -->
        <div style="display: flex; flex-direction: column; gap: 10px; width: 100%;">
            <!-- BUTTON 1: VIEW HOTEL STAY VOUCHER & TAX INVOICE -->
            <a id="btnSuccHotelVoucher" href="#" target="_blank" class="btn"
                style="display: none; width: 100%; background: #16a34a; color: #ffffff; font-weight: 800; font-size: 14px; padding: 12px 16px; border-radius: 10px; border: none; box-shadow: 0 4px 12px rgba(22,163,74,0.3); align-items: center; justify-content: center; gap: 8px; text-decoration: none;">
                <i class="fa fa-file-text-o" style="font-size: 16px;"></i>
                <span>📄 View Stay Voucher &amp; Tax Invoice (PDF)</span>
            </a>

            <!-- BUTTON 2: WHATSAPP SHARE -->
            <a id="btnSuccHotelWhatsApp" href="#" target="_blank" class="btn"
                style="display: none; width: 100%; background: #25D366; color: #ffffff; font-weight: 800; font-size: 14px; padding: 12px 16px; border-radius: 10px; border: none; box-shadow: 0 4px 12px rgba(37,211,102,0.3); align-items: center; justify-content: center; gap: 8px; text-decoration: none;">
                <i class="fa fa-whatsapp" style="font-size: 18px;"></i>
                <span>📱 Send Voucher to Hotel Desk on WhatsApp</span>
            </a>

            <!-- BUTTON 3: DASHBOARD -->
            <button type="button" id="btnGoDashboard" class="btn" style="width: 100%; background: #074121; color: #ffffff; font-weight: 800; font-size: 14px; padding: 12px 16px; border-radius: 10px; border: none; box-shadow: 0 4px 12px rgba(7,65,33,0.3);">
                🚀 Go to Hotel Dashboard Now
            </button>
        </div>

    </div>
</div>

<style>
@keyframes popIn {
    0% { transform: scale(0.7); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endsection
