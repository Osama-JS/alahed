@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $filters = $filters ?? [];
@endphp

@section('title', $isArabic ? 'الأسئلة الشائعة' : 'FAQs')
@section('page-title', $isArabic ? 'إدارة الأسئلة الشائعة' : 'Manage FAQs')

@section('content')
<div class="filter-toolbar">
    <form method="GET" action="{{ route('admin.faqs.index') }}">
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
                <label class="form-label">{{ $isArabic ? 'بحث في السؤال أو الإجابة' : 'Search question or answer' }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ $isArabic ? 'ابحث عن سؤال...' : 'Find a question...' }}">
                </div>
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary" title="{{ $isArabic ? 'إعادة تعيين' : 'Reset' }}"><i class="fas fa-rotate"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">{{ $isArabic ? 'قائمة الأسئلة' : 'FAQs List' }}</h5>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <span class="ms-2">{{ $isArabic ? 'إضافة سؤال' : 'Add FAQ' }}</span>
        </a>
    </div>
    <div class="card-body">
        @if($faqs->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'السؤال (عربي)' : 'Question (AR)' }}</th>
                            <th>{{ $isArabic ? 'السؤال (إنجليزي)' : 'Question (EN)' }}</th>
                            <th>{{ $isArabic ? 'المؤتمر' : 'Conference' }}</th>
                            <th>{{ $isArabic ? 'الترتيب' : 'Order' }}</th>
                            <th class="text-center">{{ $isArabic ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $index => $faq)
                            <tr>
                                <td>{{ $faqs->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($faq->question_ar, 70) }}</div>
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($faq->answer_ar, 90) }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($faq->question_en, 70) }}</div>
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($faq->answer_en, 90) }}</small>
                                </td>
                                <td><span class="badge-soft">{{ $isArabic ? optional($faq->conference)->title_ar : optional($faq->conference)->title_en }}</span></td>
                                <td>{{ $faq->order ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-warning" title="{{ $isArabic ? '\u062a\u0639\u062f\u064a\u0644' : 'Edit' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.faqs.duplicate', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? '\u0647\u0644 \u062a\u0631\u064a\u062f \u062a\u0643\u0631\u0627\u0631 \u0647\u0630\u0627 \u0627\u0644\u0633\u0624\u0627\u0644\u061f' : 'Do you want to duplicate this question?' }}')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary" title="{{ $isArabic ? '\u062a\u0643\u0631\u0627\u0631' : 'Duplicate' }}">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $isArabic ? '\u0647\u0644 \u0623\u0646\u062a \u0645\u062a\u0623\u0643\u062f \u0645\u0646 \u0627\u0644\u062d\u0630\u0641\u061f' : 'Are you sure you want to delete?' }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ $isArabic ? '\u062d\u0630\u0641' : 'Delete' }}">
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
                {{ $faqs->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                <i class="fas fa-info-circle"></i>
                <span>{{ $isArabic ? 'لا توجد أسئلة مطابقة للمعايير الحالية.' : 'No FAQs match the current filters.' }}</span>
            </div>
        @endif
    </div>
</div>
@endsection


