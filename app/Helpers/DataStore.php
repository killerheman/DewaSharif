<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class DataStore
{
    protected static $filePath;

    protected static function getFilePath()
    {
        if (!static::$filePath) {
            static::$filePath = storage_path('app/data_store.json');
        }
        return static::$filePath;
    }

    public static function get()
    {
        $path = static::getFilePath();
        if (!File::exists($path)) {
            $initialData = static::defaultData();
            File::put($path, json_encode($initialData, JSON_PRETTY_PRINT));
            return $initialData;
        }

        $content = File::get($path);
        $data = json_decode($content, true);

        if (!is_array($data)) {
            $data = static::defaultData();
            File::put($path, json_encode($data, JSON_PRETTY_PRINT));
        }

        return array_merge(static::defaultData(), $data);
    }

    public static function save(array $data)
    {
        $path = static::getFilePath();
        File::put($path, json_encode($data, JSON_PRETTY_PRINT));
    }

    public static function getCollection($key)
    {
        try {
            if ($key === 'hotels' && \Illuminate\Support\Facades\Schema::hasTable('hotels')) {
                $dbHotels = \Illuminate\Support\Facades\DB::table('hotels')->orderBy('id', 'asc')->get();
                return $dbHotels->map(function ($h) {
                    $arr = (array)$h;
                    if (!empty($arr['amenities']) && is_string($arr['amenities'])) {
                        $decoded = json_decode($arr['amenities'], true);
                        $arr['amenities'] = is_array($decoded) ? $decoded : explode(',', $arr['amenities']);
                    }
                    return $arr;
                })->all();
            } elseif ($key === 'hotel_bookings' && \Illuminate\Support\Facades\Schema::hasTable('hotel_bookings')) {
                $dbBookings = \Illuminate\Support\Facades\DB::table('hotel_bookings')->orderBy('created_at', 'desc')->get();
                if ($dbBookings->isNotEmpty()) {
                    return $dbBookings->map(function ($b) {
                        $arr = (array)$b;
                        $arr['booking_code'] = $arr['booking_code'] ?? ($arr['booking_number'] ?? ($arr['booking_id'] ?? ('#HTL-' . ($arr['id'] ?? 1))));
                        $arr['booking_number'] = $arr['booking_number'] ?? $arr['booking_code'];
                        $arr['hotel_name'] = $arr['hotel_name'] ?? 'Al-Waris Deluxe Guest House';
                        $arr['room_name'] = $arr['room_name'] ?? 'Deluxe AC Room';
                        $arr['total_amount'] = $arr['total_amount'] ?? 1499;
                        $arr['status'] = $arr['status'] ?? ($arr['booking_status'] ?? 'Confirmed & Paid');
                        return $arr;
                    })->all();
                }
            } elseif ($key === 'cabs' && \Illuminate\Support\Facades\Schema::hasTable('cabs')) {
                $dbCabs = \Illuminate\Support\Facades\DB::table('cabs')->orderBy('id', 'asc')->get();
                return $dbCabs->map(fn($c) => (array)$c)->all();
            } elseif ($key === 'cab_bookings' && \Illuminate\Support\Facades\Schema::hasTable('cab_bookings')) {
                $dbCabBookings = \Illuminate\Support\Facades\DB::table('cab_bookings')->orderBy('created_at', 'desc')->get();
                if ($dbCabBookings->isNotEmpty()) {
                    return $dbCabBookings->map(function ($b) {
                        $arr = (array)$b;
                        $arr['booking_code'] = $arr['booking_code'] ?? ($arr['booking_id'] ?? ('#CB-' . ($arr['id'] ?? 1)));
                        $arr['pickup'] = $arr['pickup'] ?? ($arr['pickup_location'] ?? 'Dewa Sharif');
                        $arr['destination'] = $arr['destination'] ?? ($arr['drop_location'] ?? 'Lucknow');
                        $arr['route'] = $arr['route'] ?? ($arr['pickup'] . ' → ' . $arr['destination']);
                        $arr['fare'] = $arr['fare'] ?? ($arr['total_amount'] ?? 0);
                        $arr['total_fare'] = $arr['total_fare'] ?? ($arr['total_amount'] ?? 0);
                        $arr['vehicle_type'] = $arr['vehicle_type'] ?? ($arr['vehicle_name'] ?? 'Swift Dzire (AC)');
                        $arr['vehicle_name'] = $arr['vehicle_name'] ?? $arr['vehicle_type'];
                        $arr['status'] = $arr['status'] ?? ($arr['booking_status'] ?? 'Confirmed & Paid');
                        return $arr;
                    })->all();
                }
            } elseif ($key === 'cab_vehicles' && \Illuminate\Support\Facades\Schema::hasTable('cab_vehicles')) {
                $dbVehicles = \Illuminate\Support\Facades\DB::table('cab_vehicles')->orderBy('id', 'asc')->get();
                return $dbVehicles->map(fn($v) => (array)$v)->all();
            } elseif ($key === 'cab_locations' && \Illuminate\Support\Facades\Schema::hasTable('cab_locations')) {
                $dbLocs = \Illuminate\Support\Facades\DB::table('cab_locations')->orderBy('id', 'asc')->get();
                return $dbLocs->map(fn($l) => (array)$l)->all();
            } elseif ($key === 'products' && \Illuminate\Support\Facades\Schema::hasTable('shop_products')) {
                $dbProducts = \Illuminate\Support\Facades\DB::table('shop_products')->where('status', 'active')->orderBy('id', 'asc')->get();
                return $dbProducts->map(function ($p) {
                    $arr = (array)$p;
                    $arr['category'] = $arr['category_slug'] ?? ($arr['category'] ?? 'attar');
                    $arr['image'] = $arr['thumbnail'] ?? '';
                    return $arr;
                })->all();
            }
        } catch (\Throwable $e) {}

        $all = static::get();
        return $all[$key] ?? [];
    }

    public static function addItem($key, array $item)
    {
        $all = static::get();
        if (!isset($all[$key]) || !is_array($all[$key])) {
            $all[$key] = [];
        }

        if (!isset($item['id'])) {
            $item['id'] = time() . rand(100, 999);
        }
        if (!isset($item['created_at'])) {
            $item['created_at'] = date('Y-m-d H:i:s');
        }

        array_unshift($all[$key], $item);
        static::save($all);

        // Sync to MySQL DB table if exists
        try {
            if ($key === 'products' || \Illuminate\Support\Facades\Schema::hasTable($key)) {
                if ($key === 'cab_bookings') {
                    $bCode = $item['booking_code'] ?? ($item['booking_number'] ?? ($item['booking_id'] ?? ('DWS-CAB-' . date('Y') . '-' . rand(1000, 9999))));
                    $fare = (float)($item['fare'] ?? ($item['total_fare'] ?? ($item['total_amount'] ?? 1400)));
                    $status = $item['status'] ?? 'Confirmed & Paid';
                    $rawStatus = strtolower($status);
                    $payStatus = (str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'confirm')) ? 'paid' : 'pending';
                    $bookStatus = (str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'confirm')) ? 'assigned' : 'pending';

                    $rawDate = $item['pickup_date'] ?? date('Y-m-d');
                    $pickupDate = date('Y-m-d', strtotime($rawDate) ?: time());

                    // Check if cab_id exists in cabs table to avoid foreign key failure
                    $cabId = $item['cab_id'] ?? null;
                    if ($cabId && \Illuminate\Support\Facades\Schema::hasTable('cabs')) {
                        if (!\Illuminate\Support\Facades\DB::table('cabs')->where('id', $cabId)->exists()) {
                            $cabId = null;
                        }
                    }

                    // Check if user_id exists in users table
                    $userId = $item['user_id'] ?? (auth()->id() ?? null);
                    if ($userId && \Illuminate\Support\Facades\Schema::hasTable('users')) {
                        if (!\Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->exists()) {
                            $userId = null;
                        }
                    }

                    $cabDbData = [
                        'booking_id' => $bCode,
                        'booking_code' => $bCode,
                        'cab_id' => $cabId,
                        'user_id' => $userId,
                        'customer_name' => $item['customer_name'] ?? 'Passenger',
                        'customer_phone' => $item['customer_phone'] ?? '9648777223',
                        'customer_email' => $item['customer_email'] ?? (auth()->user()->email ?? null),
                        'customer_address' => $item['customer_address'] ?? null,
                        'alternate_phone' => $item['alternate_phone'] ?? null,
                        'pickup_location' => $item['pickup'] ?? ($item['pickup_location'] ?? 'Dewa Sharif'),
                        'drop_location' => $item['destination'] ?? ($item['drop_location'] ?? 'Lucknow Charbagh Railway Station'),
                        'route' => $item['route'] ?? (($item['pickup'] ?? 'Dewa Sharif') . ' → ' . ($item['destination'] ?? 'Lucknow')),
                        'pickup_date' => $pickupDate,
                        'pickup_time' => $item['pickup_time'] ?? date('Y-m-d @ H:i'),
                        'vehicle_type' => $item['vehicle_type'] ?? 'Sedan',
                        'vehicle_name' => $item['vehicle_name'] ?? ($item['vehicle_type'] ?? 'Swift Dzire'),
                        'total_amount' => $fare,
                        'fare' => $fare,
                        'total_fare' => $fare,
                        'paid_amount' => ($payStatus === 'paid') ? $fare : 0,
                        'pending_amount' => ($payStatus === 'paid') ? 0 : $fare,
                        'night_surcharge' => (float)($item['night_surcharge'] ?? 0),
                        'id_type' => $item['id_type'] ?? 'Aadhaar Card',
                        'id_no' => $item['id_no'] ?? 'N/A',
                        'driver' => $item['driver'] ?? 'Driver Assignment in Progress',
                        'driver_name' => $item['driver_name'] ?? null,
                        'driver_phone' => $item['driver_phone'] ?? null,
                        'driver_vehicle_number' => $item['driver_vehicle_number'] ?? null,
                        'payment_id' => $item['payment_id'] ?? null,
                        'utr_number' => $item['utr_number'] ?? null,
                        'payment_mode' => $item['payment_mode'] ?? (($payStatus === 'paid') ? 'full' : 'whatsapp'),
                        'payment_status' => $payStatus,
                        'booking_status' => $bookStatus,
                        'status' => $status,
                        'created_at' => date('Y-m-d H:i:s', strtotime($item['created_at'] ?? 'now') ?: time()),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $existingCabCols = \Illuminate\Support\Facades\Schema::getColumnListing('cab_bookings');
                    $filteredCabData = array_intersect_key($cabDbData, array_flip($existingCabCols));

                    \Illuminate\Support\Facades\DB::table('cab_bookings')->updateOrInsert(
                        ['booking_id' => $bCode],
                        $filteredCabData
                    );
                } elseif ($key === 'cabs') {
                    $fare = (float)($item['fare'] ?? ($item['price'] ?? 1400));
                    \Illuminate\Support\Facades\DB::table('cabs')->updateOrInsert(
                        ['id' => $item['id']],
                        [
                            'id' => $item['id'],
                            'vehicle_name' => $item['vehicle_name'] ?? 'Swift Dzire',
                            'vehicle_number' => $item['vehicle_number'] ?? 'UP 32 AB 1234',
                            'vehicle_type' => $item['vehicle_type'] ?? ($item['title'] ?? 'Sedan'),
                            'ac_option' => $item['ac_option'] ?? 'AC',
                            'seating_capacity' => $item['seating_capacity'] ?? ($item['capacity'] ?? '4 Passengers + 1 Driver'),
                            'capacity' => $item['capacity'] ?? ($item['seating_capacity'] ?? '4 Passengers + 1 Driver'),
                            'toll_status' => $item['toll_status'] ?? 'Toll Tax Included',
                            'title' => $item['title'] ?? ($item['vehicle_type'] ?? 'Sedan'),
                            'route_name' => $item['route_name'] ?? ($item['route'] ?? 'Lucknow ↔ Dewa Sharif'),
                            'route' => $item['route'] ?? ($item['route_name'] ?? 'Lucknow ↔ Dewa Sharif'),
                            'pickup' => $item['pickup'] ?? 'Dewa Sharif',
                            'destination' => $item['destination'] ?? 'Lucknow Charbagh Railway Station',
                            'fare' => $fare,
                            'price' => $fare,
                            'driver_name' => $item['driver_name'] ?? 'Ramesh Kumar',
                            'driver_phone' => $item['driver_phone'] ?? '+91 9648777223',
                            'driver_aadhaar' => $item['driver_aadhaar'] ?? '1234 5678 9012',
                            'driver_dl' => $item['driver_dl'] ?? 'UP32-2022-0089123',
                            'luggage_capacity' => $item['luggage_capacity'] ?? '2 Large Bags + 2 Small Bags',
                            'image' => $item['image'] ?? asset('home/images/dewasharif/dewapage/cab_dzire.jpg'),
                            'status' => strtolower($item['status'] ?? 'active') === 'active' ? 'active' : 'inactive',
                            'created_at' => $item['created_at'] ?? date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                } elseif ($key === 'cab_vehicles') {
                    \Illuminate\Support\Facades\DB::table('cab_vehicles')->updateOrInsert(
                        ['id' => $item['id']],
                        [
                            'id' => $item['id'],
                            'name' => $item['name'] ?? 'Swift Dzire',
                            'type' => $item['type'] ?? 'Standard Taxi',
                            'capacity' => $item['capacity'] ?? '4 Passengers + 1 Driver',
                            'price' => (float)($item['price'] ?? 1400),
                            'fare' => (float)($item['fare'] ?? ($item['price'] ?? 1400)),
                            'fare_factor' => (float)($item['fare_factor'] ?? 1.00),
                            'status' => $item['status'] ?? 'Active',
                            'image' => $item['image'] ?? asset('home/images/dewasharif/dewapage/cab_dzire.jpg'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                } elseif ($key === 'cab_locations') {
                    \Illuminate\Support\Facades\DB::table('cab_locations')->updateOrInsert(
                        ['id' => $item['id']],
                        [
                            'id' => $item['id'],
                            'name' => $item['name'] ?? 'Location',
                            'type' => $item['type'] ?? 'Both',
                            'status' => $item['status'] ?? 'Active',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                } elseif ($key === 'hotel_bookings') {
                    $bCode = $item['booking_code'] ?? ($item['booking_number'] ?? ($item['booking_id'] ?? ('DWS-HTL-' . date('Y') . '-' . rand(1000, 9999))));
                    $totAmt = (float)($item['total_amount'] ?? ($item['amount'] ?? ($item['price'] ?? ($item['total_fare'] ?? 1499))));
                    $status = $item['status'] ?? 'Confirmed & Paid';
                    $rawStatus = strtolower($status);
                    $payStatus = !empty($item['payment_status']) ? strtolower($item['payment_status']) : ((str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'confirmed')) ? 'paid' : 'pending');
                    $bookStatus = (str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'confirmed')) ? 'confirmed' : 'pending';

                    $rawCheckin = $item['checkin'] ?? ($item['check_in'] ?? ($item['check_in_date'] ?? date('Y-m-d')));
                    $checkinVal = date('Y-m-d', strtotime($rawCheckin) ?: time());
                    $rawCheckout = $item['checkout'] ?? ($item['check_out'] ?? ($item['check_out_date'] ?? date('Y-m-d', strtotime('+1 day'))));
                    $checkoutVal = date('Y-m-d', strtotime($rawCheckout) ?: strtotime('+1 day'));

                    // Check if hotel_id exists in hotels table to avoid foreign key failure
                    $hotelId = $item['hotel_id'] ?? 1;
                    if ($hotelId && \Illuminate\Support\Facades\Schema::hasTable('hotels')) {
                        if (!\Illuminate\Support\Facades\DB::table('hotels')->where('id', $hotelId)->exists()) {
                            $hotelId = null;
                        }
                    }

                    // Check if user_id exists in users table
                    $userId = $item['user_id'] ?? (auth()->id() ?? null);
                    if ($userId && \Illuminate\Support\Facades\Schema::hasTable('users')) {
                        if (!\Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->exists()) {
                            $userId = null;
                        }
                    }

                    $htlDbData = [
                        'booking_id' => $bCode,
                        'booking_code' => $bCode,
                        'booking_number' => $bCode,
                        'hotel_id' => $hotelId,
                        'user_id' => $userId,
                        'hotel_name' => $item['hotel_name'] ?? ($item['hotel'] ?? 'Al-Waris Deluxe Guest House'),
                        'room_name' => $item['room_name'] ?? ($item['room'] ?? ($item['room_type'] ?? 'Deluxe AC Room')),
                        'customer_name' => $item['customer_name'] ?? ($item['name'] ?? 'Guest User'),
                        'customer_phone' => $item['customer_phone'] ?? ($item['phone'] ?? '9648777223'),
                        'customer_email' => $item['customer_email'] ?? (auth()->user()->email ?? null),
                        'customer_address' => $item['customer_address'] ?? null,
                        'alternate_phone' => $item['alternate_phone'] ?? null,
                        'check_in' => $checkinVal,
                        'check_out' => $checkoutVal,
                        'persons' => (int)($item['guests'] ?? ($item['persons'] ?? 2)),
                        'rooms' => (int)($item['rooms'] ?? 1),
                        'nights' => (int)($item['nights'] ?? 1),
                        'total_amount' => $totAmt,
                        'paid_amount' => ($payStatus === 'paid') ? $totAmt : (float)($item['paid_amount'] ?? 0),
                        'pending_amount' => ($payStatus === 'paid') ? 0 : $totAmt,
                        'price_per_night' => (float)($item['price_per_night'] ?? ($item['price'] ?? 1499)),
                        'id_type' => $item['id_type'] ?? 'Aadhaar Card',
                        'id_no' => $item['id_no'] ?? 'N/A',
                        'payment_id' => $item['payment_id'] ?? ('RZP_HOTEL_' . time()),
                        'payment_mode' => $item['payment_mode'] ?? (($payStatus === 'paid') ? 'full' : 'whatsapp'),
                        'payment_status' => $payStatus,
                        'hotel_status' => $bookStatus,
                        'booking_status' => $bookStatus,
                        'status' => $status,
                        'created_at' => date('Y-m-d H:i:s', strtotime($item['created_at'] ?? 'now') ?: time()),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $existingHtlCols = \Illuminate\Support\Facades\Schema::getColumnListing('hotel_bookings');
                    $filteredHtlData = array_intersect_key($htlDbData, array_flip($existingHtlCols));

                    \Illuminate\Support\Facades\DB::table('hotel_bookings')->updateOrInsert(
                        ['booking_id' => $bCode],
                        $filteredHtlData
                    );
                } elseif ($key === 'hotels') {
                    $amenities = $item['amenities'] ?? ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water'];
                    $amenitiesStr = is_array($amenities) ? json_encode($amenities) : (string)$amenities;
                    $hPrice = (float)($item['price_per_night'] ?? ($item['price'] ?? 1499));

                    \Illuminate\Support\Facades\DB::table('hotels')->updateOrInsert(
                        ['id' => $item['id']],
                        [
                            'id' => $item['id'],
                            'name' => $item['name'] ?? 'Guest House',
                            'slug' => \Illuminate\Support\Str::slug($item['name'] ?? 'hotel') . '-' . $item['id'],
                            'address' => $item['location'] ?? ($item['distance'] ?? 'Near Dewa Sharif Dargah'),
                            'location' => $item['location'] ?? ($item['distance'] ?? 'Near Dewa Sharif Dargah'),
                            'distance' => $item['distance'] ?? ($item['location'] ?? 'Near Dargah Gate'),
                            'phone' => $item['phone'] ?? '+91 9648777223',
                            'description' => $item['description'] ?? ($item['room_type'] ?? 'Deluxe Room'),
                            'cover_image' => $item['image'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'),
                            'image' => $item['image'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'),
                            'image_main' => $item['image_main'] ?? ($item['image'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg')),
                            'image_reception' => $item['image_reception'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'),
                            'image_room' => $item['image_room'] ?? asset('home/images/dewasharif/dewapage/deluxe_room.jpg'),
                            'image_bathroom' => $item['image_bathroom'] ?? asset('home/images/dewasharif/dewapage/standard_room.jpg'),
                            'image_extra' => $item['image_extra'] ?? asset('home/images/dewasharif/dewapage/deluxe_room.jpg'),
                            'price' => $hPrice,
                            'price_per_night' => $hPrice,
                            'mrp' => (float)($item['mrp'] ?? ($hPrice * 1.3)),
                            'available_rooms' => (int)($item['available_rooms'] ?? 10),
                            'category' => $item['category'] ?? 'queen_ac',
                            'category_name' => $item['category_name'] ?? ($item['room_type'] ?? 'Queen Size AC'),
                            'room_type' => $item['room_type'] ?? ($item['category_name'] ?? 'Deluxe AC Room'),
                            'ac_type' => $item['ac_type'] ?? 'AC',
                            'bed_type' => $item['bed_type'] ?? 'Double Bed',
                            'max_adults' => (int)($item['max_adults'] ?? 2),
                            'max_children' => (int)($item['max_children'] ?? 1),
                            'bath_type' => $item['bath_type'] ?? 'Attached Western Bath',
                            'amenities' => $amenitiesStr,
                            'status' => strtolower($item['status'] ?? 'active') === 'active' ? 'active' : 'inactive',
                            'created_at' => $item['created_at'] ?? date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                } elseif ($key === 'products') {
                    $catSlug = $item['category'] ?? 'attar';
                    $catRecord = \Illuminate\Support\Facades\DB::table('shop_categories')->where('slug', $catSlug)->first();
                    $catId = $catRecord ? $catRecord->id : 1;
                    $pName = $item['name'] ?? 'Product';
                    $pSlug = \Illuminate\Support\Str::slug($pName) . '-' . ($item['id'] ?? rand(100, 999));

                    \Illuminate\Support\Facades\DB::table('shop_products')->updateOrInsert(
                        ['id' => $item['id']],
                        [
                            'id' => $item['id'],
                            'category_id' => $catId,
                            'category_slug' => $catSlug,
                            'name' => $pName,
                            'slug' => $pSlug,
                            'price' => (float)($item['price'] ?? 299),
                            'sale_price' => (float)($item['price'] ?? 299),
                            'mrp' => (float)($item['mrp'] ?? round(($item['price'] ?? 299) * 1.3)),
                            'stock_quantity' => (int)($item['stock'] ?? 50),
                            'volume_ml' => $item['volume_ml'] ?? null,
                            'size_options' => $item['size_options'] ?? null,
                            'fabric_material' => $item['fabric_material'] ?? null,
                            'thumbnail' => $item['image'] ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg',
                            'description' => $item['description'] ?? '',
                            'status' => strtolower($item['status'] ?? 'active') === 'active' ? 'active' : 'inactive',
                            'created_at' => $item['created_at'] ?? date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                } elseif ($key === 'shop_categories') {
                    $cSlug = $item['slug'] ?? \Illuminate\Support\Str::slug($item['name'] ?? 'category');
                    \Illuminate\Support\Facades\DB::table('shop_categories')->updateOrInsert(
                        ['slug' => $cSlug],
                        [
                            'name' => $item['name'] ?? 'Category',
                            'slug' => $cSlug,
                            'image' => $item['image'] ?? null,
                            'status' => strtolower($item['status'] ?? 'active') === 'active' ? 'active' : 'inactive',
                            'created_at' => $item['created_at'] ?? date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    );
                } elseif ($key === 'shop_orders') {
                    $oCode = $item['order_code'] ?? ($item['order_id'] ?? ('DWS-SHP-' . date('Y') . '-' . rand(1000, 9999)));
                    $oStatus = strtolower($item['status'] ?? 'processing');
                    if (str_contains($oStatus, 'dispatch')) $mappedStatus = 'shipped';
                    elseif (str_contains($oStatus, 'deliver')) $mappedStatus = 'delivered';
                    elseif (str_contains($oStatus, 'cancel')) $mappedStatus = 'cancelled';
                    else $mappedStatus = 'processing';

                    $payStatus = (str_contains(strtolower($item['payment_status'] ?? ''), 'paid') || str_contains($oStatus, 'paid')) ? 'paid' : 'pending';

                    // Check if user_id exists in users table
                    $userId = $item['user_id'] ?? (auth()->id() ?? null);
                    if ($userId && \Illuminate\Support\Facades\Schema::hasTable('users')) {
                        if (!\Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->exists()) {
                            $userId = null;
                        }
                    }

                    $shopDbData = [
                        'order_id' => $oCode,
                        'user_id' => $userId,
                        'customer_name' => $item['customer_name'] ?? 'Customer',
                        'customer_phone' => $item['customer_phone'] ?? 'N/A',
                        'customer_whatsapp' => $item['customer_whatsapp'] ?? ($item['customer_phone'] ?? null),
                        'alternate_phone' => $item['alternate_phone'] ?? null,
                        'shipping_address' => $item['address'] ?? ($item['shipping_address'] ?? 'Dewa Sharif'),
                        'items_summary' => $item['items_summary'] ?? 'Sacred Items',
                        'total_amount' => (float)($item['total_amount'] ?? ($item['amount'] ?? 1497)),
                        'paid_amount' => ($payStatus === 'paid') ? (float)($item['total_amount'] ?? ($item['amount'] ?? 1497)) : 0,
                        'payment_id' => $item['payment_id'] ?? 'RZP_SHP',
                        'payment_mode' => $item['payment_mode'] ?? (($payStatus === 'paid') ? 'full' : 'whatsapp'),
                        'payment_status' => $payStatus,
                        'order_status' => $mappedStatus,
                        'courier_name' => $item['courier'] ?? 'DTDC Express',
                        'tracking_number' => $item['tracking'] ?? 'DT12345678IN',
                        'fateha_name' => $item['fateha_name'] ?? null,
                        'niyaz_date' => $item['niyaz_date'] ?? null,
                        'distribution_type' => $item['distribution_type'] ?? null,
                        'is_degh' => !empty($item['is_degh']) ? 1 : 0,
                        'created_at' => $item['created_at'] ?? date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $existingShopCols = \Illuminate\Support\Facades\Schema::getColumnListing('shop_orders');
                    $filteredShopData = array_intersect_key($shopDbData, array_flip($existingShopCols));

                    \Illuminate\Support\Facades\DB::table('shop_orders')->updateOrInsert(
                        ['order_id' => $oCode],
                        $filteredShopData
                    );
                } else {
                    $dbData = $item;
                    \Illuminate\Support\Facades\DB::table($key)->insertGetId($dbData);
                }
            }
        } catch (\Throwable $e) {
            // Suppress schema mismatch if table structure varies
        }

        return $item;
    }

    public static function deleteItem($key, $id)
    {
        $all = static::get();
        if (isset($all[$key]) && is_array($all[$key])) {
            $all[$key] = array_values(array_filter($all[$key], function ($item) use ($id) {
                return (string) ($item['id'] ?? '') !== (string) $id;
            }));
            static::save($all);
        }

        try {
            if ($key === 'products') {
                \Illuminate\Support\Facades\DB::table('shop_products')->where('id', $id)->delete();
            } elseif ($key === 'shop_orders') {
                \Illuminate\Support\Facades\DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->delete();
            } elseif ($key === 'shop_categories') {
                \Illuminate\Support\Facades\DB::table('shop_categories')->where('id', $id)->orWhere('slug', $id)->delete();
            } elseif (\Illuminate\Support\Facades\Schema::hasTable($key)) {
                if ($key === 'cab_bookings') {
                    \Illuminate\Support\Facades\DB::table('cab_bookings')->where('id', $id)->orWhere('booking_id', $id)->delete();
                } elseif ($key === 'hotel_bookings') {
                    \Illuminate\Support\Facades\DB::table('hotel_bookings')->where('id', $id)->orWhere('booking_id', $id)->delete();
                } else {
                    \Illuminate\Support\Facades\DB::table($key)->where('id', $id)->delete();
                }
            }
        } catch (\Throwable $e) {}
    }

    public static function updateItem($key, $id, array $updatedData)
    {
        $all = static::get();
        if (isset($all[$key]) && is_array($all[$key])) {
            foreach ($all[$key] as &$item) {
                if ((string) ($item['id'] ?? '') === (string) $id) {
                    $item = array_merge($item, $updatedData);
                    break;
                }
            }
            static::save($all);
        }

        try {
            if ($key === 'products') {
                $dbUp = [];
                if (isset($updatedData['name'])) $dbUp['name'] = $updatedData['name'];
                if (isset($updatedData['price'])) { $dbUp['price'] = (float)$updatedData['price']; $dbUp['sale_price'] = (float)$updatedData['price']; }
                if (isset($updatedData['mrp'])) $dbUp['mrp'] = (float)$updatedData['mrp'];
                if (isset($updatedData['stock'])) $dbUp['stock_quantity'] = (int)$updatedData['stock'];
                if (isset($updatedData['image'])) $dbUp['thumbnail'] = $updatedData['image'];
                if (isset($updatedData['description'])) $dbUp['description'] = $updatedData['description'];
                if (isset($updatedData['status'])) $dbUp['status'] = strtolower($updatedData['status']) === 'active' ? 'active' : 'inactive';
                if (isset($updatedData['category'])) {
                    $dbUp['category_slug'] = $updatedData['category'];
                    $catRecord = \Illuminate\Support\Facades\DB::table('shop_categories')->where('slug', $updatedData['category'])->first();
                    if ($catRecord) $dbUp['category_id'] = $catRecord->id;
                }
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('shop_products')->where('id', $id)->update($dbUp);
            } elseif ($key === 'shop_orders') {
                $dbUp = [];
                if (isset($updatedData['status'])) {
                    $st = strtolower($updatedData['status']);
                    if (str_contains($st, 'dispatch')) $dbUp['order_status'] = 'shipped';
                    elseif (str_contains($st, 'deliver')) $dbUp['order_status'] = 'delivered';
                    elseif (str_contains($st, 'cancel') || str_contains($st, 'fail')) $dbUp['order_status'] = 'cancelled';
                    else $dbUp['order_status'] = 'processing';
                }
                if (isset($updatedData['payment_status'])) {
                    $ps = strtolower($updatedData['payment_status']);
                    $dbUp['payment_status'] = ($ps === 'paid' || $ps === 'failed') ? $ps : 'pending';
                }
                if (isset($updatedData['courier'])) $dbUp['courier_name'] = $updatedData['courier'];
                if (isset($updatedData['tracking'])) $dbUp['tracking_number'] = $updatedData['tracking'];
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->update($dbUp);
            } elseif ($key === 'hotels') {
                $dbUp = [];
                foreach ($updatedData as $k => $v) {
                    if ($k === 'amenities') {
                        $dbUp['amenities'] = is_array($v) ? json_encode($v) : (string)$v;
                    } elseif (\Illuminate\Support\Facades\Schema::hasColumn('hotels', $k)) {
                        $dbUp[$k] = $v;
                    }
                }
                if (isset($updatedData['price_per_night']) && !isset($dbUp['price'])) {
                    $dbUp['price'] = (float)$updatedData['price_per_night'];
                }
                if (isset($updatedData['location']) && !isset($dbUp['address'])) {
                    $dbUp['address'] = $updatedData['location'];
                }
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('hotels')->where('id', $id)->update($dbUp);
            } elseif ($key === 'hotel_bookings') {
                $dbUp = [];
                foreach ($updatedData as $k => $v) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('hotel_bookings', $k)) {
                        $dbUp[$k] = $v;
                    }
                }
                if (isset($updatedData['status'])) {
                    $st = strtolower($updatedData['status']);
                    $isFailed = str_contains($st, 'fail') || str_contains($st, 'cancel') || str_contains($st, 'void');
                    $isConfirmed = str_contains($st, 'confirm') || str_contains($st, 'paid');
                    $dbUp['status'] = $updatedData['status'];
                    $dbUp['hotel_status'] = $isFailed ? 'cancelled' : ($isConfirmed ? 'confirmed' : 'pending');
                    $dbUp['booking_status'] = $isFailed ? 'cancelled' : ($isConfirmed ? 'confirmed' : 'pending');
                    $dbUp['payment_status'] = $isFailed ? 'failed' : ($isConfirmed ? 'paid' : 'pending');
                }
                if (isset($updatedData['payment_status'])) {
                    $dbUp['payment_status'] = $updatedData['payment_status'];
                }
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('hotel_bookings')
                    ->where('id', $id)
                    ->orWhere('booking_id', $id)
                    ->orWhere('booking_code', $id)
                    ->update($dbUp);
            } elseif ($key === 'cabs') {
                $dbUp = [];
                foreach ($updatedData as $k => $v) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('cabs', $k)) {
                        $dbUp[$k] = $v;
                    }
                }
                if (isset($updatedData['price']) && !isset($dbUp['fare'])) {
                    $dbUp['fare'] = (float)$updatedData['price'];
                }
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('cabs')->where('id', $id)->update($dbUp);
            } elseif ($key === 'cab_bookings') {
                $dbUp = [];
                foreach ($updatedData as $k => $v) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('cab_bookings', $k)) {
                        $dbUp[$k] = $v;
                    }
                }
                if (isset($updatedData['status'])) {
                    $st = strtolower($updatedData['status']);
                    $isFailed = str_contains($st, 'fail') || str_contains($st, 'cancel') || str_contains($st, 'void');
                    $isConfirmed = str_contains($st, 'confirm') || str_contains($st, 'paid') || str_contains($st, 'dispatch');
                    $dbUp['status'] = $updatedData['status'];
                    $dbUp['booking_status'] = $isFailed ? 'cancelled' : ($isConfirmed ? 'assigned' : 'pending');
                    $dbUp['payment_status'] = $isFailed ? 'failed' : ($isConfirmed ? 'paid' : 'pending');
                }
                if (isset($updatedData['payment_status'])) {
                    $dbUp['payment_status'] = $updatedData['payment_status'];
                }
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('cab_bookings')
                    ->where('id', $id)
                    ->orWhere('booking_id', $id)
                    ->orWhere('booking_code', $id)
                    ->update($dbUp);
            } elseif ($key === 'cab_vehicles') {
                $dbUp = [];
                foreach ($updatedData as $k => $v) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('cab_vehicles', $k)) {
                        $dbUp[$k] = $v;
                    }
                }
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('cab_vehicles')->where('id', $id)->update($dbUp);
            } elseif ($key === 'cab_locations') {
                $dbUp = [];
                foreach ($updatedData as $k => $v) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('cab_locations', $k)) {
                        $dbUp[$k] = $v;
                    }
                }
                $dbUp['updated_at'] = date('Y-m-d H:i:s');
                \Illuminate\Support\Facades\DB::table('cab_locations')->where('id', $id)->update($dbUp);
            } elseif (\Illuminate\Support\Facades\Schema::hasTable($key)) {
                \Illuminate\Support\Facades\DB::table($key)->where('id', $id)->update($updatedData);
            }
        } catch (\Throwable $e) {}
    }

    public static function setItem($key, $value)
    {
        $all = static::get();
        $all[$key] = $value;
        static::save($all);
        return $value;
    }

    public static function getItem($key, $id = null)
    {
        $all = static::get();
        if (!isset($all[$key])) {
            return null;
        }
        $val = $all[$key];
        if ($id === null) {
            return $val;
        }
        if (is_array($val)) {
            if (isset($val['id']) && (string)$val['id'] === (string)$id) {
                return $val;
            }
            foreach ($val as $item) {
                if (is_array($item) && (string)($item['id'] ?? '') === (string)$id) {
                    return $item;
                }
            }
            if (!isset($val[0]) && is_array($val)) {
                return $val;
            }
        }
        return null;
    }

    public static function saveItem($key, $id, array $data)
    {
        $all = static::get();
        if (!isset($all[$key]) || !is_array($all[$key])) {
            $data['id'] = $id;
            $all[$key] = $data;
        } else {
            if (!isset($all[$key][0])) {
                $data['id'] = $id;
                $all[$key] = array_merge($all[$key], $data);
            } else {
                $found = false;
                foreach ($all[$key] as &$item) {
                    if (is_array($item) && (string)($item['id'] ?? '') === (string)$id) {
                        $item = array_merge($item, $data);
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $data['id'] = $id;
                    $all[$key][] = $data;
                }
            }
        }
        static::save($all);
        return $data;
    }

    public static function defaultData()
    {
        return [
            'hotels' => [
                [
                    'id' => 1,
                    'name' => 'Al-Waris Deluxe Guest House',
                    'phone' => '+91 9648777223',
                    'category' => 'queen_ac ac',
                    'room_type' => 'Queen Size AC',
                    'ac_type' => 'AC',
                    'bed_type' => 'Queen Bed',
                    'max_adults' => 2,
                    'max_children' => 1,
                    'bath_type' => 'Attached Western Bath',
                    'category_name' => 'Queen Size AC Room',
                    'distance' => '120 meters',
                    'price' => 1499,
                    'price_per_night' => 1499,
                    'mrp' => 1999,
                    'available_rooms' => 10,
                    'image' => asset('home/images/dewasharif/dewapage/deluxe_room.jpg'),
                    'amenities' => ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Air Conditioner', 'CCTV Security'],
                    'description' => 'Attached Western Bath, 24x7 Generator Backup, CCTV & 120m from Dargah Mazar Gate.',
                    'status' => 'Active'
                ],
                [
                    'id' => 2,
                    'name' => 'Shah Wilayat Guest House',
                    'phone' => '+91 9648777223',
                    'category' => 'single_non_ac non_ac',
                    'room_type' => 'Single Non-AC',
                    'ac_type' => 'Non-AC',
                    'bed_type' => 'Single Bed',
                    'max_adults' => 1,
                    'max_children' => 0,
                    'bath_type' => 'Attached Bath',
                    'category_name' => 'Single Non-AC Room',
                    'distance' => '180 meters',
                    'price' => 799,
                    'price_per_night' => 799,
                    'mrp' => 1100,
                    'available_rooms' => 15,
                    'image' => asset('home/images/dewasharif/dewapage/standard_room.jpg'),
                    'amenities' => ['Free Wi-Fi', 'Near Dargah Gate', 'Room Service', 'CCTV Security'],
                    'description' => 'Clean budget single room, attached bathroom, pure drinking water, quiet ambience.',
                    'status' => 'Active'
                ],
                [
                    'id' => 3,
                    'name' => 'Warsi Shahi Family Lodge',
                    'phone' => '+91 9648777223',
                    'category' => 'hall_ac ac family',
                    'room_type' => 'AC Hall (5+ Persons)',
                    'ac_type' => 'AC',
                    'bed_type' => '6-Bedded Family Hall',
                    'max_adults' => 6,
                    'max_children' => 2,
                    'bath_type' => 'Double Western Bath',
                    'category_name' => 'AC Hall (5+ Persons)',
                    'distance' => '250 meters',
                    'price' => 2999,
                    'price_per_night' => 2999,
                    'mrp' => 3800,
                    'available_rooms' => 4,
                    'image' => asset('home/images/dewasharif/dewapage/family_hall.jpg'),
                    'amenities' => ['24/7 Power Backup', 'Free Wi-Fi', 'Air Conditioner', 'Geyser/Hot Water', 'CCTV Security'],
                    'description' => 'Spacious 6 bed air-conditioned family hall with attached double washrooms for groups.',
                    'status' => 'Active'
                ],
                [
                    'id' => 4,
                    'name' => 'Madina Grand Guest House',
                    'phone' => '+91 9648777223',
                    'category' => 'king_ac ac',
                    'room_type' => 'King Size AC',
                    'ac_type' => 'AC',
                    'bed_type' => 'King Size Bed',
                    'max_adults' => 3,
                    'max_children' => 1,
                    'bath_type' => 'Attached Luxury Bath',
                    'category_name' => 'King Size AC Room',
                    'distance' => '150 meters',
                    'price' => 1999,
                    'price_per_night' => 1999,
                    'mrp' => 2600,
                    'available_rooms' => 8,
                    'image' => asset('home/images/dewasharif/dewapage/deluxe_room.jpg'),
                    'amenities' => ['24/7 Power Backup', 'Free Wi-Fi', 'Air Conditioner', 'LED TV', 'Room Service'],
                    'description' => 'Luxury King Size bed room with LED TV, split AC, and premium room service near Dargah.',
                    'status' => 'Active'
                ],
                [
                    'id' => 5,
                    'name' => 'Warsi Heritage Non-AC Hall',
                    'phone' => '+91 9648777223',
                    'category' => 'hall_non_ac non_ac family',
                    'room_type' => 'Non-AC Hall (5+ Persons)',
                    'ac_type' => 'Non-AC',
                    'bed_type' => '8-Bedded Group Hall',
                    'max_adults' => 8,
                    'max_children' => 4,
                    'bath_type' => 'Multiple Bathrooms',
                    'category_name' => 'Non-AC Hall (5+ Persons)',
                    'distance' => '200 meters',
                    'price' => 1899,
                    'price_per_night' => 1899,
                    'mrp' => 2400,
                    'available_rooms' => 6,
                    'image' => asset('home/images/dewasharif/dewapage/family_hall.jpg'),
                    'amenities' => ['Free Wi-Fi', 'Air Cooler', 'Near Dargah Gate', 'Room Service'],
                    'description' => 'Budget large group hall with air coolers, multiple bathrooms, suitable for pilgrim groups.',
                    'status' => 'Active'
                ]
            ],

            'cabs' => [
                [
                    'id' => 1,
                    'vehicle_type' => 'Swift Dzire (Semi Deluxe - Sedan)',
                    'vehicle_name' => 'Maruti Swift Dzire',
                    'vehicle_number' => 'UP 32 AB 1234',
                    'ac_option' => 'AC',
                    'seating_capacity' => '4 Passengers + 1 Driver (Total 5)',
                    'capacity' => '4 Passengers + 1 Driver (Total 5)',
                    'toll_status' => 'Toll Tax Included',
                    'title' => 'Swift Dzire (Semi Deluxe - Sedan)',
                    'route_name' => 'Lucknow Charbagh Station ↔ Dewa Sharif Dargah',
                    'route' => 'Lucknow Charbagh Station ↔ Dewa Sharif Dargah',
                    'pickup' => 'Lucknow Charbagh Station',
                    'destination' => 'Dewa Sharif Dargah',
                    'fare' => 1400,
                    'price' => 1400,
                    'driver_name' => 'Ramesh Kumar',
                    'driver_phone' => '+91 9648777223',
                    'driver_aadhaar' => '1234 5678 9012',
                    'driver_dl' => 'UP32-2022-0089123',
                    'image' => asset('home/images/dewasharif/dewapage/cab_dzire.jpg'),
                    'status' => 'Active'
                ],
                [
                    'id' => 2,
                    'vehicle_type' => 'Maruti Ertiga (SUV Family Class)',
                    'vehicle_name' => 'Maruti Ertiga SUV',
                    'vehicle_number' => 'UP 32 ER 5678',
                    'ac_option' => 'AC',
                    'seating_capacity' => '6 Passengers + 1 Driver (Total 7)',
                    'capacity' => '6 Passengers + 1 Driver (Total 7)',
                    'toll_status' => 'Toll Tax Included',
                    'title' => 'Maruti Ertiga (SUV Family Class)',
                    'route_name' => 'Lucknow Airport ↔ Dewa Sharif Dargah',
                    'route' => 'Lucknow Airport ↔ Dewa Sharif Dargah',
                    'pickup' => 'Lucknow Airport',
                    'destination' => 'Dewa Sharif Dargah',
                    'fare' => 2200,
                    'price' => 2200,
                    'driver_name' => 'Masharrat Ali',
                    'driver_phone' => '+91 9648777223',
                    'driver_aadhaar' => '9876 5432 1098',
                    'driver_dl' => 'UP32-2021-0045678',
                    'image' => asset('home/images/dewasharif/dewapage/cab_ertiga.jpg'),
                    'status' => 'Active'
                ],
                [
                    'id' => 3,
                    'vehicle_type' => 'Maruti Omni (Standard)',
                    'vehicle_name' => 'Maruti Omni Van',
                    'vehicle_number' => 'UP 32 OM 1122',
                    'ac_option' => 'Non-AC',
                    'seating_capacity' => '7 Passengers + 1 Driver (Total 8)',
                    'capacity' => '7 Passengers + 1 Driver (Total 8)',
                    'toll_status' => 'Toll Tax Included',
                    'title' => 'Maruti Omni (Standard)',
                    'route_name' => 'Barabanki Junction Station ↔ Dewa Sharif',
                    'route' => 'Barabanki Junction Station ↔ Dewa Sharif',
                    'pickup' => 'Barabanki Junction Station',
                    'destination' => 'Dewa Sharif Dargah',
                    'fare' => 500,
                    'price' => 500,
                    'driver_name' => 'Aslam Khan',
                    'driver_phone' => '+91 9648777223',
                    'driver_aadhaar' => '4567 8901 2345',
                    'driver_dl' => 'UP32-2020-0012345',
                    'image' => asset('home/images/dewasharif/dewapage/cab_omni.jpg'),
                    'status' => 'Active'
                ],
                [
                    'id' => 4,
                    'vehicle_type' => 'Hyundai Verna (Deluxe - Executive Sedan)',
                    'vehicle_name' => 'Hyundai Verna',
                    'vehicle_number' => 'UP 32 VN 3344',
                    'ac_option' => 'AC',
                    'seating_capacity' => '4 Passengers + 1 Driver (Total 5)',
                    'capacity' => '4 Passengers + 1 Driver (Total 5)',
                    'toll_status' => 'Toll Tax Included',
                    'title' => 'Hyundai Verna (Deluxe - Executive Sedan)',
                    'route_name' => 'Dewa Sharif ↔ Lucknow City Sightseeing Tour',
                    'route' => 'Dewa Sharif ↔ Lucknow City Sightseeing Tour',
                    'pickup' => 'Dewa Sharif Dargah Gate',
                    'destination' => 'Lucknow City Sightseeing Tour',
                    'fare' => 2500,
                    'price' => 2500,
                    'driver_name' => 'Imran Ahmad',
                    'driver_phone' => '+91 9648777223',
                    'driver_aadhaar' => '6789 0123 4567',
                    'driver_dl' => 'UP32-2023-0099887',
                    'image' => asset('home/images/dewasharif/dewapage/cab_verna.jpg'),
                    'status' => 'Active'
                ],
                [
                    'id' => 5,
                    'vehicle_type' => 'Skoda Superb (Luxury Premium Sedan)',
                    'vehicle_name' => 'Skoda Superb',
                    'vehicle_number' => 'UP 32 SK 8899',
                    'ac_option' => 'AC',
                    'seating_capacity' => '4 Passengers + 1 Driver (Total 5)',
                    'capacity' => '4 Passengers + 1 Driver (Total 5)',
                    'toll_status' => 'Toll Tax Included',
                    'title' => 'Skoda Superb (Luxury Premium Sedan)',
                    'route_name' => 'Dewa Sharif to Anywhere (Outstation & Custom Route)',
                    'route' => 'Dewa Sharif to Anywhere (Outstation & Custom Route)',
                    'pickup' => 'Dewa Sharif Dargah Gate',
                    'destination' => 'Any Destination City / Outstation',
                    'fare' => 3500,
                    'price' => 3500,
                    'driver_name' => 'Tariq Mahmood',
                    'driver_phone' => '+91 9648777223',
                    'driver_aadhaar' => '8901 2345 6789',
                    'driver_dl' => 'UP32-2022-0055443',
                    'image' => asset('home/images/dewasharif/dewapage/cab_skoda.jpg'),
                    'status' => 'Active'
                ]
            ],

            'cab_vehicles' => [
                ['id' => 1, 'name' => 'Omni Van (Standard)', 'type' => 'Budget Microvan', 'capacity' => '7 Passengers + 1 Driver', 'price' => 770, 'status' => 'Active', 'fare_factor' => 0.55, 'image' => asset('home/images/dewasharif/dewapage/cab_omni.jpg')],
                ['id' => 2, 'name' => 'Dzire etc which is available (Semi Deluxe - Sedan)', 'type' => 'Compact Sedan', 'capacity' => '4 Passengers + 1 Driver', 'price' => 1400, 'status' => 'Active', 'fare_factor' => 1.0, 'image' => asset('home/images/dewasharif/dewapage/cab_dzire.jpg')],
                ['id' => 3, 'name' => 'Verna etc which is available (Deluxe - Sedan)', 'type' => 'Executive Sedan', 'capacity' => '4 Passengers + 1 Driver', 'price' => 1820, 'status' => 'Active', 'fare_factor' => 1.3, 'image' => asset('home/images/dewasharif/dewapage/cab_verna.jpg')],
                ['id' => 4, 'name' => 'Ertiga etc which is available (SUV)', 'type' => '7-Seater SUV', 'capacity' => '7 Passengers + 1 Driver', 'price' => 2030, 'status' => 'Active', 'fare_factor' => 1.45, 'image' => asset('home/images/dewasharif/dewapage/cab_ertiga.jpg')],
                ['id' => 5, 'name' => 'Mahindra Pickup (Goods & Dala)', 'type' => 'Commercial Goods Transport', 'capacity' => '1 Passengers + 1 Driver + Goods', 'price' => 1330, 'status' => 'Active', 'fare_factor' => 0.95, 'image' => asset('home/images/dewasharif/dewapage/cab_pickup.jpg')]
            ],

            'cab_locations' => [
                ['id' => 1, 'name' => 'Dewa Sharif', 'type' => 'both', 'status' => 'Active'],
                ['id' => 2, 'name' => 'Lucknow Airport', 'type' => 'both', 'status' => 'Active'],
                ['id' => 3, 'name' => 'Lucknow Railway Station', 'type' => 'both', 'status' => 'Active'],
                ['id' => 4, 'name' => 'Lucknow City Tour', 'type' => 'both', 'status' => 'Active'],
                ['id' => 5, 'name' => 'Barabanki Railway Station', 'type' => 'both', 'status' => 'Active'],
                ['id' => 6, 'name' => 'Barabanki Highway By-Pass', 'type' => 'both', 'status' => 'Active'],
                ['id' => 7, 'name' => 'Bahraich Sharif', 'type' => 'both', 'status' => 'Active'],
                ['id' => 8, 'name' => 'Bansa Sharif', 'type' => 'both', 'status' => 'Active']
            ],

            'erickshaw' => [
                'id' => 1,
                'service_name' => 'Local Dewa Shrine E-Rickshaw Sightseeing (Only Dewa Ghoomne Ke Liye)',
                'status' => 'Active',
                'per_person_fare' => 30,
                'full_rickshaw_fare' => 150,
                'contact_phone' => '+91 9648777223',
                'details' => 'Electric E-Rickshaw service for local shrine visits, Dargah Sharif tours, bazaar shopping & railway station connectivity.'
            ],

            'products' => [
                [
                    'id' => 1,
                    'name' => 'Original Rooh-e-Waris Khas Attar (12ml)',
                    'category' => 'attar',
                    'price' => 299,
                    'mrp' => 399,
                    'stock' => 85,
                    'image' => '/home/images/dewasharif/dewapage/attar_bottle.jpg',
                    'description' => '100% Non-Alcoholic traditional floral perfume distilled for Dargah Ziyarat.',
                    'status' => 'Active'
                ],
                [
                    'id' => 2,
                    'name' => 'Shahi Gulab Premium Attar (25ml)',
                    'category' => 'attar',
                    'price' => 499,
                    'mrp' => 650,
                    'stock' => 50,
                    'image' => '/home/images/dewasharif/dewapage/attar_bottle.jpg',
                    'description' => 'Natural Damask rose oil fragrance for home, clothes & dargah offering.',
                    'status' => 'Active'
                ],
                [
                    'id' => 3,
                    'name' => 'Handcrafted Sufi White Kurta Pyjama Set',
                    'category' => 'clothing',
                    'price' => 899,
                    'mrp' => 1200,
                    'stock' => 40,
                    'image' => '/home/images/dewasharif/dewapage/sufi_clothing.jpg',
                    'description' => '100% Pure fine breathable cotton set crafted for prayer & daily comfort.',
                    'status' => 'Active'
                ],
                [
                    'id' => 4,
                    'name' => 'Zari Embroidered Velvet Sufi Cap (Topi)',
                    'category' => 'clothing',
                    'price' => 199,
                    'mrp' => 299,
                    'stock' => 60,
                    'image' => '/home/images/dewasharif/dewapage/sufi_clothing.jpg',
                    'description' => 'Velvet handcrafted prayer cap with golden zari needlework.',
                    'status' => 'Active'
                ],
                [
                    'id' => 5,
                    'name' => 'Dewa Mela Handcrafted Clay Surahi (Water Pot)',
                    'category' => 'clay',
                    'price' => 349,
                    'mrp' => 499,
                    'stock' => 65,
                    'image' => '/home/images/dewasharif/dewapage/clay_pots.jpg',
                    'description' => 'Authentic terracotta surahi for naturally cold & alkaline drinking water.',
                    'status' => 'Active'
                ],
                [
                    'id' => 6,
                    'name' => 'Traditional Earthen Cooking Handi Set (3 Pcs)',
                    'category' => 'clay',
                    'price' => 599,
                    'mrp' => 799,
                    'stock' => 30,
                    'image' => '/home/images/dewasharif/dewapage/clay_pots.jpg',
                    'description' => 'Natural clay cooking pots for aromatic slow-cooked food & biryani.',
                    'status' => 'Active'
                ],
                [
                    'id' => 7,
                    'name' => 'Handmade Wooden Rickshaw & Cart Toy',
                    'category' => 'toys',
                    'price' => 249,
                    'mrp' => 350,
                    'stock' => 45,
                    'image' => '/home/images/dewasharif/dewapage/mela_toys.jpg',
                    'description' => 'Vibrant painted eco-friendly wooden toy handcrafted by local Dewa artisans.',
                    'status' => 'Active'
                ],
                [
                    'id' => 8,
                    'name' => 'Royal Emerald Green Velvet Zari Chadar',
                    'category' => 'islamic',
                    'price' => 1299,
                    'mrp' => 1699,
                    'stock' => 20,
                    'image' => '/home/images/dewasharif/dewapage/velvet_chadar.jpg',
                    'description' => 'Rich velvet cloth with heavy golden zari embroidery for sacred offering.',
                    'status' => 'Active'
                ],
                [
                    'id' => 9,
                    'name' => 'Warsi Mutton Biryani (Ultra Premium)',
                    'category' => 'degh',
                    'price' => 13707,
                    'mrp' => 15500,
                    'stock' => 30,
                    'volume_ml' => '10 kg Mutton + 10 kg Rice',
                    'ingredients' => 'Fresh Mutton Best Quality / Rice Ultra Premium Quality (10 kg + 10 kg)',
                    'packaging' => 'With Parcel Packing Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_mutton_biryani.jpg',
                    'description' => 'Fresh Mutton Best Quality / Rice Ultra Premium Quality (10 kg + 10 kg) — with Parcel Packing Ready.',
                    'rating' => 5.0,
                    'reviews_count' => '240+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 10,
                    'name' => 'Warsi Mutton Biryani (Premium)',
                    'category' => 'degh',
                    'price' => 12707,
                    'mrp' => 14500,
                    'stock' => 30,
                    'volume_ml' => '10 kg Mutton + 10 kg Rice',
                    'ingredients' => 'Fresh Mutton Best Quality / Rice Premium Quality (10 kg + 10 kg)',
                    'packaging' => 'With Parcel Packing Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_mutton_biryani.jpg',
                    'description' => 'Fresh Mutton Best Quality / Rice Premium Quality (10 kg + 10 kg) — with Parcel Packing Ready.',
                    'rating' => 4.9,
                    'reviews_count' => '195+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 11,
                    'name' => 'Warsi Chicken Biryani (Ultra Premium)',
                    'category' => 'degh',
                    'price' => 7707,
                    'mrp' => 9000,
                    'stock' => 35,
                    'volume_ml' => '10 kg Chicken + 10 kg Rice',
                    'ingredients' => 'Fresh Chicken Best Quality / Rice Ultra Premium Quality (10 kg Chicken + 10 kg Rice)',
                    'packaging' => 'With Parcel Distribution Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_chicken_biryani.jpg',
                    'description' => 'Fresh Chicken Best Quality / Rice Ultra Premium Quality (10 kg Chicken + 10 kg Rice) — with Parcel Distribution Ready.',
                    'rating' => 4.9,
                    'reviews_count' => '180+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 12,
                    'name' => 'Warsi Chicken Biryani (Premium)',
                    'category' => 'degh',
                    'price' => 6707,
                    'mrp' => 8000,
                    'stock' => 35,
                    'volume_ml' => '10 kg Chicken + 10 kg Rice',
                    'ingredients' => 'Fresh Chicken Best Quality / Rice Premium Quality (10 kg Chicken + 10 kg Rice)',
                    'packaging' => 'With Parcel Distribution Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_chicken_biryani.jpg',
                    'description' => 'Fresh Chicken Best Quality / Rice Premium Quality (10 kg Chicken + 10 kg Rice) — with Parcel Distribution Ready.',
                    'rating' => 4.8,
                    'reviews_count' => '160+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 13,
                    'name' => 'Warsi Chicken Biryani (Light Premium)',
                    'category' => 'degh',
                    'price' => 5707,
                    'mrp' => 7000,
                    'stock' => 35,
                    'volume_ml' => '10 kg Chicken + 10 kg Rice',
                    'ingredients' => 'Fresh Chicken Best Quality / Rice Light Premium Quality (10 kg Chicken + 10 kg Rice)',
                    'packaging' => 'With Parcel Distribution Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_chicken_biryani.jpg',
                    'description' => 'Fresh Chicken Best Quality / Rice Light Premium Quality (10 kg Chicken + 10 kg Rice) — with Parcel Distribution Ready.',
                    'rating' => 4.8,
                    'reviews_count' => '110+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 14,
                    'name' => 'Warsi Zarda Premium Kesari',
                    'category' => 'degh',
                    'price' => 7707,
                    'mrp' => 9000,
                    'stock' => 25,
                    'volume_ml' => '10 kg Rice + Khoya + Dry Fruit',
                    'ingredients' => 'Rice Ultra Premium Quality (10 kg Rice + Khoya + Dry Fruit)',
                    'packaging' => 'With Parcel Distribution Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_zarda_kesari.jpg',
                    'description' => 'Rice Ultra Premium Quality (10 kg Rice + Khoya + Dry Fruit) — with Parcel Distribution Ready.',
                    'rating' => 4.9,
                    'reviews_count' => '145+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 15,
                    'name' => 'Warsi Zarda Premium Yellow',
                    'category' => 'degh',
                    'price' => 7707,
                    'mrp' => 9000,
                    'stock' => 25,
                    'volume_ml' => '10 kg Rice + Khoya + Dry Fruit',
                    'ingredients' => 'Rice Ultra Premium Quality (10 kg Rice + Khoya + Dry Fruit)',
                    'packaging' => 'With Parcel Distribution Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_zarda_yellow.jpg',
                    'description' => 'Rice Ultra Premium Quality (10 kg Rice + Khoya + Dry Fruit) — with Parcel Distribution Ready.',
                    'rating' => 4.8,
                    'reviews_count' => '130+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 16,
                    'name' => 'Warsi Zafraani Kheer (10 Ltr)',
                    'category' => 'degh',
                    'price' => 6707,
                    'mrp' => 8000,
                    'stock' => 25,
                    'volume_ml' => '10 Litre Ultra Premium',
                    'ingredients' => 'Fresh Zafraani Kheer / Ultra Premium Quality (10 Ltr) (With Khoya + Dry Fruit + Saffron)',
                    'packaging' => 'With Parcel Distribution Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_zafraani_kheer.jpg',
                    'description' => 'Fresh Zafraani Kheer / Ultra Premium Quality (10 Ltr) (With Khoya + Dry Fruit + Saffron) — with Parcel Distribution Ready.',
                    'rating' => 5.0,
                    'reviews_count' => '125+ Niyaz Bookings',
                    'status' => 'Active'
                ],
                [
                    'id' => 17,
                    'name' => 'Warsi Zafraani Kheer (6 Ltr)',
                    'category' => 'degh',
                    'price' => 4707,
                    'mrp' => 5800,
                    'stock' => 25,
                    'volume_ml' => '6 Litre Premium',
                    'ingredients' => 'Fresh Zafraani Kheer / Premium Quality (6 Ltr) (With Khoya + Dry Fruit + Saffron)',
                    'packaging' => 'With Parcel Distribution Ready',
                    'image' => '/home/images/dewasharif/dewapage/degh_zafraani_kheer.jpg',
                    'description' => 'Fresh Zafraani Kheer / Premium Quality (6 Ltr) (With Khoya + Dry Fruit + Saffron) — with Parcel Distribution Ready.',
                    'status' => 'Active'
                ]
            ],

            'hotel_bookings' => [
                [
                    'id' => 101,
                    'booking_code' => 'DWS-HTL-2026-0001',
                    'customer_name' => 'Mohd Amir Khan',
                    'customer_phone' => '+91 9876543210',
                    'city' => 'Lucknow',
                    'hotel_name' => 'Al-Waris Deluxe Guest House',
                    'room_type' => 'Deluxe AC Room',
                    'checkin' => '27 Oct 2026',
                    'checkout' => '29 Oct 2026',
                    'nights' => 2,
                    'guests' => '2 Adults',
                    'total_amount' => 2998,
                    'payment_type' => 'Paid Online',
                    'status' => 'Pending Approval'
                ],
                [
                    'id' => 102,
                    'booking_code' => 'DWS-HTL-2026-0002',
                    'customer_name' => 'Syed Rashid Warsi',
                    'customer_phone' => '+91 9123456789',
                    'city' => 'Mumbai',
                    'hotel_name' => 'Warsi Shahi Family Hall & Lodge',
                    'room_type' => 'Family Hall (6 Beds)',
                    'checkin' => '28 Oct 2026',
                    'checkout' => '30 Oct 2026',
                    'nights' => 2,
                    'guests' => '6 Members',
                    'total_amount' => 4998,
                    'payment_type' => 'Paid Online',
                    'status' => 'Confirmed'
                ]
            ],

            'cab_bookings' => [
                [
                    'id' => 1792309934728,
                    'user_id' => 4,
                    'booking_code' => 'DWS-CAB-2026-4115',
                    'customer_name' => 'IMRAN AHMED PESHIMAM',
                    'customer_phone' => '7899422676',
                    'customer_email' => 'imran.peshimam@dewasharif.com',
                    'alternate_phone' => '',
                    'route' => 'Lucknow Railway Station → Dewa Sharif',
                    'pickup' => 'Lucknow Railway Station',
                    'destination' => 'Dewa Sharif',
                    'vehicle_type' => 'Omni Van (Standard) (×2 Cabs)',
                    'vehicle_count' => 2,
                    'pickup_time' => '2026-10-20 @ 08:30 PM',
                    'fare' => 3800,
                    'total_fare' => 3800,
                    'paid_amount' => 3800,
                    'pending_amount' => 0,
                    'payment_status' => 'paid',
                    'night_surcharge' => 0,
                    'id_type' => 'Aadhaar Card',
                    'id_no' => '8208 2148 6063',
                    'payment_id' => 'PAY-CONFIRMED-4115',
                    'utr_number' => 'UTR820821486063',
                    'payment_mode' => 'Online',
                    'payment_gateway' => 'Direct',
                    'driver' => 'Assigned',
                    'driver_name' => 'Dewa Sharif Verified Driver',
                    'driver_phone' => '9648777223',
                    'driver_vehicle_number' => 'UP-32-AB-1234',
                    'status' => 'Active & Confirmed',
                    'booking_status' => 'confirmed',
                    'created_at' => '2026-10-18 07:52:14'
                ],
                [
                    'id' => 201,
                    'booking_code' => 'DWS-CAB-2026-0001',
                    'customer_name' => 'Tariq Ansari',
                    'customer_phone' => '+91 9988776655',
                    'route' => 'Lucknow Charbagh Station → Dewa Sharif',
                    'vehicle_type' => 'Swift Dzire (Sedan)',
                    'pickup_time' => '27 Oct 2026 @ 08:30 AM',
                    'fare' => 1400,
                    'driver' => 'Ramesh Kumar (Dzire UP32 AB 1234)',
                    'status' => 'Dispatched'
                ]
            ],

            'shop_orders' => [
                [
                    'id' => 301,
                    'order_code' => 'DWS-ORD-2026-0001',
                    'customer_name' => 'Salman Siddiqui',
                    'customer_phone' => '+91 9839012345',
                    'city' => 'Barabanki',
                    'items_summary' => '• Rooh-e-Waris Khas Attar (Qty: 2) | • Sufi White Kurta Set (Qty: 1)',
                    'payment_method' => 'Razorpay Online',
                    'total_amount' => 1497,
                    'courier' => 'DTDC Express',
                    'tracking' => 'DT78459203IN',
                    'status' => 'Dispatched'
                ]
            ],

            'coupons' => [
                [
                    'id' => 1,
                    'code' => 'DEWA10',
                    'type' => 'Percentage',
                    'value' => 10,
                    'description' => '10% Discount on Sacred Shop Orders',
                    'status' => 'Active'
                ],
                [
                    'id' => 2,
                    'code' => 'WARSI20',
                    'type' => 'Percentage',
                    'value' => 20,
                    'description' => '20% Off on Attar & Sufi Clothing',
                    'status' => 'Active'
                ],
                [
                    'id' => 3,
                    'code' => 'MELA2026',
                    'type' => 'Flat',
                    'value' => 500,
                    'description' => 'Flat ₹500 Off on Hotel Stays Above ₹3,000',
                    'status' => 'Active'
                ]
            ],

            'tickets' => [
                [
                    'id' => 1,
                    'ticket_no' => 'TCK-901',
                    'customer_name' => 'Syed Rashid Warsi',
                    'customer_phone' => '+91 9123456789',
                    'subject' => 'Dargah Ziyarat & Sama Khana Timings Query',
                    'priority' => 'High',
                    'status' => 'Resolved'
                ],
                [
                    'id' => 2,
                    'ticket_no' => 'TCK-902',
                    'customer_name' => 'Mohd Kabir',
                    'customer_phone' => '+91 9415098765',
                    'subject' => 'Dewa Mela Cab Drop Point near Dargah Gate 1',
                    'priority' => 'Medium',
                    'status' => 'In Progress'
                ]
            ],

            'reviews' => [
                [
                    'id' => 1,
                    'item_type' => 'Hotel',
                    'item_name' => 'Al-Waris Deluxe Guest House',
                    'reviewer' => 'Mohd Amir Khan',
                    'rating' => 5,
                    'comment' => 'SubhanAllah! Very clean room and just 2 minutes walk from Dargah Sharif.',
                    'status' => 'Approved'
                ],
                [
                    'id' => 2,
                    'item_type' => 'Attar',
                    'item_name' => 'Original Rooh-e-Waris Khas Attar (12ml)',
                    'reviewer' => 'Syed Hassan',
                    'rating' => 5,
                    'comment' => 'Pure non-alcoholic fragrance, aroma stays for more than 24 hours!',
                    'status' => 'Approved'
                ]
            ],

            'customer_profile' => [
                'id' => 1,
                'name' => 'Masharrat Warsi',
                'phone' => '+91 7398072236',
                'email' => 'shahzade.alam707@gmail.com',
                'city' => 'Barabanki, Uttar Pradesh',
                'address' => 'House No 6 , Mohalla Kachehran 2, Dewa Sharif, Barabanki, UP - 225301'
            ],

            'settings' => [
                'sbi_acc_name' => 'Dewa Sharif Dargah Pilgrimage Services Trust',
                'sbi_acc_no' => '389472910482',
                'sbi_ifsc' => 'SBIN0001234',
                'sbi_branch' => 'Dewa Sharif Branch, Barabanki',
                'razorpay_key' => 'rzp_test_DewaSharifStore',
                'whatsapp_number' => '+919648777223',
                'mela_banner' => '🎉 Dewa Mela 2026 Dates: 27th Oct – 5th Nov | Book Stays, Cabs & Sacred Items',
                'commission_rate' => 25
            ]
        ];
    }
}
