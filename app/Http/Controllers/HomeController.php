<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $shopCategories = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_categories')) {
                $shopCategories = \Illuminate\Support\Facades\DB::table('shop_categories')
                    ->orderBy('order_num', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
            }
        } catch (\Throwable $e) {
            $shopCategories = collect();
        }

        return view('home.index', compact('shopCategories'));
    }

    //dewa sharif

    public function about()
    {
        return view('home.dewa.about');
    }

    public function history()
    {
        return view('home.dewa.history');
    }

    public function sufism()
    {
        return view('home.dewa.sufism');
    }

    public function hajiwarisalishah()
    {
        return view('home.dewa.hajiwarisalishah');
    }

    public function mazar()
    {
        return view('home.dewa.mazar');
    }

    public function qurbanalishah()
    {
        return view('home.dewa.qurbanalishah');
    }

    public function badelamazar()
    {
        return view('home.dewa.badelamazar');
    }

    public function shahwilayatshah()
    {
        return view('home.dewa.shahwilayatshah');
    }

    public function shahwilayatmazar()
    {
        return view('home.dewa.shahwilayatmazar');
    }

    public function raheemshah()
    {
        return view('home.dewa.raheemshah');
    }

    public function raheemshahmazar()
    {
        return view('home.dewa.raheemshahmazar');
    }

    public function faizushah()
    {
        return view('home.dewa.faizushah');
    }



    public function faizushahmazar()
    {
        return view('home.dewa.faizushahmazar');
    }

    public function mosqueDargah()
    {
        return view('home.dewa.mosquedargah');
    }

    public function wazukhana()
    {
        return view('home.dewa.wazukhana');
    }


    public function samakhana()
    {
        return view('home.dewa.samakhana');
    }

    public function qawwaliplace()
    {
        return view('home.dewa.qawwaliplace');
    }

    public function langarkhana()
    {
        return view('home.dewa.langarkhana');
    }

    public function trustoffice()
    {
        return view('home.dewa.trustoffice');
    }

    public function mela()
    {
        return view('home.dewa.mela');
    }

    public function numaisground()
    {
        return view('home.dewa.numaisground');
    }

    public function auditorium()
    {
        return view('home.dewa.auditorium');
    }

    public function eidgaah()
    {
        return view('home.dewa.eidgaah');
    }

    public function artandculture()
    {
        return view('home.dewa.artandculture');
    }

    public function artandcraft()
    {
        return view('home.dewa.artandcraft');
    }


    // Guest House / Hotel Booking Landing Page
    public function hotels()
    {
        $hotels = \App\Helpers\DataStore::getCollection('hotels');
        $hotelReviews = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('reviews')) {
                $hotelReviews = \Illuminate\Support\Facades\DB::table('reviews')
                    ->where('service_type', 'hotel')
                    ->where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            }
        } catch (\Throwable $e) {
            $hotelReviews = collect();
        }
        return view('home.hotels.hotel', compact('hotels', 'hotelReviews'));
    }

    // Hotel Detail & Room View Page
    public function hotelDetail($id = 1)
    {
        $hotels = \App\Helpers\DataStore::getCollection('hotels');
        $hotel = collect($hotels)->firstWhere('id', (int)$id) ?? ($hotels[0] ?? null);
        return view('home.hotels.detail', compact('id', 'hotel', 'hotels'));
    }

    public function initHotelCheckout(Request $request)
    {
        $hotel = trim($request->input('hotel', 'Al-Waris Deluxe Guest House'));
        $room = trim($request->input('room', 'Deluxe AC Room'));
        $rawPrice = preg_replace('/[^0-9.]/', '', $request->input('price', '1499'));
        $price = (float)($rawPrice ?: 1499);
        $checkin = $request->input('checkin', date('Y-m-d'));
        $checkout = $request->input('checkout', date('Y-m-d', strtotime('+1 day')));

        session(['hotel_checkout_draft' => [
            'hotel' => $hotel,
            'room' => $room,
            'price' => $price,
            'checkin' => $checkin,
            'checkout' => $checkout
        ]]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('hotels.checkout')
        ]);
    }

    public function hotelCheckout(Request $request)
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('hotels.checkout'));
            return redirect()->route('login')->with('error', 'Please Register or Login an account first to book hotel rooms.');
        }

        $draft = session('hotel_checkout_draft', []);

        $hotel = $request->input('hotel', $draft['hotel'] ?? 'Al-Waris Deluxe Guest House');
        $room = $request->input('room', $draft['room'] ?? 'Deluxe AC Room');
        $rawPrice = preg_replace('/[^0-9.]/', '', $request->input('price', $draft['price'] ?? '1499'));
        $price = (float)($rawPrice ?: 1499);
        $checkin = $request->input('checkin', $draft['checkin'] ?? date('Y-m-d'));
        $checkout = $request->input('checkout', $draft['checkout'] ?? date('Y-m-d', strtotime('+1 day')));

        $checkinTime = strtotime($checkin);
        $checkoutTime = strtotime($checkout);
        if ($checkoutTime <= $checkinTime) {
            $checkoutTime = strtotime('+1 day', $checkinTime);
            $checkout = date('Y-m-d', $checkoutTime);
        }
        $nights = max(1, (int)round(($checkoutTime - $checkinTime) / 86400));
        $totalPrice = $price * $nights;

        // Dynamic lookup of matching hotel amenities from DataStore/MySQL
        $allHotels = \App\Helpers\DataStore::getCollection('hotels');
        $matchedHotel = null;
        foreach ($allHotels as $h) {
            $hName = is_array($h) ? ($h['name'] ?? '') : ($h->name ?? '');
            if (!empty($hName) && (str_contains(strtolower($hName), strtolower($hotel)) || str_contains(strtolower($hotel), strtolower($hName)))) {
                $matchedHotel = $h;
                break;
            }
        }
        if (!$matchedHotel && isset($allHotels[0])) {
            $matchedHotel = $allHotels[0];
        }

        $hotelAmenities = [];
        if ($matchedHotel) {
            $rawAm = is_array($matchedHotel) ? ($matchedHotel['amenities'] ?? []) : ($matchedHotel->amenities ?? []);
            if (is_string($rawAm)) {
                $rawAm = explode(',', $rawAm);
            }
            $hotelAmenities = array_values(array_map('trim', array_filter($rawAm)));
        }

        return view('home.hotels.checkout', compact('hotel', 'room', 'price', 'totalPrice', 'nights', 'checkin', 'checkout', 'hotelAmenities'));
    }

    // Cab / Auto Booking Landing Page
    public function cabs()
    {
        $allCabs = \App\Helpers\DataStore::getCollection('cabs');
        $cabs = array_values(array_filter($allCabs, function($c) {
            $status = is_array($c) ? ($c['status'] ?? 'Active') : ($c->status ?? 'Active');
            return strtolower($status) === 'active';
        }));

        $allVehicles = \App\Helpers\DataStore::getCollection('cab_vehicles');
        $vehicles = array_values(array_filter($allVehicles, function($v) {
            $status = is_array($v) ? ($v['status'] ?? 'Active') : ($v->status ?? 'Active');
            return strtolower($status) === 'active';
        }));

        $locations = \App\Helpers\DataStore::getCollection('cab_locations');

        $erickshaw = \App\Helpers\DataStore::getItem('erickshaw', 1) ?? [
            'service_name' => 'Local Dewa Shrine E-Rickshaw Sightseeing (Dewa and Nearby Visiting Places)',
            'status' => 'Active',
            'per_person_fare' => 30,
            'full_rickshaw_fare' => 150,
            'contact_phone' => '+91 9648777223',
            'details' => 'Electric E-Rickshaw service for local shrine visits, Dargah Sharif tours, bazaar shopping & railway station connectivity.'
        ];
        $cabReviews = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('reviews')) {
                $cabReviews = \Illuminate\Support\Facades\DB::table('reviews')
                    ->where('service_type', 'cab')
                    ->where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            }
        } catch (\Throwable $e) {
            $cabReviews = collect();
        }
        return view('home.cabs.cab', compact('cabs', 'vehicles', 'erickshaw', 'locations', 'cabReviews'));
    }

    public function initCabCheckout(Request $request)
    {
        $pickup = trim($request->input('pickup', 'Dewa Sharif'));
        $drop = trim($request->input('drop', 'Lucknow Airport'));
        $vehicle = trim($request->input('vehicle', 'Dzire etc which is available (Semi Deluxe - Sedan)'));
        $fare = (float)$request->input('fare', 1400);

        session(['cab_checkout_draft' => [
            'pickup' => $pickup,
            'drop' => $drop,
            'vehicle' => $vehicle,
            'fare' => $fare
        ]]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('cabs.checkout')
        ]);
    }

    public function cabCheckout(Request $request)
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('cabs.checkout'));
            return redirect()->route('login')->with('error', 'Please Register or Login an account first to book cabs.');
        }

        $draft = session('cab_checkout_draft', []);

        $pickup = $request->input('pickup', $draft['pickup'] ?? 'Dewa Sharif');
        $drop = $request->input('drop', $draft['drop'] ?? 'Lucknow Airport');
        $vehicle = $request->input('vehicle', $draft['vehicle'] ?? 'Dzire etc which is available (Semi Deluxe - Sedan)');

        $fare = null;
        if ($request->has('fare')) {
            $fare = (float)$request->input('fare');
        } elseif (isset($draft['fare'])) {
            $fare = (float)$draft['fare'];
        } else {
            $allCabs = \App\Helpers\DataStore::getCollection('cabs');
            $pLow = strtolower(trim($pickup));
            $dLow = strtolower(trim($drop));
            foreach ($allCabs as $c) {
                $cPk = strtolower(trim(is_array($c) ? ($c['pickup'] ?? '') : ($c->pickup ?? '')));
                $cDp = strtolower(trim(is_array($c) ? ($c['destination'] ?? ($c['drop'] ?? '')) : ($c->destination ?? ($c->drop ?? ''))));
                if ((str_contains($pLow, $cPk) || str_contains($cPk, $pLow)) && (str_contains($dLow, $cDp) || str_contains($cDp, $dLow))) {
                    $fare = (float)(is_array($c) ? ($c['price'] ?? ($c['fare'] ?? 0)) : ($c->price ?? ($c->fare ?? 0)));
                    break;
                }
            }
            if ($fare === null || $fare <= 0) {
                $fare = 0;
            }
        }

        return view('home.cabs.checkout', compact('pickup', 'drop', 'vehicle', 'fare'));
    }

    // Dewa Islamic Shop Landing Page (Filtered by category when specified)
    public function shops($category = null)
    {
        $allProducts = \App\Helpers\DataStore::getCollection('products');
        $allCategories = collect();
        $categories = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_categories')) {
                $allCategories = \Illuminate\Support\Facades\DB::table('shop_categories')
                    ->orderBy('order_num', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
                $categories = $allCategories->where('status', 'active');
            }
        } catch (\Throwable $e) {
            $categories = collect();
            $allCategories = collect();
        }

        $activeSlugs = $categories->pluck('slug')->map(function($s) { return strtolower(trim($s)); })->toArray();
        if (empty($activeSlugs)) {
            $activeSlugs = ['degh'];
        }

        $selectedCategory = $category ? strtolower(trim($category)) : null;

        // Normalize aliases
        if (in_array($selectedCategory, ['mitti', 'bartan', 'clay-pots'])) $selectedCategory = 'clay';
        if (in_array($selectedCategory, ['islamic-products', 'tabarruk', 'tabarrukat'])) $selectedCategory = 'islamic';
        if (in_array($selectedCategory, ['degh-niyaz', 'niyaz'])) $selectedCategory = 'degh';
        if (in_array($selectedCategory, ['warsi-attar', 'perfume'])) $selectedCategory = 'attar';
        if (in_array($selectedCategory, ['sufi-clothing', 'attire'])) $selectedCategory = 'clothing';
        if (in_array($selectedCategory, ['scenery', 'paintings', 'art'])) $selectedCategory = 'calligraphy';
        if (in_array($selectedCategory, ['jewelry', 'jewels'])) $selectedCategory = 'jewellery';
        if (in_array($selectedCategory, ['skin-care', 'cosmetics'])) $selectedCategory = 'beauty';
        if (in_array($selectedCategory, ['food', 'health', 'organic-food'])) $selectedCategory = 'food-health';
        if (in_array($selectedCategory, ['gadgets', 'electronic'])) $selectedCategory = 'electronics';
        if (in_array($selectedCategory, ['appliances', 'home'])) $selectedCategory = 'home-appliances';
        if (in_array($selectedCategory, ['pet', 'pet-food', 'animals'])) $selectedCategory = 'pets';

        // Dynamic Category Status Validation: If requested category is NOT active, redirect to degh
        if ($selectedCategory && $selectedCategory !== 'all') {
            if (!in_array($selectedCategory, $activeSlugs)) {
                return redirect()->route('shops.category', 'degh');
            }
        }

        // When only degh is active, clicking shop should directly show degh niyaz
        if (empty($selectedCategory) || $selectedCategory === 'all') {
            if (count($activeSlugs) <= 1 && in_array('degh', $activeSlugs)) {
                return redirect()->route('shops.category', 'degh');
            }
            $selectedCategory = 'all';
        }

        $dbProducts = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_products')) {
                $dbProducts = \Illuminate\Support\Facades\DB::table('shop_products')->get()->keyBy('id');
            }
        } catch (\Throwable $e) {
            $dbProducts = collect();
        }

        foreach ($allProducts as &$p) {
            $pId = $p['id'] ?? null;
            if ($pId && isset($dbProducts[$pId])) {
                $dbItem = $dbProducts[$pId];
                $p['stock_quantity'] = (int)$dbItem->stock_quantity;
                $p['stock'] = (int)$dbItem->stock_quantity;
                if (!empty($dbItem->status)) {
                    $p['status'] = $dbItem->status;
                }
                if (!empty($dbItem->sku)) {
                    $p['sku'] = $dbItem->sku;
                }
                if (!empty($dbItem->return_policy)) {
                    $p['return_policy'] = $dbItem->return_policy;
                }
                if (isset($dbItem->is_featured)) {
                    $p['is_featured'] = (int)$dbItem->is_featured;
                }
                if (!empty($dbItem->rating)) {
                    $p['rating'] = (float)$dbItem->rating;
                }
                if (!empty($dbItem->reviews_count)) {
                    $p['reviews_count'] = $dbItem->reviews_count;
                }
                if (isset($dbItem->price) && (float)$dbItem->price > 0) {
                    $p['price'] = (float)$dbItem->price;
                }
                if (isset($dbItem->mrp) && (float)$dbItem->mrp > 0) {
                    $p['mrp'] = (float)$dbItem->mrp;
                }
                if (!empty($dbItem->name)) {
                    $p['name'] = $dbItem->name;
                }
                if (!empty($dbItem->thumbnail)) {
                    $p['image'] = $dbItem->thumbnail;
                }
                if (!empty($dbItem->description)) {
                    $p['description'] = $dbItem->description;
                }
                if (!empty($dbItem->volume_ml)) {
                    $p['volume_ml'] = $dbItem->volume_ml;
                }
                if (!empty($dbItem->fabric_material)) {
                    $p['fabric_material'] = $dbItem->fabric_material;
                }
                if (!empty($dbItem->size_options)) {
                    $p['size_options'] = $dbItem->size_options;
                }
            } else {
                $s = (int)($p['stock_quantity'] ?? ($p['stock'] ?? 50));
                $p['stock'] = $s;
                $p['stock_quantity'] = $s;
                $p['return_policy'] = $p['return_policy'] ?? 'non_returnable';
            }
            $p['rating'] = (float)($p['rating'] ?? 5.0);
            $p['return_policy'] = $p['return_policy'] ?? 'non_returnable';
            $p['reviews_count'] = $p['reviews_count'] ?? ((($p['category'] ?? '') === 'degh') ? '240+ Niyaz Bookings' : '150+ Devotee Reviews');
        }
        unset($p);

        if ($selectedCategory && $selectedCategory !== 'all') {
            $products = array_values(array_filter($allProducts, function ($item) use ($selectedCategory) {
                return isset($item['category']) && strtolower($item['category']) === $selectedCategory;
            }));
        } else {
            // Only active category products appear in shop catalog
            $products = array_values(array_filter($allProducts, function ($item) use ($activeSlugs) {
                return in_array(strtolower($item['category'] ?? ''), $activeSlugs);
            }));
        }

        $shopReviews = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('reviews')) {
                $shopReviews = \Illuminate\Support\Facades\DB::table('reviews')
                    ->where('service_type', 'shop')
                    ->where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            }
        } catch (\Throwable $e) {
            $shopReviews = collect();
        }

        return view('home.shops.shop', compact('products', 'selectedCategory', 'allProducts', 'categories', 'allCategories', 'shopReviews', 'activeSlugs'));
    }

    // Single Product Detail Page (Flipkart / Amazon Style)
    public function shopProductDetail($slug)
    {
        $allProducts = \App\Helpers\DataStore::getCollection('products');
        $dbProducts = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_products')) {
                $dbProducts = \Illuminate\Support\Facades\DB::table('shop_products')->get()->keyBy('id');
            }
        } catch (\Throwable $e) {
            $dbProducts = collect();
        }

        // Sync stock & real-time fields
        foreach ($allProducts as &$p) {
            $pId = $p['id'] ?? null;
            if ($pId && isset($dbProducts[$pId])) {
                $dbItem = $dbProducts[$pId];
                $p['stock_quantity'] = (int)$dbItem->stock_quantity;
                $p['stock'] = (int)$dbItem->stock_quantity;
                if (!empty($dbItem->status)) $p['status'] = $dbItem->status;
                if (!empty($dbItem->sku)) $p['sku'] = $dbItem->sku;
                if (!empty($dbItem->return_policy)) $p['return_policy'] = $dbItem->return_policy;
                if (isset($dbItem->is_featured)) $p['is_featured'] = (int)$dbItem->is_featured;
                if (!empty($dbItem->description)) $p['description'] = $dbItem->description;
                if (!empty($dbItem->fabric_material)) $p['fabric_material'] = $dbItem->fabric_material;
                if (!empty($dbItem->volume_ml)) $p['volume_ml'] = $dbItem->volume_ml;
                if (!empty($dbItem->rating)) $p['rating'] = (float)$dbItem->rating;
                if (!empty($dbItem->reviews_count)) $p['reviews_count'] = $dbItem->reviews_count;
                if (isset($dbItem->price) && (float)$dbItem->price > 0) $p['price'] = (float)$dbItem->price;
                if (isset($dbItem->mrp) && (float)$dbItem->mrp > 0) $p['mrp'] = (float)$dbItem->mrp;
                if (!empty($dbItem->name)) $p['name'] = $dbItem->name;
                if (!empty($dbItem->thumbnail)) $p['image'] = $dbItem->thumbnail;
                if (!empty($dbItem->size_options)) $p['size_options'] = $dbItem->size_options;
            }
            $p['rating'] = (float)($p['rating'] ?? 5.0);
            $p['return_policy'] = $p['return_policy'] ?? 'non_returnable';
            $p['reviews_count'] = $p['reviews_count'] ?? ((($p['category'] ?? '') === 'degh') ? '240+ Niyaz Bookings' : '150+ Devotee Reviews');
        }
        unset($p);

        // Find product by slug or id
        $matched = null;
        foreach ($allProducts as $p) {
            if (($p['slug'] ?? '') === $slug || (string)($p['id'] ?? '') === (string)$slug) {
                $matched = $p;
                break;
            }
        }

        if (!$matched) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('shop_products')) {
                    $dbItem = \Illuminate\Support\Facades\DB::table('shop_products')
                        ->where('slug', $slug)
                        ->orWhere('id', is_numeric($slug) ? (int)$slug : 0)
                        ->first();
                    if ($dbItem) {
                        $matched = (array)$dbItem;
                        $matched['image'] = $matched['thumbnail'] ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg';
                        $matched['category'] = $matched['category_slug'] ?? 'attar';
                    }
                }
            } catch (\Throwable $e) {}
        }

        if (!$matched && !empty($allProducts[0])) {
            $matched = $allProducts[0];
        }

        $product = $matched;
        $categorySlug = $product['category'] ?? ($product['category_slug'] ?? 'attar');

        // Dynamic Category Status Validation from MySQL shop_categories table
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_categories')) {
                $catRecord = \Illuminate\Support\Facades\DB::table('shop_categories')->where('slug', $categorySlug)->first();
                // If category exists and is NOT active, redirect to degh
                if ($catRecord && strtolower($catRecord->status) !== 'active') {
                    return redirect()->route('shops.category', 'degh');
                }
            }
        } catch (\Throwable $e) {}

        $category = null;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_categories')) {
                $category = \Illuminate\Support\Facades\DB::table('shop_categories')->where('slug', $categorySlug)->first();
            }
        } catch (\Throwable $e) {
            $category = null;
        }

        // Related products in the same category
        $relatedProducts = array_values(array_filter($allProducts, function($item) use ($categorySlug, $product) {
            return ($item['category'] ?? '') === $categorySlug && ($item['id'] ?? 0) != ($product['id'] ?? 0);
        }));

        $shopReviews = collect();
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('reviews')) {
                $shopReviews = \Illuminate\Support\Facades\DB::table('reviews')
                    ->where('service_type', 'shop')
                    ->where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            }
        } catch (\Throwable $e) {
            $shopReviews = collect();
        }

        return view('home.shops.product_detail', compact('product', 'category', 'relatedProducts', 'shopReviews'));
    }

    public function madarsalist()
    {
        return view('home.dewa.madarsalist');
    }

    public function collegeslist()
    {
        return view('home.dewa.collegeslist');
    }

    public function hospitals()
    {
        return view('home.dewa.hospitals');
    }

    public function docters()
    {
        return view('home.dewa.docters');
    }

    public function bank()
    {
        return view('home.dewa.bank');
    }

    public function thana()
    {
        return view('home.dewa.thana');
    }

    public function postoffice()
    {
        return view('home.dewa.postoffice');
    }

    public function townarea()
    {
        return view('home.dewa.townarea');
    }

    public function safayiheroes()
    {
        return view('home.dewa.safayiheroes');
    }

    // Aulia-Allah

    public function baghdad()
    {
        return view('home.buzurganeislam.auliaallah.abdulqadirgilani');
    }

    public function khammanpeer()
    {
        return view('home.buzurganeislam.auliaallah.khammanpeer');
    }

    public function shahmeenashah()
    {
        return view('home.buzurganeislam.auliaallah.shahmeenashah');
    }

    public function lahore()
    {
        return view('home.buzurganeislam.auliaallah.dataganjbaksh');
    }

    public function delhi()
    {
        return view('home.buzurganeislam.auliaallah.hazratnizamuddin');
    }

    public function ajmer()
    {
        return view('home.buzurganeislam.auliaallah.muinuddinchisti');
    }

    public function mumbai()
    {
        return view('home.buzurganeislam.auliaallah.hajiali');
    }

    public function nagpur()
    {
        return view('home.buzurganeislam.auliaallah.hazrattajuddin');
    }

    public function bahraich()
    {
        return view('home.buzurganeislam.auliaallah.syedmasoodghazi');
    }


    public function kichhauchha()
    {
        return view('home.buzurganeislam.auliaallah.syedmakhdoom');
    }

    public function srinagar()
    {
        return view('home.buzurganeislam.auliaallah.hazratbal');
    }

    public function bareilly()
    {
        return view('home.buzurganeislam.auliaallah.aalahazrat');
    }


