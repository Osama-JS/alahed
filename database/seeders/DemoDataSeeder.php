<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Conference;
use App\Models\Speaker;
use App\Models\Sponsor;
use App\Models\Statistic;
use App\Models\Exhibitor;
use App\Models\AgendaDay;
use App\Models\AgendaSession;
use App\Models\Gallery;
use App\Models\Faq;
use App\Models\Participant;
use App\Models\ExhibitionBooth;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data (simple truncate style, relies on FK cascade in DB)
        ExhibitionBooth::query()->delete();
        Participant::query()->delete();
        AgendaSession::query()->delete();
        AgendaDay::query()->delete();
        Gallery::query()->delete();
        Faq::query()->delete();
        Exhibitor::query()->delete();
        Statistic::query()->delete();
        Sponsor::query()->delete();
        Speaker::query()->delete();
        Conference::query()->delete();

        // Active conference
        $activeConference = Conference::create([
            'title_ar' => 'مؤتمر العهد للمعارض والمؤتمرات 2025',
            'title_en' => 'Al-Ahd Conference & Expo 2025',
            'description_ar' => 'منصة رائدة تجمع قادة القطاعات، المستثمرين، ورواد الأعمال لاستكشاف فرص الأعمال وتبادل الخبرات.',
            'description_en' => 'A leading platform bringing together industry leaders, investors, and entrepreneurs to explore business opportunities and share knowledge.',
            'start_date' => now()->addMonths(1)->startOfMonth(),
            'end_date' => now()->addMonths(1)->startOfMonth()->addDays(2),
            'start_time' => '09:00',
            'end_time' => '17:00',
            'location_ar' => 'مركز الرياض الدولي للمؤتمرات والمعارض، الرياض، المملكة العربية السعودية',
            'location_en' => 'Riyadh International Convention & Exhibition Center, Riyadh, Saudi Arabia',
            'hero_video_url' => null,
            'hero_image' => null,
            'floor_plan_image' => null,
            'is_active' => true,
            'order' => 1,
        ]);

        // Previous edition
        $previousConference = Conference::create([
            'title_ar' => 'مؤتمر العهد للمعارض والمؤتمرات 2024',
            'title_en' => 'Al-Ahd Conference & Expo 2024',
            'description_ar' => 'نسخة ناجحة شهدت مشاركة واسعة من مختلف القطاعات وحضور نخبة من المتحدثين.',
            'description_en' => 'A successful edition with wide participation from various sectors and top-tier speakers.',
            'start_date' => now()->subYear()->startOfYear()->addMonths(2),
            'end_date' => now()->subYear()->startOfYear()->addMonths(2)->addDays(2),
            'start_time' => '09:00',
            'end_time' => '17:00',
            'location_ar' => 'مركز جدة للمعارض والمؤتمرات، جدة، المملكة العربية السعودية',
            'location_en' => 'Jeddah Exhibition & Convention Center, Jeddah, Saudi Arabia',
            'hero_video_url' => null,
            'hero_image' => null,
            'floor_plan_image' => null,
            'is_active' => false,
            'order' => 2,
        ]);

        // Speakers
        $speakers = [
            [
                'name_ar' => 'د. أحمد السبيعي',
                'name_en' => 'Dr. Ahmed Al-Subaie',
                'title_ar' => 'خبير تطوير الأعمال',
                'title_en' => 'Business Development Expert',
                'company_ar' => 'شركة رؤى المستقبل',
                'company_en' => 'Future Vision Co.',
            ],
            [
                'name_ar' => 'مها العتيبي',
                'name_en' => 'Maha Al-Otaibi',
                'title_ar' => 'رائدة أعمال ومستثمرة',
                'title_en' => 'Entrepreneur & Investor',
                'company_ar' => 'مجموعة العتيبي للاستثمار',
                'company_en' => 'Al-Otaibi Investment Group',
            ],
            [
                'name_ar' => 'جون سميث',
                'name_en' => 'John Smith',
                'title_ar' => 'مدير الابتكار',
                'title_en' => 'Director of Innovation',
                'company_ar' => 'شركة التقنية المتقدمة',
                'company_en' => 'Advanced Tech Inc.',
            ],
        ];

        foreach ($speakers as $index => $data) {
            Speaker::create([
                'conference_id' => $activeConference->id,
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
                'title_ar' => $data['title_ar'],
                'title_en' => $data['title_en'],
                'bio_ar' => 'سيرة موجزة عن خبرات المتحدث وإنجازاته المهنية في مجالات الأعمال والابتكار.',
                'bio_en' => 'A brief biography highlighting the speaker’s experience and achievements in business and innovation.',
                'image' => null,
                'company_ar' => $data['company_ar'],
                'company_en' => $data['company_en'],
                'linkedin' => 'https://www.linkedin.com/',
                'twitter' => 'https://twitter.com/',
                'facebook' => 'https://facebook.com/',
                'order' => $index + 1,
            ]);
        }

        // Sponsors
        $sponsorTypes = ['platinum', 'gold', 'silver', 'bronze', 'partner'];
        foreach ($sponsorTypes as $i => $type) {
            Sponsor::create([
                'conference_id' => $activeConference->id,
                'name_ar' => 'راعي ' . ($i + 1),
                'name_en' => 'Sponsor ' . ($i + 1),
                'logo' => null,
                'website' => 'https://example-sponsor' . ($i + 1) . '.com',
                'type' => $type,
                'order' => $i + 1,
            ]);
        }

        // Statistics
        $stats = [
            ['label_ar' => 'زائر', 'label_en' => 'Visitors', 'value' => 15000],
            ['label_ar' => 'عارض', 'label_en' => 'Exhibitors', 'value' => 250],
            ['label_ar' => 'متحدث', 'label_en' => 'Speakers', 'value' => 60],
            ['label_ar' => 'جلسة وورشة عمل', 'label_en' => 'Sessions & Workshops', 'value' => 80],
        ];

        foreach ($stats as $index => $stat) {
            Statistic::create([
                'conference_id' => $activeConference->id,
                'label_ar' => $stat['label_ar'],
                'label_en' => $stat['label_en'],
                'value' => $stat['value'],
                'icon' => 'fas fa-chart-line',
                'order' => $index + 1,
            ]);
        }

        // Exhibitors
        for ($i = 1; $i <= 8; $i++) {
            Exhibitor::create([
                'conference_id' => $activeConference->id,
                'name_ar' => 'شركة العارض ' . $i,
                'name_en' => 'Exhibitor Company ' . $i,
                'description_ar' => 'شركة متخصصة في تقديم حلول مبتكرة في مجال التقنية والخدمات.',
                'description_en' => 'A company specialized in providing innovative solutions in technology and services.',
                'logo' => null,
                'website' => 'https://exhibitor' . $i . '.com',
                'booth_number' => 'B' . str_pad((string)$i, 2, '0', STR_PAD_LEFT),
                'order' => $i,
            ]);
        }

        // Agenda Days & Sessions
        $day1 = AgendaDay::create([
            'conference_id' => $activeConference->id,
            'date' => $activeConference->start_date,
            'title_ar' => 'اليوم الأول',
            'title_en' => 'Day One',
            'description_ar' => 'اليوم الافتتاحي للمؤتمر مع كلمات ترحيبية وجلسات رئيسية.',
            'description_en' => 'Opening day with welcome remarks and keynote sessions.',
            'order' => 1,
        ]);

        $day2 = AgendaDay::create([
            'conference_id' => $activeConference->id,
            'date' => $activeConference->start_date->copy()->addDay(),
            'title_ar' => 'اليوم الثاني',
            'title_en' => 'Day Two',
            'description_ar' => 'جلسات وورش عمل متخصصة في قطاعات الأعمال المختلفة.',
            'description_en' => 'Specialized sessions and workshops across business sectors.',
            'order' => 2,
        ]);

        $sessions = [
            [
                'day' => $day1,
                'title_ar' => 'جلسة رئيسية: مستقبل المعارض والمؤتمرات',
                'title_en' => 'Keynote: The Future of Exhibitions & Conferences',
                'start' => '10:00',
                'end' => '11:00',
                'stage_ar' => 'القاعة الرئيسية',
                'stage_en' => 'Main Hall',
            ],
            [
                'day' => $day1,
                'title_ar' => 'حلقة نقاش: التحول الرقمي في قطاع المعارض',
                'title_en' => 'Panel: Digital Transformation in Exhibitions',
                'start' => '12:00',
                'end' => '13:30',
                'stage_ar' => 'قاعة النقاشات',
                'stage_en' => 'Panel Hall',
            ],
            [
                'day' => $day2,
                'title_ar' => 'ورشة عمل: تصميم تجربة زائر مميزة',
                'title_en' => 'Workshop: Designing an Outstanding Visitor Experience',
                'start' => '10:30',
                'end' => '12:00',
                'stage_ar' => 'قاعة الورش',
                'stage_en' => 'Workshop Room',
            ],
        ];

        foreach ($sessions as $i => $session) {
            AgendaSession::create([
                'agenda_day_id' => $session['day']->id,
                'title_ar' => $session['title_ar'],
                'title_en' => $session['title_en'],
                'description_ar' => 'وصف موجز للجلسة يوضح أهدافها والمحاور التي سيتم مناقشتها.',
                'description_en' => 'A concise description outlining the session objectives and main discussion points.',
                'stage_ar' => $session['stage_ar'],
                'stage_en' => $session['stage_en'],
                'start_time' => $session['start'],
                'end_time' => $session['end'],
                'order' => $i + 1,
            ]);
        }

        // Gallery
        for ($i = 1; $i <= 6; $i++) {
            Gallery::create([
                'conference_id' => $activeConference->id,
                'title_ar' => 'صورة من فعاليات المؤتمر ' . $i,
                'title_en' => 'Conference Highlight ' . $i,
                'image' => null,
                'type' => 'image',
                'order' => $i,
            ]);
        }

        // FAQs
        $faqs = [
            [
                'question_ar' => 'أين يُقام المؤتمر؟',
                'question_en' => 'Where is the conference held?',
                'answer_ar' => 'يُقام المؤتمر في مركز الرياض الدولي للمؤتمرات والمعارض في مدينة الرياض.',
                'answer_en' => 'The conference is held at Riyadh International Convention & Exhibition Center in Riyadh.',
            ],
            [
                'question_ar' => 'كيف يمكنني التسجيل لحضور المؤتمر؟',
                'question_en' => 'How can I register to attend?',
                'answer_ar' => 'يمكنك التسجيل عبر صفحة التسجيل في الموقع وملء النموذج الإلكتروني.',
                'answer_en' => 'You can register through the registration page on the website and fill out the online form.',
            ],
            [
                'question_ar' => 'هل المشاركة في المعرض مجانية؟',
                'question_en' => 'Is participation in the exhibition free?',
                'answer_ar' => 'حضور المؤتمر مجاني للزوار، بينما تختلف رسوم العارضين حسب نوع الجناح.',
                'answer_en' => 'Attendance is free for visitors; exhibitor fees vary depending on booth type.',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::create([
                'conference_id' => $activeConference->id,
                'question_ar' => $faq['question_ar'],
                'question_en' => $faq['question_en'],
                'answer_ar' => $faq['answer_ar'],
                'answer_en' => $faq['answer_en'],
                'order' => $index + 1,
            ]);
        }

        // Booths & Participants
        $boothTypes = ['main', 'strategic', 'premium', 'gold', 'silver', 'standard'];
        $booths = [];
        for ($i = 1; $i <= 12; $i++) {
            $type = $boothTypes[($i - 1) % count($boothTypes)];
            $booths[] = ExhibitionBooth::create([
                'conference_id' => $activeConference->id,
                'name' => 'Booth ' . $i,
                'slug' => Str::slug('Booth ' . $i),
                'type' => $type,
                'width' => 3.00,
                'height' => 3.00,
                'area' => 9.00,
                'price' => 5000 + ($i * 250),
                'currency' => 'SAR',
                'status' => $i % 3 === 0 ? 'reserved' : 'available',
                'participant_id' => null,
                'exhibitor_id' => null,
                'reserved_at' => $i % 3 === 0 ? now()->subDays($i) : null,
                'image' => null,
                'description_ar' => 'جناح عرض مجهز بمساحة مناسبة لاستقبال الزوار وعرض المنتجات والخدمات.',
                'description_en' => 'Exhibition booth equipped with adequate space to welcome visitors and showcase products and services.',
                'notes' => 'Demo booth for seeding purposes.',
                'order' => $i,
            ]);
        }

        // Link some exhibitors to booths
        $allExhibitors = Exhibitor::where('conference_id', $activeConference->id)->get();
        foreach ($allExhibitors as $index => $exhibitor) {
            if (isset($booths[$index])) {
                $booth = $booths[$index];
                $booth->exhibitor_id = $exhibitor->id;
                $booth->save();
            }
        }

        // Participants (some reserving booths)
        for ($i = 1; $i <= 10; $i++) {
            $participantBooth = $i % 2 === 0 && isset($booths[$i - 1]) ? $booths[$i - 1] : null;

            $participant = Participant::create([
                'conference_id' => $activeConference->id,
                'name' => 'Participant ' . $i,
                'email' => 'participant' . $i . '@example.com',
                'phone' => '+9665012345' . str_pad((string)$i, 2, '0', STR_PAD_LEFT),
                'company' => 'Company ' . $i,
                'job_title' => 'Manager',
                'type' => $i % 3 === 0 ? 'exhibitor' : 'visitor',
                'booth_id' => $participantBooth?->id,
            ]);

            if ($participantBooth) {
                $participantBooth->participant_id = $participant->id;
                $participantBooth->status = 'reserved';
                $participantBooth->reserved_at = now()->subDays(2);
                $participantBooth->save();
            }
        }
    }
}
