@extends('frontend.layouts.app')

@section('title', (app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en) . ' - ' . (app()->getLocale() == 'ar' ? 'العارضون' : 'Exhibitors'))

@section('content')
    <div class="pages-wrapper">
        <div class="pages-head">
            <div class="container d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <div class="pages-breadcrumb">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
                            </li>
                            <li>
                                <a href="{{ route('exhibitors') }}">{{ app()->getLocale() == 'ar' ? 'العارضون' : 'Exhibitors' }}</a>
                            </li>
                            <li>
                                <span>{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pages-title-wrap mb-0 mt-3">
                        <strong class="pages-title" style="font-size: 2.5rem; line-height: 3rem; margin-inline-start: 0;">
                            {{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}
                        </strong>
                    </div>
                </div>
                @if($conference->logo)
                    <div class="speaker-conf-logo-wrap">
                        <div class="speaker-conf-logo">
                            <img src="{{ asset('storage/' . $conference->logo) }}" alt="Conference Logo" />
                        </div>
                        <span class="speaker-conf-label">
                            {{ app()->getLocale() == 'ar' ? 'شعار المؤتمر' : 'Conference Logo' }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <section class="section-contain">
        <div class="container">
            <div class="exhibitor-detail-card">
                <div class="exhibitor-detail-logo">
                    @if($exhibitor->logo)
                        <img src="{{ asset('storage/' . $exhibitor->logo) }}" alt="{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}" />
                    @else
                        <img src="{{ asset('assets/web/images/default-exhibitor.png') }}" alt="{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}" />
                    @endif
                </div>
                <div class="exhibitor-detail-body">
                    <div class="exhibitor-detail-header">
                        <h1>
                            {{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}
                        </h1>
                        @php
                            $summary = app()->getLocale() == 'ar' ? ($exhibitor->summary_ar ?? '') : ($exhibitor->summary_en ?? '');
                        @endphp
                        @if($summary)
                            <p class="mt-2" style="color:#4B5563;font-size:0.95rem;">
                                {{ $summary }}
                            </p>
                        @endif
                        @if($exhibitor->booth_number)
                            <div class="exhibitor-booth-pill">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ app()->getLocale() == 'ar' ? 'جناح رقم' : 'Booth' }} {{ $exhibitor->booth_number }}</span>
                            </div>
                        @endif
                    </div>

                    @if($exhibitor->description_ar || $exhibitor->description_en)
                        <div class="exhibitor-detail-section">
                            <h2>{{ app()->getLocale() == 'ar' ? 'عن العارض' : 'About the Exhibitor' }}</h2>
                            <p>
                                {!! app()->getLocale() == 'ar' ? $exhibitor->description_ar : $exhibitor->description_en !!}
                            </p>
                        </div>
                    @endif

                    <div class="exhibitor-detail-meta">
                        <div class="exhibitor-detail-meta-item">
                            <span class="label">{{ app()->getLocale() == 'ar' ? 'المؤتمر' : 'Conference' }}</span>
                            <span class="value">{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}</span>
                        </div>
                        @if($exhibitor->website)
                            <div class="exhibitor-detail-meta-item">
                                <span class="label">{{ app()->getLocale() == 'ar' ? 'الموقع الإلكتروني' : 'Website' }}</span>
                                <a href="{{ $exhibitor->website }}" target="_blank" class="exhibitor-website-btn">
                                    <i class="fas fa-globe"></i>
                                    <span>{{ app()->getLocale() == 'ar' ? 'زيارة الموقع' : 'Visit Website' }}</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .exhibitor-detail-card {
        display: grid;
        grid-template-columns: minmax(0, 260px) minmax(0, 1fr);
        gap: 32px;
        padding: 32px;
        border-radius: 32px;
        background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.16), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(96, 165, 250, 0.22), transparent 55%),
                    #ffffff;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
        align-items: center;
    }

    .exhibitor-detail-logo {
        border-radius: 24px;
        background: linear-gradient(145deg, #F3F4F6, #E5E7EB);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .exhibitor-detail-logo img {
        max-width: 100%;
        max-height: 220px;
        object-fit: contain;
    }

    .exhibitor-detail-body {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .exhibitor-detail-header h1 {
        font-size: 1.9rem;
        margin: 0 0 8px;
        color: #0F172A;
        font-weight: 800;
    }

    .exhibitor-booth-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(0, 170, 172, 0.1);
        color: #0F4572;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .exhibitor-booth-pill i {
        color: #00AAAC;
    }

    .exhibitor-detail-section h2 {
        font-size: 1.05rem;
        margin-bottom: 6px;
        color: #0F172A;
        font-weight: 700;
    }

    .exhibitor-detail-section p {
        margin: 0;
        font-size: 0.96rem;
        line-height: 1.8;
        color: #374151;
    }

    .exhibitor-detail-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-top: 8px;
    }

    .exhibitor-detail-meta-item {
        padding: 12px 16px;
        border-radius: 16px;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .exhibitor-detail-meta-item .label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #9CA3AF;
    }

    .exhibitor-detail-meta-item .value {
        font-size: 0.95rem;
        color: #111827;
        font-weight: 600;
    }

    .exhibitor-website-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: #0F4572;
        color: #ffffff;
        font-size: 0.9rem;
        text-decoration: none;
        width: fit-content;
        margin-top: 2px;
        transition: all 0.2s ease;
    }

    .exhibitor-website-btn:hover {
        background: #006F93;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.35);
    }

    .speaker-conf-logo-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .speaker-conf-logo {
        width: 80px;
        height: 80px;
        border-radius: 999px;
        background: #ffffff;
        box-shadow: 0 10px 25px rgba(15, 69, 114, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .speaker-conf-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .speaker-conf-label {
        font-size: 0.75rem;
        color: #4B5563;
    }

    @media (max-width: 992px) {
        .exhibitor-detail-card {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 768px) {
        .exhibitor-detail-card {
            padding: 20px;
            border-radius: 24px;
        }

        .exhibitor-detail-header h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush
