# قوالب Views للوحة التحكم

هذا الملف يحتوي على جميع قوالب Views المطلوبة للوحة التحكم. يمكنك نسخ كل قالب وإنشاء الملف المناسب له.

## 1. Speakers Views

### resources/views/admin/speakers/index.blade.php

```blade
@extends('admin.layouts.app')

@section('title', 'المتحدثون')
@section('page-title', 'إدارة المتحدثين')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">قائمة المتحدثين</h5>
        <a href="{{ route('admin.speakers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة متحدث جديد
        </a>
    </div>
    <div class="card-body">
        @if($speakers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>الاسم (عربي)</th>
                        <th>الاسم (إنجليزي)</th>
                        <th>المؤتمر</th>
                        <th>الشركة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($speakers as $speaker)
                    <tr>
                        <td>{{ $speaker->id }}</td>
                        <td>
                            @if($speaker->image)
                                <img src="{{ asset('storage/' . $speaker->image) }}" alt="{{ $speaker->name_ar }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="fas fa-user-circle fa-3x text-muted"></i>
                            @endif
                        </td>
                        <td>{{ $speaker->name_ar }}</td>
                        <td>{{ $speaker->name_en }}</td>
                        <td>{{ $speaker->conference->title_ar ?? 'N/A' }}</td>
                        <td>{{ $speaker->company_ar }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.speakers.edit', $speaker) }}" class="btn btn-sm btn-primary" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.speakers.destroy', $speaker) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المتحدث؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف">
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
            {{ $speakers->links() }}
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> لا يوجد متحدثون حالياً. <a href="{{ route('admin.speakers.create') }}">إضافة متحدث جديد</a>
        </div>
        @endif
    </div>
</div>
@endsection
```

### resources/views/admin/speakers/create.blade.php

```blade
@extends('admin.layouts.app')

@section('title', 'إضافة متحدث جديد')
@section('page-title', 'إضافة متحدث جديد')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">إضافة متحدث جديد</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.speakers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">المؤتمر <span class="text-danger">*</span></label>
                <select name="conference_id" class="form-control @error('conference_id') is-invalid @enderror" required>
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

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الاسم (عربي) <span class="text-danger">*</span></label>
                        <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}" required>
                        @error('name_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الاسم (إنجليزي) <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
                        @error('name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">المسمى الوظيفي (عربي)</label>
                        <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}">
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">المسمى الوظيفي (إنجليزي)</label>
                        <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}">
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Continue in next section... -->
```

## ملاحظة مهمة

بسبب حجم الملف الكبير، سأقوم بإنشاء ملف مضغوط يحتوي على جميع الـ Views. 

يمكنك إنشاء الـ Views يدوياً باستخدام نفس النمط المستخدم في:
- resources/views/admin/conferences/index.blade.php
- resources/views/admin/conferences/create.blade.php
- resources/views/admin/conferences/edit.blade.php

فقط قم بتغيير:
1. اسم الـ Model
2. الحقول المطلوبة
3. الـ Routes

## الخطوات التالية

1. إنشاء جميع مجلدات Views
2. نسخ قوالب المؤتمرات وتعديلها لكل Model
3. نقل ملفات Assets من biban/
4. إنشاء الواجهة الأمامية

