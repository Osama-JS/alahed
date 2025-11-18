<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Conference;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::with('conference');

        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->input('conference_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('question_ar', 'like', "%{$search}%")
                  ->orWhere('question_en', 'like', "%{$search}%")
                  ->orWhere('answer_ar', 'like', "%{$search}%")
                  ->orWhere('answer_en', 'like', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('order')
            ->paginate(20)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.faqs.index', [
            'faqs' => $faqs,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'search']),
        ]);
    }

    public function create()
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.faqs.create', compact('conferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'question_ar' => 'required|string',
            'question_en' => 'required|string',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'تم إضافة السؤال بنجاح');
    }

    public function edit(Faq $faq)
    {
        $conferences = Conference::orderBy('title_ar')->get();
        return view('admin.faqs.edit', compact('faq', 'conferences'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'question_ar' => 'required|string',
            'question_en' => 'required|string',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'تم تحديث السؤال بنجاح');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'تم حذف السؤال بنجاح');
    }

    public function duplicate(Faq $faq)
    {
        $newFaq = $faq->replicate();

        // ضع السؤال المكرر في نهاية ترتيب الأسئلة لنفس المؤتمر
        $maxOrder = Faq::where('conference_id', $faq->conference_id)->max('order');
        $newFaq->order = $maxOrder ? $maxOrder + 1 : ($faq->order ?? 1);

        $newFaq->save();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'تم تكرار السؤال بنجاح');
    }
}
