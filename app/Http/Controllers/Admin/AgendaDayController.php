<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaDay;
use App\Models\Conference;
use Illuminate\Http\Request;

class AgendaDayController extends Controller
{
    public function index(Request $request)
    {
        $query = AgendaDay::with('conference');

        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->input('conference_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        $agendaDays = $query->orderBy('date')
            ->paginate(20)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.agenda-days.index', [
            'agendaDays' => $agendaDays,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'search', 'date']),
        ]);
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.agenda-days.create', compact('conferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'date' => 'required|date',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        AgendaDay::create($validated);

        return redirect()->route('admin.agenda-days.index')->with('success', 'تم إضافة اليوم بنجاح');
    }

    public function edit(AgendaDay $agendaDay)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.agenda-days.edit', compact('agendaDay', 'conferences'));
    }

    public function update(Request $request, AgendaDay $agendaDay)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'date' => 'required|date',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $agendaDay->update($validated);

        return redirect()->route('admin.agenda-days.index')->with('success', 'تم تحديث اليوم بنجاح');
    }

    public function destroy(AgendaDay $agendaDay)
    {
        $agendaDay->delete();
        return redirect()->route('admin.agenda-days.index')->with('success', 'تم حذف اليوم بنجاح');
    }
}
