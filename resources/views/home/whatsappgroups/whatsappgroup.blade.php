@extends('home.includes.master')

@section('header-area')
@endsection

@section('content')
    <div class="container" style="padding: 45px 15px;">

        <!-- Page Title Header (Bold & Dark) -->
      <div style="text-align: center; margin-bottom: 40px; padding: 0 10px; box-sizing: border-box;">
            <span
                style="background: #e8a824; color: #111; font-weight: 900; font-size: 13px; text-transform: uppercase; padding: 6px 18px; border-radius: 20px; letter-spacing: 1px;">
                dewasharif.com Platform
            </span>
            <h1 style="color: #0b4625; font-size: 32px; font-weight: 900; margin-top: 15px;">
                📱 Dewa Sharif WhatsApp Groups &amp; Warsi Matrimonial Services
            </h1>
            <p
                style="color: #222; font-size: 16px; font-weight: 700; max-width: 800px; margin: 12px auto 0 auto; line-height: 1.6; padding: 0 15px; box-sizing: border-box;">
                Join our verified community updates group and Muslim marriage rishte groups securely. Please read all terms
                and safety rules carefully.
            </p>
            <div style="width: 80px; height: 3px; background: #03be64; margin: 15px auto; border-radius: 2px;"></div>
        </div>

        <!-- CRITICAL LEGAL DISCLAIMER WARNING BANNER (Bold & Dark) -->
        <div
            style="background: #fff3cd; border: 2px solid #ffeeba; color: #533f04; padding: 20px 22px; border-radius: 12px; margin-bottom: 35px; font-size: 15px; font-weight: 700; line-height: 1.8; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
            <b style="font-size: 17px; color: #721c24; font-weight: 900;">⚠️ IMPORTANT LEGAL DISCLAIMER & SAFETY NOTICE /
                कानूनी चेतावनी:</b><br>
            <b>dewasharif.com</b> par Warsi Matrimonial Service sirf aur sirf ek information-sharing aur biodata posting platform hai. Rishta tay karne,
            background ya police verification karne ya aapas ke kisi bhi len-den ki <u style="font-weight: 900;">poori
                zimmedari kewal aur kewal user aur uske parivar ki hogi</u>. Platform, Founder (Shahzade Alam) ya Admin ka
            kisi bhi vivad, police case, fraud ya nuksan se koi lena-den nahi hai. / This platform holds <b
                style="font-weight: 900;">NO LIABILITY</b> for any disputes, police cases, financial matters, or alliances.
            Users must verify everything independently.
        </div>

        <!-- Groups Section Display (Exact Border-Intersecting Badges & Perfect Row Alignment) -->
        <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-bottom: 20px; margin-right: 0; margin-left: 0; align-items: stretch;">

            <!-- CARD 1: YELLOW THEME (Dewa Sharif Updates Group) -->
            <div style="flex: 0 0 350px; max-width: 100%; width: 350px; background: #fff; border: 4px solid transparent; border-image: linear-gradient(135deg, #facc15, #ca8a04) 1; border-radius: 16px; padding: 22px 16px; text-align: center; box-shadow: 0 8px 25px rgba(202,138,4,0.2); display: flex; flex-direction: column; justify-content: space-between; position: relative; margin-top: 20px; box-sizing: border-box;">
                
                <!-- Floating Badge -->
                <div style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); width: 90%; text-align: center;">
                    <span style="background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%); color: #111; font-weight: 900; font-size: 10.5px; padding: 5px 12px; border-radius: 14px; text-transform: uppercase; box-shadow: 0 3px 8px rgba(0,0,0,0.2); display: inline-block; white-space: nowrap;">📢 COMMUNITY UPDATES</span>
                </div>

                <div style="padding-top: 10px; display: flex; flex-direction: column; height: 100%; justify-content: space-between;">
                    <div>
                        <div style="text-align: center; margin: 5px 0 0 0;">
                            <h4 style="color: #713f12; font-weight: 900; font-size: 19px; margin: 0; display: flex; align-items: center; justify-content: center;">
                                🕌 Dewa Sharif Updates
                            </h4>
                            <p style="font-size: 11px; color: #023dbeff; font-weight: 700; margin: 5px 0 8px 0;">
                                ( Dewa Sharif aur dargah se related updates ke liye hamare WhatsApp group se judein )
                            </p>
                        </div>

                        <!-- Bullet Points Area -->
                        <div style="margin-bottom: 12px;">
                            <ul style="font-size: 12.5px; color: #111; font-weight: 700; text-align: left; padding-left: 18px; line-height: 1.5; margin: 0; width: 100%; box-sizing: border-box;">
                                <li>Dargah Sharif, Urs, Mela aur Ziyarat se reated Jankari.</li>
                                <li>Hotels & Cabs Booking, Travel Guidance & Degh-Niyaz-Langar Facility Availables.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- QR Image Box -->
                    <div>
                        <div style="background: #fdfdfd; padding: 8px; border-radius: 12px; border: 2px dashed #ca8a04; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 12px;">
                            <img src="{{ asset('home/images/dewasharif/dewa-sharif-group.jpeg') }}" alt="Dewa Sharif WhatsApp QR" style="width: 100%; max-width: 200px; height: auto; object-fit: contain; display: block; margin: 0 auto; border-radius: 6px;">
                            <span style="font-size: 11.5px; font-weight: 800; color: #713f12; display: block; margin-top: 5px;">Scan QR Code</span>
                        </div>

                        <div>
                            <a href="https://chat.whatsapp.com/F7iFNc1a4hR9sMZMADXcoy" target="_blank" style="display: block; background: linear-gradient(135deg, #eab308 0%, #a16207 100%); color: #fff; font-weight: 900; padding: 11px 15px; border-radius: 30px; text-decoration: none; font-size: 14px; box-shadow: 0 4px 15px rgba(202, 138, 4, 0.4);">
                                📲 Join Group via Link
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: GREEN THEME (Warsi Matrimonial Services - Free) -->
            <div style="flex: 0 0 350px; max-width: 100%; width: 350px; background: #fff; border: 4px solid transparent; border-image: linear-gradient(135deg, #22c55e, #15803d) 1; border-radius: 16px; padding: 22px 16px; text-align: center; box-shadow: 0 8px 25px rgba(22,163,74,0.2); display: flex; flex-direction: column; justify-content: space-between; position: relative; margin-top: 20px; box-sizing: border-box;">
                
                <!-- Floating Badge -->
                <div style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); width: 90%; text-align: center;">
                    <span style="background: linear-gradient(135deg, #22c55e 0%, #15803d 100%); color: #fff; font-weight: 900; font-size: 10.5px; padding: 5px 12px; border-radius: 14px; text-transform: uppercase; box-shadow: 0 3px 8px rgba(0,0,0,0.2); display: inline-block; white-space: nowrap;">✨ FREE SERVICE</span>
                </div>

                <div style="padding-top: 10px; display: flex; flex-direction: column; height: 100%; justify-content: space-between;">
                    <div>
                        <div style="text-align: center; margin: 5px 0 0 0;">
                            <h4 style="color: #14532d; font-weight: 900; font-size: 19px; margin: 0; display: flex; align-items: center; justify-content: center;">
                                💍 Free Muslim Marriage
                            </h4>
                            <p style="font-size: 11px; color: #023dbeff; font-weight: 700; margin: 5px 0 8px 0;">
                                Dewa Sharif aur All India ke sabhi bhai-behno ke liye bilkul 100% Free rishton ki jankari
                            </p>
                        </div>

                        <!-- Bullet Points Area -->
                        <div style="margin-bottom: 12px;">
                            <ul style="font-size: 12.5px; color: #111; font-weight: 700; text-align: left; padding-left: 18px; line-height: 1.5; margin: 0; width: 100%; box-sizing: border-box;">
                                <li>Muslim Marriage Group Dewa Sharif Free- All India.</li>
                                <li>100% Free Biodata Sharing Service for Everyone in the Community.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- QR Image Box -->
                    <div>
                        <div style="background: #fdfdfd; padding: 8px; border-radius: 12px; border: 2px dashed #16a34a; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 12px;">
                            <img src="{{ asset('home/images/dewasharif/free_marriage.jpeg') }}" alt="Free Marriage QR" style="width: 100%; max-width: 200px; height: auto; object-fit: contain; display: block; margin: 0 auto; border-radius: 6px;">
                            <span style="font-size: 11.5px; font-weight: 800; color: #16a34a; display: block; margin-top: 5px;">Scan QR Code</span>
                        </div>

                        <div>
                            <a href="https://chat.whatsapp.com/F7iFNc1a4hR9sMZMADXcoy" target="_blank" style="display: block; background: linear-gradient(135deg, #22c55e 0%, #15803d 100%); color: #fff; font-weight: 900; padding: 11px 15px; border-radius: 30px; text-decoration: none; font-size: 14px; box-shadow: 0 4px 15px rgba(22, 163, 74, 0.4);">
                                📲 Join Group Via Link
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 3: RED THEME (Warsi Matrimonial Services - Paid Group ₹299) -->
            {{-- <div style="flex: 0 0 350px; max-width: 100%; width: 350px; background: #fff; border: 4px solid transparent; border-image: linear-gradient(135deg, #ef4444, #b91c1c) 1; border-radius: 16px; padding: 22px 16px; text-align: center; box-shadow: 0 8px 25px rgba(220,38,38,0.2); display: flex; flex-direction: column; justify-content: space-between; position: relative; margin-top: 20px; box-sizing: border-box;">
                
                <!-- Floating Badge -->
                <div style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); width: 90%; text-align: center;">
                    <span style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: #fff; font-weight: 900; font-size: 10.5px; padding: 5px 12px; border-radius: 14px; text-transform: uppercase; box-shadow: 0 3px 8px rgba(0,0,0,0.2); display: inline-block; white-space: nowrap;">⭐ PREMIUM GROUP (₹299)</span>
                </div>

                <div style="padding-top: 10px; display: flex; flex-direction: column; height: 100%; justify-content: space-between;">
                    <div>
                        <div style="text-align: center; margin: 5px 0 0 0;">
                            <h4 style="color: #7f1d1d; font-weight: 900; font-size: 19px; margin: 0; display: flex; align-items: center; justify-content: center;">
                                💎 Paid Marriage Group
                            </h4>
                            <p style="font-size: 11px; color: #023dbeff; font-weight: 700; margin: 5px 0 8px 0;">
                                ( Dewa Sharif aur All India ke Zyada behtar rishton ke liye hamara paid WhatsApp group join karen )
                            </p>
                        </div>

                        <!-- Bullet Points Area -->
                        <div style="margin-bottom: 12px;">
                            <ul style="font-size: 12.5px; color: #111; font-weight: 700; text-align: left; padding-left: 18px; line-height: 1.5; margin: 0; width: 100%; box-sizing: border-box;">
                                <li>Muslim Marriage Group Dewa Sharif All India Service and Valid for 6 Months.</li>
                                <li>Verified Biodatas, Photo, Contact, Address. Direct Admin Posting Service.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- QR Image Box -->
                    <div>
                        <div style="background: #fdfdfd; padding: 8px; border-radius: 12px; border: 2px dashed #dc2626; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 12px;">
                            <img src="{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}" alt="PhonePe QR 299" style="width: 100%; max-width: 200px; height: auto; object-fit: contain; display: block; margin: 0 auto; border-radius: 6px;">
                            <span style="font-size: 11.5px; font-weight: 800; color: #b91c1c; display: block; margin-top: 5px;">Scan QR code using UPI APP</span>
                        </div>

                        <div>
                            <a href="upi://pay?pa=9648777223@ybl&pn=ShahzadeAlam&am=299.00&cu=INR&tn=Paid+Muslim+Marriage+Group+Subscription+6+Months" target="_blank" style="display: block; background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: #fff; font-weight: 900; padding: 11px 15px; border-radius: 30px; text-decoration: none; font-size: 13.5px; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);">
                                ⚡ Pay ₹299 via UPI / PhonePe
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>

        <!-- RULES & REGULATIONS SECTION -->
        <div
            style="background: linear-gradient(135deg, #fdfbf7 0%, #f4eee1 100%); border: 2px solid #d4af37; border-radius: 14px; padding: 35px; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">

            <h3 style="color: #0b4625; font-weight: 900; font-size: 24px; text-align: center; margin-bottom: 30px;">
                📜 Terms, Rules & Safety Guidelines / नियम एवं शर्तें / ضوابط و شرائط
            </h3>

            <div style="display: flex; flex-wrap: wrap; gap: 30px;">

                <!-- HINDI -->
                <div
                    style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-radius: 12px; border-left: 6px solid #ca8a04; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                    <h4 style="color: #713f12; font-weight: 900; font-size: 18px; margin-bottom: 15px;">हिंदी (Hindi)</h4>
                    <ul style="font-size: 15px; color: #111; font-weight: 700; padding-left: 20px; line-height: 1.9;">
                        <li style="margin-bottom: 12px;"><b>प्लेटफॉर्म का उद्देश्य:</b> dewasharif.com केवल मुस्लिम समाज के
                            लिए वैध विवाह प्रस्ताव (Nikah) और updates साझा करने का माध्यम है।</li>
                        <li style="margin-bottom: 12px;"><b>शून्य जिम्मेदारी (No Liability / No Police Case):</b> रिश्ता तय
                            करने से पहले दोनों पक्ष अपनी व्यक्तिगत जिम्मेदारी पर पूरी छानबीन (Background/Police
                            Verification) करें। <u>dewasharif.com या एडमिन (Shahzade Alam) की किसी भी विवाद, धोखाधड़ी या
                                पुलिस केस में कोई कानूनी जिम्मेदारी नहीं होगी</u>।</li>
                        <li style="margin-bottom: 12px;"><b>गार्डियन की उपस्थिति:</b> कोई भी मीटिंग हमेशा अभिभावकों
                            (Wali/Parents) की मौजूदगी में ही होनी चाहिए।</li>
                        {{-- <li style="margin-bottom: 12px;"><b>पेड ग्रुप फीस:</b> पेड rishta ग्रुप की फीस ₹299 (6 महीने के लिए)
                            है, जो कि strictly non-refundable है।</li> --}}
                        <li style="margin-bottom: 6px;"><b>एडमिन:</b> ग्रुप में केवल एडमिन ही बायोडाटा और फोटो पोस्ट कर
                            सकेगा। अपना बायोडाटा/फोटो हमारे WhatsApp (+91 9648777223) या Email
                            (info@dewasharif.com) पर भेजें।</li>
                            {{-- पेमेंट का स्क्रीनशॉट और isko sakega ke bad likhna hai bad me  --}}
                    </ul>
                </div>

                <!-- ENGLISH -->
                <div
                    style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-radius: 12px; border-left: 6px solid #16a34a; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                    <h4 style="color: #14532d; font-weight: 900; font-size: 18px; margin-bottom: 15px;">English</h4>
                    <ul style="font-size: 15px; color: #111; font-weight: 700; padding-left: 20px; line-height: 1.9;">
                        <li style="margin-bottom: 12px;"><b>Platform Purpose:</b> dewasharif.com is a dedicated community
                            portal and information bureau facilitating genuine proposals.</li>
                        <li style="margin-bottom: 12px;"><b>Absolute Zero Liability (No Police Case):</b> Users and their
                            families are solely responsible for conducting thorough background verifications before
                            finalizing any alliance. <u>dewasharif.com, its founder (Shahzade Alam), and admins hold NO
                                liability, responsibility, or legal accountability</u> whatsoever for any disputes or
                            issues.</li>
                        <li style="margin-bottom: 12px;"><b>Guardian Role:</b> All interactions and meetings must occur
                            under the supervision of family guardians.</li>
                        {{-- <li style="margin-bottom: 12px;"><b>Subscription Fee:</b> The paid group fee is ₹299 for 6 months
                            (Strictly Non-refundable).</li> --}}
                        <li style="margin-bottom: 6px;"><b>Privacy & Posting:</b> Configured as "Admin-Only". Send your biodata and photo to our WhatsApp (+91 9648777223) or Email
                            (info@dewasharif.com).</li>
                            {{-- payment screenshot along with Note isko bad me likhna hai send ke --}}
                    </ul>
                </div>

                <!-- URDU -->
                <div style="flex: 1; min-width: 280px; background: #fff; padding: 25px; border-radius: 12px; border-left: 6px solid #dc2626; text-align: right;"
                    dir="rtl">
                    <h4 style="color: #7f1d1d; font-weight: 900; font-size: 18px; margin-bottom: 15px;">اردو (Urdu)</h4>
                    <ul style="font-size: 15.5px; color: #111; font-weight: 800; padding-right: 20px; line-height: 1.9;">
                        <li style="margin-bottom: 12px;"><b>پلیٹ فارم کا مقصد:</b> dewasharif.com صرف مسلم معاشرے کے لیے
                            جائز رشتہ ازدواج یعنی نکاح اور معلومات کے تبادلے کا ذریعہ ہے۔</li>
                        <li style="margin-bottom: 12px;"><b>صفر ذمہ داری یعنی قانونی تحفظ:</b> رشتہ طے کرنے سے پہلے دونوں
                            فریقین اپنی ذاتی ذمہ داری پر مکمل جانچ پڑتال خود کریں۔ <u>dewasharif.com یا ایڈمن یعنی شہزاد
                                عالم کی کسی بھی قسم کے تنازعہ، دھوکہ دہی یا پولیس مقدمے میں کوئی قانونی ذمہ داری نہیں
                                ہوگی</u>।</li>
                        <li style="margin-bottom: 12px;"><b>سرپرست کی موجودگی:</b> تمام ملاقاتیں والدین یا سرپرست کی موجودگی
                            میں ہی ہونی چاہئیں۔</li>
                        {{-- <li style="margin-bottom: 12px;"><b>پیڈ گروپ کی فیس:</b> پیڈ رشتے والے گروپ کی فیس دو سو ننانوے
                            (299) روپے ہے جو کہ چھ ماہ کے لیے ہے اور یہ فیس واپس نہیں کی جائے گی۔</li> --}}
                        <li style="margin-bottom: 6px;"><b>صرف ایڈمن کی پوسٹنگ:</b> گروپ میں صرف ایڈمن ہی بائیو ڈیٹا اور
                            تصویر پوسٹ کر سکے گا۔ اپنا بائیو ڈیٹا مع تصویر ہمارے واٹس ایپ نمبر
                            (9648777223 91+) یا ای میل (info@dewasharif.com) پر ارسال کریں۔</li>
                            {{--isko adayegi ke bad likhna hai bad me  ادائیگی کا اسکرین شاٹ اور --}}
                    </ul>
                </div>

            </div>
        </div>

    </div>
@endsection
