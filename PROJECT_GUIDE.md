# دليل مشروع العهد لتنظيم المعارض والمؤتمرات

## نظرة عامة على المشروع

هذا مشروع Laravel 12 كامل لإدارة المعارض والمؤتمرات، مبني على قالب Biban HTML الموجود في مجلد `biban/`.

## ما تم إنجازه حتى الآن ✅

### 1. قاعدة البيانات
- ✅ تم إنشاء جميع الـ Migrations (15 جدول)
- ✅ تم إنشاء جميع الـ Models مع العلاقات
- ✅ تم تشغيل الـ Migrations بنجاح
- ✅ تم إنشاء مستخدم Admin (admin@alahed.com / password)

**الجداول المنشأة:**
- conferences (المؤتمرات)
- speakers (المتحدثون)
- sponsors (الرعاة)
- statistics (الإحصائيات)
- participants (المشاركون)
- agenda_days (أيام جدول الأعمال)
- agenda_sessions (جلسات جدول الأعمال)
- doors (الأبواب)
- exhibitors (العارضون)
- galleries (المعرض)
- faqs (الأسئلة الشائعة)
- settings (الإعدادات)

### 2. نظام المصادقة
- ✅ تم تثبيت Laravel Breeze
- ✅ تم إنشاء نظام تسجيل الدخول

### 3. لوحة التحكم الإدارية
- ✅ تم إنشاء جميع الـ Controllers (14 controller)
- ✅ تم إنشاء ملف routes/admin.php
- ✅ تم إنشاء Layout للوحة التحكم
- ✅ تم إنشاء صفحة Dashboard
- ✅ تم إنشاء صفحات CRUD كاملة للمؤتمرات (index, create, edit)
- ✅ تم تطبيق ConferenceController بالكامل

## ما يجب إكماله 📋

### 1. إكمال Controllers للوحة التحكم

يجب إكمال الـ Controllers التالية بنفس طريقة ConferenceController:

#### A. SpeakerController
- index: عرض قائمة المتحدثين
- create: نموذج إضافة متحدث
- store: حفظ متحدث جديد
- edit: نموذج تعديل متحدث
- update: تحديث متحدث
- destroy: حذف متحدث

#### B. SponsorController
- نفس الوظائف أعلاه للرعاة

#### C. StatisticController
- نفس الوظائف أعلاه للإحصائيات

#### D. ExhibitorController
- نفس الوظائف أعلاه للعارضين

#### E. AgendaDayController & AgendaSessionController
- إدارة أيام وجلسات جدول الأعمال

#### F. GalleryController
- إدارة صور ومقاطع المعرض

#### G. FaqController
- إدارة الأسئلة الشائعة

#### H. ParticipantController
- عرض وإدارة المشاركين

#### I. SettingController
- index: عرض الإعدادات
- update: تحديث الإعدادات

### 2. إنشاء Views للوحة التحكم

يجب إنشاء Views لكل Controller:

```
resources/views/admin/
├── speakers/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── sponsors/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── statistics/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── exhibitors/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── agenda-days/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── agenda-sessions/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── galleries/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── faqs/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── participants/
│   └── index.blade.php
└── settings/
    └── index.blade.php
```

### 3. نقل الأصول (Assets)

يجب نقل ملفات القالب من `biban/` إلى `public/`:

```bash
# نقل مجلد assets
cp -r biban/assets public/

# أو يدوياً:
# نسخ biban/assets إلى public/assets
```

### 4. إنشاء الواجهة الأمامية

يجب إنشاء Controllers والـ Views للواجهة الأمامية:

#### Controllers:
- HomeController: الصفحة الرئيسية
- AboutController: صفحة من نحن
- SpeakersController: صفحة المتحدثين
- RegistrationController: صفحة التسجيل

#### Views:
```
resources/views/
├── layouts/
│   └── app.blade.php (Layout رئيسي)
├── home.blade.php
├── about.blade.php
├── speakers.blade.php
├── exhibitors.blade.php
├── registration.blade.php
└── prev-editions.blade.php
```

### 5. تطبيق نظام اللغات

```php
// في config/app.php
'locale' => 'ar',
'fallback_locale' => 'ar',
'available_locales' => ['ar', 'en'],
```

إنشاء Middleware للغات:
```bash
php artisan make:middleware SetLocale
```

### 6. Routes للواجهة الأمامية

في `routes/web.php`:
```php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\SpeakersController;
use App\Http\Controllers\RegistrationController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/speakers', [SpeakersController::class, 'index'])->name('speakers');
Route::get('/exhibitors', [ExhibitorsController::class, 'index'])->name('exhibitors');
Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/prev-editions', [HomeController::class, 'prevEditions'])->name('prev-editions');

// Language Switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
```

## تعليمات التشغيل

### 1. تشغيل المشروع

```bash
# تشغيل السيرفر
php artisan serve

# في نافذة أخرى: تشغيل Vite
npm run dev
```

### 2. الوصول للوحة التحكم

```
URL: http://localhost:8000/admin
Email: admin@alahed.com
Password: password
```

### 3. إنشاء رابط تخزين للصور

```bash
php artisan storage:link
```

## ملاحظات مهمة

1. **المؤتمر النشط**: يمكن تفعيل مؤتمر واحد فقط في كل مرة
2. **الصور**: يتم حفظ الصور في `storage/app/public/`
3. **اللغات**: النظام يدعم العربية والإنجليزية
4. **التصميم**: يجب الحفاظ على تصميم قالب Biban الأصلي

## الخطوات التالية الموصى بها

1. إكمال جميع Controllers والـ Views للوحة التحكم
2. نقل ملفات Assets من biban إلى public
3. إنشاء الواجهة الأمامية باستخدام Blade Templates
4. تطبيق نظام اللغات
5. اختبار جميع الوظائف
6. إضافة Validation Rules
7. إضافة Form Requests للتحقق من البيانات
8. تحسين الأمان والأداء

