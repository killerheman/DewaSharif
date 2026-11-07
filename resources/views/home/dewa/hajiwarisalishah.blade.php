@extends('home.includes.master')
@section('content')
<div class="container" style="padding: 45px 15px;">
    
    <!-- Title Header -->
    <div class="maroon" style="text-align: center; margin-bottom: 35px;">
        <span style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; letter-spacing: 1px;">
            Sufi Saint of Dewa Sharif
        </span>
        <h1 style="color: #0b4625; font-size: 32px; font-weight: 900; margin-top: 12px;">
            Hazrat Haji Waris Ali Shah (R.A.)
        </h1>
        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;"></div>
    </div>

    <!-- Top Section (Content & Image) -->
    <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start;">
        <div class="col-sm-8" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">
            
            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 0; margin-bottom: 12px;">
                Birth and Early Life
            </h3>
            <p style="margin-bottom: 20px;">
                Haji Waris Ali Shah was born in 1817 (1234 Hijri) in Dewa Sharif, a town in the Barabanki district of Uttar Pradesh, India. He belonged to a well-respected family of Sufi mystics. His father, <b>Qurban Ali Shah</b>, passed away when Waris Ali Shah was just a child, leaving him to be raised by his grandmother. From an early age, he displayed signs of deep spirituality and was known for his piety and inclination towards religious study and meditation. His family traced their lineage back to the <b>Prophet Muhammad</b>, which added to the spiritual reverence people had for him in later years.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Spiritual Journey and Teachings
            </h3>
            <p style="margin-bottom: 20px;">
                <b>Haji Waris Ali Shah</b> became a disciple of his maternal uncle, Khadim Ali Shah, who initiated him into the Sufi path. He engaged in intense meditation and ascetic practices, spending many years in contemplation and spiritual exercises. His Sufi order is known as the <b>"Warisiyya"</b>, a branch of the Qadiri-Razavi order, which emphasizes a deep connection with God, the importance of love for all of humanity, and the inner purification of the soul. His teachings revolved around universal love, compassion, and unity among people of all religions and backgrounds. He taught that all humans, regardless of their caste, creed, or religion, are the creation of one God and should be treated with love and respect. He was known to preach tolerance and stressed the idea that spirituality transcends formal religious boundaries. His message attracted followers from various communities, including Muslims, Hindus, Sikhs, and others, who were drawn to his simplicity and spiritual wisdom.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Pilgrimages and Travels
            </h3>
            <p style="margin-bottom: 20px;">
                <b>Haji Waris Ali Shah</b> performed the Hajj pilgrimage to Mecca several times, starting at a young age, which earned him the title "Haji" (pilgrim). It is said that he undertook the pilgrimage barefoot, a testament to his humility and devotion. During his lifetime, he traveled extensively, spreading his message of love and unity. His journeys took him across India and beyond, including visits to places like Afghanistan, Iraq, and the Arabian Peninsula. Wherever he traveled, people were drawn to him due to his profound spiritual presence and his ability to connect with others. His followers, known as murids, would often accompany him, helping spread his teachings far and wide.
            </p>

        </div>

        <!-- Sidebar Image -->
        <div class="col-sm-4 text-center" style="margin-bottom: 20px;">
            <div style="padding: 6px; background: #fff; border: 2px solid #03be64; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <img src="{{asset('home/images/dewasharif/dewapage/hajisahab.jpg')}}" alt="Hazrat Haji Waris Ali Shah" title="Hazrat Haji Waris Ali Shah" style="width: 100%; border-radius: 8px; display: block;">
                <span style="display: block; font-size: 13px; font-weight: 700; color: #0b4625; margin-top: 8px;">Hazrat Haji Waris Ali Shah (R.A.)</span>
            </div>
        </div>
    </div>

    <!-- Ziyarat Timings Box -->
    <div class="row" style="margin-top: 20px;">
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

    <!-- Bottom Full Width Sections -->
    <div class="row" style="margin-top: 30px;">
        <div class="col-sm-12" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Establishment of Dewa Sharif as a Spiritual Center
            </h3>
            <p style="margin-bottom: 20px;">
                Upon returning from his travels, Haji Waris Ali Shah made <b>Dewa Sharif</b> his permanent home and established it as a center of spiritual learning and practice. The town gradually became a site of pilgrimage for those seeking spiritual guidance and blessings. The shrine (dargah) of Haji Waris Ali Shah, known as "Dargah-e-Ala Hazrat" or "Astana-e-Waris," became a place where people of all faiths would come to receive his blessings. His simple lifestyle and message of love created an atmosphere of peace and spiritual richness at the dargah. Haji Waris Ali Shah’s presence transformed <b>Dewa Sharif</b> into a hub for Sufi culture, where qawwali (Sufi devotional music), poetry, and spiritual gatherings became a regular part of life.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Writings and Literary Contributions
            </h3>
            <p style="margin-bottom: 20px;">
                Although much of his teachings were transmitted orally through his disciples, Haji Waris Ali Shah's thoughts and philosophy have been documented in books and malfuzat (records of his sayings) by his followers. His words often reflected a deep understanding of Sufi metaphysics, human psychology, and the essence of spirituality, emphasizing the importance of ishq-e-haqiqi (true love for God) and the renunciation of worldly desires.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Passing and Legacy
            </h3>
            <p style="margin-bottom: 20px;">
                <b>Haji Waris Ali Shah</b> passed away on April 7, 1905 (1323 Hijri) in <b>Dewa Sharif</b>, where he was buried near his ancestral home. His shrine became a major center of Sufi devotion, visited by thousands of devotees annually. After his death, the annual Urs (death anniversary) of Haji Waris Ali Shah became a significant event in <b>Dewa Sharif</b>. The Urs is marked by spiritual gatherings, qawwali performances, and prayers, attracting people from across India and abroad. Today, the legacy of <b>Haji Waris Ali Shah</b> lives on through the numerous followers of the Warisiyya order, who continue to uphold his teachings of love, tolerance, and compassion. His message has inspired many Sufi scholars and spiritual seekers, contributing to the spread of Sufi values in India and beyond.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Teachings and Influence
            </h3>
            <ul style="margin-bottom: 20px; padding-left: 20px;">
                <li style="margin-bottom: 10px;"><b>Universal Brotherhood:</b> He emphasized the need for unity and brotherhood among all humans. He often said, "God has created all of us, and we must live like brothers."</li>
                <li style="margin-bottom: 10px;"><b>Simplicity and Humility:</b> Haji Waris Ali Shah lived a life of simplicity and humility, wearing plain clothes and avoiding ostentation. He believed that true spirituality required detachment from material wealth.</li>
                <li style="margin-bottom: 10px;"><b>Spiritual Equality:</b> He treated everyone equally, regardless of social status, and preached that the path to God is open to all, regardless of background or religion.</li>
                <li style="margin-bottom: 10px;"><b>Service to Humanity:</b> He encouraged his followers to serve humanity as a form of devotion to God. Acts of kindness, feeding the poor, and helping those in need were central to his teachings.</li>
            </ul>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Impact on Indian Sufism
            </h3>
            <p style="margin-bottom: 20px;">
                Haji Waris Ali Shah’s influence on Sufism in India is profound, particularly in the region of Uttar Pradesh. His teachings continue to resonate with those who seek a path of spirituality that is inclusive and rooted in love. His emphasis on the universality of God's message and his ability to bridge gaps between different religious communities made him a pivotal figure in promoting religious harmony. The Dargah of Haji Waris Ali Shah in <b>Dewa Sharif</b> remains a place where people from all walks of life come to seek blessings and guidance, making it a living symbol of his enduring legacy. Haji Waris Ali Shah's life and teachings offer a timeless message of love, humility, and spiritual unity. His legacy as a Sufi saint continues to inspire people to seek a deeper connection with the divine, transcending barriers of caste, creed, and religion. <b>Dewa Sharif</b>, with his dargah at its heart, remains a beacon of the Sufi tradition, attracting those who are drawn to the path of peace and love that he so beautifully embodied.
            </p>

        </div>
    </div>

</div>
@endsection