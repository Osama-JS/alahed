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
    $statuses = [
        'pending' => $isArabic ? 'قيد المراجعة' : 'Pending',
        'approved' => $isArabic ? 'موافق عليه' : 'Approved',
        'rejected' => $isArabic ? 'مرفوض' : 'Rejected',
    ];
@endphp

@section('title', $isArabic ? 'المشاركون المسجلون' : 'Registered Participants')
@section('page-title', $isArabic ? 'قائمة المشاركين' : 'Participants List')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.participants.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-3">
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
            <div class="col-lg-2">
                <label class="form-label">{{ $isArabic ? 'نوع الحضور' : 'Type' }}</label>
                <select name="type" class="form-select">
                    <option value="">{{ $isArabic ? 'الكل' : 'All' }}</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" {{ ($filters['type'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label">{{ $isArabic ? 'الحالة' : 'Status' }}</label>
                <select name="status" class="form-select">
                    <option value="">{{ $isArabic ? 'الكل' : 'All' }}</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ ($filters['status'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label">{{ $isArabic ? 'بحث' : 'Search' }}</label>
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
                            <th>{{ $isArabic ? 'البريد' : 'Email' }}</th>
                            <th>{{ $isArabic ? 'النوع' : 'Type' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'الحالة' : 'Status' }}</th>
                            <th>{{ $isArabic ? 'الحضور' : 'Attendance' }}</th>
                            <th>{{ $isArabic ? 'التاريخ' : 'Date' }}</th>
                            <th class="text-center">{{ $isArabic ? 'الإجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $index => $participant)
                            <tr>
                                <td>{{ $participants->firstItem() + $index }}</td>
                                <td>
                                    <a href="{{ route('admin.participants.show', $participant) }}" class="text-decoration-none fw-semibold">
                                        {{ $participant->name }}
                                    </a>
                                </td>
                                <td><a href="mailto:{{ $participant->email }}">{{ $participant->email }}</a></td>
                                <td><span class="badge bg-info">{{ $types[$participant->type] ?? $participant->type }}</span></td>
                                <td>{{ $isArabic ? optional($participant->conference)->title_ar : optional($participant->conference)->title_en }}</td>
                                <td>
                                    @if($participant->status === 'pending')
                                        <span class="badge bg-warning">{{ $statuses['pending'] }}</span>
                                    @elseif($participant->status === 'approved')
                                        <span class="badge bg-success">{{ $statuses['approved'] }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $statuses['rejected'] }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($participant->status === 'approved')
                                        <span class="badge bg-primary">{{ $participant->attendances->count() }} {{ $isArabic ? 'يوم' : 'days' }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $participant->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.participants.show', $participant) }}" class="btn btn-sm btn-info" title="{{ $isArabic ? 'عرض' : 'View' }}">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($participant->status === 'pending')
                                            <form action="{{ route('admin.participants.approve', $participant->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="{{ $isArabic ? 'موافقة' : 'Approve' }}" onclick="return confirm('{{ $isArabic ? 'هل تريد الموافقة على هذا الطلب؟' : 'Approve this request?' }}')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $participant->id }}" title="{{ $isArabic ? 'رفض' : 'Reject' }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif

                                        <form action="{{ route('admin.participants.destroy', $participant) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ $isArabic ? 'حذف' : 'Delete' }}" onclick="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure?' }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $participant->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.participants.reject', $participant->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $isArabic ? 'رفض الطلب' : 'Reject Request' }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label">{{ $isArabic ? 'سبب الرفض (اختياري)' : 'Reason (optional)' }}</label>
                                                        <textarea name="reason" class="form-control" rows="3"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $isArabic ? 'إلغاء' : 'Cancel' }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ $isArabic ? 'رفض' : 'Reject' }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
