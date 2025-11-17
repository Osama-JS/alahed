@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'التسجيل - العهد' : 'Registration - Al-Ahd')

@section('content')

<div class="pages-wrapper">
    <div class="pages-head">
        <div class="container">
            <div class="pages-breadcrumb">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
                    </li>
                    <li>
                        <span>{{ app()->getLocale() == 'ar' ? 'التسجيل' : 'Registration' }}</span>
                    </li>
                </ul>
            </div>
            <div class="pages-title-wrap">
                <strong class="pages-title">{{ app()->getLocale() == 'ar' ? 'التسجيل' : 'Registration' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Registration Section -->
<section class="registration-contain section-contain">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
               

                <!-- Conference Info -->
                <div class="conference-info-box mb-4">
                    <h3>{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}</h3>
                    <div class="info-row">
                        @if($conference->start_date && $conference->end_date)
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($conference->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}
                            </div>
                        @endif
                        @if($conference->location_ar || $conference->location_en)
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ app()->getLocale() == 'ar' ? $conference->location_ar : $conference->location_en }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Registration Form -->
                <div class="registration-form-wrapper">
                    <form action="{{ route('registration.store') }}" method="POST" class="registration-form">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Full Name' }} <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }} <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }} <span class="text-danger">*</span>
                                </label>
                                <input type="tel"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">
                                    {{ app()->getLocale() == 'ar' ? 'نوع الحضور' : 'Attendance Type' }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('type') is-invalid @enderror"
                                        id="type"
                                        name="type"
                                        required>
                                    <option value="">{{ app()->getLocale() == 'ar' ? 'اختر نوع الحضور' : 'Select Type' }}</option>
                                    <option value="visitor" {{ old('type') == 'visitor' ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? 'زائر' : 'Visitor' }}
                                    </option>
                                    <option value="exhibitor" {{ old('type') == 'exhibitor' ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? 'عارض' : 'Exhibitor' }}
                                    </option>
                                    <option value="speaker" {{ old('type') == 'speaker' ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? 'متحدث' : 'Speaker' }}
                                    </option>
                                    <option value="sponsor" {{ old('type') == 'sponsor' ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? 'راعي' : 'Sponsor' }}
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="company" class="form-label">
                                    {{ app()->getLocale() == 'ar' ? 'الشركة' : 'Company' }}
                                </label>
                                <input type="text"
                                       class="form-control @error('company') is-invalid @enderror"
                                       id="company"
                                       name="company"
                                       value="{{ old('company') }}">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="job_title" class="form-label">
                                    {{ app()->getLocale() == 'ar' ? 'المسمى الوظيفي' : 'Job Title' }}
                                </label>
                                <input type="text"
                                       class="form-control @error('job_title') is-invalid @enderror"
                                       id="job_title"
                                       name="job_title"
                                       value="{{ old('job_title') }}">
                                @error('job_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i>
                                {{ app()->getLocale() == 'ar' ? 'إرسال التسجيل' : 'Submit Registration' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .conference-info-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .conference-info-box h3 {
        font-size: 24px;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .info-row {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
    }

    .info-item i {
        font-size: 20px;
    }

    .registration-form-wrapper {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .btn-primary {
        padding: 12px 40px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,123,255,.3);
    }
</style>
@endpush

