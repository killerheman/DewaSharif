@extends('home.includes.master')
@section('content')
    <!-- Dewa Mela Hero Section -->
    <div
        style="background: linear-gradient(135deg, rgba(3, 37, 20, 0.92), rgba(4, 22, 12, 0.96)), url('{{ asset('home/images/dewa-bg.jpg') }}') center/cover no-repeat; color: #fff; padding: 75px 15px 20px 15px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: inset 0 0 100px rgba(0,0,0,0.6); box-sizing: border-box; width: 100%;">



        <!-- 1. THANK YOU / BOOKING STATS CARD (100% WIDE RESPONSIVE) -->
        <div
            style="width: 100%; max-width: 1140px; margin: 0 auto 30px auto; padding: 30px 25px; background: linear-gradient(135deg, #2c1a0c 0%, #1a0f05 100%); border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 0 30px rgba(212, 175, 55, 0.4); animation: royalGlow 2.5s infinite alternate; box-sizing: border-box; text-align: center;">

            <!-- Header Badge -->
            <span
                style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; display: inline-block; margin-bottom: 12px; letter-spacing: 0.8px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                ❤️ Heartfelt Gratitude ❤️
            </span>

            <h3
                style="color: #ffd700; font-size: 22px; font-weight: 800; text-align: center; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                ✨ Thank You So Much for Trusting Us in Dewa Mela 2026! ✨
            </h3>

            <p
                style="font-size: 15.5px; color: #fdf6e2; line-height: 1.7; font-weight: 500; margin: 0 auto 22px auto; max-width: 950px; text-align: center;">
                Aap sabhi zayreen aur guests ka dil se shukriya! Aapne humari services par bharosa kiya aur Dewa Sharif Urs
                ko safal banaya. Aapke is bharose ke liye tahe-dil se shukriya—hum hamesha aage bhi aapki seva aur khidmat
                mein aise hi hazir rahenge aur aapke kaam aate rahenge.
            </p>

            <!-- Stats Horizontal Layout -->
            <div
                style="display: flex; justify-content: center; align-items: center; gap: 14px; flex-wrap: wrap; width: 100%;">

                <!-- Stat 1: Rooms -->
                <div
                    style="background: rgba(0, 15, 8, 0.75); border: 1.5px solid rgba(212, 175, 55, 0.45); border-radius: 10px; padding: 14px 18px; text-align: center; flex: 1; min-width: 250px; box-sizing: border-box;">
                    <div style="color: #ffd700; font-size: 22px; font-weight: 900; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                        80+ Bookings</div>
                    <div
                        style="color: #ffffff; font-size: 13px; font-weight: 700; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.5px;">
                        🛏️ Rooms & Guest House</div>
                </div>

                <!-- Stat 2: Cabs -->
                <div
                    style="background: rgba(0, 15, 8, 0.75); border: 1.5px solid rgba(212, 175, 55, 0.45); border-radius: 10px; padding: 14px 18px; text-align: center; flex: 1; min-width: 250px; box-sizing: border-box;">
                    <div style="color: #ffd700; font-size: 22px; font-weight: 900; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                        150+ Bookings</div>
                    <div
                        style="color: #ffffff; font-size: 13px; font-weight: 700; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.5px;">
                        🚗 Cab & Travel Services</div>
                </div>

                <!-- Stat 3: Degh & Langar -->
                <div
                    style="background: rgba(0, 15, 8, 0.75); border: 1.5px solid rgba(212, 175, 55, 0.45); border-radius: 10px; padding: 14px 18px; text-align: center; flex: 1; min-width: 250px; box-sizing: border-box;">
                    <div style="color: #ffd700; font-size: 22px; font-weight: 900; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                        190+ Bookings</div>
                    <div
                        style="color: #ffffff; font-size: 13px; font-weight: 700; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.5px;">
                        🍲 Degh, Niyaz & Langar</div>
                </div>

            </div>
        </div>

        <!-- 2. TRAVEL & SERVICES BOX (100% WIDE RESPONSIVE) -->
        <div
            style="margin-top: 10px; padding: 30px 25px; background: linear-gradient(135deg, #2c1a0c 0%, #1a0f05 100%); border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 0 30px rgba(212, 175, 55, 0.4); animation: royalGlow 2.5s infinite alternate; width: 100%; max-width: 1140px; box-sizing: border-box;">

            <!-- Heading -->
            <h3
                style="color: #ffd700; font-size: 22px; font-weight: 800; text-align: center; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                ✨ Complete Dewa Sharif Ziyarat & Travel Services ✨
            </h3>

            <!-- Description -->
            <p
                style="font-size: 15.5px; color: #fdf6e2; line-height: 1.7; font-weight: 500; margin: 0 auto 20px auto; max-width: 950px; text-align: center;">
                Hum provide karte hain —
                <span style="color: #af0202ff; font-weight: 700;">
                    Confirm All India Bus Ticket, National & International Flights Ticket and Train Ticket only if Available
                    - contact us on
                    <a href="https://wa.me/919648777223" target="_blank"
                        style="color: #25d366; font-weight: 800; text-decoration: none;">
                        WhatsApp
                    </a>
                </span>
                <br><span style="color: #60a5fa; font-weight: 700;">Lucknow Airport & Railway Station or Custom Pickup &
                    Drop by Cabs</span>,
                <br><span style="color: #4ade80; font-weight: 700;">AC / Non-AC (Standard, Deluxe, Premium & Luxury
                    Rooms)</span>,
                <br>Sath hi complete <span style="color: #fef08a; font-weight: 700;">Guidance, Degh & Niyaz</span> ki poori
                facility Dewa Sharif mein.
                Book karein apna <span style="color: #fef08a; font-weight: 700;">Full Ziyarat Service Package (Online /
                    Offline)</span> — aapki maujudgi mein ya aapki gair-maujudgi mein <span
                    style="color: #fef08a; font-weight: 700;">WhatsApp video & photos</span> ke sath poori tasalli (proof)
                ke sath!
            </p>

            <!-- ACTION BOOKING BUTTONS -->
            <div
                style="display: flex; justify-content: center; align-items: center; gap: 12px; flex-wrap: wrap; margin-top: 22px; width: 100%;">

                <!-- 1. CAB BOOKING BUTTON -->
                <a href="{{ route('cabs') }}"
                    style="background: linear-gradient(135deg, #ffe01b 0%, #f59e0b 50%, #d97706 100%); color: #ffffff; flex: 1; min-width: 220px; min-height: 52px; padding: 7px 14px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.45); text-shadow: 0 1px 3px rgba(0, 0, 0, 0.45); transition: transform 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fa fa-taxi" style="font-size: 19px; flex-shrink: 0;"></i>
                    <div
                        style="display: flex; flex-direction: column; align-items: center; text-align: center; line-height: 1.2;">
                        <span style="font-weight: 800; font-size: 13.5px; letter-spacing: 0.3px;">BOOK CABS</span>
                        <span style="font-size: 11px; font-weight: 600; opacity: 0.98; color: #ffffff;">24×7 Service</span>
                    </div>
                </a>

                <!-- 2. HOTEL BOOKING BUTTON -->
                <a href="{{ route('hotels') }}"
                    style="background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 50%, #0f172a 100%); color: #ffffff; flex: 1; min-width: 220px; min-height: 52px; padding: 7px 14px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.45); transition: transform 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fa fa-bed" style="font-size: 19px; flex-shrink: 0;"></i>
                    <div
                        style="display: flex; flex-direction: column; align-items: center; text-align: center; line-height: 1.2;">
                        <span style="font-weight: 800; font-size: 13.5px; letter-spacing: 0.3px;">BOOK HOTELS</span>
                        <span style="font-size: 11px; font-weight: 500; opacity: 0.95; color: #ffffff;">24×7 Service</span>
                    </div>
                </a>

                <!-- 3. DEGH NIYAZ BOOKING BUTTON -->
                <a href="{{ route('shops.category', 'degh') }}"
                    style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #991b1b 100%); color: #ffffff; flex: 1; min-width: 220px; min-height: 52px; padding: 7px 14px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.45); transition: transform 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fa fa-cutlery" style="font-size: 18px; flex-shrink: 0;"></i>
                    <div
                        style="display: flex; flex-direction: column; align-items: center; text-align: center; line-height: 1.2;">
                        <span style="font-weight: 800; font-size: 13.5px; letter-spacing: 0.3px;">BOOK DEGH</span>
                        <span style="font-size: 11px; font-weight: 500; opacity: 0.95; color: #ffffff;">Tabarruk</span>
                    </div>
                </a>

                <!-- 4. WHATSAPP CHAT BUTTON -->
                <a href="https://wa.me/919648777223?text={{ urlencode('Assalamu Alaikum! Mujhe Dewa Sharif Ziyarat, Hotels, Cabs aur Tabarruk ke baare me jaankari chahiye.') }}"
                    target="_blank" rel="noopener"
                    style="background: linear-gradient(135deg, #25d366 0%, #128c7e 100%); color: #ffffff; flex: 1; min-width: 220px; min-height: 52px; padding: 7px 14px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.45); transition: transform 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fa fa-whatsapp" style="font-size: 20px; flex-shrink: 0;"></i>
                    <div
                        style="display: flex; flex-direction: column; align-items: center; text-align: center; line-height: 1.2;">
                        <span style="font-weight: 800; font-size: 13.5px; letter-spacing: 0.3px;">WHATSAPP</span>
                        <span style="font-size: 11px; font-weight: 500; opacity: 0.95; color: #ffffff;">Support</span>
                    </div>
                </a>

            </div>
        </div>

        <!-- 3. DARGAH SHARIF ZIYARAT TIMINGS (100% WIDE RESPONSIVE) -->
        <div
            style="width: 100%; max-width: 1140px; margin: 30px auto; padding: 30px 25px; background: linear-gradient(135deg, #2c1a0c 0%, #1a0f05 100%); border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 0 30px rgba(212, 175, 55, 0.4); box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

            <!-- Timings Section -->
            <h3
                style="color: #ffd700; font-size: 21px; font-weight: 800; text-align: center; margin: 0 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                ✨ Dargah Sharif Ziyarat Open / Close Timings ✨
            </h3>
            <p style="font-size: 14px; color: #fdf6e2; text-align: center; margin: 0 0 20px 0; line-height: 1.4;">
                Zayreen (Visitors) ke liye Mazar-e-Mubarak ke khulne (open) aur band (close) hone ka tay shuda waqt (time):
            </p>

            <div
                style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center; width: 100%; margin-bottom: 25px;">
                <!-- Winter Timing -->
                <div
                    style="flex: 1; min-width: 270px; background: rgba(242, 245, 244, 0.75); border: 1.5px solid rgba(212, 175, 55, 0.45); border-radius: 10px; padding: 16px 18px; text-align: left; box-sizing: border-box;">
                    <div style="color: #13471eff; font-weight: 800; font-size: 16px; margin-bottom: 6px;">❄️ Winter (Sardi
                        ke Din)</div>
                    <div style="color: #23913bff; font-size: 14px; font-weight: 700; margin-bottom: 4px;">
                        <strong>Morning (Subah):</strong> <span style="font-weight: 900;">5:00 AM to 12:00 PM</span>
                    </div>
                    <div style="color: #23913bff; font-size: 14px; font-weight: 700;">
                        <strong>After-Noon (Dopahar):</strong> <span style="font-weight: 900;">2:00 PM to 9:00 PM</span>
                    </div>
                </div>

                <!-- Summer Timing -->
                <div
                    style="flex: 1; min-width: 270px; background: rgba(255, 254, 172, 0.75); border: 1.5px solid rgba(212, 175, 55, 0.45); border-radius: 10px; padding: 16px 18px; text-align: left; box-sizing: border-box;">
                    <div style="color: #830404ff; font-weight: 800; font-size: 16px; margin-bottom: 6px;">☀️ Summer (Garmi
                        ke Din)</div>
                    <div style="color: #d42828ff; font-size: 14px; font-weight: 700; margin-bottom: 4px;">
                        <strong>Morning (Subah):</strong> <span style="font-weight: 900;">4:00 AM to 12:00 PM</span>
                    </div>
                    <div style="color: #d42828ff; font-size: 14px; font-weight: 700;">
                        <strong>After-Noon (Dopahar):</strong> <span style="font-weight: 900;">2:00 PM to 10:00 PM</span>
                    </div>
                </div>
            </div>

            <!-- Divider Line -->
            <hr style="border: none; border-top: 1px solid rgba(212, 175, 55, 0.3); margin: 25px 0;">

            <!-- Services Header Section -->
            <h3
                style="color: #ffd700; font-size: 19px; font-weight: 800; text-align: center; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                ✨ Dewa Sharif Dargah: Chadar, Phool, Dua aur Ehram Seva Packages ✨
            </h3>
            <p style="font-size: 14px; color: #fdf6e2; text-align: center; margin: 0 0 20px 0; line-height: 1.5;">
                Aapki haazri mein ya aapki gair-maujudgi mein, Sarkar Haji Waris Ali Shah R.A ki bargah mein pure ehtaram
                (respect) ke sath chadar, phool, attar pesh karwane, aur Dua karwane ki mukammal service available hai.
                Saman aur chadar ki quality ke mutabiq hamare rates niche diye gaye hain:
            </p>

            <!-- Highlight Badge -->
            <div style="text-align: center; margin-bottom: 20px;">
                <span
                    style="background: rgba(0, 0, 0, 0.25); color: #4cd137; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 6px 16px; border-radius: 20px; display: inline-block; letter-spacing: 0.8px; border: 1.5px solid #4cd137; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                    🌸 Dargah ke andar Mazar-e-Mubarak par Bouquet(Guldasta) aur Flower Decoration karwane ke liye Contact
                    Karen 🌸
                </span>
            </div>

            <!-- Packages List Container (Compact & Clean) -->
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">

                <!-- Package 1 -->
                <div
                    style="background: rgba(0, 0, 0, 0.25); border-left: 3.5px solid #d4af37; padding: 12px 15px; border-radius: 6px; text-align: left;">
                    <div
                        style="color: #ffd700; font-weight: 700; font-size: 15px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <span>1. Warsi Chadar &amp; Fateha/Dua</span>
                        <span style="color: #4cd137; font-weight: 700;">Rate: ₹499</span>
                    </div>
                    <div style="color: #fdf6e2; font-size: 13.5px; line-height: 1.4;"><strong>Kya milega:</strong> Warsi Big
                        Size Chadar, Phool Daliya, Best Quality Attar, Agarbatti aur aapki taraf se
                        Mazar-e-Mubarak par Fateha/Dua.</div>
                </div>



                <!-- Package 2 -->
                <div
                    style="background: rgba(0, 0, 0, 0.25); border-left: 3.5px solid #d4af37; padding: 12px 15px; border-radius: 6px; text-align: left;">
                    <div
                        style="color: #ffd700; font-weight: 700; font-size: 15px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <span>2. Warsi Laces Chadar &amp; Fateha/Dua</span>
                        <span style="color: #4cd137; font-weight: 700;">Rate: ₹707</span>
                    </div>
                    <div style="color: #fdf6e2; font-size: 13.5px; line-height: 1.4;"><strong>Kya milega:</strong> Warsi Big
                        Size Chadar, Phool Daliya, Best Quality Attar, Agarbatti aur aapki taraf se
                        Mazar-e-Mubarak par Fateha/Dua.</div>
                </div>

                <!-- Package 3 -->
                <div
                    style="background: rgba(0, 0, 0, 0.25); border-left: 3.5px solid #d4af37; padding: 12px 15px; border-radius: 6px; text-align: left;">
                    <div
                        style="color: #ffd700; font-weight: 700; font-size: 15px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <span>3. Standard Warsi Zari Chadar &amp; Fateha/Dua </span>
                        <span style="color: #4cd137; font-weight: 700;">Rate: ₹1100</span>
                    </div>
                    <div style="color: #fdf6e2; font-size: 13.5px; line-height: 1.4;"><strong>Kya milega:</strong> Behtar
                        quality ki Standard Warsi Zari Big Size Chadar, Big Size Phool Daliya, Best &amp; Umda Quality
                        Attar, Agarbatti, Loban
                        aur aapki taraf se Mazar-e-Mubarak par Fateha/Dua.</div>
                </div>

                <!-- Package 4 -->
                <div
                    style="background: rgba(0, 0, 0, 0.25); border-left: 3.5px solid #d4af37; padding: 12px 15px; border-radius: 6px; text-align: left;">
                    <div
                        style="color: #ffd700; font-weight: 700; font-size: 15px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <span>4. Special Warsi Velvet Zari Chadar &amp; Fateha/Dua </span>
                        <span style="color: #4cd137; font-weight: 700;">Rate: ₹2100</span>
                    </div>
                    <div style="color: #fdf6e2; font-size: 13.5px; line-height: 1.4;"><strong>Kya milega:</strong> Behtar
                        quality ki Warsi Velvet Zari Big Size Chadar, Big Size Phool Daliya, Premium &amp; Umda Quality
                        Attar,
                        Agarbatti, Loban aur aapki taraf se Mazar-e-Mubarak par Fateha/Dua.</div>
                </div>

                <!-- Package 5 -->
                <div
                    style="background: rgba(0, 0, 0, 0.25); border-left: 3.5px solid #d4af37; padding: 12px 15px; border-radius: 6px; text-align: left;">
                    <div
                        style="color: #ffd700; font-weight: 700; font-size: 15px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <span>5. Premium Warsi Velvet Zari Chadar &amp; Fateha/Dua</span>
                        <span style="color: #4cd137; font-weight: 700;">Rate: ₹5100</span>
                    </div>
                    <div style="color: #fdf6e2; font-size: 13.5px; line-height: 1.4;"><strong>Kya milega:</strong> Very Big
                        size aur behad khubsurat heavy Premium Warsi Velvet Zari Big Size Chadar, Big Size Phool Daliya,
                        Premium
                        &amp; Umda Quality Attar, Agarbatti, Loban aur aapki taraf se Mazar-e-Mubarak par Fateha/Dua.</div>
                </div>

                <!-- Package 6 -->
                <div
                    style="background: rgba(0, 0, 0, 0.25); border-left: 3.5px solid #d4af37; padding: 12px 15px; border-radius: 6px; text-align: left;">
                    <div
                        style="color: #ffd700; font-weight: 700; font-size: 15px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <span>6. Grand Premium Warsi Velvet Designer Zari Chadar &amp; Fateha/Dua</span>
                        <span style="color: #4cd137; font-weight: 700;">Rate: ₹7707</span>
                    </div>
                    <div style="color: #fdf6e2; font-size: 13.5px; line-height: 1.4;"><strong>Kya milega:</strong> Sabse
                        shandar Premium Warsi Velvet Zari Big Size Chadar, Big Size Phool Daliya, Premium &amp; Umda
                        Quality Attar, Agarbatti, Loban , aapki taraf se Mazar-e-Mubarak par Tabarruk(Mithayi) takseem aur
                        Fateha/Dua.</div>
                </div>

                <!-- Package 7 -->
                <div
                    style="background: rgba(0, 0, 0, 0.25); border-left: 3.5px solid #d4af37; padding: 12px 15px; border-radius: 6px; text-align: left;">
                    <div
                        style="color: #ffd700; font-weight: 700; font-size: 15px; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <span>7. Warsi Ehram Mubarak (Ehramposh Buzurgo (BABA ji) ko dene ya Dargah me Pesh karne ke
                            liye)</span>
                        {{-- <span style="color: #4cd137; font-weight: 700;">Rate: ₹7707</span> --}}
                    </div>
                    <div style="color: #fdf6e2; font-size: 13.5px; line-height: 1.4;">
                        <p
                            style="color: #fdf6e2; font-size: 13.5px; margin: 0; line-height: 1.5; border-top: 1px dashed rgba(212, 175, 55, 0.3); padding-top: 8px;">
                            ✨ <strong style="color: #ffd700;">Ehram Khidmaat Notice</strong>✨ Dewa Sharif mein kisi bhi
                            Ehram-posh buzurg ko Ehram Mubarak agar koi dena chahe ya Astana-e-Aliya mein pesh karna chahe,
                            toh uske liye <strong>direct contact kare</strong>.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Note Section (Compact) -->
            <div
                style="background: rgba(212, 175, 55, 0.08); border: 1.2px dashed #d4af37; padding: 14px; border-radius: 6px; text-align: left;">
                <p style="font-size: 13.5px; margin: 0; line-height: 1.5;">
                    <strong style="color: #ffd700;">(Important Notice:</strong> <span style="color: #ffffff;">Aapko hamare
                        platform se koi bhi service lene par <strong>Photos / Video (Proof)</strong> WhatsApp par bheja
                        jayega, jisse aapko kaam ki quality aur transparency par poora bharosa bana rahe. Kisi bhi tarah ki
                        malumat ke liye hamare WhatsApp / Email par contact kare.)</span>
                </p>
            </div>

        </div>


        <style>
            @keyframes royalGlow {
                0% {
                    box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
                    border-color: #d4af37;
                }

                100% {
                    box-shadow: 0 0 35px rgba(255, 215, 0, 0.7), inset 0 0 15px rgba(212, 175, 55, 0.2);
                    border-color: #ffd700;
                }
            }
        </style>

       <div
    style="width: 100%; max-width: 1140px; margin: 0 auto 30px auto; padding: 30px 25px; background: linear-gradient(135deg, #2c1a0c 0%, #1a0f05 100%); border-radius: 14px; border: 2px solid #ffd700; box-shadow: 0 0 30px rgba(212, 175, 55, 0.4); box-sizing: border-box; text-align: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <!-- Top Small Badge -->
    <span
        style="background: #e8a824; color: #111; font-weight: 800; font-size: 11px; text-transform: uppercase; padding: 4px 16px; border-radius: 20px; display: inline-block; margin-bottom: 12px; letter-spacing: 0.8px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
        🌟 Business Opportunity 🌟
    </span>

    <!-- Main Heading -->
    <h1
        style="color: #ffd700; font-size: 20px; font-weight: 800; line-height: 1.5; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 0.5px;">
        ✨ Agar koi bhai India me "Warsi Attar &amp; Perfumes Dewa Sharif" की Franchise lena chahta hai toh Contact kare ✨
    </h1>

    <!-- Subtitle / Short Details -->
    <p style="color: #ffffff; font-size: 14px; margin: 0 0 18px 0; line-height: 1.5;">
        Apne shehar mein shuru karein Sarkar Haji Waris Ali Shah R.A ki nisbat se makhsoos original Warsi Attar aur Perfumes ka business.
    </p>

    <!-- Highlights Points -->
    <div
        style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; font-size: 13px; color: #ffffff;">
        <span
            style="background: rgba(0, 15, 8, 0.75); border: 1px solid rgba(212, 175, 55, 0.4); padding: 6px 12px; border-radius: 6px;">✨
            100% Pure &amp; Original Fragrance</span>
        <span
            style="background: rgba(0, 15, 8, 0.75); border: 1px solid rgba(212, 175, 55, 0.4); padding: 6px 12px; border-radius: 6px;">💧
            100% Alcohol Free</span>
        <span
            style="background: rgba(0, 15, 8, 0.75); border: 1px solid rgba(212, 175, 55, 0.4); padding: 6px 12px; border-radius: 6px;">📈
            High Profit Margin</span>
        <span
            style="background: rgba(0, 15, 8, 0.75); border: 1px solid rgba(212, 175, 55, 0.4); padding: 6px 12px; border-radius: 6px;">🤝
            Full Business Support</span>
    </div>

    <!-- Security Money Highlight -->
    <div
        style="background: rgba(0, 15, 8, 0.85); border: 1.5px dashed #4cd137; padding: 12px 20px; border-radius: 8px; display: inline-block; margin-bottom: 15px;">
        <span style="color: #ffffff; font-size: 15px; font-weight: 700;">🔒 Security Money: <span
                style="color: #4cd137; font-size: 18px; font-weight: 900;">₹99,999</span> Only</span>
    </div>

    <!-- Call to Action / Contact Note -->
    <div
        style="text-align: center; margin-top: 15px; color: #fdf6e2; font-size: 13.5px; font-weight: 600; line-height: 1.6;">
        📞 Franchise ya dealership ke liye aaj hi humare WhatsApp par contact karein!
        <br>Warsi Attar &amp; Perfumes detail aur zyada jankari ke liye diye gaye button par click karen <br><br>
        <a href="{{ url('/attarfrenchise') }}"
            style="display: inline-block; background: #0b4625; color: #ffd700; font-weight: 800; padding: 11px 20px; border-radius: 30px; text-decoration: none; font-size: 14px; border: 2px solid #ffd700; box-shadow: 0 4px 12px rgba(11, 70, 37, 0.3); max-width: 100%; box-sizing: border-box;">
            More Information &amp; Rules - CLICK HERE
        </a>
    </div>

