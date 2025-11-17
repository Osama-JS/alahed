<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConferenceController extends Controller
{
    public function index(Request $request)
    {
        $query = Conference::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('location_ar', 'like', "%{$search}%")
                  ->orWhere('location_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        if ($request->filled('from')) {
            $query->whereDate('start_date', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('end_date', '<=', $request->input('to'));
        }

        $conferences = $query->orderBy('order')
            ->orderByDesc('start_date')
            ->paginate(12)
            ->withQueryString();

        return view('admin.conferences.index', [
            'conferences' => $conferences,
            'filters' => $request->only(['search', 'status', 'from', 'to']),
        ]);
    }

    public function create()
    {
        return view('admin.conferences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location_ar' => 'nullable|string',
            'location_en' => 'nullable|string',
            'map_url' => 'nullable|string',
            'hero_video_url' => 'nullable|file|mimetypes:video/*|max:30720',
            'hero_image' => 'nullable|image|max:10048',
            'logo' => 'nullable|image|max:8048',
            'floor_plan_image' => 'nullable|image|max:10048',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('conferences', 'public');
        }

        if ($request->hasFile('hero_video_url')) {
            $validated['hero_video_url'] = $request->file('hero_video_url')->store('conferences/videos', 'public');
        }

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('conferences/logos', 'public');
        }

        if ($request->hasFile('floor_plan_image')) {
            $validated['floor_plan_image'] = $request->file('floor_plan_image')->store('conferences/floor-plans', 'public');
        }

        Conference::create($validated);

        return redirect()->route('admin.conferences.index')->with('success', 'تم إنشاء المؤتمر بنجاح');
    }

    public function edit(Conference $conference)
    {
        return view('admin.conferences.edit', compact('conference'));
    }

    public function update(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location_ar' => 'nullable|string',
            'location_en' => 'nullable|string',
            'map_url' => 'nullable|string',
            'hero_video_url' => 'nullable|file|mimetypes:video/*|max:30720',
            'hero_image' => 'nullable|image|max:10048',
            'floor_plan_image' => 'nullable|image|max:10048',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('hero_image')) {
            if ($conference->hero_image) {
                Storage::disk('public')->delete($conference->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('conferences', 'public');
        }

        if ($request->hasFile('hero_video_url')) {
            if ($conference->hero_video_url) {
                Storage::disk('public')->delete($conference->hero_video_url);
            }
            $validated['hero_video_url'] = $request->file('hero_video_url')->store('conferences/videos', 'public');
        }

        if ($request->hasFile('logo')) {
            if ($conference->logo) {
                Storage::disk('public')->delete($conference->logo);
            }
            $validated['logo'] = $request->file('logo')->store('conferences/logos', 'public');
        }

        if ($request->hasFile('floor_plan_image')) {
            if ($conference->floor_plan_image) {
                Storage::disk('public')->delete($conference->floor_plan_image);
            }
            $validated['floor_plan_image'] = $request->file('floor_plan_image')->store('conferences/floor-plans', 'public');
        }

        $conference->update($validated);

        return redirect()->route('admin.conferences.index')->with('success', 'تم تحديث المؤتمر بنجاح');
    }

    public function destroy(Conference $conference)
    {
        if ($conference->hero_image) {
            Storage::disk('public')->delete($conference->hero_image);
        }

        if ($conference->floor_plan_image) {
            Storage::disk('public')->delete($conference->floor_plan_image);
        }

        if ($conference->logo) {
            Storage::disk('public')->delete($conference->logo);
        }

        if ($conference->hero_video_url) {
            Storage::disk('public')->delete($conference->hero_video_url);
        }

        $conference->delete();

        return redirect()->route('admin.conferences.index')->with('success', 'تم حذف المؤتمر بنجاح');
    }

    public function activate(Conference $conference)
    {
        // Deactivate all conferences
        Conference::query()->update(['is_active' => false]);

        // Activate the selected conference
        $conference->update(['is_active' => true]);

        return redirect()->route('admin.conferences.index')->with('success', 'تم تفعيل المؤتمر بنجاح');
    }
}
