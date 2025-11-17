@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
@endphp

@section('title', $isArabic ? 'أيام جدول الأعمال' : 'Agenda Days')
@section('page-title', $isArabic ? 'إدارة أيام الجدول' : 'Manage Agenda Days')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.agenda-days.index') }}">
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
            <div class="col-lg-4">
                <label class="form-label">{{ $isArabic ? 'بحث بالعنوان' : 'Search by title' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن يوم...' : 'Find a day...' }}">
                </div>
            </div>
            <div class="col-lg-2">
                <label class="form-label">{{ $isArabic ? 'التاريخ' : 'Date' }}</label>
                <input type="date" name="date" class="form-control" value="{{ $filters['date'] ?? '' }}">
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.agenda-days.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة الأيام' : 'Agenda Days List' }}</h5>
        <a href="{{ route('admin.agenda-days.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة يوم' : 'Add Day' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($agendaDays->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'التاريخ' : 'Date' }}</th>
                            <th>{{ $isArabic ? 'العنوان (عربي)' : 'Title (AR)' }}</th>
                            <th>{{ $isArabic ? 'العنوان (إنجليزي)' : 'Title (EN)' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agendaDays as $index => $day)
                            <tr>
                                <td>{{ $agendaDays->firstItem() + $index }}</td>
                                <td>{{ optional($day->date)->format('Y-m-d') }}</td>
                                <td>{{ $day->title_ar ?? '-' }}</td>
                                <td>{{ $day->title_en ?? '-' }}</td>
                                <td><span class="badge-soft">{{ $isArabic ? $day->conference->title_ar : $day->conference->title_en }}</span></td>
                                <td>{{ $day->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.agenda-days.edit', $day) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.agenda-days.destroy', $day) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
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
                {{ $agendaDays->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا توجد أيام مطابقة للمعايير الحالية.' : 'No agenda days match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection


