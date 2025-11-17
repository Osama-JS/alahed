<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;

class PreviousEditionController extends Controller
{
    public function index()
    {
        $conferences = Conference::where('is_active', false)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('frontend.previous-editions', compact('conferences'));
    }

    public function show($id)
    {
        $conference = Conference::where('is_active', false)->findOrFail($id);

        // Get all related data for this conference
        $speakers = $conference->speakers()->orderBy('order')->get();
        $sponsors = $conference->sponsors()->orderBy('order')->get();
        $statistics = $conference->statistics()->orderBy('order')->get();
        $exhibitors = $conference->exhibitors()->orderBy('order')->get();
        $agendaDays = $conference->agendaDays()->with('sessions')->orderBy('order')->get();
        $galleries = $conference->galleries()->orderBy('order')->get();
        $faqs = $conference->faqs()->orderBy('order')->get();

        return view('frontend.previous-edition-detail', compact(
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
}
