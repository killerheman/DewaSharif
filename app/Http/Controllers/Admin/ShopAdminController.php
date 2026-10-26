<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopAdminController extends Controller
{
    public function index()
    {
        $products = DataStore::getCollection('products');
        $dbProducts = DB::table('shop_products')->get()->keyBy('id');
        foreach ($products as &$p) {
            $pId = is_array($p) ? ($p['id'] ?? null) : $p->id;
            if ($pId && isset($dbProducts[$pId])) {
                $dbItem = $dbProducts[$pId];
                if (is_array($p)) {
                    $p['stock_quantity'] = (int)$dbItem->stock_quantity;
                    $p['stock'] = (int)$dbItem->stock_quantity;
                    $p['sku'] = $dbItem->sku ?? ($p['sku'] ?? null);
                    $p['return_policy'] = $dbItem->return_policy ?? ($p['return_policy'] ?? 'non_returnable');
                    $p['is_featured'] = (int)($dbItem->is_featured ?? ($p['is_featured'] ?? 0));
                    $p['status'] = $dbItem->status ?? ($p['status'] ?? 'active');
                    if (isset($dbItem->price) && (float)$dbItem->price > 0) $p['price'] = (float)$dbItem->price;
                    if (isset($dbItem->mrp) && (float)$dbItem->mrp > 0) $p['mrp'] = (float)$dbItem->mrp;
                    if (!empty($dbItem->name)) $p['name'] = $dbItem->name;
                    if (!empty($dbItem->thumbnail)) $p['image'] = $dbItem->thumbnail;
                    if (!empty($dbItem->description)) $p['description'] = $dbItem->description;
                    if (!empty($dbItem->volume_ml)) $p['volume_ml'] = $dbItem->volume_ml;
                    if (!empty($dbItem->fabric_material)) $p['fabric_material'] = $dbItem->fabric_material;
                    if (!empty($dbItem->size_options)) $p['size_options'] = $dbItem->size_options;
                } else {
                    $p->stock_quantity = (int)$dbItem->stock_quantity;
                    $p->stock = (int)$dbItem->stock_quantity;
                    $p->sku = $dbItem->sku ?? ($p->sku ?? null);
                    $p->return_policy = $dbItem->return_policy ?? ($p->return_policy ?? 'non_returnable');
                    $p->is_featured = (int)($dbItem->is_featured ?? ($p->is_featured ?? 0));
                    $p->status = $dbItem->status ?? ($p->status ?? 'active');
                    if (isset($dbItem->price) && (float)$dbItem->price > 0) $p->price = (float)$dbItem->price;
                    if (isset($dbItem->mrp) && (float)$dbItem->mrp > 0) $p->mrp = (float)$dbItem->mrp;
                    if (!empty($dbItem->name)) $p->name = $dbItem->name;
                    if (!empty($dbItem->thumbnail)) $p->image = $dbItem->thumbnail;
                    if (!empty($dbItem->description)) $p->description = $dbItem->description;
                    if (!empty($dbItem->volume_ml)) $p->volume_ml = $dbItem->volume_ml;
                    if (!empty($dbItem->fabric_material)) $p->fabric_material = $dbItem->fabric_material;
                    if (!empty($dbItem->size_options)) $p->size_options = $dbItem->size_options;
                }
            } else {
                $s = (int)(is_array($p) ? ($p['stock_quantity'] ?? ($p['stock'] ?? 50)) : ($p->stock_quantity ?? ($p->stock ?? 50)));
                if (is_array($p)) {
                    $p['stock_quantity'] = $s;
                    $p['stock'] = $s;
                    $p['return_policy'] = $p['return_policy'] ?? 'non_returnable';
                    $p['is_featured'] = (int)($p['is_featured'] ?? 0);
                } else {
                    $p->stock_quantity = $s;
                    $p->stock = $s;
                    $p->return_policy = $p->return_policy ?? 'non_returnable';
                    $p->is_featured = (int)($p->is_featured ?? 0);
                }
            }
        }
        unset($p);

        $categories = DB::table('shop_categories')->orderBy('order_num', 'asc')->orderBy('name', 'asc')->get();
        if ($categories->isEmpty()) {
            $categories = collect([
                (object)['id' => 1, 'name' => 'Warsi Attar', 'slug' => 'attar'],
                (object)['id' => 2, 'name' => 'Degh Niyaz', 'slug' => 'degh'],
                (object)['id' => 3, 'name' => 'Mitti Bartan', 'slug' => 'clay'],
                (object)['id' => 4, 'name' => 'Sufi Clothing', 'slug' => 'clothing'],
                (object)['id' => 5, 'name' => 'Mela Toys', 'slug' => 'toys'],
                (object)['id' => 6, 'name' => 'Islamic Products', 'slug' => 'islamic'],
            ]);
        }
        return view('admin.shop.index', compact('products', 'categories'));
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

        $rating = $request->filled('rating') ? (float)$request->input('rating') : 5.0;
        $reviews_count = trim($request->input('reviews_count', ($cat === 'degh' ? '240+ Niyaz Bookings' : '150+ Devotee Reviews')));
        $sku = trim($request->input('sku', '')) ?: ('#PRD-' . strtoupper(substr(md5(time() . rand(10, 99)), 0, 6)));
        $returnPolicy = $request->input('return_policy', 'non_returnable');
        $isFeatured = $request->boolean('is_featured') ? 1 : 0;

        $savedItem = DataStore::addItem('products', [
            'name' => $name,
            'category' => $cat,
            'price' => $price,
            'mrp' => $mrp,
            'sku' => $sku,
            'return_policy' => $returnPolicy,
            'is_featured' => $isFeatured,
            'stock' => $stock,
            'stock_quantity' => $stock,
            'volume_ml' => $volume_ml,
            'size_options' => $size_options,
            'fabric_material' => $fabric_material,
            'image' => $image,
            'description' => $desc,
            'rating' => $rating,
            'reviews_count' => $reviews_count,
            'status' => 'Active'
        ]);

        try {
            $catObj = DB::table('shop_categories')->where('slug', $cat)->first();
            $catId = $catObj ? $catObj->id : 1;
            DB::table('shop_products')->insert([
                'id' => $savedItem['id'] ?? null,
                'category_id' => $catId,
                'category_slug' => $cat,
                'name' => $name,
                'slug' => Str::slug($name) . '-' . ($savedItem['id'] ?? time()),
                'sku' => $sku,
                'return_policy' => $returnPolicy,
                'is_featured' => $isFeatured,
                'price' => $price,
                'mrp' => $mrp,
                'sale_price' => $price,
                'stock_quantity' => $stock,
                'volume_ml' => $volume_ml,
                'size_options' => $size_options,
                'fabric_material' => $fabric_material,
                'thumbnail' => $image,
                'description' => $desc,
                'rating' => $rating,
                'reviews_count' => $reviews_count,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Product '{$name}' published successfully to Sacred Store!");
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

        if ($request->filled('rating')) {
            $data['rating'] = (float)$request->input('rating');
        }
        if ($request->filled('reviews_count')) {
            $data['reviews_count'] = trim($request->input('reviews_count'));
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
        $orders = DataStore::getCollection('shop_orders');
        return view('admin.shop.orders', compact('orders'));
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
            DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->update([
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
            DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->update([
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
            DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->update([
                'payment_status' => strtolower($newPayment) === 'paid' ? 'paid' : 'pending',
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Order #{$id} payment status toggled to {$newPayment}!");
    }

    public function approveOrder($id)
    {
        $orders = DataStore::getCollection('shop_orders');
        $order = null;
        foreach ($orders as $o) {
            $oId = is_array($o) ? ($o['id'] ?? null) : ($o->id ?? null);
            if ((string)$oId === (string)$id) {
                $order = $o;
                break;
            }
        }

        $amount = (float)(is_array($order) ? ($order['total_amount'] ?? ($order['amount'] ?? 0)) : ($order->total_amount ?? ($order->amount ?? 0)));

        $updateData = [
            'payment_status' => 'paid',
            'paid_amount' => $amount,
            'status' => 'Payment Verified & Confirmed',
        ];

        DataStore::updateItem('shop_orders', $id, $updateData);
        try {
            DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->update([
                'payment_status' => 'paid',
                'order_status' => 'processing',
                'updated_at' => now()
            ]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Sacred Store Order #{$id} payment has been APPROVED & Verified! Receipt updated to PAID.");
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
            DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->update([
                'payment_status' => 'failed',
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
            DB::table('shop_orders')->where('id', $id)->orWhere('order_id', $id)->delete();
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
