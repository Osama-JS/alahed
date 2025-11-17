<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExhibitionBooth;
use App\Models\Conference;
use App\Models\Exhibitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExhibitionBoothController extends Controller
{
    public function index(Request $request)
    {
        $query = ExhibitionBooth::with(['conference', 'participant', 'exhibitor']);

        // Filter by conference
        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->conference_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $booths = $query->orderBy('order')->paginate(15)->withQueryString();
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.exhibition-booths.index', compact('booths', 'conferences'));
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        $exhibitors = Exhibitor::orderBy('name_ar')->get();
        return view('admin.exhibition-booths.create', compact('conferences', 'exhibitors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,premium,strategic,main,gold,silver',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'status' => 'required|in:available,reserved',
            'exhibitor_id' => 'nullable|exists:exhibitors,id',
            'image' => 'nullable|image|max:2048',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'notes' => 'nullable|string',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name.required' => 'اسم البوث مطلوب',
            'name.max' => 'اسم البوث يجب ألا يتجاوز 255 حرف',
            'type.required' => 'نوع البوث مطلوب',
            'type.in' => 'نوع البوث غير صحيح',
            'width.numeric' => 'العرض يجب أن يكون رقم',
            'width.min' => 'العرض يجب أن يكون أكبر من أو يساوي 0',
            'height.numeric' => 'الطول يجب أن يكون رقم',
            'height.min' => 'الطول يجب أن يكون أكبر من أو يساوي 0',
            'area.numeric' => 'المساحة يجب أن تكون رقم',
            'area.min' => 'المساحة يجب أن تكون أكبر من أو تساوي 0',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي 0',
            'currency.max' => 'العملة يجب ألا تتجاوز 10 أحرف',
            'status.required' => 'الحالة مطلوبة',
            'status.in' => 'الحالة غير صحيحة',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('booths', 'public');
        }

        ExhibitionBooth::create($validated);

        return redirect()->route('admin.exhibition-booths.index')->with('success', 'تم إضافة البوث بنجاح');
    }

    public function edit(ExhibitionBooth $exhibitionBooth)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        $exhibitors = Exhibitor::orderBy('name_ar')->get();
        return view('admin.exhibition-booths.edit', compact('exhibitionBooth', 'conferences', 'exhibitors'));
    }

    public function update(Request $request, ExhibitionBooth $exhibitionBooth)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,premium,strategic,main,gold,silver',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'status' => 'required|in:available,reserved',
            'exhibitor_id' => 'nullable|exists:exhibitors,id',
            'image' => 'nullable|image|max:2048',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'notes' => 'nullable|string',
            'order' => 'nullable|integer',
        ], [
            'conference_id.required' => 'يجب اختيار المؤتمر',
            'conference_id.exists' => 'المؤتمر المحدد غير موجود',
            'name.required' => 'اسم البوث مطلوب',
            'name.max' => 'اسم البوث يجب ألا يتجاوز 255 حرف',
            'type.required' => 'نوع البوث مطلوب',
            'type.in' => 'نوع البوث غير صحيح',
            'width.numeric' => 'العرض يجب أن يكون رقم',
            'width.min' => 'العرض يجب أن يكون أكبر من أو يساوي 0',
            'height.numeric' => 'الطول يجب أن يكون رقم',
            'height.min' => 'الطول يجب أن يكون أكبر من أو يساوي 0',
            'area.numeric' => 'المساحة يجب أن تكون رقم',
            'area.min' => 'المساحة يجب أن تكون أكبر من أو تساوي 0',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي 0',
            'currency.max' => 'العملة يجب ألا تتجاوز 10 أحرف',
            'status.required' => 'الحالة مطلوبة',
            'status.in' => 'الحالة غير صحيحة',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            'order.integer' => 'الترتيب يجب أن يكون رقم صحيح',
        ]);

        if ($request->hasFile('image')) {
            if ($exhibitionBooth->image) {
                Storage::disk('public')->delete($exhibitionBooth->image);
            }
            $validated['image'] = $request->file('image')->store('booths', 'public');
        }

        $exhibitionBooth->update($validated);

        return redirect()->route('admin.exhibition-booths.index')->with('success', 'تم تحديث البوث بنجاح');
    }

    public function destroy(ExhibitionBooth $exhibitionBooth)
    {
        if ($exhibitionBooth->image) {
            Storage::disk('public')->delete($exhibitionBooth->image);
        }

        $exhibitionBooth->delete();

        return redirect()->route('admin.exhibition-booths.index')->with('success', 'تم حذف البوث بنجاح');
    }

    public function duplicate(ExhibitionBooth $exhibitionBooth)
    {
        // Clone attributes except primary key and timestamps
        $data = $exhibitionBooth->toArray();

        unset($data['id'], $data['created_at'], $data['updated_at']);

        // Reset relationships/reservation-related fields to avoid data conflicts
        $data['exhibitor_id'] = null;
        $data['participant_id'] = null;
        $data['reserved_at'] = null;
        $data['status'] = 'available';

        // Name: original name + " نسخة"
        $data['name'] = trim(($exhibitionBooth->name ?? '') . ' نسخة');

        // Force slug regeneration in model boot
        $data['slug'] = null;

        $newBooth = ExhibitionBooth::create($data);

        return redirect()
            ->route('admin.exhibition-booths.edit', $newBooth)
            ->with('success', 'تم إنشاء نسخة من البوث بنجاح');
    }
}
