<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelPartner;
use App\Models\HotelSettlement;
use App\Models\HotelBooking;
use App\Helpers\DataStore;
use Illuminate\Http\Request;

class HotelPartnerAdminController extends Controller
{
    public function index()
    {
        $partners = HotelPartner::with(['hotel', 'settlements'])->orderBy('id', 'desc')->get();
        $allBookings = DataStore::getCollection('hotel_bookings');

        $totalPlatformCommission = 0;
        $totalSettledPayouts = 0;
        $totalPendingPayouts = 0;

        // Calculate balances for each partner
        $partnerStats = [];
        foreach ($partners as $partner) {
            $hId = (int)($partner->hotel_id ?? 0);
            $pName = strtolower(trim($partner->hotel_name ?? ''));

            $grossBookings = 0;
            $partnerShare = 0;
            $platformCut = 0;
            $confirmedCount = 0;
            $cancelledCount = 0;

            foreach ($allBookings as $b) {
                $bHotelId = (int)(is_array($b) ? ($b['hotel_id'] ?? 0) : ($b->hotel_id ?? 0));
                $bHotelName = strtolower(trim(is_array($b) ? ($b['hotel_name'] ?? '') : ($b->hotel_name ?? '')));

                $match = false;
                if ($hId > 0 && $bHotelId === $hId) {
                    $match = true;
                } elseif (!empty($pName) && str_contains($bHotelName, $pName)) {
                    $match = true;
                }

                if ($match) {
                    $st = strtolower(is_array($b) ? ($b['status'] ?? '') : ($b->status ?? ''));
                    $amt = (float)(is_array($b) ? ($b['total_amount'] ?? ($b['amount'] ?? 0)) : ($b->total_amount ?? ($b->amount ?? 0)));

                    if (str_contains($st, 'cancel')) {
                        $cancelledCount++;
                        $hotelCancelShare = (float)(is_array($b) ? ($b['cancellation_hotel_share'] ?? 0) : ($b->cancellation_hotel_share ?? 0));
                        $partnerShare += $hotelCancelShare;
                    } else {
                        $confirmedCount++;
                        $grossBookings += $amt;
                        $rate = (float)($partner->commission_rate ?? 20.00);
                        $pShare = (float)(is_array($b) ? ($b['hotel_payout_amount'] ?? 0) : ($b->hotel_payout_amount ?? 0));
                        if ($pShare <= 0) {
                            $pShare = round($amt * ((100 - $rate) / 100), 2);
                        }
                        $partnerShare += $pShare;
                        $platformCut += round($amt * ($rate / 100), 2);
                    }
                }
            }

            $settledSoFar = (float)$partner->settlements->sum('amount_paid');
            $balanceDue = max(0, round($partnerShare - $settledSoFar, 2));

            $totalPlatformCommission += $platformCut;
            $totalSettledPayouts += $settledSoFar;
            $totalPendingPayouts += $balanceDue;

            $partnerStats[$partner->id] = [
                'gross' => $grossBookings,
                'partner_share' => $partnerShare,
                'platform_cut' => $platformCut,
                'settled' => $settledSoFar,
                'balance' => $balanceDue,
                'confirmed_count' => $confirmedCount,
                'cancelled_count' => $cancelledCount,
            ];
        }

        $allSettlements = HotelSettlement::with('partner')->orderBy('created_at', 'desc')->take(25)->get();

        return view('admin.hotels.partners', compact(
            'partners',
            'partnerStats',
            'totalPlatformCommission',
            'totalSettledPayouts',
            'totalPendingPayouts',
            'allSettlements'
        ));
    }

    public function toggleStatus($id)
    {
        $partner = HotelPartner::findOrFail($id);
        $newStatus = ($partner->status === 'active') ? 'suspended' : 'active';
        $partner->update(['status' => $newStatus]);

        $action = ($newStatus === 'active') ? 'Activated' : 'Suspended';
        return back()->with('success', "Hotel Partner '{$partner->name}' ({$partner->hotel_name}) has been {$action}!");
    }

    public function paySettlement(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:hotel_partners,id',
            'amount_paid' => 'required|numeric|min:1',
            'payment_mode' => 'required|string',
            'transaction_ref' => 'nullable|string|max:100',
            'admin_notes' => 'nullable|string',
        ]);

        $partner = HotelPartner::findOrFail($request->input('partner_id'));
        $amountPaid = (float)$request->input('amount_paid');
        $hotelId = (int)($partner->hotel_id ?? 0);
        $mode = $request->input('payment_mode');

        // Smart ref fallback if left blank
        $txnRef = trim((string)$request->input('transaction_ref'));
        if (empty($txnRef)) {
            $txnRef = (str_contains(strtolower($mode), 'cash'))
                ? ('CASH-RCV-' . date('Ymd') . '-' . rand(100, 999))
                : ('TRF-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)));
        }

        $notes = trim((string)$request->input('admin_notes'));
        if (empty($notes) && str_contains(strtolower($mode), 'cash')) {
            $notes = 'Physical cash handed over in person by DewaSharif Admin.';
        }

        // Generate unique settlement code
        $code = 'STL-HTL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $settlement = HotelSettlement::create([
            'settlement_code' => $code,
            'hotel_id' => $hotelId,
            'hotel_partner_id' => $partner->id,
            'amount_paid' => $amountPaid,
            'payment_mode' => $mode,
            'transaction_ref' => $txnRef,
            'admin_notes' => $notes ?: 'Regular settlement verified against completed check-ins.',
            'settled_by_admin_id' => auth()->id() ?? 1,
            'settled_at' => now(),
        ]);

        // Mark associated bookings as settled
        try {
            HotelBooking::where('hotel_id', $hotelId)
                ->where('settlement_status', 'pending')
                ->update([
                    'settlement_status' => 'paid',
                    'settlement_id' => $settlement->id,
                ]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Settlement of ₹" . number_format($amountPaid, 2) . " processed successfully for {$partner->hotel_name}! Reference: {$settlement->transaction_ref}");
    }

    public function refunds()
    {
        $allBookings = DataStore::getCollection('hotel_bookings');
        $refundQueue = [];

        foreach ($allBookings as $b) {
            $st = strtolower(is_array($b) ? ($b['status'] ?? '') : ($b->status ?? ''));
            $refundSt = strtolower(is_array($b) ? ($b['refund_status'] ?? 'none') : ($b->refund_status ?? 'none'));

            if (str_contains($st, 'cancel') || $refundSt !== 'none') {
                $refundQueue[] = $b;
            }
        }

        return view('admin.hotels.refunds', compact('refundQueue'));
    }

    public function processRefund(Request $request, $id)
    {
        $request->validate([
            'refund_utr' => 'required|string|max:100',
        ]);

        $utr = trim($request->input('refund_utr'));

        $update = [
            'refund_status' => 'refunded',
            'refund_utr' => $utr,
            'refund_processed_at' => now()->toDateTimeString(),
            'status' => 'Cancelled & Refunded',
        ];

        DataStore::updateItem('hotel_bookings', $id, $update);
        try {
            HotelBooking::where('id', $id)->update($update);
        } catch (\Throwable $e) {}

        return back()->with('success', "Customer refund for Booking #{$id} marked as REFUNDED with UTR: {$utr}!");
    }
}
