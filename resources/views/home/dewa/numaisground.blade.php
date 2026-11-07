@extends('home.includes.master')
@section('content')
<div class="container" style="padding: 45px 15px;">
    
    <!-- Title Header -->
    <div class="maroon" style="text-align: center; margin-bottom: 35px;">
        <span style="background: #e8a824; color: #111; font-weight: 800; font-size: 12px; text-transform: uppercase; padding: 5px 16px; border-radius: 20px; letter-spacing: 1px;">
            Exhibition & Cultural Hub
        </span>
        <h1 style="color: #0b4625; font-size: 32px; font-weight: 900; margin-top: 12px;">
            *** Numais Ground ***
        </h1>
        <div style="width: 70px; height: 3px; background: #03be64; margin: 12px auto; border-radius: 2px;"></div>
    </div>

    <div class="row" style="display: flex; flex-wrap: wrap; align-items: flex-start;">
        <div class="col-sm-8" style="font-size: 16px; line-height: 1.85; color: #2c2c2c;">
            <p>
                <i><b>The Numais Ground</b></i> at <b>Dewa Sharif</b> is a central venue for cultural and social activities during the annual Dewa Mela, held in Barabanki, Uttar Pradesh. Located near the <b>Dewa Sharif</b> shrine, this ground becomes a bustling hub during the Mela, drawing thousands of visitors from across the region.
            </p>

            <h3 style="color: #0b4625; font-weight: 800; font-size: 20px; margin-top: 25px; margin-bottom: 12px;">
                Key Aspects
            </h3>
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Exhibition and Trade Fair
            </h4>
            <p>
                The Numais (exhibition) showcases a variety of products, including traditional crafts, handicrafts, garments, and regional specialties. Artisans and traders set up stalls, offering items like pottery, textiles, and locally-made goods, making it a vital platform for preserving local arts and crafts.
            </p>
        </div>

        <div class="col-sm-4 text-center" style="margin-bottom: 20px;">
            <div style="padding: 6px; background: #fff; border: 2px solid #03be64; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <img src="{{asset('home/images/dewasharif/dewapage/numaisground.jpg')}}" alt="Numais Ground Dewa Sharif" title="Numais Ground Dewa Mela" style="width: 100%; border-radius: 8px; display: block;">
                <span style="display: block; font-size: 13px; font-weight: 700; color: #0b4625; margin-top: 8px;">Numais Ground Dewa Sharif</span>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px; font-size: 16px; line-height: 1.85; color: #2c2c2c;">
        <div class="col-sm-12">
            
            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 15px; margin-bottom: 8px;">
                Amusement and Entertainment
            </h4>
            <p>
                The ground is filled with amusement rides such as Ferris wheels and merry-go-rounds, as well as games and attractions for families and children. This festive atmosphere makes it a lively place for visitors of all ages.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Cultural Performances
            </h4>
            <p>
                The Numais Ground also hosts cultural events, including folk music, dance performances, and traditional dramas, providing a space to celebrate regional heritage and Sufi traditions.
            </p>

            <h4 style="color: #1b5e20; font-weight: 700; font-size: 17px; margin-top: 20px; margin-bottom: 8px;">
                Community Gathering
            </h4>
            <p>
                Beyond the entertainment, the ground serves as a place for people to come together, fostering a sense of unity and shared experience among attendees, reflecting the inclusive spirit of the Dewa Mela.
            </p>
            <p>
                The Numais Ground is a vibrant mix of spirituality, culture, and celebration, offering a unique glimpse into the rich heritage of <b>Dewa Sharif</b> and the teachings of Hazrat Haji Waris Ali Shah.
            </p>

        </div>
    </div>

</div>
@endsection