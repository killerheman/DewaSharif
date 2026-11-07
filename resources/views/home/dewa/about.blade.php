@extends('home.includes.master')
@section('content')
<div class="container" style="padding: 45px 15px;">
    
    <!-- Title Header -->
    <div style="text-align: center; margin-bottom: 35px;">
        <span style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; letter-spacing: 1px;">
            A Sacred Spiritual Destination
        </span>
        <h1 style="color: #0b4625; font-size: 30px; font-weight: 900; margin-top: 12px;">
            About Dewa Sharif — History, Faith & Pilgrim Guide
        </h1>
        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;"></div>
    </div>
    
    <!-- Main Intro Section -->
    <div class="row" style="align-items: center; display: flex; flex-wrap: wrap;">
        <div class="col-sm-8" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">
            <p style="margin-bottom: 18px;">
                Agar aap <strong>Dewa Sharif</strong> (देवा शरीफ) ke baare mein jaanana chahte hain, toh yeh sirf Uttar Pradesh ke Barabanki district ka ek kasba nahi hai, balki yeh duniya bhar ke laakhon aashiqane-e-Ruhaniyat aur zaireen ke liye ek aisi roohani jagah hai jahan sukoon ki talash puri hoti hai. Lucknow se sirf 26 kilometer ki doori par bas yeh mukaddas maqam Hazrat Sayyad Haji Waris Ali Shah (r.a.) ki dargah ke liye poori duniya mein jaana jata hai. Yahan aane waley har shakhs ko bina kisi bhed-bhaav ke mohabbat, bhaichara aur insaniyat ka paigam milta hai.
            </p>
            <p style="margin-bottom: 18px;">
                Yahan ki fizaon mein ek ajeeb sa noor aur sukoon hai. State government ne bhi iske aihmiyat ko samajhte hue ise U.P. ke 'Heritage Arc' mein shamil kiya hai. Yahan ki local aabadi mein Urdu zaban bolne walon ka ek bada hissa hai, jo iski tehzeeb aur purane rang ko aaj bhi zinda rakhe hue hain.
            </p>
        </div>
        <div class="col-sm-4 text-center" style="margin-bottom: 20px;">
            <div style="padding: 6px; background: #fff; border: 2px solid #03be64; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.1);">
                <img src="{{asset('home/images/dewasharif/dewapage/about.jpg')}}" alt="Dewa Sharif Shrine" title="Dewa Sharif Shrine" style="width: 100%; border-radius: 8px; display: block;">
                <span style="display: block; font-size: 13px; font-weight: 700; color: #0b4625; margin-top: 8px;">Dewa Sharif Darbar-e-Auliya</span>
            </div>
        </div>
    </div>

    <!-- Ziyarat Timings Box -->
    <div class="row" style="margin-top: 35px;">
        <div class="col-md-12" style="background: linear-gradient(135deg, #fdfbf7 0%, #f4eee1 100%); padding: 30px; border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">
            <h3 style="color: #0b4625; font-weight: 900; font-size: 22px; margin-top: 0; margin-bottom: 10px; text-align: center;">
                ✨ Dargah Sharif Ziyarat Timings (Aane Ka Samay) ✨
            </h3>
            <p style="text-align: center; color: #555; font-size: 15px; margin-bottom: 25px;">
                Agar aap Ziyarat ke liye aa rahe hain, toh mausam ke hisaab se Dargah ke khulne ka waqt yeh rehta hai:
            </p>
            
            <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                <!-- Winter Timing -->
                <div style="flex: 1; min-width: 280px; max-width: 450px; background: #ffffff; padding: 20px 25px; border-radius: 10px; border-top: 5px solid #1b5e20; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                    <h4 style="color: #1b5e20; font-weight: 800; font-size: 18px; margin-top: 0;">❄️ Winter (Sardi ke Din)</h4>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">Morning <strong>(Subah)</strong>: 5:00 AM to 12:00 PM </p>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">After-Noon <strong>(Dopahar)</strong>: 2:00 PM to 9:00 PM </p>
                </div>
                
                <!-- Summer Timing -->
                <div style="flex: 1; min-width: 280px; max-width: 450px; background: #ffffff; padding: 20px 25px; border-radius: 10px; border-top: 5px solid #d97706; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                    <h4 style="color: #b45309; font-weight: 800; font-size: 18px; margin-top: 0;">☀️ Summer (Garmi ke Din)</h4>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">Morning <strong>(Subah)</strong>: 4:00 AM to 12:00 PM </p>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">After-Noon <strong>(Dopahar)</strong>: 2:00 PM to 10:00 PM </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Local Info & Census -->
    <div class="row" style="margin-top: 35px;">
        <div class="col-md-12" style="background: #ffffff; padding: 25px 30px; border-radius: 12px; border: 1.5px solid #e2d7c5; box-shadow: 0 3px 10px rgba(0,0,0,0.04);">
            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 0; margin-bottom: 12px;">
                📊 Demographics & Local Culture
            </h3>
            <p style="font-size: 15px; line-height: 1.8; color: #444; margin: 0;">
                2011 ki census report ke mutabiq, Dewa ki total aabadi lagbhag 15,662 thi. Yahan ke log behad mehman-nawaz aur milan-sar hain. Is portal (<i>dewasharif.com</i>) ko banane ka maqsad hi yahi hai ki door-door se aane wale zayreen ya khwahishmand logon ko Haji Sayyad Waris Ali Shah (R.A.) aur Dargah se related information mil sake aur hotels booking, cabs booking,  degh-niyaz booking, shopping etc help zyareen & visitors ko bina kisi pareshani ke ghar baithe ya visit karne wale logon ko asani se mil sake.
            </p>
        </div>
    </div>

    <!-- Travel Guide -->
    <div class="row" style="margin-top: 35px;">
        <div class="col-md-12" style="padding: 10px 0;">
            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-bottom: 15px;">
                🚗 Yahan Kaise Pahunchein? (Travel & Route Guide)
            </h3>
            <p style="font-size: 15px; line-height: 1.8; color: #333; margin-bottom: 15px;">
                Dewa Sharif tak aana behad aasan hai kyunki yeh sadak aur rail marg se acchi tarah juda hua hai:
            </p>
            <ul style="font-size: 15px; line-height: 1.8; color: #444; padding-left: 20px;">
                <li style="margin-bottom: 8px;"><strong>By Road (Sadak Marg):</strong> Aap Lucknow, Barabanki, Fatehpur, aur Chinhat se direct road ke raste cabs ya buses ke zariye yahan pahunch sakte hain. Humari site par 24x7 cab booking ki suvidha bhi uplabdh hai.</li>
                <li style="margin-bottom: 8px;"><strong>By Train (Rail Marg):</strong> Sabse nazdeek railway stations Barabanki Junction aur Lucknow Charbagh hain, jahan se local transport easily mil jata hai.</li>
                <li style="margin-bottom: 8px;"><strong>By Air (Hawai Jahaz):</strong> Sabse paas ka airport Lucknow Chaudhary Charan Singh International Airport hai, jahan se aap direct taxi book karke Dewa Sharif aa sakte hain.</li>
            </ul>
        </div>
    </div>

</div>
@endsection