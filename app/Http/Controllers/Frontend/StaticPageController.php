<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function privacyPolicy()
    {
        return view('frontend.pages.privacy-policy');
    }

    public function termsOfUse()
    {
        return view('frontend.pages.terms-of-use');
    }

    public function paymentMethod()
    {
        return view('frontend.pages.payment-method');
    }
}
