@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'المخطط والحجوزات' : 'Floor Plan & Reservations')

@section('content')
@php
    $locale = app()->getLocale();
    $groupedBooths = $booths->groupBy('type');
    $typeOrder = ['main', 'strategic', 'premium', 'gold', 'silver', 'standard'];
@endphp

<div class="pages-wrapper">
    <div class="pages-head">
        <div class="container">
            <div class="pages-breadcrumb">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">{{ $locale == 'ar' ? 'الرئيسية' : 'Home' }}</a>
                    </li>
                    <li>
                        <span>{{ $locale == 'ar' ? 'المخطط والحجوزات' : 'Floor Plan & Reservations' }}</span>
                    </li>
                </ul>
            </div>
            <div class="pages-title-wrap">
                <strong class="pages-title">{{ $locale == 'ar' ? 'المخطط والحجوزات' : 'Floor Plan & Reservations' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Floor Plan Section -->
@if($conference->floor_plan_image)
<section class="floor-plan-section section-contain">
    <div class="container">
        <div class="section-head text-center mb-4">
            <h2 class="section-title">
                <i class="fas fa-border-all me-2"></i>
                {{ $locale == 'ar' ? 'مخطط المعرض للمؤتمر النشط' : 'Active Conference Floor Plan' }}
            </h2>
            <p class="section-subtitle">
                {{ $locale == 'ar'
                    ? 'يمكنك استخدام المخطط للتعرّف على توزيع البوثات وأنواعها قبل الحجز'
                    : 'Use the floor plan to understand booth locations and types before booking' }}
            </p>
        </div>
        <div class="floor-plan-image text-center mb-3">
            <img src="{{ asset('storage/' . $conference->floor_plan_image) }}"
                 alt="{{ $locale == 'ar' ? 'مخطط المعرض' : 'Floor Plan' }}" class="img-fluid">
        </div>
        <div class="text-center text-muted small">
            <i class="fas fa-info-circle"></i>
            {{ $locale == 'ar'
                ? 'مواقع وألوان البوثات في المخطط تقريبية وتخضع لتحديثات الجهة المنظمة'
                : 'Booth locations and colors on the plan are indicative and subject to organizer updates.' }}
        </div>
    </div>
</section>
@endif

<!-- Booths by Type Section -->
<section class="booths-section section-contain">
    <div class="container">
        <div class="section-head text-center mb-4">
            <h2 class="section-title">
                <i class="fas fa-store me-2"></i>
                {{ $locale == 'ar' ? 'البوثات المتاحة والحجوزات' : 'Booths & Reservations' }}
            </h2>
            <p class="section-subtitle">
                {{ $locale == 'ar'
                    ? 'استعرض البوثات بحسب الفئة والسعر وحالة الحجز'
                    : 'Browse booths by category, price, and reservation status.' }}
            </p>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <form method="GET" action="{{ route('booths') }}" class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 small">{{ $locale == 'ar' ? 'فلترة حسب الحالة:' : 'Filter by status:' }}</label>
                @php $currentStatus = request('status'); @endphp
                <select name="status" class="form-select form-select-sm" style="min-width: 180px;" onchange="this.form.submit()">
                    <option value="">{{ $locale == 'ar' ? 'الكل (متاح + محجوز)' : 'All (Available + Reserved)' }}</option>
                    <option value="available" {{ $currentStatus === 'available' ? 'selected' : '' }}>{{ $locale == 'ar' ? 'متاح فقط' : 'Available only' }}</option>
                    <option value="reserved" {{ $currentStatus === 'reserved' ? 'selected' : '' }}>{{ $locale == 'ar' ? 'محجوز فقط' : 'Reserved only' }}</option>
                </select>
            </form>

            <div class="booths-view-toggle">
            <div class="btn-group" role="group" aria-label="Booths view toggle">
                <button type="button" class="btn btn-sm btn-primary active" data-view="cards">
                    {{ $locale == 'ar' ? 'عرض كبطاقات' : 'Card View' }}
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary" data-view="table">
                    {{ $locale == 'ar' ? 'عرض كجدول' : 'Table View' }}
                </button>
            </div>
            </div>
        </div>

        @if($booths->count() > 0)
            @foreach($typeOrder as $typeKey)
                @php $typeGroup = $groupedBooths->get($typeKey); @endphp
                @if($typeGroup && $typeGroup->count())
                    <div class="booth-type-section mb-5">
                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                            <h3 class="booth-type-title mb-2">
                                <span class="type-pill type-{{ $typeKey }}">
                                    @php $typeName = $typeGroup->first()->type_name; @endphp
                                    {{ $typeName }}
                                </span>
                            </h3>
                            <span class="text-muted small">
                                {{ $locale == 'ar'
                                    ? 'عدد البوثات في هذه الفئة: '
                                    : 'Booths in this category: ' }}{{ $typeGroup->count() }}
                            </span>
                        </div>

                        <!-- Cards View -->
                        <div class="booth-cards-grid booths-view booths-view-cards">
                            @foreach($typeGroup as $booth)
                                @php
                                    $description = $locale == 'ar' ? $booth->description_ar : $booth->description_en;
                                @endphp
                                <div class="booth-card">
                                    <div class="booth-card-head">
                                        <div class="booth-card-title-line">
                                            <strong class="booth-card-name">{{ $booth->name }}</strong>
                                            <span class="badge booth-status-badge {{ $booth->isAvailable() ? 'bg-success' : 'bg-danger' }}">
                                                {{ $booth->status_name }}
                                            </span>
                                        </div>
                                        <div class="booth-card-subline">
                                            <span class="badge booth-type-badge type-{{ $typeKey }}">{{ $booth->type_name }}</span>
                                            @if($booth->exhibitor)
                                                <span class="exhibitor-name">
                                                    <i class="fas fa-store-alt"></i>
                                                    {{ $locale == 'ar' ? $booth->exhibitor->name_ar : $booth->exhibitor->name_en }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="booth-card-body">
                                        @if($description)
                                            <div class="booth-description">
                                                {!! Str::limit($description, 180) !!}
                                            </div>
                                        @endif

                                        <div class="booth-card-meta">
                                            @if($booth->width && $booth->height)
                                                <div class="meta-item">
                                                    <i class="fas fa-ruler-combined"></i>
                                                    <span>{{ $booth->width }} × {{ $booth->height }} {{ $locale == 'ar' ? 'متر' : 'm' }}</span>
                                                </div>
                                            @endif
                                            @if($booth->area)
                                                <div class="meta-item">
                                                    <i class="fas fa-vector-square"></i>
                                                    <span>{{ $booth->area }} {{ $locale == 'ar' ? 'م²' : 'm²' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="booth-card-footer">
                                        <div class="price">
                                            <span class="price-label">{{ $locale == 'ar' ? 'السعر' : 'Price' }}</span>
                                            <span class="price-value">{{ number_format($booth->price, 2) }} {{ $booth->currency }}</span>
                                        </div>
                                        <div class="actions">
                                            @if($booth->isAvailable())
                                                <a href="{{ route('booths.show', $booth) }}" class="btn btn-sm btn-primary">
                                                    {{ $locale == 'ar' ? 'طلب حجز هذا البوث' : 'Request this Booth' }}
                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-secondary" disabled>
                                                    {{ $locale == 'ar' ? 'غير متاح' : 'Not Available' }}
                                                </button>
                                            @endif
                                            <a href="{{ route('booths.show', $booth) }}" class="btn btn-sm btn-link">
                                                {{ $locale == 'ar' ? 'تفاصيل أكثر' : 'More Details' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Table View -->
                        <div class="booth-table booths-view booths-view-table d-none">
                            <div class="booth-table-header d-none d-md-flex">
                                <div class="bt-col bt-col-name">{{ $locale == 'ar' ? 'البوث' : 'Booth' }}</div>
                                <div class="bt-col bt-col-size">{{ $locale == 'ar' ? 'المساحة / الأبعاد' : 'Size / Dimensions' }}</div>
                                <div class="bt-col bt-col-price">{{ $locale == 'ar' ? 'السعر' : 'Price' }}</div>
                                <div class="bt-col bt-col-status">{{ $locale == 'ar' ? 'الحالة' : 'Status' }}</div>
                                <div class="bt-col bt-col-actions"></div>
                            </div>
                            @foreach($typeGroup as $booth)
                                @php
                                    $description = $locale == 'ar' ? $booth->description_ar : $booth->description_en;
                                @endphp
                                <div class="booth-row">
                                    <div class="bt-col bt-col-name">
                                        <div class="booth-name-line">
                                            <strong>{{ $booth->name }}</strong>
                                            <span class="badge booth-status-badge {{ $booth->isAvailable() ? 'bg-success' : 'bg-danger' }}">
                                                {{ $booth->status_name }}
                                            </span>
                                        </div>
                                        <div class="booth-meta-small">
                                            <span class="badge booth-type-badge type-{{ $typeKey }}">
                                                {{ $booth->type_name }}
                                            </span>
                                            @if($booth->exhibitor)
                                                <span class="exhibitor-name">
                                                    <i class="fas fa-store-alt"></i>
                                                    {{ $locale == 'ar' ? $booth->exhibitor->name_ar : $booth->exhibitor->name_en }}
                                                </span>
                                            @endif
                                            @if($booth->isReserved() && $booth->participant)
                                                <span class="reserved-by">
                                                    <i class="fas fa-user-check"></i>
                                                    {{ $locale == 'ar' ? 'محجوز بواسطة:' : 'Reserved by:' }}
                                                    {{ $booth->participant->name }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($description)
                                            <p class="booth-description mb-0">{!! Str::limit($description, 120) !!}</p>
                                        @endif
                                    </div>
                                    <div class="bt-col bt-col-size">
                                        @if($booth->width && $booth->height)
                                            <div class="size-line">
                                                <i class="fas fa-ruler-combined"></i>
                                                {{ $booth->width }} × {{ $booth->height }} {{ $locale == 'ar' ? 'متر' : 'm' }}
                                            </div>
                                        @endif
                                        @if($booth->area)
                                            <div class="size-line">
                                                <i class="fas fa-vector-square"></i>
                                                {{ $booth->area }} {{ $locale == 'ar' ? 'م²' : 'm²' }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="bt-col bt-col-price">
                                        <span class="text-primary fw-bold">
                                            {{ number_format($booth->price, 2) }} {{ $booth->currency }}
                                        </span>
                                    </div>
                                    <div class="bt-col bt-col-status d-md-flex flex-md-column">
                                        <span class="badge booth-status-badge {{ $booth->isAvailable() ? 'bg-success' : 'bg-danger' }} mb-2 mb-md-1">
                                            {{ $booth->status_name }}
                                        </span>
                                        @if($booth->isAvailable())
                                            <small class="text-muted">{{ $locale == 'ar' ? 'متاح للحجز' : 'Available for booking' }}</small>
                                        @else
                                            <small class="text-muted">{{ $locale == 'ar' ? 'غير متاح حالياً' : 'Not available currently' }}</small>
                                        @endif
                                    </div>
                                    <div class="bt-col bt-col-actions">
                                        @if($booth->isAvailable())
                                            <a href="{{ route('booths.show', $booth) }}" class="btn btn-sm btn-outline-primary w-100 mb-1">
                                                {{ $locale == 'ar' ? 'طلب حجز هذا البوث' : 'Request this Booth' }}
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary w-100 mb-1" disabled>
                                                {{ $locale == 'ar' ? 'غير متاح' : 'Not Available' }}
                                            </button>
                                        @endif
                                        <a href="{{ route('booths.show', $booth) }}" class="btn btn-sm btn-link w-100 p-0">
                                            {{ $locale == 'ar' ? 'تفاصيل أكثر' : 'More Details' }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i>
                {{ $locale == 'ar' ? 'لا توجد بوثات متاحة حالياً' : 'No booths available at the moment' }}
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
    .floor-plan-image img {
        max-width: 100%;
        height: auto;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }

    .section-subtitle {
        color: #6b7280;
        max-width: 640px;
        margin: 0 auto;
    }

    /* Cards Grid */
    .booth-cards-grid {
        display: grid;
        gap: 16px;
        margin-top: 10px;
        grid-template-columns: 1fr;
    }

    /* >= 768px: 2 cards per row */
    @media (min-width: 768px) {
        .booth-cards-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* >= 992px: 3 cards per row */
    @media (min-width: 992px) {
        .booth-cards-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    .booth-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10);
        padding: 16px 16px 14px;
        border: 1px solid #e5e7eb;
    }

    .booth-card-head {
        margin-bottom: 8px;
    }

    .booth-card-title-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 4px;
    }

    .booth-card-name {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    .booth-card-subline {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
        font-size: 0.8rem;
    }

    .booth-card-body {
        flex: 1;
        margin-top: 4px;
    }

    .booth-card-body .booth-description {
        font-size: 0.86rem;
        color: #4b5563;
        margin-bottom: 10px;
    }

    .booth-card-body .booth-card-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 6px;
    }

    .booth-card-body .meta-item {
        font-size: 0.82rem;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .booth-card-body .meta-item i {
        color: #0f4572;
    }

    .booth-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 10px;
    }

    .booth-card-footer .price {
        display: grid;
        gap: 2px;
    }

    .booth-card-footer .price-label {
        font-size: 0.75rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .booth-card-footer .price-value {
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f4572;
    }

    .booth-card-footer .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: flex-end;
    }

    .booths-view-toggle .btn-group .btn {
        min-width: 120px;
    }

    .booths-view-toggle .btn-group .btn.active {
        pointer-events: none;
    }

    .booth-type-section {
        border-radius: 16px;
        padding: 20px 18px 10px;
        background: #f9fafb;
    }

    .booth-type-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    .type-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 0.95rem;
    }

    .type-main { background: rgba(15, 23, 42, 0.08); color: #111827; }
    .type-strategic { background: rgba(56, 189, 248, 0.12); color: #0369a1; }
    .type-premium { background: rgba(129, 140, 248, 0.12); color: #4338ca; }
    .type-gold { background: rgba(234, 179, 8, 0.12); color: #92400e; }
    .type-silver { background: rgba(148, 163, 184, 0.12); color: #374151; }
    .type-standard { background: rgba(209, 213, 219, 0.12); color: #4b5563; }

    /* Table View */
    .booth-table {
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .booth-table-header {
        display: flex;
        padding: 12px 16px;
        background: #f3f4f6;
        font-size: 0.85rem;
        font-weight: 600;
        color: #4b5563;
        border-bottom: 1px solid #e5e7eb;
    }

    .booth-row {
        display: flex;
        flex-wrap: wrap;
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
        row-gap: 8px;
    }

    .booth-row:last-child {
        border-bottom: none;
    }

    .bt-col {
        padding-inline: 4px;
    }

    .bt-col-name { flex: 2 1 220px; }
    .bt-col-size { flex: 1.3 1 170px; }
    .bt-col-price { flex: 0.7 1 120px; display: flex; align-items: center; }
    .bt-col-status { flex: 0.9 1 140px; }
    .bt-col-actions { flex: 0.9 1 150px; display: flex; flex-direction: column; gap: 4px; }

    .booth-name-line {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .booth-name-line strong {
        font-size: 1rem;
        color: #111827;
    }

    .booth-status-badge {
        font-size: 0.75rem;
        border-radius: 999px;
        padding: 4px 10px;
    }

    .booth-type-badge {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.75rem;
        margin-inline-end: 4px;
    }

    .booth-meta-small {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
        margin-bottom: 4px;
        font-size: 0.8rem;
    }

    .booth-meta-small i {
        margin-inline-end: 2px;
    }

    .exhibitor-name,
    .reserved-by {
        color: #4b5563;
    }

    .size-line {
        font-size: 0.85rem;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .size-line i {
        color: #0f4572;
    }

    .booth-description {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 2px;
    }

    @media (max-width: 767.98px) {
        .booth-table-header {
            display: none;
        }

        .booth-row {
            flex-direction: column;
        }

        .bt-col {
            flex: 1 1 100%;
        }
    }
</style>
@endpush
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.querySelector('.booths-view-toggle');
        if (!toggle) return;

        var buttons = toggle.querySelectorAll('button[data-view]');
        var cardsViews = document.querySelectorAll('.booths-view-cards');
        var tableViews = document.querySelectorAll('.booths-view-table');

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var view = this.getAttribute('data-view');

                buttons.forEach(function (b) {
                    var isActive = b.getAttribute('data-view') === view;
                    b.classList.toggle('btn-primary', isActive);
                    b.classList.toggle('btn-outline-primary', !isActive);
                    b.classList.toggle('active', isActive);
                });

                if (view === 'cards') {
                    cardsViews.forEach(function (el) { el.classList.remove('d-none'); });
                    tableViews.forEach(function (el) { el.classList.add('d-none'); });
                } else {
                    cardsViews.forEach(function (el) { el.classList.add('d-none'); });
                    tableViews.forEach(function (el) { el.classList.remove('d-none'); });
                }
            });
        });
    });
</script>
@endpush

