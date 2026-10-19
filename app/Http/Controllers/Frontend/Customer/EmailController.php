<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Models\BusinessEmail;
use App\Models\FreeEmailRequest;
use Illuminate\Http\Request;

use App\Models\EmailService;

class EmailController extends Controller
{
    public function index()
    {
        $emails = BusinessEmail::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('frontend.customer.my-emails', compact('emails'));
    }

    public function plans()
    {
        return view('frontend.customer.email-plans');
    }

    public function requestFree()
    {
        // Check if already submitted a pending request
        $existingRequest = FreeEmailRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        return view('frontend.customer.email-request-free', compact('existingRequest'));
    }

    public function submitFreeRequest(Request $request)
    {
        $request->validate([
            'domain_name'    => 'required|string|max:255',
            'desired_email'  => 'required|string|max:255',
            'company_name'   => 'nullable|string|max:255',
            'message'        => 'nullable|string|max:1000',
        ]);

        // Check for existing pending request
        $existing = FreeEmailRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->with('error', 'You already have a pending free email request. Please wait for admin approval.');
        }

        FreeEmailRequest::create([
            'user_id'       => auth()->id(),
            'domain_name'   => $request->domain_name,
            'desired_email' => $request->desired_email,
            'company_name'  => $request->company_name,
            'message'       => $request->message,
            'status'        => 'pending',
        ]);

        return back()->with('success', 'Your free email request has been submitted! Our team will review and contact you within 24 hours.');
    }

    public function suit()
    {
        $service = EmailService::where('slug', 'google-gmail-suite')->with(['plans', 'faqs'])->first();
        if (!$service) {
            $service = EmailService::where('is_active', true)->with(['plans', 'faqs'])->firstOrFail();
        }
        $allServices = EmailService::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('frontend.customer.email-service-show', compact('service', 'allServices'));
    }

    public function msOffice()
    {
        $service = EmailService::where('slug', 'microsoft-office-365')->with(['plans', 'faqs'])->first();
        if (!$service) {
            $service = EmailService::where('is_active', true)->with(['plans', 'faqs'])->firstOrFail();
        }
        $allServices = EmailService::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('frontend.customer.email-service-show', compact('service', 'allServices'));
    }

    public function pbMail()
    {
        $service = EmailService::where('slug', 'professional-business-mail')->with(['plans', 'faqs'])->first();
        if (!$service) {
            $service = EmailService::where('is_active', true)->with(['plans', 'faqs'])->firstOrFail();
        }
        $allServices = EmailService::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('frontend.customer.email-service-show', compact('service', 'allServices'));
    }

    public function showBySlug($slug)
    {
        $service = EmailService::where('slug', $slug)->with(['plans', 'faqs'])->where('is_active', true)->firstOrFail();
        $allServices = EmailService::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('frontend.customer.email-service-show', compact('service', 'allServices'));
    }
}
