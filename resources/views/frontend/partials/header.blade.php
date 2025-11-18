@php
    $locale = app()->getLocale();
    $siteName =
        $locale === 'ar'
            ? $siteSettings['name_ar'] ?? ' لتنظيم المعارض والمؤتمرات'
            : $siteSettings['name_en'] ?? 'Al-Ahd for Organizing Exhibitions and Conferences';
    $logoPath = $siteSettings['logo'] ?? null;
@endphp
<header class="header-contain {{ request()->routeIs('home') ? 'header-home' : '' }}" style="border-radius: 15px;">
    {{-- <img class="header-banner" src="{{ asset('assets/web/images/bg-small-banner.png') }}" /> --}}
    <div class="c_h_container">
        <div class="header-wrap">

            <div class="header-extra">
                <div class="mobile-nav-key d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft"
                    aria-controls="offcanvasLeft">
                    <div class="mobile-nav-key-line"></div>
                    <div class="mobile-nav-key-line"></div>
                    <div class="mobile-nav-key-line"></div>
                </div>
                <div class="lang-switcher_b">
                    
                    @if ($locale == 'ar')
                        <a href="{{ route('lang.switch', 'en') }}" style="display: block;
    width: 100%;
    /* padding: .25rem 1.5rem; */
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    display: flex;
    align-items: center;
    text-align: center;
    padding: 1px 5px;" class="dropdown-item" title="English">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0F4572"
                        viewBox="0 0 256 256">
                        <path
                            d="M128,20A108,108,0,1,0,236,128,108.12,108.12,0,0,0,128,20Zm83.13,96H179.56a144.3,144.3,0,0,0-21.35-66.36A84.22,84.22,0,0,1,211.13,116ZM128,207c-9.36-10.81-24.46-33.13-27.45-67h54.94a119.74,119.74,0,0,1-17.11,52.77A108.61,108.61,0,0,1,128,207Zm-27.45-91a119.74,119.74,0,0,1,17.11-52.77A108.61,108.61,0,0,1,128,49c9.36,10.81,24.46,33.13,27.45,67ZM97.79,49.64A144.3,144.3,0,0,0,76.44,116H44.87A84.22,84.22,0,0,1,97.79,49.64ZM44.87,140H76.44a144.3,144.3,0,0,0,21.35,66.36A84.22,84.22,0,0,1,44.87,140Zm113.34,66.36A144.3,144.3,0,0,0,179.56,140h31.57A84.22,84.22,0,0,1,158.21,206.36Z">
                        </path>
                    </svg>
                            <strong class="align-middle">En</strong>
                        </a>
                    @else
                        <a href="{{ route('lang.switch', 'ar') }}" style="display: block;
    width: 100%;
    /* padding: .25rem 1.5rem; */
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    display: flex;
    align-items: center;
    text-align: center;
    padding: 1px 5px;" class="dropdown-item" title="العربية">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0F4572"
                        viewBox="0 0 256 256">
                        <path
                            d="M128,20A108,108,0,1,0,236,128,108.12,108.12,0,0,0,128,20Zm83.13,96H179.56a144.3,144.3,0,0,0-21.35-66.36A84.22,84.22,0,0,1,211.13,116ZM128,207c-9.36-10.81-24.46-33.13-27.45-67h54.94a119.74,119.74,0,0,1-17.11,52.77A108.61,108.61,0,0,1,128,207Zm-27.45-91a119.74,119.74,0,0,1,17.11-52.77A108.61,108.61,0,0,1,128,49c9.36,10.81,24.46,33.13,27.45,67ZM97.79,49.64A144.3,144.3,0,0,0,76.44,116H44.87A84.22,84.22,0,0,1,97.79,49.64ZM44.87,140H76.44a144.3,144.3,0,0,0,21.35,66.36A84.22,84.22,0,0,1,44.87,140Zm113.34,66.36A144.3,144.3,0,0,0,179.56,140h31.57A84.22,84.22,0,0,1,158.21,206.36Z">
                        </path>
                    </svg>
                            <strong class="align-middle">AR</strong>
                        </a>
                    @endif
                </div>


            </div>

            <div class="header-nav">
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'الرئيسية' : 'Home' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'من نحن' : 'About' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('speakers') }}" class="{{ request()->routeIs('speakers') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'المتحدثون' : 'Speakers' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exhibitors') }}"
                            class="{{ request()->routeIs('exhibitors') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'العارضون' : 'Exhibitors' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('booths') }}" class="{{ request()->routeIs('booths*') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'المخطط والحجوزات' : 'Floor Plan & Bookings' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('agenda') }}" class="{{ request()->routeIs('agenda') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'جدول الأعمال' : 'Agenda' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'معرض الصور' : 'Gallery' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('previous-editions') }}"
                            class="{{ request()->routeIs('previous-editions*') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'النسخ السابقة' : 'Previous Editions' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registration') }}"
                            class="{{ request()->routeIs('registration') ? 'active' : '' }}">
                            {{ $locale == 'ar' ? 'التسجيل' : 'Registration' }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="header-logo-wrap d-flex align-items-center gap-3">
                <div class="header-logo">
                    <a href="{{ route('home') }}" title="{{ $siteName }}">
                        @if ($logoPath)
                            <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $siteName }}" />
                        @else
                            <img src="{{ asset('assets/frontend/img/logo.png') }}" alt="{{ $siteName }}" />
                        @endif
                    </a>
                </div>
            </div>

        </div>
    </div>
</header>


<!-- Mobile Navigation -->
<div class="offcanvas offcanvas-start mobile-nav-wrapper d-lg-none" tabindex="-1" id="offcanvasLeft"
    aria-labelledby="offcanvasLeftLabel">
    <div class="offcanvas-header mobile-nav-padding d-flex justify-content-between align-items-center">
        <div class="mobile-nav-header">
            <a href="{{ route('home') }}" title="{{ $siteName }}">
                @if ($logoPath)
                    <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $siteName }}" style="height: 50px"/>
                @else
                    <img src="{{ asset('assets/frontend/img/logo.png') }}" alt="{{ $siteName }}" style="height: 50px"/>
                @endif
            </a>
        </div>
        <button type="button" class="btn btn-close  " data-bs-dismiss="offcanvas" aria-label="Close">
        {!! app()->getLocale() == 'ar' ? '' : '<i class="fas fa-times"></i>' !!}

