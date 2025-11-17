@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'المتحدثون - العهد' : 'Speakers - Al-Ahd')

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
                        <span>{{ app()->getLocale() == 'ar' ? 'المتحدثون' : 'Speakers' }}</span>
                    </li>
                </ul>
            </div>
            <div class="pages-title-wrap">
                <strong class="pages-title">{{ app()->getLocale() == 'ar' ? 'المتحدثون' : 'Speakers' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Speakers Section -->
<section class="speakers-contain section-contain">
    <div class="container">
        

        @if($speakers->count() > 0)
            <div class="speakers-wrap">
                <div class="row">
                    @foreach($speakers as $speaker)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('speakers.show', $speaker) }}" class="text-decoration-none">
                            <div class="speakers-item biban-card">
                                <div class="speakers-item-img biban-card-img">
                                    @if($speaker->image)
                                        <img src="{{ asset('storage/' . $speaker->image) }}" alt="{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}"/>
                                    @else
                                        <img src="{{ asset('assets/web/images/default-speaker.png') }}" alt="{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}"/>
                                    @endif
                                </div>
                                <div class="speakers-item-content biban-card-body">
                                    <strong>{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}</strong>
                                    <span>{{ app()->getLocale() == 'ar' ? $speaker->title_ar : $speaker->title_en }}</span>
                                    @if($speaker->company_ar || $speaker->company_en)
                                        <p class="company-name">{{ app()->getLocale() == 'ar' ? $speaker->company_ar : $speaker->company_en }}</p>
                                    @endif
                                    @if($speaker->bio_ar || $speaker->bio_en)
                                        <p class="speaker-bio">{!! Str::limit(app()->getLocale() == 'ar' ? $speaker->bio_ar : $speaker->bio_en, 90) !!}</p>
                                    @endif
                                    
                                    <!-- Social Media Links -->
                                    @if($speaker->twitter || $speaker->linkedin || $speaker->instagram)
                                        <div class="speaker-social mt-2">
                                            @if($speaker->twitter)
                                                <a href="{{ $speaker->twitter }}" target="_blank" class="social-link" aria-label="X (تويتر)">
                                                    <i class="fab fa-x-twitter"></i>
                                                </a>
                                            @endif
                                            @if($speaker->linkedin)
                                                <a href="{{ $speaker->linkedin }}" target="_blank" class="social-link">
                                                    <i class="fab fa-linkedin"></i>
                                                </a>
                                            @endif
                                            @if($speaker->instagram)
                                                <a href="{{ $speaker->instagram }}" target="_blank" class="social-link">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                {{ app()->getLocale() == 'ar' ? 'لا يوجد متحدثون حالياً' : 'No speakers available at the moment' }}
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Speaker cards: white background, clean card style */
    .speakers-item {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.10);
        border: 1px solid rgba(15, 69, 114, 0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .speakers-item::before {
        content: "";
        position: absolute;
        inset-inline-start: -40px;
        top: -40px;
        width: 120px;
        height: 120px;
        background: radial-gradient(circle at 30% 30%, rgba(15, 69, 114, 0.06), transparent 60%);
        pointer-events: none;
    }

    .speakers-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.18);
    }

    .speakers-item-img {
        width: 100%;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        position: relative;
    }

    .speakers-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .speakers-item:hover .speakers-item-img img {
        transform: scale(1.05);
    }

    .speakers-item-content {
        padding: 18px 18px 16px;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        background: #ffffff;
        color: #4B5563;
    }

    .speakers-item-content strong {
        display: block;
        font-size: 1.05rem;
        color: #0F172A;
        margin-bottom: 2px;
        font-weight: 700;
    }

    .speakers-item-content span {
        display: block;
        font-size: 0.85rem;
        color: #6B7280;
        margin-bottom: 2px;
    }

    .company-name {
        font-size: 0.8rem;
        color: #4B5563;
        margin-bottom: 6px;
    }

    .speaker-bio {
        font-size: 0.85rem;
        color: #6B7280;
        line-height: 1.6;
        margin-bottom: 8px;
        min-height: 40px;
    }

    .speaker-social {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: auto;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 999px;
        background: #f3f4f6;
        color: #4b5563;
        transition: all 0.25s ease;
        font-size: 0.9rem;
    }

    .social-link:hover {
        background: #0f4572;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(15, 23, 42, 0.25);
    }
</style>
@endpush


