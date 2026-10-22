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
    
    .policy-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 60%);
        pointer-events: none;
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
        text-align: left;
    }
    
    .gradient-heading:hover,
    .gradient-heading:focus,
    .gradient-heading:active {
        background: linear-gradient(135deg, #f7de01ff 0%, #f59e0b 100%);
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
    
    .heading-icon-badge {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(11, 94, 54, 0.1);
        color: #0b5e36;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-right: 12px;
        vertical-align: middle;
        flex-shrink: 0;
        transition: all 0.3s ease;
        -webkit-text-fill-color: #0b5e36 !important;
    }
    
    .policy-card:hover .heading-icon-badge {
        background: #0b5e36;
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
    }

    .policy-section-content {
        padding-left: 52px;
    }

    @media (max-width: 576px) {
        .policy-section-content {
            padding-left: 0px;
        }
    }
    
    .rule-box-warning {
        background: #fffbe6;
        border-left: 4px solid #f59e0b;
        padding: 16px 20px;
        border-radius: 8px;
        margin: 18px 0;
    }
    
    .rule-box-danger {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        padding: 16px 20px;
        border-radius: 8px;
        margin: 18px 0;
    }
    
    .sticky-nav {
        position: sticky;
        top: 90px;
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
    }
    
    .nav-link-custom {
        display: block;
        padding: 10px 14px;
        color: #374151;
        font-weight: 600;
        font-size: 14px;
        border-radius: 8px;
        transition: all 0.2s;
        text-decoration: none !important;
        margin-bottom: 4px;
    }
    
    .nav-link-custom:hover {
        background: #f0fdf4;
        color: #0b5e36;
        padding-left: 18px;
    }
</style>

<div class="policy-wrapper">
    <div class="container">
        <!-- Hero Header -->
        <div class="policy-hero">
            <span class="badge-pill"><i class="fa fa-shield"></i> Legal &amp; Platform Guidelines</span>
            <h1 class="hero-title" title="Hover / Tap to view Yellow Gradient">Terms &amp; Conditions</h1>
            <p style="font-size: 16px; opacity: 0.95; max-width: 780px; margin: 0 auto;">
                Welcome to dewasharif.com. Please read these Terms &amp; Conditions carefully before booking hotels, hiring cabs, or purchasing items on our portal.
            </p>
        </div>

        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sticky-nav">
                    <h5 class="gradient-heading mb-3" style="font-size: 16px; font-weight: 700;">
                        <i class="fa fa-list-ul me-2"></i> Table of Contents
                    </h5>
                    <a href="#general" class="nav-link-custom"><i class="fa fa-angle-right me-2"></i> 1. General Usage</a>
                    <a href="#hotel-rules" class="nav-link-custom"><i class="fa fa-bed me-2"></i> 2. Hotel &amp; Stay Rules</a>
                    <a href="#theft-liability" class="nav-link-custom"><i class="fa fa-exclamation-triangle me-2"></i> 3. Room Inspection &amp; Theft</a>
                    <a href="#cab-rules" class="nav-link-custom"><i class="fa fa-taxi me-2"></i> 4. Cabs &amp; Travel</a>
                    <a href="#store-rules" class="nav-link-custom"><i class="fa fa-shopping-bag me-2"></i> 5. Islamic Store &amp; Orders</a>
                    <a href="#payments" class="nav-link-custom"><i class="fa fa-credit-card me-2"></i> 6. Payments &amp; Refunds</a>
                    <a href="#disclaimer" class="nav-link-custom"><i class="fa fa-shield me-2"></i> 7. Platform Liability</a>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9">
                <!-- Section 1 -->
                <div class="policy-card" id="general">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-globe"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            1. Acceptance of Terms &amp; Usage
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 10px;">
                            By accessing or using <strong>dewasharif.com</strong>, you agree to comply with all applicable local laws, regulations, and these Terms &amp; Conditions. This portal serves pilgrims, visitors, and residents by providing informational resources, hotel booking facilitation, cab transport arrangements, and authentic regional e-commerce products.
                        </p>
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li>All spiritual and historical content is published for informational and educational purposes.</li>
                            <li>Commercial scraping, unauthorized duplication, or misuse of website content is strictly prohibited.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section 2: Hotel Rules -->
                <div class="policy-card" id="hotel-rules">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-hotel"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            2. Hotel Guest House &amp; Stay Regulations
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 10px;">
                            All hotel and guest house stays booked via dewasharif.com are subject to strict adherence to property policies, local administration guidelines, and Indian statutory laws:
                        </p>
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li><strong>Mandatory Original Govt ID &amp; Police Verification:</strong> All adult guests must physically produce their original government-issued photo ID (Aadhaar Card, Passport, Driving License, or Voter ID) at hotel reception during check-in. Under the Sarai Act, 1867 and local police circulars, physical ID verification and maintaining the daily guest ledger is the <strong>exclusive statutory responsibility of the hotel management</strong>.</li>
                            <li><strong>Standard Check-in / Check-out:</strong> Check-in and check-out timings are strictly defined by each respective hotel. Early check-in or late checkout is subject to room availability and additional hotel charges.</li>
                            <li><strong>Prohibition of Unlawful Conduct:</strong> Consumption of alcohol, narcotics, gambling, weapons, unauthorized visitors, immoral trafficking, or any unlawful activity inside hotel premises is strictly prohibited by law.</li>
                        </ul>

                        <!-- CRIME & ACCIDENT NON-LIABILITY SHIELD -->
                        <div class="rule-box-danger" style="margin-top: 18px;">
                            <h5 style="color: #991b1b; font-weight: 800; margin-bottom: 8px;">
                                <i class="fa fa-shield me-1"></i> Absolute Platform Criminal &amp; Civil Non-Liability Notice
                            </h5>
                            <p style="color: #7f1d1d; margin: 0; font-size: 13.5px; line-height: 1.65;">
                                <strong>dewasharif.com is purely a digital booking facilitator and exercises ZERO on-ground physical control over hotel premises, room locks, staff behavior, or private guest conduct.</strong>
                                In the tragic or unforeseen event of any suicide, unnatural demise, homicide, murder, physical brawl, harassment, theft, medical emergency, or criminal offense within hotel rooms or premises, the guest(s) involved and the hotel administration shall be solely, directly, and exclusively answerable under the <strong>Bharatiya Nyaya Sanhita (BNS)</strong> and <strong>Bharatiya Nagarik Suraksha Sanhita (BNSS)</strong>. dewasharif.com, its founder, developers, and administrators bear <strong>ABSOLUTE ZERO civil, tortious, or criminal liability</strong> whatsoever. In any police or administrative inquiry, the platform's role is strictly limited to providing electronic booking verification records as an intermediary.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Room Inspection & Theft Liability -->
                <div class="policy-card" id="theft-liability" style="border-left: 5px solid #0b5e36;">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge" style="background: rgba(217, 119, 6, 0.12); color: #d97706; -webkit-text-fill-color: #d97706 !important;"><i class="fa fa-key"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            3. Mandatory Checkout Inspection &amp; Property Protection
                        </h3>
                    </div>
                    
                    <div class="policy-section-content">
                        <div class="rule-box-danger">
                            <h5 style="color: #991b1b; font-weight: 700; margin-bottom: 8px;">
                                <i class="fa fa-exclamation-circle me-1"></i> Hotel Reception Room Inspection Protocol
                            </h5>
                            <p style="color: #7f1d1d; margin: 0; font-size: 14.5px; line-height: 1.6;">
                                It is mandatory for hotel reception staff &amp; housekeeping to physically inspect the room, towels, bedsheets, electronics, TV remotes, AC remotes, keys, and room inventory at the time of guest departure <strong>BEFORE</strong> clearing final checkout.
                            </p>
                        </div>

                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li><strong>Guest Liability for Missing/Damaged Items:</strong> Guests are fully and exclusively responsible for any missing hotel items, stolen fixtures, stained linens, broken appliances, or damaged property incurred during their stay. The hotel management retains full legal right to inspect rooms and demand full immediate compensation from the guest prior to departure.</li>
                            <li><strong>Personal Belongings:</strong> Guests are advised to keep valuables, cash, and jewelry in safe custody. dewasharif.com and hotel management are not liable for loss or theft of unattended personal belongings.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section 4: Cab Rules -->
                <div class="policy-card" id="cab-rules">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-cab"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            4. Cab, Taxi &amp; Travel Regulations
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 10px;">
                            Cab bookings, airport transfers, and local auto arrangements facilitated through the portal operate under independent third-party transport agreements:
                        </p>
                        <div class="rule-box-warning">
                            <strong style="color: #92400e;"><i class="fa fa-car me-1"></i> Motor Vehicles Act &amp; Road Accident Immunity:</strong> 
                            Cabs are owned and operated by independent commercial drivers holding valid commercial transport permits. In the event of any road accident, vehicular collision, rash or negligent driving, personal injury, mechanical breakdown, traffic fine, or transit delay, the <strong>sole legal, compensatory, and financial liability rests with the independent driver and the vehicle's commercial motor insurance policy under the Motor Vehicles Act, 1988</strong>. dewasharif.com acts purely as a technological communication conduit and assumes zero liability for transit mishaps or vehicular claims.
                        </div>
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li><strong>Luggage Safety:</strong> Passengers must thoroughly check all seating areas and trunk space for personal belongings before exiting the vehicle. Neither the cab driver nor dewasharif.com accepts responsibility for items left behind.</li>
                            <li><strong>Toll &amp; Parking Fees:</strong> Toll taxes, parking fees, and state entry permits (if applicable) are paid as specified during checkout or directly at tolls.</li>
                            <li><strong>Capacity Limits:</strong> Passengers must strictly adhere to seating capacity limits as registered on the vehicle's commercial registration certificate.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section 5: Store Rules -->
                <div class="policy-card" id="store-rules">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-shopping-cart"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            5. Dewa Islamic Store &amp; E-Commerce Orders
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li><strong>Product Authenticity:</strong> All sacred items, Attar perfumes, Chadars, Tasbih, and Handicrafts listed on the Dewa Store are sourced directly from verified local artisans and merchants.</li>
                            <li><strong>Damaged Product Reporting:</strong> If an item arrives damaged or broken, the customer must intimate customer support within 24 hours of delivery with photos/unboxing video for instant replacement or refund.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section 6: Payments -->
                <div class="policy-card" id="payments">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-lock"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            6. Online Payments, UPI &amp; Cancellations
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 10px;">
                            All online transactions (Cards, NetBanking, UPI QR, Wallets) are processed through encrypted, PCI-DSS compliant payment gateways (Razorpay / Bank Payment Gateways).
                        </p>
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li><strong>50% Refund:</strong> Cancellations requested 2 days (48+ hours) prior to check-in/travel date.</li>
                            <li><strong>15% Refund:</strong> Cancellations requested within 2 days (24 to 48 hours) of booking/travel date.</li>
                            <li><strong>10% Refund:</strong> Cancellations requested on the same day of booking/travel.</li>
                            <li><strong>Refund Processing:</strong> Approved refunds are credited back to the original source UPI/Bank account within 5-7 business days.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section 7: Platform Liability & Intermediary Safe Harbor -->
                <div class="policy-card" id="disclaimer">
                    <div class="d-flex align-items-center mb-3">
                        <span class="heading-icon-badge"><i class="fa fa-gavel"></i></span>
                        <h3 class="gradient-heading m-0" style="font-size: 22px; font-weight: 700;" title="Hover/Tap to highlight">
                            7. Intermediary Safe Harbor, Indemnification &amp; Jurisdiction
                        </h3>
                    </div>
                    <div class="policy-section-content">
                        <p style="color: #4b5563; line-height: 1.7; margin-bottom: 12px;">
                            <strong>dewasharif.com</strong> acts strictly as an electronic marketplace and technological facilitator connecting pilgrims with independent third-party hoteliers, cab service operators, and merchandise vendors.
                        </p>
                        
                        <ul style="color: #4b5563; line-height: 1.7; margin: 0; padding-left: 20px;">
                            <li><strong>Safe Harbor Protection under Section 79 of the IT Act, 2000:</strong> dewasharif.com is an "Intermediary" under Section 2(1)(w) of the Information Technology Act, 2000 and observes due diligence under the Information Technology (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021. As an intermediary, the platform does not initiate, curate, or physically execute third-party services and is immune from liability for third-party acts, defaults, or content.</li>
                            <li><strong>Customer Identity Warranty:</strong> By entering guest or passenger details, the customer solemnly declares and warrants that all information, contact numbers, and Government ID proofs (Aadhaar, Voter ID, PAN, Driving License, Passport) submitted are genuine, valid, and belong to the bona fide traveler. Submitting forged or fraudulent identity documents constitutes a cognizable criminal offense punishable under cyber and penal laws.</li>
                            <li><strong>Comprehensive Indemnification (Hold Harmless):</strong> Each customer, traveler, hotelier, vendor, and cab driver unconditionally covenants to defend, indemnify, and hold completely harmless dewasharif.com, its founder/operator (Shahzade Alam / Masharrat Warsi), administrators, agents, and software developers from and against any police inquiries, FIRs, court notices, civil claims, damages, liabilities, fines, penalties, or legal fees arising out of any guest misconduct, unnatural death, suicide, accident, property damage, or violation of local laws.</li>
                            <li><strong>Exclusive Judicial Jurisdiction:</strong> All disputes, claims, and legal proceedings arising out of or related to this portal or services booked through it shall be subject to the exclusive jurisdiction of the competent Courts at <strong>District Barabanki, Uttar Pradesh, India</strong> only.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
