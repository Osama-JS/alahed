@php
    $locale = app()->getLocale();
    $siteName = $locale === 'ar'
        ? ($siteSettings['name_ar'] ?? 'العهد لتنظيم المعارض والمؤتمرات')
        : ($siteSettings['name_en'] ?? 'Al-Ahd for Organizing Exhibitions and Conferences');
    $aboutText = $locale === 'ar'
        ?  $siteSettings['short_description_ar'] ?? ''
        :  $siteSettings['short_description_en'] ?? '';
    $contactEmail = $siteSettings['contact_email'] ?? null;
    $contactPhone = $siteSettings['contact_phone'] ?? null;
    $contactAddress = $locale === 'ar'
        ? ($siteSettings['contact_address_ar'] ?? '')
        : ($siteSettings['contact_address_en'] ?? '');
    $logoPath = $siteSettings['logo'] ?? null;
    $socialLinks = [
        'facebook' => $siteSettings['social_facebook'] ?? null,
        'twitter' => $siteSettings['social_twitter'] ?? null,
        'linkedin' => $siteSettings['social_linkedin'] ?? null,
        'youtube' => $siteSettings['social_youtube'] ?? null,
        'instagram' => $siteSettings['social_instagram'] ?? null,
    ];
@endphp
<footer class="footer-contain">
    <div class="footer-wrap">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="footer-content-head">
                        <div class="footer-logo">
                            @if($logoPath)
                                <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $siteName }}" />
                            @else
                                <img src="{{ asset('assets/frontend/img/logo.png') }}" alt="{{ $siteName }}" />
                            @endif
                        </div>
                    </div>
                    <div class="footer-content-body">
                        @if($aboutText)
                            <p>{!! $aboutText !!}</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer-contact-block mb-3">
                        <strong>{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact Us' }}</strong>
                        @if($contactEmail)
                            <div class="footer-contact-item">
                                <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                            </div>
                        @endif
                        @if($contactPhone)
                            <div class="footer-contact-item">
                                <a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}">{{ $contactPhone }}</a>
                            </div>
                        @endif
                        @if($contactAddress)
                            <div class="footer-contact-item footer-address">
                                <span>{{ $contactAddress }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="footer-social-block">
                        <strong>{{ $locale === 'ar' ? 'تابعنا' : 'Follow Us' }}</strong>
                        <div class="social-links">
                            @foreach($socialLinks as $network => $url)
                                @if($url)
                                    <a href="{{ $url }}" target="_blank" rel="noopener">
                                        @switch($network)
                                            @case('facebook')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm8,191.63V152h24a8,8,0,0,0,0-16H136V112a16,16,0,0,1,16-16h16a8,8,0,0,0,0-16H152a32,32,0,0,0-32,32v24H96a8,8,0,0,0,0,16h24v63.63a88,88,0,1,1,16,0Z"></path>
                                                </svg>
                                                @break
                                            @case('twitter')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M221.66,58.34a8,8,0,0,0-11.32,0L160,108.69,114.34,63A40,40,0,0,0,57.37,119L96,157.66,34.34,219.31a8,8,0,0,0,11.32,11.32L107.31,169,152,213.66a40,40,0,0,0,56.57-56.57L170.69,119l50.97-50.97A8,8,0,0,0,221.66,58.34ZM152,197.66,74.34,120,120,74.34,197.66,152A24,24,0,0,1,152,197.66Z"></path>
                                                </svg>
                                                @break
                                            @case('linkedin')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M216,24H40A16,16,0,0,0,24,40V216a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V40A16,16,0,0,0,216,24Zm0,192H40V40H216V216ZM96,112v64a8,8,0,0,1-16,0V112a8,8,0,0,1,16,0Zm88,28v36a8,8,0,0,1-16,0V140a20,20,0,0,0-40,0v36a8,8,0,0,1-16,0V112a8,8,0,0,1,15.79-1.78A36,36,0,0,1,184,140ZM100,84A12,12,0,1,1,88,72,12,12,0,0,1,100,84Z"></path>
                                                </svg>
                                                @break
                                            @case('youtube')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M247.35,72.49c-1.71-19.53-16.25-35-35.6-37.36C175.77,32,143.63,32,112.62,32,81.61,32,49.48,32,44.25,35.13,24.9,37.49,10.36,52.95,8.65,72.49,6.13,104.46,6.13,151.54,8.65,183.51c1.71,19.53,16.25,35,35.6,37.36,5.23,3.15,37.36,3.15,68.37,3.15s63.14,0,68.37-3.15c19.35-2.33,33.89-17.83,35.6-37.36C249.87,183.51,249.87,136.43,247.35,104.46ZM106.67,168V96l69.33,36Z"></path>
                                                </svg>
                                                @break
                                            @case('instagram')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160ZM176,24H80A56.06,56.06,0,0,0,24,80v96a56.06,56.06,0,0,0,56,56h96a56.06,56.06,0,0,0,56-56V80A56.06,56.06,0,0,0,176,24Zm40,152a40,40,0,0,1-40,40H80a40,40,0,0,1-40-40V80A40,40,0,0,1,80,40h96a40,40,0,0,1,40,40ZM192,76a12,12,0,1,1-12-12A12,12,0,0,1,192,76Z"></path>
                                                </svg>
                                                @break
                                        @endswitch
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-copy">{{ $siteName }} © {{ date('Y') }}</span>
            </div>
        </div>
    </div>
</footer>

