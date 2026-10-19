<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('feedbacks')->orderBy('created_at', 'desc');

        if ($request->filled('service_type') && $request->service_type !== 'all') {
            $query->where('service_type', $request->service_type);
        }

        if ($request->filled('search')) {
            $search = '%' . trim($request->search) . '%';
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', $search)
                  ->orWhere('customer_phone', 'like', $search)
                  ->orWhere('message', 'like', $search)
                  ->orWhere('subject', 'like', $search);
            });
        }

        $feedbacks = $query->get();

        $counts = [
            'total' => DB::table('feedbacks')->count(),
            'shop' => DB::table('feedbacks')->where('service_type', 'shop')->count(),
            'hotel' => DB::table('feedbacks')->where('service_type', 'hotel')->count(),
            'cab' => DB::table('feedbacks')->where('service_type', 'cab')->count(),
            'general' => DB::table('feedbacks')->where('service_type', 'general')->count(),
        ];

        return view('admin.feedbacks.index', compact('feedbacks', 'counts'));
    }

    public function toggleStatus($id)
    {
        $fb = DB::table('feedbacks')->where('id', $id)->first();
        if ($fb) {
            $newStatus = ($fb->status === 'resolved' || $fb->status === 'reviewed') ? 'pending' : 'resolved';
            DB::table('feedbacks')->where('id', $id)->update([
                'status' => $newStatus,
                'updated_at' => now()
            ]);
            return back()->with('success', "Feedback status updated to " . ucfirst($newStatus) . "!");
        }
        return back()->with('error', "Feedback not found");
    }

    public function destroy($id)
    {
        DB::table('feedbacks')->where('id', $id)->delete();
        return back()->with('success', "Customer feedback deleted successfully!");
    }
}
