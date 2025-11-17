@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
    $typeLabels = [
        'platinum' => $isArabic ? 'بلاتيني' : 'Platinum',
        'gold' => $isArabic ? 'ذهبي' : 'Gold',
        'silver' => $isArabic ? 'فضي' : 'Silver',
        'bronze' => $isArabic ? 'برونزي' : 'Bronze',
        'partner' => $isArabic ? 'شريك' : 'Partner',
    ];
@endphp

@section('title', $isArabic ? 'الرعاة' : 'Sponsors')
@section('page-title', $isArabic ? 'إدارة الرعاة' : 'Manage Sponsors')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.sponsors.index') }}">
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
            <div class="col-lg-3">
                <label class="form-label">{{ $isArabic ? 'نوع الرعاية' : 'Sponsorship Type' }}</label>
                <select name="type" class="form-select">
                    <option value="">{{ $isArabic ? 'جميع الأنواع' : 'All types' }}</option>
                    @foreach($typeLabels as $key => $label)
                        <option value="{{ $key }}" {{ ($filters['type'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label">{{ $isArabic ? 'بحث بالاسم' : 'Search by name' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن راعٍ...' : 'Find a sponsor...' }}">
                </div>
            </div>
            <div class="col-lg-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة الرعاة' : 'Sponsors List' }}</h5>
        <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة راعٍ' : 'Add Sponsor' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($sponsors->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'الشعار' : 'Logo' }}</th>
                            <th>{{ $isArabic ? 'الاسم (عربي)' : 'Name (AR)' }}</th>
                            <th>{{ $isArabic ? 'الاسم (إنجليزي)' : 'Name (EN)' }}</th>
                            <th>{{ $isArabic ? 'النوع' : 'Type' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sponsors as $index => $sponsor)
                            <tr>
                                <td>{{ $sponsors->firstItem() + $index }}</td>
                                <td>
                                    @if($sponsor->logo)
                                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name_ar }}" class="border rounded" style="width:60px;height:60px;object-fit:contain;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                                            <i class="fas fa-image text-secondary"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $sponsor->name_ar }}</td>
                                <td>{{ $sponsor->name_en }}</td>
                                <td>
                                    <span class="badge-soft">{{ $typeLabels[$sponsor->type] ?? $sponsor->type }}</span>
                                </td>
                                <td><span class="badge-soft">{{ $isArabic ? $sponsor->conference->title_ar : $sponsor->conference->title_en }}</span></td>
                                <td>{{ $sponsor->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
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
                {{ $sponsors->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا يوجد رعاة للمعايير الحالية.' : 'No sponsors match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection

