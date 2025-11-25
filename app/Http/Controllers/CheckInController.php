<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\ParticipantAttendance;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    /**
     * عرض واجهة مسح الباركود
     */
    public function index()
    {
        return view('checkin.scanner');
    }

    /**
     * التحقق من الباركود وتسجيل الحضور اليومي
     */
    public function verify(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            // فك تشفير بيانات QR Code
            $data = json_decode($request->qr_data, true);

            if (!$data || !isset($data['participant_id']) || !isset($data['token'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'بيانات الباركود غير صالحة'
                ], 400);
            }

            // البحث عن المشارك
            $participant = Participant::where('id', $data['participant_id'])
                ->where('approval_token', $data['token'])
                ->where('status', 'approved')
                ->with('conference')
                ->first();

            if (!$participant) {
                return response()->json([
                    'success' => false,
                    'message' => 'بطاقة غير صالحة أو غير موافق عليها'
                ], 404);
            }

            // التحقق من الحضور اليوم
            $today = now()->toDateString();
            $existingAttendance = ParticipantAttendance::where('participant_id', $participant->id)
                ->where('attendance_date', $today)
                ->first();

            if ($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'تم تسجيل دخولك اليوم مسبقاً في الساعة ' . $existingAttendance->check_in_time->format('H:i'),
                    'participant' => $participant,
                    'attendance' => $existingAttendance,
                ], 400);
            }

            // تسجيل الحضور اليومي
            $attendance = ParticipantAttendance::create([
                'participant_id' => $participant->id,
                'conference_id' => $participant->conference_id,
                'attendance_date' => $today,
                'check_in_time' => now(),
                'checked_in_by' => auth()->id(),
                'entry_point' => $request->entry_point ?? 'main',
                'notes' => $request->notes,
            ]);

            // حساب إجمالي أيام الحضور
            $totalDays = $participant->attendances()->count();

            return response()->json([
                'success' => true,
                'message' => 'مرحباً ' . $participant->name . '! تم تسجيل دخولك بنجاح',
                'participant' => $participant,
                'attendance' => $attendance,
                'total_days' => $totalDays,
                'conference' => $participant->conference,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التحقق: ' . $e->getMessage()
            ], 500);
        }
    }
}
