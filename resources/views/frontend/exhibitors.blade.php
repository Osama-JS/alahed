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
                        <a href="{{ route('exhibitors.show', $exhibitor) }}" class="text-decoration-none">
                        <div class="exhibitor-card biban-card">
                            <div class="exhibitor-logo biban-card-img">
                                @if($exhibitor->logo)
                                    <img src="{{ asset('storage/' . $exhibitor->logo) }}" alt="{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}" />
                                @else
                                    <img src="{{ asset('assets/web/images/default-exhibitor.png') }}" alt="{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}" />
                                @endif
                            </div>
                            <div class="exhibitor-content biban-card-body">
                                <h4>{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}</h4>
                                @php
                                    $summary = app()->getLocale() == 'ar' ? ($exhibitor->summary_ar ?? '') : ($exhibitor->summary_en ?? '');
                                @endphp
                                @if($summary)
                                    <p class="exhibitor-description">
                                        {{ Str::limit($summary, 100) }}
                                    </p>
                                @elseif($exhibitor->description_ar || $exhibitor->description_en)
                                    <p class="exhibitor-description">
                                        {!! Str::limit(app()->getLocale() == 'ar' ? $exhibitor->description_ar : $exhibitor->description_en, 100) !!}
                                    </p>
                                @endif
                                @if($exhibitor->booth_number)
                                    <div class="booth-number">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ app()->getLocale() == 'ar' ? 'جناح رقم' : 'Booth' }} <strong>{{ $exhibitor->booth_number }}</strong>
                                    </div>
                                @endif
                                @if($exhibitor->website)
                                    <a href="{{ $exhibitor->website }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-globe"></i>
                                        {{ app()->getLocale() == 'ar' ? 'زيارة الموقع' : 'Visit Website' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        </a>
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
    /* Biban-style exhibitor cards (consistent with speakers) */
    .exhibitor-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(56, 189, 248, 0.16), transparent 60%),
            radial-gradient(circle at bottom right, rgba(96, 165, 250, 0.20), transparent 60%),
            #0F4572;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.35);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .exhibitor-card::before {
        content: "";
        position: absolute;
        inset-inline-start: -40px;
        top: -40px;
        width: 120px;
        height: 120px;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.16), transparent 60%);
        pointer-events: none;
    }
    
    .exhibitor-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 26px 65px rgba(15, 23, 42, 0.55);
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
        background: linear-gradient(180deg, rgba(15, 69, 114, 0.05), rgba(15, 69, 114, 0.6));
        color: #E5E7EB;
    }
    
    .exhibitor-content h4 {
        font-size: 18px;
        color: #F9FAFB;
        margin-bottom: 6px;
        font-weight: 700;
    }
    
    .exhibitor-description {
        font-size: 14px;
        color: #E5E7EB;
        line-height: 1.6;
        margin-bottom: 10px;
        flex: 1;
    }
    
    .booth-number {
        font-size: 14px;
        color: #BFDBFE;
        margin-bottom: 10px;
    }
    
    .booth-number i {
        margin-right: 5px;
    }
    
    .booth-number strong {
        font-weight: 700;
    }
</style>
@endpush

