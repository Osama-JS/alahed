<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Speaker;
use App\Models\Sponsor;
use App\Models\Statistic;
use App\Models\Exhibitor;
use App\Models\AgendaDay;
use App\Models\Gallery;
use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get active conference
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return view('frontend.no-active-conference');
        }

        // Get all related data for the active conference
        $speakers = Speaker::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        $sponsors = Sponsor::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        $statistics = Statistic::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        $exhibitors = Exhibitor::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        $agendaDays = AgendaDay::where('conference_id', $conference->id)
            ->with('sessions')
            ->orderBy('order')
            ->get();

        $galleries = Gallery::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        $faqs = Faq::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        return view('frontend.home', compact(
            'conference',
            'speakers',
            'sponsors',
            'statistics',
            'exhibitors',
            'agendaDays',
            'galleries',
            'faqs'
        ));
    }

    public function switchLanguage($locale)
    {
        if (in_array($locale, ['ar', 'en'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
