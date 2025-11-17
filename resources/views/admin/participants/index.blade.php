@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
    $types = [
        'visitor' => $isArabic ? 'زائر' : 'Visitor',
        'exhibitor' => $isArabic ? 'عارض' : 'Exhibitor',
        'speaker' => $isArabic ? 'متحدث' : 'Speaker',
        'sponsor' => $isArabic ? 'راعي' : 'Sponsor',
    ];
@endphp

@section('title', $isArabic ? 'المشاركون المسجلون' : 'Registered Participants')
@section('page-title', $isArabic ? 'قائمة المشاركين' : 'Participants List')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.participants.index') }}">
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
                <label class="form-label">{{ $isArabic ? 'نوع الحضور' : 'Attendance Type' }}</label>
                <select name="type" class="form-select">
                    <option value="">{{ $isArabic ? 'الكل' : 'All' }}</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" {{ ($filters['type'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label">{{ $isArabic ? 'بحث بالاسم أو البريد' : 'Search by name or email' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن مشارك...' : 'Find a participant...' }}">
                </div>
            </div>
            <div class="col-lg-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.participants.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'المشاركون المسجلون' : 'Registered Participants' }}</h5>
    </div>
    <div class="card-body">
        @if($participants->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'الاسم' : 'Name' }}</th>
                            <th>{{ $isArabic ? 'البريد الإلكتروني' : 'Email' }}</th>
                            <th>{{ $isArabic ? 'الهاتف' : 'Phone' }}</th>
                            <th>{{ $isArabic ? 'النوع' : 'Type' }}</th>
                            <th>{{ $isArabic ? 'الشركة' : 'Company' }}</th>
                            <th>{{ $isArabic ? 'المسمى الوظيفي' : 'Title' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'تاريخ التسجيل' : 'Registered At' }}</th>
                            <th class="text-center">{{ $isArabic ? 'حذف' : 'Delete' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $index => $participant)
                            <tr>
                                <td>{{ $participants->firstItem() + $index }}</td>
                                <td>{{ $participant->name }}</td>
                                <td><a href="mailto:{{ $participant->email }}">{{ $participant->email }}</a></td>
                                <td><a href="tel:{{ $participant->phone }}">{{ $participant->phone }}</a></td>
                                <td><span class="badge-soft">{{ $types[$participant->type] ?? $participant->type }}</span></td>
                                <td>{{ $participant->company ?? '-' }}</td>
                                <td>{{ $participant->job_title ?? '-' }}</td>
                                <td>{{ $isArabic ? optional($participant->conference)->title_ar : optional($participant->conference)->title_en }}</td>
                                <td>{{ $participant->created_at->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.participants.destroy', $participant) }}" method="POST" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ $isArabic ? 'حذف' : 'Delete' }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $participants->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا توجد تسجيلات مطابقة حالياً.' : 'No registrations match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection


