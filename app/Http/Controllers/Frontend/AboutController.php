<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Statistic;

class AboutController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return redirect()->route('home');
        }

            $statistics = Statistic::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();
        return view('frontend.about', compact('conference','statistics'));
    }
}
