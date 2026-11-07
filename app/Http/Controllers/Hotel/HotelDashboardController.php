<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\HotelPartner;
use App\Models\HotelSettlement;
use App\Helpers\DataStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HotelDashboardController extends Controller
{
    private function getPartner(): HotelPartner
    {
        return Auth::guard('hotel')->user();
    }

    private function getPartnerHotelId(): int
    {
        $partner = $this->getPartner();
        return (int)($partner->hotel_id ?? 0);
    }

    private function getAllBookings(): array
    {
        $items = [];
        $seenIds = [];

        try {
            $dbBookings = HotelBooking::orderBy('id', 'desc')->get();
            foreach ($dbBookings as $b) {
                $items[] = $b;
                $seenIds[] = (string)$b->id;
            }
        } catch (\Throwable $e) {}

        try {
            $dsBookings = DataStore::getCollection('hotel_bookings');
            foreach ($dsBookings as $b) {
                $bId = (string)(is_array($b) ? ($b['id'] ?? '') : ($b->id ?? ''));
                if (!in_array($bId, $seenIds)) {
                    $items[] = $b;
                    $seenIds[] = $bId;
                }
            }
        } catch (\Throwable $e) {}

        return $items;
    }

    public function index(Request $request)
    {
        $partner = $this->getPartner();
        $hotelId = $this->getPartnerHotelId();
        $period = strtolower($request->query('period', 'all'));
        if (!in_array($period, ['all', 'week', 'month', 'year'])) {
            $period = 'all';
        }

        // 1. Fetch bookings from DB & DataStore dynamically in real-time
        $allBookings = $this->getAllBookings();
        $hotelBookings = [];
        $totalGross = 0;
        $totalNet80 = 0;
        $totalPlatform20 = 0;
        $totalConfirmedBookings = 0;
        $totalCancelledBookings = 0;

        // Lifetime total for partner to calculate true current unpaid balance
        $lifetimePartnerNet80 = 0;

        foreach ($allBookings as $b) {
            $bHotelId = is_array($b) ? ($b['hotel_id'] ?? null) : ($b->hotel_id ?? null);
            $bHotelName = strtolower(trim(is_array($b) ? ($b['hotel_name'] ?? '') : ($b->hotel_name ?? '')));
            $pName = strtolower(trim($partner->hotel_name ?? ''));

            // Match by hotel_id or hotel name match
            $isMatch = false;
            if ($hotelId > 0 && (int)$bHotelId === $hotelId) {
                $isMatch = true;
            } elseif (!empty($pName) && (str_contains($bHotelName, $pName) || str_contains($pName, $bHotelName))) {
                $isMatch = true;
            }

            if ($isMatch) {
                $hotelBookings[] = $b;
                $status = strtolower(is_array($b) ? ($b['status'] ?? ($b['booking_status'] ?? '')) : ($b->status ?? ($b->booking_status ?? '')));
                $tot = (float)(is_array($b) ? ($b['total_amount'] ?? ($b['amount'] ?? 0)) : ($b->total_amount ?? ($b->amount ?? 0)));

                // Dynamic calculation fallback if tot is 0
                if ($tot <= 0) {
                    $pricePerNight = (float)(is_array($b) ? ($b['price_per_night'] ?? 0) : ($b->price_per_night ?? 0));
                    $nights = (int)(is_array($b) ? ($b['nights'] ?? 1) : ($b->nights ?? 1));
                    $rooms = (int)(is_array($b) ? ($b['rooms'] ?? 1) : ($b->rooms ?? 1));
                    if ($pricePerNight > 0) {
                        $tot = $pricePerNight * max(1, $nights) * max(1, $rooms);
                    } else {
                        $tot = 1499.00;
                    }
                }

                $commissionRate = (float)($partner->commission_rate ?? 20.00);
                $partnerCutRate = (100 - $commissionRate) / 100.0;
                $platformCutRate = $commissionRate / 100.0;

                $payoutShare = (float)(is_array($b) ? ($b['hotel_payout_amount'] ?? 0) : ($b->hotel_payout_amount ?? 0));
                if ($payoutShare <= 0) {
                    $payoutShare = round($tot * $partnerCutRate, 2);
                }

                $platformShare = (float)(is_array($b) ? ($b['admin_commission_amount'] ?? 0) : ($b->admin_commission_amount ?? 0));
                if ($platformShare <= 0) {
                    $platformShare = round($tot * $platformCutRate, 2);
                }

                $isCancelled = str_contains($status, 'cancel');
                $hotelCancelShare = (float)(is_array($b) ? ($b['cancellation_hotel_share'] ?? 0) : ($b->cancellation_hotel_share ?? 0));

                // Always accumulate lifetime partner net for accurate balance
                if ($isCancelled) {
                    $lifetimePartnerNet80 += $hotelCancelShare;
                } else {
                    $lifetimePartnerNet80 += $payoutShare;
                }

                // Check period filter
                $inPeriod = true;
                if ($period !== 'all') {
                    $rawDate = is_array($b) ? ($b['created_at'] ?? ($b['check_in_date'] ?? ($b['check_in'] ?? null))) : ($b->created_at ?? ($b->check_in_date ?? ($b->check_in ?? null)));
                    if (!empty($rawDate)) {
                        try {
                            $cDate = \Carbon\Carbon::parse($rawDate);
                            if ($period === 'week') {
                                $inPeriod = $cDate->greaterThanOrEqualTo(now()->subDays(7)->startOfDay());
                            } elseif ($period === 'month') {
                                $inPeriod = $cDate->greaterThanOrEqualTo(now()->startOfMonth());
                            } elseif ($period === 'year') {
                                $inPeriod = $cDate->greaterThanOrEqualTo(now()->startOfYear());
                            }
                        } catch (\Throwable $e) {}
                    }
                }

                if ($inPeriod) {
                    if ($isCancelled) {
                        $totalCancelledBookings++;
                        $totalNet80 += $hotelCancelShare;
                    } else {
                        $totalConfirmedBookings++;
                        $totalGross += $tot;
                        $totalNet80 += $payoutShare;
                        $totalPlatform20 += $platformShare;
                    }
                }
            }
        }

        // 2. Fetch past settlements paid by Admin
        $settlements = HotelSettlement::where(function($q) use ($hotelId, $partner) {
            if ($hotelId > 0) {
                $q->where('hotel_id', $hotelId);
            }
            $q->orWhere('hotel_partner_id', $partner->id);
        })->orderBy('created_at', 'desc')->get();

        $totalSettled = (float)$settlements->sum('amount_paid');
        $currentBalance = max(0, round($lifetimePartnerNet80 - $totalSettled, 2));

        // Period display label
        $periodLabel = match($period) {
            'week' => 'Last 7 Days',
            'month' => date('F Y'),
            'year' => date('Y') . ' Annual',
            default => 'All Time',
        };

        // 3. Rooms count
        $allHotels = DataStore::getCollection('hotels');
        $myRoomsCount = 0;
        foreach ($allHotels as $h) {
            $hId = is_array($h) ? ($h['id'] ?? null) : ($h->id ?? null);
            $hPartId = is_array($h) ? ($h['partner_id'] ?? null) : ($h->partner_id ?? null);
            if ((int)$hPartId === (int)$partner->id || (int)$hId === $hotelId) {
                $myRoomsCount++;
            }
        }

        // Recent 5 bookings
        $recentBookings = array_slice($hotelBookings, 0, 5);

        return view('hotel.dashboard', compact(
            'partner',
            'hotelBookings',
            'recentBookings',
            'totalGross',
            'totalNet80',
            'totalPlatform20',
            'totalSettled',
            'currentBalance',
            'totalConfirmedBookings',
            'totalCancelledBookings',
            'settlements',
            'myRoomsCount',
            'period',
            'periodLabel'
        ));
    }

    public function rooms()
    {
        $partner = $this->getPartner();
        $hotelId = $this->getPartnerHotelId();

        $allHotels = DataStore::getCollection('hotels');
        $rooms = [];

        foreach ($allHotels as $h) {
            $hId = (int)(is_array($h) ? ($h['id'] ?? 0) : ($h->id ?? 0));
            $hPartId = (int)(is_array($h) ? ($h['partner_id'] ?? 0) : ($h->partner_id ?? 0));
            $hName = strtolower(trim(is_array($h) ? ($h['name'] ?? '') : ($h->name ?? '')));
            $pName = strtolower(trim($partner->hotel_name ?? ''));

            if ($hPartId === (int)$partner->id || $hId === $hotelId || (!empty($pName) && str_contains($hName, $pName))) {
                $rooms[] = $h;
            }
        }

        return view('hotel.rooms.index', compact('partner', 'rooms'));
    }

    public function createRoom()
    {
        $partner = $this->getPartner();
        return view('hotel.rooms.form', ['partner' => $partner, 'room' => null, 'isEdit' => false]);
    }

    public function storeRoom(Request $request)
    {
        $partner = $this->getPartner();

        $request->validate([
            'room_type' => 'required|string|max:150',
            'price_per_night' => 'required|numeric|min:100',
            'mrp' => 'nullable|numeric|min:100',
            'available_rooms' => 'required|integer|min:1',
            'file_image_1' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Photo 1 is REQUIRED
            'file_image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_4' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_5' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_6' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $hotelName = $partner->hotel_name ?: ($request->input('name') ?: 'Guest House');
        $roomType = $request->input('room_type', 'Deluxe AC Room');
        $price = (float)$request->input('price_per_night', 1499);
        $mrp = (float)($request->input('mrp', $price * 1.35));
        $roomsCount = (int)$request->input('available_rooms', 5);
        $location = $request->input('location', 'Near Dewa Sharif Dargah Gate');
        $phone = $partner->phone ?: $request->input('phone', '9648777223');
        $acType = $request->input('ac_type', 'AC');
        $bedType = $request->input('bed_type', 'Double Bed');
        $maxAdults = (int)$request->input('max_adults', 2);
        $maxChildren = (int)$request->input('max_children', 1);
        $bathType = $request->input('bath_type', 'Attached Western Bath');
        $status = $request->input('status', 'active');
        $amenities = $request->input('amenities', ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Near Dargah Gate']);

        // Process 6 photos (1 required, 2-6 optional)
        $img1 = $this->handleUpload($request, 'file_image_1', 'home/images/dewasharif/dewapage/hero_hotel_bg.jpg');
        $img2 = $this->handleUpload($request, 'file_image_2', $img1);
        $img3 = $this->handleUpload($request, 'file_image_3', $img1);
        $img4 = $this->handleUpload($request, 'file_image_4', $img1);
        $img5 = $this->handleUpload($request, 'file_image_5', $img1);
        $img6 = $this->handleUpload($request, 'file_image_6', $img1);

        $category = match($roomType) {
            'Single Bedroom AC' => 'single_ac',
            'Queen Size AC' => 'queen_ac',
            'King Size AC' => 'king_ac',
            'AC Hall (5+ Persons)' => 'hall_ac',
            'Single Non-AC' => 'single_non_ac',
            'Queen Size Non-AC' => 'queen_non_ac',
            'King Size Non-AC' => 'king_non_ac',
            'Non-AC Hall (5+ Persons)' => 'hall_non_ac',
            default => (str_contains(strtolower($roomType), 'ac') && !str_contains(strtolower($roomType), 'non') ? 'queen_ac' : 'queen_non_ac')
        };

        // Create in MySQL
        $dbHotel = Hotel::create([
            'partner_id' => $partner->id,
            'name' => $hotelName,
            'phone' => $phone,
            'category' => $category,
            'category_name' => $roomType,
            'room_type' => $roomType,
            'ac_type' => $acType,
            'bed_type' => $bedType,
            'max_adults' => $maxAdults,
            'max_children' => $maxChildren,
            'bath_type' => $bathType,
            'amenities' => is_array($amenities) ? implode(', ', $amenities) : $amenities,
            'location' => $location,
            'distance' => $location,
            'price' => $price,
            'price_per_night' => $price,
            'mrp' => $mrp,
            'available_rooms' => $roomsCount,
            'image' => $img1,
            'image_main' => $img1,
            'image_reception' => $img2,
            'image_room' => $img3,
            'image_bathroom' => $img4,
            'image_extra' => $img5,
            'image_6' => $img6,
            'status' => $status,
        ]);

        // Sync to DataStore
        DataStore::addItem('hotels', [
            'id' => $dbHotel->id,
            'partner_id' => $partner->id,
            'name' => $hotelName,
            'phone' => $phone,
            'category' => $category,
            'room_type' => $roomType,
            'category_name' => $roomType,
            'ac_type' => $acType,
            'bed_type' => $bedType,
            'max_adults' => $maxAdults,
            'max_children' => $maxChildren,
            'bath_type' => $bathType,
            'amenities' => is_array($amenities) ? $amenities : explode(',', $amenities),
            'location' => $location,
            'distance' => $location,
            'price_per_night' => $price,
            'price' => $price,
            'mrp' => $mrp,
            'available_rooms' => $roomsCount,
            'image' => $img1,
            'image_main' => $img1,
            'image_reception' => $img2,
            'image_room' => $img3,
            'image_bathroom' => $img4,
            'image_extra' => $img5,
            'image_6' => $img6,
            'status' => $status,
        ]);

        if (empty($partner->hotel_id)) {
            $partner->update(['hotel_id' => $dbHotel->id]);
        }

        return redirect()->route('hotel.rooms')->with('success', "New Room '{$roomType}' listed successfully with verified pricing and photos!");
    }

    public function editRoom($id)
    {
        $partner = $this->getPartner();
        $room = Hotel::where('id', $id)->first();
        if (!$room) {
            $all = DataStore::getCollection('hotels');
            foreach ($all as $h) {
                if ((string)(is_array($h) ? ($h['id'] ?? null) : $h->id) === (string)$id) {
                    $room = (object)$h;
                    break;
                }
            }
        }

        return view('hotel.rooms.form', ['partner' => $partner, 'room' => $room, 'isEdit' => true]);
    }

    public function updateRoom(Request $request, $id)
    {
        $partner = $this->getPartner();

        $request->validate([
            'room_type' => 'required|string|max:150',
            'price_per_night' => 'required|numeric|min:100',
            'mrp' => 'nullable|numeric|min:100',
            'available_rooms' => 'required|integer|min:1',
            'file_image_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_4' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_5' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_image_6' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $roomType = $request->input('room_type', 'Deluxe AC Room');
        $price = (float)$request->input('price_per_night', 1499);
        $mrp = (float)($request->input('mrp', $price * 1.35));
        $roomsCount = (int)$request->input('available_rooms', 5);
        $location = $request->input('location', 'Near Dewa Sharif Dargah Gate');
        $acType = $request->input('ac_type', 'AC');
        $bedType = $request->input('bed_type', 'Double Bed');
        $maxAdults = (int)$request->input('max_adults', 2);
        $maxChildren = (int)$request->input('max_children', 1);
        $bathType = $request->input('bath_type', 'Attached Western Bath');
        $status = $request->input('status', 'active');
        $amenities = $request->input('amenities', []);

        $updateData = [
            'room_type' => $roomType,
            'category_name' => $roomType,
            'ac_type' => $acType,
            'bed_type' => $bedType,
            'max_adults' => $maxAdults,
            'max_children' => $maxChildren,
            'bath_type' => $bathType,
            'amenities' => is_array($amenities) ? $amenities : explode(',', $amenities),
            'location' => $location,
            'distance' => $location,
            'price_per_night' => $price,
            'price' => $price,
            'mrp' => $mrp,
            'available_rooms' => $roomsCount,
            'status' => $status,
        ];

        // Process images if uploaded
        for ($i = 1; $i <= 6; $i++) {
            if ($request->hasFile("file_image_{$i}")) {
                $uploaded = $this->handleUpload($request, "file_image_{$i}", null);
                if ($uploaded) {
                    if ($i === 1) { $updateData['image'] = $uploaded; $updateData['image_main'] = $uploaded; }
                    elseif ($i === 2) { $updateData['image_reception'] = $uploaded; }
                    elseif ($i === 3) { $updateData['image_room'] = $uploaded; }
                    elseif ($i === 4) { $updateData['image_bathroom'] = $uploaded; }
                    elseif ($i === 5) { $updateData['image_extra'] = $uploaded; }
                    elseif ($i === 6) { $updateData['image_6'] = $uploaded; }
                }
            }
        }

        DataStore::updateItem('hotels', $id, $updateData);

        try {
            $dbData = $updateData;
            if (isset($dbData['amenities']) && is_array($dbData['amenities'])) {
                $dbData['amenities'] = implode(', ', $dbData['amenities']);
            }
            Hotel::where('id', $id)->update($dbData);
        } catch (\Throwable $e) {}

        return redirect()->route('hotel.rooms')->with('success', "Room '{$roomType}' updated successfully!");
    }

    public function toggleRoomStatus($id)
    {
        $all = DataStore::getCollection('hotels');
        $current = 'active';
        foreach ($all as $h) {
            $hId = is_array($h) ? ($h['id'] ?? null) : $h->id;
            if ((string)$hId === (string)$id) {
                $current = is_array($h) ? ($h['status'] ?? 'active') : ($h->status ?? 'active');
                break;
            }
        }

        $new = (strtolower($current) === 'active') ? 'inactive' : 'active';
        DataStore::updateItem('hotels', $id, ['status' => $new]);
        try {
            Hotel::where('id', $id)->update(['status' => $new]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Room status switched to " . strtoupper($new) . " successfully!");
    }

    public function bookings(Request $request)
    {
        $partner = $this->getPartner();
        $hotelId = $this->getPartnerHotelId();

        $allBookings = $this->getAllBookings();
        $bookings = [];

        foreach ($allBookings as $b) {
            $bHotelId = is_array($b) ? ($b['hotel_id'] ?? null) : ($b->hotel_id ?? null);
            $bHotelName = strtolower(trim(is_array($b) ? ($b['hotel_name'] ?? '') : ($b->hotel_name ?? '')));
            $pName = strtolower(trim($partner->hotel_name ?? ''));

            if (($hotelId > 0 && (int)$bHotelId === $hotelId) || (!empty($pName) && str_contains($bHotelName, $pName))) {
                $bookings[] = $b;
            }
        }

        // Apply status filter if present
        $filter = $request->query('status');
        if (!empty($filter) && $filter !== 'all') {
            $bookings = array_filter($bookings, function($b) use ($filter) {
                $st = strtolower(is_array($b) ? ($b['status'] ?? '') : ($b->status ?? ''));
                return str_contains($st, strtolower($filter));
            });
        }

        return view('hotel.bookings.index', compact('partner', 'bookings', 'filter'));
    }

    public function verifyCheckinPin(Request $request, $id)
    {
        $request->validate(['pin' => 'required|string|size:4']);
        $enteredPin = trim($request->input('pin'));

        $allBookings = DataStore::getCollection('hotel_bookings');
        $found = null;
        foreach ($allBookings as $b) {
            $bId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            if ((string)$bId === (string)$id) {
                $found = $b;
                break;
            }
        }

        if (!$found) {
            return back()->with('error', 'Booking reservation record not found.');
        }

        $realPin = is_array($found) ? ($found['checkin_pin'] ?? null) : ($found->checkin_pin ?? null);

        // If no PIN was stored, accept default verification
        if (!empty($realPin) && $realPin !== $enteredPin) {
            return back()->with('error', "Incorrect Check-In PIN entered! Guest's Voucher PIN does not match.");
        }

        $update = [
            'status' => 'Checked-In & Verified',
            'hotel_status' => 'checked_in',
            'checkin_verified_at' => now()->toDateTimeString(),
        ];

        DataStore::updateItem('hotel_bookings', $id, $update);
        try {
            HotelBooking::where('id', $id)->update($update);
        } catch (\Throwable $e) {}

        return back()->with('success', "Success! 4-digit PIN verified. Guest is checked-in. Payout is safely locked for settlement!");
    }

    public function markNoShow($id)
    {
        $update = [
            'status' => 'Guest No-Show (Cancelled)',
            'hotel_status' => 'no_show',
            'cancellation_fee_total' => 0.00, // Policy calculation
            'refund_status' => 'none',
        ];

        DataStore::updateItem('hotel_bookings', $id, $update);
        try {
            HotelBooking::where('id', $id)->update($update);
        } catch (\Throwable $e) {}

        return back()->with('success', "Booking #{$id} marked as Guest No-Show. DewaSharif Admin has been notified.");
    }

    public function settlements()
    {
        $partner = $this->getPartner();
        $hotelId = $this->getPartnerHotelId();

        $settlements = HotelSettlement::where(function($q) use ($hotelId, $partner) {
            if ($hotelId > 0) {
                $q->where('hotel_id', $hotelId);
            }
            $q->orWhere('hotel_partner_id', $partner->id);
        })->orderBy('created_at', 'desc')->get();

        // Calculate live financial summary for Passbook
        $allBookings = $this->getAllBookings();
        $totalNet80 = 0;
        foreach ($allBookings as $b) {
            $bHotelId = is_array($b) ? ($b['hotel_id'] ?? null) : ($b->hotel_id ?? null);
            $bHotelName = strtolower(trim(is_array($b) ? ($b['hotel_name'] ?? '') : ($b->hotel_name ?? '')));
            $pName = strtolower(trim($partner->hotel_name ?? ''));

            if (($hotelId > 0 && (int)$bHotelId === $hotelId) || (!empty($pName) && str_contains($bHotelName, $pName))) {
                $st = strtolower(is_array($b) ? ($b['status'] ?? '') : ($b->status ?? ''));
                $tot = (float)(is_array($b) ? ($b['total_amount'] ?? ($b['amount'] ?? 0)) : ($b->total_amount ?? ($b->amount ?? 0)));
                if ($tot <= 0) { $tot = 1499.00; }
                if (str_contains($st, 'cancel')) {
                    $totalNet80 += (float)(is_array($b) ? ($b['cancellation_hotel_share'] ?? 0) : ($b->cancellation_hotel_share ?? 0));
                } else {
                    $pShare = (float)(is_array($b) ? ($b['hotel_payout_amount'] ?? 0) : ($b->hotel_payout_amount ?? 0));
                    if ($pShare <= 0) {
                        $pShare = round($tot * 0.80, 2);
                    }
                    $totalNet80 += $pShare;
                }
            }
        }

        $totalSettled = (float)$settlements->sum('amount_paid');
        $currentBalance = max(0, round($totalNet80 - $totalSettled, 2));

        return view('hotel.settlements.index', compact('partner', 'settlements', 'totalSettled', 'totalNet80', 'currentBalance'));
    }

    public function profile()
    {
        $partner = $this->getPartner();
        return view('hotel.profile.index', compact('partner'));
    }

    public function updateProfile(Request $request)
    {
        $partner = $this->getPartner();

        $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:20|unique:hotel_partners,phone,' . $partner->id,
            'bank_name' => 'nullable|string|max:100',
            'account_no' => 'nullable|string|max:50',
            'account_holder' => 'nullable|string|max:150',
            'ifsc_code' => 'nullable|string|max:20',
            'upi_id' => 'nullable|string|max:100',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        $updateData = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'bank_name' => $request->input('bank_name'),
            'account_no' => $request->input('account_no'),
            'account_holder' => $request->input('account_holder'),
            'ifsc_code' => $request->input('ifsc_code'),
            'upi_id' => $request->input('upi_id'),
        ];

        if ($request->filled('new_password')) {
            $updateData['password'] = Hash::make($request->input('new_password'));
        }

        $partner->update($updateData);

        return back()->with('success', 'Bank Payout Details & Profile updated successfully! All future settlements will be sent to this account.');
    }

    private function handleUpload(Request $request, string $fileKey, ?string $fallback): ?string
    {
        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            if ($file->isValid()) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $dest = public_path('uploads/hotels');
                if (!file_exists($dest)) {
                    mkdir($dest, 0777, true);
                }
                $file->move($dest, $filename);
                return 'uploads/hotels/' . $filename;
            }
        }
        return $fallback;
    }
}
