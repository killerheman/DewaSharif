<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Helpers\ShopSetting;

class ShopAdminController extends Controller
{
    public function index()
    {
        $shopSettings = ShopSetting::all();
        $dbProducts = DB::table('shop_products')->orderBy('id', 'desc')->get();
        
        $products = [];
        foreach ($dbProducts as $dp) {
            $products[] = [
                'id' => $dp->id,
                'name' => $dp->name,
                'slug' => $dp->slug,
                'category' => $dp->category_slug,
                'category_slug' => $dp->category_slug,
                'price' => (float)$dp->price,
                'mrp' => (float)($dp->mrp ?? ($dp->price * 1.3)),
                'sku' => $dp->sku ?? ('#PRD-' . $dp->id),
                'return_policy' => $dp->return_policy ?? 'non_returnable',
                'is_featured' => (int)($dp->is_featured ?? 0),
                'stock' => (int)$dp->stock_quantity,
                'stock_quantity' => (int)$dp->stock_quantity,
                'volume_ml' => $dp->volume_ml ?? '',
                'size_options' => $dp->size_options ?? '',
                'fabric_material' => $dp->fabric_material ?? '',
                'image' => $dp->thumbnail ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg',
                'thumbnail' => $dp->thumbnail ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg',
                'description' => $dp->description ?? '',
                'rating' => (float)($dp->rating ?? 5.0),
                'reviews_count' => $dp->reviews_count ?? '240+ Niyaz Bookings',
                'status' => $dp->status ?? 'active',
                'handling_fee' => (float)($dp->handling_fee ?? ($shopSettings['default_handling_fee'] ?? 10)),
                'packaging_fee' => (float)($dp->packaging_fee ?? ($shopSettings['default_packaging_fee'] ?? 20)),
                'delivery_fee' => (float)($dp->delivery_fee ?? ($shopSettings['standard_courier_fee'] ?? 40)),
                'same_day_fee_2_4h' => (float)($dp->same_day_fee_2_4h ?? ($shopSettings['express_2_4h_fee'] ?? 35)),
                'local_fee_24h' => (float)($dp->local_fee_24h ?? ($shopSettings['local_24h_fee'] ?? 20)),
                'cod_fee' => (float)($dp->cod_fee ?? ($shopSettings['cod_extra_fee'] ?? 30)),
            ];
        }

        // If any legacy items in DataStore not in DB, append them
        $dsProducts = DataStore::getCollection('products');
        $existingIds = collect($products)->pluck('id')->toArray();
        foreach ($dsProducts as $dsp) {
            $dspId = is_array($dsp) ? ($dsp['id'] ?? null) : $dsp->id;
            if ($dspId && !in_array($dspId, $existingIds)) {
                $pArray = is_array($dsp) ? $dsp : (array)$dsp;
                $pArray['handling_fee'] = (float)($pArray['handling_fee'] ?? ($shopSettings['default_handling_fee'] ?? 10));
                $pArray['packaging_fee'] = (float)($pArray['packaging_fee'] ?? ($shopSettings['default_packaging_fee'] ?? 20));
                $pArray['delivery_fee'] = (float)($pArray['delivery_fee'] ?? ($shopSettings['standard_courier_fee'] ?? 40));
                $pArray['same_day_fee_2_4h'] = (float)($pArray['same_day_fee_2_4h'] ?? ($shopSettings['express_2_4h_fee'] ?? 35));
                $pArray['local_fee_24h'] = (float)($pArray['local_fee_24h'] ?? ($shopSettings['local_24h_fee'] ?? 20));
                $pArray['cod_fee'] = (float)($pArray['cod_fee'] ?? ($shopSettings['cod_extra_fee'] ?? 30));
                $products[] = $pArray;
            }
        }

        $categories = DB::table('shop_categories')->orderBy('order_num', 'asc')->orderBy('name', 'asc')->get();
        if ($categories->isEmpty()) {
            $categories = collect([
                (object)['id' => 1, 'name' => 'Warsi Attar', 'slug' => 'attar', 'status' => 'active'],
                (object)['id' => 2, 'name' => 'Degh Niyaz', 'slug' => 'degh', 'status' => 'active'],
                (object)['id' => 3, 'name' => 'Mitti Bartan', 'slug' => 'clay', 'status' => 'inactive'],
                (object)['id' => 4, 'name' => 'Sufi Clothing', 'slug' => 'clothing', 'status' => 'inactive'],
                (object)['id' => 5, 'name' => 'Mela Toys', 'slug' => 'toys', 'status' => 'inactive'],
                (object)['id' => 6, 'name' => 'Islamic Products', 'slug' => 'islamic', 'status' => 'inactive'],
            ]);
        }
        return view('admin.shop.index', compact('products', 'categories', 'shopSettings'));
    }

