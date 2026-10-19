<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use Illuminate\Http\Request;

class CabAdminController extends Controller
{
    public function index()
    {
        $cabs = DataStore::getCollection('cabs');
        $vehicles = DataStore::getCollection('cab_vehicles');
        $locations = DataStore::getCollection('cab_locations');
        $erickshaw = DataStore::getItem('erickshaw', 1) ?? [
            'service_name' => 'Local Dewa Shrine E-Rickshaw Sightseeing (Only Dewa Ghoomne Ke Liye)',
            'status' => 'Active',
            'per_person_fare' => 30,
            'full_rickshaw_fare' => 150,
            'contact_phone' => '+91 9648777223',
            'details' => 'Electric E-Rickshaw service for local shrine visits, Dargah Sharif tours, bazaar shopping & railway station connectivity.'
        ];
        $parkingPolicy = DataStore::getItem('cab_parking_policy', 1) ?? [
            'status' => 'Active',
            'airport_note' => 'Airport entry & waiting: Initial 10 minutes free. Exceeding 10 mins parking charges payable by passenger directly as per actual airport parking receipt.',
            'sightseeing_note' => 'City Sightseeing Tour: Historical monument & tourist spot parking charges payable by passenger as per actual receipt.'
        ];
        return view('admin.cabs.index', compact('cabs', 'vehicles', 'erickshaw', 'locations', 'parkingPolicy'));
    }

