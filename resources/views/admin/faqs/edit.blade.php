@extends('admin.layouts.app')

@section('title', 'تعديل السؤال')
@section('page-title', 'تعديل السؤال')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">تعديل السؤال</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">المؤتمر المرتبط <span class="text-danger">*</span></label>
                <select name="conference_id" class="form-select @error('conference_id') is-invalid @enderror" required>
                    <option value="">اختر المؤتمر</option>
                    @foreach($conferences as $conference)
                        <option value="{{ $conference->id }}" {{ old('conference_id', $faq->conference_id) == $conference->id ? 'selected' : '' }}>
                            {{ $conference->title_ar }}
                        </option>
                    @endforeach
                </select>
                @error('conference_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">السؤال (عربي) <span class="text-danger">*</span></label>
                        <input type="text" name="question_ar" class="form-control @error('question_ar') is-invalid @enderror" value="{{ old('question_ar', $faq->question_ar) }}" required>
                        @error('question_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">السؤال (إنجليزي) <span class="text-danger">*</span></label>
                        <input type="text" name="question_en" class="form-control @error('question_en') is-invalid @enderror" value="{{ old('question_en', $faq->question_en) }}" required>
                        @error('question_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الإجابة (عربي) <span class="text-danger">*</span></label>
                        <textarea name="answer_ar" class="form-control rich-text-ar @error('answer_ar') is-invalid @enderror" rows="4">{{ old('answer_ar', $faq->answer_ar) }}</textarea>
                        @error('answer_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الإجابة (إنجليزي) <span class="text-danger">*</span></label>
                        <textarea name="answer_en" class="form-control rich-text-en @error('answer_en') is-invalid @enderror" rows="4">{{ old('answer_en', $faq->answer_en) }}</textarea>
                        @error('answer_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">الترتيب</label>
                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $faq->order) }}">
                @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i> رجوع
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> تحديث
                </button>
            </div>
        </form>
    </div>
</div>
@endsection




