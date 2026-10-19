<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('date')
            ->take(8)
            ->get();

        $faqs = Faq::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('frontend.home.index', compact('testimonials', 'faqs'));
    }
}
