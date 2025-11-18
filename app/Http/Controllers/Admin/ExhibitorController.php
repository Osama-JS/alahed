<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exhibitor;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExhibitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Exhibitor::with(['conference', 'booth']);

        // Filter by conference
        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->conference_id);
        }

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%")
                  ->orWhere('booth_number', 'like', "%{$search}%");
            });
        }

        $exhibitors = $query->orderBy('order')
            ->paginate(15)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.exhibitors.index', [
            'exhibitors' => $exhibitors,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'search']),
        ]);
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.exhibitors.create', compact('conferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'summary_ar' => 'nullable|string|max:255',
            'summary_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url',
            'booth_number' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name_ar.required' => 'اسم العارض بالعربية مطلوب',
            'name_ar.max' => 'اسم العارض بالعربية يجب ألا يتجاوز 255 حرف',
            'name_en.required' => 'اسم العارض بالإنجليزية مطلوب',
            'name_en.max' => 'اسم العارض بالإنجليزية يجب ألا يتجاوز 255 حرف',
            'logo.image' => 'يجب أن يكون الملف صورة',
            'logo.max' => 'حجم الشعار يجب ألا يتجاوز 2 ميجابايت',
            'website.url' => 'رابط الموقع غير صحيح',
            'booth_number.max' => 'رقم الجناح يجب ألا يتجاوز 255 حرف',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('exhibitors', 'public');
        }

        Exhibitor::create($validated);

        return redirect()->route('admin.exhibitors.index')->with('success', 'تم إضافة العارض بنجاح');
    }

    public function edit(Exhibitor $exhibitor)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.exhibitors.edit', compact('exhibitor', 'conferences'));
    }

    public function update(Request $request, Exhibitor $exhibitor)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'summary_ar' => 'nullable|string|max:255',
            'summary_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url',
            'booth_number' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name_ar.required' => 'اسم العارض بالعربية مطلوب',
            'name_ar.max' => 'اسم العارض بالعربية يجب ألا يتجاوز 255 حرف',
            'name_en.required' => 'اسم العارض بالإنجليزية مطلوب',
            'name_en.max' => 'اسم العارض بالإنجليزية يجب ألا يتجاوز 255 حرف',
            'logo.image' => 'يجب أن يكون الملف صورة',
            'logo.max' => 'حجم الشعار يجب ألا يتجاوز 2 ميجابايت',
            'website.url' => 'رابط الموقع غير صحيح',
            'booth_number.max' => 'رقم الجناح يجب ألا يتجاوز 255 حرف',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('logo')) {
            if ($exhibitor->logo) {
                Storage::disk('public')->delete($exhibitor->logo);
            }
            $validated['logo'] = $request->file('logo')->store('exhibitors', 'public');
        }

        $exhibitor->update($validated);

        return redirect()->route('admin.exhibitors.index')->with('success', 'تم تحديث العارض بنجاح');
    }

    public function destroy(Exhibitor $exhibitor)
    {
        if ($exhibitor->logo) {
            Storage::disk('public')->delete($exhibitor->logo);
        }

        $exhibitor->delete();

        return redirect()->route('admin.exhibitors.index')->with('success', 'تم حذف العارض بنجاح');
    }
}
