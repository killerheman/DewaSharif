<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class CommunityController extends Controller
{
    public function blog()
    {
        $blogs = Blog::where('is_active', true)
            ->orderByDesc('sort_order')
            ->orderByDesc('date')
            ->paginate(10);

        return view('frontend.community.blog', compact('blogs'));
    }

    public function blogDetails($slug)
    {
        $cleanSlug = \Illuminate\Support\Str::slug($slug);

        $blog = Blog::where('is_active', true)
            ->where(function ($query) use ($slug, $cleanSlug) {
                $query->where('slug', $slug)
                    ->orWhere('slug', $cleanSlug);
            })
            ->first();

        if (!$blog) {
            $fallbackMap = [
                'a-omnis-deserunt-fug' => 'automatic-wordpress-installation-and-updates',
                'mollitia-sit-itaque' => 'runs-on-litespeed-google-cloud-and-cloudflare',
                'optio-ullam-enim-du' => 'unlimited-bandwidth-plus-free-data-backups',
                'maxime-aspernatur-qu' => 'one-click-installations-for-the-top-blogging-software',
            ];
            if (isset($fallbackMap[$slug])) {
                return redirect()->route('blog.show', $fallbackMap[$slug], 301);
            }
            abort(404);
        }

        // If the URL slug was un-slugified (had spaces or %20), redirect to canonical slug
        if ($slug !== $blog->slug) {
            return redirect()->route('blog.show', $blog->slug, 301);
        }

        $moreBlogs = Blog::where('is_active', true)
            ->where('id', '!=', $blog->id)
            ->orderBy('sort_order')
            ->latest('date')
            ->take(4)
            ->get();

        return view('frontend.community.blog-details', compact('blog', 'moreBlogs'));
    }

    public function faqs()
    {
        return view('frontend.community.faqs');
    }

    public function contact()
    {
        return view('frontend.community.contact');
    }

    public function contactSubmit(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $recaptchaResponse = $request->input('g-recaptcha-response');
        if (!$recaptchaResponse) {
            return redirect()->back()->withInput()->withErrors(['g-recaptcha-response' => 'Please complete the Google reCAPTCHA.']);
        }

        $secret = config('services.recaptcha.secret_key') ?: env('RECAPTCHA_SECRET_KEY');
        $verify = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $verifyData = $verify->json();
        if (!isset($verifyData['success']) || !$verifyData['success']) {
            return redirect()->back()->withInput()->withErrors(['g-recaptcha-response' => 'Google reCAPTCHA verification failed. Please try again.']);
        }

        \App\Models\Contact::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent successfully. Our team will get back to you shortly.');
    }
}
