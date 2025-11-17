<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $query = Sponsor::with('conference');

        // Filter by conference
        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->conference_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        $sponsors = $query->orderBy('order')
            ->paginate(15)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.sponsors.index', [
            'sponsors' => $sponsors,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'type', 'search']),
        ]);
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.sponsors.create', compact('conferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'logo' => 'required|image|max:2048',
            'website' => 'nullable|url',
            'type' => 'required|in:platinum,gold,silver,bronze,partner',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name_ar.required' => 'اسم الراعي بالعربية مطلوب',
            'name_ar.max' => 'اسم الراعي بالعربية يجب ألا يتجاوز 255 حرف',
            'name_en.required' => 'اسم الراعي بالإنجليزية مطلوب',
            'name_en.max' => 'اسم الراعي بالإنجليزية يجب ألا يتجاوز 255 حرف',
            'logo.required' => 'شعار الراعي مطلوب',
            'logo.image' => 'يجب أن يكون الملف صورة',
            'logo.max' => 'حجم الشعار يجب ألا يتجاوز 2 ميجابايت',
            'website.url' => 'رابط الموقع غير صحيح',
            'type.required' => 'نوع الرعاية مطلوب',
            'type.in' => 'نوع الرعاية غير صحيح',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('sponsors', 'public');
        }

        Sponsor::create($validated);

        return redirect()->route('admin.sponsors.index')->with('success', 'تم إضافة الراعي بنجاح');
    }

    public function edit(Sponsor $sponsor)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.sponsors.edit', compact('sponsor', 'conferences'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url',
            'type' => 'required|in:platinum,gold,silver,bronze,partner',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name_ar.required' => 'اسم الراعي بالعربية مطلوب',
            'name_ar.max' => 'اسم الراعي بالعربية يجب ألا يتجاوز 255 حرف',
            'name_en.required' => 'اسم الراعي بالإنجليزية مطلوب',
            'name_en.max' => 'اسم الراعي بالإنجليزية يجب ألا يتجاوز 255 حرف',
            'logo.image' => 'يجب أن يكون الملف صورة',
            'logo.max' => 'حجم الشعار يجب ألا يتجاوز 2 ميجابايت',
            'website.url' => 'رابط الموقع غير صحيح',
            'type.required' => 'نوع الرعاية مطلوب',
            'type.in' => 'نوع الرعاية غير صحيح',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('logo')) {
            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            $validated['logo'] = $request->file('logo')->store('sponsors', 'public');
        }

        $sponsor->update($validated);

        return redirect()->route('admin.sponsors.index')->with('success', 'تم تحديث الراعي بنجاح');
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }

        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->with('success', 'تم حذف الراعي بنجاح');
    }
}
