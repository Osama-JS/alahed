<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();
        
        if (!$conference) {
            return redirect()->route('home');
        }
        
        $galleries = Gallery::where('conference_id', $conference->id)
            ->orderBy('order')
            ->get();
        
        return view('frontend.gallery', compact('conference', 'galleries'));
    }
}

