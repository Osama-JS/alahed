<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaSession;
use App\Models\AgendaDay;
use App\Models\Conference;
use Illuminate\Http\Request;

class AgendaSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = AgendaSession::with(['agendaDay.conference']);

        if ($request->filled('conference_id')) {
            $query->whereHas('agendaDay', function ($q) use ($request) {
                $q->where('conference_id', $request->input('conference_id'));
            });
        }

        if ($request->filled('agenda_day_id')) {
            $query->where('agenda_day_id', $request->input('agenda_day_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('stage_ar', 'like', "%{$search}%")
                  ->orWhere('stage_en', 'like', "%{$search}%");
            });
        }

        $agendaSessions = $query->orderBy('start_time')
            ->paginate(20)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);
        $agendaDays = AgendaDay::orderBy('date')->get(['id', 'conference_id', 'title_ar', 'title_en', 'date']);

        return view('admin.agenda-sessions.index', [
            'agendaSessions' => $agendaSessions,
            'conferences' => $conferences,
            'agendaDays' => $agendaDays,
            'filters' => $request->only(['conference_id', 'agenda_day_id', 'search']),
        ]);
    }

    public function create()
    {
        $agendaDays = AgendaDay::with('conference')->orderBy('date')->get();
        return view('admin.agenda-sessions.create', compact('agendaDays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_day_id' => 'required|exists:agenda_days,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'stage_ar' => 'nullable|string|max:255',
            'stage_en' => 'nullable|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'order' => 'nullable|integer',
        ]);

        AgendaSession::create($validated);

        return redirect()->route('admin.agenda-sessions.index')->with('success', 'تم إضافة الجلسة بنجاح');
    }

    public function edit(AgendaSession $agendaSession)
    {
        $agendaDays = AgendaDay::with('conference')->orderBy('date')->get();
        return view('admin.agenda-sessions.edit', compact('agendaSession', 'agendaDays'));
    }

    public function update(Request $request, AgendaSession $agendaSession)
    {
        $validated = $request->validate([
            'agenda_day_id' => 'required|exists:agenda_days,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'stage_ar' => 'nullable|string|max:255',
            'stage_en' => 'nullable|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'order' => 'nullable|integer',
        ]);

        $agendaSession->update($validated);

        return redirect()->route('admin.agenda-sessions.index')->with('success', 'تم تحديث الجلسة بنجاح');
    }

    public function destroy(AgendaSession $agendaSession)
    {
        $agendaSession->delete();
        return redirect()->route('admin.agenda-sessions.index')->with('success', 'تم حذف الجلسة بنجاح');
    }
}
