@extends('frontend.layouts.app')

@section('title', $booth->name)

@section('content')
@php
    $locale = app()->getLocale();
    $description = $locale == 'ar' ? $booth->description_ar : $booth->description_en;
    $pricePerSqm = ($booth->area && $booth->area > 0) ? round($booth->price / $booth->area, 2) : null;
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

                <h1 class="booth-title mb-2">{{ $booth->name }}</h1>

                <div class="booth-meta mb-3">
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
                        <span class="badge bg-success booth-status-pill">{{ $locale == 'ar' ? 'متاح للحجز' : 'Available for booking' }}</span>
                    @else
                        <span class="badge bg-danger booth-status-pill">{{ $locale == 'ar' ? 'محجوز' : 'Reserved' }}</span>
                    @endif
                </div>

                @if($booth->area || ($booth->width && $booth->height) || $pricePerSqm)
                <div class="booth-key-facts mb-4">
                    @if($booth->area)
                        <div class="fact-item">
                            <div class="fact-label">{{ $locale == 'ar' ? 'المساحة الكلية' : 'Total Area' }}</div>
                            <div class="fact-value">{{ $booth->area }} {{ $locale == 'ar' ? 'م²' : 'm²' }}</div>
                        </div>
                    @endif
                    @if($booth->width && $booth->height)
                        <div class="fact-item">
                            <div class="fact-label">{{ $locale == 'ar' ? 'الأبعاد' : 'Dimensions' }}</div>
                            <div class="fact-value">{{ $booth->width }} × {{ $booth->height }} {{ $locale == 'ar' ? 'متر' : 'm' }}</div>
                        </div>
                    @endif
                    @if($pricePerSqm)
                        <div class="fact-item">
                            <div class="fact-label">{{ $locale == 'ar' ? 'السعر / م²' : 'Price / m²' }}</div>
                            <div class="fact-value">{{ number_format($pricePerSqm, 2) }} {{ $booth->currency }}</div>
                        </div>
                    @endif
                    @if(!is_null($booth->price_before_vat))
                        <div class="fact-item">
                            <div class="fact-label">{{ $locale == 'ar' ? 'السعر قبل الضريبة' : 'Price before VAT' }}</div>
                            <div class="fact-value">{{ number_format($booth->price_before_vat, 2) }} {{ $booth->currency }}</div>
                        </div>
                    @endif
                </div>
                @endif

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
                            @if(!is_null($booth->price_before_vat))
                                <strong>{{ $locale == 'ar' ? 'السعر قبل الضريبة:' : 'Price before VAT:' }}</strong>
                                <p class="mb-1">{{ number_format($booth->price_before_vat, 2) }} {{ $booth->currency }}</p>
                            @endif
                            <strong>{{ $locale == 'ar' ? 'السعر:' : 'Price:' }}</strong>
                            <p class="text-primary fs-3 mb-0">{{ number_format($booth->price, 2) }} {{ $booth->currency }}</p>
                        </div>

                        @if($booth->status == 'available')
                            <hr>
                            <h5 class="mb-3">{{ $locale == 'ar' ? 'طلب حجز هذا البوث' : 'Request to Book this Booth' }}</h5>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('booths.book', $booth) }}" class="booth-booking-form" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">{{ $locale == 'ar' ? 'الاسم الكامل' : 'Full Name' }}</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">{{ $locale == 'ar' ? 'البريد الإلكتروني' : 'Email' }}</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">{{ $locale == 'ar' ? 'رقم الجوال' : 'Phone' }}</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">{{ $locale == 'ar' ? 'اسم الجهة / الشركة' : 'Company / Organization' }}</label>
                                    <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">{{ $locale == 'ar' ? 'الموقع الإلكتروني' : 'Website' }}</label>
                                    <input type="text" name="website" class="form-control" value="{{ old('website') }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">{{ $locale == 'ar' ? 'نوع النشاط التجاري' : 'Business Type' }}</label>
                                    <input type="text" name="business_type" class="form-control" value="{{ old('business_type') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ $locale == 'ar' ? 'ملاحظات إضافية' : 'Additional Notes' }}</label>
                                    <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ $locale == 'ar' ? 'رفع الإيصال البنكي (اختياري)' : 'Upload Bank Receipt (optional)' }}</label>
                                    <input type="file" name="bank_receipt" class="form-control">
                                    <small class="form-text text-muted">
                                        {{ $locale == 'ar'
                                            ? 'الملفات المسموح بها: PDF أو صور (JPG, PNG, WEBP) بحد أقصى 5 ميغابايت.'
                                            : 'Allowed files: PDF or images (JPG, PNG, WEBP) up to 5 MB.' }}
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    {{ $locale == 'ar' ? 'إرسال طلب الحجز' : 'Submit Booking Request' }}
                                </button>
                            </form>
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

.booth-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #111827;
}

.booth-meta .badge {
    font-size: 0.8rem;
}

.booth-status-pill {
    border-radius: 999px;
    padding-inline: 10px;
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

.booth-key-facts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
    margin-top: 10px;
}

.booth-key-facts .fact-item {
    background: #f9fafb;
    border-radius: 12px;
    padding: 10px 12px;
    border: 1px solid #e5e7eb;
}

.booth-key-facts .fact-label {
    font-size: 0.78rem;
    color: #6b7280;
    margin-bottom: 2px;
}

.booth-key-facts .fact-value {
    font-size: 0.98rem;
    font-weight: 600;
    color: #111827;
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

