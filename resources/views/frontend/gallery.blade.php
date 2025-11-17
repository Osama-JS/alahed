@extends('frontend.layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'معرض الصور - العهد' : 'Gallery - Al-Ahd')

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
                        <span>{{ app()->getLocale() == 'ar' ? 'معرض الصور' : 'Gallery' }}</span>
                    </li>
                </ul>
            </div>
            <div class="pages-title-wrap">
                <strong class="pages-title">{{ app()->getLocale() == 'ar' ? 'معرض الصور' : 'Gallery' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Section (Biban-style) -->
<section id="gallery" class="gallery-contain section-contain">
    <div class="">
       

    
<div class="edition-container gallery-container">
           
        @if($galleries->count() > 0)
            @php
                $firstItem = $galleries->first();
                $firstTitle = app()->getLocale() == 'ar' ? ($firstItem->title_ar ?? '') : ($firstItem->title_en ?? '');
            @endphp

            <div class="gallery-container row">
                <!-- Thumbnails -->
                <div class="col-md-2 thumbnails" style="flex-direction: column; overflow: hidden auto; max-height: 842px;">
                    <div class="thumbnails">
                        @foreach($galleries as $index => $item)
                            @php
                                $thumbTitle = app()->getLocale() == 'ar' ? ($item->title_ar ?? '') : ($item->title_en ?? '');
                            @endphp
                           
                            <div
                                class="thumbnail-img gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                                data-type="{{ $item->type }}"
                                data-src="{{ asset('storage/' . $item->image) }}"
                                data-title="{{ $thumbTitle }}">
                                @if($item->type === 'image')
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $thumbTitle }}" class="img-fluid" />
                                @else
                                    <div class="thumb-video-wrapper">
                                        <div class="thumb-video-overlay">
                                            <i class="fas fa-play"></i>
                                        </div>
                                        <video muted preload="metadata" playsinline>
                                            <source src="{{ asset('storage/' . $item->image) }}" type="video/mp4">
                                        </video>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Main display -->
                <div class="col-md-10">
                    <div class="img-full">
                        <div class="main-media-wrapper" data-current-type="{{ $firstItem->type }}">
                            @if($firstItem->type === 'image')
                                <img
                                    src="{{ asset('storage/' . $firstItem->image) }}"
                                    alt="{{ $firstTitle }}"
                                    class="main-image"
                                    id="gallery-main-image">
                            @else
                                <div class="custom-video-player">
                                    <video
                                        class="main-image custom-video"
                                        id="gallery-main-video"
                                        preload="metadata"
                                        playsinline>
                                        <source src="{{ asset('storage/' . $firstItem->image) }}" type="video/mp4">
                                    </video>
                                    <button type="button" class="cv-btn cv-play" aria-label="Play/Pause">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                {{ app()->getLocale() == 'ar' ? 'لا توجد صور أو فيديوهات حالياً' : 'No images or videos available at the moment' }}
            </div>
        @endif
    </div>
</section>




@endsection

@push('styles')
<style>
    /* تخصيصات بسيطة إضافية فوق تنسيق Biban في edition.css */
    .gallery-container {
        margin: 60px 0;
    }

    .gallery-thumb {
        cursor: pointer;
        height: 140px;
    }

    @media (min-width: 992px) {
        .gallery-thumb {
            height: 160px;
        }
    }

    .gallery-thumb img,
    .gallery-thumb video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 20px;
        display: block;
    }

    .gallery-thumb.active {
        border: 3px solid rgba(255, 158, 42, 1);
    }

    .thumb-video-wrapper {
        position: relative;
        border-radius: 20px;
        height: 100%;

        overflow: hidden;
    }

    .thumb-video-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.7), rgba(15, 69, 114, 0.6));
        color: #fff;
        font-size: 1.8rem;
    }

    .main-media-wrapper {
        width: 100%;
        max-height: 840px;
        height: 70vh;
    }

    .main-media-title {
        margin-top: 16px;
        font-size: 0.95rem;
        color: #111827;
        text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
    }

    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 40px;
        display: block;
    }

    /* Custom video player */
    .custom-video-player {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .cv-btn {
        border: none;
        background: transparent;
        color: inherit;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
        position: absolute;
        left: 20px;
        bottom: 20px;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(15, 69, 114, 0.9));
        color: #F9FAFB;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.45);
    }

    .cv-btn:hover {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(15, 69, 114, 0.95));
        transform: translateY(-1px);
    }

    @media (max-width: 767px) {
        .gallery-container {
            margin: 32px 0;
        }

        .gallery-thumb img,
        .gallery-thumb video,
        .main-image {
            border-radius: 16px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var thumbs = document.querySelectorAll('.gallery-thumb');
        var mainWrapper = document.querySelector('.main-media-wrapper');
        var mainTitleEl = document.getElementById('gallery-main-title');

        if (!thumbs.length || !mainWrapper) return;

        // Ensure video thumbnails show an internal frame (like YouTube preview)
        document.querySelectorAll('.thumb-video-wrapper video').forEach(function (video) {
            video.addEventListener('loadedmetadata', function () {
                try {
                    if (video.duration && video.duration !== Infinity) {
                        var targetTime = Math.min(1, video.duration / 3);
                        video.currentTime = targetTime;
                    }
                } catch (e) {
                    // ignore seeking errors
                }
            });
        });

        thumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                var type = this.getAttribute('data-type');
                var src = this.getAttribute('data-src');
                var title = this.getAttribute('data-title') || '';

                // active state
                thumbs.forEach(function (t) { t.classList.remove('active'); });
                this.classList.add('active');

                // replace main media
                mainWrapper.innerHTML = '';

                if (type === 'video') {
                    var player = document.createElement('div');
                    player.className = 'custom-video-player';

                    var video = document.createElement('video');
                    video.className = 'main-image custom-video';
                    video.preload = 'metadata';
                    video.playsInline = true;
                    video.muted = false;

                    var source = document.createElement('source');
                    source.src = src;
                    source.type = 'video/mp4';
                    video.appendChild(source);

                    var playBtn = document.createElement('button');
                    playBtn.type = 'button';
                    playBtn.className = 'cv-btn cv-play';
                    playBtn.innerHTML = '<i class="fas fa-pause"></i>';

                    player.appendChild(video);
                    player.appendChild(playBtn);

                    mainWrapper.appendChild(player);
                    mainWrapper.setAttribute('data-current-type', 'video');

                    // تشغيل تلقائي عند اختيار الفيديو
                    var isPlaying = false;

                    var autoPlay = function () {
                        video.play().then(function () {
                            isPlaying = true;
                            playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                        }).catch(function () {
                            // إذا منع المتصفح التشغيل التلقائي يبقى الزر متاحاً
                            isPlaying = false;
                            playBtn.innerHTML = '<i class="fas fa-play"></i>';
                        });
                    };

                    video.addEventListener('loadedmetadata', function () {
                        autoPlay();
                    });

                    playBtn.addEventListener('click', function () {
                        if (isPlaying) {
                            video.pause();
                        } else {
                            video.play();
                        }
                    });

                    video.addEventListener('play', function () {
                        isPlaying = true;
                        playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    });

                    video.addEventListener('pause', function () {
                        isPlaying = false;
                        playBtn.innerHTML = '<i class="fas fa-play"></i>';
                    });
                } else {
                    var img = document.createElement('img');
                    img.src = src;
                    img.alt = title;
                    img.className = 'main-image';
                    mainWrapper.appendChild(img);
                    mainWrapper.setAttribute('data-current-type', 'image');
                }

                if (mainTitleEl) {
                    mainTitleEl.textContent = title;
                }
            });
        });
    });
</script>
@endpush

