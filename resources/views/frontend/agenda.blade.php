@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'جدول الأعمال - العهد' : 'Agenda - Al-Ahd')

@section('content')



    <div class="pages-wrapper">

        <div class="pages-head">
            <div class="container">
                <div class="pages-breadcrumb">
                    <ul>
                        <li>
                            <a href="../ar.html">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a>
                        </li>
                        <li>
                            <span> {{ app()->getLocale() == 'ar' ? 'جدول الأعمال' : 'Agenda' }}</span>
                        </li>
                    </ul>
                </div>
                <div class="pages-title-wrap">
                    <strong class="pages-title">{{ app()->getLocale() == 'ar' ? 'جدول الأعمال' : 'Agenda' }}</strong>
                </div>
            </div>
        </div>

    </div>

<!-- Agenda Section -->
<section id="agenda" class="conference-contain section-contain">
    <div class="container">

        @if($agendaDays->count() > 0)
            <div class="row">
                
                    @foreach($agendaDays as $index => $day)
                        <div class="col-md-6" role="group" >
                            <div class="conference-item">
                                <div class="conference-item-content">
                                    <span class="conference-date">{{ app()->getLocale() == 'ar' ? \Carbon\Carbon::parse($day->date)->locale('ar')->translatedFormat('l j F Y') : \Carbon\Carbon::parse($day->date)->locale('en')->translatedFormat('l j F Y') }}</span>
                                </div>
                                <div class="separate-conf">
                                    <div>
                                        <strong class="conference-title">{{ app()->getLocale() == 'ar' ? $day->title_ar : $day->title_en }}</strong>
                                        <p class="conference-description">{!! app()->getLocale() == 'ar' ? $day->description_ar : $day->description_en !!}</p>
                                    </div>
                                    <div class="conference-item-list">
                                        <ul>
                                            @foreach($day->sessions as $session)
                                            <li class="session-item">

                                                <span class="session-title">
                                                <i class="fas fa-dot-circle" style="color: #00AAAC;"></i>

                                                    {{ app()->getLocale() == 'ar' ? $session->title_ar : $session->title_en }}
                                                </span>

                                                <span class="session-time">
                                                    {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                                </span>
                                            </li>

                                            @endforeach
                                 
                                           
                                            <li>
                                                <a class="site-filled-btn white" href="ar/agenda/2025-11-05.html">
                                                    {{ app()->getLocale() == 'ar' ? 'عرض الكل' : 'View All' }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                         <div class="col-md-6 " role="group" >
                            <div class="conference-item">
                                <div class="conference-item-content">
                                    <span class="conference-date">{{ app()->getLocale() == 'ar' ? \Carbon\Carbon::parse($day->date)->locale('ar')->translatedFormat('l j F Y') : \Carbon\Carbon::parse($day->date)->locale('en')->translatedFormat('l j F Y') }}</span>
                                </div>
                                <div class="separate-conf">
                                    <div>
                                        <strong class="conference-title">{{ app()->getLocale() == 'ar' ? $day->title_ar : $day->title_en }}</strong>
                                        <p class="conference-description">{!! app()->getLocale() == 'ar' ? $day->description_ar : $day->description_en !!}</p>
                                    </div>
                                    <div class="conference-item-list">
                                        <ul>
                                            @foreach($day->sessions as $session)
                                            <li class="session-item">

                                                <span class="session-title">
                                                <i class="fas fa-dot-circle" style="color: #00AAAC;"></i>

                                                    {{ app()->getLocale() == 'ar' ? $session->title_ar : $session->title_en }}
                                                </span>

                                                <span class="session-time">
                                                    {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                                </span>
                                            </li>

                                            @endforeach
                                 
                                           
                                            <li>
                                                <a class="site-filled-btn white" href="ar/agenda/2025-11-05.html">
                                                    {{ app()->getLocale() == 'ar' ? 'عرض الكل' : 'View All' }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                    @endforeach
                
            </div>
        @else
            <div class="alert alert-info text-center">
                {{ app()->getLocale() == 'ar' ? 'لا يوجد جدول أعمال حالياً' : 'No agenda available at the moment' }}
            </div>
        @endif

        
    </div>
</section>

@endsection

@push('styles')
<style>
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #666;
        font-weight: 600;
        padding: 15px 25px;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: #007bff;
    }

    .nav-tabs .nav-link.active {
        color: #007bff;
        border-bottom-color: #007bff;
        background: transparent;
    }

    .agenda-timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        gap: 30px;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e0e0e0;
    }

    .timeline-item:last-child {
        border-bottom: none;
    }

    .timeline-time {
        flex-shrink: 0;
        width: 150px;
    }

    .time-badge {
        display: inline-block;
        background: #007bff;
        color: #fff;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-content h4 {
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .session-description {
        font-size: 15px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .session-stage,
    .session-speaker {
        font-size: 14px;
        color: #999;
        margin-bottom: 5px;
    }

    .session-stage i,
    .session-speaker i {
        margin-right: 8px;
        color: #007bff;
    }

            .session-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .session-title {
            font-weight: 600;
        }

        .session-time {
            margin-top: 3px;
            color: #777; /* لون خفيف */
            font-size: 14px;
        }
</style>
@endpush

