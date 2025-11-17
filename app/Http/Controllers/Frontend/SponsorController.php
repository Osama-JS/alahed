<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return redirect()->route('home');
        }

        $sponsors = Sponsor::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();

        return view('frontend.sponsors', compact('conference', 'sponsors'));
    }
}
