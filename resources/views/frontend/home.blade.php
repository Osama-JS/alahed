@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'العهد لتنظيم المعارض والمؤتمرات' : 'Al-Ahd for Organizing Exhibitions
    and Conferences')

@section('content')

    <!-- Hero Section -->

    <section class="head-section intro-contain">
        <div class="intro-background">
            @if ($conference->hero_video_url && $conference->hero_video_url != 'null')
                 <video autoplay muted loop class="hero_bg_video">
                <source src="{{ asset('storage/' . $conference->hero_video_url) }}" type="video/mp4">
            </video>
            @else
                <img src="{{ asset('storage/' . $conference->hero_image) }}" class="hero_bg_video" alt="{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}" />
            @endif

        </div>
        <img class="intro-bottom-shape" src="assets/web/images/intro-bottom-banner.svg" />

        <div class="container">
            <div class="intro-wrap">
                <div class="intro-content">
                    <div class="intro-content-extra">
                        <p>

                            <svg width="21" height="19" viewBox="0 0 21 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.7246 1.55176H6.89714" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path
                                    d="M16.207 1.55176H18.3796C19.0653 1.55176 19.6208 2.10724 19.6208 2.7933V16.7588C19.6208 17.4445 19.0653 18 18.3796 18H2.24154C1.55582 18 1 17.4445 1 16.7588V2.7933C1 2.10724 1.55582 1.55176 2.24154 1.55176H4.41407"
                                    stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M2.24219 6.20679H18.3802" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M5.65527 0V4.0345" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M5.03418 4.03442H6.27572" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M14.9658 0V4.0345" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M14.3447 4.03442H15.5863" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M3.48242 9V10.2415H5.3444" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M7.5166 9V10.2415H9.37858" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M11.5518 9.00024V10.2418H13.4137" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M15.5869 9V10.2415H17.4489" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M3.48242 13.655V14.8966H5.3444" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M7.5166 13.6548V14.8963H9.37858" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M11.5518 13.655V14.8966H13.4137" stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M15.5869 13.6548V14.8963H17.4489" stroke="#87D4E9" stroke-miterlimit="10" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($conference->start_date)->format('d') }}-{{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }} </span>
                        </p>

                        <div class="time-info">

                            <svg width="20" height="20" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.3912 14.7688C8.20471 16.0887 4.55158 14.5754 3.23165 11.3888C1.91173 8.20226 3.42484 4.54907 6.61129 3.22919C9.79773 1.90932 13.4509 3.42258 14.7708 6.60915C16.0907 9.79572 14.5776 13.4489 11.3912 14.7688Z"
                                    stroke="#87D4E9" stroke-miterlimit="10" />
                                <path
                                    d="M16.1482 10.852C15.1254 14.7997 11.0959 17.1708 7.14817 16.148C3.20043 15.1252 0.829307 11.0958 1.85213 7.14802C2.87494 3.20028 6.90438 0.829158 10.8521 1.85198C14.7999 2.87479 17.171 6.90423 16.1482 10.852Z"
                                    stroke="#87D4E9" stroke-miterlimit="10" />
                                <path d="M9.00195 4.36572V8.99911H12.684" stroke="#87D4E9" stroke-miterlimit="10" />
                            </svg>

                            <span>{{ \Carbon\Carbon::parse($conference->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($conference->end_time)->format('H:i') }}</span>
                        </div>
                        <div class="location-info">
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.85722 4.28576C7.15085 4.28576 6.46035 4.49522 5.87302 4.88766C5.2857 5.2801 4.82793 5.83788 4.55762 6.49048C4.2873 7.14308 4.21658 7.86118 4.35438 8.55398C4.49219 9.24678 4.83234 9.88315 5.33181 10.3826C5.83129 10.8821 6.46767 11.2223 7.16046 11.3601C7.85326 11.4979 8.57136 11.4271 9.22396 11.1568C9.87656 10.8865 10.4343 10.4287 10.8268 9.84142C11.2192 9.2541 11.4287 8.56359 11.4287 7.85722C11.4287 6.91001 11.0524 6.00159 10.3826 5.33182C9.71285 4.66204 8.80443 4.28576 7.85722 4.28576ZM7.85722 10.0001C7.4334 10.0001 7.0191 9.87442 6.6667 9.63896C6.31431 9.4035 6.03965 9.06883 5.87746 8.67727C5.71527 8.28571 5.67283 7.85484 5.75552 7.43917C5.8382 7.02349 6.04229 6.64166 6.34198 6.34198C6.64166 6.04229 7.02349 5.8382 7.43917 5.75552C7.85484 5.67283 8.28571 5.71527 8.67727 5.87746C9.06883 6.03965 9.4035 6.31431 9.63896 6.6667C9.87442 7.0191 10.0001 7.4334 10.0001 7.85722C10.0001 8.42555 9.77433 8.9706 9.37247 9.37247C8.9706 9.77433 8.42555 10.0001 7.85722 10.0001ZM7.85722 0C5.77408 0.00236318 3.77694 0.830934 2.30394 2.30394C0.830934 3.77694 0.00236318 5.77408 0 7.85722C0 10.6608 1.29555 13.6323 3.75004 16.4511C4.85292 17.7248 6.09422 18.8717 7.45097 19.8707C7.57107 19.9549 7.71415 20 7.86079 20C8.00743 20 8.15052 19.9549 8.27062 19.8707C9.62487 18.8713 10.8638 17.7244 11.9644 16.4511C14.4153 13.6323 15.7144 10.6608 15.7144 7.85722C15.7121 5.77408 14.8835 3.77694 13.4105 2.30394C11.9375 0.830934 9.94036 0.00236318 7.85722 0ZM7.85722 18.393C6.38131 17.2323 1.42859 12.9689 1.42859 7.85722C1.42859 6.15224 2.10589 4.51709 3.31149 3.31149C4.51709 2.10589 6.15224 1.42859 7.85722 1.42859C9.5622 1.42859 11.1973 2.10589 12.403 3.31149C13.6086 4.51709 14.2859 6.15224 14.2859 7.85722C14.2859 12.9671 9.33313 17.2323 7.85722 18.393Z"
                                    fill="#87D4E9" />
                            </svg>
                            <strong>
                                {{ app()->getLocale() == 'ar' ? $conference->location_ar : $conference->location_en }}
                            </strong>
                        </div>
                    </div>
                    <div class="intro-content-title">
                        <strong>وجهة عالمية للفرص</strong>

                        @if($conference->logo)
                            <div class="hero-conf-logo-wrap mt-3">
                                <div class="hero-conf-logo">
                                    <img src="{{ asset('storage/' . $conference->logo) }}" alt="Conference Logo" />
                                </div>
                                <span class="hero-conf-logo-label">
                                    {{ app()->getLocale() == 'ar' ? 'شعار المؤتمر' : 'Conference Logo' }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="intro-actions">
                    <a href="ar/registration.html" class="site-filled-btn">سجل الآن</a>
                </div>
            </div>
        </div>


    </section>


    <!-- About Section -->
    <section id="about" class="about-contain section-contain">
        <div class="container">
            <!-- <div class="section-title-wrap">
                <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'عن المؤتمر' : 'About Conference' }}</h2>
            </div> -->
            <div class="about-wrap">
                <div class="about-head">
                    @if ($conference->hero_image)
                        <div class="about-head-img">
                            <img class="head-banner" src="{{ asset('storage/' . $conference->hero_image) }}"
                                alt="{{ app()->getLocale() == 'ar' ? $conference->title_ar : $conference->title_en }}" />
                        </div>
                    @endif
                    <div class="about-head-content">
                        <p>{!! app()->getLocale() == 'ar' ? $conference->description_ar : $conference->description_en !!}</p>
                    </div>
                </div>
            </div>


                  <!-- Statistics Section -->
    @if ($statistics->count() > 0)
        <div class="key-figures">
              <div class="edition-container">
                  <div class="figures-forums @if(app()->getLocale() == 'ar') ar-lang @else en-lang @endif">
                     @foreach ($statistics as $stat)
                    <div class="figures-forums-item">
                        <div class="icon-container">
                            <i class="{{ $stat->icon }}"></i>
                        </div>
                        <div class="item-text">
                            <h3 class="count">{{  $stat->value }}</h3>
                            <p class="desc">{{ app()->getLocale() == 'ar' ? $stat->label_ar : $stat->label_en }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
              </div>
        </div>
       
    @endif
        </div>
    </section>





    <!-- Speakers Section -->
    @if ($speakers->count() > 0)

    
       <section class="speakers-contain section-contain">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'المتحدثون' : 'Speakers' }}</h2>
                <p class="section-subtitle">
                    {{ app()->getLocale() == 'ar'
                        ? 'اكتشف نخبة المتحدثين والخبراء المشاركين في المؤتمر وتجاربهم الملهمة.'
                        : 'Discover the distinguished speakers and experts sharing their inspiring experiences at the conference.' }}
                </p>
            </div>

            <div class="speakers-wrap">
                <div class="speakers-section-wrap">
                    <div class="swiper speakers-swiper">
                        <div class="swiper-wrapper ">
                        @foreach ($speakers as $speaker)
                            <div class="swiper-slide">
                                <div class="speakers-item">
                                    <div class="speakers-item-img">
                                        <a href="{{ route('speakers.show', $speaker) }}">
                                            <img src="{{ asset('storage/' . $speaker->image) }}"
                                                    alt="{{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}" />
                                        </a>
                                    </div>
                                    <div class="speakers-item-content">
                                        <a href="{{ route('speakers.show', $speaker) }}">
                                            <strong>
                                                {{ app()->getLocale() == 'ar' ? $speaker->name_ar : $speaker->name_en }}
                                            </strong>
                                        </a>
                                        <p>
                                            {{ app()->getLocale() == 'ar' ? $speaker->title_ar : $speaker->title_en }}
                                        </p>
                                        @if ($speaker->company_ar || $speaker->company_en)
                                            <p>{{ app()->getLocale() == 'ar' ? $speaker->company_ar : $speaker->company_en }}</p>
                                        @endif
                                        <br>
                                        @if ($speaker->bio_ar || $speaker->bio_en)
                                            <p>{!! Str::limit(app()->getLocale() == 'ar' ? $speaker->bio_ar : $speaker->bio_en, 90) !!}..</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach                        
                        </div>

                        <div class="speakers-pagination">

                            <div class="custom-swiper-pagination justify-content-start">
                                <div class="custom-swiper-btn custom-swiper-prev"
                                    style="background: #0D121C33 !important;">
                                    <img src="assets/web/images/prev-arrow.png" />
                                </div>
                                <div class="custom-swiper-btn custom-swiper-next"
                                    style="background: #0D121C33 !important;">
                                    <img src="assets/web/images/next-arrow.png" />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

               

            </div>
             
        </div>


    </section>

       
    @endif

 <!-- Agenda Section -->
    @if ($agendaDays->count() > 0)
    <section id="agenda" class="conference-contain section-contain">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'جدول المؤتمر' : 'Conference Agenda' }}</h2>
                <p class="section-subtitle">
                    {{ app()->getLocale() == 'ar'
                        ? 'تعرّف على تفاصيل أيام المؤتمر وجلساته وأهم المحاور المطروحة.'
                        : 'Explore the detailed schedule of conference days, sessions, and key discussion topics.' }}
                </p>
            </div>
        </div>
        <div class="container">
            <div class="conference-wrap">
                <div class="swiper conference-swiper swiper-initialized swiper-horizontal swiper-rtl swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-76be373f4dad7e97" aria-live="polite">

                    @foreach ($agendaDays as $day)
                        <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 4" style="width: 542px; margin-left: 32px;">
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
                                                <a class="site-filled-btn white" href="{{ route('agenda.show', $day) }}">
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

                    <div class="custom-swiper-pagination justify-content-start">
                        <div class="custom-swiper-btn custom-swiper-prev swiper-button-disabled" style="background: #0D121C33 !important;" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-76be373f4dad7e97" aria-disabled="true">
                            <img src="assets/web/images/prev-arrow.png">
                        </div>
                        <div class="custom-swiper-btn custom-swiper-next" style="background: #0D121C33 !important;" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-76be373f4dad7e97" aria-disabled="false">
                            <img src="assets/web/images/next-arrow.png">
                        </div>
                    </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
            </div>
        </div>
    </section>
   
     
    @endif

    <!-- Exhibitors Section -->
    @if ($exhibitors->count() > 0)
     
  

     <section id="exhibitors" class="section-contain">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'العارضون' : 'Exhibitors' }}</h2>
                <p class="section-subtitle">
                    {{ app()->getLocale() == 'ar'
                        ? 'تعرّف على الجهات المشاركة وحلولهم ومنتجاتهم المعروضة في المعرض.'
                        : 'Get to know the participating organizations and the solutions and products they showcase.' }}
                </p>
            </div>

            <div class="">
                <div class="swiper exhb-swiper" id="exhb-swiper">
                    <div class="swiper-wrapper">
                    @foreach ($exhibitors as $exhibitor)
                   
                        <div class="swiper-slide">
                            <div class="news-card spe-card" style="background-color: #FFFFFFE5;">
                                <div class="news-card-content">
                                    <div class="news-card-img-wrapper exhb-img-wrapper">
                                        <img class=""
                                            src="{{ asset('storage/' . $exhibitor->logo) }}" />
                                    </div>
                                    <div class="news-card-head mt-2">
                                        <a href="">
                                            {{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}
                                        </a>
                                    </div>
                                    <div class="news-card-tags">
                                        
                                        <div class="tag-item industry">{{ app()->getLocale() == 'ar' ? $exhibitor->summary_ar : $exhibitor->summary_en }}</div>
                                    </div>
                                    <div class="news-card-body">
                                        <p>
                                           {!!  Str::limit(app()->getLocale() == 'ar' ? $exhibitor->description_ar : $exhibitor->description_en, 90) !!}
                                        </p>
                                    </div>
                                    <div class="news-card-foot justify-content-end">
                                        <a href="{{ route('exhibitors.show', $exhibitor) }}"
                                            class="more-btn-filled custom-swiper-btn "><img
                                                src="assets/web/images/next-arrow.png" /></a>
                                    </div>
                                </div>
                                <a href="{{ route('exhibitors.show', $exhibitor) }}" class="stretched-link"
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:10;"
                                    tabindex="-1" aria-label="{{ app()->getLocale() == 'ar' ? $exhibitor->name_ar : $exhibitor->name_en }}"></a>
                            </div>
                        </div>
                        @endforeach



                    </div>

                    <div class="speakers-pagination">
                        <div class="custom-swiper-pagination justify-content-start">
                            <div class="custom-swiper-btn custom-swiper-prev" style="background: #0D121C33 !important;">
                                <img src="assets/web/images/prev-arrow.png" />
                            </div>
                            <div class="custom-swiper-btn custom-swiper-next" style="background: #0D121C33 !important;">
                                <img src="assets/web/images/next-arrow.png" />
                            </div>
                        </div>
                        <a href="{{ route('exhibitors') }}" class="site-filled-btn white"> {{ app()->getLocale() == 'ar' ? 'عرض جميع العارضين' : 'View All Exhibitors' }}</a>
                    </div>
                </div>
            </div>
            <!-- <div class="text-end mt-4">
                <a href="https://bibanglobal.sa/ar/exhibitor" class="site-filled-btn white">عرض الكل</a>
            </div> -->
        </div>
    </section>

      @endif

    <!-- Sponsors Section -->
    @if ($sponsors->count() > 0)
        <section class="sponsors-contain section-contain bg-white">
            <div class="container">
                <div class="section-title-wrap">
                    <h2 class="section-title ">{{ app()->getLocale() == 'ar' ? 'الرعاة' : 'Sponsors' }}</h2>
                    <p class="section-subtitle">
                        {{ app()->getLocale() == 'ar'
                            ? 'نقدّر دعم شركائنا ورعاتنا الذين يسهمون في نجاح هذا الحدث.'
                            : 'We value the support of our partners and sponsors who contribute to the success of this event.' }}
                    </p>
                </div>

                @php
                    $sponsorTypes = $sponsors->groupBy('type');
                    $typeLabelsAr = [
                        'platinum' => 'الرعاة البلاتينيون',
                        'gold' => 'الرعاة الذهبيون',
                        'silver' => 'الرعاة الفضيون',
                        'bronze' => 'الرعاة البرونزيون',
                        'partner' => 'الشركاء',
                    ];
                    $typeLabelsEn = [
                        'platinum' => 'Platinum',
                        'gold' => 'Gold',
                        'silver' => 'Silver',
                        'bronze' => 'Bronze',
                        'partner' => 'Partners',
                    ];
                @endphp

                <div class="sponsors-filter-wrap mb-4">
                    <button type="button" class="sponsor-filter-btn active" data-sponsor-filter="all">
                        {{ app()->getLocale() == 'ar' ? 'جميع الرعاة' : 'All Sponsors' }}
                    </button>
                    @foreach (['platinum', 'gold', 'silver', 'bronze', 'partner'] as $type)
                        @if (isset($sponsorTypes[$type]) && $sponsorTypes[$type]->count() > 0)
                            <button type="button" class="sponsor-filter-btn" data-sponsor-filter="{{ $type }}">
                                {{ app()->getLocale() == 'ar' ? $typeLabelsAr[$type] : $typeLabelsEn[$type] }}
                            </button>
                        @endif
                    @endforeach
                </div>

                <div class="sponsors-strip-wrap">
                    <div class="swiper sponsors-swiper">
                        <div class="swiper-wrapper py-3">
                            @foreach ($sponsors as $sponsor)
                                @if ($sponsor->logo)
                                    <div class="swiper-slide" data-sponsor-type="{{ $sponsor->type }}">
                                        <div class="sponsor-logo-card">
                                            <div class="sponsor-logo-inner">
                                                <img src="{{ asset('storage/' . $sponsor->logo) }}"
                                                    alt="{{ app()->getLocale() == 'ar' ? $sponsor->name_ar : $sponsor->name_en }}" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endif
                            @endforeach
                        </div>

                        <div class="sponsors-strip-nav">
                            <div class="custom-swiper-btn custom-swiper-prev sponsors-prev" style="background: #0D121C33 !important;">
                                <img src="{{ asset('assets/web/images/prev-arrow.png') }}" />
                            </div>
                            <div class="custom-swiper-btn custom-swiper-next sponsors-next" style="background: #0D121C33 !important;">
                                <img src="{{ asset('assets/web/images/next-arrow.png') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif



    <!-- FAQs Section -->
    @if ($faqs->count() > 0)
        <section id="faqs" class="faqs-contain section-contain">
            <div class="container">
                <div class="section-title-wrap">
                    <h2 class="section-title">{{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'FAQs' }}</h2>
                    <p class="section-subtitle">
                        {{ app()->getLocale() == 'ar'
                            ? 'إجابات على أكثر الأسئلة تكرارًا حول المؤتمر، التسجيل والمشاركة.'
                            : 'Answers to the most common questions about the conference, registration, and participation.' }}
                    </p>
                </div>
                <div class="accordion" id="faqAccordion">
                    @foreach ($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                    aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $index }}">
                                    {{ app()->getLocale() == 'ar' ? $faq->question_ar : $faq->question_en }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}"
                                class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {!! app()->getLocale() == 'ar' ? $faq->answer_ar : $faq->answer_en !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!empty($conference->map_url))
        <section class="section-contain">
            <div class="">
                <div class="conference-map-wrap">
                    {!! $conference->map_url !!}
                </div>
            </div>
        </section>
    @endif

