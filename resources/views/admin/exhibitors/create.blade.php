@extends('admin.layouts.app')

@section('title', 'إضافة عارض جديد')
@section('page-title', 'إضافة عارض جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">إضافة عارض جديد</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.exhibitors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-12 mb-3">
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
                    <label for="name_ar" class="form-label">الاسم (عربي) <span class="text-danger">*</span></label>
                    <input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}" required>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="name_en" class="form-label">الاسم (إنجليزي) <span class="text-danger">*</span></label>
                    <input type="text" name="name_en" id="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="summary_ar" class="form-label">وصف العارض (عربي)</label>
                    <input type="text" name="summary_ar" id="summary_ar" class="form-control @error('summary_ar') is-invalid @enderror" value="{{ old('summary_ar') }}">
                    @error('summary_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="summary_en" class="form-label">وصف العارض (إنجليزي)</label>
                    <input type="text" name="summary_en" id="summary_en" class="form-control @error('summary_en') is-invalid @enderror" value="{{ old('summary_en') }}">
                    @error('summary_en')
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
                    <label for="booth_number" class="form-label">رقم الجناح</label>
                    <input type="text" name="booth_number" id="booth_number" class="form-control @error('booth_number') is-invalid @enderror" value="{{ old('booth_number') }}">
                    @error('booth_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="website" class="form-label">الموقع الإلكتروني</label>
                    <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                    @error('website')
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

                <div class="col-md-6 mb-3">
                    <label for="logo" class="form-label">الشعار</label>
                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">الحد الأقصى: 2 ميجابايت</small>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ
                </button>
                <a href="{{ route('admin.exhibitors.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


