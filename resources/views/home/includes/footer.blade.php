@php
    $curSetting = $setting ?? new \App\Models\Setting();
    $sitePhone = ($curSetting->website_phone ?? null) ?: (($curSetting->phone ?? null) ?: (($curSetting->support_phone ?? null) ?: '+91 9648777223'));
    $siteWhatsapp = ($curSetting->whatsapp ?? null) ?: $sitePhone;
    $siteEmail = ($curSetting->website_email ?? null) ?: (($curSetting->company_email ?? null) ?: 'info@dewasharif.com');
    $siteAddress = ($curSetting->address ?? null) ?: 'Town Dewa Sharif, Barabanki, Uttar Pradesh - 225301, India';
    $siteWhatsappDigits = preg_replace('/\D+/', '', $siteWhatsapp);
    if (strlen($siteWhatsappDigits) === 10) {
        $cleanWaDigits = '91' . $siteWhatsappDigits;
    } elseif (strlen($siteWhatsappDigits) === 11 && str_starts_with($siteWhatsappDigits, '0')) {
        $cleanWaDigits = '91' . substr($siteWhatsappDigits, 1);
    } else {
        $cleanWaDigits = $siteWhatsappDigits ?: '919648777223';
    }
@endphp

<div class="monument_footer">
    <img src="{{ asset('home/images/dewasharif/colorfooter.png') }}" alt="Dewa Sharif Dargah Skyline"
        style="width: 100%; display: block;" />
</div>

