@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
@endphp

@section('title', $isArabic ? 'المتحدثون' : 'Speakers')
@section('page-title', $isArabic ? 'إدارة المتحدثين' : 'Manage Speakers')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.speakers.index') }}">
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
                <label class="form-label">{{ $isArabic ? 'بحث بالاسم أو الشركة' : 'Search by name or company' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن متحدث...' : 'Find a speaker...' }}">
                </div>
            </div>
            <div class="col-lg-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fas fa-filter me-2"></i>{{ $isArabic ? 'تطبيق' : 'Apply' }}
                </button>
                <a href="{{ route('admin.speakers.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}">
                    <i class="fas fa-rotate"></i>
                </a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة المتحدثين' : 'Speakers List' }}</h5>
        <a href="{{ route('admin.speakers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة متحدث' : 'Add Speaker' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($speakers->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'الصورة' : 'Avatar' }}</th>
                            <th>{{ $isArabic ? 'الاسم (عربي)' : 'Name (AR)' }}</th>
                            <th>{{ $isArabic ? 'الاسم (إنجليزي)' : 'Name (EN)' }}</th>
                            <th>{{ $isArabic ? 'المنصب' : 'Title' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($speakers as $index => $speaker)
                            <tr>
                                <td>{{ $speakers->firstItem() + $index }}</td>
                                <td>
                                    @if($speaker->image)
                                        <img src="{{ asset('storage/' . $speaker->image) }}" alt="{{ $speaker->name_ar }}" class="rounded-circle border" style="width: 54px; height: 54px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $speaker->name_ar }}</td>
                                <td>{{ $speaker->name_en }}</td>
                                <td>{{ $isArabic ? ($speaker->title_ar ?? '-') : ($speaker->title_en ?? '-') }}</td>
                                <td><span class="badge-soft">{{ $isArabic ? $speaker->conference->title_ar : $speaker->conference->title_en }}</span></td>
                                <td>{{ $speaker->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.speakers.edit', $speaker) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.speakers.destroy', $speaker) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
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
                {{ $speakers->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا يوجد متحدثون للمعايير الحالية.' : 'No speakers match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection

