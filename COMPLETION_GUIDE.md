# دليل إكمال مشروع العهد - الخطوات النهائية

## ✅ ما تم إنجازه (100% مكتمل)

### 1. قاعدة البيانات والـ Models
- ✅ جميع الـ Migrations (15 جدول)
- ✅ جميع الـ Models مع العلاقات
- ✅ تشغيل الـ Migrations
- ✅ إنشاء مستخدم Admin

### 2. Controllers
- ✅ **ConferenceController** - مكتمل 100%
- ✅ **SpeakerController** - مكتمل 100%
- ✅ **SponsorController** - مكتمل 100%
- ✅ **StatisticController** - مكتمل 100%
- ✅ **ExhibitorController** - مكتمل 100%
- ✅ **AgendaDayController** - مكتمل 100%
- ✅ **AgendaSessionController** - مكتمل 100%
- ✅ **GalleryController** - مكتمل 100%
- ✅ **FaqController** - مكتمل 100%
- ✅ **ParticipantController** - مكتمل 100%
- ✅ **SettingController** - مكتمل 100%
- ✅ **DashboardController** - مكتمل 100%

### 3. Routes
- ✅ routes/admin.php مع جميع الـ Routes
- ✅ تسجيل Routes في bootstrap/app.php

### 4. Views للوحة التحكم
- ✅ admin/layouts/app.blade.php
- ✅ admin/dashboard.blade.php
- ✅ admin/conferences/index.blade.php
- ✅ admin/conferences/create.blade.php
- ✅ admin/conferences/edit.blade.php

## 📋 ما يجب إكماله

### 1. إنشاء باقي Views للوحة التحكم

يجب إنشاء Views لكل Controller. استخدم نفس النمط المستخدم في المؤتمرات:

#### A. Speakers Views
```bash
mkdir resources/views/admin/speakers
```

انسخ ملفات conferences وعدّل:
- `$conference` → `$speaker`
- `conferences` → `speakers`
- الحقول حسب جدول speakers

#### B. Sponsors Views
```bash
mkdir resources/views/admin/sponsors
```

الحقول المطلوبة:
- conference_id (dropdown)
- name_ar, name_en
- logo (file upload)
- website (url)
- type (dropdown: platinum, gold, silver, bronze, partner)
- order

#### C. Statistics Views
```bash
mkdir resources/views/admin/statistics
```

الحقول:
- conference_id
- label_ar, label_en
- value
- icon (اختياري - Font Awesome class)
- order

#### D. Exhibitors Views
```bash
mkdir resources/views/admin/exhibitors
```

الحقول:
- conference_id
- name_ar, name_en
- description_ar, description_en (textarea)
- logo (file upload)
- website
- booth_number
- order

#### E. Agenda Days Views
```bash
mkdir resources/views/admin/agenda-days
```

الحقول:
- conference_id
- date (date picker)
- title_ar, title_en
- description_ar, description_en
- order

#### F. Agenda Sessions Views
```bash
mkdir resources/views/admin/agenda-sessions
```

الحقول:
- agenda_day_id (dropdown)
- title_ar, title_en
- description_ar, description_en
- stage_ar, stage_en
- start_time, end_time (time picker)
- order

#### G. Galleries Views
```bash
mkdir resources/views/admin/galleries
```

الحقول:
- conference_id
- title_ar, title_en
- image (file upload)
- type (dropdown: image, video)
- order

#### H. FAQs Views
```bash
mkdir resources/views/admin/faqs
```

الحقول:
- conference_id
- question_ar, question_en (textarea)
- answer_ar, answer_en (textarea)
- order

#### I. Participants View
```bash
mkdir resources/views/admin/participants
```

فقط index.blade.php (عرض فقط):
- name, email, phone
- company, job_title
- type
- conference
- created_at

#### J. Settings View
```bash
mkdir resources/views/admin/settings
```

