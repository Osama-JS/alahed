<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Speaker;

class SpeakerController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return redirect()->route('home');
        }

        $speakers = Speaker::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        return view('frontend.speakers', compact('conference', 'speakers'));
    }

    public function show(Speaker $speaker)
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference || $speaker->conference_id !== $conference->id) {
            return redirect()->route('home');
        }

        return view('frontend.speaker-show', compact('conference', 'speaker'));
    }
}
