<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessEmail;
use Illuminate\Http\Request;

class BusinessEmailController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = BusinessEmail::with('user')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $emails = $query->paginate(10);

        $counts = [
            'all' => BusinessEmail::count(),
            'active' => BusinessEmail::where('status', 'active')->count(),
            'suspended' => BusinessEmail::where('status', 'suspended')->count(),
            'cancelled' => BusinessEmail::where('status', 'cancelled')->count(),
            'expired' => BusinessEmail::where('status', 'expired')->count(),
        ];

        return view('admin.business-emails.index', compact('emails', 'status', 'counts'));
    }

    public function show(BusinessEmail $businessEmail)
    {
        return view('admin.business-emails.show', compact('businessEmail'));
    }

    public function edit(BusinessEmail $businessEmail)
    {
        return view('admin.business-emails.edit', compact('businessEmail'));
    }

    public function update(Request $request, BusinessEmail $businessEmail)
    {
        $request->validate([
            'status'            => 'required|string|in:active,suspended,cancelled,expired',
            'provider_email_id' => 'nullable|string',
            'expiry_date'       => 'nullable|date',
        ]);

        $businessEmail->update([
            'status'            => $request->status,
            'provider_email_id' => $request->provider_email_id,
            'expiry_date'       => $request->expiry_date,
        ]);

        return redirect()->route('admin.business-emails.index')->with('success', 'Business Email updated successfully.');
    }

    public function destroy(BusinessEmail $businessEmail)
    {
        $businessEmail->delete();
        return redirect()->route('admin.business-emails.index')->with('success', 'Business Email deleted successfully.');
    }
}
