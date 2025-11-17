@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
    $selectedConference = $filters['conference_id'] ?? '';
@endphp

@section('title', $isArabic ? 'جلسات جدول الأعمال' : 'Agenda Sessions')
@section('page-title', $isArabic ? 'إدارة جلسات الجدول' : 'Manage Agenda Sessions')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.agenda-sessions.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-xl-4">
                <label class="form-label">{{ $isArabic ? 'المؤتمر' : 'Conference' }}</label>
                <select name="conference_id" class="form-select">
                    <option value="">{{ $isArabic ? 'جميع المؤتمرات' : 'All conferences' }}</option>
                    @foreach($conferences as $conf)
                        <option value="{{ $conf->id }}" {{ $selectedConference == $conf->id ? 'selected' : '' }}>
                            {{ $isArabic ? $conf->title_ar : $conf->title_en }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-4">
                <label class="form-label">{{ $isArabic ? 'اليوم' : 'Day' }}</label>
                <select name="agenda_day_id" class="form-select">
                    <option value="">{{ $isArabic ? 'كل الأيام' : 'All days' }}</option>
                    @foreach($agendaDays as $day)
                        @if(!$selectedConference || $day->conference_id == $selectedConference)
                            <option value="{{ $day->id }}" {{ ($filters['agenda_day_id'] ?? '') == $day->id ? 'selected' : '' }}>
                                {{ $isArabic ? $day->title_ar : $day->title_en }} - {{ optional($day->date)->format('Y-m-d') }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-xl-3">
                <label class="form-label">{{ $isArabic ? 'بحث بالعنوان أو المسرح' : 'Search by title or stage' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن جلسة...' : 'Find a session...' }}">
                </div>
            </div>
            <div class="col-xl-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.agenda-sessions.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة الجلسات' : 'Sessions List' }}</h5>
        <a href="{{ route('admin.agenda-sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة جلسة' : 'Add Session' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($agendaSessions->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'اليوم' : 'Day' }}</th>
                            <th>{{ $isArabic ? 'الوقت' : 'Time' }}</th>
                            <th>{{ $isArabic ? 'العنوان (عربي)' : 'Title (AR)' }}</th>
                            <th>{{ $isArabic ? 'العنوان (إنجليزي)' : 'Title (EN)' }}</th>
                            <th>{{ $isArabic ? 'المسرح' : 'Stage' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agendaSessions as $index => $session)
                            <tr>
                                <td>{{ $agendaSessions->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $isArabic ? optional($session->agendaDay->conference)->title_ar : optional($session->agendaDay->conference)->title_en }}</div>
                                    <small class="text-muted">{{ optional($session->agendaDay)->date?->format('Y-m-d') }}</small>
                                </td>
                                <td>{{ $session->start_time }} - {{ $session->end_time }}</td>
                                <td>{{ $session->title_ar }}</td>
                                <td>{{ $session->title_en }}</td>
                                <td>{{ $isArabic ? ($session->stage_ar ?? $session->stage_en ?? '-') : ($session->stage_en ?? $session->stage_ar ?? '-') }}</td>
                                <td>{{ $session->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.agenda-sessions.edit', $session) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? 'تعديل' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.agenda-sessions.destroy', $session) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
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
                {{ $agendaSessions->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا توجد جلسات مطابقة للمعايير الحالية.' : 'No sessions match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection


