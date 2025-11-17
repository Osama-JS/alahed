<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Participant;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return redirect()->route('home');
        }

        return view('frontend.registration', compact('conference'));
    }

    public function store(Request $request)
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return redirect()->route('home')->with('error', 'لا يوجد مؤتمر نشط حالياً');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'type' => 'required|in:visitor,exhibitor,speaker,sponsor',
        ]);

        $validated['conference_id'] = $conference->id;

        Participant::create($validated);

        return redirect()->back()->with('success', 'تم التسجيل بنجاح! سنتواصل معك قريباً.');
    }
}
