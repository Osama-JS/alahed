@extends('admin.layouts.app')

@section('title', 'إضافة بوث جديد')
@section('page-title', 'إضافة بوث جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">إضافة بوث جديد</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.exhibition-booths.store') }}" method="POST" enctype="multipart/form-data">
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

                <!-- Name -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">اسم البوث <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="مثال: بوث A1">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">نوع البوث <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="">اختر نوع البوث</option>
                        <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>عادي</option>
                        <option value="premium" {{ old('type') == 'premium' ? 'selected' : '' }}>مميز</option>
                        <option value="strategic" {{ old('type') == 'strategic' ? 'selected' : '' }}>استراتيجي</option>
                        <option value="main" {{ old('type') == 'main' ? 'selected' : '' }}>رئيسي</option>
                        <option value="gold" {{ old('type') == 'gold' ? 'selected' : '' }}>ذهبي</option>
                        <option value="silver" {{ old('type') == 'silver' ? 'selected' : '' }}>فضي</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Exhibitor -->
                <div class="col-md-6 mb-3">
                    <label for="exhibitor_id" class="form-label">العارض (اختياري)</label>
                    <select name="exhibitor_id" id="exhibitor_id" class="form-control @error('exhibitor_id') is-invalid @enderror">
                        <option value="">لا يوجد عارض</option>
                        @foreach($exhibitors as $exhibitor)
                            <option value="{{ $exhibitor->id }}" {{ old('exhibitor_id') == $exhibitor->id ? 'selected' : '' }}>
                                {{ $exhibitor->name_ar }}
                            </option>
                        @endforeach
                    </select>
                    @error('exhibitor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">يمكن ربط البوث بعارض معين أو تركه فارغاً</small>
                </div>

                <!-- Width -->
                <div class="col-md-4 mb-3">
                    <label for="width" class="form-label">العرض (متر)</label>
                    <input type="number" step="0.01" name="width" id="width" class="form-control @error('width') is-invalid @enderror" value="{{ old('width') }}" placeholder="4.00">
                    @error('width')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Height -->
                <div class="col-md-4 mb-3">
                    <label for="height" class="form-label">الطول (متر)</label>
                    <input type="number" step="0.01" name="height" id="height" class="form-control @error('height') is-invalid @enderror" value="{{ old('height') }}" placeholder="4.00">
                    @error('height')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">المساحة ستحسب تلقائياً</small>
                </div>

                <!-- Area -->
                <div class="col-md-4 mb-3">
                    <label for="area" class="form-label">المساحة (م²)</label>
                    <input type="number" step="0.01" name="area" id="area" class="form-control @error('area') is-invalid @enderror" value="{{ old('area') }}" placeholder="16.00">
                    @error('area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">اختياري إذا تم إدخال العرض والطول</small>
                </div>

                <!-- Price -->
                <div class="col-md-4 mb-3">
                    <label for="price" class="form-label">السعر بعد الضريبة <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 0) }}" required placeholder="11000.00">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">السعر الإجمالي (يشمل الضريبة إن وُجدت)</small>
                </div>

                <!-- Price Before VAT (optional) -->
                <div class="col-md-4 mb-3">
                    <label for="price_before_vat" class="form-label">السعر قبل الضريبة (اختياري)</label>
                    <input type="number" step="0.01" name="price_before_vat" id="price_before_vat" class="form-control @error('price_before_vat') is-invalid @enderror" value="{{ old('price_before_vat') }}" placeholder="10000.00">
                    @error('price_before_vat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">اتركه فارغاً إذا لم ترغب في تخزين السعر قبل الضريبة</small>
                </div>

                <!-- Currency -->
                <div class="col-md-4 mb-3">
                    <label for="currency" class="form-label">العملة</label>
                    <input type="text" name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror" value="{{ old('currency', 'SAR') }}" placeholder="SAR">
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>متاح</option>
                        <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>محجوز</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

                <!-- Image -->
                <div class="col-md-12 mb-3">
                    <label for="image" class="form-label">صورة البوث</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">الحد الأقصى: 2 ميجابايت</small>
                </div>

                <!-- Description Arabic -->
                <div class="col-md-6 mb-3">
                    <label for="description_ar" class="form-label">الوصف (عربي)</label>
                    <textarea name="description_ar" id="description_ar" rows="4" class="form-control rich-text-ar @error('description_ar') is-invalid @enderror">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description English -->
                <div class="col-md-6 mb-3">
                    <label for="description_en" class="form-label">الوصف (إنجليزي)</label>
                    <textarea name="description_en" id="description_en" rows="4" class="form-control rich-text-en @error('description_en') is-invalid @enderror">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ
                </button>
                <a href="{{ route('admin.exhibition-booths.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

