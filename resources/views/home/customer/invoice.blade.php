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

        /* WATERMARK OVERLAY STAMP */
        .watermark-bg {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-24deg);
            -webkit-transform: translate(-50%, -50%) rotate(-24deg);
            text-align: center;
            white-space: nowrap;
            pointer-events: none;
            user-select: none;
            z-index: 99;
            line-height: 1.25;
            border: none !important;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            text-transform: uppercase;
        }

        .watermark-paid {
            color: #16a34a;
            opacity: 0.18;
        }

        .watermark-pending {
            color: #d97706;
            opacity: 0.20;
        }

        .watermark-failed {
            color: #dc2626;
            opacity: 0.18;
        }

        /* HEADER SECTION */
        .invoice-header {
            position: relative;
            z-index: 2;
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
            position: relative;
            z-index: 2;
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
            position: relative;
            z-index: 2;
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
            background-color: transparent;
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
            background-color: transparent;
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
                    <span class="meta-label" style="display: block; margin-bottom: 3px;">Amount Status:</span>
                    @php
                        $rawPayStatus = strtolower(
                            $paymentStatus ?? ($cabData['payment_status'] ?? ($hotelData['payment_status'] ?? 'pending')),
                        );
                        $hasPaidAmt = !empty($paidAmount) && (float)$paidAmount > 0;
                        $hasDueAmt = !empty($dueAmount) && (float)$dueAmount > 0;
                        $isPaid = in_array($rawPayStatus, ['paid', 'completed', 'success']) && !$hasDueAmt;
                        $isFullPaid = $isPaid;
                        $isPartial = ($rawPayStatus === 'partial') || ($hasPaidAmt && $hasDueAmt && in_array($rawPayStatus, ['paid', 'completed', 'success', 'partial']));
                        $isFailed = in_array($rawPayStatus, ['failed', 'cancelled', 'rejected', 'void']);
                        $isPending = !$isPaid && !$isPartial && !$isFailed;
                    @endphp
                    @if ($isPaid)
                        <span class="badge-paid">✓ PAID &amp; CONFIRMED</span>
                    @elseif($isPartial)
                        <div style="display: inline-block; background: #fef3c7; color: #92400e; border: 1.5px solid #fde68a; font-weight: 800; padding: 6px 12px; border-radius: 6px; font-size: 11px; text-align: right; line-height: 1.4; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <div>✅ ADVANCE RECEIVED &amp; CONFIRMED (₹{{ number_format($paidAmount, 2) }} RECEIVED)</div>
                            <div style="margin-top: 4px; color: #b91c1c; font-weight: 900; font-size: 11.5px; border-top: 1px dashed #fcd34d; padding-top: 3px;">🔴 BALANCE DUE: ₹{{ number_format($dueAmount, 2) }} (PAYABLE ON DELIVERY / NIYAZ)</div>
                        </div>
                    @elseif($isFailed)
                        <span class="badge-failed">❌ PAYMENT FAILED / VOID</span>
                    @else
                        <div style="display: inline-block; background: #fff7ed; color: #c2410c; border: 1.5px solid #fed7aa; font-weight: 800; padding: 6px 12px; border-radius: 6px; font-size: 11px; text-align: right; line-height: 1.4; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            @if($hasPaidAmt)
                                <div>⏳ PROVISIONAL — PAYMENT CONFIRMATION PENDING (₹{{ number_format($paidAmount, 2) }} PROPOSED ADVANCE)</div>
                            @else
                                <div>⏳ PROVISIONAL — PAYMENT CONFIRMATION PENDING</div>
                            @endif
                            @if($hasDueAmt)
                                <div style="margin-top: 4px; color: #ea580c; font-weight: 900; font-size: 11.5px; border-top: 1px dashed #fdba74; padding-top: 3px;">🔴 BALANCE DUE: ₹{{ number_format($dueAmount, 2) }} (PAYABLE UPON CONFIRMATION)</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- DYNAMIC OFFICIAL WATERMARK OVERLAY (Green for Paid, Red for Failed, Amber for Partial, Warning for Pending) --}}
        @if ($isPaid)
            <div class="watermark-bg watermark-paid"
                style="position: absolute; top: 52%; left: 50%; transform: translate(-50%, -50%) rotate(-24deg); -webkit-transform: translate(-50%, -50%) rotate(-24deg); color: #16a34a; opacity: 0.18; text-align: center; white-space: nowrap; pointer-events: none; user-select: none; z-index: 99; border: none; font-family: 'Inter', system-ui, sans-serif;">
                <div style="font-size: 38px; font-weight: 900; letter-spacing: 5px; margin-bottom: 8px;">PAID &amp; VERIFIED</div>
                <div style="font-size: 24px; font-weight: 800; letter-spacing: 8px;">WWW.DEWASHARIF.COM</div>
            </div>
        @elseif ($isPartial)
            <div class="watermark-bg watermark-pending"
                style="position: absolute; top: 52%; left: 50%; transform: translate(-50%, -50%) rotate(-24deg); -webkit-transform: translate(-50%, -50%) rotate(-24deg); color: #d97706; opacity: 0.20; text-align: center; white-space: nowrap; pointer-events: none; user-select: none; z-index: 99; border: none; font-family: 'Inter', system-ui, sans-serif;">
                <div style="font-size: 34px; font-weight: 900; letter-spacing: 4px; margin-bottom: 8px;">ADVANCE RECEIVED &amp; CONFIRMED</div>
                <div style="font-size: 20px; font-weight: 800; letter-spacing: 6px;">WWW.DEWASHARIF.COM</div>
            </div>
        @elseif ($isFailed)
            <div class="watermark-bg watermark-failed"
                style="position: absolute; top: 52%; left: 50%; transform: translate(-50%, -50%) rotate(-24deg); -webkit-transform: translate(-50%, -50%) rotate(-24deg); color: #dc2626; opacity: 0.18; text-align: center; white-space: nowrap; pointer-events: none; user-select: none; z-index: 99; border: none; font-family: 'Inter', system-ui, sans-serif;">
                <div style="font-size: 38px; font-weight: 900; letter-spacing: 5px; margin-bottom: 8px;">PAYMENT FAILED / VOID</div>
                <div style="font-size: 24px; font-weight: 800; letter-spacing: 8px;">WWW.DEWASHARIF.COM</div>
            </div>
        @else
            <div class="watermark-bg watermark-pending"
                style="position: absolute; top: 52%; left: 50%; transform: translate(-50%, -50%) rotate(-24deg); -webkit-transform: translate(-50%, -50%) rotate(-24deg); color: #c2410c; opacity: 0.20; text-align: center; white-space: nowrap; pointer-events: none; user-select: none; z-index: 99; border: none; font-family: 'Inter', system-ui, sans-serif;">
                <div style="font-size: 32px; font-weight: 900; letter-spacing: 4px; margin-bottom: 8px;">PROVISIONAL — CONFIRMATION PENDING</div>
                <div style="font-size: 20px; font-weight: 800; letter-spacing: 6px;">NOT CONFIRMED UNTIL BANK CREDIT</div>
            </div>
        @endif

        @if ($isFailed)
            <div
                style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 8px; padding: 14px 18px; margin-bottom: 25px; color: #991b1b;">
                <div
                    style="display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 14px; margin-bottom: 4px;">
                    <span style="font-size: 18px;">❌</span> PAYMENT SETTLEMENT FAILED — VOUCHER CANCELLED (VOID)
                </div>
                <p style="font-size: 12.5px; margin: 0; line-height: 1.5;">
                    The payment reference / UTR provided was uncredited or rejected during bank verification. This duty
                    voucher is rendered <strong>VOID</strong> and <strong>CANNOT</strong> be accepted. To re-book or clarify your payment, please contact Dewa Sharif Support immediately at
                    <strong>info@dewasharif.com / +91 9648777223</strong>.
                </p>
            </div>
        @elseif($isPending)
            <div
                style="background: #fffbeb; border: 2px dashed #f59e0b; border-radius: 8px; padding: 14px 18px; margin-bottom: 25px; color: #92400e;">
                <div
                    style="display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 13.5px; margin-bottom: 4px;">
                    <span style="font-size: 18px;">⚠️</span> PROVISIONAL QUOTATION / BILL ESTIMATE — SUBJECT TO BANK REALISATION
                </div>
                <p style="font-size: 12px; margin: 0; line-height: 1.5;">
                    <strong>TERMS / NOTICE:</strong> This document is an initial provisional quotation and booking estimate. This receipt shall only be deemed <strong>CONFIRMED &amp; ACCEPTABLE</strong> once the payment (UTR reference or bank transfer receipt) has been verified and credited to the official Dewa Sharif Management bank account. In the absence of verified bank credit realization, this document remains strictly provisional, unconfirmed, and non-claimable.
                </p>
            </div>
        @elseif($isPartial)
            <div
                style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 8px; padding: 12px 18px; margin-bottom: 25px; color: #166534;">
                <div
                    style="display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 13.5px; margin-bottom: 4px;">
                    <span style="font-size: 18px;">✅</span>BOOKING CONFIRMED — PARTIAL ADVANCE VERIFIED
                </div>
                <p style="font-size: 12px; margin: 0; line-height: 1.5;">
                    <strong>SETTLEMENT NOTICE:</strong> An advance payment of <strong>₹{{ number_format($paidAmount, 2) }}</strong> has been verified and credited to Dewa Sharif Management. The remaining balance of <strong>₹{{ number_format($dueAmount, 2) }}</strong> is outstanding and strictly payable prior to service commencement or Niyaz handover.
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

        @if (($type ?? '') === 'hotel' && !$isFailed)
            @php
                $hotelPin = $checkinPin ?? ($hotelData['checkin_pin'] ?? '4821');
                $hotelNameDisplay = $hotelData['hotel_name'] ?? 'Al-Waris Deluxe Guest House';
                $roomNameDisplay = $hotelData['room_name'] ?? ($hotelData['room_type'] ?? 'Deluxe Room');
            @endphp
            <div style="background: linear-gradient(135deg, #052c16 0%, #031c0e 100%); color: #ffffff; border-radius: 8px; padding: 16px 22px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; border: 2px solid #10b981; box-shadow: 0 4px 15px rgba(5,44,22,0.15);">
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #34d399; font-weight: 800; margin-bottom: 3px;">
                        🔐Check-In Voucher &amp; Security PIN
                    </div>
                    <div style="font-size: 15px; font-weight: 800; color: #ffffff;">
                        {{ $hotelNameDisplay }} — {{ $roomNameDisplay }}
                    </div>
                    <div style="font-size: 12.5px; color: rgba(255,255,255,0.85); margin-top: 3px;">
                        Present this secret 4-digit PIN to the hotel reception upon check-in to confirm your stay and collect keys.
                    </div>
                    <div style="font-size: 11px; color: #fde047; margin-top: 4px; font-weight: 700;">
                        ⚠️ 100% Online Security: Room rent is fully paid online. Do NOT pay rent in cash at reception.
                    </div>
                </div>
                <div style="text-align: center; background: rgba(16, 185, 129, 0.18); border: 2px solid #10b981; padding: 10px 20px; border-radius: 10px; min-width: 130px; margin-left: 15px;">
                    <div style="font-size: 10px; text-transform: uppercase; color: #a7f3d0; font-weight: 800; letter-spacing: 1px;">
                        Check-In PIN
                    </div>
                    <div style="font-size: 30px; font-weight: 900; letter-spacing: 6px; color: #ffffff; line-height: 1.15; margin-top: 2px;">
                        {{ $hotelPin }}
                    </div>
                    <div style="font-size: 9px; color: #6ee7b7; font-weight: 600; text-transform: uppercase;">
                        Secret OTP
                    </div>
                </div>
            </div>
        @endif

        @if (($type ?? '') === 'cab' && $isPaid)
            @php
                $rawDriverName = trim($cabData['driver_name'] ?? '');
                $cabDriverName = ($rawDriverName && $rawDriverName !== 'Ramesh Kumar') ? $rawDriverName : '';

                $rawDriverPhone = trim($cabData['driver_phone'] ?? '');
                $cabDriverPhone = ($rawDriverPhone && $rawDriverPhone !== '+91 9648777223' && $rawDriverPhone !== '9876543210') ? $rawDriverPhone : '';

                $rawDriverVehicle = trim($cabData['driver_vehicle_number'] ?? '');
                $cabDriverVehicle = ($rawDriverVehicle && !str_contains($rawDriverVehicle, 'UP 32 AZ 4589') && !str_contains($rawDriverVehicle, 'UP 32 AB 1234') && !str_contains($rawDriverVehicle, 'UP32 AB 1234')) ? $rawDriverVehicle : '';

                $rawDriverAadhaar = trim($cabData['driver_aadhaar'] ?? '');
                $cabDriverAadhaar = ($rawDriverAadhaar && $rawDriverAadhaar !== '1234 5678 9012' && $rawDriverAadhaar !== 'Verified') ? $rawDriverAadhaar : '';

                $cabVehicleCount = (int)($cabData['vehicle_count'] ?? 1);
                if ($cabVehicleCount < 1) { $cabVehicleCount = 1; }

                $cabVehicleModel = $cabData['vehicle_name'] ?? ($cabData['vehicle_type'] ?? ($cabData['vehicle'] ?? 'Cab Taxi'));

                // Strict check: driver is assigned ONLY if real data was entered in DB
                $hasDriverAssigned = !empty($cabDriverName) || !empty($cabDriverPhone) || !empty($cabDriverVehicle);
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
                            ⏳ To Be Allocated
                        </span>
                    @endif
                </div>
                @if ($hasDriverAssigned)
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; font-size: 13px;">
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">👤 Duty Driver:</span>
                            <strong style="color: #0f172a; font-size: 14px;">{{ $cabDriverName ?: 'Duty Driver' }}</strong>
                        </div>
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">📱 Driver Contact:</span>
                            <strong style="color: #0f172a; font-size: 14px;">{{ $cabDriverPhone ?: 'Shared on WhatsApp' }}</strong>
                        </div>
                        @if(!empty($cabDriverAadhaar))
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🪪 Driver Aadhaar:</span>
                            <strong style="color: #1e40af; font-size: 14px;">{{ $cabDriverAadhaar }}</strong>
                        </div>
                        @endif
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🚗 Assigned Vehicle:</span>
                            <strong style="color: #0f172a; font-size: 14px;">{{ $cabVehicleModel }}{{ $cabVehicleCount > 1 ? " ({$cabVehicleCount} Cabs)" : '' }}</strong>
                        </div>
                        <div>
                            <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🔢 Vehicle Number Plate(s):</span>
                            <strong style="color: #15803d; font-size: 14px;">{{ $cabDriverVehicle ?: 'To be shared' }}</strong>
                        </div>
                    </div>
                @else
                    <div style="font-size: 12.5px; color: #334155; line-height: 1.55;">
                        <span style="color: #b45309; font-weight: 700;">⏳ Driver &amp; Vehicle Allocation in Progress:</span>
                        Your ride for <strong>{{ $cabVehicleModel }}</strong>{{ $cabVehicleCount > 1 ? " ({$cabVehicleCount} Cabs)" : '' }} is confirmed &amp; verified. Dedicated driver details, direct phone number, and vehicle number plate will be assigned and shared on your WhatsApp 2 hours prior to journey pickup time.
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
                    <div>
                        <span style="color: #64748b; font-weight: 600; display: block; font-size: 11.5px;">🔐 Reception Check-In PIN:</span>
                        <strong style="color: #1e3a8a; font-size: 16px; background: #dbeafe; padding: 2px 8px; border-radius: 4px; letter-spacing: 2px;">{{ $hotelData['checkin_pin'] ?? '4821' }}</strong>
                    </div>
                </div>
                <div style="margin-top: 12px; padding: 8px 12px; background: #ecfdf5; border: 1.5px solid #10b981; border-radius: 6px; font-size: 11.5px; color: #065f46;">
                    <strong>🛡️ PAID ONLINE TO DEWASHARIF.COM:</strong> Room rent is 100% pre-paid online. <u>Do NOT pay room tariff in cash at reception</u>. Simply present this voucher and quote your 4-digit Check-In PIN during room handover.
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
                        🍲Dewa Sharif — Degh & Niyaz Booking Summary
                    </span>
                    @php
                        $actPkgFee = (float)($packagingFee ?? ($order['packaging_fee'] ?? 0));
                        $actPkgType = strtolower($packagingType ?? ($order['packaging_type'] ?? ''));
                        $isComplimentary = ($actPkgType === 'complimentary' || str_contains($actPkgType, 'complimentary'));
                    @endphp
                    @if($actPkgFee > 0 || $isComplimentary)
                        @php
                            $badgeLabel = match(true) {
                                $isComplimentary => "✓ COMPLIMENTARY PACKAGING COURTESY (₹0)",
                                $actPkgType === 'polythin' || str_contains($actPkgType, 'polythin') => "✓ FOOD-GRADE POLYTHIN PACKING (₹" . number_format($actPkgFee) . ")",
                                $actPkgType === 'box' || str_contains($actPkgType, 'box') || str_contains($actPkgType, 'dabba') => "✓ CONTAINER BOX / DABBA PACKING (₹" . number_format($actPkgFee) . ")",
                                $actPkgType === 'katori' || (str_contains($actPkgType, 'katori') && !str_contains($actPkgType, 'mitti')) => "✓ DISPOSABLE KATORI PACKING (₹" . number_format($actPkgFee) . ")",
                                $actPkgType === 'mitti_katori' || str_contains($actPkgType, 'mitti') => "✓ SACRED MITTI KATORI PACKING (₹" . number_format($actPkgFee) . ")",
                                default => "✓ CUSTOM PACKAGING INCLUDED (₹" . number_format($actPkgFee) . ")"
                            };
                        @endphp
                        <span
                            style="background: #15803d; color: #ffffff; font-weight: 800; font-size: 11px; padding: 4px 12px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.4px;">
                            {{ $badgeLabel }}
                        </span>
                    @endif
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
                            Scheduled Niyaz Date &amp; Time:</span>
                        <strong style="color: #0f172a; font-size: 15px;">{{ $niyazDate ?? $serviceDate }}</strong>
                    </div>
                    @php
                        $distVal = $distributionType ?: ($distribution_type ?: 'Direct Handover / Self Collection at Dewa Sharif');
                        $isDargahLangar = str_contains(strtolower($distVal), 'dargah') || str_contains(strtolower($distVal), 'taqseem') || str_contains(strtolower($distVal), 'langar');
                        $isTakeaway = str_contains(strtolower($distVal), 'takeaway') || str_contains(strtolower($distVal), 'parcel') || str_contains(strtolower($distVal), 'packed');
                        $actDistFee = (float)($distributionFee ?? ($order['distribution_fee'] ?? 0));
                    @endphp
                    <div>
                        <span style="color: #475569; font-weight: 600; display: block; margin-bottom: 3px;">🕌 Tabarruk Distribution Mode:</span>
                        @if($isDargahLangar)
                            <strong style="color: #92400e; font-size: 12.5px; display: inline-flex; align-items: center; gap: 5px; background: #fef3c7; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 6px;">
                                <span>🕌 Dargah Sharif Langar Taqseem (Managed Service)</span>
                                @if($actDistFee > 0)
                                    <span style="background: #d97706; color: #fff; font-size: 10px; font-weight: 800; padding: 1px 6px; border-radius: 10px;">+₹{{ number_format($actDistFee) }}</span>
                                @endif
                            </strong>
                        @elseif($isTakeaway)
                            <strong style="color: #0369a1; font-size: 12.5px; display: inline-flex; align-items: center; gap: 5px; background: #f0f9ff; border: 1px solid #bae6fd; padding: 4px 10px; border-radius: 6px;">
                                <span>📦 Packed Takeaway Handover (Devotee Self-Distribution)</span>
                            </strong>
                        @else
                            <strong style="color: #15803d; font-size: 12.5px; display: inline-flex; align-items: center; gap: 5px; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 4px 10px; border-radius: 6px;">
                                <span>🟢 Direct Handover / Self-Collection</span>
                            </strong>
                        @endif
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
                        <td class="text-right">₹{{ number_format($item['price'], 2) }} &times; {{ $item['qty'] }}</td>
                        {{-- <td class="text-right">₹{{ number_format($item['discount'], 2) }}</td> --}}
                        {{-- <td class="text-right">₹{{ number_format($item['gst'], 2) }}</td> --}}
                        <td class="text-right">₹{{ number_format($item['total'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="text-right">Net Total Amount</td>
                    <td class="text-right">₹{{ number_format($netTotal, 2) }}</td>
                </tr>
                @if(!empty($isPartial))
                    <tr style="background:#f0fdf4; color:#166534; font-weight:700;">
                        <td colspan="3" class="text-right" style="border:1px solid #000; padding:8px 14px;">Advance Amount Received ({{ $paymentMode ?: 'UPI / Cash' }})</td>
                        <td class="text-right" style="border:1px solid #000; padding:8px 14px; color:#15803d; font-weight:800;">- ₹{{ number_format($paidAmount, 2) }}</td>
                    </tr>
                    <tr style="background:#fef2f2; color:#991b1b; font-weight:800; font-size:15px;">
                        <td colspan="3" class="text-right" style="border:1px solid #000; padding:10px 14px;">Balance Due (Payable on Niyaz / Delivery)</td>
                        <td class="text-right" style="border:1px solid #000; padding:10px 14px; color:#dc2626;">₹{{ number_format($dueAmount, 2) }}</td>
                    </tr>
                @elseif(!empty($isPending) && (float)$paidAmount > 0)
                    <tr style="background:#fffbeb; color:#92400e; font-weight:700;">
                        <td colspan="3" class="text-right" style="border:1px solid #000; padding:8px 14px;">Proposed Advance (Payment Confirmation Pending)</td>
                        <td class="text-right" style="border:1px solid #000; padding:8px 14px; color:#b45309; font-weight:800;">₹{{ number_format($paidAmount, 2) }}</td>
                    </tr>
                    <tr style="background:#fff7ed; color:#c2410c; font-weight:800; font-size:15px;">
                        <td colspan="3" class="text-right" style="border:1px solid #000; padding:10px 14px;">Balance Due Upon Confirmation</td>
                        <td class="text-right" style="border:1px solid #000; padding:10px 14px; color:#ea580c;">₹{{ number_format($dueAmount, 2) }}</td>
                    </tr>
                @endif
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
                                in invoice total and must be settled directly against parking slip.</em>
                        </li>
                    </ul>
                </div>
            @endif
        @endif

        <!-- FOOTER / STAMP -->
        <div class="invoice-footer">
            <div class="footer-note">
                • Computer generated Booking Voucher &amp; Receipt under DewaSharif.com Platform.<br>
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
                style="border-color: {{ $isPaid ? '#16a34a' : ($isPartial ? '#d97706' : ($isFailed ? '#dc2626' : '#f59e0b')) }}; background: {{ $isPaid ? '#f0fdf4' : ($isPartial ? '#fffbeb' : ($isFailed ? '#fef2f2' : '#fffbeb')) }};">
                @if ($isPaid)
                    <div class="stamp-title" style="color: #15803d;">✓ VERIFIED &amp; PAID</div>
                    <div class="stamp-sub" style="color: #166534;">Dewa Sharif Trust</div>
                @elseif($isPartial)
                    <div class="stamp-title" style="color: #b45309;">✓ ADVANCE PAID</div>
                    <div class="stamp-sub" style="color: #92400e;">Balance Due: ₹{{ number_format($dueAmount) }}</div>
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
