<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreeEmailRequest;
use Illuminate\Http\Request;

class FreeEmailRequestController extends Controller
{
    public function index(Request $request)
    {
        $status   = $request->get('status', 'all');
        $query    = FreeEmailRequest::with('user')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $requests = $query->paginate(15);
        $counts   = [
            'all'      => FreeEmailRequest::count(),
            'pending'  => FreeEmailRequest::where('status', 'pending')->count(),
            'approved' => FreeEmailRequest::where('status', 'approved')->count(),
            'rejected' => FreeEmailRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.free-email-requests.index', compact('requests', 'counts', 'status'));
    }

    public function show(FreeEmailRequest $freeEmailRequest)
    {
        $freeEmailRequest->load('user');
        return view('admin.free-email-requests.show', compact('freeEmailRequest'));
    }

    public function approve(Request $request, FreeEmailRequest $freeEmailRequest)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $freeEmailRequest->update([
            'status'     => 'approved',
            'admin_note' => $request->admin_note,
        ]);

        // Also create a BusinessEmail record for the customer
        \App\Models\BusinessEmail::create([
            'user_id'           => $freeEmailRequest->user_id,
            'domain'            => $freeEmailRequest->domain_name,
            'plan_name'         => 'Free Email',
            'email_address'     => $freeEmailRequest->desired_email . '@' . $freeEmailRequest->domain_name,
            'registration_date' => now()->toDateString(),
            'expiry_date'       => now()->addYear()->toDateString(),
            'status'            => 'active',
        ]);

        return redirect()->route('admin.free-email-requests.index')
            ->with('success', 'Free email request approved and email activated for the customer.');
    }

    public function reject(Request $request, FreeEmailRequest $freeEmailRequest)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $freeEmailRequest->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.free-email-requests.index')
            ->with('success', 'Free email request has been rejected.');
    }

    public function destroy(FreeEmailRequest $freeEmailRequest)
    {
        $freeEmailRequest->delete();
        return redirect()->route('admin.free-email-requests.index')
            ->with('success', 'Request deleted successfully.');
    }
}
