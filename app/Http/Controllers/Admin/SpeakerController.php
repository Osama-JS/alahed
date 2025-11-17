<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    public function index(Request $request)
    {
        $query = Speaker::with('conference');

        // Filter by conference
        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->conference_id);
        }

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        $speakers = $query->orderBy('order')
            ->paginate(15)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.speakers.index', [
            'speakers' => $speakers,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'search']),
        ]);
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.speakers.create', compact('conferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'company_ar' => 'nullable|string|max:255',
            'company_en' => 'nullable|string|max:255',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name_ar.required' => 'اسم المتحدث بالعربية مطلوب',
            'name_ar.max' => 'اسم المتحدث بالعربية يجب ألا يتجاوز 255 حرف',
            'name_en.required' => 'اسم المتحدث بالإنجليزية مطلوب',
            'name_en.max' => 'اسم المتحدث بالإنجليزية يجب ألا يتجاوز 255 حرف',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            'linkedin.url' => 'رابط LinkedIn غير صحيح',
            'twitter.url' => 'رابط Twitter غير صحيح',
            'facebook.url' => 'رابط Facebook غير صحيح',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('speakers', 'public');
        }

        Speaker::create($validated);

        return redirect()->route('admin.speakers.index')->with('success', 'تم إضافة المتحدث بنجاح');
    }

    public function edit(Speaker $speaker)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.speakers.edit', compact('speaker', 'conferences'));
    }

    public function update(Request $request, Speaker $speaker)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'company_ar' => 'nullable|string|max:255',
            'company_en' => 'nullable|string|max:255',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name_ar.required' => 'اسم المتحدث بالعربية مطلوب',
            'name_ar.max' => 'اسم المتحدث بالعربية يجب ألا يتجاوز 255 حرف',
            'name_en.required' => 'اسم المتحدث بالإنجليزية مطلوب',
            'name_en.max' => 'اسم المتحدث بالإنجليزية يجب ألا يتجاوز 255 حرف',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            'linkedin.url' => 'رابط LinkedIn غير صحيح',
            'twitter.url' => 'رابط Twitter غير صحيح',
            'facebook.url' => 'رابط Facebook غير صحيح',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('image')) {
            if ($speaker->image) {
                Storage::disk('public')->delete($speaker->image);
            }
            $validated['image'] = $request->file('image')->store('speakers', 'public');
        }

        $speaker->update($validated);

        return redirect()->route('admin.speakers.index')->with('success', 'تم تحديث المتحدث بنجاح');
    }

    public function destroy(Speaker $speaker)
    {
        if ($speaker->image) {
            Storage::disk('public')->delete($speaker->image);
        }

        $speaker->delete();

        return redirect()->route('admin.speakers.index')->with('success', 'تم حذف المتحدث بنجاح');
    }
}
