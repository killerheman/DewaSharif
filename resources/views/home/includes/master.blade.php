<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include('home.includes.head')
    @yield('head-area')
</head>

<body class="homebody ">


    <div class="homecontent">
        <div class="webtop-section" style="display: block;">
            @include('home.includes.header')

            @yield('content')

        </div>

    </div>
    @include('home.includes.foot')
    @yield('script-area')
</body>

</html>
