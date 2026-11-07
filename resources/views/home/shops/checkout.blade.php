@extends('home.includes.master')

@section('content')
<style>
    .btn-gradient-green {
        background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
        transition: all 0.25s ease-in-out;
    }
    .btn-gradient-green:hover {
        background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 7px 18px rgba(16, 185, 129, 0.5);
    }
    .btn-gradient-navy {
        background: linear-gradient(135deg, #0b132b 0%, #1c2541 45%, #1e40af 85%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 14px rgba(30, 64, 175, 0.4);
        transition: all 0.25s ease-in-out;
    }
    .btn-gradient-navy:hover {
        background: linear-gradient(135deg, #1c2541 0%, #1e40af 50%, #2563eb 100%) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 7px 18px rgba(37, 99, 235, 0.5);
    }
    .badge-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #34d399 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(4, 120, 87, 0.35);
    }
    .badge-gradient-navy {
        background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 50%, #2563eb 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(30, 58, 138, 0.35);
    }
    .badge-gradient-yellow {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #ee8916 100%) !important;
        color: #1e1b4b !important;
        font-weight: 800;
        box-shadow: 0 2px 5px rgba(245, 158, 11, 0.35);
    }
    .title-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
    }
    #mainCheckoutForm select,
    select.form-control {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23475569' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: calc(100% - 14px) center !important;
        background-size: 12px 12px !important;
        background-color: #ffffff !important;
        padding-right: 36px !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
    }
