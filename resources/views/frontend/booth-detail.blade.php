@extends('frontend.layouts.app')

@section('title', $booth->name)

@section('content')
@php
    $locale = app()->getLocale();
    $description = $locale == 'ar' ? $booth->description_ar : $booth->description_en;
@endphp

<!-- Booth Detail Section -->
<section class="booth-detail-section section-contain" style="margin-top: 110px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if($booth->image)
                <div class="booth-image mb-4">
                    <img src="{{ asset('storage/' . $booth->image) }}" alt="{{ $booth->name }}" class="img-fluid rounded">
                </div>
                @endif

                <h1 class="mb-3">{{ $booth->name }}</h1>

                <div class="booth-meta mb-4">
                    <span class="badge me-2">
                        @if($booth->type == 'standard')
                            <span class="badge bg-secondary">{{ $locale == 'ar' ? 'عادي' : 'Standard' }}</span>
                        @elseif($booth->type == 'premium')
                            <span class="badge bg-primary">{{ $locale == 'ar' ? 'مميز' : 'Premium' }}</span>
                        @elseif($booth->type == 'strategic')
                            <span class="badge bg-info">{{ $locale == 'ar' ? 'استراتيجي' : 'Strategic' }}</span>
                        @elseif($booth->type == 'main')
                            <span class="badge bg-dark">{{ $locale == 'ar' ? 'رئيسي' : 'Main' }}</span>
                        @elseif($booth->type == 'gold')
                            <span class="badge bg-warning">{{ $locale == 'ar' ? 'ذهبي' : 'Gold' }}</span>
                        @else
                            <span class="badge" style="background-color: silver;">{{ $locale == 'ar' ? 'فضي' : 'Silver' }}</span>
                        @endif
                    </span>

                    @if($booth->status == 'available')
                        <span class="badge bg-success">{{ $locale == 'ar' ? 'متاح' : 'Available' }}</span>
                    @else
                        <span class="badge bg-danger">{{ $locale == 'ar' ? 'محجوز' : 'Reserved' }}</span>
                    @endif
                </div>

                @if($description)
                <div class="booth-description mb-4">
                    <h3>{{ $locale == 'ar' ? 'الوصف' : 'Description' }}</h3>
                    <p>{!! app()->getLocale() == 'ar' ? $booth->description_ar : $booth->description_en !!}</p>
                </div>
                @endif

                @if($booth->notes)
                <div class="booth-notes alert alert-info">
                    <strong>{{ $locale == 'ar' ? 'ملاحظات:' : 'Notes:' }}</strong>
                    <p class="mb-0">{{ $booth->notes }}</p>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="booth-info-card card sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ $locale == 'ar' ? 'معلومات البوث' : 'Booth Information' }}</h4>

                        <div class="info-item mb-3">
                            <strong>{{ $locale == 'ar' ? 'المؤتمر:' : 'Conference:' }}</strong>
                            <p>{{ $locale == 'ar' ? $booth->conference->title_ar : $booth->conference->title_en }}</p>
                        </div>

                        @if($booth->exhibitor)
                        <div class="info-item mb-3">
                            <strong>{{ $locale == 'ar' ? 'العارض:' : 'Exhibitor:' }}</strong>
                            <p>{{ $locale == 'ar' ? $booth->exhibitor->name_ar : $booth->exhibitor->name_en }}</p>
                        </div>
                        @endif

                        @if($booth->width && $booth->height)
                        <div class="info-item mb-3">
                            <strong>{{ $locale == 'ar' ? 'الأبعاد:' : 'Dimensions:' }}</strong>
                            <p>{{ $booth->width }} × {{ $booth->height }} {{ $locale == 'ar' ? 'متر' : 'm' }}</p>
                        </div>
                        @endif

                        @if($booth->area)
                        <div class="info-item mb-3">
                            <strong>{{ $locale == 'ar' ? 'المساحة:' : 'Area:' }}</strong>
                            <p>{{ $booth->area }} {{ $locale == 'ar' ? 'م²' : 'm²' }}</p>
                        </div>
                        @endif

                        <div class="info-item mb-4">
                            <strong>{{ $locale == 'ar' ? 'السعر:' : 'Price:' }}</strong>
                            <p class="text-primary fs-3 mb-0">{{ number_format($booth->price, 2) }} {{ $booth->currency }}</p>
                        </div>

                        @if($booth->status == 'available')
                        <a href="{{ route('registration') }}" class="btn btn-primary btn-lg w-100">
                            {{ $locale == 'ar' ? 'احجز الآن' : 'Book Now' }}
                        </a>
                        @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            {{ $locale == 'ar' ? 'محجوز' : 'Reserved' }}
                        </button>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('booths') }}" class="btn btn-outline-secondary w-100">
                                {{ $locale == 'ar' ? 'عودة للبوثات' : 'Back to Booths' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.booth-detail-section {
    padding: 60px 0;
}

.booth-image img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
}

.booth-info-card {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.info-item strong {
    display: block;
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.info-item p {
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 0;
}
</style>
@endsection