@endsection

@push('styles')
    <style>
        .hero-conf-logo-wrap {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .hero-conf-logo {
            width: 72px;
            height: 72px;
            border-radius: 999px;
            background: rgba(15, 69, 114, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
        }

        .hero-conf-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .hero-conf-logo-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.85);
        }

        .section-subtitle {
            margin-top: 6px;
            max-width: 640px;
            font-size: 0.95rem;
            color: #6b7280;
        }

        /* Modern FAQ styling */
        .faqs-contain .accordion-item {
            border-radius: 18px !important;
            overflow: hidden;
            border: 1px solid rgba(15, 69, 114, 0.08);
            box-shadow: 0 14px 36px rgba(15, 23, 42, 0.12);
            margin-bottom: 16px;
            background-color: #ffffff !important;
        }

        .faqs-contain .accordion-button {
            font-weight: 600;
            font-size: 0.98rem;
            padding: 14px 18px;
            border: none;
            box-shadow: none;
            background-color: #ffffff;
            border-radius: 0;
        }

        .faqs-contain .accordion-button:not(.collapsed) {
            color: #0F4572;
            background: linear-gradient(90deg, rgba(15, 69, 114, 0.06), rgba(0, 170, 172, 0.06));
            box-shadow: inset 0 -1px 0 rgba(15, 69, 114, 0.08);
        }

        .faqs-contain .accordion-body {
            font-size: 0.94rem;
            color: #374151;
            line-height: 1.8;
            padding: 0 18px 16px;
        }

        .conference-map-wrap {
            width: 100%;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
            margin-bottom: -60px;
        }

        .conference-map-wrap iframe {
            width: 100%;
            min-height: 360px;
            border: 0;
            display: block;
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

        /* Sponsors strip */
        .sponsors-contain {
            position: relative;
            background-color: #ffffff;
        }

        .sponsors-filter-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
        }

        .sponsor-filter-btn {
            border: none;
            outline: none;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.85rem;
            background: #f3f4f6;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sponsor-filter-btn.active {
            background: linear-gradient(135deg, #0f4572, #00aaac);
            color: #ffffff;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.2);
        }

        .sponsors-strip-wrap {
            position: relative;
        }

        .sponsor-logo-card {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 1px 7px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(148, 163, 184, 0.25);
            height: 96px;
        }

        .sponsor-logo-inner {
            width: 100%;
            max-width: 160px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sponsor-logo-inner img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }

        .sponsors-strip-nav {
            position: absolute;
            inset-inline-end: 0;
            inset-block-start: 0;
            display: flex;
            gap: 8px;
            z-index: 5;
        }

       

        /* Exhibitors slider cards: make cards consistent */
        #exhibitors .exhb-swiper .swiper-wrapper {
            display: flex;
            flex-wrap: nowrap;
            align-items: stretch;
        }

        /* Fix slide width so all exhibitor cards are the same and aligned horizontally */
        #exhibitors .exhb-swiper .swiper-slide {
            display: flex;
            height: auto;
            width: 260px;
            margin-inline-end: 24px;
        }

        #exhibitors .news-card.spe-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            width: 100%;
            background-color: #FFFFFFE5 !important;
        }

        #exhibitors .news-card-content {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        #exhibitors .exhb-img-wrapper {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #exhibitors .exhb-img-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        #exhibitors .news-card-body {
            min-height: 80px;
            flex: 1;
        }

    </style>
