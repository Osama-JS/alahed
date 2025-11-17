<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'site_favicon',
                'value' => '',
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'site_name_ar',
                'value' => 'العهد لتنظيم المعارض والمؤتمرات',
                'type' => 'text',
                'group' => 'branding',
            ],
            [
                'key' => 'site_name_en',
                'value' => 'Al-Ahd Events & Conferences',
                'type' => 'text',
                'group' => 'branding',
            ],
            [
                'key' => 'short_description_ar',
                'value' => 'المنصة الرائدة لتنظيم المعارض والمؤتمرات في المملكة العربية السعودية.',
                'type' => 'textarea',
                'group' => 'content',
            ],
            [
                'key' => 'short_description_en',
                'value' => 'Saudi Arabia’s leading platform for organizing exhibitions and conferences.',
                'type' => 'textarea',
                'group' => 'content',
            ],
            [
                'key' => 'about_company_ar',
                'value' => "العهد لتنظيم المعارض والمؤتمرات هي شركة سعودية متخصصة في إدارة وتنفيذ الفعاليات الكبرى على مستوى المنطقة، نقدم حلولاً متكاملة تركز على الابتكار والتميز.",
                'type' => 'textarea',
                'group' => 'content',
            ],
            [
                'key' => 'about_company_en',
                'value' => "Al-Ahd is a Saudi-based event management company delivering end-to-end solutions for major conferences and exhibitions with a focus on innovation and excellence.",
                'type' => 'textarea',
                'group' => 'content',
            ],
            [
                'key' => 'seo_keywords_ar',
                'value' => 'العهد,معارض,مؤتمرات,تنظيم فعاليات,السعودية',
                'type' => 'textarea',
                'group' => 'seo',
            ],
            [
                'key' => 'seo_keywords_en',
                'value' => 'Al-Ahd,events,exhibitions,conferences,event management,Saudi Arabia',
                'type' => 'textarea',
                'group' => 'seo',
            ],
            [
                'key' => 'meta_description_ar',
                'value' => 'العهد لتنظيم المعارض والمؤتمرات تقدم حلولاً متكاملة لتنظيم الفعاليات والمعارض في المملكة العربية السعودية بمستوى عالمي من الاحترافية.',
                'type' => 'textarea',
                'group' => 'seo',
            ],
            [
                'key' => 'meta_description_en',
                'value' => 'Al-Ahd provides integrated event management solutions for exhibitions and conferences across Saudi Arabia with world-class professionalism.',
                'type' => 'textarea',
                'group' => 'seo',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@alahd.sa',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+966 55 123 4567',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_address_ar',
                'value' => 'الرياض، المملكة العربية السعودية',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_address_en',
                'value' => 'Riyadh, Saudi Arabia',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://www.facebook.com/alahd',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/alahd',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://www.linkedin.com/company/alahd',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://www.youtube.com/@alahd',
                'type' => 'text',
                'group' => 'social',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://www.instagram.com/alahd',
                'type' => 'text',
                'group' => 'social',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                ]
            );
        }
    }
}


