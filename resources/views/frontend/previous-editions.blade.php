@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'النسخ السابقة - العهد' : 'Previous Editions - Al-Ahd')

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
                        <span>{{ app()->getLocale() == 'ar' ? 'النسخ السابقة' : 'Previous Editions' }}</span>
                    </li>
                </ul>
            </div>
            <div class="pages-title-wrap">
                <strong class="pages-title">{{ app()->getLocale() == 'ar' ? 'النسخ السابقة' : 'Previous Editions' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Previous Editions Section -->
<section class="previous-editions-contain section-contain">
    <div class="container">
       
        @if($conferences->count() > 0)
            <div class="row">
                @foreach($conferences as $conference)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="edition-card">
                            @if($conference->hero_image)
                                <div class="edition-image">
                                    <img src="{{ asset('storage/' . $conference->hero_image) }}" alt="{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}"/>
                                    <div class="edition-overlay">
                                        <a href="{{ route('previous-editions.show', $conference->id) }}" class="btn btn-light">
                                            {{ app()->getLocale() == 'ar' ? 'عرض التفاصيل' : 'View Details' }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="edition-content">
                                <h3>{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}</h3>
                                @if($conference->start_date && $conference->end_date)
                                    <div class="edition-date">
                                        <i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($conference->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}
                                    </div>
                                @endif
                                @if($conference->location_ar || $conference->location_en)
                                    <div class="edition-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ app()->getLocale() == 'ar' ? $conference->location_ar : $conference->location_en }}
                                    </div>
                                @endif
                                @if($conference->description_ar || $conference->description_en)
                                    <p class="edition-description">
                                        {!! Str::limit(app()->getLocale() == 'ar' ? $conference->description_ar : $conference->description_en, 150) !!}
                                    </p>
                                @endif
                                <a href="{{ route('previous-editions.show', $conference->id) }}" class="btn btn-outline-primary btn-sm">
                                    {{ app()->getLocale() == 'ar' ? 'اقرأ المزيد' : 'Read More' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                {{ app()->getLocale() == 'ar' ? 'لا توجد نسخ سابقة حالياً' : 'No previous editions available at the moment' }}
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    .edition-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .edition-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .edition-image {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
    }
    
    .edition-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .edition-card:hover .edition-image img {
        transform: scale(1.1);
    }
    
    .edition-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .edition-card:hover .edition-overlay {
        opacity: 1;
    }
    
    .edition-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .edition-content h3 {
        font-size: 20px;
        color: #333;
        margin-bottom: 15px;
        font-weight: 700;
    }
    
    .edition-date,
    .edition-location {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .edition-date i,
    .edition-location i {
        color: #007bff;
    }
    
    .edition-description {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
        flex: 1;
    }
</style>
@endpush

