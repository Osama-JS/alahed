<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * عرض نموذج التسجيل
     */
    public function create(Conference $conference)
    {
        return view('frontend.registration', compact('conference'));
    }

    /**
     * حفظ طلب التسجيل
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'conference_id' => 'required|exists:conferences,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:visitor,exhibitor,speaker,sponsor',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
        ]);

        // إنشاء طلب اشتراك جديد
        $participant = Participant::create([
            ...$validated,
            'status' => 'pending',
            'approval_token' => Str::uuid(),
        ]);

        return redirect()->back()->with('success',
            app()->getLocale() == 'ar'
                ? 'تم استلام طلبك بنجاح! سيتم مراجعته والرد عليك قريباً عبر البريد الإلكتروني.'
                : 'Your registration request has been received! It will be reviewed and you will be notified via email soon.'
        );
    }
}
