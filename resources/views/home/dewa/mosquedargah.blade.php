@extends('home.includes.master')
@section('content')
<div class="container" style="padding: 45px 15px;">
    
    <!-- Title Header -->
    <div class="maroon" style="text-align: center; margin-bottom: 35px;">
        <span style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; letter-spacing: 1px;">
            Spiritual Place of Worship
        </span>
        <h1 style="color: #0b4625; font-size: 32px; font-weight: 900; margin-top: 12px;">
            *** Masjid-Al-Waris [Mosque] ***
        </h1>
        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;"></div>
    </div>

    <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start;">
        <div class="col-sm-8" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">
            <p>
                <i><b>The mosque [Masjid]</b></i> at <b>Dewa Sharif Dargah</b> is an integral part of the spiritual complex dedicated to Hazrat Haji Waris Ali Shah. Situated in the town of Dewa, Barabanki district, Uttar Pradesh, the mosque is not only a place of worship but also a center for spiritual gatherings and community prayers. Here’s a detailed look at the mosque and its significance within the Dargah complex:
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                1. Architectural Design
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Traditional Indo-Islamic Style
            </h4>
            <p>
                The mosque at the <b>Dewa Sharif Dargah</b> is built in a traditional Indo-Islamic style, featuring a blend of Mughal and regional architectural influences. Its design emphasizes simplicity, serenity, and the spiritual ambiance fitting for a place of worship. The structure is adorned with arches, domes, and intricate carvings that are typical of Islamic architecture. These elements not only add to the beauty of the mosque but also represent the spiritual essence of Islam.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Domes and Minarets
            </h4>
            <p>
                The mosque is crowned with a central dome, a characteristic feature of many Islamic places of worship. The dome symbolizes the heavens and the connection between the divine and the earthly realms. Minarets flank the mosque’s structure, adding height and grandeur to the building. They are traditionally used for the adhan (call to prayer), which invites worshippers to gather for prayer.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Interior Space
            </h4>
            <p>
                Inside, the mosque is spacious and designed to accommodate a large number of worshippers, especially during prayer times and special occasions like Fridays and the annual Urs (death anniversary) of Hazrat Haji Waris Ali Shah. The prayer hall is decorated with Quranic inscriptions, which are meticulously engraved on the walls. The simple yet elegant interior allows devotees to focus on their prayers and spiritual connection.
            </p>
        </div>

        <div class="col-sm-4 text-center" style="margin-bottom: 20px;">
            <div style="padding: 6px; background: #fff; border: 2px solid #03be64; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <img src="{{asset('home/images/dewasharif/dewapage/masjid.jpg')}}" alt="Masjid Al Waris Dewa Sharif" title="Masjid Al Waris" style="width: 100%; border-radius: 8px; display: block;">
                <span style="display: block; font-size: 13px; font-weight: 700; color: #0b4625; margin-top: 8px;">Masjid-Al-Waris Dewa Sharif</span>
            </div>
        </div>
    </div>

    <!-- Namaz Timings & Schedule Guidelines Box (Above) -->
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12" style="background: linear-gradient(135deg, #fdfbf7 0%, #f4eee1 100%); padding: 30px; border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">
            <h3 style="color: #0b4625; font-weight: 900; font-size: 22px; margin-top: 0; margin-bottom: 10px; text-align: center;">
                🕌 Namaz & Prayer Schedule Guidelines 🕌
            </h3>
            <p style="text-align: center; color: #555; font-size: 15px; margin-bottom: 20px;">
                Masjid-Al-Waris mein panchtana namaz aur ibadat se judi zaroori jankari:
            </p>
            
            <div style="background: #ffffff; padding: 20px 25px; border-radius: 10px; border-left: 5px solid #1b5e20; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                <p style="margin: 0 0 12px 0; color: #333; font-size: 15px; line-height: 1.7;">
                    1. <strong>Daily Prayers (Panchtana Namaz):</strong> Panchon waqt ki namazen (Fajr, Dhuhr, Asr, Maghrib, aur Isha) rozaana Ada ki jati hain. Suraj ke nikalne aur dhalne (solar movement) ke mutabiq namaz ke auqaat har roz thode-thode badalte rehte hain, isliye zaireen se guzarish hai ki wo azaan ki awaz ya local schedule ke hisaab se namaz ada karein.
                </p>
                <p style="margin: 0; color: #333; font-size: 15px; line-height: 1.7;">
                    2. <strong>Jumu'ah (Friday) Prayers:</strong> Har jumah ke din Masjid-al-Waris me kaseer ta'adad me log ikattha hokar namaze juma ada karte. Iski timings is tarah rehti hain: <strong>12:30 PM par Azaan</strong>, <strong>12:45 PM par Bayaan (بیان)</strong>, <strong>1:00 PM par Khutba</strong>, aur <strong>1:10 PM par Namaz-e-Jumu'ah</strong> ada ki jati hai.
                </p>
            </div>
        </div>
    </div>

    <!-- Dargah Sharif Ziyarat Timings Box (Below) -->
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12" style="background: linear-gradient(135deg, #fdfbf7 0%, #f4eee1 100%); padding: 30px; border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">
            <h3 style="color: #0b4625; font-weight: 900; font-size: 22px; margin-top: 0; margin-bottom: 10px; text-align: center;">
                ✨ Dargah Sharif Ziyarat Timings (Aane Ka Samay) ✨
            </h3>
            <p style="text-align: center; color: #555; font-size: 15px; margin-bottom: 25px;">
                Zaireen (Visitors) ke liye Dargah Sharif ke khulne aur ziyarat karne ka samay seasonal nirdharit hai:
            </p>
            
            <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                <!-- Winter Timing -->
                <div style="flex: 1; min-width: 280px; max-width: 450px; background: #ffffff; padding: 20px 25px; border-radius: 10px; border-top: 5px solid #1b5e20; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                    <h4 style="color: #1b5e20; font-weight: 800; font-size: 18px; margin-top: 0;">❄️ Winter (Sardi ke Din)</h4>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">Morning <strong>(Subah)</strong>: 5:00 AM to 12:00 PM</p>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">After-Noon <strong>(Dopahar)</strong>: 2:00 PM to 9:00 PM</p>
                </div>
                
                <!-- Summer Timing -->
                <div style="flex: 1; min-width: 280px; max-width: 450px; background: #ffffff; padding: 20px 25px; border-radius: 10px; border-top: 5px solid #d97706; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                    <h4 style="color: #b45309; font-weight: 800; font-size: 18px; margin-top: 0;">☀️ Summer (Garmi ke Din)</h4>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">Morning <strong>(Subah)</strong>: 4:00 AM to 12:00 PM</p>
                    <p style="margin: 8px 0; color: #333; font-size: 15px;">After-Noon <strong>(Dopahar)</strong>: 2:00 PM to 10:00 PM</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px; font-size: 16px; line-height: 1.85; color: #2c2c2c;">
        <div class="col-sm-12">

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                2. Spiritual Role and Activities
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Daily Prayers
            </h4>
            <p>
                The mosque serves as a place for <b>daily prayers (salah)</b>, where local residents and visitors to the Dargah come together to perform their religious duties. The mosque remains open throughout the day for anyone who wishes to pray.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                During Urs and Festivals
            </h4>
            <p>
                During the annual Urs of Hazrat Haji Waris Ali Shah, the mosque plays a central role in the spiritual activities of the Dargah. Special prayers and recitations are conducted, with thousands of devotees participating in collective worship. It becomes particularly vibrant during <i><b>Friday prayers (Jumu'ah)</b></i>, when a larger congregation gathers, listening to sermons and engaging in communal worship.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Spiritual Gatherings and Dua Sessions
            </h4>
            <p>
                The mosque at <b>Dewa Sharif Dargah</b> is not only a place for regular prayers but also hosts dua (supplication) sessions and majlis (gatherings) where devotees recite naats (poems in praise of the Prophet) and engage in spiritual discourse. These gatherings emphasize the teachings of Sufism, including love, peace, and the remembrance of God, aligning with the legacy of Hazrat Haji Waris Ali Shah.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                3. Community Services
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Educational Role
            </h4>
            <p>
                The mosque often serves as a center for Islamic education, where local scholars impart teachings from the Quran and Hadith. It plays an important role in the religious education of the community, particularly for children. During the Mela, special sessions are held to educate visitors about the life and teachings of Hazrat Haji Waris Ali Shah, emphasizing his message of universal brotherhood and love for humanity.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Charity and Langar (Community Kitchen)
            </h4>
            <p>
                Reflecting the values of Sufism, the mosque, alongside the Dargah’s langarkhana (community kitchen), serves as a place where charitable activities take place. Free meals are provided to visitors and the needy, following the tradition of hospitality and care that Hazrat Haji Waris Ali Shah emphasized. The mosque’s connection to the community extends beyond spiritual needs, serving as a place where social welfare activities are conducted.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                4. Architectural and Spiritual Symbolism
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Symbol of Unity
            </h4>
            <p>
                The mosque, being part of the Dargah complex, stands as a symbol of unity and inclusiveness. It embodies the teachings of Sufism, welcoming people from all walks of life, irrespective of their background. Visitors from various faiths often come to the mosque to seek peace and solace, reflecting the open and embracing nature of the <b>Dewa Sharif Dargah</b>.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Architectural Harmony with the Dargah
            </h4>
            <p>
                The mosque’s design complements the architecture of the nearby Mazar (shrine) of Hazrat Haji Waris Ali Shah, creating a harmonious spiritual environment. The close proximity of the mosque to the Mazar allows devotees to seamlessly transition between the spaces of prayer and reverence for the saint.
            </p>
            <p>
                The mosque at <b>Dewa Sharif Dargah</b> is more than just a place of worship; it is a living representation of the spiritual and social values that Hazrat Haji Waris Ali Shah preached. Its architecture and role within the Dargah complex reflect the integration of devotion, community service, and the Sufi tradition of embracing all humanity with love and compassion.
            </p>

        </div>
    </div>

</div>
@endsection