</style>
<div style="background: #f8fafc; min-height: 90vh; padding-bottom: 80px;">

    <!-- TOP HEADER SPACER -->
    <div style="height: 60px; width: 100%;"></div>

    <!-- TOP ANNOUNCEMENT BAR -->
    <div style="background: linear-gradient(135deg, #0b132b 0%, #1e293b 100%); color: #60a5fa; padding: 11px 0; font-size: 13.5px; font-weight: 700; text-align: center; border-bottom: 2px solid #3b82f6; letter-spacing: 0.3px;">
        🔒100% Secure & Encrypted Checkout | Direct Bank Payment & Verified PDF Invoice
    </div>

    <div class="container" style="margin-top: 35px;">

        <!-- BREADCRUMB -->
        <div style="margin-bottom: 24px;">
            <a href="{{ route('shops.cart') }}" style="color: #0284c7; text-decoration: none; font-weight: 700; font-size: 13.5px;">← Back to Cart Page</a>
            <h2 style="font-weight: 900; color: #0f172a; margin-top: 6px; margin-bottom: 0; font-size: 28px;">
                💳 <span class="title-gradient-green">Secure Checkout &amp; Delivery Address</span>
            </h2>
        </div>

        <form id="mainCheckoutForm" onsubmit="processFinalOrder(event)">
            <div class="row g-4">
                
                <!-- LEFT COLUMN: ADDRESS & PAYMENT FORM -->
                <div class="col-lg-7 col-12">
                    
                    <!-- STEP 1: CUSTOMER INFORMATION -->
                    <div style="background: #ffffff; border-radius: 14px; padding: 26px; border: 1.5px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.05); margin-bottom: 24px;">
                        <h5 style="font-weight: 900; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                            <span>1️⃣</span> Customer Information
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">👤 Customer Full Name</label>
                                <input type="text" id="chk_name" class="form-control" value="{{ auth()->user()->name ?? '' }}" placeholder="Aapka Poora Naam" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📱 Mobile</label>
                                <input type="tel" id="chk_phone" class="form-control" value="{{ auth()->user()->phone ?? '' }}" placeholder="10 digit mobile number" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">✉️ Email Address (Optional)</label>
                                <input type="email" id="chk_email" class="form-control" placeholder="email@gmail.com" style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">💬 Alternate Mobile (Optional)</label>
                                <input type="tel" id="chk_alt_phone" class="form-control" placeholder="Alternate phone number" style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <!-- STEP: DEGH NIYAZ & FATEHA BOOKING DETAILS -->
                    <div id="deghNiyazSection" style="display: none; background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border-radius: 14px; padding: 26px; border: 2px solid #10b981; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.12); margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #bbf7d0; padding-bottom: 12px; margin-bottom: 20px;">
                            <h5 style="font-weight: 900; color: #064e3b; margin: 0; display: flex; align-items: center; gap: 8px; font-size: 18px;">
                                <span>🍲</span> Degh Niyaz &amp; Dua Offering Details
                            </h5>
                            <span style="background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #10b981 100%); color: #ffffff; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Dargah Langar Khidmat
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-7 col-12">
                                <label style="font-size: 13px; font-weight: 800; color: #064e3b; margin-bottom: 6px; display: block;">
                                    🤲 Niyaz / Fateha Ba-Naam (Dua kiske naam se honi hai)
                                </label>
                                <input type="text" id="chk_fateha_name" class="form-control" placeholder="e.g. Marhoom Haji Mohammad Iqbal / Family Members" style="border-radius: 8px; height: 46px; border: 1.5px solid #86efac; font-weight: 600; font-size: 14px; background: #ffffff;">
                                <small style="color: #047857; font-size: 11.5px; font-weight: 600; margin-top: 4px; display: block;">
                                    * Is naam se Dargah Sharif par ba-dastoor Fateha khwani ki jayegi aur Tabarruk invoice me darj hoga.
                                </small>
                            </div>

                            <div class="col-md-5 col-12">
                                <label style="font-size: 13px; font-weight: 800; color: #064e3b; margin-bottom: 6px; display: block;">
                                    📅 Scheduled Niyaz Date &amp; Time
                                </label>
                                <input type="datetime-local" id="chk_niyaz_date" class="form-control" value="{{ \Carbon\Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i') }}" min="{{ \Carbon\Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i') }}" style="border-radius: 8px; height: 46px; border: 1.5px solid #86efac; font-weight: 600; font-size: 14px; background: #ffffff;">
                                <small style="color: #047857; font-size: 11.5px; font-weight: 600; margin-top: 4px; display: block;">
                                    * Calendar icon se Niyaz ki tarikh aur waqt chunein.
                                </small>
                            </div>

                            <div class="col-12" style="margin-top: 15px;">
                                <label style="font-size: 13.5px; font-weight: 800; color: #064e3b; margin-bottom: 8px; display: block;">
                                    🕌 Tabarruk Taqseem / Distribution Preference *
                                </label>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px;">
                                    <label id="distLabelDirect" style="display: flex; align-items: flex-start; gap: 10px; background: #f0fdf4; border: 2px solid #10b981; padding: 14px 16px; border-radius: 10px; cursor: pointer; transition: all 0.2s;">
                                        <input type="radio" name="distribution_type" value="Direct Handover / Self Collection at Dewa Sharif" checked onchange="onDistributionTypeRadioChange()" style="margin-top: 3px; accent-color: #15803d;">
                                        <div>
                                            <strong style="display: block; color: #065f46; font-size: 13.5px;">🟢 1. Direct Handover / Self Collection</strong>
                                            <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block; margin-top: 2px;">Degh paka kar Astana / Degchi point par direct receive karein. Devotee khud collect karenge.</span>
                                            <span style="display: inline-block; margin-top: 4px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">FREE (₹0 Extra)</span>
                                        </div>
                                    </label>

                                    <label id="distLabelTakeaway" style="display: flex; align-items: flex-start; gap: 10px; background: #ffffff; border: 1.5px solid #cbd5e1; padding: 14px 16px; border-radius: 10px; cursor: pointer; transition: all 0.2s;">
                                        <input type="radio" name="distribution_type" value="Packed Takeaway Handover (Devotee Self-Distribution)" onchange="onDistributionTypeRadioChange()" style="margin-top: 3px; accent-color: #0284c7;">
                                        <div>
                                            <strong style="display: block; color: #0369a1; font-size: 13.5px;">📦 2. Packed Takeaway (Self-Distribution)</strong>
                                            <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block; margin-top: 2px;">Ready portion pouches ya boxes me pack karke hotel ya room par handover. Taqseem aap khud karenge.</span>
                                            <span style="display: inline-block; margin-top: 4px; background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Packaging Fee Only</span>
                                        </div>
                                    </label>

                                    <label id="distLabelDargah" style="display: flex; align-items: flex-start; gap: 10px; background: #ffffff; border: 1.5px solid #cbd5e1; padding: 14px 16px; border-radius: 10px; cursor: pointer; transition: all 0.2s;">
                                        <input type="radio" name="distribution_type" value="Dargah Sharif Me Langar Taqseem (Managed Distribution Service)" onchange="onDistributionTypeRadioChange()" style="margin-top: 3px; accent-color: #d97706;">
                                        <div>
                                            <strong style="display: block; color: #92400e; font-size: 13.5px;">🕌 3. Dargah Sharif Langar Taqseem (Managed)</strong>
                                            <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block; margin-top: 2px;">Dewa Sharif Management ki taraf se Dargah Sharif par zaireen aur miskeenon me baqaida taqseem ki zimmedari.</span>
                                            <span style="display: inline-block; margin-top: 4px; background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">+₹500 / Degh + Packaging</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- DYNAMIC PACKAGING & SERVING OPTIONS CONTAINER -->
                            <div class="col-12" id="chk_packaging_options_container" style="margin-top: 15px;">
                                <!-- Rendered dynamically by renderPackagingOptions() -->
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: SHIPPING ADDRESS -->
                    <div style="background: #ffffff; border-radius: 14px; padding: 26px; border: 1.5px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.05); margin-bottom: 24px;">
                        <h5 style="font-weight: 900; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                            <span>2️⃣</span> Delivery Shipping Address / Dewa Sharif Local Address
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🌐 Select Country</label>
                                <select id="chk_country" class="form-control" onchange="onWorldCountryChange()" style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px; background: #ffffff; color: #0f172a;">
                                    <option value="India" selected>IN India</option>
                                    <option value="Afghanistan">AF Afghanistan</option>
                                    <option value="Albania">AL Albania</option>
                                    <option value="Algeria">DZ Algeria</option>
                                    <option value="Andorra">AD Andorra</option>
                                    <option value="Angola">AO Angola</option>
                                    <option value="Anguilla">AI Anguilla</option>
                                    <option value="Antigua and Barbuda">AG Antigua and Barbuda</option>
                                    <option value="Argentina">AR Argentina</option>
                                    <option value="Armenia">AM Armenia</option>
                                    <option value="Aruba">AW Aruba</option>
                                    <option value="Australia">AU Australia</option>
                                    <option value="Austria">AT Austria</option>
                                    <option value="Azerbaijan">AZ Azerbaijan</option>
                                    <option value="Bahamas">BS Bahamas</option>
                                    <option value="Bahrain">BH Bahrain</option>
                                    <option value="Bangladesh">BD Bangladesh</option>
                                    <option value="Barbados">BB Barbados</option>
                                    <option value="Belarus">BY Belarus</option>
                                    <option value="Belgium">BE Belgium</option>
                                    <option value="Belize">BZ Belize</option>
                                    <option value="Benin">BJ Benin</option>
                                    <option value="Bermuda">BM Bermuda</option>
                                    <option value="Bhutan">BT Bhutan</option>
                                    <option value="Bosnia and Herzegovina">BA Bosnia and Herzegovina</option>
                                    <option value="Botswana">BW Botswana</option>
                                    <option value="Brazil">BR Brazil</option>
                                    <option value="Brunei">BN Brunei</option>
                                    <option value="Bulgaria">BG Bulgaria</option>
                                    <option value="Burkina Faso">BF Burkina Faso</option>
                                    <option value="Burundi">BI Burundi</option>
                                    <option value="Cambodia">KH Cambodia</option>
                                    <option value="Cameroon">CM Cameroon</option>
                                    <option value="Canada">CA Canada</option>
                                    <option value="Cape Verde">CV Cape Verde</option>
                                    <option value="Central African Republic">CF Central African Republic</option>
                                    <option value="Chad">TD Chad</option>
                                    <option value="Chile">CL Chile</option>
                                    <option value="China">CN China</option>
                                    <option value="Colombia">CO Colombia</option>
                                    <option value="Comoros">KM Comoros</option>
                                    <option value="Congo">CG Congo</option>
                                    <option value="Costa Rica">CR Costa Rica</option>
                                    <option value="Croatia">HR Croatia</option>
                                    <option value="Cuba">CU Cuba</option>
                                    <option value="Cyprus">CY Cyprus</option>
                                    <option value="Czech Republic">CZ Czech Republic</option>
                                    <option value="Denmark">DK Denmark</option>
                                    <option value="Djibouti">DJ Djibouti</option>
                                    <option value="Dominican Republic">DO Dominican Republic</option>
                                    <option value="Ecuador">EC Ecuador</option>
                                    <option value="Egypt">EG Egypt</option>
                                    <option value="El Salvador">SV El Salvador</option>
                                    <option value="Estonia">EE Estonia</option>
                                    <option value="Ethiopia">ET Ethiopia</option>
                                    <option value="Fiji">FJ Fiji</option>
                                    <option value="Finland">FI Finland</option>
                                    <option value="France">FR France</option>
                                    <option value="Gabon">GA Gabon</option>
                                    <option value="Gambia">GM Gambia</option>
                                    <option value="Georgia">GE Georgia</option>
                                    <option value="Germany">DE Germany</option>
                                    <option value="Ghana">GH Ghana</option>
                                    <option value="Greece">GR Greece</option>
                                    <option value="Greenland">GL Greenland</option>
                                    <option value="Guatemala">GT Guatemala</option>
                                    <option value="Guinea">GN Guinea</option>
                                    <option value="Guyana">GY Guyana</option>
                                    <option value="Haiti">HT Haiti</option>
                                    <option value="Honduras">HN Honduras</option>
                                    <option value="Hong Kong">HK Hong Kong</option>
                                    <option value="Hungary">HU Hungary</option>
                                    <option value="Iceland">IS Iceland</option>
                                    <option value="Indonesia">ID Indonesia</option>
                                    <option value="Iran">IR Iran</option>
                                    <option value="Iraq">IQ Iraq</option>
                                    <option value="Ireland">IE Ireland</option>
                                    <option value="Israel">IL Israel</option>
                                    <option value="Italy">IT Italy</option>
                                    <option value="Jamaica">JM Jamaica</option>
                                    <option value="Japan">JP Japan</option>
                                    <option value="Jordan">JO Jordan</option>
                                    <option value="Kazakhstan">KZ Kazakhstan</option>
                                    <option value="Kenya">KE Kenya</option>
                                    <option value="Kuwait">KW Kuwait</option>
                                    <option value="Kyrgyzstan">KG Kyrgyzstan</option>
                                    <option value="Laos">LA Laos</option>
                                    <option value="Latvia">LV Latvia</option>
                                    <option value="Lebanon">LB Lebanon</option>
                                    <option value="Liberia">LR Liberia</option>
                                    <option value="Libya">LY Libya</option>
                                    <option value="Liechtenstein">LI Liechtenstein</option>
                                    <option value="Lithuania">LT Lithuania</option>
                                    <option value="Luxembourg">LU Luxembourg</option>
                                    <option value="Madagascar">MG Madagascar</option>
                                    <option value="Malawi">MW Malawi</option>
                                    <option value="Malaysia">MY Malaysia</option>
                                    <option value="Maldives">MV Maldives</option>
                                    <option value="Mali">ML Mali</option>
                                    <option value="Malta">MT Malta</option>
                                    <option value="Mauritania">MR Mauritania</option>
                                    <option value="Mauritius">MU Mauritius</option>
                                    <option value="Mexico">MX Mexico</option>
                                    <option value="Monaco">MC Monaco</option>
                                    <option value="Mongolia">MN Mongolia</option>
                                    <option value="Montenegro">ME Montenegro</option>
                                    <option value="Morocco">MA Morocco</option>
                                    <option value="Mozambique">MZ Mozambique</option>
                                    <option value="Myanmar">MM Myanmar</option>
                                    <option value="Namibia">NA Namibia</option>
                                    <option value="Nepal">NP Nepal</option>
                                    <option value="Netherlands">NL Netherlands</option>
                                    <option value="New Zealand">NZ New Zealand</option>
                                    <option value="Nicaragua">NI Nicaragua</option>
                                    <option value="Niger">NE Niger</option>
                                    <option value="Nigeria">NG Nigeria</option>
                                    <option value="Norway">NO Norway</option>
                                    <option value="Oman">OM Oman</option>
                                    <option value="Pakistan">PK Pakistan</option>
                                    <option value="Palestine">PS Palestine</option>
                                    <option value="Panama">PA Panama</option>
                                    <option value="Papua New Guinea">PG Papua New Guinea</option>
                                    <option value="Paraguay">PY Paraguay</option>
                                    <option value="Peru">PE Peru</option>
                                    <option value="Philippines">PH Philippines</option>
                                    <option value="Poland">PL Poland</option>
                                    <option value="Portugal">PT Portugal</option>
                                    <option value="Puerto Rico">PR Puerto Rico</option>
                                    <option value="Qatar">QA Qatar</option>
                                    <option value="Romania">RO Romania</option>
                                    <option value="Russia">RU Russia</option>
                                    <option value="Rwanda">RW Rwanda</option>
                                    <option value="Saudi Arabia">SA Saudi Arabia</option>
                                    <option value="Senegal">SN Senegal</option>
                                    <option value="Serbia">RS Serbia</option>
                                    <option value="Singapore">SG Singapore</option>
                                    <option value="Slovakia">SK Slovakia</option>
                                    <option value="Slovenia">SI Slovenia</option>
                                    <option value="Somalia">SO Somalia</option>
                                    <option value="South Africa">ZA South Africa</option>
                                    <option value="South Korea">KR South Korea</option>
                                    <option value="Spain">ES Spain</option>
                                    <option value="Sri Lanka">LK Sri Lanka</option>
                                    <option value="Sudan">SD Sudan</option>
                                    <option value="Sweden">SE Sweden</option>
                                    <option value="Switzerland">CH Switzerland</option>
                                    <option value="Syria">SY Syria</option>
                                    <option value="Taiwan">TW Taiwan</option>
                                    <option value="Tajikistan">TJ Tajikistan</option>
                                    <option value="Tanzania">TZ Tanzania</option>
                                    <option value="Thailand">TH Thailand</option>
                                    <option value="Togo">TG Togo</option>
                                    <option value="Trinidad and Tobago">TT Trinidad and Tobago</option>
                                    <option value="Tunisia">TN Tunisia</option>
                                    <option value="Turkey">TR Turkey</option>
                                    <option value="Turkmenistan">TM Turkmenistan</option>
                                    <option value="Uganda">UG Uganda</option>
                                    <option value="Ukraine">UA Ukraine</option>
                                    <option value="United Arab Emirates">AE United Arab Emirates</option>
                                    <option value="United Kingdom">GB United Kingdom</option>
                                    <option value="United States">US United States</option>
                                    <option value="Uruguay">UY Uruguay</option>
                                    <option value="Uzbekistan">UZ Uzbekistan</option>
                                    <option value="Vatican City">VA Vatican City</option>
                                    <option value="Venezuela">VE Venezuela</option>
                                    <option value="Vietnam">VN Vietnam</option>
                                    <option value="Yemen">YE Yemen</option>
                                    <option value="Zambia">ZM Zambia</option>
                                    <option value="Zimbabwe">ZW Zimbabwe</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🗺️ Select State / Region</label>
                                <select id="chk_state" class="form-control" onchange="onWorldStateChange()" style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px; background: #ffffff; color: #0f172a;">
                                    <!-- Populated dynamically -->
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🏙️ Select City / District</label>
                                <select id="chk_city" class="form-control" style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px; background: #ffffff; color: #0f172a;">
                                    <!-- Populated dynamically -->
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📮 Delivery Pincode / Zip</label>
                                <input type="text" id="chk_pincode" class="form-control" placeholder="E.g. 225301" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>

                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🏠 House / Flat No, Street Address</label>
                                <input type="text" id="chk_street" class="form-control" placeholder="Ghar / shop number & street name" required style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>

                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">📍 Landmark / Nearby Place (Optional)</label>
                                <input type="text" id="chk_landmark" class="form-control" placeholder="Near Dargah Gate / Station" style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px;">
                            </div>

                            <div class="col-md-6 col-12">
                                <label style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: block;">🏢 Address Type</label>
                                <select id="chk_addresstype" class="form-control" style="border-radius: 8px; height: 46px; border: 1.5px solid #cbd5e1; font-weight: 600; font-size: 14px; background: #ffffff; color: #0f172a;">
                                    <option value="Home">Home (All Day Delivery)</option>
                                    <option value="Work">Work / Office (9 AM - 6 PM)</option>
                                    <option value="Hotel">Hotel / Guest House</option>
                                </select>
                            </div>

                            <!-- Deliver to someone else / Gift Tabarruk Option -->
                            <div class="col-12 mt-2">
                                <div class="p-3 rounded-3 border" style="background: #f8fafc; border: 1.5px solid #cbd5e1 !important;">
                                    <label style="display: flex; align-items: center; gap: 9px; font-size: 13.5px; font-weight: 750; color: #0f172a; cursor: pointer; margin-bottom: 0;">
                                        <input type="checkbox" id="chk_different_receiver" onchange="toggleReceiverSection()" style="width: 18px; height: 18px; accent-color: #059669; cursor: pointer;">
                                        <span>🎁 Send as Gift / Tabarruk to Someone Else (Different Receiver Name &amp; Phone)</span>
                                    </label>
                                    <div id="receiverSection" style="display: none; margin-top: 14px; padding-top: 14px; border-top: 1.5px dashed #cbd5e1;">
                                        <div class="row g-3">
                                            <div class="col-md-6 col-12">
                                                <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Recipient Full Name (Parcel Lene Wale Ka Naam)*</label>
                                                <input type="text" id="chk_receiver_name" class="form-control" placeholder="e.g. Haji Mohammad Iqbal / Family" style="border-radius: 8px; height: 44px; border: 1.5px solid #94a3b8; font-weight: 600; font-size: 13.5px; background: #ffffff;">
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Recipient Contact Mobile (Courier Delivery Call)*</label>
                                                <input type="tel" id="chk_receiver_phone" class="form-control" placeholder="10 digit mobile number" style="border-radius: 8px; height: 44px; border: 1.5px solid #94a3b8; font-weight: 600; font-size: 13.5px; background: #ffffff;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: DELIVERY SPEED & SHIPPING METHOD (REAL-TIME DB RATES) -->
                    <div style="background: #ffffff; border-radius: 14px; padding: 26px; border: 1.5px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.05); margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 20px; flex-wrap: wrap; gap: 8px;">
                            <h5 style="font-weight: 900; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px; font-size: 18px;">
                                <span>3️⃣</span> Select Delivery Speed &amp; Courier Tier
                            </h5>
                            <span id="deliveryZoneBadge" style="background: #dcfce7; color: #166534; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px; border: 1px solid #86efac;">
                                ⚡ Dewa Sharif Local Zone (225301)
                            </span>
                        </div>

                        <div id="deliverySpeedOptionsWrapper" style="display: flex; flex-direction: column; gap: 12px;">
                            <!-- Populated dynamically based on Pincode and City -->
                        </div>
                    </div>

                    <!-- STEP 4: PAYMENT METHOD SELECTION (REAL-TIME COD VS ONLINE) -->
                    <div style="background: #ffffff; border-radius: 14px; padding: 26px; border: 1.5px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.05); margin-bottom: 24px;">
                        <h5 style="font-weight: 900; color: #0f172a; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; font-size: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                            <span>4️⃣</span> Choose Payment Method
                        </h5>

                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <label id="paymentMethodOnlineLabel" style="border: 2px solid #10b981; border-radius: 12px; padding: 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15); transition: all 0.2s;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input type="radio" name="payment_method" value="online" checked onchange="onPaymentMethodRadioChange()" style="width: 20px; height: 20px; accent-color: #047857;">
                                    <div>
                                        <span style="font-size: 15px; font-weight: 900; color: #064e3b; display: block;">
                                            💳 Pay Online (PhonePe / GPay / UPI / SBI Direct)
                                        </span>
                                        <span style="font-size: 12.5px; color: #047857; font-weight: 600;">
                                            Zero COD Fee • Instant PDF Tax Invoice &amp; Priority Dispatch
                                        </span>
                                    </div>
                                </div>
                                <span class="badge badge-gradient-green px-3 py-1.5 rounded-pill font-bold shadow-sm">
                                    SAVE ₹{{ number_format((float)($shopSettings['cod_extra_fee'] ?? 30)) }} (₹0 COD)
                                </span>
                            </label>

                            <label id="paymentMethodCodLabel" style="border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: #ffffff; transition: all 0.2s;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <input type="radio" name="payment_method" value="cod" onchange="onPaymentMethodRadioChange()" style="width: 20px; height: 20px; accent-color: #0b132b;">
                                    <div>
                                        <span style="font-size: 15px; font-weight: 900; color: #0f172a; display: block;">
                                            💵 Cash on Delivery (COD)
                                        </span>
                                        <span style="font-size: 12.5px; color: #64748b; font-weight: 600;">
                                            Pay cash directly to delivery rider / courier driver at your door (+₹{{ number_format((float)($shopSettings['cod_extra_fee'] ?? 30)) }} handling fee)
                                        </span>
                                    </div>
                                </div>
                                <span class="badge badge-gradient-navy px-3 py-1.5 rounded-pill font-bold shadow-sm">
                                    +₹{{ number_format((float)($shopSettings['cod_extra_fee'] ?? 30)) }} COD FEE
                                </span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: ORDER SUMMARY & PAY BUTTON -->
               <div class="col-lg-5 col-12">
    <div style="background: #ffffff; border-radius: 14px; padding: 24px; border: 1.5px solid #cbd5e1; box-shadow: 0 8px 25px rgba(0,0,0,0.08); position: sticky; top: 80px;">
        <h5 style="font-weight: 900; color: #0f172a; margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; font-size: 18px;">
            Order Items Summary
        </h5>

        <div id="checkoutOrderItemsList" style="max-height: 380px; overflow-y: auto; margin-bottom: 16px; padding-right: 4px;">
            <!-- Dynamic items list with interactive quantity & remove controls -->
        </div>

        <div style="border-top: 1.5px solid #e2e8f0; padding-top: 14px;">
            <div style="display: flex; justify-content: space-between; font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 7px;">
                <span>Item(s) Subtotal:</span>
                <span style="font-weight: 800; color: #0f172a;" id="chkSubtotalVal">₹0</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 7px;">
                <span>📦 Packaging Fee:</span>
                <span style="font-weight: 800; color: #0f172a;" id="chkPackagingFeeVal">₹0</span>
            </div>
            <div id="chkDistFeeRow" style="display: flex; justify-content: space-between; font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 7px;">
                <span>🕌 Dargah Taqseem Service:</span>
                <span style="font-weight: 800; color: #0f172a;" id="chkDistFeeVal">FREE (₹0)</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 7px;">
                <span>🛡️ Handling Fee:</span>
                <span style="font-weight: 800; color: #0f172a;" id="chkHandlingFeeVal">₹0</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 7px;">
                <span id="chkDeliveryTierLabel">🚚 Delivery Charges:</span>
                <span style="font-weight: 800; color: #0f172a;" id="chkDeliveryFeeVal">₹0</span>
            </div>
            <div id="chkCodRow" style="display: none; justify-content: space-between; font-size: 13.5px; color: #b45309; font-weight: 700; margin-bottom: 7px;">
                <span>💵 COD Extra Fee:</span>
                <span style="font-weight: 800; color: #b45309;" id="chkCodFeeVal">+₹0</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 14px; border-radius: 10px; border: 1.5px solid #cbd5e1; margin-top: 12px; margin-bottom: 18px;">
                <span style="font-size: 16px; font-weight: 900; color: #111827;">Grand Total:</span>
                <span style="font-size: 26px; font-weight: 900; background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;" id="chkGrandTotalVal">₹0</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
                <!-- BUTTON FOR COD (VISIBLE ONLY WHEN COD SELECTED) -->
                <button type="submit" id="btnShopConfirmCod" class="btn w-100 font-extrabold" style="display: none; background: #0f172a; color: #ffffff; font-weight: 900; border-radius: 10px; padding: 14px; font-size: 15px; border: none; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.4); text-align: center;">
                    <i class="fa fa-truck" style="margin-right: 6px;"></i> Confirm Cash on Delivery (COD) Order
                </button>

                <!-- BUTTON 1: RAZORPAY ONLINE PAYMENT (DISABLED - COMING SOON) -->
                <button type="button" id="btnShopPayOnline" disabled class="btn w-100" style="background: #f1f5f9; color: #64748b; font-weight: 700; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; border: 1.5px dashed #cbd5e1; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap; opacity: 0.95; white-space: normal !important; text-align: center; box-sizing: border-box;" title="Online Gateway verification underway. Please use UPI QR.">
                    <i class="fa fa-credit-card" style="font-size: 16px; color: #94a3b8; flex-shrink: 0;"></i>
                    <span>Pay Online (Cards / NetBanking)</span>
                    <span class="badge" style="background: #f59e0b; color: #111; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px; text-transform: uppercase; margin-left: 4px; flex-shrink: 0;">Soon</span>
                </button>

                <!-- BUTTON 2: PHONEPE / UPI QR CODE PAYMENT (DEFAULT & PRIMARY) -->
                <button type="button" id="btnShopQr" onclick="openShopQrModal()" class="btn w-100 font-extrabold" style="background: #074121; color: #ffffff; font-weight: 800; border-radius: 10px; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 14px rgba(7, 65, 33, 0.35); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px; white-space: normal !important; text-align: center; box-sizing: border-box;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap;">
                        <i class="fa fa-qrcode" style="font-size: 18px; color: #4ade80; flex-shrink: 0;"></i>
                        <span style="font-size: 14.5px; font-weight: 900;">Pay via UPI QR (PhonePe / GPay / Paytm)</span>
                    </div>
                    <small style="font-size: 11px; opacity: 0.9; font-weight: 600; color: #dcfce7;">Scan &amp; Pay directly to SBI A/C</small>
                </button>

                <!-- BUTTON 3: DIRECT WHATSAPP ORDER -->
                <button type="button" onclick="checkoutShopWhatsAppDirect()" class="btn w-100 font-extrabold" style="background: #25D366; color: #ffffff; font-weight: 800; border-radius: 10px; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px; white-space: normal !important; text-align: center; box-sizing: border-box;">
                    <i class="fa fa-whatsapp" style="font-size: 19px; flex-shrink: 0;"></i>
                    <span>Order Sacred Items via WhatsApp</span>
                </button>
            </div>
        </div>

    </div>
