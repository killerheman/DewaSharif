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
            <span class="badge-pill"><i class="fa fa-info-circle"></i> Portal Disclaimer &amp; Notice</span>
            <h1 class="hero-title" title="Hover / Tap to view Yellow Gradient">Website Disclaimer</h1>
            <p style="font-size: 16px; opacity: 0.95; max-width: 780px; margin: 0 auto;">
                Important legal safe harbor notice regarding independent portal operations, third-party services and statutory non-affiliation.
            </p>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="policy-card" style="border-left: 5px solid #f59e0b;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="policy-icon-box" style="background: #fef3c7; color: #d97706;"><i class="fa fa-exclamation-triangle"></i></div>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            Independent Private Portal Notice
                        </h3>
                    </div>
                    <p style="color: #4b5563; line-height: 1.7;">
                        <strong>DewaSharif.com</strong> is a privately managed, independent community facilitation portal. It is <strong>NOT</strong> an official website of, nor run by, nor affiliated with the <em>Official Dargah Committee, Trust, Waqf Board, or any Government Administration</em>. We do not claim official administrative authority nor do we collect religious donations on their behalf.
                    </p>
                </div>

                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="policy-icon-box"><i class="fa fa-handshake-o"></i></div>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            Intermediary Status &amp; Third-Party Service Providers
                        </h3>
                    </div>
                    <p style="color: #4b5563; line-height: 1.7; margin-bottom: 12px;">
                        Hotels, Guest Houses, Cabs, Autos, and Shop vendors listed on this website operate as independent third-party commercial entities. DewaSharif.com acts strictly as a technological "Intermediary" under <strong>Section 79 of the Information Technology Act, 2000</strong> to facilitate digital communication and reservations. DewaSharif.com does not own, lease, manage, or operate physical hotels, rooms, or motor vehicle fleets.
                    </p>
                    <p style="color: #4b5563; line-height: 1.7; margin-bottom: 0;">
                        Physical check-in inspection, original Government ID authentication, and compliance with the <em>Sarai Act, 1867 / local police directives</em> are the exclusive statutory duties of the hotel management. Similarly, vehicular safety, insurance, and road transit compliance fall exclusively under the <em>Motor Vehicles Act, 1988</em> upon independent drivers.
                    </p>
                </div>

                <div class="policy-card" style="border-left: 5px solid #ef4444;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="policy-icon-box" style="background: #fee2e2; color: #dc2626;"><i class="fa fa-shield"></i></div>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            Crime, Suicide, Accident &amp; Personal Safety Disclaimer
                        </h3>
                    </div>
                    <p style="color: #4b5563; line-height: 1.7;">
                        DewaSharif.com exercises zero physical control over private hotel room premises or vehicular transit. In the unfortunate event of any criminal incident, suicide, homicide, theft, physical dispute, medical crisis, or vehicular accident, the involved parties (guest, hotel management, or cab driver) shall be solely and directly answerable under Indian Penal and Procedural laws. DewaSharif.com, its founder, and technical administrators bear <strong>ABSOLUTE ZERO civil, tortious, or criminal liability</strong>. All bookings are subject to the exclusive jurisdiction of the Courts at <strong>District Barabanki, Uttar Pradesh, India</strong>.
                    </p>
                </div>

                <div class="policy-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="policy-icon-box"><i class="fa fa-envelope"></i></div>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            Grievances &amp; Direct Contact
                        </h3>
                    </div>
                    <p style="color: #4b5563; line-height: 1.7;">
                        If any law enforcement agency, authority, business, or visitor has official inquiries, notices, or concerns, please contact our grievance officer directly:
                    </p>
                    <p style="color: #0b5e36; font-weight: 700; margin: 0;">
                        <i class="fa fa-envelope me-2"></i> info@dewasharif.com | <i class="fa fa-phone me-2"></i> +91 96487 77223
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
