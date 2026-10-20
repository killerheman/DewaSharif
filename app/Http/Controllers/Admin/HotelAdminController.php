<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use Illuminate\Http\Request;

class HotelAdminController extends Controller
{
    public function index()
    {
        $hotels = DataStore::getCollection('hotels');
        return view('admin.hotels.index', compact('hotels'));
    }

    public function store(Request $request)
    {
        $name = trim($request->input('name', 'New Guest House'));
        $roomType = $request->input('room_type', $request->input('category_name', 'Deluxe AC Room'));
        $location = trim($request->input('location', $request->input('distance', 'Near Dewa Sharif Dargah')));
        $price = (float)($request->input('price_per_night', $request->input('price', 1499)));
        $rooms = (int)$request->input('available_rooms', 10);
        $phone = trim($request->input('phone', '+91 9648777223'));
        $status = $request->input('status', 'active');

        $acType = $request->input('ac_type', (str_contains(strtolower($roomType), 'ac') ? 'AC' : 'Non-AC'));
        $bedType = $request->input('bed_type', 'Double Bed');
        $maxAdults = (int)$request->input('max_adults', 2);
        $maxChildren = (int)$request->input('max_children', 1);
        $bathType = $request->input('bath_type', 'Attached Western Bath');
        $amenities = $request->input('amenities', ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Near Dargah Gate']);

        $imageMain = $this->processImageInput($request, 'file_image_main', 'image', asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'));
        $imageReception = $this->processImageInput($request, 'file_image_reception', 'image_reception', asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'));
        $imageRoom = $this->processImageInput($request, 'file_image_room', 'image_room', asset('home/images/dewasharif/dewapage/deluxe_room.jpg'));
        $imageBathroom = $this->processImageInput($request, 'file_image_bathroom', 'image_bathroom', asset('home/images/dewasharif/dewapage/standard_room.jpg'));
        $imageExtra = $this->processImageInput($request, 'file_image_extra', 'image_extra', asset('home/images/dewasharif/dewapage/deluxe_room.jpg'));

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

        DataStore::addItem('hotels', [
            'name' => $name,
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
            'available_rooms' => $rooms,
            'image' => $imageMain,
            'image_main' => $imageMain,
            'image_reception' => $imageReception,
            'image_room' => $imageRoom,
            'image_bathroom' => $imageBathroom,
            'image_extra' => $imageExtra,
            'status' => $status,
        ]);

        return back()->with('success', "Hotel Room '{$name}' created with complete Room Master setup!");
    }

    public function update(Request $request, $id)
    {
        $name = trim($request->input('name', 'Hotel Room'));
        $roomType = $request->input('room_type', $request->input('category_name', 'Deluxe AC Room'));
        $location = trim($request->input('location', $request->input('distance', 'Near Dewa Sharif Dargah')));
        $price = (float)($request->input('price_per_night', $request->input('price', 1499)));
        $rooms = (int)$request->input('available_rooms', 10);
        $status = $request->input('status', 'active');

        $acType = $request->input('ac_type', (str_contains(strtolower($roomType), 'ac') ? 'AC' : 'Non-AC'));
        $bedType = $request->input('bed_type', 'Double Bed');
        $maxAdults = (int)$request->input('max_adults', 2);
        $maxChildren = (int)$request->input('max_children', 1);
        $bathType = $request->input('bath_type', 'Attached Western Bath');
        $amenities = $request->input('amenities', ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Near Dargah Gate']);

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

        $data = [
            'name' => $name,
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
            'available_rooms' => $rooms,
            'status' => $status,
        ];

        if ($request->hasFile('file_image_main') || $request->filled('image')) {
            $img = $this->processImageInput($request, 'file_image_main', 'image', null);
            if ($img) { $data['image'] = $img; $data['image_main'] = $img; }
        }
        if ($request->hasFile('file_image_reception') || $request->filled('image_reception')) {
            $img = $this->processImageInput($request, 'file_image_reception', 'image_reception', null);
            if ($img) { $data['image_reception'] = $img; }
        }
        if ($request->hasFile('file_image_room') || $request->filled('image_room')) {
            $img = $this->processImageInput($request, 'file_image_room', 'image_room', null);
            if ($img) { $data['image_room'] = $img; }
        }
        if ($request->hasFile('file_image_bathroom') || $request->filled('image_bathroom')) {
            $img = $this->processImageInput($request, 'file_image_bathroom', 'image_bathroom', null);
            if ($img) { $data['image_bathroom'] = $img; }
        }
        if ($request->hasFile('file_image_extra') || $request->filled('image_extra')) {
            $img = $this->processImageInput($request, 'file_image_extra', 'image_extra', null);
            if ($img) { $data['image_extra'] = $img; }
        }

        DataStore::updateItem('hotels', $id, $data);
        return back()->with('success', "Hotel '{$name}' Room Master details updated successfully!");
    }

    private function processImageInput(Request $request, $fileKey, $urlKey, $defaultAsset)
    {
        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            if ($file->isValid()) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('uploads/hotels');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                $file->move($destination, $filename);
                return 'uploads/hotels/' . $filename;
            }
        }

        if ($request->filled($urlKey)) {
            $url = trim($request->input($urlKey));
            if (str_contains($url, 'dewasharif.com/') || str_contains($url, '127.0.0.1') || str_contains($url, 'localhost')) {
                $parsed = parse_url($url, PHP_URL_PATH);
                if (!empty($parsed)) {
                    return ltrim($parsed, '/');
                }
            }
            return $url;
        }

        return $defaultAsset;
    }

    public function toggleStatus($id)
    {
        $hotels = DataStore::getCollection('hotels');
        $current = 'active';
        foreach ($hotels as $h) {
            $hId = is_array($h) ? ($h['id'] ?? null) : $h->id;
            if ($hId == $id) {
                $current = is_array($h) ? ($h['status'] ?? 'active') : ($h->status ?? 'active');
                break;
            }
        }
        $newStatus = (strtolower($current) === 'active' || strtolower($current) === 'active') ? 'inactive' : 'active';
        DataStore::updateItem('hotels', $id, ['status' => $newStatus]);

        return back()->with('success', "Hotel status updated to " . ucfirst($newStatus) . "!");
    }

    public function destroy($id)
    {
        DataStore::deleteItem('hotels', $id);
        return back()->with('success', "Hotel deleted successfully!");
    }

    public function bookings()
    {
        $bookings = DataStore::getCollection('hotel_bookings');
        return view('admin.hotels.bookings', compact('bookings'));
    }

    public function updateCommission(Request $request)
    {
        $rate = (int)$request->input('commission_rate', 25);
        $settings = DataStore::getCollection('settings');
        $settings['commission_rate'] = $rate;
        $all = DataStore::get();
        $all['settings'] = $settings;
        DataStore::save($all);

        return back()->with('success', "Hotel Commission Rate updated to {$rate}% successfully!");
    }

    public function confirmBooking($id)
    {
        $bookings = DataStore::getCollection('hotel_bookings');
        $currentStatus = 'Pending';
        foreach ($bookings as $b) {
            $bId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            if ((string)$bId === (string)$id) {
                $currentStatus = is_array($b) ? ($b['status'] ?? 'Pending') : ($b->status ?? 'Pending');
                break;
            }
        }

        $isAlreadyConfirmed = str_contains(strtolower($currentStatus), 'confirmed');
        $newStatus = $isAlreadyConfirmed ? 'Pending Approval' : 'Confirmed';
        DataStore::updateItem('hotel_bookings', $id, ['status' => $newStatus]);

        $msg = ($newStatus === 'Confirmed') 
            ? "Booking #{$id} has been Approved & Confirmed!" 
            : "Booking #{$id} status set to Pending Approval.";

        return back()->with('success', $msg);
    }

    public function approveBooking($id)
    {
        $bookings = DataStore::getCollection('hotel_bookings');
        $booking = null;
        foreach ($bookings as $b) {
            $bId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            if ((string)$bId === (string)$id) {
                $booking = $b;
                break;
            }
        }

        $amount = (float)(is_array($booking) ? ($booking['total_amount'] ?? ($booking['amount'] ?? 0)) : ($booking->total_amount ?? ($booking->amount ?? 0)));

        $updateData = [
            'payment_status' => 'paid',
            'paid_amount' => $amount,
            'pending_amount' => 0,
            'status' => 'Confirmed & Paid',
            'hotel_status' => 'confirmed',
            'booking_status' => 'confirmed'
        ];

        DataStore::updateItem('hotel_bookings', $id, $updateData);
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hotel_bookings')) {
                $columns = \Illuminate\Support\Facades\Schema::getColumnListing('hotel_bookings');
                $dbUpdate = array_intersect_key(array_merge($updateData, ['updated_at' => now()]), array_flip($columns));
                \Illuminate\Support\Facades\DB::table('hotel_bookings')->where('id', $id)->update($dbUpdate);
            }
        } catch (\Throwable $e) {}

        return back()->with('success', "Hotel Booking #{$id} payment has been APPROVED & Verified! Voucher updated to PAID.");
    }