</div>

            </div>
        </form>

    </div>
</div>

<!-- RAZORPAY SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    window.DEWA_SHOP_SETTINGS = @json($shopSettings ?? []);
    window.DEWA_DB_PRODUCTS = @json($dbProducts ?? []);

    function toggleReceiverSection() {
        var isChecked = document.getElementById('chk_different_receiver') && document.getElementById('chk_different_receiver').checked;
        if (isChecked) {
            $('#receiverSection').slideDown(200);
        } else {
            $('#receiverSection').slideUp(200);
        }
    }

    function isDewaSharifLocal() {
        var pin = ($('#chk_pincode').val() || '').trim();
        var city = ($('#chk_city').val() || '').trim().toLowerCase();
        return (pin === '225301' || city.includes('dewa'));
    }

    function getCartData() {
        var raw = localStorage.getItem('dewa_cart');
        var data = [];
        try {
            if (raw) {
                data = JSON.parse(raw);
            }
        } catch(e) {
            data = [];
        }

        if (!Array.isArray(data)) {
            data = [];
        }

        return data.map(function(item) {
            var cleanImg = (item.image || '').replace(/^https?:\/\/[^\/]+/, '');
            if (!cleanImg.startsWith('/')) cleanImg = '/' + cleanImg;
            return {
                id: item.id || 1,
                name: item.name || "Sacred Item",
                price: parseFloat(item.price) || 0,
                image: cleanImg || "/home/images/dewasharif/dewapage/attar_bottle.jpg",
                qty: parseInt(item.qty || item.quantity) || 1,
                maxStock: parseInt(item.maxStock || item.stock) || 999
            };
        });
    }

    function calculateCartFees(cart) {
        var subtotal = 0;
        var packagingFee = 0;
        var defaultPkg = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.default_packaging_fee) || 20);
        var maxHandling = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.default_handling_fee) || 10);
        var deghCount = 0;
        var hasDeghItem = false;

        cart.forEach(function(item) {
            subtotal += (item.price * item.qty);
            var isItemDegh = item.name.toLowerCase().includes('biryani') || 
                             item.name.toLowerCase().includes('zarda') || 
                             item.name.toLowerCase().includes('kheer') || 
                             item.name.toLowerCase().includes('degh');
            if (isItemDegh) {
                hasDeghItem = true;
                deghCount += item.qty;
            } else {
                var pDb = (window.DEWA_DB_PRODUCTS && window.DEWA_DB_PRODUCTS[item.id]) ? window.DEWA_DB_PRODUCTS[item.id] : null;
                var itemPkg = (pDb && pDb.packaging_fee !== null && pDb.packaging_fee !== undefined && pDb.packaging_fee !== '') 
                              ? parseFloat(pDb.packaging_fee) 
                              : defaultPkg;
                packagingFee += (itemPkg * item.qty);
            }

            if (pDb && pDb.handling_fee !== null && pDb.handling_fee !== undefined && pDb.handling_fee !== '') {
                var pH = parseFloat(pDb.handling_fee);
                if (pH > maxHandling) maxHandling = pH;
            }
        });

        var chosenPkgType = $('input[name="chk_packaging_choice"]:checked').val() || 'none';
        if (hasDeghItem) {
            if (chosenPkgType === 'polythin' || chosenPkgType === 'katori') {
                packagingFee += (300 * deghCount);
            } else if (chosenPkgType === 'box' || chosenPkgType === 'mitti_katori') {
                packagingFee += (600 * deghCount);
            }
        }

        var chosenDistType = $('input[name="distribution_type"]:checked').val() || 'Direct Handover / Self Collection at Dewa Sharif';
        var distributionFee = 0;
        if (hasDeghItem) {
            if (chosenDistType.toLowerCase().includes('langar taqseem') || chosenDistType.toLowerCase().includes('managed')) {
                distributionFee = 500 * deghCount;
            } else {
                distributionFee = 0;
            }
        }

        var isLocal = isDewaSharifLocal();
        var selectedTier = $('input[name="delivery_tier"]:checked').val();
        if (isLocal) {
            if (!selectedTier || (selectedTier !== 'express_2_4h' && selectedTier !== 'local_24h' && selectedTier !== 'standard_courier')) {
                selectedTier = 'local_24h';
            }
        } else {
            selectedTier = 'standard_courier';
        }

        var freeThreshold = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.free_delivery_threshold) || 999);
        var deliveryFee = 0;
        var deliveryTierName = "🚚 Standard Courier Delivery";

        if (selectedTier === 'express_2_4h') {
            deliveryFee = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.express_2_4h_fee) || 35);
            deliveryTierName = "⚡ Superfast Express (2–4 Hours)";
        } else if (selectedTier === 'local_24h') {
            deliveryFee = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.local_24h_fee) || 20);
            deliveryTierName = "🕒 Dewa Sharif Normal Local (Within 24 Hours)";
        } else {
            if (freeThreshold > 0 && subtotal >= freeThreshold) {
                deliveryFee = 0;
                deliveryTierName = "🚚 Standard Courier (FREE Delivery)";
            } else {
                deliveryFee = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.standard_courier_fee) || 40);
                deliveryTierName = "🚚 Standard Company Courier";
            }
        }

        var paymentMethod = $('input[name="payment_method"]:checked').val() || 'online';
        var codFee = 0;
        if (paymentMethod === 'cod') {
            codFee = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.cod_extra_fee) || 30);
        }

        var grandTotal = subtotal + packagingFee + distributionFee + maxHandling + deliveryFee + codFee;

        return {
            subtotal: subtotal,
            packagingFee: packagingFee,
            packagingType: chosenPkgType,
            distributionFee: distributionFee,
            distributionType: chosenDistType,
            handlingFee: maxHandling,
            deliveryFee: deliveryFee,
            codFee: codFee,
            grandTotal: grandTotal,
            selectedTier: selectedTier,
            deliveryTierName: deliveryTierName,
            paymentMethod: paymentMethod,
            isLocal: isLocal
        };
    }

    function renderDeliverySpeedOptions() {
        var cart = getCartData();
        var fees = calculateCartFees(cart);
        var wrapper = document.getElementById('deliverySpeedOptionsWrapper');
        var badge = document.getElementById('deliveryZoneBadge');
        if (!wrapper) return;

        var expFee = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.express_2_4h_fee) || 35);
        var locFee = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.local_24h_fee) || 20);
        var stdFee = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.standard_courier_fee) || 40);
        var freeThreshold = parseFloat((window.DEWA_SHOP_SETTINGS && window.DEWA_SHOP_SETTINGS.free_delivery_threshold) || 999);
        var stdLabel = (freeThreshold > 0 && fees.subtotal >= freeThreshold) ? 'FREE (₹0)' : '₹' + stdFee;

        var currentTier = $('input[name="delivery_tier"]:checked').val() || (fees.isLocal ? 'local_24h' : 'standard_courier');

        if (fees.isLocal) {
            if (badge) {
                badge.style.background = '#dcfce7';
                badge.style.color = '#166534';
                badge.style.border = '1px solid #86efac';
                badge.innerHTML = '⚡ Dewa Sharif Local Zone Active (Pincode: 225301)';
            }

            var html = '' +
                '<label style="border: ' + (currentTier === 'express_2_4h' ? '2px solid #ef4444' : '1.5px solid #cbd5e1') + '; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: ' + (currentTier === 'express_2_4h' ? '#fff1f2' : '#ffffff') + '; transition: all 0.2s;">' +
                '  <div style="display: flex; align-items: center; gap: 12px;">' +
                '    <input type="radio" name="delivery_tier" value="express_2_4h" ' + (currentTier === 'express_2_4h' ? 'checked' : '') + ' onchange="onDeliveryTierChange()" style="width: 18px; height: 18px; accent-color: #dc2626;">' +
                '    <div>' +
                '      <strong style="color: #991b1b; font-size: 14.5px; display: block;">⚡ Superfast Express (2–4 Hours)</strong>' +
                '      <span style="color: #64748b; font-size: 12px;">Dewa Sharif Urgent Rider • Delivery directly to home, hotel or Astana</span>' +
                '    </div>' +
                '  </div>' +
                '  <span class="badge" style="background: #dc2626; color: #ffffff; font-size: 13.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px;">₹' + expFee + '</span>' +
                '</label>' +

                '<label style="border: ' + (currentTier === 'local_24h' ? '2px solid #059669' : '1.5px solid #cbd5e1') + '; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: ' + (currentTier === 'local_24h' ? '#f0fdf4' : '#ffffff') + '; transition: all 0.2s;">' +
                '  <div style="display: flex; align-items: center; gap: 12px;">' +
                '    <input type="radio" name="delivery_tier" value="local_24h" ' + (currentTier === 'local_24h' ? 'checked' : '') + ' onchange="onDeliveryTierChange()" style="width: 18px; height: 18px; accent-color: #059669;">' +
                '    <div>' +
                '      <strong style="color: #065f46; font-size: 14.5px; display: block;">🕒 Normal Local Delivery (Within 24 Hours)</strong>' +
                '      <span style="color: #64748b; font-size: 12px;">Dewa Sharif Town standard hand delivery within 24 hours</span>' +
                '    </div>' +
                '  </div>' +
                '  <span class="badge" style="background: #059669; color: #ffffff; font-size: 13.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px;">₹' + locFee + '</span>' +
                '</label>' +

                '<label style="border: ' + (currentTier === 'standard_courier' ? '2px solid #2563eb' : '1.5px solid #cbd5e1') + '; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: ' + (currentTier === 'standard_courier' ? '#eff6ff' : '#ffffff') + '; transition: all 0.2s;">' +
                '  <div style="display: flex; align-items: center; gap: 12px;">' +
                '    <input type="radio" name="delivery_tier" value="standard_courier" ' + (currentTier === 'standard_courier' ? 'checked' : '') + ' onchange="onDeliveryTierChange()" style="width: 18px; height: 18px; accent-color: #2563eb;">' +
                '    <div>' +
                '      <strong style="color: #1e40af; font-size: 14.5px; display: block;">🚚 Standard Courier Delivery (2-3 Days)</strong>' +
                '      <span style="color: #64748b; font-size: 12px;">Company standard courier with tracking number</span>' +
                '    </div>' +
                '  </div>' +
                '  <span class="badge" style="background: #1e40af; color: #ffffff; font-size: 13.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px;">' + stdLabel + '</span>' +
                '</label>';
            wrapper.innerHTML = html;
        } else {
            if (badge) {
                badge.style.background = '#e0f2fe';
                badge.style.color = '#0369a1';
                badge.style.border = '1px solid #7dd3fc';
                badge.innerHTML = '🌐 All-India Standard Courier Delivery Zone';
            }

            var html = '' +
                '<label style="border: 2px solid #2563eb; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: #eff6ff;">' +
                '  <div style="display: flex; align-items: center; gap: 12px;">' +
                '    <input type="radio" name="delivery_tier" value="standard_courier" checked onchange="onDeliveryTierChange()" style="width: 18px; height: 18px; accent-color: #2563eb;">' +
                '    <div>' +
                '      <strong style="color: #1e40af; font-size: 14.5px; display: block;">🚚 Standard Company Courier (DTDC / Shiprocket, 2-5 Days)</strong>' +
                '      <span style="color: #64748b; font-size: 12px;">Dispatched safely with online courier tracking code</span>' +
                '    </div>' +
                '  </div>' +
                '  <span class="badge" style="background: #1e40af; color: #ffffff; font-size: 13.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px;">' + stdLabel + '</span>' +
                '</label>';
            wrapper.innerHTML = html;
        }
    }

    function onDeliveryTierChange() {
        renderDeliverySpeedOptions();
        updateCheckoutTotals();
    }

    function onPaymentMethodRadioChange() {
        var selectedMethod = $('input[name="payment_method"]:checked').val() || 'online';
        if (selectedMethod === 'cod') {
            $('#paymentMethodCodLabel').css({
                'border': '2px solid #0f172a',
                'background': '#f8fafc',
                'box-shadow': '0 4px 12px rgba(15, 23, 42, 0.15)'
            });
            $('#paymentMethodOnlineLabel').css({
                'border': '1.5px solid #cbd5e1',
                'background': '#ffffff',
                'box-shadow': 'none'
            });
            $('#btnShopConfirmCod').show();
            $('#btnShopQr').hide();
            $('#btnShopPayOnline').hide();
            $('#chkCodRow').css('display', 'flex');
        } else {
            $('#paymentMethodOnlineLabel').css({
                'border': '2px solid #10b981',
                'background': 'linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%)',
                'box-shadow': '0 4px 12px rgba(16, 185, 129, 0.15)'
            });
            $('#paymentMethodCodLabel').css({
                'border': '1.5px solid #cbd5e1',
                'background': '#ffffff',
                'box-shadow': 'none'
            });
            $('#btnShopConfirmCod').hide();
            $('#btnShopQr').show();
            $('#btnShopPayOnline').show();
            $('#chkCodRow').hide();
        }
        updateCheckoutTotals();
    }

    function updateCheckoutTotals() {
        var cart = getCartData();
        var fees = calculateCartFees(cart);

        var subEl = document.getElementById('chkSubtotalVal');
        if (subEl) subEl.textContent = '₹' + fees.subtotal.toLocaleString('en-IN');

        var pkgEl = document.getElementById('chkPackagingFeeVal');
        if (pkgEl) {
            if (fees.packagingFee === 0) {
                pkgEl.textContent = 'FREE (₹0)';
                pkgEl.style.color = '#15803d';
            } else {
                pkgEl.textContent = '₹' + fees.packagingFee.toLocaleString('en-IN');
                pkgEl.style.color = '#0f172a';
            }
        }

        var distFeeEl = document.getElementById('chkDistFeeVal');
        var distFeeRow = document.getElementById('chkDistFeeRow');
        if (distFeeEl) {
            if (fees.distributionFee > 0) {
                distFeeEl.textContent = '+₹' + fees.distributionFee.toLocaleString('en-IN');
                distFeeEl.style.color = '#b45309';
                if (distFeeRow) distFeeRow.style.display = 'flex';
            } else {
                distFeeEl.textContent = 'FREE (₹0)';
                distFeeEl.style.color = '#15803d';
                if (distFeeRow) distFeeRow.style.display = 'flex';
            }
        }

        var hndEl = document.getElementById('chkHandlingFeeVal');
        if (hndEl) hndEl.textContent = '₹' + fees.handlingFee.toLocaleString('en-IN');

        var delLabelEl = document.getElementById('chkDeliveryTierLabel');
        if (delLabelEl) delLabelEl.textContent = fees.deliveryTierName + ':';

        var delValEl = document.getElementById('chkDeliveryFeeVal');
        if (delValEl) {
            delValEl.textContent = fees.deliveryFee === 0 ? 'FREE (₹0)' : '₹' + fees.deliveryFee.toLocaleString('en-IN');
            if (fees.deliveryFee === 0) {
                delValEl.style.color = '#15803d';
            } else {
                delValEl.style.color = '#0f172a';
            }
        }

        var codValEl = document.getElementById('chkCodFeeVal');
        if (codValEl) codValEl.textContent = '+₹' + fees.codFee.toLocaleString('en-IN');

        var grandEl = document.getElementById('chkGrandTotalVal');
        if (grandEl) grandEl.textContent = '₹' + fees.grandTotal.toLocaleString('en-IN');

        var upiAmtEl = document.getElementById('shopDirectUpiAmount');
        if (upiAmtEl) upiAmtEl.textContent = '₹' + fees.grandTotal.toLocaleString('en-IN');

        var qrAmtEl = document.getElementById('shopQrPayAmountText');
        if (qrAmtEl) qrAmtEl.textContent = '₹' + fees.grandTotal.toLocaleString('en-IN');
    }

    function renderCheckoutPage() {
        var cart = getCartData();
        var html = '';
        var hasDeghItem = false;

        if (cart.length === 0) {
            html = '<div style="text-align: center; padding: 32px 10px; color: #64748b;">' +
                   '<span style="font-size: 44px; display: block; margin-bottom: 10px;">🛍️</span>' +
                   '<h6 style="font-weight: 900; color: #0f172a; margin-bottom: 6px; font-size: 16px;">Your cart is empty</h6>' +
                   '<p style="font-size: 13px; margin-bottom: 16px; color: #64748b;">Select your sacred offering to proceed with booking.</p>' +
                   '<a href="{{ route("shops.category", "degh") }}" class="btn btn-sm" style="background: #052c16; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 8px 20px; text-decoration: none;">Explore Degh Niyaz</a>' +
                   '</div>';

            var payOnlineBtn = document.getElementById('btnShopPayOnline');
            if (payOnlineBtn) payOnlineBtn.disabled = true;
            var qrBtn = document.getElementById('btnShopQr');
            if (qrBtn) qrBtn.disabled = true;
            var codBtn = document.getElementById('btnShopConfirmCod');
            if (codBtn) codBtn.disabled = true;
            $('#deghNiyazSection').slideUp(200);
        } else {
            var payOnlineBtn = document.getElementById('btnShopPayOnline');
            if (payOnlineBtn) payOnlineBtn.disabled = false;
            var qrBtn = document.getElementById('btnShopQr');
            if (qrBtn) qrBtn.disabled = false;
            var codBtn = document.getElementById('btnShopConfirmCod');
            if (codBtn) codBtn.disabled = false;

            cart.forEach(function(item, index) {
                var itemTotal = item.price * item.qty;
                var isItemDegh = item.name.toLowerCase().includes('biryani') || 
                                 item.name.toLowerCase().includes('zarda') || 
                                 item.name.toLowerCase().includes('kheer') || 
                                 item.name.toLowerCase().includes('degh');
                if (isItemDegh) hasDeghItem = true;

                html += '<div style="border-bottom: 1.5px solid #f1f5f9; padding-bottom: 14px; margin-bottom: 14px;">' +
                        '  <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 10px;">' +
                        '    <div style="display: flex; align-items: center; gap: 10px;">' +
                        '      <img src="' + item.image + '" onerror="this.onerror=null; this.src=\'/home/images/dewasharif/dewapage/attar_bottle.jpg\';" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1.5px solid #cbd5e1; flex-shrink: 0;">' +
                        '      <div>' +
                        '        <span style="font-weight: 800; font-size: 13.5px; color: #0f172a; line-height: 1.3; display: block;">' + item.name + '</span>' +
                        (isItemDegh ? '<span style="background: #dcfce7; color: #166534; font-size: 10.5px; font-weight: 800; padding: 2px 7px; border-radius: 4px; display: inline-block; margin-top: 3px;">🍲 Degh Niyaz Tabarruk</span>' : '') +
                        '        <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-top: 2px;">₹' + item.price.toLocaleString('en-IN') + ' each</span>' +
                        '      </div>' +
                        '    </div>' +
                        '    <button type="button" onclick="removeCheckoutItem(' + index + ')" class="btn btn-sm" style="color: #ef4444; font-weight: 900; font-size: 16px; border: none; background: #fef2f2; padding: 2px 8px; border-radius: 6px; cursor: pointer; line-height: 1;" title="Remove this item">&times;</button>' +
                        '  </div>' +
                        '  <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 10px; padding-top: 6px;">' +
                        '    <div style="display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 6px; padding: 2px 6px;">' +
                        '      <button type="button" onclick="changeCheckoutQty(' + index + ', -1)" class="btn btn-sm" style="font-weight: 900; border: none; background: transparent; width: 26px; height: 26px; padding: 0; font-size: 16px; color: #0f172a; line-height: 1;">-</button>' +
                        '      <span style="font-weight: 900; font-size: 14px; min-width: 24px; text-align: center; color: #0f172a;">' + item.qty + '</span>' +
                        '      <button type="button" onclick="changeCheckoutQty(' + index + ', 1)" class="btn btn-sm" style="font-weight: 900; border: none; background: transparent; width: 26px; height: 26px; padding: 0; font-size: 16px; color: #0f172a; line-height: 1;">+</button>' +
                        '    </div>' +
                        '    <span style="font-size: 16px; font-weight: 900; color: #074121;">₹' + itemTotal.toLocaleString('en-IN') + '</span>' +
                        '  </div>' +
                        '</div>';
            });

            if (hasDeghItem) {
                renderPackagingOptions(cart);
                $('#deghNiyazSection').slideDown(200);
            } else {
                $('#deghNiyazSection').slideUp(200);
            }
        }

        var itemsList = document.getElementById('checkoutOrderItemsList');
        if (itemsList) itemsList.innerHTML = html;

        updateCheckoutTotals();
    }

    function renderPackagingOptions(cart) {
        var container = document.getElementById('chk_packaging_options_container');
        if (!container) return;

        var hasKheer = cart.some(function(i) { return i.name.toLowerCase().includes('kheer'); });
        var hasBiryani = cart.some(function(i) { 
            return i.name.toLowerCase().includes('biryani') || i.name.toLowerCase().includes('zarda') || i.name.toLowerCase().includes('degh') || i.name.toLowerCase().includes('mutton') || i.name.toLowerCase().includes('chicken'); 
        });

        var currentChoice = $('input[name="chk_packaging_choice"]:checked').val() || 'none';

        var html = '';
        if (hasKheer && !hasBiryani) {
            // Kheer Options: Khula ₹0, Disposable Katori ₹300, Mitti Katori ₹600
            html = '<label style="font-size: 13px; font-weight: 800; color: #064e3b; margin-bottom: 8px; display: block;">' +
                   '  🥣 Kheer Niyaz Serving &amp; Packaging Option' +
                   '</label>' +
                   '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px;">' +
                   '  <label style="display: flex; align-items: flex-start; gap: 10px; background: ' + (currentChoice === 'none' ? '#f0fdf4' : '#ffffff') + '; border: ' + (currentChoice === 'none' ? '2px solid #10b981' : '1.5px solid #cbd5e1') + '; padding: 14px 16px; border-radius: 10px; cursor: pointer;">' +
                   '    <input type="radio" name="chk_packaging_choice" value="none" ' + (currentChoice === 'none' ? 'checked' : '') + ' onchange="onPackagingChoiceChange()" style="margin-top: 3px; accent-color: #15803d;">' +
                   '    <div>' +
                   '      <strong style="display: block; color: #065f46; font-size: 13.5px;">🟢 Khula Langar (Direct Taqseem)</strong>' +
                   '      <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block;">Dargah Sharif par zaireen ko direct kheer tabarruk taqseem. (₹0 Extra)</span>' +
                   '      <span style="display: inline-block; margin-top: 4px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">FREE (₹0)</span>' +
                   '    </div>' +
                   '  </label>' +
                   '  <label style="display: flex; align-items: flex-start; gap: 10px; background: ' + (currentChoice === 'katori' ? '#f0f9ff' : '#ffffff') + '; border: ' + (currentChoice === 'katori' ? '2px solid #0284c7' : '1.5px solid #cbd5e1') + '; padding: 14px 16px; border-radius: 10px; cursor: pointer;">' +
                   '    <input type="radio" name="chk_packaging_choice" value="katori" ' + (currentChoice === 'katori' ? 'checked' : '') + ' onchange="onPackagingChoiceChange()" style="margin-top: 3px; accent-color: #0284c7;">' +
                   '    <div>' +
                   '      <strong style="display: block; color: #0369a1; font-size: 13.5px;">🥣 Disposable Katori Bowls</strong>' +
                   '      <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block;">Hygienic single-use disposable bowls me kheer taqseem.</span>' +
                   '      <span style="display: inline-block; margin-top: 4px; background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">+₹300 / Degh</span>' +
                   '    </div>' +
                   '  </label>' +
                   '  <label style="display: flex; align-items: flex-start; gap: 10px; background: ' + (currentChoice === 'mitti_katori' ? '#fffbeb' : '#ffffff') + '; border: ' + (currentChoice === 'mitti_katori' ? '2px solid #d97706' : '1.5px solid #cbd5e1') + '; padding: 14px 16px; border-radius: 10px; cursor: pointer;">' +
                   '    <input type="radio" name="chk_packaging_choice" value="mitti_katori" ' + (currentChoice === 'mitti_katori' ? 'checked' : '') + ' onchange="onPackagingChoiceChange()" style="margin-top: 3px; accent-color: #d97706;">' +
                   '    <div>' +
                   '      <strong style="display: block; color: #92400e; font-size: 13.5px;">🏺 Sacred Mitti Katori Bowls</strong>' +
                   '      <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block;">Traditional sacred clay earthen bowls me barakat wali taqseem.</span>' +
                   '      <span style="display: inline-block; margin-top: 4px; background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">+₹600 / Degh</span>' +
                   '    </div>' +
                   '  </label>' +
                   '</div>';
        } else {
            // Biryani / Zarda / Degh Options: Khula ₹0, Polythin ₹300, Box/Dabba ₹600
            html = '<label style="font-size: 13px; font-weight: 800; color: #064e3b; margin-bottom: 8px; display: block;">' +
                   '  📦 Degh Niyaz Packaging &amp; Distribution Option' +
                   '</label>' +
                   '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px;">' +
                   '  <label style="display: flex; align-items: flex-start; gap: 10px; background: ' + (currentChoice === 'none' ? '#f0fdf4' : '#ffffff') + '; border: ' + (currentChoice === 'none' ? '2px solid #10b981' : '1.5px solid #cbd5e1') + '; padding: 14px 16px; border-radius: 10px; cursor: pointer;">' +
                   '    <input type="radio" name="chk_packaging_choice" value="none" ' + (currentChoice === 'none' ? 'checked' : '') + ' onchange="onPackagingChoiceChange()" style="margin-top: 3px; accent-color: #15803d;">' +
                   '    <div>' +
                   '      <strong style="display: block; color: #065f46; font-size: 13.5px;">🟢 Khula Langar (Direct Taqseem)</strong>' +
                   '      <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block;">Dargah Sharif par zaireen aur miskeenon me direct langar taqseem. (₹0 Extra)</span>' +
                   '      <span style="display: inline-block; margin-top: 4px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">FREE (₹0)</span>' +
                   '    </div>' +
                   '  </label>' +
                   '  <label style="display: flex; align-items: flex-start; gap: 10px; background: ' + (currentChoice === 'polythin' ? '#f0f9ff' : '#ffffff') + '; border: ' + (currentChoice === 'polythin' ? '2px solid #0284c7' : '1.5px solid #cbd5e1') + '; padding: 14px 16px; border-radius: 10px; cursor: pointer;">' +
                   '    <input type="radio" name="chk_packaging_choice" value="polythin" ' + (currentChoice === 'polythin' ? 'checked' : '') + ' onchange="onPackagingChoiceChange()" style="margin-top: 3px; accent-color: #0284c7;">' +
                   '    <div>' +
                   '      <strong style="display: block; color: #0369a1; font-size: 13.5px;">🛍️ Food-Grade Polythin Pouches</strong>' +
                   '      <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block;">Food-grade hygienic sealed polythin packets for easy distribution.</span>' +
                   '      <span style="display: inline-block; margin-top: 4px; background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">+₹300 / Degh</span>' +
                   '    </div>' +
                   '  </label>' +
                   '  <label style="display: flex; align-items: flex-start; gap: 10px; background: ' + (currentChoice === 'box' ? '#fffbeb' : '#ffffff') + '; border: ' + (currentChoice === 'box' ? '2px solid #d97706' : '1.5px solid #cbd5e1') + '; padding: 14px 16px; border-radius: 10px; cursor: pointer;">' +
                   '    <input type="radio" name="chk_packaging_choice" value="box" ' + (currentChoice === 'box' ? 'checked' : '') + ' onchange="onPackagingChoiceChange()" style="margin-top: 3px; accent-color: #d97706;">' +
                   '    <div>' +
                   '      <strong style="display: block; color: #92400e; font-size: 13.5px;">🍱 Container Box / Dabba</strong>' +
                   '      <span style="color: #64748b; font-size: 12px; line-height: 1.4; display: block;">Disposable hygienic meal container boxes for dignified handover.</span>' +
                   '      <span style="display: inline-block; margin-top: 4px; background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">+₹600 / Degh</span>' +
                   '    </div>' +
                   '  </label>' +
                   '</div>';
        }
        container.innerHTML = html;
    }

    function onPackagingChoiceChange() {
        var cart = getCartData();
        renderPackagingOptions(cart);
        updateCheckoutTotals();
    }

    function onDistributionTypeRadioChange() {
        var val = $('input[name="distribution_type"]:checked').val() || '';
        var isDirect = val.toLowerCase().includes('direct handover');
        var isTakeaway = val.toLowerCase().includes('takeaway');
        var isDargah = val.toLowerCase().includes('langar taqseem') || val.toLowerCase().includes('managed');

        $('#distLabelDirect').css({
            'border': isDirect ? '2px solid #10b981' : '1.5px solid #cbd5e1',
            'background': isDirect ? '#f0fdf4' : '#ffffff'
        });
        $('#distLabelTakeaway').css({
            'border': isTakeaway ? '2px solid #0284c7' : '1.5px solid #cbd5e1',
            'background': isTakeaway ? '#f0f9ff' : '#ffffff'
        });
        $('#distLabelDargah').css({
            'border': isDargah ? '2px solid #d97706' : '1.5px solid #cbd5e1',
            'background': isDargah ? '#fffbeb' : '#ffffff'
        });

        updateCheckoutTotals();
    }

    function changeCheckoutQty(index, delta) {
        var cart = getCartData();
        if (cart[index]) {
            if (delta > 0 && cart[index].maxStock && cart[index].qty >= cart[index].maxStock) {
                alert("Only " + cart[index].maxStock + " units available in stock for '" + cart[index].name + "'.");
                return;
            }
            cart[index].qty += delta;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            localStorage.setItem('dewa_cart', JSON.stringify(cart));
            window.dispatchEvent(new Event('dewa-cart-updated'));
            updateHeaderCartBadges();
            renderCheckoutPage();
            renderDeliverySpeedOptions();
        }
    }

    function removeCheckoutItem(index) {
        var cart = getCartData();
        if (cart[index]) {
            cart.splice(index, 1);
            localStorage.setItem('dewa_cart', JSON.stringify(cart));
            window.dispatchEvent(new Event('dewa-cart-updated'));
            updateHeaderCartBadges();
            renderCheckoutPage();
            renderDeliverySpeedOptions();
        }
    }

    function updateHeaderCartBadges() {
        var cart = getCartData();
        var totalQty = cart.reduce(function(sum, item) { return sum + (item.qty || 0); }, 0);
        document.querySelectorAll('.cart-count-badge').forEach(function(b) {
            b.textContent = totalQty;
        });
        if (window.jQuery) {
            $('.cart-count-badge').text(totalQty);
        }
    }

    function processFinalOrder(e) {
        if (e && e.preventDefault) e.preventDefault();
        var name = (document.getElementById('chk_name') || {}).value || '';
        var phone = (document.getElementById('chk_phone') || {}).value || '';
        var street = (document.getElementById('chk_street') || {}).value || '';
        var city = (document.getElementById('chk_city') || {}).value || '';
        var pincode = (document.getElementById('chk_pincode') || {}).value || '';
        var selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        var paymentMethod = selectedMethod ? selectedMethod.value : 'online';

        if (!name || !phone || !street || !pincode) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Address & Contact Required',
                    text: 'Kripya pehle Full Name, Mobile Number, Street Address aur Pincode enter karein.',
                    confirmButtonColor: '#052c16'
                });
            } else {
                alert('Kripya pehle Full Name, Mobile Number, Street Address aur Pincode enter karein.');
            }
            return;
        }

        var cart = getCartData();
        if (cart.length === 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cart is Empty',
                    text: 'Aapka cart khaali hai. Kripya pehle items add karein.',
                    confirmButtonColor: '#052c16'
                });
            } else {
                alert('Aapka cart khaali hai.');
            }
            return;
        }

        var fees = calculateCartFees(cart);

        if (paymentMethod === 'cod') {
            executeShopOrderSave('COD_' + Date.now());
        } else {
            openShopQrModal();
        }
    }

    function executeShopOrderSave(paymentId) {
        $('#btnShopPayOnline').prop('disabled', true).html('⏳ Processing Order & Generating Invoice...');
        $('#btnShopConfirmCod').prop('disabled', true).html('⏳ Booking Cash on Delivery Order...');
        if ($('#btnConfirmShopQrPayment').length) {
            $('#btnConfirmShopQrPayment').prop('disabled', true).html('⏳ Confirming Order...');
        }
        var name = $('#chk_name').val() ? $('#chk_name').val().trim() : 'Pilgrim Customer';
        var phone = $('#chk_phone').val() ? $('#chk_phone').val().trim() : '9648777223';
        var altPhone = $('#chk_alt_phone').val() ? $('#chk_alt_phone').val().trim() : '';
        var street = $('#chk_street').val() ? $('#chk_street').val().trim() : 'Dewa Sharif Dargah Gate';
        var city = $('#chk_city').val() || 'Barabanki';
        var state = $('#chk_state').val() || 'Uttar Pradesh';
        var pincode = $('#chk_pincode').val() ? $('#chk_pincode').val().trim() : '225301';
        var fatehaName = $('#chk_fateha_name').val() ? $('#chk_fateha_name').val().trim() : '';
        var niyazDate = $('#chk_niyaz_date').val() || '';
        var distributionType = $('input[name="distribution_type"]:checked').val() || 'Dargah Sharif Me Langar Taqseem (Distribute to Zaireen)';

        var isDiff = $('#chk_different_receiver').is(':checked');
        var receiverName = isDiff && $('#chk_receiver_name').val() ? $('#chk_receiver_name').val().trim() : '';
        var receiverPhone = isDiff && $('#chk_receiver_phone').val() ? $('#chk_receiver_phone').val().trim() : '';
        if (isDiff && receiverName) {
            street = '🎁 RECIPIENT: ' + receiverName + (receiverPhone ? ' (Mob: ' + receiverPhone + ')' : '') + ' | ' + street;
        }

        try {
            localStorage.setItem('dewa_chk_name', name);
            localStorage.setItem('dewa_chk_phone', phone);
            localStorage.setItem('dewa_chk_street', $('#chk_street').val() || '');
            localStorage.setItem('dewa_chk_pincode', pincode);
        } catch(e) {}

        var cart = getCartData();
        var fees = calculateCartFees(cart);
        var itemsSummary = cart.map(function(item){ return item.name + ' (x' + item.qty + ')'; }).join(', ') || 'Attar & Sufi Handicrafts';

        $.ajax({
            url: "{{ route('shops.book') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                name: name,
                phone: phone,
                alternate_phone: altPhone,
                address: street,
                city: city,
                state: state,
                pincode: pincode,
                items_summary: itemsSummary,
                amount: fees.grandTotal,
                subtotal: fees.subtotal,
                packaging_fee: fees.packagingFee,
                packaging_type: fees.packagingType || 'none',
                distribution_fee: fees.distributionFee || 0,
                handling_fee: fees.handlingFee,
                delivery_fee: fees.deliveryFee,
                cod_fee: fees.codFee,
                delivery_tier: fees.selectedTier,
                payment_id: paymentId,
                payment_mode: (fees.paymentMethod === 'cod' ? 'cod' : 'PhonePe QR'),
                fateha_name: fatehaName,
                niyaz_date: niyazDate,
                distribution_type: distributionType,
                cart_items: localStorage.getItem('dewa_cart')
            },
            success: function(response) {
                localStorage.removeItem('dewa_cart');
                if(response.success) {
                    var displayCust = name + ' (' + phone + (altPhone ? ' / Alt: ' + altPhone : '') + ')';
                    triggerShopSuccessOverlay(response, fees.grandTotal, displayCust);
                } else {
                    window.location.href = "{{ route('customer.orders') }}";
                }
            },
            error: function(err) {
                localStorage.removeItem('dewa_cart');
                window.location.href = "{{ route('customer.orders') }}";
            }
        });
    }

    function triggerShopSuccessOverlay(response, amount, custInfo) {
        $('#succBookingCode').text('#' + (response.booking_code || 'DWS-ORD-2026'));
        $('#succAmountPaid').text('₹' + parseFloat(amount).toLocaleString('en-IN'));
        $('#succCustomerInfo').text(custInfo);

        $('#paymentSuccessOverlay').css('display', 'flex');

        var secondsLeft = 5;
        $('#succCountdown').text(secondsLeft);
        $('#succProgressBar').css('width', '100%');

        var targetUrl = response.redirect_url || "{{ route('customer.orders') }}";

        $('#btnGoDashboard').off('click').on('click', function() {
            window.location.href = targetUrl;
        });

        var timerInt = setInterval(function() {
            secondsLeft--;
            if (secondsLeft < 0) secondsLeft = 0;
            $('#succCountdown').text(secondsLeft);
            var pct = (secondsLeft / 5) * 100;
            $('#succProgressBar').css('width', pct + '%');

            if (secondsLeft <= 0) {
                clearInterval(timerInt);
                window.location.href = targetUrl;
            }
        }, 1000);
    }

    var worldCountriesCache = [];
    var worldStatesCache = {};
    var worldCitiesCache = {};

    function loadWorldCountries() {
        var countrySel = document.getElementById('chk_country');
        if (!countrySel) return;

        fetch('https://countriesnow.space/api/v0.1/countries/iso')
            .then(function(res) { return res.json(); })
            .then(function(json) {
                if (json && json.data && Array.isArray(json.data) && json.data.length > 0) {
                    worldCountriesCache = json.data;
                    renderWorldCountryOptions(json.data);
                } else {
                    onWorldCountryChange();
                }
            })
            .catch(function(err) {
                console.log("Using fallback country select", err);
                onWorldCountryChange();
            });
    }

    function renderWorldCountryOptions(countriesList) {
        var countrySel = document.getElementById('chk_country');
        if (!countrySel) return;
        var selectedVal = countrySel.value || "India";
        countrySel.innerHTML = '';

        countriesList.forEach(function(c) {
            var cName = c.name || c.country;
            var opt = document.createElement('option');
            opt.value = cName;
            opt.textContent = (c.Iso2 ? (c.Iso2 + ' ') : '') + cName;
            if (cName.toLowerCase() === 'india') {
                opt.selected = true;
            }
            countrySel.appendChild(opt);
        });

        if (selectedVal && selectedVal !== 'India') {
            countrySel.value = selectedVal;
        }

        onWorldCountryChange();
    }

    function onWorldCountryChange() {
        var countrySel = document.getElementById('chk_country');
        var stateSel = document.getElementById('chk_state');
        var citySel = document.getElementById('chk_city');
        if (!countrySel || !stateSel) return;

        var selectedCountry = countrySel.value || "India";
        stateSel.innerHTML = '<option value="">⏳ Loading States...</option>';
        if (citySel) citySel.innerHTML = '<option value="">⏳ Select State First</option>';

        if (worldStatesCache[selectedCountry]) {
            renderWorldStateOptions(selectedCountry, worldStatesCache[selectedCountry]);
            return;
        }

        // 1. Try local MySQL database API first
        fetch('/api/location/states/' + encodeURIComponent(selectedCountry))
            .then(function(res) { return res.json(); })
            .then(function(json) {
                if (json && json.status && Array.isArray(json.data) && json.data.length > 0) {
                    var stateNames = json.data.map(function(s) { return s.name; });
                    worldStatesCache[selectedCountry] = stateNames;
                    renderWorldStateOptions(selectedCountry, stateNames);
                } else {
                    fetchExternalStates(selectedCountry);
                }
            })
            .catch(function() {
                fetchExternalStates(selectedCountry);
            });
    }

    function fetchExternalStates(selectedCountry) {
        fetch('https://countriesnow.space/api/v0.1/countries/states', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: selectedCountry })
        })
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json && json.data && json.data.states && Array.isArray(json.data.states) && json.data.states.length > 0) {
                var stateNames = json.data.states.map(function(s) { return s.name; });
                worldStatesCache[selectedCountry] = stateNames;
                renderWorldStateOptions(selectedCountry, stateNames);
            } else {
                renderWorldStateOptions(selectedCountry, ["Main State / Region"]);
            }
        })
        .catch(function(err) {
            renderWorldStateOptions(selectedCountry, ["Uttar Pradesh", "Delhi", "Maharashtra", "Other State"]);
        });
    }

    function renderWorldStateOptions(country, statesList) {
        var stateSel = document.getElementById('chk_state');
        if (!stateSel) return;
        stateSel.innerHTML = '';

        if (!statesList || statesList.length === 0) {
            statesList = ["General Region"];
        }

        statesList.forEach(function(stName) {
            var opt = document.createElement('option');
            opt.value = stName;
            opt.textContent = stName;
            if (country.toLowerCase() === 'india' && stName.toLowerCase().includes('uttar pradesh')) {
                opt.selected = true;
            }
            stateSel.appendChild(opt);
        });

        onWorldStateChange();
    }

    function onWorldStateChange() {
        var countrySel = document.getElementById('chk_country');
        var stateSel = document.getElementById('chk_state');
        var citySel = document.getElementById('chk_city');
        if (!countrySel || !stateSel || !citySel) return;

        var selectedCountry = countrySel.value || "India";
        var selectedState = stateSel.value || "Uttar Pradesh";
        var cacheKey = selectedCountry + '_' + selectedState;

        citySel.innerHTML = '<option value="">⏳ Loading Cities...</option>';

        if (worldCitiesCache[cacheKey]) {
            renderWorldCityOptions(selectedCountry, selectedState, worldCitiesCache[cacheKey]);
            return;
        }

        // 1. Try local MySQL database API first
        fetch('/api/location/cities/' + encodeURIComponent(selectedState))
            .then(function(res) { return res.json(); })
            .then(function(json) {
                if (json && json.status && Array.isArray(json.data) && json.data.length > 0) {
                    var cityNames = json.data.map(function(c) { return c.name; });
                    worldCitiesCache[cacheKey] = cityNames;
                    renderWorldCityOptions(selectedCountry, selectedState, cityNames);
                } else {
                    fetchExternalCities(selectedCountry, selectedState);
                }
            })
            .catch(function() {
                fetchExternalCities(selectedCountry, selectedState);
            });
    }

    function fetchExternalCities(selectedCountry, selectedState) {
        var cacheKey = selectedCountry + '_' + selectedState;
        fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: selectedCountry, state: selectedState })
        })
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json && json.data && Array.isArray(json.data) && json.data.length > 0) {
                worldCitiesCache[cacheKey] = json.data;
                renderWorldCityOptions(selectedCountry, selectedState, json.data);
            } else {
                fetchCountryLevelCities(selectedCountry, selectedState);
            }
        })
        .catch(function() {
            fetchCountryLevelCities(selectedCountry, selectedState);
        });
    }

    function fetchCountryLevelCities(country, state) {
        var cacheKey = country + '_' + state;
        fetch('https://countriesnow.space/api/v0.1/countries/cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: country })
        })
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json && json.data && Array.isArray(json.data) && json.data.length > 0) {
                worldCitiesCache[cacheKey] = json.data;
                renderWorldCityOptions(country, state, json.data);
            } else {
                renderWorldCityOptions(country, state, ["Barabanki", "Lucknow", "Kanpur", "Other City"]);
            }
        })
        .catch(function() {
            renderWorldCityOptions(country, state, ["Barabanki", "Lucknow", "Kanpur", "Other City"]);
        });
    }

    function renderWorldCityOptions(country, state, citiesList) {
        var citySel = document.getElementById('chk_city');
        if (!citySel) return;
        citySel.innerHTML = '';

        if (!citiesList || citiesList.length === 0) {
            citiesList = ["Main City"];
        }

        citiesList.forEach(function(ctName) {
            var opt = document.createElement('option');
            opt.value = ctName;
            opt.textContent = ctName;
            if (ctName.toLowerCase() === 'barabanki') {
                opt.selected = true;
            }
            citySel.appendChild(opt);
        });
    }

    function generateDynamicUpi(amount, note) {
        var upiId = '9648777223@ybl';
        var payeeName = 'SHAHZADE ALAM';
        var cleanAmount = (parseFloat(amount) || 0).toFixed(2);
        var noteText = note || 'Dewa Sharif Store';
        
        var upiUri = 'upi://pay?pa=' + encodeURIComponent(upiId) +
                     '&pn=' + encodeURIComponent(payeeName) +
                     '&am=' + encodeURIComponent(cleanAmount) +
                     '&cu=INR' +
                     '&tn=' + encodeURIComponent(noteText);
                     
        var qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=8&data=' + encodeURIComponent(upiUri);
        return {
            uri: upiUri,
            qr: qrImgUrl,
            amount: cleanAmount
        };
    }

    function openShopQrModal() {
        var name = ($('#chk_name').val() || '').trim();
        var phone = ($('#chk_phone').val() || '').trim();
        var street = ($('#chk_street').val() || '').trim();
        var pincode = ($('#chk_pincode').val() || '').trim();

        if (!name || !phone || !street || !pincode) {
            Swal.fire({
                icon: 'warning',
                title: 'Address & Contact Required',
                text: 'Kripya pehle Full Name, Mobile Number, Street Address aur Pincode enter karein.',
                confirmButtonColor: '#052c16'
            });
            return;
        }

        var cart = getCartData();
        if (cart.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Cart is Empty',
                text: 'Aapka cart khaali hai. Kripya pehle items add karein.',
                confirmButtonColor: '#052c16'
            });
            return;
        }

        var fees = calculateCartFees(cart);
        var formattedTotal = Number(fees.grandTotal).toLocaleString('en-IN');
        $('#shopQrPayAmountText').text('₹' + formattedTotal);

        var upiData = generateDynamicUpi(fees.grandTotal, 'Dewa Sharif Store Order');
        $('#shopDynamicQrImg').attr('src', upiData.qr);
        $('#shopDirectUpiBtn').attr('href', upiData.uri);
        $('#shopDirectUpiAmount').text('₹' + formattedTotal);

        $('#shopQrModalOverlay').css('display', 'flex');
    }

    function closeShopQrModal() {
        $('#shopQrModalOverlay').hide();
    }

    function copyUpiId(btn) {
        var upi = '9648777223@ybl';
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(upi);
        } else {
            var tempInput = document.createElement('input');
            tempInput.value = upi;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }
        if (btn) {
            var originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
            btn.style.background = '#16a34a';
            setTimeout(function() {
                btn.innerHTML = originalHtml;
                btn.style.background = '#0f172a';
            }, 2000);
        }
    }

    function sendShopQrWhatsApp() {
        var name = ($('#chk_name').val() || '').trim();
        var phone = ($('#chk_phone').val() || '').trim();
        var altPhone = ($('#chk_alt_phone').val() || '').trim();
        var street = ($('#chk_street').val() || '').trim();
        var city = ($('#chk_city').val() || '').trim();
        var state = ($('#chk_state').val() || '').trim();
        var pincode = ($('#chk_pincode').val() || '').trim();

        var cart = getCartData();
        var fees = calculateCartFees(cart);
        var itemsSummary = cart.map(function(item){ return "• " + item.name + " (Qty: " + item.qty + ") - ₹" + (item.price * item.qty); }).join("\n");

        closeShopQrModal();
        executeShopOrderSave('PhonePe QR (Screenshot on WhatsApp)');

        var custStr = name + " (" + phone + (altPhone ? " / Alt: " + altPhone : "") + ")";
        var text = "Assalamu Alaikum Dewa Sharif Store!\n\n" +
                   "Maine PhonePe QR se payment kar diya hai:\n" +
                   "💰 Total Paid: ₹" + Number(fees.grandTotal).toLocaleString('en-IN') + "\n\n" +
                   "📋 *Order Bill Breakdown:*\n" +
                   "• Items Subtotal: ₹" + fees.subtotal.toLocaleString('en-IN') + "\n" +
                   "• Packaging Fee: ₹" + fees.packagingFee.toLocaleString('en-IN') + "\n" +
                   "• Handling Fee: ₹" + fees.handlingFee.toLocaleString('en-IN') + "\n" +
                   "• Delivery (" + fees.deliveryTierName + "): " + (fees.deliveryFee === 0 ? "FREE (₹0)" : "₹" + fees.deliveryFee.toLocaleString('en-IN')) + "\n\n" +
                   "📦 *Items Ordered:*\n" + itemsSummary + "\n\n" +
                   "👤 *Customer:* " + custStr + "\n" +
                   "📍 *Delivery Address:* " + street + ", " + city + ", " + state + " - " + pincode + "\n\n" +
                   "Maine payment ka screenshot WhatsApp par attach kar diya hai. Kripya order dispatch confirm karein. Shukriya!";

        window.open("https://wa.me/919648777223?text=" + encodeURIComponent(text), '_blank');
    }

    function checkoutShopWhatsAppDirect() {
        var name = ($('#chk_name').val() || '').trim();
        var phone = ($('#chk_phone').val() || '').trim();
        var altPhone = ($('#chk_alt_phone').val() || '').trim();
        var street = ($('#chk_street').val() || '').trim();
        var city = ($('#chk_city').val() || '').trim();
        var state = ($('#chk_state').val() || '').trim();
        var pincode = ($('#chk_pincode').val() || '').trim();

        var cart = getCartData();
        if (cart.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Cart Empty',
                text: 'Aapka cart khaali hai!',
                confirmButtonColor: '#052c16'
            });
            return;
        }

        var fees = calculateCartFees(cart);
        var itemsSummary = cart.map(function(item){ return "• " + item.name + " (Qty: " + item.qty + ") - ₹" + (item.price * item.qty); }).join("\n");
        var itemsBrief = cart.map(function(item){ return item.name + " (x" + item.qty + ")"; }).join(", ");
        var custStr = (name || "Customer") + (phone ? " (" + phone + (altPhone ? " / Alt: " + altPhone : "") + ")" : "");
        var addrStr = street ? (street + ", " + city + ", " + state + " - " + pincode) : "Will provide on WhatsApp";

        var code = 'DWS-SHP-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000);

        var text = "Assalamu Alaikum Dewa Sharif Store!\n\n" +
                   "Main sacred shop items order karna chahta hun:\n" +
                   "🛍️ *Order Ref:* #" + code + "\n\n" +
                   "📋 *Order Bill Breakdown:*\n" +
                   "• Items Subtotal: ₹" + fees.subtotal.toLocaleString('en-IN') + "\n" +
                   "• Packaging Fee: ₹" + fees.packagingFee.toLocaleString('en-IN') + "\n" +
                   "• Handling Fee: ₹" + fees.handlingFee.toLocaleString('en-IN') + "\n" +
                   "• Delivery (" + fees.deliveryTierName + "): " + (fees.deliveryFee === 0 ? "FREE (₹0)" : "₹" + fees.deliveryFee.toLocaleString('en-IN')) + "\n" +
                   (fees.codFee > 0 ? ("• COD Convenience Fee: ₹" + fees.codFee.toLocaleString('en-IN') + "\n") : "") +
                   "💰 *Grand Total:* ₹" + Number(fees.grandTotal).toLocaleString('en-IN') + "\n\n" +
                   "📦 *Items:*\n" + itemsSummary + "\n\n" +
                   "👤 *Customer:* " + custStr + "\n" +
                   "📍 *Delivery Address:* " + addrStr + "\n\n" +
                   "Kripya confirmation aur delivery details bhejein. Shukriya!";

        var waUrl = "https://wa.me/919648777223?text=" + encodeURIComponent(text);

        window.open(waUrl, '_blank');

        $.ajax({
            url: "{{ route('shops.book') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                order_code: code,
                name: name || 'Pilgrim Customer',
                phone: phone || '9648777223',
                alternate_phone: altPhone,
                address: street || 'Dewa Sharif Dargah Gate',
                city: city || 'Barabanki',
                state: state || 'Uttar Pradesh',
                pincode: pincode || '225301',
                items_summary: itemsBrief,
                amount: fees.grandTotal,
                subtotal: fees.subtotal,
                packaging_fee: fees.packagingFee,
                handling_fee: fees.handlingFee,
                delivery_fee: fees.deliveryFee,
                cod_fee: fees.codFee,
                delivery_tier: fees.selectedTier,
                booking_mode: 'whatsapp',
                payment_mode: 'whatsapp',
                payment_id: 'WhatsApp Order (' + code + ')',
                cart_items: localStorage.getItem('dewa_cart')
            },
            success: function(response) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'WhatsApp Chat Opened!',
                        html: '<p style="font-size:14px;color:#475569;">Aapka Shop Order Request Ref <b>#' + code + '</b> register ho gaya hai. Humne WhatsApp khol diya hai, kripya wahan Send button press karein.</p>',
                        confirmButtonColor: '#052c16'
                    });
                }
            },
            error: function(err) {}
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        renderCheckoutPage();
        renderDeliverySpeedOptions();
        updateCheckoutTotals();
        loadWorldCountries();

        var pinEl = document.getElementById('chk_pincode');
        if (pinEl) {
            pinEl.addEventListener('input', function() {
                renderDeliverySpeedOptions();
                updateCheckoutTotals();
            });
            pinEl.addEventListener('change', function() {
                renderDeliverySpeedOptions();
                updateCheckoutTotals();
            });
        }
        var cityEl = document.getElementById('chk_city');
        if (cityEl) {
            cityEl.addEventListener('change', function() {
                renderDeliverySpeedOptions();
                updateCheckoutTotals();
            });
        }
    });
