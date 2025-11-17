<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\ExhibitionBooth;

class BoothController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return view('frontend.no-active-conference');
        }

        $booths = ExhibitionBooth::with(['participant', 'exhibitor'])
            ->where('conference_id', $conference->id)
            ->orderBy('order')
            ->orderBy('type')
            ->get();

        return view('frontend.booths', compact('conference', 'booths'));
    }

    public function show(ExhibitionBooth $booth)
    {
        return view('frontend.booth-detail', compact('booth'));
    }
}