</button>
    </div>
    <div class="offcanvas-body mobile-nav-padding">
        <div class="mobile-nav-body">
            <ul class="mobile-nav-list">
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#006f93"
                                viewBox="0 0 256 256">
                                <path
                                    d="M240,208H224V136l2.34,2.34A8,8,0,0,0,237.66,127L139.31,28.68a16,16,0,0,0-22.62,0L18.34,127a8,8,0,0,0,11.32,11.31L32,136v72H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM48,120l80-80,80,80v88H160V152a8,8,0,0,0-8-8H104a8,8,0,0,0-8,8v56H48Zm96,88H112V160h32Z">
                                </path>
                            </svg>
                        </div>
                        <span>{{ $locale == 'ar' ? 'الرئيسية' : 'Home' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('about') }}">
                        <div class="nav-icon">
                            <i class="fas fa-info-circle" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'من نحن' : 'About' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('speakers') }}">
                        <div class="nav-icon">
                            <i class="fas fa-microphone" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'المتحدثون' : 'Speakers' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('exhibitors') }}">
                        <div class="nav-icon">
                            <i class="fas fa-store" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'العارضون' : 'Exhibitors' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('booths') }}">
                        <div class="nav-icon">
                            <i class="fas fa-th-large" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'المخطط والحجوزات' : 'Floor Plan & Bookings' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('agenda') }}">
                        <div class="nav-icon">
                            <i class="fas fa-calendar-alt" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'جدول الأعمال' : 'Agenda' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('gallery') }}">
                        <div class="nav-icon">
                            <i class="fas fa-image" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'معرض الصور' : 'Gallery' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('previous-editions') }}">
                        <div class="nav-icon">
                            <i class="fas fa-history" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'النسخ السابقة' : 'Previous Editions' }}</span>
                    </a>
                </li>
                <li data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <a href="{{ route('registration') }}">
                        <div class="nav-icon">
                            <i class="fas fa-edit" style="color:#006f93;"></i>
                        </div>
                        <span>{{ $locale == 'ar' ? 'التسجيل' : 'Registration' }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
