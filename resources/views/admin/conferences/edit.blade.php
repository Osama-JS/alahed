@extends('admin.layouts.app')

@section('title', 'تعديل مؤتمر')
@section('page-title', 'تعديل مؤتمر')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">تعديل مؤتمر: {{ $conference->title_ar }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.conferences.update', $conference) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">العنوان (عربي) <span class="text-danger">*</span></label>
                        <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $conference->title_ar) }}" required>
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">العنوان (إنجليزي) <span class="text-danger">*</span></label>
                        <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $conference->title_en) }}" required>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الوصف (عربي)</label>
                        <textarea name="description_ar" class="form-control rich-text-ar @error('description_ar') is-invalid @enderror" rows="4">{{ old('description_ar', $conference->description_ar) }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الوصف (إنجليزي)</label>
                        <textarea name="description_en" class="form-control rich-text-en @error('description_en') is-invalid @enderror" rows="4">{{ old('description_en', $conference->description_en) }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">تاريخ البداية <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $conference->start_date->format('Y-m-d')) }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">تاريخ النهاية <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $conference->end_date->format('Y-m-d')) }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">وقت البداية</label>
                        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $conference->start_time) }}">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">وقت النهاية</label>
                        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $conference->end_time) }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الموقع (عربي)</label>
                        <input type="text" name="location_ar" class="form-control @error('location_ar') is-invalid @enderror" value="{{ old('location_ar', $conference->location_ar) }}">
                        @error('location_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الموقع (إنجليزي)</label>
                        <input type="text" name="location_en" class="form-control @error('location_en') is-invalid @enderror" value="{{ old('location_en', $conference->location_en) }}">
                        @error('location_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">رابط خريطة موقع المؤتمر (Map URL)</label>
                        <input type="text" name="map_url" class="form-control @error('map_url') is-invalid @enderror" value="{{ old('map_url', $conference->map_url) }}" placeholder="مثال: رابط Google Maps embed">
                        @error('map_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">فيديو البطل (Hero Video)</label>
                        <input type="file" name="hero_video_url" class="form-control @error('hero_video_url') is-invalid @enderror" accept="video/*">
                        @if($conference->hero_video_url)
                            <small class="text-muted d-block mt-1">الفيديو الحالي: {{ basename($conference->hero_video_url) }}</small>
                        @endif
                        @error('hero_video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">الحد الأقصى لحجم ملف الفيديو 30 ميجا تقريباً.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">صورة البطل (Hero Image)</label>
                        <input type="file" name="hero_image" class="form-control @error('hero_image') is-invalid @enderror" accept="image/*">
                        @if($conference->hero_image)
                            <small class="text-muted">الصورة الحالية: {{ basename($conference->hero_image) }}</small>
                        @endif
                        @error('hero_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">شعار المؤتمر (Logo)</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                        @if($conference->logo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $conference->logo) }}" alt="Conference Logo" class="img-thumbnail" style="max-width: 160px;">
                            </div>
                            <small class="text-muted">الشعار الحالي: {{ basename($conference->logo) }}</small>
                        @endif
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">يفضّل تحميل شعار بجودة عالية وخلفية شفافة إن أمكن.</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">صورة مخطط المعرض (Floor Plan Image)</label>
                        <input type="file" name="floor_plan_image" class="form-control @error('floor_plan_image') is-invalid @enderror" accept="image/*">
                        @if($conference->floor_plan_image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $conference->floor_plan_image) }}" alt="Floor Plan" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            <small class="text-muted">الصورة الحالية: {{ basename($conference->floor_plan_image) }}</small>
                        @endif
                        @error('floor_plan_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">صورة توضح مخطط المعرض والبوثات المتاحة</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الترتيب</label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $conference->order) }}">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.conferences.index') }}" class="btn btn-secondary">
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