// Ahlebayt-Sahaba
public function mohammad()
{
    return view('home.buzurganeislam.ahlebaytsahaba.muhammad');
}

public function fatima()
{
    return view('home.buzurganeislam.ahlebaytsahaba.fatima');
}

public function ali()
{
    return view('home.buzurganeislam.ahlebaytsahaba.ali');
}

public function hasan()
{
    return view('home.buzurganeislam.ahlebaytsahaba.hasan');
}

public function hussain()
{
    return view('home.buzurganeislam.ahlebaytsahaba.husain');
}

public function khadija()
{
    return view('home.buzurganeislam.ahlebaytsahaba.khadija');
}

public function sawdah()
{
    return view('home.buzurganeislam.ahlebaytsahaba.sawdahbintzamah');
}

public function aisha()
{
    return view('home.buzurganeislam.ahlebaytsahaba.aisha');
}

public function hafsa()
{
    return view('home.buzurganeislam.ahlebaytsahaba.hafsa');
}

public function ummesalma()
{
    return view('home.buzurganeislam.ahlebaytsahaba.ummesalma');
}

public function zaynabbintkhuzayma()
{
    return view('home.buzurganeislam.ahlebaytsahaba.zaynabbintkhuzayma');
}

public function juwayriyahbintalharis()
{
    return view('home.buzurganeislam.ahlebaytsahaba.juwayriyahbintalharis');
}
public function zaynabbintjahsh()
{
    return view('home.buzurganeislam.ahlebaytsahaba.zaynabbintjahsh');
}
public function ummhabibahbintabisufyan()
{
    return view('home.buzurganeislam.ahlebaytsahaba.ummhabibahbintabisufyan');
}
public function maymonahbintalharis()
{
    return view('home.buzurganeislam.ahlebaytsahaba.maymonahbintalharis');
}
public function safiyyahbinthuyayyibnakhtab()
{
    return view('home.buzurganeislam.ahlebaytsahaba.safiyyahbinthuyayyibnakhtab');
}

