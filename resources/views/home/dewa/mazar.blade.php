@extends('home.includes.master')
@section('content')
<div class="container" style="padding: 45px 15px;">
    
    <!-- Title Header -->
    <div class="maroon" style="text-align: center; margin-bottom: 35px;">
        <span style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; letter-spacing: 1px;">
            Sacred Architecture & Shrine
        </span>
        <h1 style="color: #0b4625; font-size: 32px; font-weight: 900; margin-top: 12px;">
            *** Mazaar [Hazrat Waris Ali Shah (R.A.)] ***
        </h1>
        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;"></div>
    </div>

    <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start;">
        <div class="col-sm-8" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">
            <p>
                The Mazar (shrine) of <i><b>Hazrat Haji Waris Ali Shah</b></i> at <b>Dewa Sharif</b> is a significant site both spiritually and architecturally. Its design reflects a blend of Indo-Islamic architecture, offering a serene and sacred space for visitors. Here’s a detailed description of the Mazar’s structure:
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                1. Main Tomb (Maqbara)
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Central Dome
            </h4>
            <p>
                The heart of the shrine is its large, impressive dome, symbolizing the spiritual significance of the Mazar. The dome is intricately decorated with floral and geometric motifs, common in Islamic architecture. It is coated in a white finish, which adds to its serene and peaceful appearance. The dome is elevated on a drum-like base, creating a sense of height and grandeur, making it a visible landmark in the Dewa Sharif complex.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Tomb Chamber
            </h4>
            <p>
                The chamber holds the grave of Hazrat Haji Waris Ali Shah, covered with ornate chadars (embroidered cloths) offered by devotees. The grave is surrounded by a marble enclosure, featuring intricate carvings. Inside the chamber, the atmosphere is calm and reverent, with the scent of flowers and incense creating a spiritual ambiance. The inner walls are adorned with verses from the Quran, emphasizing the sacred nature of the space.
            </p>
        </div>

        <div class="col-sm-4 text-center" style="margin-bottom: 20px;">
            <div style="padding: 6px; background: #fff; border: 2px solid #03be64; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <img src="{{asset('home/images/dewasharif/dewapage/mazar.jpg')}}" alt="Mazar Hazrat Waris Ali Shah" title="Mazar Hazrat Waris Ali Shah" style="width: 100%; border-radius: 8px; display: block;">
                <span style="display: block; font-size: 13px; font-weight: 700; color: #0b4625; margin-top: 8px;">Mazar Mubarak Dewa Sharif</span>
            </div>
        </div>
    </div>

    <!-- Ziyarat Timings Box -->
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12" style="background: linear-gradient(135deg, #fdfbf7 0%, #f4eee1 100%); padding: 30px; border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">
            <h3 style="color: #0b4625; font-weight: 900; font-size: 22px; margin-top: 0; margin-bottom: 10px; text-align: center;">
                ✨ Dargah Sharif Ziyarat Timings (Aane Ka Samay) ✨
            </h3>
            <p style="text-align: center; color: #555; font-size: 15px; margin-bottom: 25px;">
                Zaireen (Visitors) ke liye Mazar-e-Mubarak par haziri aur ziyarat ka nirdharit samay:
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
                2. Entrance and Courtyard
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Main Gateway (Darwaza)
            </h4>
            <p>
                The entrance to the Mazar is through a grand gateway, reflecting the blend of Mughal and Indian architectural styles. The gateway is decorated with traditional arch designs, detailed carvings, and inscriptions. The entrance is flanked by two small minaret-like structures, adding to the verticality and prominence of the structure.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Courtyard
            </h4>
            <p>
                After entering the gateway, one steps into a large courtyard, which serves as a gathering place for pilgrims, especially during Urs and other festivals. The courtyard is paved with stone and marble, offering a clean space for prayer and meditation. The courtyard is often bustling with activity, where devotees gather to recite prayers, participate in qawwali sessions, or offer nazrana (offerings).
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                3. Exterior and Decoration
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Marble Work
            </h4>
            <p>
                The Mazar’s exterior is adorned with white marble, which gives it a bright and serene appearance. The marble surface is engraved with floral patterns and calligraphy, showcasing the artistry of the time. The smooth marble not only enhances the shrine's beauty but also provides a cooling effect, making it a comfortable space for visitors during hot days.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Arches and Jaali Work
            </h4>
            <p>
                The Mazar features several arched windows and doorways, reflecting traditional Islamic design. These arches are supported by columns, adding a sense of rhythm and structure to the building. Some windows are decorated with jaali work (intricately carved stone screens), which allows light to filter through while maintaining privacy and a sense of sacredness within the shrine.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                4. Spiritual Symbolism
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Minarets and Dome
            </h4>
            <p>
                The dome and minaret-like features represent spiritual ascension, symbolizing the connection between the earthly and divine realms. This is a common theme in Sufi architecture, where the structure of the building is designed to inspire spiritual reflection.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Interior Ambiance
            </h4>
            <p>
                The interior of the Mazar is a place of tranquility, with soft lighting and the scent of incense creating a peaceful atmosphere. Devotees often gather here to recite duas (prayers) and seek blessings.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                5. Annual Gatherings
            </h3>
            <p>
                The Mazar becomes the center of attention during the Urs of Hazrat Haji Waris Ali Shah, his death anniversary, which is celebrated with much devotion. Pilgrims from various parts of India and beyond visit the Mazar to pay their respects and participate in the spiritual gatherings. During these times, the Mazar and its courtyard are beautifully decorated with lights, and the entire area takes on a festive yet deeply spiritual atmosphere, reflecting the legacy of Hazrat Haji Waris Ali Shah and his message of love and unity.
            </p>
            <p>
                The Mazar of <b>Dewa Sharif</b> stands not only as a religious monument but also as a symbol of Sufi culture, offering a space where spiritual seekers can connect with the teachings of love, peace, and universal brotherhood. Its architecture, with its detailed carvings and serene ambiance, embodies the spirit of Sufism that Hazrat Haji Waris Ali Shah spread throughout his life.
            </p>

        </div>
    </div>

</div>
@endsection@extends('home.includes.master')
@section('content')
<div class="container" style="padding: 45px 15px;">
    
    <!-- Title Header -->
    <div class="maroon" style="text-align: center; margin-bottom: 35px;">
        <span style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; letter-spacing: 1px;">
            Sacred Architecture & Shrine
        </span>
        <h1 style="color: #0b4625; font-size: 32px; font-weight: 900; margin-top: 12px;">
            *** Mazaar [Hazrat Waris Ali Shah (R.A.)] ***
        </h1>
        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;"></div>
    </div>

    <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start;">
        <div class="col-sm-8" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">
            <p>
                The Mazar (shrine) of <i><b>Hazrat Haji Waris Ali Shah</b></i> at <b>Dewa Sharif</b> is a significant site both spiritually and architecturally. Its design reflects a blend of Indo-Islamic architecture, offering a serene and sacred space for visitors. Here’s a detailed description of the Mazar’s structure:
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                1. Main Tomb (Maqbara)
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Central Dome
            </h4>
            <p>
                The heart of the shrine is its large, impressive dome, symbolizing the spiritual significance of the Mazar. The dome is intricately decorated with floral and geometric motifs, common in Islamic architecture. It is coated in a white finish, which adds to its serene and peaceful appearance. The dome is elevated on a drum-like base, creating a sense of height and grandeur, making it a visible landmark in the Dewa Sharif complex.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Tomb Chamber
            </h4>
            <p>
                The chamber holds the grave of Hazrat Haji Waris Ali Shah, covered with ornate chadars (embroidered cloths) offered by devotees. The grave is surrounded by a marble enclosure, featuring intricate carvings. Inside the chamber, the atmosphere is calm and reverent, with the scent of flowers and incense creating a spiritual ambiance. The inner walls are adorned with verses from the Quran, emphasizing the sacred nature of the space.
            </p>
        </div>

        <div class="col-sm-4 text-center" style="margin-bottom: 20px;">
            <div style="padding: 6px; background: #fff; border: 2px solid #03be64; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <img src="{{asset('home/images/dewasharif/dewapage/mazar.jpg')}}" alt="Mazar Hazrat Waris Ali Shah" title="Mazar Hazrat Waris Ali Shah" style="width: 100%; border-radius: 8px; display: block;">
                <span style="display: block; font-size: 13px; font-weight: 700; color: #0b4625; margin-top: 8px;">Mazar Mubarak Dewa Sharif</span>
            </div>
        </div>
    </div>

    <!-- Ziyarat Timings Box -->
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12" style="background: linear-gradient(135deg, #fdfbf7 0%, #f4eee1 100%); padding: 30px; border-radius: 14px; border: 2px solid #d4af37; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">
            <h3 style="color: #0b4625; font-weight: 900; font-size: 22px; margin-top: 0; margin-bottom: 10px; text-align: center;">
                ✨ Dargah Sharif Ziyarat Timings (Aane Ka Samay) ✨
            </h3>
            <p style="text-align: center; color: #555; font-size: 15px; margin-bottom: 25px;">
                Zaireen (Visitors) ke liye Mazar-e-Mubarak par haziri aur ziyarat ka nirdharit samay:
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
                2. Entrance and Courtyard
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Main Gateway (Darwaza)
            </h4>
            <p>
                The entrance to the Mazar is through a grand gateway, reflecting the blend of Mughal and Indian architectural styles. The gateway is decorated with traditional arch designs, detailed carvings, and inscriptions. The entrance is flanked by two small minaret-like structures, adding to the verticality and prominence of the structure.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Courtyard
            </h4>
            <p>
                After entering the gateway, one steps into a large courtyard, which serves as a gathering place for pilgrims, especially during Urs and other festivals. The courtyard is paved with stone and marble, offering a clean space for prayer and meditation. The courtyard is often bustling with activity, where devotees gather to recite prayers, participate in qawwali sessions, or offer nazrana (offerings).
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                3. Exterior and Decoration
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Marble Work
            </h4>
            <p>
                The Mazar’s exterior is adorned with white marble, which gives it a bright and serene appearance. The marble surface is engraved with floral patterns and calligraphy, showcasing the artistry of the time. The smooth marble not only enhances the shrine's beauty but also provides a cooling effect, making it a comfortable space for visitors during hot days.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Arches and Jaali Work
            </h4>
            <p>
                The Mazar features several arched windows and doorways, reflecting traditional Islamic design. These arches are supported by columns, adding a sense of rhythm and structure to the building. Some windows are decorated with jaali work (intricately carved stone screens), which allows light to filter through while maintaining privacy and a sense of sacredness within the shrine.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                4. Spiritual Symbolism
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Minarets and Dome
            </h4>
            <p>
                The dome and minaret-like features represent spiritual ascension, symbolizing the connection between the earthly and divine realms. This is a common theme in Sufi architecture, where the structure of the building is designed to inspire spiritual reflection.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Interior Ambiance
            </h4>
            <p>
                The interior of the Mazar is a place of tranquility, with soft lighting and the scent of incense creating a peaceful atmosphere. Devotees often gather here to recite duas (prayers) and seek blessings.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                5. Annual Gatherings
            </h3>
            <p>
                The Mazar becomes the center of attention during the Urs of Hazrat Haji Waris Ali Shah, his death anniversary, which is celebrated with much devotion. Pilgrims from various parts of India and beyond visit the Mazar to pay their respects and participate in the spiritual gatherings. During these times, the Mazar and its courtyard are beautifully decorated with lights, and the entire area takes on a festive yet deeply spiritual atmosphere, reflecting the legacy of Hazrat Haji Waris Ali Shah and his message of love and unity.
            </p>
            <p>
                The Mazar of <b>Dewa Sharif</b> stands not only as a religious monument but also as a symbol of Sufi culture, offering a space where spiritual seekers can connect with the teachings of love, peace, and universal brotherhood. Its architecture, with its detailed carvings and serene ambiance, embodies the spirit of Sufism that Hazrat Haji Waris Ali Shah spread throughout his life.
            </p>

        </div>
    </div>

</div>
@endsection