@extends('admin.layouts.app')

@section('title', 'تعديل متحدث')
@section('page-title', 'تعديل متحدث')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">تعديل متحدث: {{ $speaker->name_ar }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.speakers.update', $speaker) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Conference Selection -->
                <div class="col-md-12 mb-3">
                    <label for="conference_id" class="form-label">المؤتمر <span class="text-danger">*</span></label>
                    <select name="conference_id" id="conference_id" class="form-control @error('conference_id') is-invalid @enderror" required>
                        <option value="">اختر المؤتمر</option>
                        @foreach($conferences as $conference)
                            <option value="{{ $conference->id }}" {{ old('conference_id', $speaker->conference_id) == $conference->id ? 'selected' : '' }}>
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
                    <label for="name_ar" class="form-label">الاسم (عربي) <span class="text-danger">*</span></label>
                    <input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $speaker->name_ar) }}" required>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Name English -->
                <div class="col-md-6 mb-3">
                    <label for="name_en" class="form-label">الاسم (إنجليزي) <span class="text-danger">*</span></label>
                    <input type="text" name="name_en" id="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $speaker->name_en) }}" required>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title Arabic -->
                <div class="col-md-6 mb-3">
                    <label for="title_ar" class="form-label">المسمى الوظيفي (عربي)</label>
                    <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $speaker->title_ar) }}">
                    @error('title_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title English -->
                <div class="col-md-6 mb-3">
                    <label for="title_en" class="form-label">المسمى الوظيفي (إنجليزي)</label>
                    <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $speaker->title_en) }}">
                    @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Company Arabic -->
                <div class="col-md-6 mb-3">
                    <label for="company_ar" class="form-label">الشركة (عربي)</label>
                    <input type="text" name="company_ar" id="company_ar" class="form-control @error('company_ar') is-invalid @enderror" value="{{ old('company_ar', $speaker->company_ar) }}">
                    @error('company_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Company English -->
                <div class="col-md-6 mb-3">
                    <label for="company_en" class="form-label">الشركة (إنجليزي)</label>
                    <input type="text" name="company_en" id="company_en" class="form-control @error('company_en') is-invalid @enderror" value="{{ old('company_en', $speaker->company_en) }}">
                    @error('company_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bio Arabic -->
                <div class="col-md-6 mb-3">
                    <label for="bio_ar" class="form-label">السيرة الذاتية (عربي)</label>
                    <textarea name="bio_ar" id="bio_ar" rows="4" class="form-control rich-text-ar @error('bio_ar') is-invalid @enderror">{{ old('bio_ar', $speaker->bio_ar) }}</textarea>
                    @error('bio_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bio English -->
                <div class="col-md-6 mb-3">
                    <label for="bio_en" class="form-label">السيرة الذاتية (إنجليزي)</label>
                    <textarea name="bio_en" id="bio_en" rows="4" class="form-control rich-text-en @error('bio_en') is-invalid @enderror">{{ old('bio_en', $speaker->bio_en) }}</textarea>
                    @error('bio_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- LinkedIn -->
                <div class="col-md-4 mb-3">
                    <label for="linkedin" class="form-label">رابط LinkedIn</label>
                    <input type="url" name="linkedin" id="linkedin" class="form-control @error('linkedin') is-invalid @enderror" value="{{ old('linkedin', $speaker->linkedin) }}" placeholder="https://linkedin.com/in/...">
                    @error('linkedin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- X (Twitter) -->
                <div class="col-md-4 mb-3">
                    <label for="twitter" class="form-label">رابط X (تويتر)</label>
                    <input type="url" name="twitter" id="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ old('twitter', $speaker->twitter) }}" placeholder="https://twitter.com/...">
                    @error('twitter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Facebook -->
                <div class="col-md-4 mb-3">
                    <label for="facebook" class="form-label">رابط Facebook</label>
                    <input type="url" name="facebook" id="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', $speaker->facebook) }}" placeholder="https://facebook.com/...">
                    @error('facebook')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Current Image -->
                @if($speaker->image)
                <div class="col-md-12 mb-3">
                    <label class="form-label">الصورة الحالية</label>
                    <div>
                        <img src="{{ asset('storage/' . $speaker->image) }}" alt="{{ $speaker->name_ar }}" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                </div>
                @endif

                <!-- Image -->
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">تغيير الصورة الشخصية</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">الحد الأقصى: 2 ميجابايت</small>
                </div>

                <!-- Order -->
                <div class="col-md-6 mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $speaker->order) }}">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> تحديث
                </button>
                <a href="{{ route('admin.speakers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

