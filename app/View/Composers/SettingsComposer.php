<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $locale = app()->getLocale();
        
        $settings = [
            // Branding
            'site_logo' => Setting::get('site_logo'),
            'site_favicon' => Setting::get('site_favicon'),
            'site_name' => $locale === 'ar' 
                ? Setting::get('site_name_ar', 'العهد لتنظيم المعارض والمؤتمرات')
                : Setting::get('site_name_en', 'Al-Ahd Events & Conferences'),
            
            // Content
            'short_description' => $locale === 'ar'
                ? Setting::get('short_description_ar')
                : Setting::get('short_description_en'),
            'about_us' => $locale === 'ar'
                ? Setting::get('about_us_ar')
                : Setting::get('about_us_en'),
            
            // SEO
            'seo_keywords' => $locale === 'ar'
                ? Setting::get('seo_keywords_ar')
                : Setting::get('seo_keywords_en'),
            'meta_description' => $locale === 'ar'
                ? Setting::get('meta_description_ar')
                : Setting::get('meta_description_en'),
            
            // Contact
            'contact_email' => Setting::get('contact_email'),
            'contact_phone' => Setting::get('contact_phone'),
            'contact_address' => $locale === 'ar'
                ? Setting::get('contact_address_ar')
                : Setting::get('contact_address_en'),
            
            // Social Media
            'facebook_url' => Setting::get('facebook_url'),
            'twitter_url' => Setting::get('twitter_url'),
            'linkedin_url' => Setting::get('linkedin_url'),
            'youtube_url' => Setting::get('youtube_url'),
            'instagram_url' => Setting::get('instagram_url'),
        ];
        
        $view->with('settings', $settings);
    }
}

