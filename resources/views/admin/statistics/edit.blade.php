@extends('admin.layouts.app')

@section('title', 'تعديل إحصائية')
@section('page-title', 'تعديل إحصائية')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">تعديل إحصائية: {{ $statistic->label_ar }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.statistics.update', $statistic) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="conference_id" class="form-label">المؤتمر <span class="text-danger">*</span></label>
                    <select name="conference_id" id="conference_id" class="form-control @error('conference_id') is-invalid @enderror" required>
                        <option value="">اختر المؤتمر</option>
                        @foreach(\App\Models\Conference::orderBy('title_ar')->get() as $conference)
                            <option value="{{ $conference->id }}" {{ old('conference_id', $statistic->conference_id) == $conference->id ? 'selected' : '' }}>
                                {{ $conference->title_ar }}
                            </option>
                        @endforeach
                    </select>
                    @error('conference_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="label_ar" class="form-label">النص (عربي) <span class="text-danger">*</span></label>
                    <input type="text" name="label_ar" id="label_ar" class="form-control @error('label_ar') is-invalid @enderror" value="{{ old('label_ar', $statistic->label_ar) }}" required>
                    @error('label_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="label_en" class="form-label">النص (إنجليزي) <span class="text-danger">*</span></label>
                    <input type="text" name="label_en" id="label_en" class="form-control @error('label_en') is-invalid @enderror" value="{{ old('label_en', $statistic->label_en) }}" required>
                    @error('label_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="value" class="form-label">القيمة <span class="text-danger">*</span></label>
                    <input type="text" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $statistic->value) }}" required>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="icon" class="form-label">الأيقونة (اختياري)</label>
                    <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $statistic->icon) }}" placeholder="مثال: fas fa-users">
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">استخدم اسم الأيقونة من Font Awesome.</small>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $statistic->order) }}">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> تحديث
                </button>
                <a href="{{ route('admin.statistics.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


