<!DOCTYPE html>
@php
    use App\Models\Setting;

    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $siteName = $isArabic
        ? (Setting::get('site_name_ar') ?: 'لوحة التحكم')
        : (Setting::get('site_name_en') ?: 'Admin Panel');
    $logoPath = Setting::get('site_logo');
    $faviconPath = Setting::get('site_favicon');
    $navItems = [
        ['route' => 'admin.dashboard', 'icon' => 'fas fa-gauge', 'label' => ['ar' => 'لوحة التحكم', 'en' => 'Dashboard']],
        ['route' => 'admin.conferences.index', 'icon' => 'fas fa-calendar-days', 'label' => ['ar' => 'المؤتمرات', 'en' => 'Conferences']],
        ['route' => 'admin.speakers.index', 'icon' => 'fas fa-microphone-lines', 'label' => ['ar' => 'المتحدثون', 'en' => 'Speakers']],
        ['route' => 'admin.sponsors.index', 'icon' => 'fas fa-handshake-angle', 'label' => ['ar' => 'الرعاة', 'en' => 'Sponsors']],
        ['route' => 'admin.exhibitors.index', 'icon' => 'fas fa-store', 'label' => ['ar' => 'العارضون', 'en' => 'Exhibitors']],
        ['route' => 'admin.exhibition-booths.index', 'icon' => 'fas fa-th', 'label' => ['ar' => 'بوثات المعرض', 'en' => 'Exhibition Booths']],
        ['route' => 'admin.booth-bookings.index', 'icon' => 'fas fa-book', 'label' => ['ar' => 'طلبات حجز البوثات', 'en' => 'Booth Bookings']],
        ['route' => 'admin.statistics.index', 'icon' => 'fas fa-chart-column', 'label' => ['ar' => 'الإحصاءات', 'en' => 'Statistics']],
        ['route' => 'admin.agenda-days.index', 'icon' => 'fas fa-calendar-day', 'label' => ['ar' => 'أيام الجدول', 'en' => 'Agenda Days']],
        ['route' => 'admin.agenda-sessions.index', 'icon' => 'fas fa-clock', 'label' => ['ar' => 'جلسات الجدول', 'en' => 'Agenda Sessions']],
        ['route' => 'admin.galleries.index', 'icon' => 'fas fa-images', 'label' => ['ar' => 'المعرض', 'en' => 'Gallery']],
        ['route' => 'admin.faqs.index', 'icon' => 'fas fa-circle-question', 'label' => ['ar' => 'الأسئلة الشائعة', 'en' => 'FAQs']],
        ['route' => 'admin.participants.index', 'icon' => 'fas fa-users', 'label' => ['ar' => 'المشاركون', 'en' => 'Participants']],
        ['route' => 'admin.settings.index', 'icon' => 'fas fa-gear', 'label' => ['ar' => 'الإعدادات', 'en' => 'Settings']],
    ];
@endphp
<html lang="{{ $locale }}" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteName) - {{ $siteName }}</title>

    @if($faviconPath)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $faviconPath) }}">
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap{{ $isArabic ? '.rtl' : '' }}.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* تحسين تناسق التصميم عبر جميع صفحات لوحة التحكم وتثبيت المسافات */
        :root {
            --admin-bg: #f3f4f8;
            --sidebar-bg: linear-gradient(180deg, #1f3c88 0%, #182952 100%);
            --sidebar-link: rgba(255, 255, 255, 0.75);
            --sidebar-link-active: #ffffff;
            --topbar-bg: #ffffff;
            --card-radius: 18px;
            --gap-sm: 0.5rem;
            --gap-md: 0.75rem;
            --gap-lg: 1rem;
        }

        a,h1,h2,h3,h4,h5,h6,p,li,span{
            font-family: 'Tajawal', sans-serif;
        }
        body.admin-body {
            background: var(--admin-bg);
            font-family: 'Segoe UI', 'Tahoma', sans-serif;
            min-height: 100vh;
        }

        .admin-layout {
            min-height: 100vh;
        }

        .admin-sidebar {
            background: var(--sidebar-bg);
            color: #fff;
            min-height: 100vh;
            position: sticky;
            top: 0;
            padding: 1.5rem 1rem;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: var(--card-radius);
            background: rgba(255, 255, 255, 0.08);
            margin-bottom: 1.5rem;
        }

        .brand-box img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .brand-name {
            font-weight: 600;
            line-height: 1.2;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: var(--gap-md);
            color: var(--sidebar-link);
            padding: 0.65rem 1rem;
            border-radius: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
            font-weight: 500;
            line-height: 1.2;
        }

        .nav-link-custom i {
            width: 20px;
            text-align: center;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--sidebar-link-active);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        .topbar {
            background: var(--topbar-bg);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            position: sticky;
            top: 0;
            z-index: 25;
        }

        .topbar .lang-toggle .btn {
            font-weight: 600;
        }

        .topbar .lang-toggle .btn.active {
            background: #1f3c88;
            color: #fff;
            border-color: #1f3c88;
        }

        .content-wrapper {
            padding: 2rem 2.5rem;
        }

        .flash-card {
            border-radius: var(--card-radius);
        }

        .setting-card,
        .filter-card,
        .card {
            border-radius: var(--card-radius);
        }

        .filter-toolbar {
            background: #ffffff;
            border-radius: var(--card-radius);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
        }

        .filter-toolbar .form-label {
            font-weight: 600;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: none;
            font-weight: 600;
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }

        .badge-soft {
            background: rgba(31, 60, 136, 0.08);
            color: #1f3c88;
            border-radius: 999px;
            padding: 0.35rem 0.9rem;
            font-weight: 600;
        }

        @media (max-width: 991.98px) {
            .admin-layout {
                display: block;
            }

            .admin-sidebar {
                position: fixed;
                inset-inline-start: -270px;
                width: 260px;
                z-index: 30;
                transition: inset-inline-start 0.3s ease;
            }

            .admin-sidebar.open {
                inset-inline-start: 0;
            }

            .mobile-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.35);
                z-index: 20;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }

            .mobile-backdrop.visible {
                opacity: 1;
                pointer-events: auto;
            }

            .flex-grow-1 {
                width: 100%;
            }

            .content-wrapper {
                padding: 1.5rem 1rem 2rem;
            }

            .table-responsive,
            .table-wrap {
                width: 100%;
                overflow-x: auto;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="admin-body {{ $isArabic ? 'rtl-mode' : 'ltr-mode' }}">
    <div class="admin-layout d-flex">
        <div class="mobile-backdrop"></div>
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="brand-box">
                @if($logoPath)
                    <img src="{{ asset('storage/' . $logoPath) }}" alt="logo">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-white text-primary rounded-circle" style="width:42px;height:42px;">
                        <i class="fas fa-bolt"></i>
                    </div>
                @endif
                <div class="brand-name">{{ $siteName }}</div>
            </div>
            <nav class="nav flex-column gap-1">
                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="nav-link-custom {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['label'][$isArabic ? 'ar' : 'en'] }}</span>
                    </a>
                @endforeach
                <hr class="border-light opacity-25 my-3">
                <a href="{{ route('dashboard') }}" class="nav-link-custom">
                    <i class="fas fa-globe"></i>
                    <span>{{ $isArabic ? 'عرض الموقع' : 'View Website' }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="nav-link-custom w-100 text-start border-0 bg-transparent">
                        <i class="fas fa-arrow-right-from-bracket"></i>
                        <span>{{ $isArabic ? 'تسجيل الخروج' : 'Sign Out' }}</span>
                    </button>
                </form>
            </nav>
        </aside>
        <div class="flex-grow-1">
            <header class="topbar d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" id="sidebarToggle" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h4 class="mb-0 fw-semibold">@yield('page-title', $siteName)</h4>
                        <small class="text-muted">{{ $isArabic ? 'مرحباً' : 'Welcome' }}, {{ auth()->user()->name }}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group lang-toggle" role="group">
                        <a href="{{ route('lang.switch', 'ar') }}" class="btn btn-sm {{ $isArabic ? 'active btn-primary text-white' : 'btn-outline-primary' }}">AR</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="btn btn-sm {{ !$isArabic ? 'active btn-primary text-white' : 'btn-outline-primary' }}">EN</a>
                    </div>
                </div>
            </header>
            <main class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success flash-card shadow-sm border-0 d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger flash-card shadow-sm border-0 d-flex align-items-center gap-2">
                        <i class="fas fa-triangle-exclamation"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.querySelector('.mobile-backdrop');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                backdrop.classList.toggle('visible');
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', () => {
                sidebar.classList.remove('open');
                backdrop.classList.remove('visible');
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof tinymce === 'undefined') {
                return;
            }

            const baseConfig = {
                menubar: true,
                height: 350,
                plugins: 'lists link image table code fullscreen preview searchreplace emoticons directionality',
                toolbar: 'undo redo | formatselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | emoticons | ltr rtl | removeformat | code fullscreen preview',
                content_style: "body { font-family: 'Tajawal', -apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; font-size:14px }",
                branding: false,
                directionality: document.documentElement.getAttribute('dir') === 'rtl' ? 'rtl' : 'ltr'
            };

            if (document.querySelector('textarea.rich-text-ar')) {
                tinymce.init({
                    ...baseConfig,
                    selector: 'textarea.rich-text-ar',
                    language: 'ar',
                    directionality: 'rtl'
                });
            }

            if (document.querySelector('textarea.rich-text-en')) {
                tinymce.init({
                    ...baseConfig,
                    selector: 'textarea.rich-text-en',
                    language: 'en',
                    directionality: 'ltr'
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

