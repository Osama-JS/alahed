<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\ExhibitionBooth;
use App\Models\BoothBooking;
use Illuminate\Http\Request;

class BoothController extends Controller
{
    public function index(Request $request)
    {
        $conference = Conference::where('is_active', true)->first();

        if (!$conference) {
            return view('frontend.no-active-conference');
        }

        $boothsQuery = ExhibitionBooth::with(['participant', 'exhibitor'])
            ->where('conference_id', $conference->id);

        if ($request->filled('status') && in_array($request->status, ['available', 'reserved'])) {
            $boothsQuery->where('status', $request->status);
        }

        $booths = $boothsQuery
            ->orderBy('order')
            ->orderBy('type')
            ->get();

        return view('frontend.booths', compact('conference', 'booths'));
    }

    public function show(ExhibitionBooth $booth)
    {
        return view('frontend.booth-detail', compact('booth'));
    }

    public function book(Request $request, ExhibitionBooth $booth)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'bank_receipt' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ]);

        // Handle optional bank receipt upload
        if ($request->hasFile('bank_receipt')) {
            $path = $request->file('bank_receipt')->store('booth-bank-receipts', 'public');
            $validated['bank_receipt'] = $path;
        }

        BoothBooking::create(array_merge($validated, [
            'exhibition_booth_id' => $booth->id,
            'status' => 'pending',
        ]));

        return back()->with('success', app()->getLocale() === 'ar'
            ? 'تم إرسال طلب الحجز بنجاح، وسيتم التواصل معك من قبل فريق التنظيم.'
            : 'Your booking request has been submitted. The organizing team will contact you soon.');
    }
}
