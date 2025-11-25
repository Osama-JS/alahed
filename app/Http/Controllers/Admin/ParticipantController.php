<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Participant;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::with(['conference', 'attendances']);

        if ($request->filled('conference_id')) {
            $query->where('conference_id', $request->input('conference_id'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        $participants = $query->orderByDesc('created_at')
            ->paginate(50)
            ->withQueryString();

        $conferences = Conference::orderBy('title_ar')->get(['id', 'title_ar', 'title_en']);

        return view('admin.participants.index', [
            'participants' => $participants,
            'conferences' => $conferences,
            'filters' => $request->only(['conference_id', 'type', 'status', 'search']),
        ]);
    }

    /**
     * عرض تفاصيل المشارك مع سجل الحضور
     */
    public function show(Participant $participant)
    {
        $participant->load(['conference', 'attendances.checkedInBy', 'approvedBy']);

        // توليد بيانات QR Code مماثلة لتلك المستخدمة في بطاقة PDF
        $qrData = json_encode([
            'participant_id' => $participant->id,
            'token' => $participant->approval_token,
            'conference_id' => $participant->conference_id,
            'name' => $participant->name,
            'email' => $participant->email,
            'type' => $participant->type,
            'issued_at' => now()->toIso8601String(),
        ]);

        // توليد صورة QR كـ base64 لتضمينها في الـ view


        // توليد QR Code باستخدام محرك GD لتجنب الحاجة إلى imagick

        $qrCode = QrCode::format('png')
            ->size(200)
            ->margin(1)
            ->generate($qrData);
        $qrCodeBase64 = base64_encode($qrCode);

        return view('admin.participants.show', compact('participant', 'qrCodeBase64', 'qrData'));
    }

    /**
     * الموافقة على طلب الاشتراك
     */
    public function approve($id)
    {
        $participant = Participant::findOrFail($id);

        if ($participant->status === 'approved') {
            return redirect()->back()->with('warning', 'تمت الموافقة على هذا الطلب مسبقاً');
        }

        $participant->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        // إرسال البريد الإلكتروني
        try {
            \Mail::to($participant->email)->send(new \App\Mail\ParticipantApprovedMail($participant));
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'تمت الموافقة على الطلب ولكن فشل إرسال البريد الإلكتروني: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'تمت الموافقة على الطلب وإرسال البريد الإلكتروني بنجاح');
    }

    /**
     * رفض طلب الاشتراك
     */
    public function reject(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $participant->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('reason'),
        ]);

        return redirect()->back()->with('success', 'تم رفض الطلب');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->route('admin.participants.index')->with('success', 'تم حذف المشارك بنجاح');
    }
}