</div>




        <!-- WhatsApp & Marriage Groups Section -->
        <section id="whatsapp-groups-section"
            style="padding: 30px 12px; background: #f9f6ef; margin-top: 20px; border-top: 2px solid #d4af37; border-bottom: 2px solid #d4af37; box-sizing: border-box; width: 100%;">
            <div class="container"
                style="padding-left: 15px; padding-right: 15px; max-width: 1280px; margin: 0 auto; box-sizing: border-box; width: 100%;">
                <div class="row text-center mb-4" style="margin-left: 0; margin-right: 0;">
                    <div class="col-md-12" style="padding: 0 10px;">
                        <span
                            style="background: #e8a824; color: #111; font-weight: 800; font-size: 11px; text-transform: uppercase; padding: 5px 14px; border-radius: 20px; letter-spacing: 1px; display: inline-block;">
                            Community & Warsi Matrimonial Services
                        </span>
                        <h2 style="color: #0b4625; font-size: 24px; font-weight: 900; margin-top: 12px;">
                            ✨ Join Our Official WhatsApp Groups ✨
                        </h2>
                        <p
                            style="color: #111; font-size: 14.5px; max-width: 800px; margin: 10px auto 0 auto; font-weight: 800; letter-spacing: 0.2px; padding: 0 5px;">
                            Dewa Sharif aur Dargah se judi jankari, updates aur Muslim Marriage (Rishte) ke liye hamare
                            official aur verified WhatsApp groups se judein.
                        </p>
                        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;">
                        </div>
                    </div>
                </div>

                <!-- Row with flexible card widths -->
                <div class="row"
                    style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-bottom: 20px; margin-right: 0; margin-left: 0; align-items: stretch;">

                    <!-- CARD 1: YELLOW THEME (Dewa Sharif Updates Group) -->
                    <div
                        style="flex: 1; min-width: 300px; max-width: 380px; width: 100%; background: #fff; border: 4px solid transparent; border-image: linear-gradient(135deg, #facc15, #ca8a04) 1; border-radius: 16px; padding: 22px 16px; text-align: center; box-shadow: 0 8px 25px rgba(202,138,4,0.2); display: flex; flex-direction: column; justify-content: space-between; position: relative; margin-top: 20px; box-sizing: border-box;">

                        <!-- Floating Badge -->
                        <div
                            style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); width: 90%; text-align: center;">
                            <span
                                style="background: linear-gradient(135deg, #facc15 0%, #ca8a04 100%); color: #111; font-weight: 900; font-size: 10.5px; padding: 5px 12px; border-radius: 14px; text-transform: uppercase; box-shadow: 0 3px 8px rgba(0,0,0,0.2); display: inline-block; white-space: nowrap;">📢
                                COMMUNITY UPDATES</span>
                        </div>

                        <div
                            style="padding-top: 10px; display: flex; flex-direction: column; height: 100%; justify-content: space-between;">
                            <div>
                                <div style="text-align: center; margin: 5px 0 0 0;">
                                    <h4
                                        style="color: #713f12; font-weight: 900; font-size: 19px; margin: 0; display: flex; align-items: center; justify-content: center;">
                                        🕌 Dewa Sharif Updates
                                    </h4>
                                    <p style="font-size: 11px; color: #023dbeff; font-weight: 700; margin: 5px 0 8px 0;">
                                        ( Dewa Sharif aur dargah se related updates ke liye hamare WhatsApp group se judein
                                        )
                                    </p>
                                </div>

                                <!-- Bullet Points Area -->
                                <div style="margin-bottom: 12px;">
                                    <ul
                                        style="font-size: 12.5px; color: #111; font-weight: 700; text-align: left; padding-left: 18px; line-height: 1.5; margin: 0; width: 100%; box-sizing: border-box;">
                                        <li>Dargah Sharif, Urs, Mela aur Ziyarat se reated Jankari.</li>
                                        <li>Hotels & Cabs Booking, Travel Guidance & Degh-Niyaz-Langar Facility Availables.
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- QR Image Box -->
                            <div>
                                <div
                                    style="background: #fdfdfd; padding: 8px; border-radius: 12px; border: 2px dashed #ca8a04; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 12px;">
                                    <img src="{{ asset('home/images/dewasharif/dewa-sharif-group.jpeg') }}"
                                        alt="Dewa Sharif WhatsApp QR"
                                        style="width: 100%; max-width: 200px; height: auto; object-fit: contain; display: block; margin: 0 auto; border-radius: 6px;">
                                    <span
                                        style="font-size: 11.5px; font-weight: 800; color: #713f12; display: block; margin-top: 5px;">Scan
                                        QR Code</span>
                                </div>

                                <div>
                                    <a href="https://chat.whatsapp.com/F7iFNc1a4hR9sMZMADXcoy" target="_blank"
                                        style="display: block; background: linear-gradient(135deg, #eab308 0%, #a16207 100%); color: #fff; font-weight: 900; padding: 11px 15px; border-radius: 30px; text-decoration: none; font-size: 14px; box-shadow: 0 4px 15px rgba(202, 138, 4, 0.4);">
                                        📲 Join Group via Link
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: GREEN THEME (Warsi Matrimonial Services - Free) -->
                    <div
                        style="flex: 1; min-width: 300px; max-width: 380px; width: 100%; background: #fff; border: 4px solid transparent; border-image: linear-gradient(135deg, #22c55e, #15803d) 1; border-radius: 16px; padding: 22px 16px; text-align: center; box-shadow: 0 8px 25px rgba(22,163,74,0.2); display: flex; flex-direction: column; justify-content: space-between; position: relative; margin-top: 20px; box-sizing: border-box;">

                        <!-- Floating Badge -->
                        <div
                            style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); width: 90%; text-align: center;">
                            <span
                                style="background: linear-gradient(135deg, #22c55e 0%, #15803d 100%); color: #fff; font-weight: 900; font-size: 10.5px; padding: 5px 12px; border-radius: 14px; text-transform: uppercase; box-shadow: 0 3px 8px rgba(0,0,0,0.2); display: inline-block; white-space: nowrap;">✨
                                FREE SERVICE</span>
                        </div>

                        <div
                            style="padding-top: 10px; display: flex; flex-direction: column; height: 100%; justify-content: space-between;">
                            <div>
                                <div style="text-align: center; margin: 5px 0 0 0;">
                                    <h4
                                        style="color: #14532d; font-weight: 900; font-size: 19px; margin: 0; display: flex; align-items: center; justify-content: center;">
                                        💍 Free Muslim Marriage
                                    </h4>
                                    <p style="font-size: 11px; color: #023dbeff; font-weight: 700; margin: 5px 0 8px 0;">
                                        Dewa Sharif aur All India ke sabhi bhai-behno ke liye bilkul 100% Free rishton ki
                                        jankari
                                    </p>
                                </div>

                                <!-- Bullet Points Area -->
                                <div style="margin-bottom: 12px;">
                                    <ul
                                        style="font-size: 12.5px; color: #111; font-weight: 700; text-align: left; padding-left: 18px; line-height: 1.5; margin: 0; width: 100%; box-sizing: border-box;">
                                        <li>Muslim Marriage Group Dewa Sharif Free- All India.</li>
                                        <li>100% Free Biodata Sharing Service for Everyone in the Community.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- QR Image Box -->
                            <div>
                                <div
                                    style="background: #fdfdfd; padding: 8px; border-radius: 12px; border: 2px dashed #16a34a; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 12px;">
                                    <img src="{{ asset('home/images/dewasharif/free_marriage.jpeg') }}"
                                        alt="Free Marriage QR"
                                        style="width: 100%; max-width: 200px; height: auto; object-fit: contain; display: block; margin: 0 auto; border-radius: 6px;">
                                    <span
                                        style="font-size: 11.5px; font-weight: 800; color: #16a34a; display: block; margin-top: 5px;">Scan
                                        QR Code</span>
                                </div>

                                <div>
                                    <a href="https://chat.whatsapp.com/F7iFNc1a4hR9sMZMADXcoy" target="_blank"
                                        style="display: block; background: linear-gradient(135deg, #22c55e 0%, #15803d 100%); color: #fff; font-weight: 900; padding: 11px 15px; border-radius: 30px; text-decoration: none; font-size: 14px; box-shadow: 0 4px 15px rgba(22, 163, 74, 0.4);">
                                        📲 Join Group Via Link
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3: RED THEME (Warsi Matrimonial Services - Paid Group ₹299) -->
                    {{-- <div
                        style="flex: 1; min-width: 300px; max-width: 380px; width: 100%; background: #fff; border: 4px solid transparent; border-image: linear-gradient(135deg, #ef4444, #b91c1c) 1; border-radius: 16px; padding: 22px 16px; text-align: center; box-shadow: 0 8px 25px rgba(220,38,38,0.2); display: flex; flex-direction: column; justify-content: space-between; position: relative; margin-top: 20px; box-sizing: border-box;">

                        <!-- Floating Badge -->
                        <div
                            style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); width: 90%; text-align: center;">
                            <span
                                style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: #fff; font-weight: 900; font-size: 10.5px; padding: 5px 12px; border-radius: 14px; text-transform: uppercase; box-shadow: 0 3px 8px rgba(0,0,0,0.2); display: inline-block; white-space: nowrap;">⭐
                                PREMIUM GROUP (₹299)</span>
                        </div>

                        <div
                            style="padding-top: 10px; display: flex; flex-direction: column; height: 100%; justify-content: space-between;">
                            <div>
                                <div style="text-align: center; margin: 5px 0 0 0;">
                                    <h4
                                        style="color: #7f1d1d; font-weight: 900; font-size: 19px; margin: 0; display: flex; align-items: center; justify-content: center;">
                                        💎 Paid Marriage Group
                                    </h4>
                                    <p style="font-size: 11px; color: #023dbeff; font-weight: 700; margin: 5px 0 8px 0;">
                                        ( Dewa Sharif aur All India ke Zyada behtar rishton ke liye hamara paid WhatsApp
                                        group join karen )
                                    </p>
                                </div>

                                <!-- Bullet Points Area -->
                                <div style="margin-bottom: 12px;">
                                    <ul
                                        style="font-size: 12.5px; color: #111; font-weight: 700; text-align: left; padding-left: 18px; line-height: 1.5; margin: 0; width: 100%; box-sizing: border-box;">
                                        <li>Muslim Marriage Group Dewa Sharif All India Service and Valid for 6 Months.</li>
                                        <li>Verified Biodatas, Photo, Contact, Address. Direct Admin Posting Service.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- QR Image Box -->
                            <div>
                                <div
                                    style="background: #fdfdfd; padding: 8px; border-radius: 12px; border: 2px dashed #dc2626; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 12px;">
                                    <img src="{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}" alt="PhonePe QR 299"
                                        style="width: 100%; max-width: 200px; height: auto; object-fit: contain; display: block; margin: 0 auto; border-radius: 6px;">
                                    <span
                                        style="font-size: 11.5px; font-weight: 800; color: #b91c1c; display: block; margin-top: 5px;">Scan
                                        QR code using UPI APP</span>
                                </div>

                                <div>
                                    <a href="upi://pay?pa=9648777223@ybl&pn=ShahzadeAlam&am=299.00&cu=INR&tn=Paid+Muslim+Marriage+Group+Subscription+6+Months"
                                        target="_blank"
                                        style="display: block; background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: #fff; font-weight: 900; padding: 11px 15px; border-radius: 30px; text-decoration: none; font-size: 13.5px; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);">
                                        ⚡ Pay ₹299 via UPI / PhonePe
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>

                <!-- More Information & Rules Button -->
                <div class="row text-center" style="margin-top: 20px; margin-left: 0; margin-right: 0;">
                    <div class="col-md-12" style="padding: 0 5px;">
                        <p style="font-size: 13.5px; color: #333; margin-bottom: 10px; font-weight: 700;">
                            ⚠️ Group join karne se pehle niyam aur shartein (Rules & Regulations) zaroor padhein niche
                            Button click karen.
                        </p>
                        <a href="{{ url('/whatsappgroup') }}"
                            style="display: inline-block; background: #0b4625; color: #ffd700; font-weight: 800; padding: 11px 20px; border-radius: 30px; text-decoration: none; font-size: 14px; border: 2px solid #ffd700; box-shadow: 0 4px 12px rgba(11, 70, 37, 0.3); max-width: 100%; box-sizing: border-box;">
                            📖 For More Information & Rules (Niyam & Shartein)
                        </a>
                    </div>
                </div>

            </div>
        </section>

    </div>



    <!-- ================= 3 FEATURED SERVICE CARDS ================= -->
    <section style="padding: 50px 0 25px 0; background: #fdfbf7; border-bottom: 2px solid #e2d7c5;">
        <div class="container">

            <div style="text-align: center; margin-bottom: 30px;">
                <span
                    style="display: inline-block; color: #ffffffff; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; background: #105a35ff; padding: 6px 18px; border-radius: 20px; border: 1.5px solid #fbc02d;">
                    Dewa Sharif Booking, Shopping &amp; Services Portal
                </span>
                <h2 style="color: #1b5e20; font-size: 16px; font-weight: 800; margin-top: 12px; margin-bottom: 8px;">
                    Hotels &amp; Cabs Booking | Sacred Store • Warsi Attar • Degh Niyaz • Mitti Bartan • Sufi Attire •
                    Calligraphy &amp; Art • Toys • Jewellery • Beauty • Food &amp; Health • Electronics • Home Appliances •
                    Pets Care
                </h2>

                <span
                    style="display: inline-block; color: #ffffffff; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; background: #105a35ff; padding: 6px 18px; border-radius: 20px; border: 1.5px solid #fbc02d; margin-top: 10px;">
                    Warsi Technology & Services
                </span>
                <h2 style="color: #1b5e20; font-size: 16px; font-weight: 800; margin-top: 12px; margin-bottom: 8px;">
                    New & Custom Websites Development • Mobile Apps Development • Brand Logo Design • Website Maintenance &
                    Support
                </h2>

            </div>

            <div class="row" style="margin-bottom: 28px; display: flex; flex-wrap: wrap; justify-content: center;">

                <!-- Card 1: Hotel & Guest House -->
                <div class="col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                    <div
                        style="background: #ffffff; border: 2px solid #1b5e20; border-radius: 14px; overflow: hidden; box-shadow: 0 6px 18px rgba(27, 94, 32, 0.12); display: flex; flex-direction: column; width: 100%;">
                        <div style="position: relative; height: 180px; overflow: hidden; background: #1b5e20;">
                            <img src="{{ asset('home/images/dewasharif/dewapage/deluxe_room.jpg') }}"
                                alt="Hotels & Guest House"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span
                                style="position: absolute; top: 12px; left: 12px; background: #1b5e20; color: #ffff00; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 6px; text-transform: uppercase;">🏨
                                VERIFIED STAYS</span>
                        </div>
                        <div
                            style="padding: 22px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <h3 style="font-size: 20px; font-weight: 800; color: #1b5e20; margin-bottom: 8px;">Hotels
                                    &amp; Guest Houses</h3>
                                <p style="font-size: 14px; color: #555; line-height: 1.55; margin-bottom: 15px;">Dargah ke
                                    nazdeek AC/NON AC Rooms, Party-Halls, Guest House, Marriage Hall ki direct live booking.
                                </p>
                                <ul
                                    style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 13px; color: #333; line-height: 1.8;">
                                    <li>✔ Walking distance from Mazar Gate</li>
                                    <li>✔ Neat -Clean &amp; Water Supply</li>
                                    <li>✔ Read Carefully Terms & Conditions</li>
                                </ul>
                            </div>
                            <div>
                                <a href="{{ route('hotels') }}"
                                    style="display: block; width: 100%; text-align: center; background: #1b5e20; color: #ffffff; text-decoration: none; padding: 11px 0; font-weight: 700; font-size: 14px; border-radius: 8px;">Open
                                    Hotel Portal →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Auto & Cab Booking -->
                <div class="col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                    <div
                        style="background: #ffffff; border: 2px solid #b71c1c; border-radius: 14px; overflow: hidden; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15); display: flex; flex-direction: column; width: 100%;">
                        <div style="position: relative; height: 180px; overflow: hidden; background: #b71c1c;">
                            <img src="{{ asset('home/images/dewasharif/dewapage/sedan_dzire.jpg') }}"
                                alt="Auto & Cab Service"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span
                                style="position: absolute; top: 12px; left: 12px; background: #b71c1c; color: #ffffff; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 6px; text-transform: uppercase;">🚕
                                24/7 TRANSPORT</span>
                        </div>
                        <div
                            style="padding: 22px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <h3 style="font-size: 20px; font-weight: 800; color: #b71c1c; margin-bottom: 8px;">Auto
                                    &amp; Cab Booking</h3>
                                <p style="font-size: 14px; color: #555; line-height: 1.55; margin-bottom: 15px;">Barabanki
                                    Junction, Lucknow Charbagh aur Airport se direct Dewa Sharif ke liye verified cabs aur
                                    autos.</p>
                                <ul
                                    style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 13px; color: #333; line-height: 1.8;">
                                    <li>✔ Local Auto, E-Rickshaw, Sedan &amp; SUV</li>
                                    <li>✔ Fixed transparent rates</li>
                                    <li>✔ Station, Airport or Any Location direct pickup</li>
                                </ul>
                            </div>
                            <div>
                                <a href="{{ route('cabs') }}"
                                    style="display: block; width: 100%; text-align: center; background: #b71c1c; color: #ffffff; text-decoration: none; padding: 11px 0; font-weight: 700; font-size: 14px; border-radius: 8px;">Open
                                    Cab Portal →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Online Shop -->
                <div class="col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                    <div
                        style="background: #ffffff; border: 2.5px solid #ffeb3b; border-radius: 14px; overflow: hidden; box-shadow: 0 6px 18px rgba(255, 235, 59, 0.35); display: flex; flex-direction: column; width: 100%;">
                        <div style="position: relative; height: 180px; overflow: hidden; background: #ffeb3b;">
                            <img src="{{ asset('home/images/dewasharif/dewapage/online_shop_mix.jpg') }}"
                                alt="Online Shop" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <span
                                style="position: absolute; top: 12px; left: 12px; background: #ffeb3b; color: #1b5e20; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 6px; text-transform: uppercase;">🛍️
                                AUTHENTIC STORE</span>
                        </div>
                        <div
                            style="padding: 22px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <h3 style="font-size: 20px; font-weight: 800; color: #a17800; margin-bottom: 8px;">Online
                                    Shop</h3>
                                <p style="font-size: 14px; color: #555; line-height: 1.55; margin-bottom: 15px;">Dewa
                                    sharif ke tabarrukat, khushbu-e-attar, chaadar with good fragrance aur mitti bartan etc
                                    order karein.</p>
                                <ul
                                    style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 13px; color: #333; line-height: 1.8;">
                                    <li>✔ Pure Non-Alcoholic Fragrances &amp; Attar</li>
                                    <li>✔ Islamic Products, Clay Pots, Scenery, Jewellery</li>
                                    <li>✔ Safe all-India shipping &amp; delivery</li>
                                </ul>
                            </div>
                            <div>
                                <a href="https://wa.me/919648777223?text={{ urlencode('Assalamu Alaikum! Main Dewa Sharif Portal se Sacred Shop items ke baare me poochhna aur order karna chahta hoon.') }}"
                                    target="_blank"
                                    style="display: block; width: 100%; text-align: center; background: #25D366; color: #ffffff; text-decoration: none; padding: 10px 0; font-weight: 800; font-size: 14px; border-radius: 8px; margin-bottom: 6px;">Order
                                    via WhatsApp 💬</a>
                                <a href="{{ route('shops') }}"
                                    style="display: block; width: 100%; text-align: center; background: #ffeb3b; color: #111111; text-decoration: none; padding: 8px 0; font-weight: 800; font-size: 13px; border-radius: 8px;">🛍️
                                    Browse Shop Items →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DYNAMIC SACRED STORE & SHOPPING CATEGORY CARDS -->
                @php
                    $landingCategories =
                        !empty($shopCategories) && count($shopCategories) > 0
                            ? $shopCategories
                            : \Illuminate\Support\Facades\DB::table('shop_categories')
                                ->orderBy('order_num', 'asc')
                                ->orderBy('id', 'asc')
                                ->get();
                @endphp

                @foreach ($landingCategories as $sc)
                    @php
                        $isCatActive = strtolower($sc->status ?? 'active') === 'active';
                    @endphp
                    <div class="col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                        <div style="background: #ffffff; border: 2px solid {{ $sc->theme_color ?? '#10b981' }}; border-radius: 14px; overflow: hidden; box-shadow: 0 6px 18px {{ $sc->theme_color ?? '#10b981' }}22; display: flex; flex-direction: column; width: 100%; transition: transform 0.25s ease, box-shadow 0.25s ease;"
                            onmouseenter="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 25px {{ $sc->theme_color ?? '#10b981' }}35';"
                            onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 18px {{ $sc->theme_color ?? '#10b981' }}22';">

                            <div
                                style="position: relative; height: 180px; overflow: hidden; background: {{ $sc->theme_color ?? '#10b981' }};">
                                <img src="{{ asset($sc->image ?? '/home/images/dewasharif/dewapage/attar_bottle.jpg') }}"
                                    alt="{{ $sc->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover; display: block;"
                                    onerror="this.onerror=null; this.src='/home/images/dewasharif/dewapage/attar_bottle.jpg';">
                                <span
                                    style="position: absolute; top: 12px; left: 12px; background: {{ $isCatActive ? $sc->theme_color ?? '#10b981' : '#d97706' }}; color: #ffffff; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid rgba(255,255,255,0.4); box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                                    {{ $isCatActive ? $sc->badge_text ?? strtoupper($sc->name) : '⏳ LAUNCHING SOON' }}
                                </span>
                                @if (!empty($sc->tag_text))
                                    <span
                                        style="position: absolute; bottom: 10px; right: 12px; background: #ffffff; color: {{ $isCatActive ? $sc->theme_color ?? '#10b981' : '#d97706' }}; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                                        {{ $sc->tag_text }}
                                    </span>
                                @endif
                            </div>

                            <div
                                style="padding: 22px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <h3
                                        style="font-size: 20px; font-weight: 800; color: {{ $sc->theme_color ?? '#10b981' }}; margin-bottom: 8px;">
                                        {{ $sc->name }}
                                    </h3>
                                    <p
                                        style="font-size: 14px; color: #555; line-height: 1.55; margin-bottom: 15px; min-height: 44px;">
                                        {{ $sc->description ?? 'Authentic sacred offerings direct from Dewa Sharif.' }}
                                    </p>

                                    <ul
                                        style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 13px; color: #333; line-height: 1.8; min-height: 72px;">
                                        @php
                                            $bulletList = !empty($sc->features)
                                                ? explode("\n", str_replace("\r", '', $sc->features))
                                                : [];
                                        @endphp
                                        @foreach ($bulletList as $bullet)
                                            @if (!empty(trim($bullet)))
                                                <li>{{ trim($bullet) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <div>
                                    @if (strtolower($sc->status ?? 'active') === 'active')
                                        <a href="{{ route('shops.category', $sc->slug) }}"
                                            style="display: block; width: 100%; text-align: center; background: {{ $sc->theme_color ?? '#10b981' }}; color: #ffffff; text-decoration: none; padding: 11px 0; font-weight: 700; font-size: 14px; border-radius: 8px; box-shadow: 0 3px 8px {{ $sc->theme_color ?? '#10b981' }}55; transition: opacity 0.2s;"
                                            onmouseenter="this.style.opacity='0.92';"
                                            onmouseleave="this.style.opacity='1';">
                                            {{ $sc->button_text ?? 'Explore ' . $sc->name . ' →' }}
                                        </a>
                                    @else
                                        <button type="button"
                                            onclick="showComingSoonModal('{{ addslashes($sc->name) }}')"
                                            style="display: block; width: 100%; text-align: center; background: #64748b; color: #ffffff; border: none; padding: 11px 0; font-weight: 700; font-size: 14px; border-radius: 8px; cursor: pointer; box-shadow: 0 3px 8px rgba(0,0,0,0.15); transition: background 0.2s;"
                                            onmouseenter="this.style.background='#475569';"
                                            onmouseleave="this.style.background='#64748b';">
                                            ⏳ Coming Soon (Launching Shortly)
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- ================= END FEATURED SERVICE CARDS ================= -->


    <section id="banner">
        <video width="300" height="150" id="myVideo" loop="loop" muted="" autoplay="autoplay">
            <source src="{{ asset('home/images/dewasharif/topvideo/Makkah Madina.mp4') }}" type="video/mp4" />
        </video>
        <div class="videocontrol">
            <button onclick="playVid()" type="button"><i class="fa fa-play" aria-hidden="true"></i></button>
            <button onclick="pauseVid()" type="button"><i class="fa fa-pause" aria-hidden="true"></i></button>
        </div>
    </section>

    <section class="important-event">
        <style>
            @media (max-width: 767px) {
                .important-event {
                    padding: 30px 12px 50px 12px !important;
                }
            }
        </style>
        <div class="container">
            <div class="title">
                <h1 style="color:#03be64"><b>"یہ ویب سائٹ کسی بھی قسم کے شرک کی نہ اجازت دیتی ہے اور نہ اس کی پیروی کرتی
                        ہے۔
                        اللہ ("یعنی اعلیٰ ذات — واحد، بےشکل، اور کائنات کا خالق۔") کے سوا کوئی معبود نہیں اور محمد ﷺ اللہ کے
                        رسول ہیں۔ اولیاء اللہ کے مزارات پر بے ادبی سے بچیں اور ہر اس چیز سے پرہیز کریں جس کی اسلام اجازت
                        نہیں دیتا۔"</b></h1><br>
                <h1 style="color:#03be64"><b>"यह वेबसाइट किसी भी प्रकार के शिर्क की अनुमति न देती है और न समर्थन करती है।
                        अल्लाह ("परमेश्वर अर्थात सर्वोच्च, एक, निराकार, सृष्टिकर्ता") के सिवा कोई माबूद नहीं, और मुहम्मद ﷺ
                        अल्लाह के रसूल हैं। औलिया-अल्लाह की दरगाहों पर बेअदबी से बचें और उन सभी कार्यों से दूर रहें जिनकी
                        इस्लाम में अनुमति नहीं है।"</b></h1><br>
                <h1 style="color:#03be64"><b>"This website does not permit or endorse any form of shirk. There is no deity
                        worthy of worship except Allah (“God, meaning the Supreme One — the One, Formless, and the Creator
                        of the universe.”), and Muhammad (ﷺ) is the Messenger of Allah. We advise everyone to avoid any act
                        of disrespect at the shrines of the Awliya Allah and to refrain from anything that is not permitted
                        in Islam."</b></h1><br><br><br>

                <h1 style="color:#0cff8a"><b>What&rsquo;s New</b> in <b>DEWA SHARIF </b>?</h1>
                <h3>
                    <p style="color:#03be64; font-weight: 800; font-size: 22px; margin: 10px 0;">
                        DEWA SHARIF MELA <span style="color: #ffeb3b; font-weight: 700;">(27 October 2026 – 5 November
                            2026)</span>
                    </p>
                </h3>
            </div>
            <div class="row event-gallery-row">
                <div class="col-md-3 col-sm-6 col-xs-12 event-col">
                    <div class="event-img-card">
                        <img src="{{ asset('home/images/dewasharif/event/event-1.jpeg') }}"
                            class="img-responsive event-img" alt="Dewa Sharif Mela Night Lightening"
                            title="Dewa Sharif Mela Lightening">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 event-col">
                    <div class="event-img-card">
                        <img src="{{ asset('home/images/dewasharif/event/event-2.png') }}"
                            class="img-responsive event-img" alt="Zikr-e-Ali Ibadat Dewa Sharif"
                            title="Zikr-e-Ali Ibadat">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 event-col">
                    <div class="event-img-card">
                        <img src="{{ asset('home/images/dewasharif/event/event-3.jpeg') }}"
                            class="img-responsive event-img" alt="Dargah Dewa Sharif Illumination"
                            title="Dargah Dewa Sharif Illumination">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 event-col">
                    <div class="event-img-card">
                        <img src="{{ asset('home/images/dewasharif/event/event-shop.png') }}"
                            class="img-responsive event-img" alt="Online Shopping Dewa Sharif"
                            title="Coming Soon Shopping">
                    </div>
                </div>
            </div>

            <style>
                .event-gallery-row {
                    margin-top: 15px;
                }

                .event-col {
                    margin-bottom: 20px;
                }

                .event-img-card {
                    background: #012b13;
                    border: 2px solid #00e676;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
                    padding: 6px;
                    text-align: center;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100%;
                    min-height: 280px;
                    transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
                }

                .event-img-card:hover {
                    transform: translateY(-4px);
                    border-color: #ffeb3b;
                    box-shadow: 0 10px 24px rgba(0, 230, 118, 0.35);
                }

                .event-img {
                    width: 100%;
                    height: auto;
                    max-height: 280px;
                    object-fit: contain;
                    display: block;
                    margin: 0 auto;
                    border-radius: 8px;
                }

                @media (max-width: 767px) {
                    .event-col {
                        width: 100% !important;
                        padding-left: 10px !important;
                        padding-right: 10px !important;
                        margin-bottom: 18px !important;
                    }

                    .event-img-card {
                        min-height: auto !important;
                        padding: 8px !important;
                        border-radius: 12px !important;
                    }

                    .event-img {
                        max-height: none !important;
                        height: auto !important;
                        width: 100% !important;
                        object-fit: contain !important;
                    }
                }
            </style>
        </div>
        <div class="explorebg2">
            <img src="{{ asset('home/images/Festive_Delights_divider.png') }}" alt="Background" title="Background" />
        </div>
    </section>



    <section id="explore">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h2>"Dewa Sharif:<b> A Legacy of Love, Faith, Spirituality, Humanity, Peace And Devotion"</b></h2>
                    <style>
                        .letters-wrap-box {
                            width: 100%;
                            margin: 15px auto;
                            text-align: center;
                            padding: 0 12px;
                            box-sizing: border-box;
                        }

                        .letters-row {
                            display: flex !important;
                            justify-content: center !important;
                            align-items: flex-start !important;
                            list-style: none !important;
                            padding: 0 !important;
                            margin: 0 auto 18px auto !important;
                            gap: 20px;
                            flex-wrap: nowrap !important;
                        }

                        .letters-row li {
                            text-align: center;
                            margin: 0 !important;
                            padding: 0 2px;
                            transition: transform 0.3s ease;
                            flex: 0 0 auto;
                        }

                        .letters-row li a {
                            display: block;
                            pointer-events: none;
                        }

                        .letters-row li img {
                            height: 120px;
                            display: block;
                            margin: 5px auto;
                            max-width: 100%;
                            object-fit: contain;
                        }

                        .letters-row li p {
                            color: #005c29;
                            font-size: 13px;
                            font-weight: 700;
                            text-align: center;
                            margin-top: 4px;
                            letter-spacing: 0.4px;
                        }

                        .letters-row li:hover {
                            transform: translateY(-8px);
                        }

                        @media (max-width: 991px) {
                            .letters-row {
                                gap: 14px;
                            }

                            .letters-row li img {
                                height: 85px;
                            }

                            .letters-row li p {
                                font-size: 11px;
                            }
                        }

                        @media (max-width: 768px) {
                            .letters-row {
                                gap: 8px;
                                margin-bottom: 12px !important;
                            }

                            .letters-row li img {
                                height: 50px;
                            }

                            .letters-row li p {
                                font-size: 8px;
                                letter-spacing: 0;
                            }
                        }

                        @media (max-width: 480px) {
                            .letters-wrap-box {
                                padding: 0 8px;
                            }

                            .letters-row {
                                gap: 5px;
                                margin-bottom: 10px !important;
                            }

                            .letters-row li img {
                                height: 38px;
                                max-width: 32px;
                            }

                            .letters-row li p {
                                font-size: 6.5px;
                                margin-top: 2px;
                            }
                        }

                        @media (max-width: 360px) {
                            .letters-wrap-box {
                                padding: 0 6px;
                            }

                            .letters-row {
                                gap: 3px;
                            }

                            .letters-row li img {
                                height: 30px;
                                max-width: 25px;
                            }

                            .letters-row li p {
                                font-size: 5.5px;
                            }
                        }

                        @media (max-width: 300px) {
                            .letters-wrap-box {
                                padding: 0 4px;
                            }

                            .letters-row {
                                gap: 2px;
                            }

                            .letters-row li img {
                                height: 26px;
                                max-width: 22px;
                            }

                            .letters-row li p {
                                font-size: 5px;
                            }
                        }
                    </style>

                    <div class="letters-wrap-box">
                        <!-- LINE 1: DEWA -->
                        <ul class="letters-row">
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/1.png') }}" alt="DEVOTION"
                                        title="DEVOTION" /></a>
                                <p>DEVOTION</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/2.png') }}" alt="EDUCATION"
                                        title="EDUCATION" /></a>
                                <p>EDUCATION</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/3.png') }}" alt="WARSI"
                                        title="WARSI" /></a>
                                <p>WARSI</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/4.png') }}" alt="AZAAN"
                                        title="AZAAN" /></a>
                                <p>AZAAN</p>
                            </li>
                        </ul>

                        <!-- LINE 2: SHARIF -->
                        <ul class="letters-row">
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/5.png') }}"
                                        alt="SPRITUALITY" title="SPRITUALITY" /></a>
                                <p>SPRITUALITY</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/6.png') }}" alt="HUMANITY"
                                        title="HUMANITY" /></a>
                                <p>HUMANITY</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/7.png') }}" alt="AWLIYA"
                                        title="AWLIYA" /></a>
                                <p>AWLIYA</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/8.png') }}" alt="RELIGIOUS"
                                        title="RELIGIOUS" /></a>
                                <p>RELIGIOUS</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/9.png') }}" alt="ISLAM"
                                        title="ISLAM" /></a>
                                <p>ISLAM</p>
                            </li>
                            <li><a href="#"><img src="{{ asset('home/images/dewasharif/10.png') }}" alt="FAITH"
                                        title="FAITH" /></a>
                                <p>FAITH</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center text-center">
                    <div class="row justify-content-center text-center">
                        <!-- Father Card -->
                        <div class="col-md-6 col-sm-6 col-12 mb-3 px-2">
                            <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px 10px; background: #fff;">
                                <img src="{{ asset('home/images/dewasharif/walidsahab.jpeg') }}" alt="Father"
                                    title="Barkat Ali"
                                    style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid #ffeb3b;" />
                                <h4
                                    style="font-size: 18px; font-weight: 800; text-align: center; margin-top: 10px; color: #14412a;">
                                    BARKAT ALI <br><span style="font-size: 14px;">[FATHER]</span></h4>
                                <p style="margin: 0; text-align: center; font-size: 14px;"><b><i>Barkat Ali Kirana
                                            Store</i></b> <br /> <b
                                        style="word-break: break-all; color: #09532f;">www.dewasharif.com</b></p>
                            </div>
                        </div>

                        <!-- Shahzade Alam Card -->
                        <div class="col-md-6 col-sm-6 col-12 mb-3 px-2">
                            <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px 10px; background: #fff;">
                                <img src="{{ asset('home/images/dewasharif/masharrat.jpg') }}" alt="Shahzade Alam"
                                    title="Shahzade Alam"
                                    style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid #ffeb3b;" />
                                <h4
                                    style="font-size: 18px; text-align: center; font-weight: 800; margin-top: 10px; color: #14412a;">
                                    Shahzade Alam <br><span style="font-size: 14px;">[مشرت وارثی]</span></h4>
                                <p style="margin: 0; text-align: center; font-size: 14px;"><b><i>Software Engineer</i></b>
                                    <br /> <b style="word-break: break-all; color: #09532f;">www.dewasharif.com</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Masjid AL Waris --}}
    <div class="kumbh-25">
        <div class="kumbhshape-1"><img src="{{ asset('home/images/kumbh-2.png') }}" alt="" /></div>
        <img src="{{ asset('home/images/dewasharif/trip0.jpeg') }}" height="100%" width="100%"
            alt="background image">
        <div class="kumbhshape-2"><img src="{{ asset('home/images/kumbh-1.png') }}" style="margin-bottom:9px;"
                alt="" />
        </div>
    </div>

    {{-- Masjid AL Waris Video --}}
    <div class="kumbh-25">
        <div class="kumbhshape-1"><img src="{{ asset('home/images/kumbh-2.png') }}" alt="" /></div>
        <video height="30%" width="100%" autoplay loop muted>
            <source src="{{ asset('home/images/dewasharif/pagebackground/Eid.mp4') }}" type="video/mp4">
        </video>
    </div>

    <section id="festive">
        <div class="container">
            <div class="title">
                <p style="color: #0a5c36">Checkout <i>Festivals </i> &amp; <i>Events </i> of <b><i>Islam </i></b> &amp;
                    <b><i>Dewa Sharif</i></b>
                </p>
                <h1 style="color: #03be64"> <b>Islamic Festive Seasons</b></h1>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-tabs tabs-left">
                        <li><a href="#January" data-toggle="tab">January</a></li>
                        <li><a href="#February" data-toggle="tab">February</a></li>
                        <li><a href="#March" data-toggle="tab">March</a></li>
                        <li><a href="#April" data-toggle="tab">April</a></li>
                        <li><a href="#May" data-toggle="tab">May</a></li>
                        <li><a href="#June" data-toggle="tab">June</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="tab-content festivetab">
                        <div class="tab-pane" id="January">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="February">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="March">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="April">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="May">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="June">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="July">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="August">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane active" id="September">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="October">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="November">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="December">
                            <ul class="festivals owl-carousel">
                                <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                        alt="Dewa Sharif Mazar Sharif" title="Dewa Sharif Mazar Sharif" />
                                    <ul class="description"></ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <ul class="nav nav-tabs tabs-left">
                        <li><a href="#July" data-toggle="tab">July</a></li>
                        <li><a href="#August" data-toggle="tab">August</a></li>
                        <li class="active"><a href="#September" data-toggle="tab">September</a></li>
                        <li><a href="#October" data-toggle="tab">October</a></li>
                        <li><a href="#November" data-toggle="tab">November</a></li>
                        <li><a href="#December" data-toggle="tab">December</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="trip">
        <div class="explorebg">
            <img src="{{ asset('home/images/tribg1.png') }}" alt="Image of background" title="background" />
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 trip-plan">
                    <h2>Plan Your Trip</h2>
                    <ul>
                        <li><a href="{{ route('hotels') }}"><img src="{{ asset('home/images/icons/hotel.png') }}"
                                    alt="Hotel" title="Image of Hotel" /> Hotel Accommodation</a></li>
                        <li><a href="{{ route('cabs') }}"><img src="{{ asset('home/images/icons/bus.png') }}"
                                    alt="Taxi/Bus" title="Image of Taxi/Bus" /> Taxi / Bus</a></li>
                        <li><a href="#" target="_blank" rel="noopener"><img
                                    src="{{ asset('home/images/icons/guide.png') }}" alt="Authorised Travel Guides"
                                    title="Image of Authorised Travel Guides" /> Authorised Travel Guides</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="explorebg2">
            <img src="{{ asset('home/images/tribg2.png') }}" alt="Image of background" title="background" />
        </div>
    </section>

    <section id="trip2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 trip-plan">
                    <ul
                        style="display: flex; flex-wrap: wrap; gap: 20px; list-style: none; padding: 0; margin-top: 20px; justify-content: center; align-items: center;">
                        <li style="text-align: center;">
                            <a href="{{ route('allah') }}" target="_blank" rel="noopener">
                                <img src="{{ asset('home/images/icons/allah.jpg') }}" alt="Allah S.W.T"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                                <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Allah
                                    (S.W.T)</span>
                            </a>
                        </li>
                        <li style="text-align: center;">
                            <a href="{{ route('hazratmuhammad') }}" target="_blank" rel="noopener">
                                <img src="{{ asset('home/images/icons/muhammad.jpg') }}" alt="Hz. Muhammad"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                                <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Hz. Muhammad
                                    (S.A.W)</span>
                            </a>
                        </li>
                        <li style="text-align: center;">
                            <a href="{{ route('khanaekaaba') }}" target="_blank" rel="noopener">
                                <img src="{{ asset('home/images/icons/kaba2.jpg') }}" alt="Khana-e-Kaaba"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                                <span
                                    style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Khana-e-Ka'aba</span>
                            </a>
                        </li>
                        <li style="text-align: center;">
                            <a href="{{ route('muhammad') }}" target="_blank" rel="noopener">
                                <img src="{{ asset('home/images/icons/jumapic.jpg') }}" alt="Raoza-E-Rasool"
                                    title="Raoza-E-Rasool"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                                <span
                                    style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Raoza-E-Rasool
                                    (S.A.W)</span>
                            </a>
                        </li>
                        <li style="text-align: center;">
                            <a href="{{ route('hajiwarisalishah') }}" target="_blank" rel="noopener">
                                <img src="{{ asset('home/images/icons/melalogo.jpg') }}" alt="Haji Waris Ali Shah R.A."
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                                <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Haji Waris
                                    Ali Shah R.A.</span>
                            </a>
                        </li>
                        <li style="text-align: center;">
                            <a href="https://dewasharif.com" target="_blank" rel="noopener">
                                <img src="{{ asset('home/images/icons/panjatanpaak.jpg') }}" alt="Panjatan Pak"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                                <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Panjatan
                                    Pak</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="unfold">
        <div class="container">
            <div class="title">
                <p style="color: #0a5c36">Dive In And Discover</p>
                <h1 style="color: #03be64"><b>Visual Library</b></h1>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="pcard">
                        <a href="#" target="_blank" rel="noopener"><img src="{{ asset('home/images/1.jpg') }}"
                                alt="Blog" class="img-fluid" /></a>
                        <div class="box text-center">
                            <a href="#" target="_blank" rel="noopener"><img
                                    src="{{ asset('home/images/blog.png') }}" alt="Blog" class="img-fluid" /></a>
                            <h4><a href="#">Blog</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="pcard">
                        <a href="#" rel="noopener"><img src="{{ asset('home/images/2.jpg') }}"
                                alt="Photo Gallery" class="img-fluid" /></a>
                        <div class="box text-center">
                            <a href="#"><img src="{{ asset('home/images/Visual_Library1.png') }}"
                                    alt="Photo Gallery" class="img-fluid" /></a>
                            <h4><a href="#">Photo Gallery</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="pcard">
                        <a href="#" rel="noopener"><img src="{{ asset('home/images/3.jpg') }}"
                                alt="Video Gallery" class="img-fluid" /></a>
                        <div class="box text-center">
                            <a href="#"><img src="{{ asset('home/images/Visual_Library2.png') }}"
                                    alt="Video Gallery" class="img-fluid" /></a>
                            <h4><a href="#">Video Gallery</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="pcard">
                        <a href="#" rel="noopener"><img src="{{ asset('home/images/dewasharif/india.jpg') }}"
                                alt="India" class="img-fluid" /></a>
                        <div class="box text-center">
                            <a href="#"><img src="{{ asset('home/images/icons/oneday.png') }}" alt="India"
                                    class="img-fluid" /></a>
                            <h4><a href="#">India</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="explorebg2">
            <img src="{{ asset('home/images/unfoldbg.png') }}" alt="Image of Background" />
        </div>
    </section>

    <!-- =================================================================== -->
    <!-- 🚀 GOOGLE ADSENSE & E-E-A-T OPTIMIZED CONTENT SECTION (ADDED) -->
    <!-- =================================================================== -->
    <section
        style="padding: 50px 20px; background: #ffffff; border-top: 3px solid #03be64; border-bottom: 3px solid #03be64; margin: 40px 0;">
        <div class="container" style="max-width: 1000px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 35px;">
                <span
                    style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 15px; border-radius: 20px; letter-spacing: 1px;">
                    Official Information Portal
                </span>
                <h2 style="color: #0b4625; font-size: 28px; font-weight: 900; margin-top: 15px; line-height: 1.4;">
                    Welcome to Dewa Sharif — Spiritual Heritage, Ziyarat & Travel Hub
                </h2>
                <hr style="width: 80px; height: 3px; background: #03be64; border: none; margin: 15px auto;">
            </div>

            <div style="font-size: 16px; color: #333333; line-height: 1.8; font-weight: 400; text-align: justify;">
                <p style="margin-bottom: 20px;">
                    <strong>Dewa Sharif</strong> (देवा शरीफ) is one of the most revered spiritual destinations in India,
                    located in the Barabanki district of Uttar Pradesh. Millions of devotees and pilgrims (Zaireen) visit
                    the sacred shrine of <strong>Hazrat Sayyad Haji Waris Ali Shah (r.a.)</strong> every year to seek
                    spiritual solace, peace, and blessings. Known universally as a symbol of unconditional love, communal
                    harmony, and divine devotion, Dewa Sharif attracts people across all faiths and regions.
                </p>

                <h3 style="color: #0b4625; font-size: 20px; font-weight: 800; margin-top: 25px; margin-bottom: 12px;">
                    Key Services & Facilities Offered on dewasharif.com
                </h3>
                <p style="margin-bottom: 15px;">
                    Our platform is meticulously designed to serve pilgrims visiting Barabanki and Lucknow with seamless
                    online digital services:
                </p>
                <ul style="list-style-type: disc; padding-left: 25px; margin-bottom: 20px; color: #444;">
                    <li style="margin-bottom: 8px;"><strong>Hotel & Guest House Bookings:</strong> Secure verified AC and
                        Non-AC accommodations, guest houses, and stay packages within walking distance from the Mazar gate.
                    </li>
                    <li style="margin-bottom: 8px;"><strong>Cab & Taxi Services:</strong> 24/7 reliable pickup and drop
                        facilities from Lucknow Chaudhary Charan Singh International Airport, Lucknow Charbagh Railway
                        Station, and Barabanki Junction straight to Dewa Sharif.</li>
                    <li style="margin-bottom: 8px;"><strong>Degh Niyaz & Sacred Store:</strong> Direct digital booking for
                        Degh, authentic non-alcoholic Warsi attars, traditional tabarrukat, and home delivery support.</li>
                    <li style="margin-bottom: 8px;"><strong>Urs Mela Updates:</strong> Accurate schedules, historical
                        insights, route guidance, and safety advisories for the grand annual Dewa Sharif Urs and Exhibition.
                    </li>
                </ul>

                <h3 style="color: #0b4625; font-size: 20px; font-weight: 800; margin-top: 25px; margin-bottom: 12px;">
                    Plan Your Visit to Barabanki & Lucknow Region
                </h3>
                <p style="margin-bottom: 20px;">
                    Whether you are planning a one-day spiritual journey (Ziyarat) or attending the world-famous annual Dewa
                    Mela, our portal provides trusted assistance, transparent pricing, and direct communication lines via
                    WhatsApp and customer support. Experience a hassle-free pilgrimage with authentic local guidance and
                    digital convenience.
                </p>
            </div>
        </div>
    </section>
    <!-- =================================================================== -->

    <!-- CONNECT SECTION -->
    <section id="connect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center title">
                        <h1><b>Connect </b> &amp; <b>Engage</b></h1>
                    </div>

                    <style>
                        #connect .sm-icon {
                            display: flex !important;
                            flex-wrap: wrap !important;
                            justify-content: center !important;
                            align-items: center !important;
                            list-style: none !important;
                            padding: 0 !important;
                            margin: 25px auto 10px auto !important;
                            gap: 16px;
                            width: 100%;
                            max-width: 780px;
                            box-sizing: border-box;
                        }

                        #connect .sm-icon li {
                            display: flex !important;
                            justify-content: center !important;
                            align-items: center !important;
                            float: none !important;
                            width: auto !important;
                            padding: 0 !important;
                            margin: 0 !important;
                        }

                        #connect .sm-icon li a {
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            width: 100px !important;
                            height: 100px !important;
                            border-radius: 50% !important;
                            background: #ffffff !important;
                            font-size: 48px !important;
                            line-height: 1 !important;
                            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
                            transition: transform 0.25s ease, box-shadow 0.25s ease;
                            margin: 0 !important;
                        }

                        #connect .sm-icon li a:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
                        }

                        @media (max-width: 768px) {
                            #connect .sm-icon {
                                gap: 14px 12px !important;
                                padding: 0 10px !important;
                            }

                            #connect .sm-icon li a {
                                width: 72px !important;
                                height: 72px !important;
                                font-size: 34px !important;
                            }
                        }
                    </style>

                    <ul class="sm-icon">
                        <li><a href="https://www.facebook.com/dewasharif707?mibextid=ZbWKwL" target="_blank"
                                rel="noopener" class="external none" title="Facebook"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="https://x.com/dewasharif707?t=V7INlftOKGRvkXpyxt8hcg&s=09" target="_blank"
                                rel="noopener" class="external none" title="Twitter"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="https://www.instagram.com/masharrat_bin_barkat/" target="_blank" rel="noopener"
                                class="external none" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://wa.me/919648777223" target="_blank" rel="noopener" class="external none"
                                title="WhatsApp"><i class="fa fa-whatsapp"></i></a></li>
                        <li><a href="https://www.youtube.com/@DewaSharif707" target="_blank" rel="noopener"
                                class="external none" title="YouTube"><i class="fa fa-youtube-play"></i></a></li>
                        <li>
                            <a href="#" target="_blank" rel="noopener" class="external none"
                                title="UP Tourism Blog" style="position: relative;">
                                <img src="{{ asset('home/images/blog.png') }}"
                                    style="filter: contrast(0%) brightness(20%); width: 74px;" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="explorebg2">
            <img src="{{ asset('home/images/connectbg.png') }}" alt="Image of background" title="background" />
        </div>
    </section>

    <section id="branding">
        <div class="container">
            <div class="title">
                <h1 style="color: #074121"><b>Mother's Love</b> is the <b>Fragrance</b> of <b>Jannat</b> <i><b>- MASHARRAT
                            WARSI</b></i></h1>
            </div>
        </div>
    </section>
@endsection
