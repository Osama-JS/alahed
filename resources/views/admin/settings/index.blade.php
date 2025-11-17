@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('title', $locale === 'ar' ? 'إعدادات النظام' : 'System Settings')
@section('page-title', $locale === 'ar' ? 'إدارة الإعدادات العامة' : 'Manage Global Settings')

@section('content')
@php
    $labels = [
        'site_logo' => ['ar' => 'شعار الموقع', 'en' => 'Site Logo'],
        'site_favicon' => ['ar' => 'أيقونة الموقع', 'en' => 'Site Favicon'],
        'site_name_ar' => ['ar' => 'اسم الموقع (عربي)', 'en' => 'Site Name (Arabic)'],
        'site_name_en' => ['ar' => 'اسم الموقع (إنجليزي)', 'en' => 'Site Name (English)'],
        'about_company_ar' => ['ar' => 'عن الشركة (عربي)', 'en' => 'About Company (Arabic)'],
        'about_company_en' => ['ar' => 'عن الشركة (إنجليزي)', 'en' => 'About Company (English)'],
        'short_description_ar' => ['ar' => 'الوصف المختصر (عربي)', 'en' => 'Short Description (Arabic)'],
        'short_description_en' => ['ar' => 'الوصف المختصر (إنجليزي)', 'en' => 'Short Description (English)'],
        'seo_keywords_ar' => ['ar' => 'الكلمات المفتاحية (عربي)', 'en' => 'SEO Keywords (Arabic)'],
        'seo_keywords_en' => ['ar' => 'الكلمات المفتاحية (إنجليزي)', 'en' => 'SEO Keywords (English)'],
        'meta_description_ar' => ['ar' => 'وصف محركات البحث (عربي)', 'en' => 'Meta Description (Arabic)'],
        'meta_description_en' => ['ar' => 'وصف محركات البحث (إنجليزي)', 'en' => 'Meta Description (English)'],
        'contact_email' => ['ar' => 'البريد الإلكتروني', 'en' => 'Contact Email'],
        'contact_phone' => ['ar' => 'رقم التواصل', 'en' => 'Contact Phone'],
        'contact_address_ar' => ['ar' => 'العنوان (عربي)', 'en' => 'Address (Arabic)'],
        'contact_address_en' => ['ar' => 'العنوان (إنجليزي)', 'en' => 'Address (English)'],
        'facebook_url' => ['ar' => 'رابط فيسبوك', 'en' => 'Facebook URL'],
        'twitter_url' => ['ar' => 'رابط X (تويتر)', 'en' => 'X (Twitter) URL'],
        'linkedin_url' => ['ar' => 'رابط لينكدإن', 'en' => 'LinkedIn URL'],
        'youtube_url' => ['ar' => 'رابط يوتيوب', 'en' => 'YouTube URL'],
        'instagram_url' => ['ar' => 'رابط إنستغرام', 'en' => 'Instagram URL'],
    ];

    $groups = [
        'branding' => ['ar' => 'الهوية البصرية', 'en' => 'Branding'],
        'content' => ['ar' => 'محتوى الموقع', 'en' => 'Site Content'],
        'seo' => ['ar' => 'تحسين محركات البحث', 'en' => 'SEO'],
        'contact' => ['ar' => 'بيانات التواصل', 'en' => 'Contact'],
        'social' => ['ar' => 'روابط التواصل الاجتماعي', 'en' => 'Social Links'],
    ];
@endphp