@endpush

@push('scripts')
    <script>
        // Initialize Swiper for Speakers
        var speakersSwiper = new Swiper('.speakers-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });

        // Initialize Swiper for Agenda
        var conferenceSwiper = new Swiper('.conference-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        // Initialize Swiper for Sponsors strip
        var sponsorsSwiper = new Swiper('.sponsors-swiper', {
            slidesPerView: 2,
            spaceBetween: 16,
            navigation: {
                nextEl: '.sponsors-next',
                prevEl: '.sponsors-prev',
            },
            breakpoints: {
                480: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 6,
                },
            },
        });

        // Sponsors filter behaviour
        document.addEventListener('DOMContentLoaded', function () {
            var filterButtons = document.querySelectorAll('.sponsor-filter-btn');
            var sponsorSlides = document.querySelectorAll('.sponsors-swiper .swiper-slide');

            if (!filterButtons.length || !sponsorSlides.length || !sponsorsSwiper) return;

            filterButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var type = this.getAttribute('data-sponsor-filter');

                    filterButtons.forEach(function (b) { b.classList.remove('active'); });
                    this.classList.add('active');

                    sponsorSlides.forEach(function (slide) {
                        var slideType = slide.getAttribute('data-sponsor-type');
                        if (type === 'all' || slideType === type) {
                            slide.style.display = '';
                        } else {
                            slide.style.display = 'none';
                        }
                    });

                    sponsorsSwiper.update();
                    sponsorsSwiper.slideTo(0);
                });
            });
        });
    </script>
@endpush
