<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('frontend.*', function ($view) {
            $view->with('siteSettings', [
                'logo' => Setting::get('site_logo'),
                'favicon' => Setting::get('site_favicon'),
                'name_ar' => Setting::get('site_name_ar'),
                'name_en' => Setting::get('site_name_en'),
                'short_description_ar' => Setting::get('short_description_ar'),
                'short_description_en' => Setting::get('short_description_en'),
                'about_ar' => Setting::get('about_company_ar'),
                'about_en' => Setting::get('about_company_en'),
                'seo_keywords_ar' => Setting::get('seo_keywords_ar'),
                'seo_keywords_en' => Setting::get('seo_keywords_en'),
                'meta_description_ar' => Setting::get('meta_description_ar'),
                'meta_description_en' => Setting::get('meta_description_en'),
                'contact_email' => Setting::get('contact_email'),
                'contact_phone' => Setting::get('contact_phone'),
                'contact_address_ar' => Setting::get('contact_address_ar'),
                'contact_address_en' => Setting::get('contact_address_en'),
                'social_facebook' => Setting::get('facebook_url'),
                'social_twitter' => Setting::get('twitter_url'),
                'social_linkedin' => Setting::get('linkedin_url'),
                'social_youtube' => Setting::get('youtube_url'),
                'social_instagram' => Setting::get('instagram_url'),
            ]);
        });
    }
}
