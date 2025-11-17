@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
@endphp

@section('title', $isArabic ? 'العارضون' : 'Exhibitors')
@section('page-title', $isArabic ? 'إدارة العارضين' : 'Manage Exhibitors')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.exhibitors.index') }}">
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
                <label class="form-label">{{ $isArabic ? 'بحث بالاسم أو رقم الجناح' : 'Search by name or booth' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن عارض...' : 'Find an exhibitor...' }}">
                </div>
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.exhibitors.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة العارضين' : 'Exhibitors List' }}</h5>
        <a href="{{ route('admin.exhibitors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة عارض' : 'Add Exhibitor' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($exhibitors->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'الشعار' : 'Logo' }}</th>
                            <th>{{ $isArabic ? 'الاسم (عربي)' : 'Name (AR)' }}</th>
                            <th>{{ $isArabic ? 'الاسم (إنجليزي)' : 'Name (EN)' }}</th>
                            <th>{{ $isArabic ? 'وصف العارض' : 'Summary' }}</th>
                            <th>{{ $isArabic ? 'الجناح' : 'Booth' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exhibitors as $index => $exhibitor)
                            <tr>
                                <td>{{ $exhibitors->firstItem() + $index }}</td>
                                <td>
                                    @if($exhibitor->logo)
                                        <img src="{{ asset('storage/' . $exhibitor->logo) }}" alt="{{ $exhibitor->name_ar }}" class="border rounded" style="width:60px;height:60px;object-fit:contain;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                                            <i class="fas fa-image text-secondary"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $exhibitor->name_ar }}</td>
                                <td>{{ $exhibitor->name_en }}</td>
                                <td>
                                    @php
                                        $summary = $isArabic ? ($exhibitor->summary_ar ?? '') : ($exhibitor->summary_en ?? '');
                                    @endphp
                                    @if($summary)
                                        {{ Str::limit($summary, 40) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($exhibitor->booth_number)
                                        <span class="badge-soft">{{ $exhibitor->booth_number }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge-soft">{{ $isArabic ? $exhibitor->conference->title_ar : $exhibitor->conference->title_en }}</span></td>
                                <td>{{ $exhibitor->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.exhibitors.edit', $exhibitor) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.exhibitors.destroy', $exhibitor) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
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
                {{ $exhibitors->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا يوجد عارضون للمعايير الحالية.' : 'No exhibitors match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection

