@extends('frontend.layouts.app')

@section('title', (app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en) . ' - ' . (app()->getLocale() == 'ar' ? 'المتحدثون' : 'Speakers'))

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
                                <a href="{{ route('speakers') }}">{{ app()->getLocale() == 'ar' ? 'المتحدثون' : 'Speakers' }}</a>
                            </li>
                            <li>
                                <span>{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pages-title-wrap mb-0 mt-3">
                        <strong class="pages-title" style="font-size: 2.5rem; line-height: 3rem; margin-inline-start: 0;">
                            {{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}
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
            <div class="speaker-detail-card">
                <div class="speaker-detail-avatar">
                    @if($speaker->image)
                        <img src="{{ asset('storage/' . $speaker->image) }}" alt="{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}" />
                    @else
                        <img src="{{ asset('assets/web/images/default-speaker.png') }}" alt="{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}" />
                    @endif
                </div>
                <div class="speaker-detail-body">
                    <div class="speaker-detail-header">
                        <h1>
                            {{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}
                        </h1>
                        @if($speaker->title_ar || $speaker->title_en)
                            <p class="speaker-detail-title">
                                {{ app()->getLocale() == 'ar' ? $speaker->title_ar : $speaker->title_en }}
                            </p>
                        @endif
                        @if($speaker->company_ar || $speaker->company_en)
                            <p class="speaker-detail-company">
                                {{ app()->getLocale() == 'ar' ? $speaker->company_ar : $speaker->company_en }}
                            </p>
                        @endif
                    </div>

                    @if($speaker->bio_ar || $speaker->bio_en)
                        <div class="speaker-detail-section">
                            <h2>{{ app()->getLocale() == 'ar' ? 'نبذة عن المتحدث' : 'About the Speaker' }}</h2>
                            <p>
                                {!! nl2br(e(app()->getLocale() == 'ar' ? $speaker->bio_ar : $speaker->bio_en)) !!}
                            </p>
                        </div>
                    @endif

                    <div class="speaker-detail-meta">
                        <div class="speaker-detail-meta-item">
                            <span class="label">{{ app()->getLocale() == 'ar' ? 'المؤتمر' : 'Conference' }}</span>
                            <span class="value">{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}</span>
                        </div>
                        @if($speaker->twitter || $speaker->linkedin || $speaker->facebook)
                            <div class="speaker-detail-meta-item">
                                <span class="label">{{ app()->getLocale() == 'ar' ? 'روابط التواصل' : 'Social Links' }}</span>
                                <div class="speaker-detail-social">
                                    @if($speaker->twitter)
                                        <a href="{{ $speaker->twitter }}" target="_blank" aria-label="X (تويتر)">
                                            <i class="fab fa-x-twitter"></i>
                                        </a>
                                    @endif
                                    @if($speaker->linkedin)
                                        <a href="{{ $speaker->linkedin }}" target="_blank" aria-label="LinkedIn">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    @endif
                                    @if($speaker->facebook)
                                        <a href="{{ $speaker->facebook }}" target="_blank" aria-label="Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif
                                </div>
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
    .speaker-detail-card {
        display: grid;
        grid-template-columns: minmax(0, 280px) minmax(0, 1fr);
        gap: 32px;
        padding: 32px;
        border-radius: 32px;
        background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.25), transparent 55%),
                    #ffffff;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
        align-items: center;
    }

    .speaker-detail-avatar {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        background: linear-gradient(145deg, #0F4572, #00AAAC);
        padding: 6px;
    }

    .speaker-detail-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 20px;
        display: block;
    }

    .speaker-detail-body {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .speaker-detail-header h1 {
        font-size: 1.9rem;
        margin: 0;
        color: #0F172A;
        font-weight: 800;
    }

    .speaker-detail-title {
        margin: 6px 0 0;
        font-size: 1rem;
        color: #4B5563;
        font-weight: 600;
    }

    .speaker-detail-company {
        margin: 4px 0 0;
        font-size: 0.95rem;
        color: #6B7280;
    }

    .speaker-detail-section h2 {
        font-size: 1.05rem;
        margin-bottom: 6px;
        color: #0F172A;
        font-weight: 700;
    }

    .speaker-detail-section p {
        margin: 0;
        font-size: 0.96rem;
        line-height: 1.8;
        color: #374151;
    }

    .speaker-detail-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-top: 8px;
    }

    .speaker-detail-meta-item {
        padding: 12px 16px;
        border-radius: 16px;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
    }

    .speaker-detail-meta-item .label {
        display: block;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #9CA3AF;
        margin-bottom: 4px;
    }

    .speaker-detail-meta-item .value {
        font-size: 0.95rem;
        color: #111827;
        font-weight: 600;
    }

    .speaker-detail-social {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .speaker-detail-social a {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #E5E7EB;
        color: #374151;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .speaker-detail-social a:hover {
        background: #0F4572;
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
        .speaker-detail-card {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 768px) {
        .speaker-detail-card {
            padding: 20px;
            border-radius: 24px;
        }

        .speaker-detail-header h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush
