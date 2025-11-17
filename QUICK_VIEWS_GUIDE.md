# دليل سريع لإنشاء Views

## طريقة سريعة لإنشاء جميع Views

### الخطوة 1: إنشاء المجلدات

```bash
mkdir resources\views\admin\speakers
mkdir resources\views\admin\sponsors
mkdir resources\views\admin\statistics
mkdir resources\views\admin\exhibitors
mkdir resources\views\admin\agenda-days
mkdir resources\views\admin\agenda-sessions
mkdir resources\views\admin\galleries
mkdir resources\views\admin\faqs
mkdir resources\views\admin\participants
mkdir resources\views\admin\settings
```

### الخطوة 2: نسخ ملفات conferences

لكل مجلد، انسخ الملفات الثلاثة من conferences:

```bash
# مثال للـ Speakers
copy resources\views\admin\conferences\index.blade.php resources\views\admin\speakers\index.blade.php
copy resources\views\admin\conferences\create.blade.php resources\views\admin\speakers\create.blade.php
copy resources\views\admin\conferences\edit.blade.php resources\views\admin\speakers\edit.blade.php
```

### الخطوة 3: البحث والاستبدال

في كل ملف، استبدل:

#### للـ Speakers:
- `conferences` → `speakers`
- `conference` → `speaker`
- `المؤتمرات` → `المتحدثون`
- `المؤتمر` → `المتحدث`
- `مؤتمر` → `متحدث`

#### للـ Sponsors:
- `conferences` → `sponsors`
- `conference` → `sponsor`
- `المؤتمرات` → `الرعاة`
- `المؤتمر` → `الراعي`
- `مؤتمر` → `راعي`

وهكذا...

---

## مثال كامل: Speakers Index

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
                        <th>المؤتمر</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($speakers as $speaker)
                    <tr>
                        <td>{{ $speaker->id }}</td>
                        <td>
                            @if($speaker->image)
                                <img src="{{ asset('storage/' . $speaker->image) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @endif
                        </td>
                        <td>{{ $speaker->name_ar }}</td>
                        <td>{{ $speaker->conference->title_ar ?? 'N/A' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.speakers.edit', $speaker) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.speakers.destroy', $speaker) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
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
        {{ $speakers->links() }}
        @else
        <div class="alert alert-info">
            لا يوجد متحدثون. <a href="{{ route('admin.speakers.create') }}">إضافة متحدث</a>
        </div>
        @endif
    </div>
</div>
@endsection
```

---

## الحقول المطلوبة لكل Model

### Speakers
```html
<select name="conference_id" required>...</select>
<input name="name_ar" required>
<input name="name_en" required>
<input name="title_ar">
<input name="title_en">
<textarea name="bio_ar"></textarea>
<textarea name="bio_en"></textarea>
<input type="file" name="image">
<input name="company_ar">
<input name="company_en">
<input name="linkedin" type="url">
<input name="twitter" type="url">
<input name="facebook" type="url">
<input name="order" type="number">
```

### Sponsors
```html
<select name="conference_id" required>...</select>
<input name="name_ar" required>
<input name="name_en" required>
<input type="file" name="logo" required>
<input name="website" type="url">
<select name="type" required>
    <option value="platinum">بلاتيني</option>
    <option value="gold">ذهبي</option>
    <option value="silver">فضي</option>
    <option value="bronze">برونزي</option>
    <option value="partner">شريك</option>
</select>
<input name="order" type="number">
```

### Statistics
```html
<select name="conference_id" required>...</select>
<input name="label_ar" required>
<input name="label_en" required>
<input name="value" required>
<input name="icon" placeholder="fas fa-users">
<input name="order" type="number">
```

### Exhibitors
```html
<select name="conference_id" required>...</select>
<input name="name_ar" required>
<input name="name_en" required>
<textarea name="description_ar"></textarea>
<textarea name="description_en"></textarea>
<input type="file" name="logo">
<input name="website" type="url">
<input name="booth_number">
<input name="order" type="number">
```

### Galleries
```html
<select name="conference_id" required>...</select>
<input name="title_ar">
<input name="title_en">
<input type="file" name="image" required>
<select name="type" required>
    <option value="image">صورة</option>
    <option value="video">فيديو</option>
</select>
<input name="order" type="number">
```

### FAQs
```html
<select name="conference_id" required>...</select>
<textarea name="question_ar" required></textarea>
<textarea name="question_en" required></textarea>
<textarea name="answer_ar" required></textarea>
<textarea name="answer_en" required></textarea>
<input name="order" type="number">
```

---

## نصيحة ذهبية 💡

استخدم Find & Replace في محرر النصوص:
1. افتح ملف conferences/index.blade.php
2. اضغط Ctrl+H
3. استبدل جميع `conference` بـ `speaker` (مثلاً)
4. احفظ باسم جديد

**وفّر ساعات من العمل!** 🚀