    public function storeProduct(Request $request)
    {
        $name = trim($request->input('name', 'New Sacred Product'));
        $cat = $request->input('category', 'attar');
        $price = (float)$request->input('price', 299);
        $mrp = (float)$request->input('mrp', round($price * 1.35));
        $stock = (int)$request->input('stock', 50);
        $volume_ml = trim($request->input('volume_ml', ''));
        $size_options = trim($request->input('size_options', ''));
        $fabric_material = trim($request->input('fabric_material', ''));
        $customImage = trim($request->input('image', ''));
        $desc = trim($request->input('description', 'Handcrafted sacred item with 100% genuine quality.'));

        $shopSettings = ShopSetting::all();
        $handling_fee = $request->filled('handling_fee') ? (float)$request->input('handling_fee') : (float)($shopSettings['default_handling_fee'] ?? 10);
        $packaging_fee = $request->filled('packaging_fee') ? (float)$request->input('packaging_fee') : (float)($shopSettings['default_packaging_fee'] ?? 20);
        $delivery_fee = $request->filled('delivery_fee') ? (float)$request->input('delivery_fee') : (float)($shopSettings['standard_courier_fee'] ?? 40);
        $same_day_fee_2_4h = $request->filled('same_day_fee_2_4h') ? (float)$request->input('same_day_fee_2_4h') : (float)($shopSettings['express_2_4h_fee'] ?? 35);
        $local_fee_24h = $request->filled('local_fee_24h') ? (float)$request->input('local_fee_24h') : (float)($shopSettings['local_24h_fee'] ?? 20);
        $cod_fee = $request->filled('cod_fee') ? (float)$request->input('cod_fee') : (float)($shopSettings['cod_extra_fee'] ?? 30);

        $image = '/home/images/dewasharif/dewapage/attar_bottle.jpg';

        // Check if real file upload provided
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $file = $request->file('image_file');
            $fileName = 'prod_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/shop');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $fileName);
            $image = '/uploads/shop/' . $fileName;
        } elseif (!empty($customImage)) {
            $image = $customImage;
        } elseif ($cat === 'clothing') {
            $image = '/home/images/dewasharif/dewapage/sufi_clothing.jpg';
        } elseif ($cat === 'clay') {
            $image = '/home/images/dewasharif/dewapage/clay_pots.jpg';
        } elseif ($cat === 'toys') {
            $image = '/home/images/dewasharif/dewapage/mela_toys.jpg';
        } elseif ($cat === 'islamic') {
            $image = '/home/images/dewasharif/dewapage/velvet_chadar.jpg';
        } elseif ($cat === 'degh') {
            $lowerName = strtolower($name);
            if (str_contains($lowerName, 'mutton')) {
                $image = '/home/images/dewasharif/dewapage/degh_mutton_biryani.jpg';
            } elseif (str_contains($lowerName, 'chicken')) {
                $image = '/home/images/dewasharif/dewapage/degh_chicken_biryani.jpg';
            } elseif (str_contains($lowerName, 'zarda')) {
                $image = '/home/images/dewasharif/dewapage/degh_zarda_kesari.jpg';
            } elseif (str_contains($lowerName, 'kheer')) {
                $image = '/home/images/dewasharif/dewapage/degh_zafraani_kheer.jpg';
            } else {
                $image = '/home/images/dewasharif/dewapage/degh_mutton_biryani.jpg';
            }
        }

        // Handle discount % (Manual input or auto-calculated from MRP & Price)
        $discount_percent = null;
        if ($request->filled('discount_percent')) {
            $discount_percent = max(0, min(99, (int)$request->input('discount_percent')));
        } elseif ($mrp > $price && $mrp > 0) {
            $discount_percent = (int)round((($mrp - $price) / $mrp) * 100);
        }

        // Process Additional Gallery Images (Up to 5 images total)
        $gallery = [];
        // 1. Multi-file upload batch
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $gFileName = 'gallery_' . time() . '_' . rand(1000, 9999) . '.' . $gFile->getClientOriginalExtension();
                    $destPath = public_path('uploads/shop');
                    if (!file_exists($destPath)) mkdir($destPath, 0755, true);
                    $gFile->move($destPath, $gFileName);
                    $gallery[] = '/uploads/shop/' . $gFileName;
                }
            }
        }
        // 2. Individual slots 2 to 5
        for ($i = 2; $i <= 5; $i++) {
            if ($request->hasFile("gallery_file_{$i}") && $request->file("gallery_file_{$i}")->isValid()) {
                $gFile = $request->file("gallery_file_{$i}");
                $gFileName = 'gallery_' . time() . "_{$i}_" . rand(100, 999) . '.' . $gFile->getClientOriginalExtension();
                $destPath = public_path('uploads/shop');
                if (!file_exists($destPath)) mkdir($destPath, 0755, true);
                $gFile->move($destPath, $gFileName);
                $gallery[] = '/uploads/shop/' . $gFileName;
            } elseif ($request->filled("gallery_url_{$i}")) {
                $gallery[] = trim($request->input("gallery_url_{$i}"));
            }
        }
        $gallery = array_values(array_unique(array_filter($gallery)));
        $galleryJson = !empty($gallery) ? json_encode($gallery) : null;

        $rating = $request->filled('rating') ? (float)$request->input('rating') : 5.0;
        $reviews_count = trim($request->input('reviews_count', ($cat === 'degh' ? '240+ Niyaz Bookings' : '150+ Devotee Reviews')));
        $sku = trim($request->input('sku', '')) ?: ('#PRD-' . strtoupper(substr(md5(time() . rand(10, 99)), 0, 6)));
        $returnPolicy = $request->input('return_policy', 'non_returnable');
        $isFeatured = $request->boolean('is_featured') ? 1 : 0;

        $catObj = DB::table('shop_categories')->where('slug', $cat)->first();
        $catId = $catObj ? $catObj->id : 1;

        $newProdId = DB::table('shop_products')->insertGetId([
            'category_id' => $catId,
            'category_slug' => $cat,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . time(),
            'sku' => $sku,
            'return_policy' => $returnPolicy,
            'is_featured' => $isFeatured,
            'price' => $price,
            'mrp' => $mrp,
            'discount_percent' => $discount_percent,
            'sale_price' => $price,
            'stock_quantity' => $stock,
            'volume_ml' => $volume_ml,
            'size_options' => $size_options,
            'fabric_material' => $fabric_material,
            'thumbnail' => $image,
            'gallery_images' => $galleryJson,
            'description' => $desc,
            'rating' => $rating,
            'reviews_count' => $reviews_count,
            'handling_fee' => $handling_fee,
            'packaging_fee' => $packaging_fee,
            'delivery_fee' => $delivery_fee,
            'same_day_fee_2_4h' => $same_day_fee_2_4h,
            'local_fee_24h' => $local_fee_24h,
            'cod_fee' => $cod_fee,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DataStore::addItem('products', [
            'id' => $newProdId,
            'name' => $name,
            'category' => $cat,
            'price' => $price,
            'mrp' => $mrp,
            'discount_percent' => $discount_percent,
            'sku' => $sku,
            'return_policy' => $returnPolicy,
            'is_featured' => $isFeatured,
            'stock' => $stock,
            'stock_quantity' => $stock,
            'volume_ml' => $volume_ml,
            'size_options' => $size_options,
            'fabric_material' => $fabric_material,
            'image' => $image,
            'gallery_images' => $galleryJson,
            'description' => $desc,
            'rating' => $rating,
            'reviews_count' => $reviews_count,
            'handling_fee' => $handling_fee,
            'packaging_fee' => $packaging_fee,
            'delivery_fee' => $delivery_fee,
            'same_day_fee_2_4h' => $same_day_fee_2_4h,
            'local_fee_24h' => $local_fee_24h,
            'cod_fee' => $cod_fee,
            'status' => 'Active'
        ]);

        return back()->with('success', "Product '{$name}' published successfully to Sacred Store (Active at Top)!");
    }

    public function destroy($id)
    {
        DataStore::deleteItem('products', $id);
        try {
            DB::table('shop_products')->where('id', $id)->delete();
        } catch (\Throwable $e) {}
        return back()->with('success', "Product deleted successfully!");
    }

    public function updateProduct(Request $request, $id)
    {
        $stock = (int)$request->input('stock', 50);
        $data = [
            'name' => trim($request->input('name')),
            'category' => $request->input('category'),
            'sku' => trim($request->input('sku', '')),
            'return_policy' => $request->input('return_policy', 'non_returnable'),
            'is_featured' => $request->boolean('is_featured') ? 1 : 0,
            'price' => (float)$request->input('price'),
            'mrp' => (float)$request->input('mrp'),
            'stock' => $stock,
            'stock_quantity' => $stock,
            'volume_ml' => trim($request->input('volume_ml', '')),
            'size_options' => trim($request->input('size_options', '')),
            'fabric_material' => trim($request->input('fabric_material', '')),
            'description' => trim($request->input('description', '')),
        ];

        if ($request->filled('handling_fee')) {
            $data['handling_fee'] = (float)$request->input('handling_fee');
        }
        if ($request->filled('packaging_fee')) {
            $data['packaging_fee'] = (float)$request->input('packaging_fee');
        }
        if ($request->filled('delivery_fee')) {
            $data['delivery_fee'] = (float)$request->input('delivery_fee');
        }
        if ($request->filled('same_day_fee_2_4h')) {
            $data['same_day_fee_2_4h'] = (float)$request->input('same_day_fee_2_4h');
        }
        if ($request->filled('local_fee_24h')) {
            $data['local_fee_24h'] = (float)$request->input('local_fee_24h');
        }
        if ($request->filled('cod_fee')) {
            $data['cod_fee'] = (float)$request->input('cod_fee');
        }

        if ($request->filled('rating')) {
            $data['rating'] = (float)$request->input('rating');
        }
        if ($request->filled('reviews_count')) {
            $data['reviews_count'] = trim($request->input('reviews_count'));
        }

        if ($request->filled('discount_percent')) {
            $data['discount_percent'] = max(0, min(99, (int)$request->input('discount_percent')));
        } elseif (isset($data['mrp']) && isset($data['price']) && $data['mrp'] > $data['price'] && $data['mrp'] > 0) {
            $data['discount_percent'] = (int)round((($data['mrp'] - $data['price']) / $data['mrp']) * 100);
        }

        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $file = $request->file('image_file');
            $fileName = 'prod_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/shop');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $fileName);
            $data['image'] = '/uploads/shop/' . $fileName;
        } elseif ($request->filled('image')) {
            $data['image'] = trim($request->input('image'));
        }

        // Process Additional Gallery Images (Up to 5 images total)
        $existingProd = DB::table('shop_products')->where('id', $id)->first();
        $existingGallery = [];
        if ($existingProd && !empty($existingProd->gallery_images)) {
            $existingGallery = is_array($existingProd->gallery_images) ? $existingProd->gallery_images : (json_decode($existingProd->gallery_images, true) ?: []);
        }

        $gallery = [];
        // 1. Multi-file upload batch
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $gFileName = 'gallery_' . time() . '_' . rand(1000, 9999) . '.' . $gFile->getClientOriginalExtension();
                    $destPath = public_path('uploads/shop');
                    if (!file_exists($destPath)) mkdir($destPath, 0755, true);
                    $gFile->move($destPath, $gFileName);
                    $gallery[] = '/uploads/shop/' . $gFileName;
                }
            }
        }
        // 2. Individual slots 2 to 5
        for ($i = 2; $i <= 5; $i++) {
            if ($request->hasFile("gallery_file_{$i}") && $request->file("gallery_file_{$i}")->isValid()) {
                $gFile = $request->file("gallery_file_{$i}");
                $gFileName = 'gallery_' . time() . "_{$i}_" . rand(100, 999) . '.' . $gFile->getClientOriginalExtension();
                $destPath = public_path('uploads/shop');
                if (!file_exists($destPath)) mkdir($destPath, 0755, true);
                $gFile->move($destPath, $gFileName);
                $gallery[] = '/uploads/shop/' . $gFileName;
            } elseif ($request->filled("gallery_url_{$i}")) {
                $gallery[] = trim($request->input("gallery_url_{$i}"));
            } elseif (isset($existingGallery[$i - 2])) {
                $gallery[] = $existingGallery[$i - 2];
            }
        }
        $gallery = array_values(array_unique(array_filter($gallery)));
        $data['gallery_images'] = !empty($gallery) ? json_encode($gallery) : null;

        DataStore::updateItem('products', $id, $data);

        try {
            $catObj = DB::table('shop_categories')->where('slug', $data['category'])->first();
            $catId = $catObj ? $catObj->id : 1;
            $dbData = [
                'name' => $data['name'],
                'category_id' => $catId,
                'category_slug' => $data['category'],
                'sku' => $data['sku'],
                'return_policy' => $data['return_policy'],
                'is_featured' => $data['is_featured'],
                'price' => $data['price'],
                'mrp' => $data['mrp'],
                'sale_price' => $data['price'],
                'stock_quantity' => $stock,
                'volume_ml' => $data['volume_ml'],
                'size_options' => $data['size_options'],
                'fabric_material' => $data['fabric_material'],
                'description' => $data['description'],
                'updated_at' => now()
            ];
            if (isset($data['discount_percent'])) $dbData['discount_percent'] = $data['discount_percent'];
            if (isset($data['gallery_images'])) $dbData['gallery_images'] = $data['gallery_images'];
            if (isset($data['handling_fee'])) $dbData['handling_fee'] = $data['handling_fee'];
            if (isset($data['packaging_fee'])) $dbData['packaging_fee'] = $data['packaging_fee'];
            if (isset($data['delivery_fee'])) $dbData['delivery_fee'] = $data['delivery_fee'];
            if (isset($data['same_day_fee_2_4h'])) $dbData['same_day_fee_2_4h'] = $data['same_day_fee_2_4h'];
            if (isset($data['local_fee_24h'])) $dbData['local_fee_24h'] = $data['local_fee_24h'];
            if (isset($data['cod_fee'])) $dbData['cod_fee'] = $data['cod_fee'];

            if (isset($data['rating'])) {
                $dbData['rating'] = $data['rating'];
            }
            if (isset($data['reviews_count'])) {
                $dbData['reviews_count'] = $data['reviews_count'];
            }
            if (isset($data['image'])) {
                $dbData['thumbnail'] = $data['image'];
            }
            DB::table('shop_products')->where('id', $id)->update($dbData);
        } catch (\Throwable $e) {}

        return back()->with('success', "Product updated successfully!");
    }

    public function updateSettings(Request $request)
    {
        $settings = [
            'express_2_4h_fee' => (float)$request->input('express_2_4h_fee', 35),
            'local_24h_fee' => (float)$request->input('local_24h_fee', 20),
            'standard_courier_fee' => (float)$request->input('standard_courier_fee', 40),
            'default_handling_fee' => (float)$request->input('default_handling_fee', 10),
            'default_packaging_fee' => (float)$request->input('default_packaging_fee', 20),
            'cod_extra_fee' => (float)$request->input('cod_extra_fee', 30),
            'free_delivery_threshold' => (float)$request->input('free_delivery_threshold', 999),
        ];

        ShopSetting::updateMany($settings);

        return back()->with('success', 'Global Shop Delivery & Fee Settings Updated Successfully!');
    }

    public function toggleStatus($id)
    {
        $products = DataStore::getCollection('products');
        $current = 'Active';
        foreach ($products as $p) {
            $pId = is_array($p) ? ($p['id'] ?? null) : $p->id;
            if ($pId == $id) {
                $current = is_array($p) ? ($p['status'] ?? 'Active') : ($p->status ?? 'Active');
                break;
            }
        }
        $newStatus = (strtolower($current) === 'active') ? 'Inactive' : 'Active';
        DataStore::updateItem('products', $id, ['status' => $newStatus]);
        try {
            DB::table('shop_products')->where('id', $id)->update(['status' => strtolower($newStatus)]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Product status updated to " . ucfirst($newStatus) . "!");
    }

    public function orders()
    {
        $orders = DB::table('shop_orders')->orderBy('id', 'desc')->get();
        if ($orders->isEmpty()) {
            $orders = DataStore::getCollection('shop_orders');
        }

        $availableProducts = DB::table('shop_products')->where('status', 'active')->orderBy('id', 'desc')->get();
        if ($availableProducts->isEmpty()) {
            $rawP = DataStore::getCollection('products');
            $availableProducts = collect($rawP);
        }

        return view('admin.shop.orders', compact('orders', 'availableProducts'));
    }

    public function storeCustomOrder(Request $request)
    {
        $custName = trim($request->input('customer_name', 'Devotee Customer'));
        $custPhone = trim($request->input('customer_phone', '9648777223'));
        $altPhone = trim($request->input('alternate_phone', ''));
        $address = trim($request->input('shipping_address', 'Dewa Sharif, Barabanki, UP - 225301'));
        $itemsSummary = trim($request->input('items_summary', 'Warsi Chicken Biryani (Light Premium)'));
        $isDegh = $request->boolean('is_degh') ? 1 : (str_contains(strtolower($itemsSummary), 'degh') || str_contains(strtolower($itemsSummary), 'biryani') || str_contains(strtolower($itemsSummary), 'zarda') || str_contains(strtolower($itemsSummary), 'kheer') ? 1 : 0);
        $fatehaName = trim($request->input('fateha_name', ''));
        $rawNiyazDate = trim($request->input('niyaz_date', ''));
        if (!empty($rawNiyazDate)) {
            try {
                $niyazDate = \Carbon\Carbon::parse($rawNiyazDate)->format('d M Y, h:i A');
            } catch (\Throwable $e) {
                $niyazDate = $rawNiyazDate;
            }
        } else {
            $niyazDate = \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y, h:i A');
        }
        $distributionType = trim($request->input('distribution_type', 'Direct Handover / Self Collection at Dewa Sharif'));
        $distributionFee = (float)$request->input('distribution_fee', 0);

        $totalAmount = (float)$request->input('total_amount', 0);
        $paidAmount = (float)$request->input('paid_amount', 0);

        // Respect admin's explicit choice (pending, partial, paid, failed)
        $rawPayStatus = strtolower(trim($request->input('payment_status', 'pending')));
        if (!in_array($rawPayStatus, ['pending', 'partial', 'paid', 'failed'])) {
            $rawPayStatus = 'pending';
        }
        if ($rawPayStatus === 'paid' && $paidAmount <= 0 && $totalAmount > 0) {
            $paidAmount = $totalAmount;
        }

        $paymentMode = trim($request->input('payment_mode', 'SBI UPI / PhonePe QR'));
        $utrNumber = trim($request->input('utr_number', ''));
        $paymentId = !empty($utrNumber) ? ('SBI_UPI_' . $utrNumber) : ($paymentMode . ' (' . ($rawPayStatus === 'partial' ? "₹{$paidAmount} Adv" : ($rawPayStatus === 'paid' ? 'Full Paid' : 'Verification Pending')) . ')');

        $orderStatus = trim($request->input('order_status', 'processing'));
        $courierName = trim($request->input('courier_name', $isDegh ? 'Dargah Langar Distribution / Special Delivery' : 'DTDC Express'));
        $trackingNumber = trim($request->input('tracking_number', ($isDegh ? 'DGH-' : 'DT') . rand(10000000, 99999999) . 'IN'));

        $randCode = ($isDegh ? 'DWS-DGH-' : 'DWS-SHP-') . date('Y') . '-' . rand(1000, 9999);
        $packagingType = trim($request->input('packaging_type', 'none'));
        $packagingFee = (float)$request->input('packaging_fee', 0);
        if ($packagingType === 'complimentary' || $packagingType === 'none') {
            $packagingFee = 0.00;
        }

        $orderData = [
            'order_id' => $randCode,
            'customer_name' => $custName,
            'customer_phone' => $custPhone,
            'customer_whatsapp' => $custPhone,
            'alternate_phone' => $altPhone,
            'shipping_address' => $address,
            'items_summary' => $itemsSummary,
            'cart_items_json' => json_encode([
                [
                    'name' => $itemsSummary,
                    'price' => $totalAmount,
                    'qty' => 1
                ]
            ]),
            'subtotal' => $totalAmount,
            'handling_fee' => 0.00,
            'packaging_fee' => $packagingFee,
            'packaging_type' => $packagingType,
            'distribution_fee' => $distributionFee,
            'delivery_fee' => 0.00,
            'cod_fee' => 0.00,
            'delivery_tier' => 'standard_courier',
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'payment_id' => $paymentId,
            'payment_mode' => $paymentMode,
            'payment_status' => $rawPayStatus,
            'order_status' => $orderStatus,
            'fateha_name' => $fatehaName,
            'niyaz_date' => $niyazDate,
            'distribution_type' => $distributionType,
            'is_degh' => $isDegh,
            'courier_name' => $courierName,
            'tracking_number' => $trackingNumber,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $newId = DB::table('shop_orders')->insertGetId($orderData);
        $orderData['id'] = $newId;
        DataStore::addItem('shop_orders', $orderData);

        return back()->with('success', "Custom " . ($isDegh ? "Degh Niyaz" : "Store") . " Order #{$randCode} created successfully! You can now view and download the invoice.");
    }

    public function updateOrder(Request $request, $id)
    {
        $custName = trim($request->input('customer_name', 'Customer'));
        $custPhone = trim($request->input('customer_phone', ''));
        $altPhone = trim($request->input('alternate_phone', ''));
        $address = trim($request->input('shipping_address', ''));
        $itemsSummary = trim($request->input('items_summary', 'Sacred Store Offering'));
        $isDegh = $request->boolean('is_degh') ? 1 : 0;
        $fatehaName = trim($request->input('fateha_name', ''));
        $rawNiyazDate = trim($request->input('niyaz_date', ''));
        if (!empty($rawNiyazDate)) {
            try {
                $niyazDate = \Carbon\Carbon::parse($rawNiyazDate)->format('d M Y, h:i A');
            } catch (\Throwable $e) {
                $niyazDate = $rawNiyazDate;
            }
        } else {
            $niyazDate = \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y, h:i A');
        }
        $distributionType = trim($request->input('distribution_type', ''));
        $distributionFee = (float)$request->input('distribution_fee', 0);

        $packagingType = trim($request->input('packaging_type', 'none'));
        $packagingFee = (float)$request->input('packaging_fee', 0);
        if ($packagingType === 'complimentary' || $packagingType === 'none') {
            $packagingFee = 0.00;
        }

        $totalAmount = (float)$request->input('total_amount', 0);
        $paidAmount = (float)$request->input('paid_amount', 0);

        // Respect admin's explicit choice (pending, partial, paid, failed)
        $rawPayStatus = strtolower(trim($request->input('payment_status', 'pending')));
        if (!in_array($rawPayStatus, ['pending', 'partial', 'paid', 'failed'])) {
            $rawPayStatus = 'pending';
        }
        if ($rawPayStatus === 'paid' && $paidAmount > 0 && $paidAmount < $totalAmount) {
            $rawPayStatus = 'partial';
        } elseif ($rawPayStatus === 'paid' && $paidAmount <= 0 && $totalAmount > 0) {
            $paidAmount = $totalAmount;
        } elseif ($rawPayStatus === 'partial' && $paidAmount >= $totalAmount && $totalAmount > 0) {
            $rawPayStatus = 'paid';
        }

        $paymentMode = trim($request->input('payment_mode', 'SBI UPI / PhonePe QR'));
        $utrNumber = trim($request->input('utr_number', ''));
        $paymentId = !empty($utrNumber) ? ('SBI_UPI_' . $utrNumber) : ($paymentMode . ' (' . ($rawPayStatus === 'partial' ? "₹{$paidAmount} Adv" : ($rawPayStatus === 'paid' ? 'Full Paid' : 'Verification Pending')) . ')');

        $orderStatus = trim($request->input('order_status', 'processing'));
        $courierName = trim($request->input('courier_name', ''));
        $trackingNumber = trim($request->input('tracking_number', ''));

        $updateData = [
            'customer_name' => $custName,
            'customer_phone' => $custPhone,
            'alternate_phone' => $altPhone,
            'shipping_address' => $address,
            'items_summary' => $itemsSummary,
            'cart_items_json' => json_encode([
                [
                    'name' => $itemsSummary,
                    'price' => $totalAmount,
                    'qty' => 1
                ]
            ]),
            'packaging_fee' => $packagingFee,
            'packaging_type' => $packagingType,
            'distribution_fee' => $distributionFee,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'payment_id' => $paymentId,
            'payment_mode' => $paymentMode,
            'payment_status' => $rawPayStatus,
            'order_status' => $orderStatus,
            'fateha_name' => $fatehaName,
            'niyaz_date' => $niyazDate,
            'distribution_type' => $distributionType,
            'is_degh' => $isDegh,
            'updated_at' => now()
        ];

        if (!empty($courierName)) $updateData['courier_name'] = $courierName;
        if (!empty($trackingNumber)) $updateData['tracking_number'] = $trackingNumber;

        try {
            if (is_numeric($id)) {
                DB::table('shop_orders')->where('id', (int)$id)->update($updateData);
            } else {
                DB::table('shop_orders')->where('order_id', (string)$id)->update($updateData);
            }
        } catch (\Throwable $e) {}

        DataStore::updateItem('shop_orders', $id, $updateData);

        return back()->with('success', "Order #{$id} updated successfully! Invoice and WhatsApp links refreshed.");
    }

    public function dispatchOrder(Request $request, $id)
    {
        $courier = trim($request->input('courier_name', 'DTDC Express'));
        $tracking = trim($request->input('tracking_number', 'DT123456789IN'));
        $notes = trim($request->input('dispatch_notes', ''));
        $status = trim($request->input('status', 'Dispatched'));

        DataStore::updateItem('shop_orders', $id, [
            'courier' => $courier,
            'tracking' => $tracking,
            'dispatch_notes' => $notes,
            'status' => $status
        ]);

        try {
            $q = DB::table('shop_orders');
            if (is_numeric($id)) {
                $q->where('id', (int)$id);
            } else {
                $q->where('order_id', (string)$id);
            }
            $q->update([
                'courier_name' => $courier,
                'tracking_number' => $tracking,
                'order_status' => strtolower($status) === 'dispatched' ? 'shipped' : strtolower($status),
                'dispatched_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Order #{$id} marked as {$status} via {$courier} (Tracking / Ref: {$tracking})!");
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $status = trim($request->input('status', 'Processing'));
        DataStore::updateItem('shop_orders', $id, ['status' => $status]);
        try {
            $dbStatus = strtolower($status);
            if ($dbStatus === 'dispatched') $dbStatus = 'shipped';
            $q = DB::table('shop_orders');
            if (is_numeric($id)) {
                $q->where('id', (int)$id);
            } else {
                $q->where('order_id', (string)$id);
            }
            $q->update([
                'order_status' => $dbStatus,
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}
        return back()->with('success', "Order #{$id} status updated to {$status}!");
    }

    public function togglePaymentStatus($id)
    {
        $orders = DataStore::getCollection('shop_orders');
        $current = 'Pending (COD)';
        foreach ($orders as $o) {
            $oId = is_array($o) ? ($o['id'] ?? null) : ($o->id ?? null);
            if ((string)$oId === (string)$id) {
                $payMethod = is_array($o) ? ($o['payment_method'] ?? 'COD') : ($o->payment_method ?? 'COD');
                $current = is_array($o) ? ($o['payment_status'] ?? ($payMethod === 'Razorpay Online' ? 'Paid' : 'Pending (COD)')) : ($o->payment_status ?? 'Pending (COD)');
                break;
            }
        }
        $newPayment = (strtolower($current) === 'paid') ? 'Pending (COD)' : 'Paid';
        DataStore::updateItem('shop_orders', $id, ['payment_status' => $newPayment]);
        try {
            $q = DB::table('shop_orders');
            if (is_numeric($id)) {
                $q->where('id', (int)$id);
            } else {
                $q->where('order_id', (string)$id);
            }
            $q->update([
                'payment_status' => strtolower($newPayment) === 'paid' ? 'paid' : 'pending',
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Order #{$id} payment status toggled to {$newPayment}!");
    }

    public function approveOrder($id)
    {
        $order = null;
        try {
            $q = DB::table('shop_orders');
            if (is_numeric($id)) {
                $dbO = $q->where('id', (int)$id)->first();
            } else {
                $dbO = $q->where('order_id', (string)$id)->first();
            }
            if ($dbO) $order = (array)$dbO;
        } catch (\Throwable $e) {}

        if (!$order) {
            $orders = DataStore::getCollection('shop_orders');
            foreach ($orders as $o) {
                $oId = is_array($o) ? ($o['id'] ?? null) : ($o->id ?? null);
                if ((string)$oId === (string)$id) {
                    $order = $o;
                    break;
                }
            }
        }

        $totalAmt = (float)(is_array($order) ? ($order['total_amount'] ?? ($order['amount'] ?? 0)) : ($order->total_amount ?? ($order->amount ?? 0)));
        $currPaid = (float)(is_array($order) ? ($order['paid_amount'] ?? 0) : ($order->paid_amount ?? 0));

        // If order already has partial advance (e.g. 3707 out of 4707), keep advance and mark partial verified!
        $isPartial = ($currPaid > 0 && $currPaid < $totalAmt);
        $newPayStatus = $isPartial ? 'partial' : 'paid';
        $finalPaid = $isPartial ? $currPaid : ($totalAmt > 0 ? $totalAmt : $currPaid);
        $statusMsg = $isPartial ? 'Advance Payment Verified & Confirmed' : 'Payment Verified & Confirmed';

        $updateData = [
            'payment_status' => $newPayStatus,
            'paid_amount' => $finalPaid,
            'status' => $statusMsg,
            'order_status' => 'processing',
        ];

        DataStore::updateItem('shop_orders', $id, $updateData);
        try {
            $q = DB::table('shop_orders');
            if (is_numeric($id)) {
                $q->where('id', (int)$id);
            } else {
                $q->where('order_id', (string)$id);
            }
            $q->update([
                'payment_status' => $newPayStatus,
                'paid_amount' => $finalPaid,
                'order_status' => 'processing',
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}

        $advNotice = $isPartial ? " (Advance of ₹" . number_format($finalPaid, 2) . " verified, ₹" . number_format(max(0, $totalAmt - $finalPaid), 2) . " balance due)" : "";
        return back()->with('success', "Sacred Store Order #{$id} payment has been APPROVED & Verified!{$advNotice} Receipt updated.");
    }

    public function rejectOrder($id)
    {
        $updateData = [
            'payment_status' => 'failed',
            'paid_amount' => 0,
            'status' => 'Payment Failed',
        ];

        DataStore::updateItem('shop_orders', $id, $updateData);
        try {
            $q = DB::table('shop_orders');
            if (is_numeric($id)) {
                $q->where('id', (int)$id);
            } else {
                $q->where('order_id', (string)$id);
            }
            $q->update([
                'payment_status' => 'failed',
                'paid_amount' => 0,
                'order_status' => 'cancelled',
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Sacred Store Order #{$id} payment REJECTED as Uncredited/Fake UTR. Order is now VOID & CANCELLED.");
    }

    public function destroyOrder($id)
    {
        DataStore::deleteItem('shop_orders', $id);
        try {
            $q = DB::table('shop_orders');
            if (is_numeric($id)) {
                $q->where('id', (int)$id);
            } else {
                $q->where('order_id', (string)$id);
            }
            $q->delete();
        } catch (\Throwable $e) {}
        return back()->with('success', "Order #{$id} deleted successfully!");
    }

    /*
    |--------------------------------------------------------------------------
    | SHOP CATEGORIES CRUD
    |--------------------------------------------------------------------------
    */
    public function categories()
    {
        $categories = DB::table('shop_categories')->orderBy('order_num', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.shop.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $name = trim($request->input('name'));
        $slug = trim($request->input('slug')) ?: Str::slug($name);
        $status = $request->input('status', 'active');
        $themeColor = trim($request->input('theme_color', '#10b981')) ?: '#10b981';
        $badgeText = trim($request->input('badge_text', '⭐ FEATURED CATEGORY'));
        $tagText = trim($request->input('tag_text', 'Verified Store'));
        $description = trim($request->input('description', 'Authentic products direct from Dewa Sharif.'));
        $features = trim($request->input('features', "✔ 100% Genuine Quality\n✔ Doorstep Fast Delivery\n✔ Verified Local Craftsmen"));
        $buttonText = trim($request->input('button_text', "Explore {$name} →"));
        $orderNum = (float)$request->input('order_num', 99);
        $image = '/home/images/dewasharif/dewapage/attar_bottle.jpg';

        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $file = $request->file('image_file');
            $fileName = 'cat_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/shop/categories');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $fileName);
            $image = '/uploads/shop/categories/' . $fileName;
        } elseif ($request->filled('image')) {
            $image = trim($request->input('image'));
        }

        DB::table('shop_categories')->insert([
            'name' => $name,
            'slug' => $slug,
            'image' => $image,
            'theme_color' => $themeColor,
            'badge_text' => $badgeText,
            'tag_text' => $tagText,
            'description' => $description,
            'features' => $features,
            'button_text' => $buttonText,
            'order_num' => $orderNum,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', "Category '{$name}' created successfully!");
    }

    public function updateCategory(Request $request, $id)
    {
        $name = trim($request->input('name'));
        $slug = trim($request->input('slug')) ?: Str::slug($name);
        $status = $request->input('status', 'active');
        $themeColor = trim($request->input('theme_color', '#10b981')) ?: '#10b981';
        $badgeText = trim($request->input('badge_text', '⭐ FEATURED CATEGORY'));
        $tagText = trim($request->input('tag_text', 'Verified Store'));
        $description = trim($request->input('description', ''));
        $features = trim($request->input('features', ''));
        $buttonText = trim($request->input('button_text', "Explore {$name} →"));
        $orderNum = (float)$request->input('order_num', 99);

        $data = [
            'name' => $name,
            'slug' => $slug,
            'theme_color' => $themeColor,
            'badge_text' => $badgeText,
            'tag_text' => $tagText,
            'description' => $description,
            'features' => $features,
            'button_text' => $buttonText,
            'order_num' => $orderNum,
            'status' => $status,
            'updated_at' => now()
        ];

        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $file = $request->file('image_file');
            $fileName = 'cat_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('uploads/shop/categories');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $fileName);
            $data['image'] = '/uploads/shop/categories/' . $fileName;
        } elseif ($request->filled('image')) {
            $data['image'] = trim($request->input('image'));
        }

        DB::table('shop_categories')->where('id', $id)->update($data);

        return back()->with('success', "Category updated successfully!");
    }

    public function toggleCategory($id)
    {
        $cat = DB::table('shop_categories')->where('id', $id)->first();
        if ($cat) {
            $newStatus = (strtolower($cat->status) === 'active') ? 'inactive' : 'active';
            DB::table('shop_categories')->where('id', $id)->update([
                'status' => $newStatus,
                'updated_at' => now()
            ]);
            return back()->with('success', "Category status changed to " . ucfirst($newStatus) . "!");
        }
        return back()->with('error', "Category not found!");
    }

    public function destroyCategory($id)
    {
        DB::table('shop_categories')->where('id', $id)->delete();
        return back()->with('success', "Category deleted successfully!");
    }
}
