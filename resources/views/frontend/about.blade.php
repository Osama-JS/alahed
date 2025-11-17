@extends('frontend.layouts.app')

@php
    $locale = app()->getLocale();
    $siteName =
        $locale === 'ar'
            ? $siteSettings['name_ar'] ?? 'العهد لتنظيم المعارض والمؤتمرات'
            : $siteSettings['name_en'] ?? 'Al-Ahd for Organizing Exhibitions and Conferences';
    $companyAbout =
        $locale === 'ar'
            ? $siteSettings['about_ar'] ?? ($siteSettings['short_description_ar'] ?? null)
            : $siteSettings['about_en'] ?? ($siteSettings['short_description_en'] ?? null);
@endphp

@section('title', app()->getLocale() == 'ar' ? 'عن المؤتمر - العهد' : 'About Conference - Al-Ahd')

@section('content')

    <!-- Page Header -->
    {{-- <section class="page-header">
    <div class="container">
        <h1>{{ app()->getLocale() == 'ar' ? 'عن المؤتمر' : 'About Conference' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="breadcrumb-item active">{{ app()->getLocale() == 'ar' ? 'عن المؤتمر' : 'About' }}</li>
            </ol>
        </nav>
    </div>
</section> --}}
    <div class="pages-wrapper">

        <div class="pages-head">
            <div class="container">
                <div class="pages-breadcrumb">
                    <ul>
                        <li>
                            <a href="../ar.html">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
                        </li>
                        <li>
                            <span>{{ app()->getLocale() == 'ar' ? 'عن' : 'About' }} {{ $siteName }}</span>
                        </li>
                    </ul>
                </div>
                <div class="pages-title-wrap">
                    <strong class="pages-title">{{ $siteName }}</strong>
                </div>
            </div>
        </div>

    </div>

    @if ($companyAbout)
        <section class="section-contain py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <p class="lead">{!! $companyAbout !!}</p>
                    </div>
                    <div class="col-lg-6 text-center">
                        @php $logoPath = $siteSettings['logo'] ?? null; @endphp
                        @if ($logoPath)
                            <img src="{{ asset('storage/' . $logoPath) }}"
                                alt="{{ $locale === 'ar' ? $siteSettings['name_ar'] ?? 'العهد' : $siteSettings['name_en'] ?? 'Al-Ahd' }}"
                                class="img-fluid" style="max-width: 280px;">
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- About Section -->
    <section id="about" class="about-contain section-contain">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}
                </h2>
            </div>

            <div class="about-wrap">
                <div class="about-head">
                    @if ($conference->hero_image)
                        <div class="about-head-img">
                            <img class="head-banner" src="{{ asset('storage/' . $conference->hero_image) }}"
                                alt="{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}" />
                        </div>
                    @endif
                    <div class="about-head-content">
                        <div class="conference-info mb-4">
                            @if ($conference->start_date && $conference->end_date)
                                <div class="info-item mb-3">
                                    <i class="fas fa-calendar fa-2x text-primary"></i>
                                    <div>
                                        <strong>{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</strong>
                                        <p>{{ \Carbon\Carbon::parse($conference->start_date)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($conference->location_ar || $conference->location_en)
                                <div class="info-item mb-3">
                                    <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                    <div>
                                        <strong>{{ app()->getLocale() == 'ar' ? 'الموقع' : 'Location' }}</strong>
                                        <p>{{ app()->getLocale() == 'ar' ? $conference->location_ar : $conference->location_en }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="conference-description">
                            <h3>{{ app()->getLocale() == 'ar' ? 'نبذة عن المؤتمر' : 'About the Conference' }}</h3>
                            <p>{!! app()->getLocale() == 'ar' ? $conference->description_ar : $conference->description_en !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics (same layout as Home) -->
            @if ($statistics->count() > 0)
                <div class="mt-5">
                    <h3 class="text-center mb-4">
                        {{ app()->getLocale() == 'ar' ? 'إحصائيات المؤتمر' : 'Conference Statistics' }}
                    </h3>

                    <div class="key-figures">
                        <div class="edition-container">
                            <div class="figures-forums @if(app()->getLocale() == 'ar') ar-lang @else en-lang @endif">
                                @foreach ($statistics as $stat)
                                    <div class="figures-forums-item">
                                        <div class="icon-container">
                                            @if ($stat->icon)
                                                <i class="{{ $stat->icon }}"></i>
                                            @endif
                                        </div>
                                        <div class="item-text">
                                            <h3 class="count">{{ $stat->value }}</h3>
                                            <p class="desc">
                                                {{ app()->getLocale() == 'ar' ? $stat->label_ar : $stat->label_en }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Call to Action -->
            <div class="text-center mt-5">
                <a href="{{ route('registration') }}" class="btn btn-primary btn-lg">
                    {{ app()->getLocale() == 'ar' ? 'سجل الآن' : 'Register Now' }}
                </a>
            </div>
        </div>
    </section>

@endsection
