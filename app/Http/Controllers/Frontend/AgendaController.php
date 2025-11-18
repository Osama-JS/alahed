<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\AgendaDay;

class AgendaController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return redirect()->route('home');
        }

        $agendaDays = AgendaDay::where('conference_id', $conference->id)
            ->with('sessions')
            ->orderBy('order')
            ->get();

        return view('frontend.agenda', compact('conference', 'agendaDays'));
    }

    public function show(AgendaDay $day)
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference || $day->conference_id !== $conference->id) {
            return redirect()->route('agenda');
        }

        $day->load('sessions');

        return view('frontend.agenda-day', [
            'conference' => $conference,
            'day' => $day,
        ]);
    }
}
