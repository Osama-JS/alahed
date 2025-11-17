@extends('admin.layouts.app')

@section('title', 'إضافة يوم جديد')
@section('page-title', 'إضافة يوم جديد في جدول الأعمال')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">إضافة يوم جديد</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.agenda-days.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="conference_id" class="form-label">المؤتمر <span class="text-danger">*</span></label>
                    <select name="conference_id" id="conference_id" class="form-control @error('conference_id') is-invalid @enderror" required>
                        <option value="">اختر المؤتمر</option>
                        @foreach(\App\Models\Conference::orderBy('title_ar')->get() as $conference)
                            <option value="{{ $conference->id }}" {{ old('conference_id') == $conference->id ? 'selected' : '' }}>
                                {{ $conference->title_ar }}
                            </option>
                        @endforeach
                    </select>
                    @error('conference_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">التاريخ <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="title_ar" class="form-label">العنوان (عربي)</label>
                    <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}">
                    @error('title_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="title_en" class="form-label">العنوان (إنجليزي)</label>
                    <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}">
                    @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="description_ar" class="form-label">الوصف (عربي)</label>
                    <textarea name="description_ar" id="description_ar" rows="4" class="form-control rich-text-ar @error('description_ar') is-invalid @enderror">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="description_en" class="form-label">الوصف (إنجليزي)</label>
                    <textarea name="description_en" id="description_en" rows="4" class="form-control rich-text-en @error('description_en') is-invalid @enderror">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ
                </button>
                <a href="{{ route('admin.agenda-days.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


