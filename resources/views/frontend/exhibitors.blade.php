@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'العارضون - العهد' : 'Exhibitors - Al-Ahd')

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
                        <span>{{ app()->getLocale() == 'ar' ? 'العارضون' : 'Exhibitors' }}</span>
                    </li>
                </ul>
            </div>
            <div class="pages-title-wrap">
                <strong class="pages-title">{{ app()->getLocale() == 'ar' ? 'العارضون' : 'Exhibitors' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Exhibitors Section -->
<section id="exhibitors" class="section-contain">
    <div class="container">
       

        @if($exhibitors->count() > 0)
            <div class="row">
                @foreach($exhibitors as $exhibitor)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="exhibitor-card">
                            <div class="exhibitor-logo biban-card-img">
                                @if($exhibitor->logo)
                                    <img src="{{ asset('storage/' . $exhibitor->logo) }}" alt="{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}" />
                                @else
                                    <img src="{{ asset('assets/web/images/default-exhibitor.png') }}" alt="{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}" />
                                @endif
                            </div>
                            <div class="exhibitor-content">
                                <h4>{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}</h4>
                                @php
                                    $summary = app()->getLocale() == 'ar' ? ($exhibitor->summary_ar ?? '') : ($exhibitor->summary_en ?? '');
                                @endphp
                                @if($summary)
                                    <p class="exhibitor-description">
                                        {{ $summary }}
                                    </p>
                                @elseif($exhibitor->description_ar || $exhibitor->description_en)
                                    <p class="exhibitor-description">
                                        {!! Str::limit(app()->getLocale() == 'ar' ? $exhibitor->description_ar : $exhibitor->description_en, 100) !!}
                                    </p>
                                @endif
                                @if($exhibitor->booth)
                                    <div class="booth-number">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ app()->getLocale() == 'ar' ? 'البوث:' : 'Booth:' }}
                                        <strong>{{ $exhibitor->booth->name }}</strong>
                                    </div>
                                @endif
                                @if($exhibitor->website)
                                    <a href="{{ $exhibitor->website }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-globe"></i>
                                        {{ app()->getLocale() == 'ar' ? 'زيارة الموقع' : 'Visit Website' }}
                                    </a>
                                @endif

                                <div class="mt-3 d-flex justify-content-end">
                                    <a href="{{ route('exhibitors.show', $exhibitor) }}" class="exhibitor-details-btn" aria-label="{{ app()->getLocale() == 'ar' ? 'عرض تفاصيل العارض' : 'View exhibitor details' }}">
                                        <i class="fas {{ app()->getLocale() == 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                {{ app()->getLocale() == 'ar' ? 'لا يوجد عارضون حالياً' : 'No exhibitors available at the moment' }}
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Exhibitor cards: clean white design */
    .exhibitor-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.10);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #e5e7eb;
    }

    .exhibitor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
    }
    
    .exhibitor-logo {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, 0.08);
        padding: 20px;
    }
    
    .exhibitor-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .exhibitor-content {
        padding: 18px 18px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #ffffff;
        color: #111827;
    }
    
    .exhibitor-content h4 {
        font-size: 18px;
        color: #111827;
        margin-bottom: 6px;
        font-weight: 700;
    }
    
    .exhibitor-description {
        font-size: 14px;
        color: #4B5563;
        line-height: 1.6;
        margin-bottom: 10px;
        flex: 1;
    }
    
    .booth-number {
        font-size: 14px;
        color: #1D4ED8;
        margin-bottom: 10px;
    }
    
    .booth-number i {
        margin-right: 5px;
        color: #2563EB;
    }
    
    .booth-number strong {
        font-weight: 700;
    }

    .exhibitor-details-btn {
        width: 40px;
        height: 40px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #0F4572;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.20);
    }

    .exhibitor-details-btn:hover {
        background: #006F93;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.30);
    }
</style>
@endpush

