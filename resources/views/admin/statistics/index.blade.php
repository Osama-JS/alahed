@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
@endphp

@section('title', $isArabic ? 'الإحصاءات' : 'Statistics')
@section('page-title', $isArabic ? 'إدارة الإحصاءات' : 'Manage Statistics')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.statistics.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label class="form-label">{{ $isArabic ? 'المؤتمر' : 'Conference' }}</label>
                <select name="conference_id" class="form-select">
                    <option value="">{{ $isArabic ? 'جميع المؤتمرات' : 'All conferences' }}</option>
                    @foreach($conferences as $conf)
                        <option value="{{ $conf->id }}" {{ ($filters['conference_id'] ?? '') == $conf->id ? 'selected' : '' }}>
                            {{ $isArabic ? $conf->title_ar : $conf->title_en }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6">
                <label class="form-label">{{ $isArabic ? 'بحث في العنوان أو القيمة' : 'Search in label or value' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن إحصائية...' : 'Find a statistic...' }}">
                </div>
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.statistics.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة الإحصاءات' : 'Statistics List' }}</h5>
        <a href="{{ route('admin.statistics.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة إحصائية' : 'Add Statistic' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($statistics->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'النص (عربي)' : 'Label (AR)' }}</th>
                            <th>{{ $isArabic ? 'النص (إنجليزي)' : 'Label (EN)' }}</th>
                            <th>{{ $isArabic ? 'القيمة' : 'Value' }}</th>
                            <th>{{ $isArabic ? 'الأيقونة' : 'Icon' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistics as $index => $statistic)
                            <tr>
                                <td>{{ $statistics->firstItem() + $index }}</td>
                                <td>{{ $statistic->label_ar }}</td>
                                <td>{{ $statistic->label_en }}</td>
                                <td>{{ $statistic->value }}</td>
                                <td>
                                    @if($statistic->icon)
                                        <span class="badge-soft"><i class="{{ $statistic->icon }} me-2"></i>{{ $statistic->icon }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge-soft">{{ $isArabic ? $statistic->conference->title_ar : $statistic->conference->title_en }}</span></td>
                                <td>{{ $statistic->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.statistics.edit', $statistic) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.statistics.destroy', $statistic) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ $isArabic ? 'حذف' : 'Delete' }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $statistics->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا توجد إحصاءات للمعايير الحالية.' : 'No statistics match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection


