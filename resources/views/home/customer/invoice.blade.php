<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice - {{ strtoupper($type) }} #{{ $invoiceNo }} | www.dewasharif.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .action-bar {
            width: 100%;
            max-width: 850px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-back {
            background-color: #ffffff;
            color: #334155;
            border: 1px solid #cbd5e1;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-back:hover {
            background-color: #f8fafc;
            color: #0f172a;
        }

        .btn-print {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
        }

        .btn-print:hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.5);
        }

        /* INVOICE CARD */
        .invoice-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 850px;
            padding: 45px 50px;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        /* HEADER SECTION */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 35px;
        }

        .logo-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .logo-img {
            max-height: 85px;
            width: auto;
            object-fit: contain;
            margin-bottom: 8px;
        }

        .company-name {
            font-size: 22px;
            font-weight: 800;
            color: #15803d;
            letter-spacing: -0.5px;
        }

        .company-subtitle {
            font-size: 14px;
            font-weight: 700;
            color: #334155;
            margin-top: 2px;
        }

        .company-details {
            font-size: 12.5px;
            color: #475569;
            line-height: 1.5;
            margin-top: 4px;
        }

        .invoice-meta {
            text-align: right;

        }

        .invoice-title {
            font-size: 32px;
            font-weight: 800;
            color: #15803d;
            margin-top: 15px;
            /* margin-bottom: 12px; */
            letter-spacing: -0.5px;
        }

        .meta-line {
            font-size: 13.5px;
            color: #334155;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .meta-label {
            font-weight: 600;
            color: #475569;
        }

        .meta-val {
            font-weight: 700;
            color: #0f172a;
        }

        .badge-paid {
            display: inline-block;
            background-color: #22c55e;
            color: #ffffff;
            font-weight: 800;
            font-size: 13px;
            padding: 3px 12px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .badge-pending {
            display: inline-block;
            background-color: #f59e0b;
            color: #ffffff;
            font-weight: 800;
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .badge-failed {
            display: inline-block;
            background-color: #dc2626;
            color: #ffffff;
            font-weight: 800;
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .badge-unpaid {
            display: inline-block;
            background-color: #ef4444;
            color: #ffffff;
            font-weight: 800;
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* BILLED TO */
        .billed-to {
            margin-bottom: 35px;
        }

        .billed-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .billed-info {
            font-size: 13.5px;
            color: #334155;
            line-height: 1.5;
        }

        .billed-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 15px;
        }

        /* TABLE */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000000;
            padding: 12px 14px;
            font-size: 13.5px;
        }

        .items-table th {
            background-color: #ffffff;
            color: #0f172a;
            font-weight: 800;
            text-align: left;
        }

        .items-table th.text-center,
        .items-table td.text-center {
            text-align: center;
        }

        .items-table th.text-right,
        .items-table td.text-right {
            text-align: right;
        }

        .items-table td {
            color: #1e293b;
            vertical-align: top;
        }

        .particulars-desc {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        .total-row td {
            font-weight: 800;
            font-size: 15px;
            background-color: #ffffff;
        }

        /* FOOTER / STAMP */
        .invoice-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px dashed #cbd5e1;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer-note {
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
            max-width: 500px;
        }

        .stamp-box {
            text-align: center;
            border: 2px dashed #16a34a;
            padding: 10px 20px;
            border-radius: 8px;
            background: #f0fdf4;
        }

        .stamp-title {
            font-weight: 800;
            color: #15803d;
            font-size: 13px;
        }

        .stamp-sub {
            font-size: 11px;
            color: #166534;
        }

        /* PRINT STYLES */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }

            .action-bar {
                display: none !important;
            }

            .invoice-card {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            @page {
                size: A4;
                margin: 12mm 15mm;
            }
        }
    </style>
</head>

<body>

    <!-- ACTION BAR -->
    <div class="action-bar">
        <a href="{{ route('customer.billing') }}" class="btn-action btn-back">
            ← Back to Customer Portal
        </a>
        <div style="display: flex; gap: 10px;">
            @if (!empty($whatsappShareUrl))
                <a href="{{ $whatsappShareUrl }}" target="_blank" class="btn-action"
                    style="background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); color: #ffffff; text-decoration: none; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);">
                    💬 Share on WhatsApp
                </a>
            @endif
            <button onclick="window.print()" class="btn-action btn-print">
                🖨️ Print / Download PDF
            </button>
        </div>
    </div>

    <!-- INVOICE CARD -->
    <div class="invoice-card">

        <!-- HEADER -->
        <div class="invoice-header">
            <div class="logo-box">
                <img src="{{ asset('home/images/dewasharif/dewa_invoice_logo.png') }}" alt="Dewa Sharif Logo"
                    class="logo-img">
                <div class="company-name">www.dewasharif.com</div>
                <div class="company-subtitle">{{ $serviceName }}</div>
                <div class="company-details">

                    Astana Road, Dewa Sharif, Barabanki, U.P. - India<br>
                    Pin Code : 225301 <br>
                    Phone/WhatsApp :+91 9648777223 <br>
                    Email : info@dewasharif.com
                    <!-- GST No: AZP700SGP29004OSJ -->
                </div>
            </div>

            <div class="invoice-meta">
                <div class="invoice-title">Invoice</div><br><br>
                <div class="meta-line"><span class="meta-label">Invoice No:</span> <span
                        class="meta-val">{{ $invoiceNo }}</span></div>
                <div class="meta-line"><span class="meta-label">Invoice Date:</span> <span
                        class="meta-val">{{ $invoiceDate }}</span></div>
                <div class="meta-line"><span class="meta-label">Service Date:</span> <span
                        class="meta-val">{{ $serviceDate }}</span></div>
                @if (!empty($orderNo))
                    <div class="meta-line"><span class="meta-label">Order ID:</span> <span
                            class="meta-val">{{ $orderNo }}</span></div>
                @endif
                @if (!empty($paymentId))
                    <div class="meta-line"><span class="meta-label">Payment ID:</span> <span
                            class="meta-val">{{ $paymentId }}</span></div>
                @endif
                <div class="meta-line" style="margin-top: 6px;">
                    <span class="meta-label">Amount Status:</span>
                    @php
                        $rawPayStatus = strtolower(
                            $paymentStatus ?? ($cabData['payment_status'] ?? ($hotelData['payment_status'] ?? 'paid')),
                        );
                        $isPaid = in_array($rawPayStatus, ['paid', 'completed', 'success']);
                        $isFailed = in_array($rawPayStatus, ['failed', 'cancelled', 'rejected']);
                        $isPending = !$isPaid && !$isFailed;
                    @endphp
                    @if ($isPaid)
                        <span class="badge-paid">✓ PAID &amp; CONFIRMED</span>
                    @elseif($isFailed)
                        <span class="badge-failed">❌ PAYMENT FAILED / VOID</span>
                    @else
                        <span class="badge-pending">⏳ VERIFICATION PENDING</span>
                    @endif
                </div>
            </div>
        </div>

        @if ($isFailed)
            <div
                style="position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%) rotate(-25deg); font-size: 38px; font-weight: 900; color: rgba(220, 38, 38, 0.16); border: 4px dashed #dc2626; padding: 12px 28px; text-transform: uppercase; pointer-events: none; z-index: 10; letter-spacing: 3px; text-align: center; border-radius: 12px; white-space: nowrap;">
                PAYMENT FAILED / VOID
            </div>
            <div
                style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 8px; padding: 14px 18px; margin-bottom: 25px; color: #991b1b;">
                <div
                    style="display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 14px; margin-bottom: 4px;">
                    <span style="font-size: 18px;">❌</span> PAYMENT SETTLEMENT FAILED — VOUCHER CANCELLED (VOID)
                </div>
                <p style="font-size: 12.5px; margin: 0; line-height: 1.5;">
                    The payment reference / UTR provided was uncredited or rejected during bank verification. This duty
                    voucher is rendered <strong>VOID</strong> and <strong>CANNOT</strong> be accepted by the driver or
                    hotel desk. To re-book or clarify your payment, please contact Dewa Sharif Support immediately at
                    <strong>info@dewasharif.com / +91 9648777223</strong>.
                </p>
            </div>
        @elseif($isPending)
            <div
                style="background: #fffbeb; border: 1.5px solid #f59e0b; border-radius: 8px; padding: 14px 18px; margin-bottom: 25px; color: #92400e;">
                <div
                    style="display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 13.5px; margin-bottom: 4px;">
                    <span style="font-size: 18px;">⏳</span> UPI QR PAYMENT SUBMITTED — SETTLEMENT VERIFICATION UNDERWAY
                </div>
                <p style="font-size: 12px; margin: 0; line-height: 1.5;">
                    Booking reserved against UPI Reference / UTR:
                    <strong>{{ $cabData['utr_number'] ?? ($hotelData['utr_number'] ?? ($paymentId ?? 'Submitted')) }}</strong>.
                    Vehicle dispatch &amp; duty assignment is subject to bank credit settlement verification by Dewa
                    Sharif desk.
                </p>
            </div>
        @endif

        <!-- BILLED TO -->
        <div class="billed-to">
            <div class="billed-title">BILLED TO (PASSENGER / GUEST / DEVOTEE)</div>
            <div class="billed-info">
                <div class="billed-name" style="font-size: 17px; font-weight: 800; color: #15803d; margin-bottom: 4px;">
                    {{ $customerName }}</div>
                <div style="font-size: 13px; color: #334155; margin-bottom: 2px;">📍 <strong>Address:</strong>
                    {{ $customerAddress ?? 'Dewa Sharif, Barabanki, Uttar Pradesh' }}</div>
                <div style="font-size: 13px; color: #334155; margin-bottom: 2px;">📞 <strong>Mobile:</strong>
                    {{ $customerPhone }}</div>
                @if (!empty($customerAltPhone))
                    <div style="font-size: 13px; color: #334155; margin-bottom: 2px;">📱 <strong>Alternate
                            Contact:</strong> {{ $customerAltPhone }}</div>
                @endif
                @if (!empty($customerEmail))
                    <div style="font-size: 13px; color: #334155; margin-bottom: 2px;">✉️ <strong>Email:</strong>
                        {{ $customerEmail }}</div>
                @endif
                @if (!empty($idInfo))
                    <div style="font-size: 13px; color: #15803d; margin-top: 4px; font-weight: 700;">🪪 <strong>Govt
                            ID:</strong> {{ $idInfo }}</div>
                    @if (($type ?? '') === 'cab')
                        <div style="font-size: 11.5px; color: #166534; margin-top: 2px; font-weight: 600;">⚠️
                            <strong>Boarding Rule:</strong> Passenger must present this original physical ID card to
                            driver before boarding.
                        </div>
                    @elseif(($type ?? '') === 'hotel')
                        <div style="font-size: 11.5px; color: #166534; margin-top: 2px; font-weight: 600;">⚠️
                            <strong>Check-in Rule:</strong> Guest must present this original physical ID card at
                            reception desk during check-in.
                        </div>
                    @endif
                @endif
            </div>
        </div>

        @if (($type ?? '') === 'cab')
            @php
                $cabDriverName = $cabData['driver_name'] ?? null;
                $cabDriverPhone = $cabData['driver_phone'] ?? null;
                $cabDriverVehicle = $cabData['driver_vehicle_number'] ?? null;
                $hasDriverAssigned =
                    (!empty($cabDriverName) && $cabDriverName !== 'Ramesh Kumar') ||
                    (!empty($cabData['driver']) &&
                        !str_contains($cabData['driver'], 'Progress') &&
                        !str_contains($cabData['driver'], 'Pending'));
            @endphp
            <div
                style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 16px 20px; margin-bottom: 25px;">
                <div
                    style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                    <span
                        style="font-weight: 800; color: #0f172a; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                        🚖 Assigned Vehicle &amp; Duty Driver Details
                    </span>
                    @if ($hasDriverAssigned)
                        <span
                            style="background: #dcfce7; color: #15803d; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 12px; text-transform: uppercase;">
                            ✓ Driver Dispatched
                        </span>
                    @else
                        <span
                            style="background: #fef3c7; color: #b45309; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 12px; text-transform: uppercase;">
                            ⏳ In Progress
                        </span>
                    @endif
                </div>
                @if ($hasDriverAssigned)
                    @php
                        $cabVehicleModel =
                            $cabData['vehicle_name'] ??
                            ($cabData['vehicle_type'] ?? ($cabData['vehicle'] ?? 'Cab Taxi'));
                    @endphp
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; font-size: 13px;">
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">👤 Duty
                                Driver:</span>
                            <strong
                                style="color: #0f172a; font-size: 14px;">{{ $cabDriverName ?: $cabData['driver'] ?? 'Assigned Driver' }}</strong>
                        </div>
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">📱 Driver
                                Contact:</span>
                            <strong
                                style="color: #0f172a; font-size: 14px;">{{ $cabDriverPhone ?: '+91 9648777223' }}</strong>
                        </div>
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🚗
                                Assigned Vehicle:</span>
                            <strong style="color: #0f172a; font-size: 14px;">{{ $cabVehicleModel }}</strong>
                        </div>
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🔢
                                Vehicle Number Plate:</span>
                            <strong
                                style="color: #15803d; font-size: 14px;">{{ $cabDriverVehicle ?: 'UP 32 AZ 4589' }}</strong>
                        </div>
                    </div>
                @else
                    @php
                        $cabVehicleModel =
                            $cabData['vehicle_name'] ??
                            ($cabData['vehicle_type'] ?? ($cabData['vehicle'] ?? 'Cab Taxi'));
                    @endphp
                    <div style="font-size: 12.5px; color: #334155; line-height: 1.5;">
                        <span style="color: #b45309; font-weight: 700;">⏳ Driver Assignment in Progress:</span>
                        Your ride for <strong>{{ $cabVehicleModel }}</strong> is confirmed. Driver name, direct phone
                        number, and vehicle plate number will be assigned and sent via SMS/WhatsApp prior to journey
                        pickup time.
                    </div>
                @endif
            </div>
        @endif

        @if (($type ?? '') === 'hotel')
            @php
                $hotelStayName = $hotelData['hotel_name'] ?? 'Al-Waris Deluxe Guest House';
                $roomCategory = $hotelData['room_name'] ?? ($hotelData['room_type'] ?? 'Deluxe AC Room');
                $rawIn = $hotelData['check_in'] ?? ($hotelData['checkin'] ?? null);
                $rawOut = $hotelData['check_out'] ?? ($hotelData['checkout'] ?? null);
                $checkinDate = $rawIn ? date('d M Y', strtotime($rawIn)) : 'N/A';
                $checkoutDate = $rawOut ? date('d M Y', strtotime($rawOut)) : 'N/A';
                $stayNights = $hotelData['nights'] ?? 1;
            @endphp
            <div
                style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 16px 20px; margin-bottom: 25px;">
                <div
                    style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                    <span
                        style="font-weight: 800; color: #0f172a; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                        🏨 Confirmed Hotel Room Reservation Details
                    </span>
                    <span
                        style="background: #dcfce7; color: #15803d; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 12px; text-transform: uppercase;">
                        ✓ Room Reserved
                    </span>
                </div>
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; font-size: 13px;">
                    <div>
                        <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🏨 Hotel
                            Property:</span>
                        <strong style="color: #0f172a; font-size: 14px;">{{ $hotelStayName }}</strong>
                    </div>
                    <div>
                        <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🛏️ Room
                            Type:</span>
                        <strong style="color: #15803d; font-size: 14px;">{{ $roomCategory }}</strong>
                    </div>
                    <div>
                        <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">📅 Stay
                            Duration:</span>
                        <strong style="color: #0f172a; font-size: 14px;">{{ $checkinDate }} → {{ $checkoutDate }}
                            ({{ $stayNights }} Night{{ $stayNights > 1 ? 's' : '' }})</strong>
                    </div>
                </div>
            </div>
        @endif

        @if (!empty($isDegh) || !empty($fatehaName))
            <!-- SACRED DEGH NIYAZ & DUA CERTIFICATE BOX -->
            <div
                style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px solid #86efac; border-radius: 8px; padding: 18px 22px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.08);">
                <div
                    style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; border-bottom: 1px solid #bbf7d0; padding-bottom: 8px;">
                    <span
                        style="font-weight: 800; color: #166534; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                        🍲 Aastana-e-Aaliya Dewa Sharif — Degh Niyaz Booking Summary
                    </span>
                    <span
                        style="background: #15803d; color: #ffffff; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 12px; text-transform: uppercase;">
                        ✓ Parcel / Distribution Ready
                    </span>
                </div>
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px; font-size: 13px;">
                    <div>
                        <span style="color: #475569; font-weight: 600; display: block; margin-bottom: 2px;">🤲 Niyaz
                            Ba-Naam (Fateha):</span>
                        <strong
                            style="color: #0f172a; font-size: 15px;">{{ $fatehaName ?: 'Special Dua & Fateha Offering' }}</strong>
                    </div>
                    <div>
                        <span style="color: #475569; font-weight: 600; display: block; margin-bottom: 2px;">📅
                            Scheduled Niyaz Date:</span>
                        <strong style="color: #0f172a; font-size: 15px;">{{ $niyazDate ?? $serviceDate }}</strong>
                    </div>
                    <div>
                        <span style="color: #475569; font-weight: 600; display: block; margin-bottom: 2px;">🕌 Tabarruk
                            Distribution Mode:</span>
                        <strong
                            style="color: #15803d; font-size: 13.5px;">{{ $distributionType ?? 'Dargah Sharif Me Langar Taqseem' }}</strong>
                    </div>
                </div>
            </div>
        @endif

        <!-- ITEMS TABLE -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 8%;">SL NO.</th>
                    <th style="width: 58%;">Particulars</th>
                    <th class="text-right" style="width: 18%;">Price</th>
                    {{-- GST & Discount commented out until post-mela GST registration --}}
                    {{-- <th class="text-right" style="width: 10%;">Discount</th> --}}
                    {{-- <th class="text-right" style="width: 10%;">GST</th> --}}
                    <th class="text-right" style="width: 16%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td class="text-center">{{ $item['sl'] }}</td>
                        <td>
                            <strong>{{ $item['particulars'] }}</strong>
                            @if (!empty($item['desc']))
                                <div class="particulars-desc">{{ $item['desc'] }}</div>
                            @endif
                        </td>
                        <td class="text-right">₹{{ number_format($item['price'], 2) }}x{{ $item['qty'] }}</td>
                        {{-- <td class="text-right">₹{{ number_format($item['discount'], 2) }}</td> --}}
                        {{-- <td class="text-right">₹{{ number_format($item['gst'], 2) }}</td> --}}
                        <td class="text-right">₹{{ number_format($item['total'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="text-right">Net Total Amount</td>
                    <td class="text-right">₹{{ number_format($netTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>

        @if (($type ?? '') === 'cab')
            @php
                $cabParking = \App\Helpers\DataStore::getItem('cab_parking_policy', 1) ?? ['status' => 'Active'];
                $isPolActive = ($cabParking['status'] ?? 'Active') === 'Active';
            @endphp
            @if ($isPolActive)
                <div
                    style="margin: 18px 0; padding: 12px 16px; background: #fffbeb; border: 1px solid #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px; font-size: 12px; color: #78350f;">
                    <div
                        style="font-weight: 800; font-size: 12.5px; margin-bottom: 5px; color: #92400e; display: flex; align-items: center; gap: 6px;">
                        <span>🅿️ Important Parking &amp; Waiting Policy Instruction:</span>
                    </div>
                    <ul style="margin: 0; padding-left: 18px; line-height: 1.55; color: #78350f;">
                        <li><strong>Airport Pickup/Drop:</strong>
                            {{ $cabParking['airport_note'] ?? 'First 10 minutes free entry/parking at Airport. Any extra waiting/parking beyond 10 mins is directly payable by customer as per actual parking receipt.' }}
                        </li>
                        <li><strong>Sightseeing &amp; Monuments:</strong>
                            {{ $cabParking['sightseeing_note'] ?? 'Sightseeing and monument entry parking charges are excluded from total fare and payable directly by customer on actual receipt.' }}
                        </li>
                        <li
                            style="color: #b45309; font-size: 11px; list-style-type: none; margin-left: -18px; margin-top: 4px;">
                            <em>*Notice: Standard taxi fare covers transit &amp; toll. Any parking fee is non-inclusive
                                in invoice total and must be settled directly against official parking slip.</em>
                        </li>
                    </ul>
                </div>
            @endif
        @endif

        <!-- FOOTER / STAMP -->
        <div class="invoice-footer">
            <div class="footer-note">
                • Computer generated official Booking Voucher &amp; Receipt under DewaSharif.com Platform.<br>
                • <strong>Statutory Safe Harbor Notice:</strong> DewaSharif.com is an independent technology booking
                facilitator under Section 79 of the IT Act, 2000. Physical premises safety, guest ledger entry under
                Sarai Act / police rules, and vehicular travel safety remain the exclusive statutory responsibility of
                respective hotel operators and licensed cab drivers.
                @if (($type ?? '') === 'cab')
                    <br>• <strong>Parking Policy:</strong> Airport 10 mins free entry. Extra airport or monument parking
                    payable directly by passenger on actual receipt.
                @endif <br>
                • Managed &amp; Supervised by Shahzade Alam / Masharrat Warsi.
            </div>
            <div class="stamp-box"
                style="border-color: {{ $isPaid ? '#16a34a' : ($isFailed ? '#dc2626' : '#f59e0b') }}; background: {{ $isPaid ? '#f0fdf4' : ($isFailed ? '#fef2f2' : '#fffbeb') }};">
                @if ($isPaid)
                    <div class="stamp-title" style="color: #15803d;">✓ VERIFIED &amp; PAID</div>
                    <div class="stamp-sub" style="color: #166534;">Dewa Sharif Trust</div>
                @elseif($isFailed)
                    <div class="stamp-title" style="color: #dc2626;">❌ PAYMENT FAILED / VOID</div>
                    <div class="stamp-sub" style="color: #991b1b;">Not Valid for Boarding/Check-in</div>
                @else
                    <div class="stamp-title" style="color: #d97706;">⏳ PROVISIONAL VOUCHER</div>
                    <div class="stamp-sub" style="color: #92400e;">Settlement Verification Underway</div>
                @endif
            </div>
        </div>

    </div>

</body>

</html>
