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

    <!-- Top Alert Notification Bar -->
    <div style="background: #0b5e36; color: #ffffff; padding: 10px 15px; text-align: center; font-size: 14px; font-weight: 600; position: relative; z-index: 99999; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
        🎉 Dewa Mela 2026 Dates: 27th Oct – 5th Nov |
        <a href="#stay" style="color: #ffeb3b; text-decoration: underline; margin-left: 6px;">Check Stays, Hotels &amp; Guest Houses Nearby !!</a>
    </div>

    <div class="homecontent">
        <div class="webtop-section" style="display: block;">
            @include('home.includes.header')

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @include('home.includes.footer')
    @include('home.includes.foot')
    @yield('script-area')

</body>
</html>
