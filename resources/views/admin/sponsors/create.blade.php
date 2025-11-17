@extends('admin.layouts.app')

@section('title', 'إضافة راعي جديد')
@section('page-title', 'إضافة راعي جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">إضافة راعي جديد</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Conference Selection -->
                <div class="col-md-12 mb-3">
                    <label for="conference_id" class="form-label">المؤتمر <span class="text-danger">*</span></label>
                    <select name="conference_id" id="conference_id" class="form-control @error('conference_id') is-invalid @enderror" required>
                        <option value="">اختر المؤتمر</option>
                        @foreach($conferences as $conference)
                            <option value="{{ $conference->id }}" {{ old('conference_id') == $conference->id ? 'selected' : '' }}>
                                {{ $conference->title_ar }}
                            </option>
                        @endforeach
                    </select>
                    @error('conference_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Name Arabic -->
                <div class="col-md-6 mb-3">
                    <label for="name_ar" class="form-label">اسم الراعي (عربي) <span class="text-danger">*</span></label>
                    <input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}" required>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Name English -->
                <div class="col-md-6 mb-3">
                    <label for="name_en" class="form-label">اسم الراعي (إنجليزي) <span class="text-danger">*</span></label>
                    <input type="text" name="name_en" id="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">نوع الرعاية <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="">اختر نوع الرعاية</option>
                        <option value="platinum" {{ old('type') == 'platinum' ? 'selected' : '' }}>بلاتيني</option>
                        <option value="gold" {{ old('type') == 'gold' ? 'selected' : '' }}>ذهبي</option>
                        <option value="silver" {{ old('type') == 'silver' ? 'selected' : '' }}>فضي</option>
                        <option value="bronze" {{ old('type') == 'bronze' ? 'selected' : '' }}>برونزي</option>
                        <option value="partner" {{ old('type') == 'partner' ? 'selected' : '' }}>شريك</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Website -->
                <div class="col-md-6 mb-3">
                    <label for="website" class="form-label">رابط الموقع</label>
                    <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Logo -->
                <div class="col-md-6 mb-3">
                    <label for="logo" class="form-label">شعار الراعي <span class="text-danger">*</span></label>
                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" required>
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">الحد الأقصى: 2 ميجابايت</small>
                </div>

                <!-- Order -->
                <div class="col-md-6 mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">الرقم الأصغر يظهر أولاً</small>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ
                </button>
                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

