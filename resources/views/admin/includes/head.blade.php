<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>

    <!--begin::Theme Init (prevents flash of incorrect theme on load, #6043)-->
    <script>
        (() => {
            'use strict';
            const STORAGE_KEY = 'lte-theme';
            let stored = null;
            try {
                stored = localStorage.getItem(STORAGE_KEY);
            } catch {
                // localStorage may be unavailable (private mode, sandboxed iframe).
            }
            const prefersDark = globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
            // Mirror the resolution in _scripts.astro: explicit "dark"/"light" win,
            // otherwise ("auto" or unset) fall back to the OS preference.
            let resolved = 'light';
            if (stored === 'dark' || stored === 'light') {
                resolved = stored;
            } else if (prefersDark) {
                resolved = 'dark';
            }
            document.documentElement.setAttribute('data-bs-theme', resolved);
            document.documentElement.style.colorScheme = resolved;
        })();
    </script>
    <!--end::Theme Init-->

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a free Bootstrap 5 admin dashboard template with almost 50 example pages, built with vanilla JS and designed with accessibility in mind." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel" />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    @if(!empty($setting->favicon) && file_exists(public_path($setting->favicon)))
        <link href="{{ asset($setting->favicon) }}" rel="icon" type="image/x-icon">
    @elseif(!empty($setting->logo) && file_exists(public_path($setting->logo)))
        <link href="{{ asset($setting->logo) }}" rel="icon">
    @else
        <link href="{{ asset('frontend/assets/images/hostlok-logo.png') }}" rel="icon">
    @endif
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('admin/assets/css/adminlte.css')}}" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media = 'all'" />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons & FontAwesome)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--end::Third Party Plugin(Bootstrap Icons & FontAwesome)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('admin/assets/css/adminlte.css')}}" />
    <!--end::Required Plugin(AdminLTE)-->

    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <style>
        .app-footer a {
            color: #22C55E !important;
            transition: color 0.3s ease;
        }

        .app-footer a:hover {
            color: #169645 !important;
        }

        .ck-editor__editable_inline {
            min-height: 180px;
        }

        /* GLOBAL PREMIUM STAT CARDS & GRADIENTS */
        .stat-card {
            border-radius: 16px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 10% 10%, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0) 65%);
            pointer-events: none;
            z-index: 1;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px -6px rgba(0, 0, 0, 0.35) !important;
        }

        .card-gradient-green {
            background: linear-gradient(135deg, #34d399 0%, #198754 48%, #064e3b 100%) !important;
            box-shadow: 0 10px 24px -4px rgba(25, 135, 84, 0.4);
            color: #ffffff !important;
        }
        .card-gradient-blue {
            background: linear-gradient(135deg, #38bdf8 0%, #0d6efd 48%, #032b69 100%) !important;
            box-shadow: 0 10px 24px -4px rgba(13, 110, 253, 0.4);
            color: #ffffff !important;
        }
        .card-gradient-amber {
            background: linear-gradient(135deg, #fde047 0%, #d97706 50%, #78350f 100%) !important;
            box-shadow: 0 10px 24px -4px rgba(217, 119, 6, 0.4);
            color: #ffffff !important;
        }
        .card-gradient-dark {
            background: linear-gradient(135deg, #64748b 0%, #334155 48%, #111827 100%) !important;
            box-shadow: 0 10px 24px -4px rgba(51, 65, 85, 0.4);
            color: #ffffff !important;
        }
        .card-gradient-orange {
            background: linear-gradient(135deg, #fb923c 0%, #ea580c 48%, #7c2d12 100%) !important;
            box-shadow: 0 10px 24px -4px rgba(234, 88, 12, 0.4);
            color: #ffffff !important;
        }
        .card-gradient-red {
            background: linear-gradient(135deg, #ff6b6b 0%, #dc3545 48%, #7f1d1d 100%) !important;
            box-shadow: 0 10px 24px -4px rgba(220, 53, 69, 0.4);
            color: #ffffff !important;
        }
        .card-gradient-purple {
            background: linear-gradient(135deg, #c084fc 0%, #7c3aed 48%, #3b0764 100%) !important;
            box-shadow: 0 10px 24px -4px rgba(124, 58, 237, 0.4);
            color: #ffffff !important;
        }
    </style>

</head>