</script>

<!-- PHONEPE / UPI QR CODE MODAL OVERLAY -->
<div id="shopQrModalOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 24px; padding: 28px 24px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; max-height: 90vh; overflow-y: auto; animation: popIn 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        
        <!-- CLOSE BUTTON (X) -->
        <button type="button" onclick="closeShopQrModal()" style="position: absolute; top: 16px; right: 18px; background: #f1f5f9; border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 18px; font-weight: bold; color: #475569; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
            ✕
        </button>

        <!-- HEADER BADGE -->
        <div style="display: inline-flex; align-items: center; gap: 8px; background: #fef3c7; border: 1.5px solid #fde68a; padding: 6px 16px; border-radius: 30px; margin-bottom: 12px;">
            <i class="fa fa-qrcode" style="color: #b45309; font-size: 16px;"></i>
            <span style="font-size: 12px; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">PhonePe &amp; All UPI Apps Accepted</span>
        </div>

        <h4 style="font-weight: 900; color: #0f172a; margin-bottom: 4px; font-size: 20px; text-align: center !important;">
            Scan &amp; Pay via QR Code
        </h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 14px; text-align: center !important; width: 100%; display: block; margin-left: auto; margin-right: auto;">
            Pay directly to Merchant: <strong style="color: #0f172a;">SHAHZADE ALAM</strong>
        </p>

        <!-- AMOUNT TO PAY BANNER -->
        <div style="background: linear-gradient(135deg, #052c16 0%, #074121 100%); color: #ffffff; border-radius: 12px; padding: 12px; margin-bottom: 14px;">
            <span style="font-size: 11.5px; font-weight: 700; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Total Amount to Pay</span>
            <span style="font-size: 26px; font-weight: 900; color: #4ade80;" id="shopQrPayAmountText">₹0</span>
        </div>

        <!-- DYNAMIC QR IMAGE WITH AUTO AMOUNT EMBEDDED -->
        <div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 12px; margin-bottom: 14px; display: inline-block; max-width: 290px; width: 100%; box-sizing: border-box;">
            <div style="position: relative; width: 230px; height: 230px; margin: 0 auto; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.06); overflow: hidden;">
                <img id="shopDynamicQrImg" 
                     src="{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}" 
                     alt="PhonePe Dynamic QR Code" 
                     onerror="this.src='{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}'"
                     style="width: 100%; height: 100%; object-fit: contain; display: block;">
            </div>
            <div style="margin-top: 8px; font-size: 11px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                ✔ Amount Pre-filled on Scan
            </div>
            <div style="margin-top: 6px; font-size: 11.5px; font-weight: 700; color: #475569; text-align: center;">
                📱 PhonePe • Google Pay • Paytm • BHIM
            </div>
            
            <!-- UPI ID BOX WITH 1-CLICK COPY -->
            <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 7px 10px; margin-top: 10px; display: flex; align-items: center; justify-content: space-between; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                <div style="text-align: left; overflow: hidden;">
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase; display: block; line-height: 1;">UPI ID</span>
                    <span style="font-size: 13px; font-weight: 900; color: #0f172a; font-family: monospace; letter-spacing: 0.2px;">9648777223@ybl</span>
                </div>
                <button type="button" onclick="copyUpiId(this)" style="background: #0f172a; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s; white-space: nowrap;">
                    <i class="fa fa-clone"></i> <span>Copy</span>
                </button>
            </div>
        </div>

        <!-- 1-TAP DIRECT UPI APP PAYMENT BUTTON (MOBILE FRIENDLY) -->
        <div style="margin-bottom: 12px;">
            <a id="shopDirectUpiBtn" 
               href="upi://pay?pa=9648777223@ybl&pn=SHAHZADE%20ALAM&cu=INR&tn=Dewa%20Sharif%20Store%20Order" 
               class="btn w-100 font-extrabold" 
               style="background: linear-gradient(135deg, #5f259f 0%, #3f156d 100%); color: #ffffff; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(95, 37, 159, 0.35); white-space: normal !important; text-align: center; flex-wrap: wrap; line-height: 1.35; box-sizing: border-box;">
                <i class="fa fa-mobile" style="font-size: 22px; flex-shrink: 0;"></i>
                <span>Tap to Pay <strong id="shopDirectUpiAmount">₹0</strong> via PhonePe / GPay</span>
            </a>
            <small style="color: #64748b; font-size: 11px; display: block; margin-top: 4px;">(If on mobile, tap above to open UPI app directly without scanning)</small>
        </div>

        <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 12px 14px; margin-bottom: 16px; text-align: center;">
            <span style="font-size: 12.5px; font-weight: 700; color: #166534; display: block;">
                📸 Payment karne ke baad neeche diye button se screenshot WhatsApp par bhejein.
            </span>
        </div>

        <!-- SINGLE ACTION BUTTON IN MODAL -->
        <div>
            <button type="button" onclick="sendShopQrWhatsApp()" class="btn w-100 font-extrabold" style="background: #25D366; color: #ffffff; font-weight: 900; border-radius: 10px; min-height: 48px; height: auto; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 16px rgba(37, 211, 102, 0.4); display: flex; align-items: center; justify-content: center; gap: 8px; white-space: normal !important; text-align: center; line-height: 1.35; flex-wrap: wrap; box-sizing: border-box;">
                <i class="fa fa-whatsapp" style="font-size: 20px; flex-shrink: 0;"></i>
                <span>Send Screenshot &amp; Confirm on WhatsApp</span>
            </button>
        </div>

    </div>
