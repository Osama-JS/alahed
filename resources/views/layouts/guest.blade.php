<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
    $siteName = $isArabic ? (\App\Models\Setting::get('site_name_ar') ?: 'العهد') : (\App\Models\Setting::get('site_name_en') ?: 'Al-Ahd');
    $logoPath = \App\Models\Setting::get('site_logo');
@endphp
<html lang="{{ $locale }}" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $siteName }} - {{ __('Log in') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-[#1f3c88] to-[#182952] p-0 md:p-6 flex items-stretch md:items-center justify-center">
            <div class="w-full max-w-5xl bg-white rounded-none md:rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
                <div class="relative hidden md:block">
                    <img src="{{ asset('assets/portal/images/dashboard_bg.webp') }}" alt="cover" class="absolute inset-0 w-full h-full object-cover" onerror="this.src='{{ asset('assets/portal/images/dashboard_bg.png') }}'">
                    <div class="absolute inset-0 bg-[#1f3c88]/70"></div>
                    <div class="relative z-10 p-8 h-full flex flex-col justify-between">
                        <a href="/" class="flex items-center gap-3 text-white">
                            @if($logoPath)
                                <img class="w-12 h-12 object-contain" src="{{ asset('storage/' . $logoPath) }}" alt="{{ $siteName }}"/>
                            @else
                                <x-application-logo class="w-12 h-12 fill-current text-white" />
                            @endif
                            <div class="font-bold">{{ $siteName }}</div>
                        </a>
                        <div class="space-y-2 text-white">
                            <h2 class="text-2xl font-semibold">{{ $isArabic ? 'مرحباً بك' : 'Welcome' }}</h2>
                            <p class="text-sm opacity-90">{{ $isArabic ? 'تسجيل الدخول يمنحك الوصول إلى لوحة التحكم' : 'Sign in to access the admin panel' }}</p>
                        </div>
                    </div>
                </div>
                <div class="px-8 pb-8 pt-8">
                    <a href="/" class="flex items-center gap-3 md:hidden mb-6">
                        @if($logoPath)
                            <img class="w-10 h-10 object-contain" src="{{ asset('storage/' . $logoPath) }}" alt="{{ $siteName }}"/>
                        @else
                            <x-application-logo class="w-10 h-10 fill-current text-gray-600" />
                        @endif
                        <div class="font-bold text-gray-900">{{ $siteName }}</div>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
