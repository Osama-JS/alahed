<!doctype html>
@php
    use Illuminate\Support\Str;

    $locale = app()->getLocale();
    $siteName =
        $locale === 'ar'
            ? $siteSettings['name_ar'] ?? 'العهد لتنظيم المعارض والمؤتمرات'
            : $siteSettings['name_en'] ?? 'Al-Ahd for Organizing Exhibitions and Conferences';
    $metaDescription =
        $locale === 'ar'
            ? $siteSettings['meta_description_ar'] ?? 'فرص تصنع الريادة'
            : $siteSettings['meta_description_en'] ?? 'Opportunities that create leadership';
    $seoKeywords = $locale === 'ar' ? $siteSettings['seo_keywords_ar'] ?? '' : $siteSettings['seo_keywords_en'] ?? '';
    $faviconPath = $siteSettings['favicon'] ?? null;
@endphp
<html lang="{{ $locale }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', $siteName)</title>
    <meta content="@yield('description', $metaDescription)" name="description" />
    <meta content="{{ $siteName }}" name="author" />
    @if (!empty($seoKeywords))
        <meta name="keywords" content="{{ $seoKeywords }}">
    @endif

    <!-- App favicon -->
    @if ($faviconPath)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $faviconPath) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $faviconPath) }}">
    @else
        <link rel="apple-touch-icon" sizes="180x180"
            href="{{ asset('assets/frontend/img/icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32"
            href="{{ asset('assets/frontend/img/icon.png') }}">
        <link rel="icon" type="image/png" sizes="16x16"
            href="{{ asset('frontend/img/icon.png') }}">
        <link rel="shortcut icon" href="{{ asset('assets/frontend/img/icon.pnggh ') }}" />
    @endif

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.min.css" />
    <link href="{{ asset('assets/portal/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Ensure Font Awesome icons are not overridden by global font rules */
        .fa,
        .fas,
        .far {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", sans-serif !important;
        }

        .fab {
            font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands", sans-serif !important;
        }
    </style>

    <!-- Select2 CSS -->
    <link href="{{ asset('assets/portal/css/select2.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/portal/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Biban Edition -->
    <link rel="stylesheet" href="{{ asset('assets/web/style/edition.css') }}" />

    <link href="{{ asset('assets/web/style/home.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .footer-contain {
            background: #ffffff;
            border-radius: 30px 30px 0 0;
            box-shadow: 0 -10px 30px rgba(15, 23, 42, 0.08);
            margin-top: 60px;
        }

        .footer-wrap {
            padding: 32px 24px 16px;
        }

        .footer-main {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .footer-column {
            flex: 1 1 260px;
        }

        .footer-content-head .footer-logo img {
            max-height: 56px;
            width: auto;
        }

        .footer-content-body p {
            margin: 12px 0 0;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.7;
        }

        .footer-contact-block strong,
        .footer-social-block strong {
            display: block;
            margin-bottom: 8px;
            color: #111827;
            font-size: 14px;
        }

        .footer-contact-item a,
        .footer-contact-item span {
            display: block;
            color: #1f2933;
            font-size: 14px;
        }

        .footer-contact-item a:hover {
            color: #0f766e;
            text-decoration: none;
        }

        .footer-contact-item + .footer-contact-item {
            margin-top: 4px;
        }

        .footer-address span {
            color: #6b7280;
        }

        .footer-social-block .social-links {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-social-block .social-links a {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #374151;
            transition: all 0.2s ease-in-out;
        }

        .footer-social-block .social-links a:hover {
            background: #0f766e;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .footer-social-block .social-links svg {
            display: block;
        }

        .footer-bottom {
            margin-top: 20px;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
            text-align: center;
        }

        .footer-copy {
            color: #9ca3af;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .footer-wrap {
                padding: 24px 16px 12px;
            }

            .footer-main {
                flex-direction: column;
                gap: 24px;
            }
        }
    </style>

    @if ($locale === 'ar')
        <style>
            .digital-stamp-card {
                padding: 8px 32px;
                background: #F3F4F6;
            }

            .digital-stamp-card .digital-stamp-header {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .digital-stamp-card .digital-stamp-header h6 {
                margin: 0px;
                color: #161616;
                font-size: 14px;
            }

            .digital-stamp-card .digital-stamp-header .btn-digital-stamp-card {
                cursor: pointer;
            }

            .digital-stamp-card .digital-stamp-header .btn-digital-stamp-card span {
                color: #1B8354;
                font-size: 14px;
            }

            .digital-stamp-card .digital-stamp-header .btn-digital-stamp-card svg,
            .digital-stamp-card .digital-stamp-header .btn-digital-stamp-card img {
                transition: 0.3s;
            }

            .digital-stamp-card .digital-stamp-header.open .btn-digital-stamp-card svg,
            .digital-stamp-card .digital-stamp-header.open .btn-digital-stamp-card img {
                transform: rotate(180deg);
            }

            .btn-digital-stamp-card img {
                margin-right: 4px;
                margin-left: 4px;
            }

            .digital-stamp-card .digital-stamp-body {
                padding-top: 40px;
                padding-bottom: 32px;
                display: none;
            }

            .digital-stamp-card .digital-stamp-body .digital-stamp-container {
                margin-bottom: 32px;
                display: flex;
                gap: 32px;
            }

            .digital-stamp-card .digital-stamp-body .digital-stamp-container .box {
                display: flex;
                align-items: flex-start;
                gap: 18px;
            }

            .digital-stamp-card .digital-stamp-body .digital-stamp-container .box .img-border-rounded {
                padding: 14px 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #067647;
                border-radius: 100%;
            }

            .digital-stamp-card .digital-stamp-body .digital-stamp-container .box h6 {
                margin-top: 0px;
                margin-bottom: 12px;
                color: #161616;
                font-size: 18px;
            }

            .digital-stamp-card .digital-stamp-body .digital-stamp-container .box .green-text {
                color: #1B8354;
            }

            .digital-stamp-card .digital-stamp-body .digital-stamp-container .box p {
                margin: 0px;
                color: #384250;
                font-size: 16px;
            }

            .digital-stamp-card .digital-stamp-body .stamp-link-box {
                padding: 8px 28px;
                display: flex;
                align-items: center;
                gap: 12px;
                border-radius: 8px;
                background: #FFF;
            }

            .digital-stamp-card .digital-stamp-body .stamp-link-box p {
                margin: 0px;
                color: #161616;
                font-size: 16px;
            }

            .digital-stamp-card .digital-stamp-body .stamp-link-box a {
                color: #1B8354;
                font-size: 16px;
                text-decoration: underline;
            }

            .stamp-ar {
                direction: rtl;
            }

            .stamp-en {
                direction: ltr;
            }

            @media (max-width: 768px) {
                .digital-stamp-card {
                    padding: 8px 16px;
                }

                .digital-stamp-card .digital-stamp-header {
                    flex-wrap: wrap;
                }

                .digital-stamp-card .digital-stamp-header .btn-digital-stamp-card {
                    flex: 100%;
                    margin-right: 33px;
                }

                .digital-stamp-card .digital-stamp-body .digital-stamp-container {
                    flex-direction: column;
                }

                [dir="ltr"] .digital-stamp-card .digital-stamp-header .btn-digital-stamp-card {
                    margin-right: 0px;
                    margin-left: 33px;
                }
            }
        </style>
        <!-- AR Style -->
        <link href="{{ asset('assets/web/style/rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/portal/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/portal/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/portal/css/custom-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    @endif

    <link href="{{ asset('assets/web/style/layout.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/web/style/base.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/web/style/news.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/web/style/guides.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/portal/css/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/portal/css/datepicker.css') }}" rel="stylesheet" type="text/css" />

    @stack('styles')
</head>

<body class="{{ request()->routeIs('home') ? 'home-page' : '' }}">
    <!-- Header -->
    @include('frontend.partials.header')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('frontend.partials.footer')



    <script src="{{ asset('assets/portal/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/portal/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/portal/js/bootstrap-select.js') }}"></script>

    <script src="{{ asset('assets/portal/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/portal/js/jquery-slim.js') }}"></script>

    <script src="{{ asset('assets/portal/js/popper.js') }}"></script>


    <script src="{{ asset('assets/portal/js/bootstrap.js') }}"></script>


    <script src="{{ asset('assets/portal/libs/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('assets/web/js/base.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var header = document.querySelector('.header-home');
            if (!header) return;

            function handleHeaderScroll() {
                if (window.scrollY > 80) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            }

            handleHeaderScroll();
            window.addEventListener('scroll', handleHeaderScroll);
        });
    </script>

    @stack('scripts')
</body>

</html>
