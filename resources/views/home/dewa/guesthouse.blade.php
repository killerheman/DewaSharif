@extends('home.includes.master')
@section('content')
<div class="container">
    <div class="maroon"> <h1>*** Guest House & Hotels ***</h1></div>
    <div class="row">
        <div class="col-sm-8">
            <p>
                Dewa Sharif, known for the dargah of Hazrat Haji Waris Ali Shah, has several <i><b>Guest Houses</b></i>
                to accommodate pilgrims and tourists. These include:

                <i>
                    <h5>Dargah-Managed Dargah-Rooms:</h5>
                </i> Dargah-Rooms managed by the dargah administration, close to the shrine for
                easy access to spiritual activities.

                <i>
                    <h5>Private Lodges:</h5>
                </i> Privately run guest houses offer a range of basic to comfortable rooms at reasonable rates.

                <i>
                    <h5>Nearby Hotels:</h5>
                </i> In Barabanki city, close to Dewa Sharif, visitors can find hotels with more modern amenities.

                These guest houses focus on providing a peaceful, spiritual environment for visitors at affordable
                prices.
            </p>

        </div>
        <div class="col-sm-4">
            <img src="{{asset('home/images/dewasharif/dewapage/hotels.jpg')}}" alt="">
        </div>
    </div>

</div>

@endsection
