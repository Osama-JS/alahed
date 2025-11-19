@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
@endphp

@section('title', $isArabic ? 'تفاصيل طلب الحجز' : 'Booking Details')
@section('page-title', $isArabic ? 'تفاصيل طلب الحجز' : 'Booking Details')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'بيانات الطلب' : 'Request Information' }}</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">{{ $isArabic ? 'الاسم' : 'Name' }}</dt>
                    <dd class="col-sm-9">{{ $booking->name }}</dd>

                    <dt class="col-sm-3">{{ $isArabic ? 'البريد الإلكتروني' : 'Email' }}</dt>
                    <dd class="col-sm-9">{{ $booking->email }}</dd>

                    <dt class="col-sm-3">{{ $isArabic ? 'الهاتف' : 'Phone' }}</dt>
                    <dd class="col-sm-9">{{ $booking->phone ?? '-' }}</dd>

                    <dt class="col-sm-3">{{ $isArabic ? 'الشركة' : 'Company' }}</dt>
                    <dd class="col-sm-9">{{ $booking->company ?? '-' }}</dd>

                    <dt class="col-sm-3">{{ $isArabic ? 'الموقع الإلكتروني' : 'Website' }}</dt>
                    <dd class="col-sm-9">{{ $booking->website ?? '-' }}</dd>

                    <dt class="col-sm-3">{{ $isArabic ? 'نوع النشاط' : 'Business Type' }}</dt>
                    <dd class="col-sm-9">{{ $booking->business_type ?? '-' }}</dd>

                    <dt class="col-sm-3">{{ $isArabic ? 'ملاحظات' : 'Notes' }}</dt>
                    <dd class="col-sm-9">{{ $booking->notes ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'البوث' : 'Booth' }}</h5>
            </div>
            <div class="card-body">
                @if($booking->booth)
                    <p class="mb-1"><strong>{{ $booking->booth->name }}</strong></p>
                    <p class="mb-1 text-muted">{{ $isArabic ? 'المؤتمر:' : 'Conference:' }}
                        {{ $locale === 'ar' ? $booking->booth->conference->title_ar : $booking->booth->conference->title_en }}</p>
                    <p class="mb-1 text-muted">{{ $isArabic ? 'الحالة الحالية للبوث:' : 'Current booth status:' }}
                        {{ $booking->booth->status_name }}</p>
                    @if(!is_null($booking->booth->price_before_vat))
                        <p class="mb-1">
                            <strong>{{ $isArabic ? 'السعر قبل الضريبة:' : 'Price before VAT:' }}</strong>
                            {{ number_format($booking->booth->price_before_vat, 2) }} {{ $booking->booth->currency }}
                        </p>
                    @endif
                    <p class="mb-0">
                        <strong>{{ $isArabic ? 'السعر:' : 'Price:' }}</strong>
                        {{ number_format($booking->booth->price, 2) }} {{ $booking->booth->currency }}
                    </p>
                @else
                    <p class="text-muted mb-0">{{ $isArabic ? 'البوث غير متوفر.' : 'Booth not available.' }}</p>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'إدارة الحالة' : 'Manage Status' }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.booth-bookings.update', $booking) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">{{ $isArabic ? 'حالة الطلب' : 'Request Status' }}</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>{{ $isArabic ? 'قيد المراجعة' : 'Pending' }}</option>
                            <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>{{ $isArabic ? 'معتمد' : 'Approved' }}</option>
                            <option value="rejected" {{ $booking->status === 'rejected' ? 'selected' : '' }}>{{ $isArabic ? 'مرفوض' : 'Rejected' }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        {{ $isArabic ? 'تحديث الحالة' : 'Update Status' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