index.blade.php فقط:
- عرض جميع الإعدادات مجمعة حسب group
- نموذج لتحديث القيم
- زر لإضافة إعداد جديد

### 2. إنشاء رابط التخزين

```bash
php artisan storage:link
```

### 3. نقل Assets من biban

```bash
# في PowerShell
xcopy biban\assets public\assets /E /I /Y

# أو يدوياً:
# انسخ مجلد biban/assets إلى public/assets
```

### 4. إنشاء الواجهة الأمامية

#### A. إنشاء Frontend Controllers

```bash
php artisan make:controller Frontend/HomeController
php artisan make:controller Frontend/AboutController
php artisan make:controller Frontend/SpeakersController
php artisan make:controller Frontend/ExhibitorsController
php artisan make:controller Frontend/RegistrationController
```

#### B. تطبيق Controllers

في `app/Http/Controllers/Frontend/HomeController.php`:
```php
public function index()
{
    $conference = Conference::active()->with(['speakers', 'sponsors', 'statistics'])->first();
    return view('frontend.home', compact('conference'));
}

public function prevEditions()
{
    $conferences = Conference::inactive()->orderBy('start_date', 'desc')->get();
    return view('frontend.prev-editions', compact('conferences'));
}
```

#### C. إنشاء Frontend Views

```bash
mkdir resources/views/frontend
```

الملفات المطلوبة:
- layouts/app.blade.php (Layout رئيسي)
- home.blade.php
- about.blade.php
- speakers.blade.php
- exhibitors.blade.php
- registration.blade.php
- prev-editions.blade.php

#### D. تحديث Routes

في `routes/web.php`:
```php
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\SpeakersController;
use App\Http\Controllers\Frontend\ExhibitorsController;
use App\Http\Controllers\Frontend\RegistrationController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/speakers', [SpeakersController::class, 'index'])->name('speakers');
Route::get('/exhibitors', [ExhibitorsController::class, 'index'])->name('exhibitors');
Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/prev-editions', [HomeController::class, 'prevEditions'])->name('prev-editions');
```

### 5. نظام اللغات

#### A. إنشاء Middleware

```bash
php artisan make:middleware SetLocale
```

في `app/Http/Middleware/SetLocale.php`:
```php
public function handle($request, Closure $next)
{
    $locale = session('locale', config('app.locale'));
    app()->setLocale($locale);
    return $next($request);
}
```

#### B. تسجيل Middleware

في `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\SetLocale::class,
    ]);
})
```

#### C. Route للتبديل بين اللغات

```php
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
```

## 🚀 اختبار المشروع

### 1. تشغيل السيرفر

```bash
php artisan serve
```

### 2. الوصول للوحة التحكم

```
URL: http://localhost:8000/admin
Email: admin@alahed.com
Password: password
```

### 3. خطوات الاختبار

1. تسجيل الدخول للوحة التحكم
2. إضافة مؤتمر جديد
3. تفعيل المؤتمر
4. إضافة متحدثين، رعاة، إحصائيات
5. زيارة الصفحة الرئيسية للتأكد من ظهور البيانات

## 📝 ملاحظات مهمة

1. **جميع Controllers جاهزة ومكتملة 100%**
2. **يجب فقط إنشاء Views باستخدام نفس النمط**
3. **استخدم Bootstrap RTL للتصميم**
4. **احفظ الصور في storage/app/public/**
5. **استخدم {{ asset('storage/...') }} لعرض الصور**

## 🎯 الأولويات

1. **أولاً**: إنشاء Views للوحة التحكم (نسخ وتعديل من conferences)
2. **ثانياً**: نقل Assets ونشاء الواجهة الأمامية
3. **ثالثاً**: تطبيق نظام اللغات
4. **رابعاً**: الاختبار النهائي

جميع الـ Controllers جاهزة ومكتملة! فقط قم بإنشاء الـ Views وستكون جاهزاً! 🎉

