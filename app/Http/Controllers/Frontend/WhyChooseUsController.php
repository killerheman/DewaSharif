<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    public function aboutUs()
{
    return view('frontend.whychooseus.about-us');
}

public function trustSecurity()
{
    return view('frontend.whychooseus.trust-security');
}

public function customerSupport()
{
    return view('frontend.whychooseus.customer-support');
}

public function tenYearsOfExperience()
{
    return view('frontend.whychooseus.ten-years-of-experience');
}

public function testimonials()
{
     $testimonials = Testimonial::where('is_active', true)
        ->orderBy('sort_order')
        ->orderByDesc('date')
        ->take(8)
        ->get();

    return view('frontend.whychooseus.testimonials', compact('testimonials'));
}
}
