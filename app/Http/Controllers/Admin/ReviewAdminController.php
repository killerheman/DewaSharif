<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('reviews')->orderBy('created_at', 'desc');

        if ($request->filled('service_type') && $request->service_type !== 'all') {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = '%' . trim($request->search) . '%';
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', $search)
                  ->orWhere('item_name', 'like', $search)
                  ->orWhere('comment', 'like', $search);
            });
        }

        $reviews = $query->get();

        $counts = [
            'total' => DB::table('reviews')->count(),
            'shop' => DB::table('reviews')->where('service_type', 'shop')->count(),
            'hotel' => DB::table('reviews')->where('service_type', 'hotel')->count(),
            'cab' => DB::table('reviews')->where('service_type', 'cab')->count(),
            'approved' => DB::table('reviews')->where('status', 'approved')->count(),
            'pending' => DB::table('reviews')->where('status', 'pending')->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'counts'));
    }

    public function store(Request $request)
    {
        $serviceType = $request->input('service_type', 'shop');
        $itemName = trim($request->input('item_name', 'Sacred Service'));
        $customerName = trim($request->input('customer_name', 'Devotee'));
        $customerPhone = trim($request->input('customer_phone', ''));
        $rating = max(1, min(5, (int)$request->input('rating', 5)));
        $title = trim($request->input('title', ''));
        $comment = trim($request->input('comment', ''));
        $status = $request->input('status', 'approved');

        if (empty($comment)) {
            return back()->with('error', 'Please provide a comment for the review.');
        }

        DB::table('reviews')->insert([
            'user_id' => auth()->id() ?? null,
            'service_type' => in_array($serviceType, ['shop', 'hotel', 'cab']) ? $serviceType : 'shop',
            'item_name' => $itemName,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'rating' => $rating,
            'title' => $title,
            'comment' => $comment,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'New review created successfully!');
    }

    public function update(Request $request, $id)
    {
        $rating = (int)$request->input('rating', 5);
        $comment = trim($request->input('comment'));
        $title = trim($request->input('title'));
        $status = $request->input('status', 'approved');

        DB::table('reviews')->where('id', $id)->update([
            'rating' => $rating,
            'title' => $title,
            'comment' => $comment,
            'status' => $status,
            'updated_at' => now()
        ]);

        return back()->with('success', "Review #{$id} updated successfully!");
    }

    public function toggleStatus($id)
    {
        $review = DB::table('reviews')->where('id', $id)->first();
        if ($review) {
            $newStatus = (strtolower($review->status) === 'approved') ? 'pending' : 'approved';
            DB::table('reviews')->where('id', $id)->update([
                'status' => $newStatus,
                'updated_at' => now()
            ]);
            return back()->with('success', "Review #{$id} status set to " . ucfirst($newStatus) . "!");
        }
        return back()->with('error', "Review not found!");
    }

    public function destroy($id)
    {
        DB::table('reviews')->where('id', $id)->delete();
        return back()->with('success', "Review #{$id} permanently deleted from database!");
    }
}