    public function rejectBooking($id)
    {
        $bookings = DataStore::getCollection('hotel_bookings');
        $booking = null;
        foreach ($bookings as $b) {
            $bId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            if ((string)$bId === (string)$id) {
                $booking = $b;
                break;
            }
        }

        $amount = (float)(is_array($booking) ? ($booking['total_amount'] ?? ($booking['amount'] ?? 0)) : ($booking->total_amount ?? ($booking->amount ?? 0)));

        $updateData = [
            'payment_status' => 'failed',
            'paid_amount' => 0,
            'pending_amount' => $amount,
            'status' => 'Payment Failed',
            'hotel_status' => 'cancelled',
            'booking_status' => 'cancelled'
        ];

        DataStore::updateItem('hotel_bookings', $id, $updateData);
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hotel_bookings')) {
                $columns = \Illuminate\Support\Facades\Schema::getColumnListing('hotel_bookings');
                $dbUpdate = array_intersect_key(array_merge($updateData, ['updated_at' => now()]), array_flip($columns));
                \Illuminate\Support\Facades\DB::table('hotel_bookings')->where('id', $id)->update($dbUpdate);
            }
        } catch (\Throwable $e) {}

        return back()->with('success', "Hotel Booking #{$id} payment REJECTED as Uncredited/Fake UTR. Stay voucher is now VOID & CANCELLED.");
    }

    public function destroyBooking($id)
    {
        DataStore::deleteItem('hotel_bookings', $id);
        return back()->with('success', "Booking #{$id} deleted successfully!");
    }

    public function updateBookingAmount(Request $request, $id)
    {
        $rawAmount = preg_replace('/[^0-9.]/', '', (string)$request->input('amount', '0'));
        $amount = (float)$rawAmount;
        $paymentMode = trim($request->input('payment_mode', 'SBI UPI / PhonePe'));
        $status = 'Confirmed & Paid';

        $data = [
            'total_amount' => $amount,
            'amount' => $amount,
            'paid_amount' => $amount,
            'price_per_night' => $amount,
            'payment_status' => 'paid',
            'payment_mode' => $paymentMode,
            'status' => $status,
        ];

        if ($request->filled('id_no')) {
            $cleanIdNo = trim($request->input('id_no'));
            $cleanIdType = trim($request->input('id_type', 'Aadhaar Card'));
            $data['id_no'] = $cleanIdNo;
            $data['id_type'] = $cleanIdType;
        }

        DataStore::updateItem('hotel_bookings', $id, $data);

        // Also sync directly to MySQL hotel_bookings table if exists
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hotel_bookings')) {
                $dbUpdate = [
                    'total_amount' => $amount,
                    'paid_amount' => $amount,
                    'price_per_night' => $amount,
                    'payment_status' => 'paid',
                    'payment_mode' => $paymentMode,
                    'status' => $status,
                    'hotel_status' => 'confirmed',
                    'booking_status' => 'confirmed',
                    'updated_at' => now(),
                ];
                if ($request->filled('id_no')) {
                    $dbUpdate['id_no'] = trim($request->input('id_no'));
                    $dbUpdate['id_type'] = trim($request->input('id_type', 'Aadhaar Card'));
                }
                \Illuminate\Support\Facades\DB::table('hotel_bookings')->where('id', $id)->update($dbUpdate);
            }
        } catch (\Throwable $e) {}

        return back()->with('success', "Booking #{$id} amount finalized to ₹" . number_format($amount, 2) . " and marked as Paid successfully!");
    }

    public function updateBooking(Request $request, $id)
    {
        $custName = trim($request->input('customer_name', ''));
        $custPhone = trim($request->input('customer_phone', ''));
        $altPhone = trim($request->input('alternate_phone', ''));
        $custEmail = trim($request->input('customer_email', ''));
        $custAddress = trim($request->input('customer_address', ''));
        $idType = trim($request->input('id_type', 'Aadhaar Card'));
        $idNo = trim($request->input('id_no', 'N/A'));

        $hotelName = trim($request->input('hotel_name', 'Al-Waris Deluxe Guest House'));
        $roomName = trim($request->input('room_name', 'Deluxe Room'));
        $checkIn = trim($request->input('check_in', ''));
        $checkOut = trim($request->input('check_out', ''));
        $persons = (int)$request->input('persons', 2);
        $rooms = (int)$request->input('rooms', 1);

        $nights = 1;
        if (!empty($checkIn) && !empty($checkOut)) {
            $inTime = strtotime($checkIn);
            $outTime = strtotime($checkOut);
            if ($outTime > $inTime) {
                $nights = max(1, (int)round(($outTime - $inTime) / 86400));
            }
        }

        $amount = (float)$request->input('total_amount', $request->input('amount', 0));
        $paymentStatus = strtolower(trim($request->input('payment_status', 'paid')));
        $bookingStatus = trim($request->input('status', 'Confirmed & Paid'));
        $paymentMode = trim($request->input('payment_mode', 'SBI UPI / PhonePe'));
        $utrNumber = trim($request->input('utr_number', ''));

        // Handle Hotel Amenities (for PDF & Voucher sync)
        $rawAmenities = $request->input('amenities', []);
        if (is_string($rawAmenities)) {
            $amenitiesList = array_values(array_filter(array_map('trim', explode(',', $rawAmenities))));
        } elseif (is_array($rawAmenities)) {
            $amenitiesList = array_values(array_filter($rawAmenities));
        } else {
            $amenitiesList = [];
        }
        $customAmenity = trim($request->input('custom_amenity', ''));
        if (!empty($customAmenity) && !in_array($customAmenity, $amenitiesList)) {
            $amenitiesList[] = $customAmenity;
        }
        $amenitiesStr = implode(', ', $amenitiesList);

        $data = [
            'customer_name' => $custName ?: 'Guest Devotee',
            'customer_phone' => $custPhone,
            'alternate_phone' => $altPhone ?: null,
            'customer_email' => $custEmail ?: null,
            'customer_address' => $custAddress ?: null,
            'id_type' => $idType,
            'id_no' => $idNo ?: 'N/A',
            'hotel_name' => $hotelName,
            'room_name' => $roomName,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'persons' => $persons,
            'rooms' => $rooms,
            'nights' => $nights,
            'amenities' => $amenitiesStr,
            'amenities_list' => $amenitiesList,
            'total_amount' => $amount,
            'amount' => $amount,
            'price_per_night' => $amount / max(1, $nights),
            'paid_amount' => ($paymentStatus === 'paid') ? $amount : 0,
            'pending_amount' => ($paymentStatus === 'paid') ? 0 : $amount,
            'payment_status' => $paymentStatus,
            'status' => $bookingStatus,
            'hotel_status' => (str_contains(strtolower($bookingStatus), 'confirm') || $paymentStatus === 'paid') ? 'confirmed' : 'pending',
            'booking_status' => (str_contains(strtolower($bookingStatus), 'confirm') || $paymentStatus === 'paid') ? 'confirmed' : 'pending',
            'payment_mode' => $paymentMode,
            'utr_number' => $utrNumber ?: null,
            'payment_id' => $utrNumber ? ('SBI_UPI_' . $utrNumber) : ('pay_HOT_' . substr(md5($id), 0, 8)),
        ];

        DataStore::updateItem('hotel_bookings', $id, $data);

        // Also sync directly to MySQL hotel_bookings table if exists
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hotel_bookings')) {
                $columns = \Illuminate\Support\Facades\Schema::getColumnListing('hotel_bookings');
                $dbUpdate = array_intersect_key(array_merge($data, ['updated_at' => now()]), array_flip($columns));
                \Illuminate\Support\Facades\DB::table('hotel_bookings')->where('id', $id)->update($dbUpdate);
            }
        } catch (\Throwable $e) {}

        $statusMsg = ($paymentStatus === 'paid') ? 'Marked as PAID' : 'Marked as UNPAID / PENDING';
        return back()->with('success', "Hotel booking #{$id} details and status updated successfully ({$statusMsg})!");
    }
}

