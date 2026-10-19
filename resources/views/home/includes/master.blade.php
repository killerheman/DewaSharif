<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.includes.head')

    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" href="{{ asset('home/images/dewasharif/dewalogos.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('home/images/dewasharif/dewalogos.png') }}">

    @yield('head-area')
</head>

<body class="homebody">

    {{-- Top Alert Notification Bar: Yeh SIRF Main Website par dikhega, Hotels/Cabs/Shops par nahi --}}
    <!-- @if(!Request::is('hotels*') && !Request::is('cabs*') && !Request::is('shops*'))
        <div
            style="background: #0b5e36; color: #ffffff; padding: 10px 15px; text-align: center; font-size: 14px; font-weight: 600; position: relative; z-index: 99999; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
            🎉 Dewa Mela 2026 Dates: 27th Oct – 5th Nov <br>
            <a href="{{ route('hotels') }}" style="color: #ffeb3b; text-decoration: underline; margin-left: 6px;">Check
                Stays, Hotels &amp; Guest Houses Nearby !!Now Live!!</a>
        </div>
    @endif -->

    <div class="homecontent">
        <div class="webtop-section" style="display: block;">

            {{-- Dynamic Header Switcher --}}
            @if(Request::is('hotels*'))
                @include('home.hotels.includes.header_hotel')

            @elseif(Request::is('cabs*'))
                @include('home.cabs.includes.header_cab')

            @elseif(Request::is('shops*'))
                @include('home.shops.includes.header_shop')

            @else
                @include('home.includes.header')
            @endif

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Dynamic Footer Switcher --}}
    @if(Request::is('hotels*'))
        @include('home.hotels.includes.footer_hotel')
    @elseif(Request::is('cabs*'))
        @include('home.cabs.includes.footer_cab')
    @elseif(Request::is('shops*'))
        @include('home.shops.includes.footer_shop')
    @else
        @include('home.includes.footer')
    @endif

    @include('home.includes.foot')
    @yield('script-area')

</body>

</html>