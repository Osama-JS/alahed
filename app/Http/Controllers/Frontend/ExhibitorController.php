<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Exhibitor;

class ExhibitorController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return redirect()->route('home');
        }

        $exhibitors = Exhibitor::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        return view('frontend.exhibitors', compact('conference', 'exhibitors'));
    }

    public function show(Exhibitor $exhibitor)
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference || $exhibitor->conference_id !== $conference->id) {
            return redirect()->route('home');
        }

        return view('frontend.exhibitor-show', compact('conference', 'exhibitor'));
    }
}
