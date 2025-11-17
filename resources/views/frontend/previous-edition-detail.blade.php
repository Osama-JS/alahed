@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? $conference->title_ar . ' - العهد' : $conference->title_en . ' - Al-Ahd')

@section('content')

<div class="pages-wrapper">
    <div class="pages-head">
        <div class="container">
            <div class="pages-breadcrumb">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
                    </li>
                    <li>
                        <a href="{{ route('previous-editions') }}">{{ app()->getLocale() == 'ar' ? 'النسخ السابقة' : 'Previous Editions' }}</a>
                    </li>
                    <li>
                        <span>{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}</span>
                    </li>
                </ul>
            </div>
            <div class="pages-title-wrap">
                <strong class="pages-title">{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Conference Hero -->
@if($conference->hero_image)
<section class="conference-hero">
    <img src="{{ asset('storage/' . $conference->hero_image) }}" alt="{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}" class="w-100">
</section>
@endif

<!-- About Section -->
<section id="about" class="about-contain section-contain">
    <div class="container">
        <div class="section-title-wrap">
           
        </div>
        <div class="about-wrap">
            <div class="about-head">
                <div class="about-head-content">
                    <div class="conference-info mb-4">
                        @if($conference->start_date && $conference->end_date)
                            <div class="info-item mb-3">
                                <i class="fas fa-calendar fa-2x text-primary"></i>
                                <div>
                                    <strong>{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</strong>
                                    <p>{{ \Carbon\Carbon::parse($conference->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($conference->location_ar || $conference->location_en)
                            <div class="info-item mb-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                <div>
                                    <strong>{{ app()->getLocale() == 'ar' ? 'الموقع' : 'Location' }}</strong>
                                    <p>{{ app()->getLocale() == 'ar' ? $conference->location_ar : $conference->location_en }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <p>{!! app()->getLocale() == 'ar' ? $conference->description_ar : $conference->description_en !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
@if($statistics->count() > 0)
<section class="statistics-section section-contain">
    <div class="container">
        <h3 class="text-center mb-4">{{ app()->getLocale() == 'ar' ? 'إحصائيات المؤتمر' : 'Conference Statistics' }}</h3>
        <div class="row">
            @foreach($statistics as $stat)
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item text-center">
                        @if($stat->icon)
                            <i class="{{ $stat->icon }} stat-icon"></i>
                        @endif
                        <h3 class="stat-value">{{ $stat->value }}</h3>
                        <p class="stat-label">{{ app()->getLocale() == 'ar' ? $stat->label_ar : $stat->label_en }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Speakers Section -->
@if($speakers->count() > 0)
<section class="speakers-contain section-contain">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'المتحدثون' : 'Speakers' }}</h2>
            <img class="section-banner" src="{{ asset('assets/web/images/section-title-banner.png') }}"/>
        </div>
        <div class="row">
            @foreach($speakers as $speaker)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="speakers-item">
                        <div class="speakers-item-img">
                            @if($speaker->image)
                                <img src="{{ asset('storage/' . $speaker->image) }}" alt="{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}"/>
                            @endif
                        </div>
                        <div class="speakers-item-content">
                            <strong>{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}</strong>
                            <span>{{ app()->getLocale() == 'ar' ? $speaker->title_ar : $speaker->title_en }}</span>
                            @if($speaker->company_ar || $speaker->company_en)
                                <p>{{ app()->getLocale() == 'ar' ? $speaker->company_ar : $speaker->company_en }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Sponsors Section -->
@if($sponsors->count() > 0)
<section class="sponsors-contain section-contain bg-white">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title gray-color">{{ app()->getLocale() == 'ar' ? 'الرعاة' : 'Sponsors' }}</h2>
        </div>
        <div class="sponsors-wrap">
            @php
                $sponsorTypes = $sponsors->groupBy('type');
            @endphp
            @foreach(['platinum', 'gold', 'silver', 'bronze', 'partner'] as $type)
                @if(isset($sponsorTypes[$type]) && $sponsorTypes[$type]->count() > 0)
                    <div class="sponsor-category mb-5">
                        <h3 class="sponsor-type-title">
                            {{ app()->getLocale() == 'ar' ?
                                ['platinum' => 'الرعاة البلاتينيون', 'gold' => 'الرعاة الذهبيون', 'silver' => 'الرعاة الفضيون', 'bronze' => 'الرعاة البرونزيون', 'partner' => 'الشركاء'][$type] :
                                ['platinum' => 'Platinum Sponsors', 'gold' => 'Gold Sponsors', 'silver' => 'Silver Sponsors', 'bronze' => 'Bronze Sponsors', 'partner' => 'Partners'][$type]
                            }}
                        </h3>
                        <div class="row">
                            @foreach($sponsorTypes[$type] as $sponsor)
                                <div class="col-md-3 col-6 mb-4">
                                    <div class="sponsor-item">
                                        @if($sponsor->logo)
                                            <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ app()->getLocale() == 'ar' ? $sponsor->name_ar : $sponsor->name_en }}" class="img-fluid"/>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if($galleries->count() > 0)
<section id="gallery" class="gallery-contain section-contain">
    <div class="container">
        <div class="section-title-wrap">
            <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'معرض الصور' : 'Gallery' }}</h2>
            <img class="section-banner" src="{{ asset('assets/web/images/section-title-banner.png') }}"/>
        </div>
        <div class="gallery-wrap">
            <div class="row">
                @foreach($galleries->take(8) as $item)
                    <div class="col-md-3 col-6 mb-4">
                        <div class="gallery-item">
                            @if($item->type == 'image')
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ app()->getLocale() == 'ar' ? $item->title_ar : $item->title_en }}" class="img-fluid"/>
                            @elseif($item->type == 'video')
                                <video controls class="w-100">
                                    <source src="{{ asset('storage/' . $item->image) }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@endsection