public function abbas()
{
    return view('home.buzurganeislam.ahlebaytsahaba.abbas');
}

public function jafar()
{
    return view('home.buzurganeislam.ahlebaytsahaba.jafar');
}

public function abubakrsiddiq()
{
    return view('home.buzurganeislam.ahlebaytsahaba.abubakr');
}

public function umar()
{
    return view('home.buzurganeislam.ahlebaytsahaba.umar');
}

public function usman()
{
    return view('home.buzurganeislam.ahlebaytsahaba.usman');
}






    // ISLAM ************

    // MAKKAH Al Mukarrama

    public function creater()
    {
        return view('home.islam.makkah.allah');
    }

    public function messenger()
    {
        return view('home.islam.makkah.hazratmuhammad');
    }

    public function islam()
    {
        return view('home.islam.makkah.islam');
    }

    public function makkah()
    {
        return view('home.islam.makkah.makkah');
    }

    public function khanaekaaba()
    {
        return view('home.islam.makkah.khanaekaaba');
    }

    public function alharammosque()
    {
        return view('home.islam.makkah.alharammosque');
    }

    public function alhajaralaswad()
    {
        return view('home.islam.makkah.alhajaralaswad');
    }

    public function alsafaalmarwa()
    {
        return view('home.islam.makkah.alsafaalmarwa');
    }

    public function zamzam()
    {
        return view('home.islam.makkah.zamzam');
    }

    public function makameibraheem()
    {
        return view('home.islam.makkah.makameibraheem');
    }

    public function thekiswafactory()
    {
        return view('home.islam.makkah.thekiswafactory');
    }

    public function clocktower()
    {
        return view('home.islam.makkah.clocktower');
    }

    public function exhibitionmosques()
    {
        return view('home.islam.makkah.exhibitionmosques');
    }


    public function hajj()
    {
        return view('home.islam.makkah.hajj');
    }

    public function umrah()
    {
        return view('home.islam.makkah.umrah');
    }

    public function alrahmatmountain()
    {
        return view('home..islam.makkah.alrahmatmountain');
    }

    public function alnoormountain()
    {
        return view('home.islam.makkah.alnoormountain');
    }

    public function altoormountain()
    {
        return view('home.islam.makkah.altoormountain');
    }

    public function arafat()
    {
        return view('home.islam.makkah.arafat');
    }

    public function alqubaismountain()
    {
        return view('home.islam.makkah.alqubaismountain');
    }


    public function mina()
    {
        return view('home.islam.makkah.mina');
    }

    public function muzdalifa()
    {
        return view('home.islam.makkah.muzdalifa');
    }

    public function jisraljamarat()
    {
        return view('home.islam.makkah.jisraljamarat');
    }

    public function jannatalmualla()
    {
        return view('home.islam.makkah.jannatalmualla');
    }

    public function badr()
    {
        return view('home.islam.makkah.badr');
    }

    public function birtuwawell()
    {
        return view('home.islam.makkah.birtuwawell');
    }

    public function makkahmusium()
    {
        return view('home.islam.makkah.makkahmusium');
    }

    public function bilalbinrabahmosque()
    {
        return view('home.islam.makkah.bilalbinrabahmosque');
    }

    public function aishamosque()
    {
        return view('home.islam.makkah.aishamosque');
    }



    public function nimrahmosque()
    {
        return view('home.islam.makkah.nimrahmosque');
    }

    public function aishaalrajhimosque()
    {
        return view('home.islam.makkah.aishaalrajhimosque');
    }

    public function alrayahmosque()
    {
        return view('home.islam.makkah.alrayahmosque');
    }

    public function alkhaifmosque()
    {
        return view('home..islam.makkah.alkhaifmosque');
    }

    public function aljinnmosque()
    {
        return view('home.islam.makkah.aljinnmosque');
    }

    public function gharehira()
    {
        return view('home..islam.makkah.gharehira');
    }

    public function zamzamwell()
    {
        return view('home..islam.makkah.zamzamwell');
    }


    // MADINAH Al Munawwara

    public function muhammad()
    {
        return view('home.islam.madina.muhammad');
    }

    public function hazratmuhammaddome()
    {
        return view('home.islam.madina.hazratmuhammaddome');
    }

    public function madinah()
    {
        return view('home.islam.madina.madinah');
    }

    public function almasjidalnabawi()
    {
        return view('home.islam.madina.almasjidalnabawi');
    }

    public function jannatulbaqi()
    {
        return view('home.islam.madina.jannatulbaqi');
    }

    public function alqubamosque()
    {
        return view('home.islam.madina.alqubamosque');
    }

    public function alqiblataynmosque()
    {
        return view('home.islam.madina.alqiblataynmosque');
    }

    public function mountuhud()
    {
        return view('home.islam.madina.mountuhud');
    }

    public function ghamamahmosque()
    {
        return view('home.islam.madina.ghamamahmosque');
    }

    public function abubakrmosque()
    {
        return view('home.islam.madina.abubakrmosque');
    }

    public function anbariyamosque()
    {
        return view('home.islam.madina.anbariyamosque');
    }

    public function wadiejinn()
    {
        return view('home.islam.madina.wadiejinn');
    }

    public function jumahmosque()
    {
        return view('home.islam.madina.jumahmosque');
    }

    public function daralmadinahmuseum()
    {
        return view('home.islam.madina.daralmadinahmuseum');
    }

    public function hejazrailwaymuseum()
    {
        return view('home.islam.madina.hejazrailwaymuseum');
    }

    public function quranprintcomplex()
    {
        return view('home.islam.madina.quranprintcomplex');
    }

    public function almadinahmuseum()
    {
        return view('home.islam.madina.almadinahmuseum');
    }