    public function updateParkingPolicy(Request $request)
    {
        $status = $request->has('status') ? 'Active' : 'Inactive';
        $airportNote = trim($request->input('airport_note', 'Airport entry & waiting: Initial 10 minutes free. Exceeding 10 mins parking charges payable by passenger directly as per actual airport parking receipt.'));
        $sightseeingNote = trim($request->input('sightseeing_note', 'City Sightseeing Tour: Historical monument & tourist spot parking charges payable by passenger as per actual receipt.'));

        DataStore::saveItem('cab_parking_policy', 1, [
            'status' => $status,
            'airport_note' => $airportNote,
            'sightseeing_note' => $sightseeingNote,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return back()->with('success', 'Airport & Sightseeing Parking Instruction Policy updated successfully!');
    }

    public function toggleERickshawStatus(Request $request)
    {
        $current = DataStore::getItem('erickshaw', 1) ?? [
            'service_name' => 'Local Dewa Shrine E-Rickshaw Sightseeing (Only Dewa Ghoomne Ke Liye)',
            'status' => 'Active',
            'per_person_fare' => 30,
            'full_rickshaw_fare' => 150,
            'contact_phone' => '+91 9648777223',
            'details' => 'Electric E-Rickshaw service for local shrine visits, Dargah Sharif tours, bazaar shopping & railway station connectivity.'
        ];

        $newStatus = (strtolower($current['status'] ?? 'active') === 'active') ? 'Inactive' : 'Active';
        $current['status'] = $newStatus;

        if ($request->filled('per_person_fare')) {
            $current['per_person_fare'] = (float)$request->input('per_person_fare');
        }
        if ($request->filled('full_rickshaw_fare')) {
            $current['full_rickshaw_fare'] = (float)$request->input('full_rickshaw_fare');
        }

        DataStore::saveItem('erickshaw', 1, $current);
        return back()->with('success', "Local Dewa Shrine E-Rickshaw Service status updated to " . strtoupper($newStatus) . "!");
    }

    public function toggleVehicleStatus(Request $request, $id)
    {
        $vehicles = DataStore::getCollection('cab_vehicles');
        foreach ($vehicles as $v) {
            if ((string)($v['id'] ?? '') === (string)$id) {
                $newStatus = ($v['status'] ?? 'Active') === 'Active' ? 'Inactive' : 'Active';
                DataStore::updateItem('cab_vehicles', $id, ['status' => $newStatus]);
                return back()->with('success', "Vehicle model {$v['name']} status updated to " . strtoupper($newStatus) . "!");
            }
        }
        return back();
    }

    public function storeVehicle(Request $request)
    {
        $name = trim($request->input('name', 'New Vehicle Model'));
        $type = trim($request->input('type', 'Standard Taxi'));
        $capacity = trim($request->input('capacity', '4 Passengers + 1 Driver'));
        $price = (float)$request->input('price', 1400);
        $image = trim($request->input('image', ''));

        DataStore::addItem('cab_vehicles', [
            'name' => $name,
            'type' => $type,
            'capacity' => $capacity,
            'price' => $price,
            'fare' => $price,
            'fare_factor' => 1.0,
            'status' => 'Active',
            'image' => $image ?: asset('home/images/dewasharif/dewapage/cab_dzire.jpg')
        ]);

        return back()->with('success', "New vehicle model '{$name}' added successfully!");
    }

    public function updateVehicle(Request $request, $id)
    {
        $name = trim($request->input('name'));
        $type = trim($request->input('type'));
        $capacity = trim($request->input('capacity'));
        $price = (float)$request->input('price', 1400);

        $data = [
            'name' => $name,
            'type' => $type,
            'capacity' => $capacity,
            'price' => $price,
            'fare' => $price,
        ];

        if ($request->filled('image')) {
            $data['image'] = trim($request->input('image'));
        }

        DataStore::updateItem('cab_vehicles', $id, $data);
        return back()->with('success', "Vehicle model '{$name}' updated successfully!");
    }

    public function destroyVehicle($id)
    {
        DataStore::deleteItem('cab_vehicles', $id);
        return back()->with('success', "Vehicle model deleted successfully!");
    }

    public function storeRoute(Request $request)
    {
        $type = $request->input('vehicle_type', 'Dzire etc which is available (Semi Deluxe - Sedan)');
        $vehicleName = trim($request->input('vehicle_name') ?? '') ?: $type;
        $vehicleNumber = strtoupper(trim($request->input('vehicle_number') ?? '')) ?: 'Available Fleet';
        $acOption = $request->input('ac_option', 'AC');
        $seatingCapacity = trim($request->input('seating_capacity') ?? '') ?: '4 Passengers + 1 Driver (Total 5)';
        $tollStatus = $request->input('toll_status', 'Toll Tax Included');

        $pickup = trim($request->input('pickup') ?? 'Dewa Sharif');
        $dest = trim($request->input('destination') ?? 'Lucknow Airport');
        $routeName = trim($request->input('route_name') ?? '') ?: ($pickup . ' ↔ ' . $dest);
        $fare = (float)$request->input('price', $request->input('fare', 1499));
        
        $driverName = trim($request->input('driver_name') ?? '') ?: 'To Be Assigned';
        $driverPhone = trim($request->input('driver_phone') ?? '') ?: '+91 9648777223';
        $driverAadhaar = trim($request->input('driver_aadhaar') ?? '') ?: 'Verified';
        $driverDl = strtoupper(trim($request->input('driver_dl') ?? '')) ?: 'Verified';

        $image = $this->resolveVehicleImage($type);

        DataStore::addItem('cabs', [
            'vehicle_type' => $type,
            'vehicle_name' => $vehicleName,
            'vehicle_number' => $vehicleNumber,
            'ac_option' => $acOption,
            'seating_capacity' => $seatingCapacity,
            'capacity' => $seatingCapacity,
            'toll_status' => $tollStatus,
            'title' => $type,
            'route_name' => $routeName,
            'route' => $routeName,
            'pickup' => $pickup,
            'destination' => $dest,
            'fare' => $fare,
            'price' => $fare,
            'driver_name' => $driverName,
            'driver_phone' => $driverPhone,
            'driver_aadhaar' => $driverAadhaar,
            'driver_dl' => $driverDl,
            'image' => $image,
            'status' => 'Active'
        ]);

        return back()->with('success', "Cab Route & Fleet Record '{$routeName}' added successfully!");
    }

    public function destroy($id)
    {
        DataStore::deleteItem('cabs', $id);
        return back()->with('success', "Cab route deleted successfully!");
    }

    public function updateRoute(Request $request, $id)
    {
        $type = $request->input('vehicle_type', 'Dzire etc which is available (Semi Deluxe - Sedan)');
        $vehicleName = trim($request->input('vehicle_name') ?? '') ?: $type;
        $vehicleNumber = strtoupper(trim($request->input('vehicle_number') ?? '')) ?: 'Available Fleet';
        $acOption = $request->input('ac_option', 'AC');
        $seatingCapacity = trim($request->input('seating_capacity') ?? '') ?: '4 Passengers + 1 Driver (Total 5)';
        $tollStatus = $request->input('toll_status', 'Toll Tax Included');

        $pickup = trim($request->input('pickup') ?? 'Dewa Sharif');
        $dest = trim($request->input('destination') ?? 'Lucknow Airport');
        $routeName = trim($request->input('route_name') ?? '') ?: ($pickup . ' ↔ ' . $dest);
        $fare = (float)$request->input('price', $request->input('fare', 1499));

        $driverName = trim($request->input('driver_name') ?? '') ?: 'To Be Assigned';
        $driverPhone = trim($request->input('driver_phone') ?? '') ?: '+91 9648777223';
        $driverAadhaar = trim($request->input('driver_aadhaar') ?? '') ?: 'Verified';
        $driverDl = strtoupper(trim($request->input('driver_dl') ?? '')) ?: 'Verified';

        $data = [
            'vehicle_type' => $type,
            'vehicle_name' => $vehicleName,
            'vehicle_number' => $vehicleNumber,
            'ac_option' => $acOption,
            'seating_capacity' => $seatingCapacity,
            'capacity' => $seatingCapacity,
            'toll_status' => $tollStatus,
            'title' => $type,
            'route_name' => $routeName,
            'route' => $routeName,
            'pickup' => $pickup,
            'destination' => $dest,
            'fare' => $fare,
            'price' => $fare,
            'driver_name' => $driverName,
            'driver_phone' => $driverPhone,
            'driver_aadhaar' => $driverAadhaar,
            'driver_dl' => $driverDl,
        ];

        if ($request->filled('image')) {
            $data['image'] = trim($request->input('image'));
        } else {
            $data['image'] = $this->resolveVehicleImage($type);
        }

        DataStore::updateItem('cabs', $id, $data);
        return back()->with('success', "Cab Route '{$routeName}' updated successfully!");
    }

    private function resolveVehicleImage($vehicleType)
    {
        $vLow = strtolower($vehicleType);
        if (str_contains($vLow, 'omni') || str_contains($vLow, 'van')) {
            return asset('home/images/dewasharif/dewapage/cab_omni.jpg');
        }
        if (str_contains($vLow, 'pickup') || str_contains($vLow, 'mahindra') || str_contains($vLow, 'dala')) {
            return asset('home/images/dewasharif/dewapage/cab_pickup.jpg');
        }
        if (str_contains($vLow, 'verna')) {
            return asset('home/images/dewasharif/dewapage/cab_verna.jpg');
        }
        if (str_contains($vLow, 'ertiga') || str_contains($vLow, 'suv') || str_contains($vLow, 'tempo')) {
            return asset('home/images/dewasharif/dewapage/suv_ertiga.jpg');
        }
        return asset('home/images/dewasharif/dewapage/cab_dzire.jpg');
    }

    public function toggleRouteStatus($id)
    {
        $cabs = DataStore::getCollection('cabs');
        $current = 'Active';
        foreach ($cabs as $c) {
            $cId = is_array($c) ? ($c['id'] ?? null) : $c->id;
            if ($cId == $id) {
                $current = is_array($c) ? ($c['status'] ?? 'Active') : ($c->status ?? 'Active');
                break;
            }
        }
        $newStatus = (strtolower($current) === 'active') ? 'Inactive' : 'Active';
        DataStore::updateItem('cabs', $id, ['status' => $newStatus]);

        return back()->with('success', "Cab route status updated to " . ucfirst($newStatus) . "!");
    }

    public function bookings()
    {
        $bookings = DataStore::getCollection('cab_bookings');
        return view('admin.cabs.bookings', compact('bookings'));
    }

    public function confirmBooking($id)
    {
        $bookings = DataStore::getCollection('cab_bookings');
        $currentStatus = 'Confirmed & Paid';
        foreach ($bookings as $b) {
            $bId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            if ((string)$bId === (string)$id) {
                $currentStatus = is_array($b) ? ($b['status'] ?? 'Confirmed & Paid') : ($b->status ?? 'Confirmed & Paid');
                break;
            }
        }

        $newStatus = str_contains(strtolower($currentStatus), 'confirm') ? 'Pending' : 'Confirmed & Paid';
        DataStore::updateItem('cab_bookings', $id, ['status' => $newStatus]);

        return back()->with('success', "Cab reservation #{$id} status updated to {$newStatus}!");
    }

    public function assignDriver(Request $request, $id)
    {
        $driverName = trim($request->input('driver_name', 'Ramesh Kumar'));
        $driverPhone = trim($request->input('driver_phone', '9876543210'));
        $vehicleNumber = trim($request->input('vehicle_number', 'UP 32 AB 1234'));
        $vehicleName = trim($request->input('vehicle_name', ''));

        $fullDriverString = "{$driverName} ({$vehicleNumber})";

        $updateData = [
            'driver' => $fullDriverString,
            'driver_name' => $driverName,
            'driver_phone' => $driverPhone,
            'driver_vehicle_number' => $vehicleNumber,
            'status' => 'Dispatched'
        ];

        if (!empty($vehicleName)) {
            $updateData['vehicle_name'] = $vehicleName;
            $updateData['vehicle_type'] = $vehicleName;
        }

        if ($request->filled('fare') || $request->filled('amount')) {
            $customFare = (float)preg_replace('/[^0-9.]/', '', (string)$request->input('fare', $request->input('amount')));
            if ($customFare > 0) {
                $updateData['total_fare'] = $customFare;
                $updateData['fare'] = $customFare;
                $updateData['amount'] = $customFare;
                $updateData['paid_amount'] = $customFare;
                $updateData['payment_status'] = 'paid';
            }
        }

        DataStore::updateItem('cab_bookings', $id, $updateData);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('cab_bookings')) {
                \Illuminate\Support\Facades\DB::table('cab_bookings')->where('id', $id)->update(array_merge($updateData, ['updated_at' => now()]));
            }
        } catch (\Throwable $e) {}

        $bookings = DataStore::getCollection('cab_bookings');
        $booking = null;
        foreach ($bookings as $b) {
            $bId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            if ((string)$bId === (string)$id) {
                $booking = $b;
                break;
            }
        }

        $custName = is_array($booking) ? ($booking['customer_name'] ?? ($booking['passenger_name'] ?? 'Passenger')) : ($booking->customer_name ?? 'Passenger');
        $custPhone = is_array($booking) ? ($booking['customer_phone'] ?? ($booking['passenger_phone'] ?? 'N/A')) : ($booking->customer_phone ?? 'N/A');
        $custAltPhone = is_array($booking) ? ($booking['alternate_phone'] ?? null) : ($booking->alternate_phone ?? null);
        $idType = is_array($booking) ? ($booking['id_type'] ?? 'Aadhaar Card / Govt ID') : ($booking->id_type ?? 'Aadhaar Card / Govt ID');
        $idNo = is_array($booking) ? ($booking['id_no'] ?? ($booking['aadhaar'] ?? 'Verified')) : ($booking->id_no ?? 'Verified');
        $route = is_array($booking) ? ($booking['route'] ?? 'Lucknow ↔ Dewa Sharif') : ($booking->route ?? 'Lucknow ↔ Dewa Sharif');
        $vehicle = is_array($booking) ? ($booking['vehicle_type'] ?? 'Cab Taxi') : ($booking->vehicle_type ?? 'Cab Taxi');
        $pickupTime = is_array($booking) ? ($booking['pickup_time'] ?? 'As Scheduled') : ($booking->pickup_time ?? 'As Scheduled');
        $fare = is_array($booking) ? ($booking['fare'] ?? ($booking['total_fare'] ?? 1499)) : ($booking->fare ?? 1499);
        $nightFee = !empty(is_array($booking) ? ($booking['night_surcharge'] ?? 0) : ($booking->night_surcharge ?? 0)) ? " (Includes ₹100 Night Charge 10 PM-5 AM)" : "";

        $waPassengerContact = $custPhone . (!empty($custAltPhone) ? " (Alt: {$custAltPhone})" : "");
        $waMsg = "🚨 *DEWA SHARIF CAB DUTY SLIP - DRIVER ASSIGNED*\n\n" .
                 "🎫 *Booking ID:* #CB-{$id}\n" .
                 "👤 *Passenger Name:* {$custName}\n" .
                 "📞 *Passenger Phone:* {$waPassengerContact}\n" .
                 "🪪 *Passenger ID Verification:* {$idType} ({$idNo})\n" .
                 "📍 *Route:* {$route}\n" .
                 "🚕 *Vehicle Model:* " . (!empty($vehicleName) ? $vehicleName : $vehicle) . "\n" .
                 "📅 *Pickup Date & Time:* {$pickupTime}\n" .
                 "💰 *Total Fare Paid:* ₹" . number_format((float)$fare, 2) . "{$nightFee}\n\n" .
                 "🚖 *Assigned Driver:* {$driverName}\n" .
                 "📱 *Driver Contact:* {$driverPhone}\n" .
                 "🔢 *Vehicle No Plate:* {$vehicleNumber}\n\n" .
                 "Please reach pickup point 15 mins prior to time. Wish you a safe trip!";

        // Send Driver Assignment Alert Email to Customer & Admin
        try {
            $mailPassengerContact = $custName . ' (' . $custPhone . (!empty($custAltPhone) ? " / Alt: {$custAltPhone}" : "") . ')';
            $mailText = "🚖 DEWA SHARIF CAB — DRIVER & VEHICLE ALLOCATED!\n\n" .
                        "Booking Reference: #CB-{$id}\n" .
                        "Passenger: {$mailPassengerContact}\n" .
                        "Route: {$route}\n" .
                        "Pickup Date & Time: {$pickupTime}\n\n" .
                        "DRIVER ALLOCATION:\n" .
                        "Driver Name: {$driverName}\n" .
                        "Driver Phone: {$driverPhone}\n" .
                        "Vehicle Number Plate: {$vehicleNumber} ({$vehicle})\n\n" .
                        "Wish you a safe & comfortable trip with DewaSharif.com!";

            \Illuminate\Support\Facades\Mail::raw($mailText, function ($message) use ($custName, $id) {
                $message->to(env('MAIL_FROM_ADDRESS', 'shahzade.alam707@gmail.com'))
                        ->subject("🚖 DewaSharif Cab Driver & Car Assigned [#CB-{$id}]");
            });
        } catch (\Throwable $e) {}

        // Send Automatic Meta WhatsApp Cloud API Driver Alert to Passenger
        try {
            if ($booking) {
                \App\Services\MetaWhatsAppService::sendDriverAssignmentMessage($custPhone, $booking);
            }
        } catch (\Throwable $e) {}

        $cleanPhone = preg_replace('/[^0-9]/', '', $driverPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $waUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode($waMsg);

        return redirect()->back()
            ->with('success', "Driver {$driverName} assigned & WhatsApp/Email Notification Sent for Booking #{$id}!")
            ->with('whatsapp_redirect', $waUrl);
    }

    public function destroyBooking($id)
    {
        DataStore::deleteItem('cab_bookings', $id);
        return redirect()->back()->with('success', "Cab reservation #CB-{$id} deleted successfully!");
    }

    public function updateBookingAmount(Request $request, $id)
    {
        $rawAmount = preg_replace('/[^0-9.]/', '', (string)$request->input('amount', $request->input('fare', '0')));
        $amount = (float)$rawAmount;
        $paymentMode = trim($request->input('payment_mode', 'SBI UPI / PhonePe'));
        $status = 'Confirmed & Paid';

        $data = [
            'total_fare' => $amount,
            'fare' => $amount,
            'amount' => $amount,
            'paid_amount' => $amount,
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

        DataStore::updateItem('cab_bookings', $id, $data);

        // Also sync directly to MySQL cab_bookings table if exists
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('cab_bookings')) {
                $dbUpdate = [
                    'total_fare' => $amount,
                    'fare' => $amount,
                    'amount' => $amount,
                    'paid_amount' => $amount,
                    'payment_status' => 'paid',
                    'payment_mode' => $paymentMode,
                    'status' => $status,
                    'booking_status' => 'assigned',
                    'updated_at' => now(),
                ];
                if ($request->filled('id_no')) {
                    $dbUpdate['id_no'] = trim($request->input('id_no'));
                    $dbUpdate['id_type'] = trim($request->input('id_type', 'Aadhaar Card'));
                }
                \Illuminate\Support\Facades\DB::table('cab_bookings')->where('id', $id)->update($dbUpdate);
            }
        } catch (\Throwable $e) {}

        return back()->with('success', "Cab booking #{$id} fare finalized to ₹" . number_format($amount, 2) . " and marked as Paid successfully!");
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
        $route = trim($request->input('route', ''));
        $vehicle = trim($request->input('vehicle_type', $request->input('vehicle_name', '')));
        $pickupTime = trim($request->input('pickup_time', ''));
        $amount = (float)$request->input('fare', $request->input('amount', 0));
        $paymentStatus = strtolower(trim($request->input('payment_status', 'paid')));
        $bookingStatus = trim($request->input('status', 'Confirmed & Paid'));
        $paymentMode = trim($request->input('payment_mode', 'SBI UPI / PhonePe'));
        $utrNumber = trim($request->input('utr_number', ''));

        $data = [
            'customer_name' => $custName ?: 'Guest Passenger',
            'customer_phone' => $custPhone,
            'alternate_phone' => $altPhone ?: null,
            'customer_email' => $custEmail ?: null,
            'customer_address' => $custAddress ?: null,
            'id_type' => $idType,
            'id_no' => $idNo ?: 'N/A',
            'route' => $route,
            'vehicle_type' => $vehicle,
            'vehicle_name' => $vehicle,
            'pickup_time' => $pickupTime,
            'fare' => $amount,
            'total_fare' => $amount,
            'amount' => $amount,
            'paid_amount' => ($paymentStatus === 'paid') ? $amount : 0,
            'payment_status' => $paymentStatus,
            'status' => $bookingStatus,
            'payment_mode' => $paymentMode,
            'utr_number' => $utrNumber ?: null,
        ];

        DataStore::updateItem('cab_bookings', $id, $data);

        // Also sync directly to MySQL cab_bookings table if exists
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('cab_bookings')) {
                $dbUpdate = array_merge($data, ['updated_at' => now()]);
                \Illuminate\Support\Facades\DB::table('cab_bookings')->where('id', $id)->update($dbUpdate);
            }
        } catch (\Throwable $e) {}

        $statusMsg = ($paymentStatus === 'paid') ? 'Marked as PAID' : 'Marked as UNPAID / PENDING';
        return back()->with('success', "Cab booking #{$id} details and status updated successfully ({$statusMsg})!");
    }

    public function storeLocation(Request $request)
    {
        $name = trim($request->input('name'));
        $type = $request->input('type', 'Both');
        if (!empty($name)) {
            DataStore::addItem('cab_locations', [
                'name' => $name,
                'type' => $type,
                'status' => 'Active'
            ]);
            return back()->with('success', "Location '{$name}' added to {$type} directory!");
        }
        return back()->with('error', 'Location name cannot be empty.');
    }

    public function updateLocation(Request $request, $id)
    {
        $name = trim($request->input('name'));
        $type = $request->input('type', 'Both');
        if (!empty($name)) {
            DataStore::updateItem('cab_locations', $id, [
                'name' => $name,
                'type' => $type
            ]);
            return back()->with('success', "Location '{$name}' updated successfully!");
        }
        return back()->with('error', 'Location name cannot be empty.');
    }

    public function destroyLocation($id)
    {
        DataStore::deleteItem('cab_locations', $id);
        return back()->with('success', "Location deleted successfully from directory!");
    }
}