<div class="settings-wrapper">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h5 class="mb-1 fw-semibold">
                    {{ $locale === 'ar' ? 'تهيئة إعدادات الموقع' : 'Configure Website Settings' }}
                </h5>
                <p class="text-muted mb-0">
                    {{ $locale === 'ar'
                        ? 'تمت تهيئة هذه الإعدادات بواسطة النظام ويمكن تعديل قيمها هنا فقط.'
                        : 'These settings are seeded by the system; you can update their values here.' }}
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="fas fa-database me-2"></i>
                    {{ $locale === 'ar' ? 'عدد الإعدادات' : 'Total Settings' }}: {{ $settings->count() }}
                </span>
                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                    <i class="fas fa-lock me-2"></i>
                    {{ $locale === 'ar' ? 'لا يمكن إضافة مفاتيح جديدة من الواجهة' : 'Keys are system-managed' }}
                </span>
            </div>
        </div>
        <div class="card-body">
            @if($settings->count() > 0)
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="settings-form">
                    @csrf
                    @php
                        $grouped = $settings->groupBy(fn($setting) => $setting->group ?? 'content');
                    @endphp

                    @foreach($grouped as $groupKey => $groupSettings)
                        <div class="settings-section mb-5">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                <h6 class="mb-0 section-title text-primary">
                                    {{ $groups[$groupKey][$locale] ?? ($locale === 'ar' ? 'إعدادات إضافية' : 'Additional Settings') }}
                                </h6>
                                <div class="section-divider flex-grow-1 ms-lg-4 mt-2 mt-lg-0"></div>
                            </div>
                            <div class="row g-4">
                                @foreach($groupSettings as $setting)
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="setting-card h-100 border rounded-4 p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <label class="form-label fw-semibold mb-0">
                                                    {{ $labels[$setting->key][$locale] ?? str_replace('_', ' ', $setting->key) }}
                                                </label>
                                                <span class="setting-key text-muted small">{{ $setting->key }}</span>
                                            </div>

                                            @if($setting->type === 'image')
                                                <div class="media-preview rounded-3 border mb-3">
                                                    @if($setting->value)
                                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->key }}" class="img-fluid rounded-3">
                                                    @else
                                                        <div class="placeholder d-flex align-items-center justify-content-center text-muted">
                                                            <i class="fas fa-image fa-2x"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <input type="file"
                                                       name="settings[{{ $setting->key }}]"
                                                       class="form-control @error('settings.' . $setting->key) is-invalid @enderror"
                                                       accept="image/*">
                                                <small class="text-muted d-block mt-2">
                                                    {{ $locale === 'ar'
                                                        ? 'تنبيه: سيتم استبدال الصورة الحالية. الامتدادات المسموحة PNG / JPG / SVG حتى 4 م.ب'
                                                        : 'Note: Upload will replace the current image. Allowed formats PNG / JPG / SVG up to 4MB.' }}
                                                </small>
                                            @elseif($setting->type === 'textarea')
                                                <textarea
                                                    name="settings[{{ $setting->key }}]"
                                                    rows="4"
                                                    class="form-control @error('settings.' . $setting->key) is-invalid @enderror {{ in_array($setting->key, ['about_company_ar', 'short_description_ar', 'meta_description_ar']) ? 'rich-text-ar' : '' }} {{ in_array($setting->key, ['about_company_en', 'short_description_en', 'meta_description_en']) ? 'rich-text-en' : '' }}"
                                                    placeholder="{{ $locale === 'ar' ? 'اكتب المحتوى هنا' : 'Type the content here' }}">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                            @else
                                                <input type="text"
                                                       name="settings[{{ $setting->key }}]"
                                                       value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                       class="form-control @error('settings.' . $setting->key) is-invalid @enderror"
                                                       placeholder="{{ $locale === 'ar' ? 'اكتب القيمة هنا' : 'Enter the value here' }}">
                                            @endif

                                            @error('settings.' . $setting->key)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-2"></i>{{ $locale === 'ar' ? 'إعادة تعيين' : 'Reset' }}
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>{{ $locale === 'ar' ? 'حفظ التغييرات' : 'Save Changes' }}
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-info d-flex align-items-center gap-3 mb-0">
                    <i class="fas fa-info-circle fa-lg"></i>
                    <span>
                        {{ $locale === 'ar'
                            ? 'لم يتم العثور على إعدادات. يرجى تشغيل Seeder الإعدادات لإعادة تهيئتها.'
                            : 'No settings found. Please run the settings seeder to populate defaults.' }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

