@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
@endphp

@section('title', $isArabic ? 'المؤتمرات' : 'Conferences')
@section('page-title', $isArabic ? 'إدارة المؤتمرات' : 'Manage Conferences')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.conferences.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">{{ $isArabic ? 'بحث بالعنوان أو الموقع' : 'Search by title or location' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'اكتب كلمة البحث...' : 'Type to search...' }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ $isArabic ? 'الحالة' : 'Status' }}</label>
                <select name="status" class="form-select">
                    <option value="">{{ $isArabic ? 'الكل' : 'All' }}</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>{{ $isArabic ? 'نشط' : 'Active' }}</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>{{ $isArabic ? 'غير نشط' : 'Inactive' }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ $isArabic ? 'من تاريخ' : 'From' }}</label>
                <input type="date" name="from" class="form-control" value="{{ $filters['from'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ $isArabic ? 'إلى تاريخ' : 'To' }}</label>
                <input type="date" name="to" class="form-control" value="{{ $filters['to'] ?? '' }}">
            </div>
            <div class="col-md-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i>
                </button>
                <a href="{{ route('admin.conferences.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}">
                    <i class="fas fa-rotate"></i>
                </a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة المؤتمرات' : 'Conferences List' }}</h5>
        <a href="{{ route('admin.conferences.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة مؤتمر' : 'Add Conference' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($conferences->count() > 0)
            <div class="overflow-x-auto">
                <table class="table align-middle min-w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'العنوان (عربي)' : 'Title (AR)' }}</th>
                            <th>{{ $isArabic ? 'العنوان (إنجليزي)' : 'Title (EN)' }}</th>
                            <th>{{ $isArabic ? 'البداية' : 'Start' }}</th>
                            <th>{{ $isArabic ? 'النهاية' : 'End' }}</th>
                            <th>{{ $isArabic ? 'الموقع' : 'Location' }}</th>
                            <th>{{ $isArabic ? 'الحالة' : 'Status' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conferences as $conference)
                            <tr>
                                <td>{{ $conference->id }}</td>
                                <td>{{ $conference->title_ar }}</td>
                                <td>{{ $conference->title_en }}</td>
                                <td>{{ optional($conference->start_date)->format('Y-m-d') }}</td>
                                <td>{{ optional($conference->end_date)->format('Y-m-d') }}</td>
                                <td>{{ $isArabic ? $conference->location_ar : $conference->location_en }}</td>
                                <td>
                                    @if($conference->is_active)
                                        <span class="badge bg-success">{{ $isArabic ? 'نشط' : 'Active' }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $isArabic ? 'غير نشط' : 'Inactive' }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        @if(!$conference->is_active)
                                            <form action="{{ route('admin.conferences.activate', $conference) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="{{ $isArabic ? 'تفعيل' : 'Activate' }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.conferences.edit', $conference) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.conferences.destroy', $conference) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
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
                {{ $conferences->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا توجد مؤتمرات مطابقة للمعايير الحالية.' : 'No conferences found for the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection

