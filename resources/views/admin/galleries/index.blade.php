@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
    $typeLabels = [
        'image' => $isArabic ? 'صورة' : 'Image',
        'video' => $isArabic ? 'فيديو' : 'Video',
    ];
@endphp

@section('title', $isArabic ? 'إدارة المعرض' : 'Gallery Management')
@section('page-title', $isArabic ? 'إدارة عناصر المعرض' : 'Manage Gallery Items')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.galleries.index') }}">
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
                <label class="form-label">{{ $isArabic ? 'النوع' : 'Type' }}</label>
                <select name="type" class="form-select">
                    <option value="">{{ $isArabic ? 'الكل' : 'All' }}</option>
                    @foreach($typeLabels as $key => $label)
                        <option value="{{ $key }}" {{ ($filters['type'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label">{{ $isArabic ? 'بحث بالعنوان' : 'Search by title' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن عنصر...' : 'Find an item...' }}">
                </div>
            </div>
            <div class="col-lg-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'عناصر المعرض' : 'Gallery Items' }}</h5>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة عنصر' : 'Add Item' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($galleries->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'المعاينة' : 'Preview' }}</th>
                            <th>{{ $isArabic ? 'العنوان' : 'Title' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'النوع' : 'Type' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($galleries as $index => $item)
                            <tr>
                                <td>{{ $galleries->firstItem() + $index }}</td>
                                <td>
                                    @if($item->type === 'image' && $item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title_ar ?? $item->title_en }}" class="rounded border" style="width:100px;height:70px;object-fit:cover;">
                                    @elseif($item->type === 'video')
                                        <span class="badge-soft"><i class="fas fa-video"></i> {{ $typeLabels['video'] }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->title_ar ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->title_en ?? '-' }}</small>
                                </td>
                                <td>{{ $isArabic ? optional($item->conference)->title_ar : optional($item->conference)->title_en }}</td>
                                <td><span class="badge-soft">{{ $typeLabels[$item->type] ?? $item->type }}</span></td>
                                <td>{{ $item->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.galleries.edit', $item) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.galleries.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
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
                {{ $galleries->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا توجد عناصر مطابقة للمعايير الحالية.' : 'No gallery items match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection


