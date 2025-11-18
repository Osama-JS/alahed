@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'جدول اليوم - العهد' : 'Day Schedule - Al-Ahd')

@section('content')
    <div class="pages-wrapper">
        <div class="pages-head day-hero">
            <div class="container">
                <div class="pages-breadcrumb">
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
                        </li>
                        <li>
                            <a href="{{ route('agenda') }}">{{ app()->getLocale() == 'ar' ? 'جدول المؤتمر' : 'Agenda' }}</a>
                        </li>
                        <li>
                            <span>{{ app()->getLocale() == 'ar' ? 'جدول اليوم' : 'Day Schedule' }}</span>
                        </li>
                    </ul>
                </div>

                <div class="day-hero-content">
                    <div class="day-hero-main">
                        <span class="day-badge">
                            {{ app()->getLocale() == 'ar'
                                ? \Carbon\Carbon::parse($day->date)->locale('ar')->translatedFormat('l j F Y')
                                : \Carbon\Carbon::parse($day->date)->locale('en')->translatedFormat('l j F Y') }}
                        </span>
                        <h1 class="day-title">
                            {{ app()->getLocale() == 'ar' ? $day->title_ar : $day->title_en }}
                        </h1>
                        @if (!empty($day->description_ar) || !empty($day->description_en))
                            <p class="day-summary">
                                {!! app()->getLocale() == 'ar' ? $day->description_ar : $day->description_en !!}
                            </p>
                        @endif
                    </div>

                    <div class="day-meta-card">
                        <h4>{{ app()->getLocale() == 'ar' ? 'معلومات اليوم' : 'Day Overview' }}</h4>
                        <ul>
                            <li>
                                <span class="meta-label">{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</span>
                                <span class="meta-value">
                                    {{ app()->getLocale() == 'ar'
                                        ? \Carbon\Carbon::parse($day->date)->locale('ar')->translatedFormat('j F Y')
                                        : \Carbon\Carbon::parse($day->date)->locale('en')->translatedFormat('j F Y') }}
                                </span>
                            </li>
                            <li>
                                <span class="meta-label">{{ app()->getLocale() == 'ar' ? 'المؤتمر' : 'Conference' }}</span>
                                <span class="meta-value">
                                    {{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}
                                </span>
                            </li>
                            @if (!empty($conference->location_ar) || !empty($conference->location_en))
                                <li>
                                    <span class="meta-label">{{ app()->getLocale() == 'ar' ? 'الموقع' : 'Location' }}</span>
                                    <span class="meta-value">
                                        {{ app()->getLocale() == 'ar' ? $conference->location_ar : $conference->location_en }}
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section-contain day-schedule-section">
        <div class="container">
            <div class="section-title-wrap mb-4 mt-5">
                <h2 class="section-title">
                    {{ app()->getLocale() == 'ar' ? 'جلسات هذا اليوم' : 'Sessions of the Day' }}
                </h2>
                <p class="section-subtitle">
                    {{ app()->getLocale() == 'ar'
                        ? 'استعرض جميع الجلسات والفعاليات المجدولة لهذا اليوم مع التفاصيل الكاملة لكل حدث.'
                        : 'Browse all scheduled sessions and events for this day with full details for each.' }}
                </p>
            </div>

            @if ($day->sessions->count() > 0)
                <div class="day-schedule-grid">
                    @foreach ($day->sessions as $session)
                        <div class="session-card">
                            <div class="session-header">
                                <div class="session-time-pill">
                                    {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                                    –
                                    {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                </div>
                                <span class="session-label">
                                    {{ app()->getLocale() == 'ar' ? 'جلسة' : 'Session' }}
                                </span>
                            </div>

                            <h3 class="session-title-full">
                                {{ app()->getLocale() == 'ar' ? $session->title_ar : $session->title_en }}
                            </h3>

                            @if (!empty($session->description_ar) || !empty($session->description_en))
                                <p class="session-description-full">
                                    {!! app()->getLocale() == 'ar' ? $session->description_ar : $session->description_en !!}
                                </p>
                            @endif

                            <div class="session-meta-row">
                                @if (!empty($session->stage_ar) || !empty($session->stage_en))
                                    <div class="session-meta-item">
                                        <span class="meta-icon"><i class="fas fa-map-marker-alt"></i></span>
                                        <div class="meta-text">
                                            <span class="meta-label-small">{{ app()->getLocale() == 'ar' ? 'القاعة' : 'Stage' }}</span>
                                            <span class="meta-value-small">
                                                {{ app()->getLocale() == 'ar' ? $session->stage_ar : $session->stage_en }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($session->speaker_ar) || !empty($session->speaker_en))
                                    <div class="session-meta-item">
                                        <span class="meta-icon"><i class="fas fa-user"></i></span>
                                        <div class="meta-text">
                                            <span class="meta-label-small">{{ app()->getLocale() == 'ar' ? 'المتحدث' : 'Speaker' }}</span>
                                            <span class="meta-value-small">
                                                {{ app()->getLocale() == 'ar' ? $session->speaker_ar : $session->speaker_en }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    {{ app()->getLocale() == 'ar' ? 'لا توجد جلسات لهذا اليوم' : 'No sessions for this day' }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .day-hero {
            background: radial-gradient(circle at top left, rgba(0, 170, 172, 0.18), transparent 55%),
                        radial-gradient(circle at bottom right, rgba(15, 69, 114, 0.16), transparent 55%),
                        #0b1020;
            color: #fff;
            padding-bottom: 40px;
        }

        .day-hero-content {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            align-items: flex-start;
            justify-content: space-between;
            padding-top: 16px;
        }

        .day-hero-main {
            max-width: 620px;
        }

        .day-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            font-size: 0.85rem;
            letter-spacing: 0.03em;
        }

        .day-title {
            margin-top: 14px;
            margin-bottom: 10px;
            font-size: 1.9rem;
            font-weight: 700;
        }

        .day-summary {
            margin: 0;
            font-size: 0.98rem;
            line-height: 1.9;
            color: rgba(255, 255, 255, 0.86);
        }

        .day-meta-card {
            min-width: 260px;
            max-width: 320px;
            background: rgba(8, 13, 23, 0.9);
            border-radius: 18px;
            padding: 18px 18px 14px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
        }

        .day-meta-card h4 {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .day-meta-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .day-meta-card li {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 6px 0;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.08);
        }

        .day-meta-card li:last-child {
            border-bottom: none;
        }

        .day-meta-card .meta-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.6);
        }

        .day-meta-card .meta-value {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .day-schedule-section {
            background: #f3f4f6;
        }

        .day-schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .session-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px 18px 16px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(148, 163, 184, 0.22);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .session-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .session-time-pill {
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(15, 69, 114, 0.06);
            color: #0f4572;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .session-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #6b7280;
        }

        .session-title-full {
            font-size: 1.05rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .session-description-full {
            font-size: 0.92rem;
            color: #4b5563;
            margin: 4px 0 2px;
            line-height: 1.8;
        }

        .session-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 8px;
        }

        .session-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-icon {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 69, 114, 0.06);
            color: #0f4572;
            font-size: 0.8rem;
        }

        .meta-text {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .meta-label-small {
            font-size: 0.78rem;
            color: #9ca3af;
        }

        .meta-value-small {
            font-size: 0.9rem;
            color: #111827;
            font-weight: 500;
        }

        @media (max-width: 767.98px) {
            .day-hero-content {
                flex-direction: column;
            }

            .day-meta-card {
                width: 100%;
            }
        }
    </style>
@endpush
