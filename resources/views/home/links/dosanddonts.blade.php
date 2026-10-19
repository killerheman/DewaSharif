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
        display: block;
        text-align: center;
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
    
    .guide-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid rgba(11, 94, 54, 0.08);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }
    
    .guide-card:hover {
        box-shadow: 0 8px 25px rgba(11, 94, 54, 0.12);
        border-color: rgba(22, 163, 74, 0.3);
    }
    
    .dos-item {
        background: #f0fdf4;
        border-left: 4px solid #16a34a;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .donts-item {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 12px;
    }
</style>

<div class="policy-wrapper">
    <div class="container">
        <!-- Hero Header -->
        <div class="policy-hero">
            <span class="badge-pill"><i class="fa fa-hand-o-right"></i> Visitor &amp; Pilgrim Etiquette</span>
            <h1 class="hero-title" title="Hover / Tap to view Yellow Gradient">DOs &amp; DON’Ts Guidelines</h1>
            <p style="font-size: 16px; opacity: 0.95; max-width: 780px; margin: 0 auto;">
                Essential guidelines and spiritual code of conduct for pilgrims visiting Dewa Sharif Dargah, staying at hotels, and traveling around the holy shrine.
            </p>
        </div>

        <div class="row">
            <!-- DOs Column -->
            <div class="col-lg-6">
                <div class="guide-card" style="border-top: 5px solid #16a34a;">
                    <div class="d-flex align-items-center mb-4">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #dcfce7; color: #15803d; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-right: 12px;">
                            <i class="fa fa-check"></i>
                        </div>
                        <h2 class="gradient-heading m-0" style="font-size: 24px; font-weight: 800;" title="Hover/Tap to highlight">
                            RECOMMENDED DOs
                        </h2>
                    </div>

                    <div class="dos-item">
                        <h5 style="color: #166534; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-check-circle me-1"></i> Maintain Sacred Dignity &amp; Respect
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Maintain silence, modesty, and reverence inside the Dargah premises, Sama Khana, and Mosque areas.
                        </p>
                    </div>

                    <div class="dos-item">
                        <h5 style="color: #166534; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-check-circle me-1"></i> Carry Valid Government Identification
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Always carry original Photo ID (Aadhaar Card, Voter ID, Passport) for smooth check-in at hotels and guest houses.
                        </p>
                    </div>

                    <div class="dos-item">
                        <h5 style="color: #166534; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-check-circle me-1"></i> Cooperate with Hotel Checkout Inspections
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Inform hotel reception in advance for physical room inspection during check-out to verify key handover and room inventory.
                        </p>
                    </div>

                    <div class="dos-item">
                        <h5 style="color: #166534; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-check-circle me-1"></i> Verify Luggage in Cabs
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Double-check seat pockets, luggage boots, and bags before exiting taxis, auto-rickshaws, or booked cabs.
                        </p>
                    </div>

                    <div class="dos-item">
                        <h5 style="color: #166534; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-check-circle me-1"></i> Support Local Artisans &amp; Shops
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Purchase genuine Attar, Chadars, Tasbih, and Handicrafts from verified Dewa Islamic Store merchants.
                        </p>
                    </div>
                </div>
            </div>

            <!-- DON'Ts Column -->
            <div class="col-lg-6">
                <div class="guide-card" style="border-top: 5px solid #ef4444;">
                    <div class="d-flex align-items-center mb-4">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #fee2e2; color: #b91c1c; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-right: 12px;">
                            <i class="fa fa-times"></i>
                        </div>
                        <h2 class="gradient-heading m-0" style="font-size: 24px; font-weight: 800;" title="Hover/Tap to highlight">
                            STRICT DON’Ts
                        </h2>
                    </div>

                    <div class="donts-item">
                        <h5 style="color: #991b1b; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-times-circle me-1"></i> No Damage or Removal of Hotel Property
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Do not remove towels, blankets, electronics, or damage hotel room fixtures. Missing inventory is strictly billable and punishable.
                        </p>
                    </div>

                    <div class="donts-item">
                        <h5 style="color: #991b1b; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-times-circle me-1"></i> No Intoxicants or Unlawful Activity
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Consumption of alcohol, illegal drugs, tobacco inside Dargah zones or non-designated hotel areas is strictly forbidden.
                        </p>
                    </div>

                    <div class="donts-item">
                        <h5 style="color: #991b1b; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-times-circle me-1"></i> Do Not Leave Valuables Unattended
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Never leave cash, gold, expensive gadgets, or mobile phones unattended in crowded areas or unlocked hotel rooms.
                        </p>
                    </div>

                    <div class="donts-item">
                        <h5 style="color: #991b1b; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-times-circle me-1"></i> Avoid Littering &amp; Waste
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Do not throw plastic, garbage, or food waste on holy shrine pathways. Keep Dewa Sharif clean and green.
                        </p>
                    </div>

                    <div class="donts-item">
                        <h5 style="color: #991b1b; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                            <i class="fa fa-times-circle me-1"></i> No Unauthorized Photography in Restricted Areas
                        </h5>
                        <p style="color: #374151; margin: 0; font-size: 14px;">
                            Respect privacy and signage restricting flash photography or video recording inside inner sanctum areas.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection