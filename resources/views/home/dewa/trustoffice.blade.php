@extends('home.includes.master')
@section('content')
<div class="container" style="padding: 45px 15px;">
    
    <!-- Title Header -->
    <div class="maroon" style="text-align: center; margin-bottom: 35px;">
        <span style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; letter-spacing: 1px;">
            Administration & Management
        </span>
        <h1 style="color: #0b4625; font-size: 32px; font-weight: 900; margin-top: 12px;">
            *** Dargah Mausoleum Trust ***
        </h1>
        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;"></div>
    </div>

    <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start;">
        <div class="col-sm-8" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">
            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 0; margin-bottom: 12px;">
                Dewa Sharif Dargah Mausoleum Trust: Overview and Role
            </h3>
            <p>
                The Dewa Sharif <i>Dargah Mausoleum Trust</i> manages and oversees the operations, maintenance, and activities associated with the Dargah of Hazrat Haji Waris Ali Shah, located in <i>Dewa Sharif</i>, Barabanki, Uttar Pradesh. The Trust plays a crucial role in preserving the spiritual heritage and traditions of the Dargah, while also ensuring the welfare of the thousands of visitors and devotees who come to pay their respects.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Key Responsibilities and Functions
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Management of the Dargah Complex
            </h4>
            <p>
                The Trust is responsible for the upkeep and maintenance of the Dargah, including the shrine (Mazar) of Hazrat Haji Waris Ali Shah, the mosque, the Wazu Khana (ablution area), and other facilities within the Dargah complex. This involves ensuring the cleanliness, safety, and accessibility of the premises, so that devotees can visit and worship in a serene and respectful environment.
            </p>
        </div>

        <div class="col-sm-4 text-center" style="margin-bottom: 20px;">
            <div style="padding: 6px; background: #fff; border: 2px solid #03be64; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <img src="{{asset('home/images/dewasharif/dewapage/office.jpg')}}" alt="Dargah Mausoleum Trust Office" title="Dewa Sharif Trust Office" style="width: 100%; border-radius: 8px; display: block;">
                <span style="display: block; font-size: 13px; font-weight: 700; color: #0b4625; margin-top: 8px;">Dargah Trust Office</span>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px; font-size: 16px; line-height: 1.85; color: #2c2c2c;">
        <div class="col-sm-12">
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Organizing Annual Events
            </h4>
            <p>
                One of the most significant activities overseen by the Trust is the organization of the annual Urs (death anniversary) of Hazrat Haji Waris Ali Shah. The Urs is a major event that attracts thousands of pilgrims from different parts of India and beyond. The Trust manages arrangements for the Urs celebration, including the setup of accommodation for visitors, food distribution (langar), and spiritual events such as sama (Qawwali sessions) and zikr gatherings.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Charitable Activities and Langarkhana
            </h4>
            <p>
                The Trust is involved in charitable activities, including the operation of the Langarkhana, where free meals are provided to devotees and visitors. This is in line with the teachings of Hazrat Haji Waris Ali Shah, emphasizing compassion, service, and the importance of helping those in need. The Langar is particularly active during the Urs, where the Trust ensures that no visitor goes hungry, providing meals as an expression of the Dargah's inclusive and hospitable spirit.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Preserving Sufi Heritage and Teachings
            </h4>
            <p>
                The Trust is dedicated to preserving and promoting the spiritual teachings of Hazrat Haji Waris Ali Shah, who was a renowned Sufi saint known for his message of love, peace, and unity among all people. They facilitate spiritual gatherings, lectures, and Qawwali performances that reflect the values of Sufism and the saint's legacy. This helps maintain the rich cultural and religious traditions that have been associated with <i>Dewa Sharif</i> for generations.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Maintenance of Records and Legal Affairs
            </h4>
            <p>
                The Trust manages the legal and administrative aspects of the Dargah, including maintaining records of donations, managing property associated with the shrine, and ensuring compliance with legal regulations governing religious and charitable institutions. This involves coordinating with local authorities and stakeholders to ensure that the operations of the Dargah run smoothly and continue to serve the community effectively.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Role in Community and Visitor Services
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Facilitating Pilgrims and Devotees
            </h4>
            <p>
                The Trust provides facilities for the large number of pilgrims who visit <i>Dewa Sharif</i> throughout the year. This includes managing accommodation, ensuring access to clean water, and maintaining spaces for prayer and reflection. During events like the Urs, the Trust also sets up temporary shelters and organizes medical camps to assist visitors.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Community Engagement and Social Harmony
            </h4>
            <p>
                Reflecting the inclusive nature of Sufi teachings, the Trust plays a role in fostering social harmony and unity in the local community. The Dargah has historically been a space where people of different faiths come together, and the Trust upholds this tradition. The Dargah is open to people from all backgrounds, emphasizing the values of mutual respect and tolerance, which are central to the teachings of Hazrat Haji Waris Ali Shah.
            </p>
            <p>
                <i><b>The Dewa Sharif Dargah Mausoleum Trust</b></i> is central to the spiritual life of the Dargah and the local community, managing the sacred space and its activities with a commitment to service, tradition, and the preservation of the Sufi ethos. Through its work, the Trust ensures that the legacy of Hazrat Haji Waris Ali Shah continues to inspire and offer solace to all who visit the shrine.
            </p>

        </div>
    </div>

</div>
@endsection