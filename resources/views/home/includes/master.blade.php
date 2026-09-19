<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.includes.head')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('home/images/dewasharif/dewalogos.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('home/images/dewasharif/dewalogos.png') }}">

    @yield('head-area')
</head>

<body class="homebody">

    <div class="homecontent">
        <div class="webtop-section" style="display: block;">
            @include('home.includes.header')

            @yield('content')
        </div>
    </div>

    @include('home.includes.footer')
    @include('home.includes.foot')
    @yield('script-area')
</body>

</html>
