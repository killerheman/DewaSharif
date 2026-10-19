@extends('home.includes.master')

@section('content')
<style>
    .policy-wrapper {
        background: #f4f6f8;
        padding: 45px 0 70px;
        min-height: 85vh;
    }
    
    .policy-wrapper .d-flex {
        justify-content: flex-start !important;
    }
    
    .policy-hero {
        background: linear-gradient(135deg, #063820 0%, #0b5e36 50%, #16a34a 100%);
        border-radius: 20px;
        padding: 40px 30px;
        color: #ffffff;
        box-shadow: 0 12px 30px rgba(11, 94, 54, 0.25);
        margin-bottom: 35px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .policy-hero .badge-pill {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        color: #ffeb3b;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 15px;
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    /* Green Gradient to Yellow Gradient Header Effect */
    .gradient-heading {
        background: linear-gradient(135deg, #0b5e36 0%, #16a34a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        transition: all 0.35s ease-in-out;
        cursor: pointer;
        display: inline-block;
    }
    
    .gradient-heading:hover,
    .gradient-heading:focus,
    .gradient-heading:active {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        transform: translateY(-2px);
    }
    
    .hero-title {
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 12px;
        transition: all 0.35s ease-in-out;
        cursor: pointer;
    }
    
    .hero-title:hover {
        background: linear-gradient(135deg, #fef08a 0%, #f59e0b 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
    }
    
    .policy-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid rgba(11, 94, 54, 0.08);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }
    
    .policy-card:hover {
        box-shadow: 0 8px 25px rgba(11, 94, 54, 0.12);
        border-color: rgba(22, 163, 74, 0.3);
    }
    
    .policy-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(11, 94, 54, 0.08);
        color: #0b5e36;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    
    .policy-card:hover .policy-icon-box {
        background: #0b5e36;
        color: #ffffff;
    }
</style>

<div class="policy-wrapper">
    <div class="container">
        <!-- Hero Header -->
        <div class="policy-hero">
            <span class="badge-pill"><i class="fa fa-copyright"></i> Intellectual Property Protection</span>
            <h1 class="hero-title" title="Hover / Tap to view Yellow Gradient">Copyright Policy</h1>
            <p style="font-size: 16px; opacity: 0.95; max-width: 780px; margin: 0 auto;">
                Information on content ownership, fair educational usage, and intellectual property rights at DewaSharif.com.
            </p>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="policy-icon-box"><i class="fa fa-copyright"></i></div>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            1. Ownership of Content
                        </h3>
                    </div>
                    <p style="color: #4b5563; line-height: 1.7;">
                        All articles, historical biographies, photographs, graphics, logos, and digital assets published on <strong>DewaSharif.com</strong> are the property of DewaSharif.com or credited copyright owners. Content is protected by Indian and International copyright laws.
                    </p>
                </div>

                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="policy-icon-box"><i class="fa fa-book"></i></div>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            2. Educational &amp; Non-Commercial Permitted Use
                        </h3>
                    </div>
                    <p style="color: #4b5563; line-height: 1.7;">
                        Pilgrims and visitors are welcome to download, share, or read content for non-commercial personal growth and educational purposes, provided full source attribution to <strong>DewaSharif.com</strong> is clearly maintained.
                    </p>
                </div>

                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="policy-icon-box"><i class="fa fa-flag"></i></div>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            3. DMCA &amp; Copyright Grievance Contact
                        </h3>
                    </div>
                    <p style="color: #4b5563; line-height: 1.7;">
                        If you believe any content on our platform infringes your copyright or trademark rights, please intimate our team with proof of ownership for immediate resolution within 24 to 48 hours:
                    </p>
                    <p style="color: #0b5e36; font-weight: 700; margin: 0;">
                        <i class="fa fa-envelope me-2"></i> info@dewasharif.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection