<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('conference');

        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->input('conference_id'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        $galleries = $query->orderBy('order')
            ->paginate(20)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.galleries.index', [
            'galleries' => $galleries,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'type', 'search']),
        ]);
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.galleries.create', compact('conferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'image' => 'required|mimetypes:image/jpeg,image/png,video/mp4|max:25120',
            'type' => 'required|in:image,video',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'تم إضافة العنصر بنجاح');
    }

    public function edit(Gallery $gallery)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.galleries.edit', compact('gallery', 'conferences'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'type' => 'required|in:image,video',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'تم تحديث العنصر بنجاح');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'تم حذف العنصر بنجاح');
    }
}
