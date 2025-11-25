@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $types = [
        'visitor' => $isArabic ? 'زائر' : 'Visitor',
        'exhibitor' => $isArabic ? 'عارض' : 'Exhibitor',
        'speaker' => $isArabic ? 'متحدث' : 'Speaker',
        'sponsor' => $isArabic ? 'راعي' : 'Sponsor',
    ];
@endphp

@section('title', $isArabic ? 'تفاصيل المشارك' : 'Participant Details')
@section('page-title', $isArabic ? 'تفاصيل المشارك' : 'Participant Details')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Participant Info Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>{{ $isArabic ? 'معلومات المشارك' : 'Participant Information' }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'الاسم' : 'Name' }}</label>
                    <p class="fw-semibold mb-0">{{ $participant->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'البريد الإلكتروني' : 'Email' }}</label>
                    <p class="mb-0"><a href="mailto:{{ $participant->email }}">{{ $participant->email }}</a></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'الهاتف' : 'Phone' }}</label>
                    <p class="mb-0"><a href="tel:{{ $participant->phone }}">{{ $participant->phone }}</a></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'نوع الحضور' : 'Type' }}</label>
                    <p class="mb-0"><span class="badge bg-info">{{ $types[$participant->type] ?? $participant->type }}</span></p>
                </div>
                @if($participant->company)
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'الشركة' : 'Company' }}</label>
                    <p class="mb-0">{{ $participant->company }}</p>
                </div>
                @endif
                @if($participant->job_title)
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'المسمى الوظيفي' : 'Job Title' }}</label>
                    <p class="mb-0">{{ $participant->job_title }}</p>
                </div>
                @endif
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'المؤتمر' : 'Conference' }}</label>
                    <p class="fw-semibold mb-0">{{ $isArabic ? $participant->conference->title_ar : $participant->conference->title_en }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'تاريخ التسجيل' : 'Registration Date' }}</label>
                    <p class="mb-0">{{ $participant->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        <div class="mb-4 text-center">
            <h5 class="mb-3">{{ $isArabic ? 'رمز QR للبطاقة' : 'Ticket QR Code' }}</h5>
            <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code" class="img-fluid" style="max-width:200px;">
            <div class="mt-3">
                <a href="{{ route('ticket.download', $participant->approval_token) }}" class="btn btn-primary" target="_blank">
                    <i class="fas fa-download me-2"></i>{{ $isArabic ? 'تحميل البطاقة' : 'Download Ticket' }}
                </a>
                <button class="btn btn-secondary ms-2" onclick="window.print();">
                    <i class="fas fa-print me-2"></i>{{ $isArabic ? 'طباعة' : 'Print' }}
                </button>
            </div>
        </div>

        <!-- Status Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>{{ $isArabic ? 'حالة الطلب' : 'Request Status' }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'الحالة' : 'Status' }}</label>
                    <p class="mb-0">
                        @if($participant->status === 'pending')
                            <span class="badge bg-warning">{{ $isArabic ? 'قيد المراجعة' : 'Pending' }}</span>
                        @elseif($participant->status === 'approved')
                            <span class="badge bg-success">{{ $isArabic ? 'موافق عليه' : 'Approved' }}</span>
                        @else
                            <span class="badge bg-danger">{{ $isArabic ? 'مرفوض' : 'Rejected' }}</span>
                        @endif
                    </p>
                </div>

                @if($participant->approved_at)
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'تاريخ الموافقة' : 'Approved At' }}</label>
                    <p class="mb-0">{{ $participant->approved_at->format('Y-m-d H:i') }}</p>
                </div>
                @endif

                @if($participant->approvedBy)
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'تمت الموافقة بواسطة' : 'Approved By' }}</label>
                    <p class="mb-0">{{ $participant->approvedBy->name }}</p>
                </div>
                @endif

                @if($participant->admin_notes)
                <div class="mb-3">
                    <label class="text-muted small">{{ $isArabic ? 'ملاحظات الإدارة' : 'Admin Notes' }}</label>
                    <p class="mb-0">{{ $participant->admin_notes }}</p>
                </div>
                @endif

                @if($participant->status === 'pending')
                <div class="d-grid gap-2 mt-4">
                    <form action="{{ route('admin.participants.approve', $participant->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('{{ $isArabic ? 'هل تريد الموافقة على هذا الطلب؟' : 'Approve this request?' }}')">
                            <i class="fas fa-check me-2"></i>{{ $isArabic ? 'موافقة' : 'Approve' }}
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-2"></i>{{ $isArabic ? 'رفض' : 'Reject' }}
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Attendance History -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>{{ $isArabic ? 'سجل الحضور' : 'Attendance History' }}</h5>
            </div>
            <div class="card-body">
                @if($participant->status === 'approved')
                    @if($participant->attendances->count() > 0)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ $isArabic ? 'إجمالي أيام الحضور:' : 'Total attendance days:' }}
                            <strong>{{ $participant->attendances->count() }}</strong>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ $isArabic ? 'التاريخ' : 'Date' }}</th>
                                        <th>{{ $isArabic ? 'وقت الدخول' : 'Check-in Time' }}</th>
                                        <th>{{ $isArabic ? 'نقطة الدخول' : 'Entry Point' }}</th>
                                        <th>{{ $isArabic ? 'سجل بواسطة' : 'Checked In By' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participant->attendances->sortByDesc('attendance_date') as $index => $attendance)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $attendance->attendance_date->format('Y-m-d') }}</td>
                                            <td>{{ $attendance->check_in_time->format('H:i') }}</td>
                                            <td><span class="badge bg-secondary">{{ $attendance->entry_point ?? 'main' }}</span></td>
                                            <td>{{ optional($attendance->checkedInBy)->name ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $isArabic ? 'لم يتم تسجيل أي حضور بعد' : 'No attendance recorded yet' }}
                        </div>
                    @endif
                @else
                    <div class="alert alert-secondary mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ $isArabic ? 'سيتم تفعيل سجل الحضور بعد الموافقة على الطلب' : 'Attendance tracking will be enabled after approval' }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
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
                    <textarea name="reason" class="form-control" rows="3" placeholder="{{ $isArabic ? 'اكتب سبب الرفض...' : 'Enter rejection reason...' }}"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $isArabic ? 'إلغاء' : 'Cancel' }}</button>
                    <button type="submit" class="btn btn-danger">{{ $isArabic ? 'رفض' : 'Reject' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.participants.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-{{ $isArabic ? 'right' : 'left' }} me-2"></i>{{ $isArabic ? 'العودة للقائمة' : 'Back to List' }}
    </a>
</div>
@endsection
