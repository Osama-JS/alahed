<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    /**
     * تحميل بطاقة الزائر بصيغة PDF
     */
    public function download($token)
    {
        // البحث عن المشارك بواسطة الرمز
        $participant = Participant::where('approval_token', $token)
            ->where('status', 'approved')
            ->with('conference')
            ->firstOrFail();

        // توليد QR Code
        $qrData = json_encode([
            'participant_id' => $participant->id,
            'token' => $participant->approval_token,
            'conference_id' => $participant->conference_id,
            'conference_code' => $participant->conference->code ?? 'CONF',
            'name' => $participant->name,
            'email' => $participant->email,
            'type' => $participant->type,
            'issued_at' => now()->toIso8601String(),
        ]);

        // توليد QR Code باستخدام محرك GD لتجنب الحاجة إلى imagick

        $qrCode = QrCode::format('png')
            ->size(200)
            ->margin(1)
            ->generate($qrData);

        // توليد PDF
        $pdf = PDF::loadView('pdf.ticket', [
            'participant' => $participant,
            'qrCode' => base64_encode($qrCode),
        ]);

        // تحميل الملف
        $fileName = 'ticket-' . str_replace(' ', '-', $participant->name) . '.pdf';
        return $pdf->download($fileName);
    }
}
