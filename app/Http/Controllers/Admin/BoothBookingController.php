<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoothBooking;
use Illuminate\Http\Request;

class BoothBookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = BoothBooking::with('booth')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.booth-bookings.index', compact('bookings'));
    }

    public function show(BoothBooking $boothBooking)
    {
        $booking = $boothBooking->load('booth');
        return view('admin.booth-bookings.show', compact('booking'));
    }

    public function update(Request $request, BoothBooking $boothBooking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $boothBooking->update($validated);

        return redirect()->route('admin.booth-bookings.show', $boothBooking)
            ->with('success', __('Status updated successfully'));
    }
}
