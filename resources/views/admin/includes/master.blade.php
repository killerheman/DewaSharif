<!doctype html>
<html lang="en">

<!--begin::Head-->
@include('admin.includes.head')
<!--end::Head-->


<!--begin::Body-->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">


    <!--begin::App Wrapper-->
    <div class="app-wrapper">


        <!--begin::Header-->
        @include('admin.includes.header')
        <!--end::Header-->



        <!--begin::Sidebar-->
        @include('admin.includes.sidebar')
        <!--end::Sidebar-->



        <!--begin::App Main-->
        <main class="app-main">


            <!-- Page Header (Optional) -->
            @yield('page-header')



            <!--begin::App Content-->
            <div class="app-content">


                <div class="container-fluid">


                    {{-- Flash Messages --}}
                    {{-- @include('admin.includes.flash-message') --}}


                    {{-- Page Content --}}
                    @yield('content')


                </div>


            </div>
            <!--end::App Content-->



        </main>
        <!--end::App Main-->



        <!--begin::Footer-->
        @include('admin.includes.footer')
        <!--end::Footer-->



    </div>
    <!--end::App Wrapper-->



    <!--begin::Scripts-->

    {{-- AdminLTE + Plugins JS --}}
    @include('admin.includes.foot')


    {{-- Page Specific JS --}}
    @stack('scripts')


    {{-- Global SweetAlert --}}
    @include('admin.includes.sweetalert')


    <!--end::Scripts-->


</body>
<!--end::Body-->

</html>