<footer>
    <div class="footer">
        <div class="container">
            <div class="footer-column">
                <div class="row">

                    <!-- Col 1: Contact Info & Local Guidance Entity -->
                    <div class="col-md-3 col-sm-6">
                        <h3 class="footer-heading">Contact Info</h3>
                        <ul class="connect_new">
                            <li class="widget_contacts_address">
                                <div class="icon"><img src="{{ asset('home/images/f_i_1.png') }}"
                                        alt="Dewa Sharif Location" /></div>
                                <div class="text">
                                    <strong>Dargah Hazrat Waris Ali Shah</strong><br>
                                    {{ $siteAddress }}
                                </div>
                            </li>
                            <li>
                                <div class="icon"><img src="{{ asset('home/images/f_i_1.png') }}" alt="Phone" /></div>
                                <div class="text"><a href="tel:{{ preg_replace('/[^\d+]/', '', $sitePhone) }}">{{ $sitePhone }}</a></div>
                            </li><br>
                            <li>
                                <div class="icon"><img src="{{ asset('home/images/f_i_1.png') }}" alt="WhatsApp" /></div>
                                <div class="text"><a href="https://wa.me/{{ $cleanWaDigits }}" target="_blank" rel="noopener">WhatsApp: {{ $siteWhatsapp }}</a></div>
                            </li><br>
                            <li>
                                <div class="icon"><img src="{{ asset('home/images/f_i_2.png') }}" alt="Email" /></div>
                                <div class="text">
                                    <a href="mailto:{{ $siteEmail }}" class="local">{{ $siteEmail }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-9 col-sm-6">
                        <div class="row">

                            <!-- Col 2: Holy Sites & Awliya Links -->
                            <div class="col-md-3 col-sm-6">
                                <h3 class="footer-heading">Dewa &amp; Spiritual</h3>
                                <ul id="aup" class="f-link">
                                    <li><a href="{{ route('allah') }}" target="_blank" rel="noopener">Allah (S.W.T)</a>
                                    </li>
                                    <li><a href="{{ route('hazratmuhammad') }}" target="_blank" rel="noopener">Muhammad
                                            (ﷺ)</a></li>
                                    <li><a href="{{ route('hajiwarisalishah') }}" target="_blank" rel="noopener">Haji
                                            Waris Ali Shah</a></li>
                                    <li><a href="{{ route('history') }}" target="_blank" rel="noopener">Dewa Sharif
                                            History</a></li>
                                    <li><a href="{{ route('mazar') }}" target="_blank" rel="noopener">Mazar Sharif
                                            Dewa</a></li>
                                    <li><a href="{{ route('mosquedargah') }}" target="_blank" rel="noopener">Masjid Al
                                            Waris</a></li>
                                </ul>
                            </div>

                            <!-- Col 3: Visitor Services & Booking Assistance -->
                            <div class="col-md-3 col-sm-6">
                                <h3 class="footer-heading">Services &amp; Stay</h3>
                                <ul class="f-link">
                                    <li><a href="{{ route('hotels') }}">Hotels &amp; Guest House</a></li>
                                        <li><a href="https://wa.me/{{ $siteWhatsappDigits }}?text=Assalam%20Alaikum,%20Mujhe%20Dewa%20Sharif%20me%20Cab%20Taxi%20booking%20chahiye"
                                            target="_blank" rel="noopener">Lucknow - Dewa Cab</a></li>
                                        <li><a href="https://wa.me/{{ $siteWhatsappDigits }}?text=Assalam%20Alaikum,%20Mujhe%20Biryani%20Degh%20aur%20Chadar%20peshi%20karwani%20hai"
                                            target="_blank" rel="noopener">Degh Niyaz &amp; Chadar</a></li>
                                        <li><a href="https://wa.me/{{ $siteWhatsappDigits }}?text=Assalam%20Alaikum,%20Mujhe%20Warsi%20Attar%20aur%20Tasbih%20chahiye"
                                            target="_blank" rel="noopener">Warsi Attar &amp; Tasbih</a></li>
                                    <li><a href="{{ route('mela') }}">Dewa Mela 2026 Dates</a></li>
                                    <li><a href="{{ route('langarkhana') }}">Langarkhana &amp; Tabarruk</a></li>
                                </ul>
                            </div>

                            <!-- Col 4: Policies -->
                            <div class="col-md-3 col-sm-6">
                                <h3 class="footer-heading">Policies</h3>
                                <ul id="policy" class="f-link">
                                    <li><a href="{{ route('terms') }}" target="_blank" rel="noopener">Terms &amp;
                                            Conditions</a></li>
                                    <li><a href="{{ route('copyright') }}" target="_blank" rel="noopener">Copyright
                                            Policy</a></li>
                                    <li><a href="{{ route('privacy') }}" target="_blank" rel="noopener">Privacy
                                            Policy</a></li>
                                    <li><a href="{{ route('disclaimer') }}" target="_blank"
                                            rel="noopener">Disclaimer</a></li>
                                </ul>
                            </div>

                            <!-- Col 5: Quick Travel Links -->
                            <div class="col-md-3 col-sm-6">
                                <h3 class="footer-heading">Visitor Guidance</h3>
                                <ul class="f-link">
                                    <li><a href="https://maps.app.goo.gl/LFx8yPuFLQLn79ow6" target="_blank"
                                            rel="noopener">Dewa Sharif Map</a></li>
                                    <li><a href="https://mausam.imd.gov.in/" target="_blank" rel="noopener">Weather
                                            Forecast</a></li>
                                    <li><a href="{{ route('faqs') }}" target="_blank" rel="noopener">Dewa FAQs</a></li>
                                    <li><a href="{{ route('dosanddonts') }}" target="_blank" rel="noopener">DOs &amp;
                                            Don’ts</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footbtm">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <p style="line-height: 1.7; font-size: 13.5px; color: #ffffff;">
                            Informational guide and pilgrimage assistance portal for visitors traveling to <strong>Dewa
                                Sharif, Barabanki, Uttar Pradesh, India</strong>. Dedicated to the universal Sufi
                            teachings of <strong>Hazrat Haji Waris Ali Shah (R.A.)</strong>, <strong>Dewa Mela
                                2026</strong> updates, nearby accommodations, travel cabs from Lucknow, and ziyarat
                            guidance.<br>
                            Content on this website is voluntarily created and independently managed by
                            <strong class="color-toggle-yellow">SHAHZADE ALAM [Masharrat Warsi]</strong>, Dewa Sharif.
                        </p>

                        <!-- Legal Safe Notice & Safe Harbor Clause -->
                        <div
                            style="background: rgba(0, 0, 0, 0.45); border-left: 3px solid #ffeb3b; padding: 10px 14px; margin: 12px 0; border-radius: 4px;">
                            <p style="margin: 0; line-height: 1.6; font-size: 12px; color: #f0f0f0;">
                                <strong style="color: #ffeb3b;">LEGAL NOTICE &amp; DISCLAIMER:</strong> This is a
                                privately run, independent community facilitation portal. It is <strong>NOT</strong> an
                                official portal of, nor run by, nor affiliated with the <strong>Official Dargah
                                    Committee, Trust, Waqf Board, or any Government Administration</strong>. We do not
                                claim official authority nor collect any official religious donations on their behalf.
                            </p>
                            <p style="margin: 6px 0 0 0; line-height: 1.5; font-size: 11.5px; color: #00e676;">
                                <strong>Grievance &amp; Content Clarification:</strong> All information is provided in
                                good faith for visitor convenience. If any authority, trust, or individual has any
                                concern, suggestion, copyright inquiry, or objection regarding any content or photo,
                                please write to us immediately at our direct email. We will address, correct, or
                                promptly remove the content within 24 to 48 hours without dispute.
                            </p>
                        </div>

                        <!-- Social Handles -->
                        <div style="margin: 14px 0; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                            <a href="https://www.instagram.com/masharrat_bin_barkat/" target="_blank" rel="noopener"
                                title="Follow on Instagram"
                                style="display:inline-block; transition: transform 0.2s ease, filter 0.2s ease;"
                                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg"
                                    alt="Instagram" style="width:36px; height:36px; border-radius: 9px; vertical-align: middle;">
                            </a>

                            <a href="https://wa.me/{{ $cleanWaDigits }}" target="_blank" rel="noopener"
                                title="Chat on WhatsApp ({{ $siteWhatsapp }})"
                                style="display:inline-block; transition: transform 0.2s ease, filter 0.2s ease;"
                                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <img src="{{ asset('home/images/whatsapp.svg') }}" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg'"
                                    alt="WhatsApp" style="width:36px; height:36px; vertical-align: middle;">
                            </a>

                            <a href="mailto:{{ $siteEmail }}"
                                title="Send Email ({{ $siteEmail }})"
                                target="_blank" rel="noopener"
                                style="display:inline-block; transition: transform 0.2s ease, filter 0.2s ease;"
                                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png"
                                    alt="Email" style="width:36px; height:36px; vertical-align: middle;">
                            </a>
                        </div>

                        <strong style="color: #ffffff;">Direct Email for Inquiries &amp; Grievances:</strong>
                        <a href="mailto:{{ $siteEmail }}" target="_blank"
                            rel="noopener" class="color-toggle-yellow footer-link">
                            {{ $siteEmail }}
                        </a>

                        <!-- High Visibility Update Line -->
                        <p class="mt-2 color-toggle-green"
                            style="font-size: 14px; font-weight: 700; letter-spacing: 0.4px; margin-top: 10px; cursor: pointer;">
                            Last Updated On: 19 October 2026 7:07 PM <br> Portal Focus: Dewa Sharif Visitor Guidance &amp;
                            Universal Peace
                        </p>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12 footer-widget-col">
                        <div class="footer-widget-row">
                            <!-- Live Visitors Box -->
                            <div class="live-visitor-box">
                                <strong class="color-toggle-yellow"
                                    style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Visitors</strong><br>
                                <span class="visitor-count">786707</span>
                            </div>

                            <!-- Google Translate Widget -->
                            <div class="footer-lang-box">
                                <span
                                    style="font-size: 11px; font-weight: 800; color: #ffeb3b; display: block; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">🌐
                                    Select Language</span>
                                <div id="google_translate_element"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clean Visible Middle Divider -->
                <hr class="divider-toggle" style="border: 0; height: 1.5px; margin: 20px 0;">

                <div class="row text-center" style="font-size: 13.5px; color: #ffffff;">
                    <div class="col-xs-12 col-12">
                        <span>
                            &copy; 2026
                            <strong>
                                <a href="https://dewasharif.com/" class="color-toggle-yellow footer-link">
                                   www.dewasharif.com
                                </a>
                            </strong>.
                            (Independent Private Portal). All Rights Reserved.
                        </span>

                        <span class="mx-2 color-toggle-green">|</span>

                        <span>
                            Designed &amp; Managed by
                            <strong>
                                <a href="https://www.instagram.com/masharrat_bin_barkat/" target="_blank" rel="noopener"
                                    class="color-toggle-green footer-link">
                                    Shahzade Alam/Masharrat Warsi
                                </a>
                            </strong>
                        </span>
                    </div>
                </div>

                <!-- Clean Visible Bottom Divider -->
                <hr
                    style="border: 0; height: 3px; background-color: #03be64; margin-top: 15px; margin-bottom: 0; opacity: 1; box-shadow: 0 0 10px rgba(3, 190, 100, 0.5);">
            </div>
        </div>
    </div>
</footer>

<!-- Modal -->
<div class="modal" id="basicExampleModal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img src="{{ asset('downloadmedia/siteContent/638616837023717318.jpg') }}"
                    alt="Kakori Train Action Shatabdi Mahotsav" title="Kakori Train Action Shatabdi Mahotsav"
                    style="width: 100%; height: auto;" />
            </div>
        </div>
    </div>
</div>

<style>
    /* Base links style */
    .f-link li a {
        color: #fff;
        transition: color 0.3s ease, transform 0.2s ease;
        display: inline-block;
    }

    .f-link li a:hover {
        color: #00e676 !important;
        text-decoration: underline;
        transform: translateX(4px);
    }

    /* 1. Pehle Yellow (#ffeb3b), Hover par Green (#00e676) */
    .color-toggle-yellow {
        color: #ffeb3b !important;
        transition: color 0.3s ease, transform 0.2s ease;
        display: inline-block;
    }

    .color-toggle-yellow:hover {
        color: #00e676 !important;
        text-decoration: underline;
        transform: scale(1.03);
    }

    /* 2. Pehle Green (#00e676), Hover par Yellow (#ffeb3b) */
    .color-toggle-green {
        color: #00e676 !important;
        transition: color 0.3s ease, transform 0.2s ease;
        display: inline-block;
    }

    .color-toggle-green:hover {
        color: #ffeb3b !important;
        transform: scale(1.02);
    }

    /* Footer Headings toggle */
    .footer-heading {
        color: #ffeb3b;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .footer-heading:hover {
        color: #00e676 !important;
    }

    /* Footer Widget Row & Boxes */
    .footer-widget-col {
        display: flex;
        justify-content: flex-end;
    }

    .footer-widget-row {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        margin-top: 5px;
    }

    .footer-lang-box {
        display: inline-flex;
        flex-direction: column;
        justify-content: center;
        background: rgba(255, 255, 255, 0.08);
        padding: 8px 14px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: left;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        min-height: 68px;
        vertical-align: middle;
        box-sizing: border-box;
    }

    /* Live Visitor Box */
    .live-visitor-box {
        background: rgba(255, 255, 255, 0.08);
        border: 1.5px solid #00e676;
        padding: 8px 18px;
        border-radius: 12px;
        display: inline-flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: border-color 0.3s ease, transform 0.2s ease;
        cursor: pointer;
        min-height: 68px;
        min-width: 125px;
        vertical-align: middle;
        box-sizing: border-box;
    }

    .live-visitor-box .visitor-count {
        font-size: 24px;
        color: #00e676;
        font-weight: 800;
        line-height: 1.1;
        text-shadow: 0 0 10px rgba(0, 230, 118, 0.5);
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }

    .live-visitor-box:hover {
        border-color: #ffeb3b;
        transform: translateY(-2px);
    }

    .live-visitor-box:hover .visitor-count {
        color: #ffeb3b !important;
        text-shadow: 0 0 10px rgba(255, 235, 59, 0.6);
    }

    @media (max-width: 991px) {
        .footer-widget-col {
            display: flex !important;
            justify-content: center !important;
            text-align: center !important;
        }

        .footer-widget-row {
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            flex-wrap: wrap !important;
            gap: 14px !important;
            margin: 18px auto 8px auto !important;
            width: 100% !important;
        }

        .live-visitor-box,
        .footer-lang-box {
            margin: 0 !important;
            align-self: center !important;
        }
    }

    /* Middle Divider: Pehle Yellow, Hover par Green */
    .divider-toggle {
        background-color: #ffeb3b;
        opacity: 1;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .divider-toggle:hover {
        background-color: #00e676 !important;
        box-shadow: 0 0 8px #00e676;
    }

    /* Google Translate Widget Styling */
    #google_translate_element select,
    #google_translate_element .goog-te-combo {
        padding: 7px 12px 7px 16px !important;
        padding-left: 16px !important;
        margin: 6px 0 !important;
        border-radius: 8px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        background-color: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        outline: none !important;
        cursor: pointer !important;
        width: 100% !important;
        min-width: 170px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15) !important;
    }

    #google_translate_element .goog-te-gadget {
        color: rgba(255,255,255,0.7) !important;
        font-size: 11px !important;
        line-height: 1.4 !important;
    }

    #google_translate_element .goog-te-gadget a {
        color: #ffeb3b !important;
    }

    @media (max-width: 768px) {
        .footer .container {
            padding-left: 15px !important;
            padding-right: 15px !important;
            box-sizing: border-box !important;
        }
        .footer-column {
            padding: 20px 10px !important;
        }
    }
</style>
<!-- GOOGLE TRANSLATE IN FOOTER -->
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
                pageLanguage: "en"
            },
            "google_translate_element"
        );
    }
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