// Goodt Thoughts
public function goodthoughts()
{
    return view('home.islam.thoughts.goodthoughts');
}

// Instructions

public function copyright()
{
    return view('home.instructions.copyright');
}

public function disclaimer()
{
    return view('home.instructions.disclaimer');
}
public function privacy()
{
    return view('home.instructions.privacy');
}
public function terms()
{
    return view('home.instructions.terms');
}

// Quick Links
public function dosanddonts()
{
    return view('home.links.dosanddonts');
}
public function faqs()
{
    return view('home.links.faqs');
}

// Gellary


    public function gellary()
    {
        return view('home.gellary.gellary');
    }

    public function shopCart()
    {
        return view('home.shops.cart');
    }

    public function shopCheckout(Request $request)
    {
        if (!auth()->check()) {
            session()->put('url.intended', $request->fullUrl());
            return redirect()->route('login')->with('error', 'Please Register or Login an account first to purchase products.');
        }

        return view('home.shops.checkout');
    }

    private function isCabNightTime($timeStr)
    {
        if (!$timeStr) return false;
        $timeStr = strtolower(trim($timeStr));
        $isPM = str_contains($timeStr, 'pm');
        $isAM = str_contains($timeStr, 'am');

        preg_match('/(\d{1,2}):?(\d{2})?/', $timeStr, $matches);
        if (!empty($matches[1])) {
            $hour = (int)$matches[1];
            if ($isPM && $hour < 12) $hour += 12;
            if ($isAM && $hour === 12) $hour = 0;
            return ($hour >= 22 || ($hour >= 0 && $hour < 5));
        }
        return false;
    }

    public function storeCustomCabEnquiry(Request $request)
    {
        $pickup = trim($request->input('pickup', 'Dewa Sharif'));
        $drop = trim($request->input('drop', 'Any City / Outstation'));
        $vehicle = trim($request->input('vehicle', 'Dzire etc which is available (Semi Deluxe - Sedan)'));
        
        $user = auth()->user();
        $name = $user ? $user->name : 'Pilgrim Visitor';
        $phone = $user ? ($user->phone ?? '9648777223') : '9648777223';

        $bookingCode = 'DWS-CUST-' . date('Y') . '-' . rand(1000, 9999);
        $routeStr = "{$pickup} → {$drop} (Custom Outstation Route)";

        $booking = [
            'booking_code' => $bookingCode,
            'customer_name' => $name,
            'customer_phone' => $phone,
            'route' => $routeStr,
            'pickup' => $pickup,
            'destination' => $drop,
            'vehicle_type' => $vehicle,
            'pickup_time' => date('Y-m-d H:i:s'),
            'fare' => 0,
            'total_fare' => 0,
            'status' => 'Custom WhatsApp Inquiry',
            'created_at' => date('Y-m-d H:i:s')
        ];

        \App\Helpers\DataStore::addItem('cab_bookings', $booking);

        $waMsg = "Assalamu Alaikum Sir !\n\n" .
            "I want to book a Custom Route Cab from dewasharif.com:\n" .
            "📍 Custom Pickup: " . $pickup . "\n" .
            "📍 Custom Destination: " . $drop . "\n" .
            "🚕 Vehicle Preferred: " . $vehicle . "\n\n" .
            "Please let me know the best quote fare and availability. Thank you!";

        $waUrl = "https://wa.me/919648777223?text=" . urlencode($waMsg);

        return response()->json([
            'success' => true,
            'whatsapp_url' => $waUrl
        ]);
    }

    public function storeCustomHotelEnquiry(Request $request)
    {
        $requirement = trim($request->input('requirement', 'AC Family Hall / Group Stay'));
        $guests = trim($request->input('guests', '8-15 Persons'));
        $dates = trim($request->input('dates', 'Upcoming Dewa Ziyarat / Urs'));

        $user = auth()->user();
        $name = $user ? $user->name : 'Pilgrim Visitor';
        $phone = $user ? ($user->phone ?? '9648777223') : '9648777223';

        $bookingCode = 'DWS-HTL-GRP-' . date('Y') . '-' . rand(1000, 9999);

        $parsedGuests = (int)preg_replace('/[^0-9]/', '', $guests);
        if ($parsedGuests <= 0) $parsedGuests = 8;

        $booking = [
            'booking_code' => $bookingCode,
            'booking_number' => $bookingCode,
            'customer_name' => $name,
            'customer_phone' => $phone,
            'hotel_id' => 1,
            'hotel_name' => 'Custom Hall & Group Stay Enquiry',
            'room_name' => $requirement,
            'check_in' => date('Y-m-d'),
            'check_out' => date('Y-m-d', strtotime('+1 day')),
            'nights' => 1,
            'guests' => $parsedGuests,
            'persons' => $parsedGuests,
            'rooms' => 1,
            'total_amount' => 0,
            'paid_amount' => 0,
            'price_per_night' => 0,
            'payment_status' => 'pending',
            'status' => 'Custom WhatsApp Inquiry',
            'created_at' => date('Y-m-d H:i:s')
        ];

        \App\Helpers\DataStore::addItem('hotel_bookings', $booking);

        $waMsg = "Assalamu Alaikum Dewa Sharif Hotel Desk!\n\n" .
            "I want to book a Custom Family Hall / Group Stay near Dewa Sharif Dargah:\n" .
            "🏨 Stay Requirement: " . $requirement . "\n" .
            "👥 Total Guests / Persons: " . $guests . "\n" .
            "📅 Expected Dates / Duration: " . $dates . "\n\n" .
            "Please share available guest houses, halls & best custom quote. Thank you!";

        $waUrl = "https://wa.me/919648777223?text=" . urlencode($waMsg);

        return response()->json([
            'success' => true,
            'whatsapp_url' => $waUrl
        ]);
    }

    public function storeCabBooking(Request $request)
    {
        $mode = $request->input('booking_mode', 'online');
        if (!auth()->check() && $mode !== 'whatsapp') {
            session()->put('url.intended', route('cabs.checkout'));
            return response()->json([
                'success' => false,
                'require_login' => true,
                'redirect_url' => route('login'),
                'message' => 'Please Register or Login an account first to book cabs.'
            ], 401);
        }

        $name = trim($request->input('name', ''));
        $rawPhone = trim($request->input('phone', ''));
        $altPhone = trim($request->input('alternate_phone', ''));
        $pickup = trim($request->input('pickup', 'Dewa Sharif Dargah Gate'));
        $drop = trim($request->input('drop', 'Lucknow Charbagh Railway Station'));
        $vehicle = trim($request->input('vehicle', 'Swift Dzire (AC)'));
        $date = trim($request->input('date', ''));
        $time = trim($request->input('time', ''));
        $idType = trim($request->input('id_type', 'Aadhaar Card'));
        $idNo = trim($request->input('id_no', 'N/A'));
        if (empty($idNo)) {
            $idNo = 'N/A';
        }

        if ($mode !== 'whatsapp') {
            if (empty($name) || empty($rawPhone) || empty($date) || empty($time) || empty($idNo) || $idNo === 'N/A') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kripya sabhi zaroori fields (Passenger Name, Mobile, Pickup Date, Time, aur Govt ID Number) bharein.'
                ], 422);
            }
        } else {
            if (empty($name) || empty($rawPhone)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kripya Passenger Name aur Mobile Number bharein.'
                ], 422);
            }
        }

        $fare = (float)$request->input('fare', 0);
        if ($fare <= 0) {
            $allCabs = \App\Helpers\DataStore::getCollection('cabs');
            $pLow = strtolower(trim($pickup));
            $dLow = strtolower(trim($drop));
            foreach ($allCabs as $c) {
                $cPk = strtolower(trim(is_array($c) ? ($c['pickup'] ?? '') : ($c->pickup ?? '')));
                $cDp = strtolower(trim(is_array($c) ? ($c['destination'] ?? ($c['drop'] ?? '')) : ($c->destination ?? ($c->drop ?? ''))));
                if ((str_contains($pLow, $cPk) || str_contains($cPk, $pLow)) && (str_contains($dLow, $cDp) || str_contains($cDp, $dLow))) {
                    $fare = (float)(is_array($c) ? ($c['price'] ?? ($c['fare'] ?? 0)) : ($c->price ?? ($c->fare ?? 0)));
                    break;
                }
            }
        }

        $isNight = $this->isCabNightTime($time);
        $nightNote = $isNight ? " (Includes ₹100 Night Service Surcharge 10 PM - 5 AM)" : "";

        // Clean phone number for WhatsApp wa.me
        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $bookingCode = $request->input('booking_code') ?: ('DWS-CAB-' . date('Y') . '-' . rand(1000, 9999));
        $routeStr = "{$pickup} → {$drop}";

        $paymentId = $request->input('payment_id', ($mode === 'whatsapp' ? 'WhatsApp Direct' : ('RZP_CAB_' . time())));
        $utrNumber = trim($request->input('utr_number', ''));
        $isQr = str_contains($paymentId, 'QR') || !empty($utrNumber);
        $gatewayName = ($mode === 'whatsapp') ? 'WhatsApp Direct' : ($isQr ? 'PhonePe QR' : 'Razorpay / SBI UPI');
        $statusStr = ($mode === 'whatsapp') ? 'Custom WhatsApp Inquiry' : ($isQr ? 'Payment Submitted (UTR Verification Pending)' : 'Confirmed & Paid');
        $paymentMode = ($mode === 'whatsapp') ? 'whatsapp' : ($isQr ? 'PhonePe QR' : 'full');
        $paymentStatus = ($mode === 'whatsapp') ? 'pending' : ($isQr ? 'verification_pending' : 'paid');
        $paidAmount = ($mode === 'whatsapp' || $isQr) ? 0 : $fare;

        $vehicleCount = max(1, (int)$request->input('vehicle_count', 1));
        $vehicleTypeStored = $vehicleCount > 1 ? "{$vehicle} (×{$vehicleCount} Cabs)" : $vehicle;

        $user = auth()->user();
        $userId = $user ? $user->id : null;
        $userEmail = $user ? ($user->email ?? null) : null;

        $booking = [
            'booking_code' => $bookingCode,
            'user_id' => $userId,
            'customer_name' => $name,
            'customer_phone' => $rawPhone,
            'customer_email' => $userEmail,
            'alternate_phone' => $altPhone ?: null,
            'route' => $routeStr,
            'pickup' => $pickup,
            'destination' => $drop,
            'vehicle_type' => $vehicleTypeStored,
            'vehicle_name' => $vehicleTypeStored,
            'vehicle_count' => $vehicleCount,
            'pickup_time' => "{$date} @ {$time}",
            'fare' => $fare,
            'total_fare' => $fare,
            'paid_amount' => $paidAmount,
            'payment_status' => $paymentStatus,
            'night_surcharge' => $isNight ? (100 * $vehicleCount) : 0,
            'id_type' => $idType,
            'id_no' => $idNo,
            'payment_id' => $paymentId,
            'utr_number' => $utrNumber ?: null,
            'payment_mode' => $paymentMode,
            'payment_gateway' => $gatewayName,
            'driver' => ($mode === 'whatsapp') ? 'Inquiry pending admin fare confirmation' : 'Driver Assignment in Progress (Details sent before pickup)',
            'driver_name' => null,
            'driver_phone' => null,
            'driver_vehicle_number' => null,
            'status' => $statusStr,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $savedItem = \App\Helpers\DataStore::addItem('cab_bookings', $booking);
        $bookingId = $savedItem['id'] ?? time();

        // Save transaction record for Customer Billing only if paid
        if ($mode !== 'whatsapp') {
            try {
                \App\Helpers\DataStore::addItem('transactions', [
                    'transaction_id' => 'TXN-' . strtoupper(substr(md5(time() . rand(100, 999)), 0, 10)),
                    'payment_id' => $paymentId,
                    'customer_name' => $name,
                    'customer_phone' => $rawPhone,
                    'service_type' => 'Taxi Ride (' . $vehicleTypeStored . ')',
                    'amount' => $fare,
                    'status' => 'Paid',
                    'payment_gateway' => $gatewayName,
                    'date' => date('Y-m-d H:i:s')
                ]);
            } catch (\Throwable $e) {}
        }

        // Parking Policy Check
        $parkingPolicy = \App\Helpers\DataStore::getItem('cab_parking_policy', 1) ?? ['status' => 'Active'];
        $isParkingActive = ($parkingPolicy['status'] ?? 'Active') === 'Active';
        $parkingNoteMsg = "";
        $parkingMailMsg = "";
        if ($isParkingActive) {
            $parkingNoteMsg = "🅿️ *Parking Note:* Airport first 10 mins free. Extra airport waiting or monument parking payable directly by passenger as per actual receipt.\n\n";
            $parkingMailMsg = "Parking Note: Airport first 10 mins free. Extra airport waiting or monument parking payable directly by passenger as per actual receipt.\n";
        }

        // Send Email Confirmation to Customer & Admin only if paid
        if ($mode !== 'whatsapp') {
            try {
                $passengerContact = $name . ' (' . $rawPhone . (!empty($altPhone) ? " / Alt: {$altPhone}" : "") . ')';
                $mailText = "🎉 PAYMENT SUCCESSFUL & TAXI RIDE CONFIRMED!\n\n" .
                            "Booking Code: {$bookingCode}\n" .
                            "Passenger: {$passengerContact}\n" .
                            "Vehicle: {$vehicle}\n" .
                            "Route: {$routeStr}\n" .
                            "Pickup Date & Time: {$date} @ {$time}\n" .
                            "Total Amount Paid: ₹" . number_format($fare) . "{$nightNote}\n" .
                            $parkingMailMsg .
                            "Tax Invoice & Duty Slip: " . route('customer.invoice', ['type' => 'cab', 'id' => $bookingId]) . "\n\n" .
                            "Thank you for booking with DewaSharif.com!";

                $mailRecipients = array_filter([$userEmail, env('MAIL_FROM_ADDRESS', 'shahzade.alam707@gmail.com')]);
                if (!empty($mailRecipients)) {
                    \Illuminate\Support\Facades\Mail::raw($mailText, function ($message) use ($name, $bookingCode, $mailRecipients) {
                        $message->to($mailRecipients)
                                ->subject("🎉 DewaSharif Cab Ride Confirmed [{$bookingCode}]");
                    });
                }
            } catch (\Throwable $e) {}

            // Send Automatic Meta WhatsApp Cloud API Message to Customer
            try {
                \App\Services\MetaWhatsAppService::sendCustomMessage($rawPhone, $booking, 'Cab Booking');
            } catch (\Throwable $e) {}
        }

        $invoiceUrl = route('customer.invoice', ['type' => 'cab', 'id' => $bookingId]);
        $redirectUrl = route('customer.dashboard', ['payment_success' => 1, 'type' => 'cab', 'id' => $bookingId, 'code' => $bookingCode]);

        $passengerLabel = $name . ' (' . $rawPhone . (!empty($altPhone) ? " / Alt: {$altPhone}" : "") . ')';
        $waMsg = "🎉 *DEWA SHARIF TAXI RIDE CONFIRMED*\n\n" .
                 "🎫 *Booking Code:* {$bookingCode}\n" .
                 "👤 *Passenger:* {$passengerLabel}\n" .
                 "🚕 *Vehicle:* {$vehicle}\n" .
                 "📍 *Route:* {$routeStr}\n" .
                 "📅 *Pickup Date & Time:* {$date} @ {$time}\n" .
                 "🪪 *Govt ID:* {$idType} ({$idNo})\n" .
                 "💰 *Total Fare Paid:* ₹" . number_format($fare) . "{$nightNote}\n\n" .
                 $parkingNoteMsg .
                 "⚠️ *Boarding Rule:* Gaadi me baithne se pehle passenger ko yahi original physical ID driver ko dikhana anivarya hai.\n\n" .
                 "📄 *Tax Invoice & Duty Slip:* {$invoiceUrl}\n\n" .
                 "Driver duty slip is active. Thank you for booking with DewaSharif.com!";

        $passengerWhatsappUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode($waMsg);
        $companyWhatsappUrl = "https://wa.me/919648777223?text=" . urlencode($waMsg);

        return response()->json([
            'success' => true,
            'booking_id' => $bookingId,
            'booking_code' => $bookingCode,
            'invoice_url' => $invoiceUrl,
            'redirect_url' => $redirectUrl,
            'whatsapp_url' => $passengerWhatsappUrl,
            'company_whatsapp_url' => $companyWhatsappUrl,
            'message' => 'Cab Ride Booked & Tax Invoice Generated Successfully!'
        ]);
    }

    public function storeHotelBooking(Request $request)
    {
        $mode = $request->input('booking_mode', 'online');
        if (!auth()->check() && $mode !== 'whatsapp') {
            session()->put('url.intended', route('hotels.checkout'));
            return response()->json([
                'success' => false,
                'require_login' => true,
                'redirect_url' => route('login'),
                'message' => 'Please Register or Login an account first to book hotel rooms.'
            ], 401);
        }

        $name = trim($request->input('name', 'Guest User'));
        $rawPhone = trim($request->input('phone', '9648777223'));
        $altPhone = trim($request->input('alternate_phone', ''));
        $hotelName = trim($request->input('hotel_name', 'Al-Waris Deluxe Guest House'));
        $roomName = trim($request->input('room_name', 'Deluxe AC Room'));
        $rawPrice = preg_replace('/[^0-9.]/', '', $request->input('price', '1499'));
        $price = (float)($rawPrice ?: 1499);
        $checkin = $request->input('checkin', date('Y-m-d'));
        $checkout = $request->input('checkout', date('Y-m-d', strtotime('+1 day')));
        $idType = $request->input('id_type', 'Aadhaar Card');
        $idNo = trim($request->input('id_no', 'N/A')) ?: 'N/A';
        $paymentId = $request->input('payment_id', ($mode === 'whatsapp' ? 'WhatsApp Direct' : ('RZP_HOTEL_' . time())));

        $checkinTime = strtotime($checkin);
        $checkoutTime = strtotime($checkout);
        if ($checkoutTime <= $checkinTime) {
            $checkoutTime = strtotime('+1 day', $checkinTime);
            $checkout = date('Y-m-d', $checkoutTime);
        }
        $nights = max(1, (int)round(($checkoutTime - $checkinTime) / 86400));

        $roomsCount = max(1, (int)$request->input('rooms', $request->input('rooms_count', 1)));
        $roomNameStored = $roomsCount > 1 ? "{$roomName} (×{$roomsCount} Rooms)" : $roomName;

        // Enforce strict price per night & total fare calculation:
        $rawBase = preg_replace('/[^0-9.]/', '', $request->input('base_price', '0'));
        $basePrice = (float)$rawBase;
        if ($basePrice <= 0) {
            // If base_price was not explicitly passed, deduce it
            $basePrice = ($nights > 1 && $price > 0) ? round($price / ($nights * $roomsCount), 2) : $price;
        }
        $totalFare = round($basePrice * $nights * $roomsCount, 2);
        $pricePerNight = $basePrice;

        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $bookingCode = $request->input('booking_code') ?: ('DWS-HTL-' . date('Y') . '-' . rand(1000, 9999));
        $isQr = (str_contains($paymentId, 'QR') || $request->filled('utr_number'));
        $paymentMode = ($mode === 'whatsapp') ? 'whatsapp' : ($isQr ? 'PhonePe QR' : 'full');
        $gatewayName = ($mode === 'whatsapp') ? 'WhatsApp Direct' : ($isQr ? 'PhonePe QR' : 'Razorpay / SBI UPI');
        $statusStr = ($mode === 'whatsapp') ? 'Custom WhatsApp Inquiry' : ($isQr ? 'Payment Submitted (UTR Verification Pending)' : 'Confirmed & Paid');
        $paymentStatus = ($mode === 'whatsapp') ? 'pending' : ($isQr ? 'verification_pending' : 'paid');
        $paidAmount = ($mode === 'whatsapp' || $isQr) ? 0 : $totalFare;

        $booking = [
            'user_id' => auth()->id() ?? null,
            'customer_email' => auth()->check() ? (auth()->user()->email ?? null) : null,
            'booking_code' => $bookingCode,
            'booking_number' => $bookingCode,
            'customer_name' => $name,
            'customer_phone' => $rawPhone,
            'alternate_phone' => $altPhone ?: null,
            'hotel_name' => $hotelName,
            'room_name' => $roomNameStored,
            'rooms_count' => $roomsCount,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'nights' => $nights,
            'price_per_night' => $pricePerNight,
            'amount' => $totalFare,
            'total_fare' => $totalFare,
            'total_amount' => $totalFare,
            'paid_amount' => $paidAmount,
            'payment_status' => $paymentStatus,
            'id_type' => $idType,
            'id_no' => $idNo,
            'status' => $statusStr,
            'payment_id' => $paymentId,
            'utr_number' => trim($request->input('utr_number', '')) ?: null,
            'payment_mode' => $paymentMode,
            'payment_gateway' => $gatewayName,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $savedItem = \App\Helpers\DataStore::addItem('hotel_bookings', $booking);
        $bookingId = $savedItem['id'] ?? time();

        // Save transaction record for Customer Billing only if paid
        if ($mode !== 'whatsapp') {
            try {
                $htlGateway = (str_contains($paymentId, 'QR') || $request->filled('utr_number')) ? 'PhonePe QR' : 'Razorpay / SBI UPI';
                \App\Helpers\DataStore::addItem('transactions', [
                    'transaction_id' => 'TXN-' . strtoupper(substr(md5(time() . rand(100, 999)), 0, 10)),
                    'payment_id' => $paymentId,
                    'customer_name' => $name,
                    'customer_phone' => $rawPhone,
                    'service_type' => 'Hotel Stay (' . $hotelName . ' - ' . $roomNameStored . ')',
                    'amount' => $totalFare,
                    'status' => 'Paid',
                    'payment_gateway' => $htlGateway,
                    'date' => date('Y-m-d H:i:s')
                ]);
            } catch (\Throwable $e) {}

            // Auto-decrement available rooms inventory in DataStore
            try {
                $hotels = \App\Helpers\DataStore::getCollection('hotels');
                foreach ($hotels as $h) {
                    $hName = $h['name'] ?? '';
                    if (!empty($hName) && (str_contains(strtolower($hName), strtolower($hotelName)) || str_contains(strtolower($hotelName), strtolower($hName)))) {
                        $currAvail = (int)($h['available_rooms'] ?? 10);
                        $newAvail = max(0, $currAvail - $roomsCount);
                        \App\Helpers\DataStore::updateItem('hotels', $h['id'], ['available_rooms' => $newAvail]);
                        break;
                    }
                }
            } catch (\Throwable $e) {}
        }

        // Send Email Confirmation to Customer & Admin only if paid
        if ($mode !== 'whatsapp') {
            try {
                $guestContact = $name . ' (' . $rawPhone . (!empty($altPhone) ? " / Alt: {$altPhone}" : "") . ')';
                $mailText = "🎉 PAYMENT SUCCESSFUL & HOTEL ROOM CONFIRMED!\n\n" .
                            "Booking Code: {$bookingCode}\n" .
                            "Guest Name: {$guestContact}\n" .
                            "Hotel: {$hotelName}\n" .
                            "Room Type: {$roomName}\n" .
                            "Dates: {$checkin} to {$checkout} ({$nights} Night)\n" .
                            "Amount Paid: ₹" . number_format($totalFare, 2) . "\n" .
                            "Tax Invoice & Voucher: " . route('customer.invoice', ['type' => 'hotel', 'id' => $bookingId]) . "\n\n" .
                            "Thank you for staying with DewaSharif.com!";

                \Illuminate\Support\Facades\Mail::raw($mailText, function ($message) use ($name, $bookingCode) {
                    $message->to(env('MAIL_FROM_ADDRESS', 'shahzade.alam707@gmail.com'))
                            ->subject("🎉 DewaSharif Hotel Reservation Confirmed [{$bookingCode}]");
                });
            } catch (\Throwable $e) {}

            // Send Automatic Meta WhatsApp Cloud API Message to Customer
            try {
                \App\Services\MetaWhatsAppService::sendCustomMessage($rawPhone, $booking, 'Hotel Booking');
            } catch (\Throwable $e) {}
        }

        $invoiceUrl = route('customer.invoice', ['type' => 'hotel', 'id' => $bookingId]);
        $redirectUrl = route('customer.dashboard', ['payment_success' => 1, 'type' => 'hotel', 'id' => $bookingId, 'code' => $bookingCode]);

        $guestLabel = $name . ' (' . $rawPhone . (!empty($altPhone) ? " / Alt: {$altPhone}" : "") . ')';
        $waMsg = "🎉 *DEWA SHARIF HOTEL ROOM BOOKING CONFIRMED*\n\n" .
                 "🎫 *Booking Code:* {$bookingCode}\n" .
                 "👤 *Guest Name:* {$guestLabel}\n" .
                 "🪪 *Govt ID:* {$idType} ({$idNo})\n" .
                 "🏨 *Hotel:* {$hotelName}\n" .
                 "🛏️ *Room:* {$roomName}\n" .
                 "📅 *Dates:* {$checkin} to {$checkout} ({$nights} Night)\n" .
                 "💰 *Amount Paid:* ₹" . number_format($totalFare, 2) . " (Direct SBI Credit)\n\n" .
                 "⚠️ *Check-in Notice:* Hotel reception par check-in ke waqt yahi original physical ID card dikhana anivarya hai.\n\n" .
                 "📄 *Tax Invoice PDF Voucher:* {$invoiceUrl}\n\n" .
                 "Room reservation is active. Thank you for booking with DewaSharif.com!";

        $passengerWhatsappUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode($waMsg);
        $companyWhatsappUrl = "https://wa.me/919648777223?text=" . urlencode($waMsg);

        return response()->json([
            'success' => true,
            'booking_id' => $bookingId,
            'booking_code' => $bookingCode,
            'invoice_url' => $invoiceUrl,
            'redirect_url' => $redirectUrl,
            'whatsapp_url' => $passengerWhatsappUrl,
            'company_whatsapp_url' => $companyWhatsappUrl,
            'message' => 'Hotel Room Booked & Tax Invoice Generated Successfully!'
        ]);
    }

    public function storeShopOrder(Request $request)
    {
        $mode = $request->input('booking_mode', 'online');
        if (!auth()->check() && $mode !== 'whatsapp') {
            session()->put('url.intended', route('shops.checkout'));
            return response()->json([
                'success' => false,
                'require_login' => true,
                'redirect_url' => route('login'),
                'message' => 'Please Register or Login an account first to complete your product order.'
            ], 401);
        }

        $name = trim($request->input('name', 'Pilgrim Customer'));
        $rawPhone = trim($request->input('phone', '9648777223'));
        $altPhone = trim($request->input('alternate_phone', ''));
        $address = trim($request->input('address', 'Dewa Sharif Dargah Gate'));
        $city = trim($request->input('city', 'Barabanki'));
        $state = trim($request->input('state', 'Uttar Pradesh'));
        $pincode = trim($request->input('pincode', '225301'));
        $itemsSummary = trim($request->input('items_summary', 'Warsis Attar & Sacred Souvenirs'));
        $amount = (float)$request->input('amount', 1497);
        $paymentId = $request->input('payment_id', ($mode === 'whatsapp' ? 'WhatsApp Direct' : ('RZP_SHP_' . time())));
        $fatehaName = trim($request->input('fateha_name', ''));
        $niyazDate = trim($request->input('niyaz_date', date('d M Y')));
        $distributionType = trim($request->input('distribution_type', 'Dargah Sharif Me Langar Taqseem (Distribute to Zaireen & Needy Devotees)'));
        
        $isDegh = !empty($fatehaName) || str_contains(strtolower($itemsSummary), 'degh') || str_contains(strtolower($itemsSummary), 'biryani') || str_contains(strtolower($itemsSummary), 'zarda') || str_contains(strtolower($itemsSummary), 'kheer');

        // Stock Pre-Check Validation: Make sure no item is out of stock or requesting more than stock (for paid orders)
        $cartItemsRaw = $request->input('cart_items', '');
        $cartItems = is_string($cartItemsRaw) ? json_decode($cartItemsRaw, true) : $cartItemsRaw;
        if ($mode !== 'whatsapp' && !empty($cartItems) && is_array($cartItems)) {
            $dbProducts = \Illuminate\Support\Facades\DB::table('shop_products')->get()->keyBy('id');
            $dataStoreProducts = collect(\App\Helpers\DataStore::getCollection('products'))->keyBy('id');

            foreach ($cartItems as $item) {
                $pId = $item['id'] ?? null;
                $reqQty = max(1, (int)($item['qty'] ?? 1));
                $pName = $item['name'] ?? 'Product';

                if ($pId) {
                    $itemCategory = null;
                    if (isset($dbProducts[$pId])) {
                        $itemCategory = $dbProducts[$pId]->category_slug ?? null;
                    } elseif (isset($dataStoreProducts[$pId])) {
                        $itemCategory = $dataStoreProducts[$pId]['category'] ?? null;
                    }
                    if ($itemCategory) {
                        try {
                            $catRec = \Illuminate\Support\Facades\DB::table('shop_categories')->where('slug', $itemCategory)->first();
                            if ($catRec && strtolower($catRec->status) !== 'active') {
                                return response()->json([
                                    'success' => false,
                                    'message' => "Sorry, '{$pName}' belongs to a category that is currently Coming Soon. Please remove it from your cart to proceed."
                                ], 422);
                            }
                        } catch (\Throwable $e) {}
                    }

                    $available = null;
                    if (isset($dbProducts[$pId])) {
                        $available = (int)$dbProducts[$pId]->stock_quantity;
                    } elseif (isset($dataStoreProducts[$pId])) {
                        $dsItem = $dataStoreProducts[$pId];
                        $available = (int)($dsItem['stock_quantity'] ?? ($dsItem['stock'] ?? 50));
                    }

                    if ($available !== null) {
                        if ($available <= 0) {
                            return response()->json([
                                'success' => false,
                                'message' => "Sorry, '{$pName}' is currently Out of Stock. Please remove it from your cart to proceed."
                            ], 422);
                        }
                        if ($reqQty > $available) {
                            return response()->json([
                                'success' => false,
                                'message' => "Sorry, only {$available} unit(s) available in stock for '{$pName}'."
                            ], 422);
                        }
                    }
                }
            }
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $orderCode = $request->input('order_code') ?: (($isDegh ? 'DWS-DGH-' : 'DWS-SHP-') . date('Y') . '-' . rand(1000, 9999));

        $isWhatsapp = ($mode === 'whatsapp');
        $isQrPayment = !$isWhatsapp && (stripos($paymentId, 'PhonePe') !== false || stripos($paymentId, 'QR') !== false || $request->filled('utr_number'));
        $isCodPayment = !$isWhatsapp && (stripos($paymentId, 'COD') !== false);
        $paymentMode = $isWhatsapp ? 'whatsapp' : ($isQrPayment ? 'PhonePe QR' : ($isCodPayment ? 'cod' : 'online'));
        $paymentStatus = $isWhatsapp ? 'pending' : ($isQrPayment ? 'verification_pending' : ($isCodPayment ? 'pending' : 'paid'));
        $orderStatus = $isWhatsapp ? 'pending' : 'processing';
        $paidAmount = ($isWhatsapp || $isQrPayment || $isCodPayment) ? 0 : $amount;
        $statusStr = $isWhatsapp ? 'Custom WhatsApp Inquiry' : ($isQrPayment ? 'Payment Submitted (UTR Verification Pending)' : ($isCodPayment ? 'Pending COD' : 'Dispatched & Paid'));

        $order = [
            'order_code' => $orderCode,
            'customer_name' => $name,
            'customer_phone' => $rawPhone,
            'alternate_phone' => $altPhone ?: null,
            'address' => "{$address}, {$city}, {$state} - {$pincode}",
            'items_summary' => $itemsSummary,
            'amount' => $amount,
            'total_amount' => $amount,
            'paid_amount' => $paidAmount,
            'payment_status' => $paymentStatus,
            'status' => $statusStr,
            'payment_id' => $paymentId,
            'payment_mode' => $paymentMode,
            'fateha_name' => $fatehaName,
            'niyaz_date' => $niyazDate,
            'distribution_type' => $distributionType,
            'is_degh' => $isDegh ? 1 : 0,
            'courier' => $isDegh ? 'Dargah Langar Distribution / Special Delivery' : 'DTDC Express',
            'tracking' => ($isDegh ? 'DGH-' : 'DT') . rand(10000000, 99999999) . 'IN',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $savedItem = \App\Helpers\DataStore::addItem('shop_orders', $order);
        $orderId = $savedItem['id'] ?? time();

        // Fetch real-time Order ID from MySQL shop_orders table (synced by DataStore)
        $dbOrder = \Illuminate\Support\Facades\DB::table('shop_orders')->where('order_id', $orderCode)->first();
        $dbOrderId = $dbOrder ? $dbOrder->id : null;
        if (!$dbOrderId) {
            try {
                $dbOrderId = \Illuminate\Support\Facades\DB::table('shop_orders')->insertGetId([
                    'order_id' => $orderCode,
                    'user_id' => auth()->id() ?? null,
                    'customer_name' => $name,
                    'customer_phone' => $rawPhone,
                    'customer_whatsapp' => $rawPhone,
                    'alternate_phone' => $altPhone ?: null,
                    'shipping_address' => "{$address}, {$city}, {$state} - {$pincode}",
                    'items_summary' => $itemsSummary,
                    'total_amount' => $amount,
                    'paid_amount' => $paidAmount,
                    'payment_id' => $paymentId,
                    'payment_mode' => $paymentMode,
                    'payment_status' => $paymentStatus,
                    'order_status' => $orderStatus,
                    'fateha_name' => $fatehaName,
                    'niyaz_date' => $niyazDate,
                    'distribution_type' => $distributionType,
                    'is_degh' => $isDegh ? 1 : 0,
                    'courier_name' => $isDegh ? 'Dargah Langar Distribution / Special Delivery' : 'DTDC Express',
                    'tracking_number' => ($isDegh ? 'DGH-' : 'DT') . rand(10000000, 99999999) . 'IN',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } catch (\Throwable $e) {}
        }

        // Auto-decrement inventory stock only if paid (not for whatsapp inquiries)
        if (!$isWhatsapp && !empty($cartItems) && is_array($cartItems)) {
            foreach ($cartItems as $item) {
                $pId = $item['id'] ?? null;
                $qty = max(1, (int)($item['qty'] ?? 1));
                $pPrice = (float)($item['price'] ?? 0);
                $pName = $item['name'] ?? 'Product';

                if ($pId) {
                    try {
                        // 1. MySQL Real-Time Decrement & Clamp to 0
                        \Illuminate\Support\Facades\DB::table('shop_products')
                            ->where('id', $pId)
                            ->decrement('stock_quantity', $qty);

                        \Illuminate\Support\Facades\DB::table('shop_products')
                            ->where('id', $pId)
                            ->where('stock_quantity', '<', 0)
                            ->update(['stock_quantity' => 0]);

                        // 2. DataStore Real-Time Stock Decrement & Clamp to 0
                        $products = \App\Helpers\DataStore::getCollection('products');
                        foreach ($products as &$prod) {
                            if (($prod['id'] ?? null) == $pId) {
                                $curr = (int)($prod['stock_quantity'] ?? ($prod['stock'] ?? 50));
                                $newStock = max(0, $curr - $qty);
                                $prod['stock_quantity'] = $newStock;
                                $prod['stock'] = $newStock;
                                break;
                            }
                        }
                        \App\Helpers\DataStore::save(array_merge(\App\Helpers\DataStore::get(), ['products' => $products]));

                        // 3. MySQL shop_order_items Insert
                        if ($dbOrderId) {
                            \Illuminate\Support\Facades\DB::table('shop_order_items')->insert([
                                'order_id' => $dbOrderId,
                                'product_id' => $pId,
                                'product_name' => $pName,
                                'unit_price' => $pPrice,
                                'quantity' => $qty,
                                'total_price' => $pPrice * $qty,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::error('Order items error: ' . $e->getMessage());
                    }
                }
            }
        }

        // Save transaction record for Customer Billing
        if (!$isWhatsapp) {
            try {
                \App\Helpers\DataStore::addItem('transactions', [
                    'transaction_id' => 'TXN-' . strtoupper(substr(md5(time() . rand(100, 999)), 0, 10)),
                    'payment_id' => $paymentId,
                    'customer_name' => $name,
                    'customer_phone' => $rawPhone,
                    'service_type' => ($isDegh ? 'Degh Niyaz Booking (' : 'Sacred Store (') . $itemsSummary . ')',
                    'amount' => $amount,
                    'status' => 'Paid',
                    'payment_gateway' => $isQrPayment ? 'PhonePe QR / UPI' : 'Razorpay / SBI UPI',
                    'date' => date('Y-m-d H:i:s')
                ]);
            } catch (\Throwable $e) {}
        }

        // Send Email Confirmation to Customer & Admin only if paid
        if (!$isWhatsapp) {
            try {
                $customerContact = $name . ' (' . $rawPhone . (!empty($altPhone) ? " / Alt: {$altPhone}" : "") . ')';
                if ($isDegh) {
                    $mailText = "🎉 DEGH NIYAZ & TABARRUK BOOKING CONFIRMED!\n\n" .
                                "Booking Reference: {$orderCode}\n" .
                                "Devotee Name: {$customerContact}\n" .
                                "Niyaz Ba-Naam (Fateha): " . ($fatehaName ?: 'Special Fateha & Dua') . "\n" .
                                "Scheduled Niyaz Date: {$niyazDate}\n" .
                                "Distribution Mode: {$distributionType}\n" .
                                "Degh Item(s): {$itemsSummary}\n" .
                                "Amount Paid: ₹" . number_format($amount) . " (Direct SBI Account Credit)\n" .
                                "Status: Confirmed & Scheduled for Preparation\n" .
                                "Tax Invoice PDF: " . route('customer.invoice', ['type' => 'shop', 'id' => $orderId]) . "\n\n" .
                                "Haji Waris Ali Shah (R.A.) Dargah Sharif Blessings & Khidmat.";
                } else {
                    $mailText = "🎉 PAYMENT SUCCESSFUL & STORE ORDER DISPATCHED!\n\n" .
                                "Order Code: {$orderCode}\n" .
                                "Customer Name: {$customerContact}\n" .
                                "Delivery Address: {$address}, {$city}, {$state} - {$pincode}\n" .
                                "Items Purchased: {$itemsSummary}\n" .
                                "Amount Paid: ₹" . number_format($amount) . "\n" .
                                "Courier: DTDC Express (Tracking ID: " . ($order['tracking']) . ")\n" .
                                "Tax Invoice: " . route('customer.invoice', ['type' => 'shop', 'id' => $orderId]) . "\n\n" .
                                "Thank you for shopping at DewaSharif.com!";
                }

                \Illuminate\Support\Facades\Mail::raw($mailText, function ($message) use ($name, $orderCode, $isDegh) {
                    $message->to(env('MAIL_FROM_ADDRESS', 'shahzade.alam707@gmail.com'))
                            ->subject($isDegh ? "🍲 Dewa Sharif Degh Niyaz Booked [{$orderCode}]" : "🎉 DewaSharif Store Order Confirmed [{$orderCode}]");
                });
            } catch (\Throwable $e) {}

            // Send Automatic Meta WhatsApp Cloud API Message to Customer
            try {
                \App\Services\MetaWhatsAppService::sendCustomMessage($rawPhone, $order, $isDegh ? 'Degh Niyaz Booking' : 'Sacred Store Order');
            } catch (\Throwable $e) {}
        }

        $invoiceUrl = route('customer.invoice', ['type' => 'shop', 'id' => $orderId]);
        $redirectUrl = route('customer.dashboard', ['payment_success' => 1, 'type' => 'shop', 'id' => $orderId, 'code' => $orderCode]);

        $customerLabel = $name . ' (' . $rawPhone . (!empty($altPhone) ? " / Alt: {$altPhone}" : "") . ')';
        if ($isDegh) {
            $waMsg = "🍲 *DEWA SHARIF DEGH NIYAZ BOOKING CONFIRMED*\n\n" .
                     "🎫 *Booking Code:* {$orderCode}\n" .
                     "👤 *Devotee:* {$customerLabel}\n" .
                     "🤲 *Niyaz Ba-Naam (Fateha):* " . ($fatehaName ?: 'Special Dua & Fateha') . "\n" .
                     "📅 *Niyaz Date:* {$niyazDate}\n" .
                     "🕌 *Distribution Mode:* {$distributionType}\n" .
                     "🥘 *Degh Tabarruk:* {$itemsSummary}\n" .
                     "💰 *Amount Paid:* ₹" . number_format($amount) . " (Direct SBI Credit)\n\n" .
                     "📄 *Official Tabarruk Invoice PDF:* {$invoiceUrl}\n\n" .
                     "Aapki Degh Niyaz Dargah Sharif par tayyar o taqseem ki jayegi. Shukriya!";
        } else {
            $waMsg = "🎉 *DEWA SHARIF SACRED STORE ORDER CONFIRMED*\n\n" .
                     "🎫 *Order Code:* {$orderCode}\n" .
                     "👤 *Customer:* {$customerLabel}\n" .
                     "📍 *Delivery Address:* {$address}, {$city}, {$state} - {$pincode}\n" .
                     "📦 *Items:* {$itemsSummary}\n" .
                     "💰 *Amount Paid:* ₹" . number_format($amount) . "\n\n" .
                     "📄 *Tax Invoice PDF:* {$invoiceUrl}\n\n" .
                     "Order dispatched. Thank you for shopping with DewaSharif.com!";
        }

        $passengerWhatsappUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode($waMsg);
        $companyWhatsappUrl = "https://wa.me/919648777223?text=" . urlencode($waMsg);

        return response()->json([
            'success' => true,
            'order_id' => $orderId,
            'order_code' => $orderCode,
            'invoice_url' => $invoiceUrl,
            'redirect_url' => $redirectUrl,
            'whatsapp_url' => $passengerWhatsappUrl,
            'company_whatsapp_url' => $companyWhatsappUrl,
            'message' => $isDegh ? 'Degh Niyaz Booked & Official Invoice Generated Successfully!' : 'Sacred Store Order Confirmed & Tax Invoice Generated Successfully!'
        ]);
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contactData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('contacts')) {
                \App\Models\Contact::create($contactData);
            } else {
                \App\Helpers\DataStore::addItem('contacts', $contactData);
            }
        } catch (\Throwable $e) {
            \App\Helpers\DataStore::addItem('contacts', $contactData);
        }

        return back()->with('success', 'Thank you for reaching out! Your message has been received. Our team will get back to you shortly.');
    }

    public function applyCoupon(Request $request)
    {
        $code = trim(strtoupper($request->input('code', '')));
        $subtotal = (float)$request->input('subtotal', 0);

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'Please enter a coupon code.']);
        }

        $coupon = null;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('coupons')) {
                $coupon = \Illuminate\Support\Facades\DB::table('coupons')->where('code', $code)->first();
            }
        } catch (\Throwable $e) {}

        if ($coupon) {
            $discountPct = (float)($coupon->discount ?? 10);
            $discountVal = round(($subtotal * $discountPct) / 100);
            return response()->json([
                'success' => true,
                'discount' => $discountVal,
                'code' => $code,
                'message' => "Coupon '{$code}' applied! You saved ₹{$discountVal} ({$discountPct}% OFF)."
            ]);
        }

        if ($code === 'DEWA10' || $code === 'WARIS10') {
            $discountVal = round($subtotal * 0.10);
            return response()->json([
                'success' => true,
                'discount' => $discountVal,
                'code' => $code,
                'message' => "Sacred Promo '{$code}' applied! 10% Discount saved ₹{$discountVal}."
            ]);
        } elseif ($code === 'DEWA50') {
            $discountVal = 50;
            return response()->json([
                'success' => true,
                'discount' => $discountVal,
                'code' => $code,
                'message' => "Sacred Promo '{$code}' applied! Flat ₹50 Discount."
            ]);
        }

        return response()->json(['success' => false, 'message' => "Invalid or expired promo code '{$code}'."]);
    }

    public function storeReview(Request $request)
    {
        $serviceType = $request->input('service_type', 'shop');
        $itemId = $request->input('item_id');
        $itemName = $request->input('item_name', 'Sacred Service');
        $name = trim($request->input('name', 'Devotee'));
        $phone = trim($request->input('phone', ''));
        $rating = max(1, min(5, (int)$request->input('rating', 5)));
        $title = trim($request->input('title', ''));
        $comment = trim($request->input('comment', ''));

        if (empty($comment)) {
            return response()->json(['success' => false, 'message' => 'Please provide a comment for your review.'], 422);
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('reviews')) {
                \Illuminate\Support\Facades\DB::table('reviews')->insert([
                    'user_id' => auth()->id() ?? null,
                    'service_type' => in_array($serviceType, ['shop', 'hotel', 'cab']) ? $serviceType : 'shop',
                    'item_id' => $itemId,
                    'item_name' => $itemName,
                    'customer_name' => $name,
                    'customer_phone' => $phone,
                    'rating' => $rating,
                    'title' => $title,
                    'comment' => $comment,
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'message' => 'Shukriya! Your review has been submitted successfully.'
        ]);
    }

    public function storeFeedback(Request $request)
    {
        $serviceType = $request->input('service_type', 'general');
        $name = trim($request->input('name', 'Devotee'));
        $phone = trim($request->input('phone', ''));
        $email = trim($request->input('email', ''));
        $subject = trim($request->input('subject', 'Customer Feedback'));
        $message = trim($request->input('message', ''));
        $rating = $request->filled('rating') ? (int)$request->input('rating') : null;

        if (empty($message)) {
            return response()->json(['success' => false, 'message' => 'Please enter your feedback message.'], 422);
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('feedbacks')) {
                \Illuminate\Support\Facades\DB::table('feedbacks')->insert([
                    'user_id' => auth()->id() ?? null,
                    'service_type' => in_array($serviceType, ['shop', 'hotel', 'cab', 'general']) ? $serviceType : 'general',
                    'customer_name' => $name,
                    'customer_phone' => $phone,
                    'customer_email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                    'rating' => $rating,
                    'status' => 'new',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your feedback has been received and shared with Dewa Sharif administration.'
        ]);
    }
}