</div>

<!-- HOSTLOK STYLE PAYMENT SUCCESS MODAL OVERLAY -->
<div id="paymentSuccessOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(17, 24, 39, 0.88); backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 500px; border-radius: 24px; padding: 35px 30px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        
        <!-- Animated Green Success Checkmark Badge -->
        <div style="width: 85px; height: 85px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 42px; box-shadow: 0 10px 25px rgba(22,163,74,0.3); border: 3.5px solid #22c55e;">
            ✓
        </div>

        <h3 style="font-weight: 900; color: #111827; margin-bottom: 6px; font-size: 24px; letter-spacing: -0.3px;">
            🎉 Payment Successful!
        </h3>
        <p style="color: #64748b; font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            Money Credited to Dewa Sharif Store (SBI A/C). Order confirmed!
        </p>

        <!-- Details Summary Box -->
        <div style="background: #f8fafc; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 18px; margin-bottom: 22px; text-align: left; font-size: 13.5px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #64748b; font-weight: 700;">Order Reference:</span>
                <span style="font-weight: 900; color: #0f172a;" id="succBookingCode">#DWS-ORD-2026</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #64748b; font-weight: 700;">Amount Paid:</span>
                <span style="font-weight: 900; color: #16a34a; font-size: 16px;" id="succAmountPaid">₹0</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #64748b; font-weight: 700;">Customer / Contact:</span>
                <span style="font-weight: 800; color: #334155;" id="succCustomerInfo">-</span>
            </div>
        </div>

        <!-- 5-Second Countdown Bar -->
        <div style="margin-bottom: 22px;">
            <p style="font-weight: 800; color: #111827; font-size: 14px; margin-bottom: 10px;">
                ⌛ Redirecting to your Orders Dashboard in <span id="succCountdown" style="color: #e11d48; font-size: 18px; font-weight: 900;">5</span> seconds...
            </p>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div id="succProgressBar" style="width: 100%; height: 100%; background: linear-gradient(90deg, #16a34a, #22c55e); transition: width 1s linear;"></div>
            </div>
        </div>

        <!-- Action Button -->
        <div style="display: flex; gap: 12px; justify-content: center;">
            <button type="button" id="btnGoDashboard" class="btn" style="background: #111827; color: #f59e0b; font-weight: 900; font-size: 14px; padding: 12px 24px; border-radius: 10px; flex: 1; border: none; box-shadow: 0 4px 12px rgba(17,24,39,0.3);">
                🚀 Go to Orders Dashboard Now
            </button>
        </div>

    </div>
</div>

<style>
@keyframes popIn {
    0% { transform: scale(0.7); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endsection
