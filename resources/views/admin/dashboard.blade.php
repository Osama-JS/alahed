@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('title', $locale === 'ar' ? 'لوحة التحكم' : 'Dashboard')
@section('page-title', $locale === 'ar' ? 'لوحة التحكم الرئيسية' : 'Main Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">{{ $locale === 'ar' ? 'المؤتمرات' : 'Conferences' }}</h6>
                        <h3 class="mb-0">{{ $stats['conferences'] }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-calendar-alt fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">{{ $locale === 'ar' ? 'المتحدثون' : 'Speakers' }}</h6>
                        <h3 class="mb-0">{{ $stats['speakers'] }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-microphone fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">{{ $locale === 'ar' ? 'الرعاة' : 'Sponsors' }}</h6>
                        <h3 class="mb-0">{{ $stats['sponsors'] }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-handshake fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">{{ $locale === 'ar' ? 'المشاركون' : 'Participants' }}</h6>
                        <h3 class="mb-0">{{ $stats['participants'] }}</h3>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Active Conference -->
@if($stats['active_conference'])
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-star"></i>
                    {{ $locale === 'ar' ? 'المؤتمر النشط حالياً' : 'Active Conference' }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4>
                            {{ $locale === 'ar'
                                ? $stats['active_conference']->title_ar
                                : $stats['active_conference']->title_en }}
                        </h4>
                        <p class="text-muted">
                            {!! $locale === 'ar'
                                ? $stats['active_conference']->description_ar
                                : $stats['active_conference']->description_en !!}
                        </p>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p>
                                    <strong>{{ $locale === 'ar' ? 'تاريخ البداية:' : 'Start Date:' }}</strong>
                                    {{ $stats['active_conference']->start_date->format('Y-m-d') }}
                                </p>
                                <p>
                                    <strong>{{ $locale === 'ar' ? 'تاريخ النهاية:' : 'End Date:' }}</strong>
                                    {{ $stats['active_conference']->end_date->format('Y-m-d') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <strong>{{ $locale === 'ar' ? 'الموقع:' : 'Location:' }}</strong>
                                    {{ $locale === 'ar'
                                        ? $stats['active_conference']->location_ar
                                        : $stats['active_conference']->location_en }}
                                </p>
                                <p>
                                    <strong>{{ $locale === 'ar' ? 'الوقت:' : 'Time:' }}</strong>
                                    {{ $stats['active_conference']->start_time }} - {{ $stats['active_conference']->end_time }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3">
                            <h6 class="text-muted">
                                {{ $locale === 'ar' ? 'إحصائيات المؤتمر' : 'Conference Stats' }}
                            </h6>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <h4>{{ $stats['active_conference']->speakers->count() }}</h4>
                                    <small>{{ $locale === 'ar' ? 'متحدث' : 'Speaker' }}</small>
                                </div>
                                <div class="col-6">
                                    <h4>{{ $stats['active_conference']->sponsors->count() }}</h4>
                                    <small>{{ $locale === 'ar' ? 'راعي' : 'Sponsor' }}</small>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <h4>{{ $stats['active_conference']->exhibitors->count() }}</h4>
                                    <small>{{ $locale === 'ar' ? 'عارض' : 'Exhibitor' }}</small>
                                </div>
                                <div class="col-6">
                                    <h4>{{ $stats['active_conference']->participants->count() }}</h4>
                                    <small>{{ $locale === 'ar' ? 'مشارك' : 'Participant' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            @if($locale === 'ar')
                لا يوجد مؤتمر نشط حالياً. يرجى تفعيل مؤتمر من
                <a href="{{ route('admin.conferences.index') }}">صفحة المؤتمرات</a>.
            @else
                There is no active conference at the moment. Please activate one from
                <a href="{{ route('admin.conferences.index') }}">Conferences page</a>.
            @endif
        </div>
    </div>
</div>
@endif

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt"></i>
                    {{ $locale === 'ar' ? 'إجراءات سريعة' : 'Quick Actions' }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.conferences.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i>
                            {{ $locale === 'ar' ? 'إضافة مؤتمر جديد' : 'Add New Conference' }}
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.speakers.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i>
                            {{ $locale === 'ar' ? 'إضافة متحدث' : 'Add Speaker' }}
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.sponsors.create') }}" class="btn btn-warning w-100">
                            <i class="fas fa-plus"></i>
                            {{ $locale === 'ar' ? 'إضافة راعي' : 'Add Sponsor' }}
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-cog"></i>
                            {{ $locale === 'ar' ? 'إعدادات الموقع' : 'Site Settings' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

