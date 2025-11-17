<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\Conference;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $query = Statistic::with('conference');

        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->input('conference_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('label_ar', 'like', "%{$search}%")
                  ->orWhere('label_en', 'like', "%{$search}%")
                  ->orWhere('value', 'like', "%{$search}%");
            });
        }

        $statistics = $query->orderBy('order')
            ->paginate(20)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.statistics.index', [
            'statistics' => $statistics,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'search']),
        ]);
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.statistics.create', compact('conferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'label_ar' => 'required|string|max:255',
            'label_en' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        Statistic::create($validated);

        return redirect()->route('admin.statistics.index')->with('success', 'تم إضافة الإحصائية بنجاح');
    }

    public function edit(Statistic $statistic)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.statistics.edit', compact('statistic', 'conferences'));
    }

    public function update(Request $request, Statistic $statistic)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'label_ar' => 'required|string|max:255',
            'label_en' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $statistic->update($validated);

        return redirect()->route('admin.statistics.index')->with('success', 'تم تحديث الإحصائية بنجاح');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();
        return redirect()->route('admin.statistics.index')->with('success', 'تم حذف الإحصائية بنجاح');
    }
}
