@extends('admin.layouts.app')

@section('title', 'إضافة جلسة جديدة')
@section('page-title', 'إضافة جلسة جديدة')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">إضافة جلسة جديدة</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.agenda-sessions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">اليوم المرتبط <span class="text-danger">*</span></label>
                <select name="agenda_day_id" class="form-select @error('agenda_day_id') is-invalid @enderror" required>
                    <option value="">{{ __('اختر اليوم') }}</option>
                    @foreach($agendaDays as $day)
                        <option value="{{ $day->id }}" {{ old('agenda_day_id') == $day->id ? 'selected' : '' }}>
                            {{ optional($day->conference)->title_ar }} - {{ optional($day->date)->format('Y-m-d') }} ({{ $day->title_ar }})
                        </option>
                    @endforeach
                </select>
                @error('agenda_day_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">عنوان الجلسة (عربي) <span class="text-danger">*</span></label>
                        <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}" required>
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">عنوان الجلسة (إنجليزي) <span class="text-danger">*</span></label>
                        <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" required>
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
                        <textarea name="description_ar" class="form-control rich-text-ar @error('description_ar') is-invalid @enderror" rows="4">{{ old('description_ar') }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الوصف (إنجليزي)</label>
                        <textarea name="description_en" class="form-control rich-text-en @error('description_en') is-invalid @enderror" rows="4">{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">المسرح / القاعة (عربي)</label>
                        <input type="text" name="stage_ar" class="form-control @error('stage_ar') is-invalid @enderror" value="{{ old('stage_ar') }}">
                        @error('stage_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">المسرح / القاعة (إنجليزي)</label>
                        <input type="text" name="stage_en" class="form-control @error('stage_en') is-invalid @enderror" value="{{ old('stage_en') }}">
                        @error('stage_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">وقت البداية <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">وقت النهاية <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" required>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">الترتيب</label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.agenda-sessions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i> رجوع
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection




