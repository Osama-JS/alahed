<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\Participant;
use App\Models\ParticipantAttendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubscriptionSystemTest extends TestCase
{
    // استخدام RefreshDatabase لإعادة تعيين قاعدة البيانات بعد كل اختبار
    // ملاحظة: إذا كنت تستخدم قاعدة بيانات حقيقية، قد ترغب في استخدام DatabaseTransactions بدلاً منها
    // use RefreshDatabase;

    protected $conference;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء مؤتمر للاختبار
        $this->conference = Conference::first() ?? Conference::create([
            'title_ar' => 'مؤتمر الاختبار',
            'title_en' => 'Test Conference',
            'slug' => 'test-conference',
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'location_ar' => 'الرياض',
            'location_en' => 'Riyadh',
        ]);

        // إنشاء مستخدم مسؤول
        $this->admin = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'type' => 'admin', // تأكد من أن هذا الحقل موجود أو عدله حسب نظام الصلاحيات لديك
        ]);
    }

    /** @test */
    public function visitor_can_register_for_conference()
    {
        $response = $this->post(route('registration.store'), [
            'conference_id' => $this->conference->id,
            'name' => 'Test Visitor',
            'email' => 'visitor@test.com',
            'phone' => '123456789',
            'type' => 'visitor',
            'company' => 'Test Co',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('participants', [
            'email' => 'visitor@test.com',
            'status' => 'pending',
            'conference_id' => $this->conference->id,
        ]);

        $participant = Participant::where('email', 'visitor@test.com')->first();
        $this->assertNotNull($participant->approval_token);
    }

    /** @test */
    public function admin_can_approve_participant()
    {
        Mail::fake();

        $participant = Participant::create([
            'conference_id' => $this->conference->id,
            'name' => 'Pending Visitor',
            'email' => 'pending@test.com',
            'phone' => '987654321',
            'type' => 'visitor',
            'status' => 'pending',
            'approval_token' => \Illuminate\Support\Str::uuid(),
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.participants.approve', $participant->id));

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('participants', [
            'id' => $participant->id,
            'status' => 'approved',
            'approved_by' => $this->admin->id,
        ]);

        Mail::assertSent(\App\Mail\ParticipantApprovedMail::class, function ($mail) use ($participant) {
            return $mail->hasTo($participant->email);
        });
    }

    /** @test */
    public function visitor_can_check_in_with_valid_qr()
    {
        $participant = Participant::create([
            'conference_id' => $this->conference->id,
            'name' => 'Approved Visitor',
            'email' => 'approved@test.com',
            'phone' => '555555555',
            'type' => 'visitor',
            'status' => 'approved',
            'approval_token' => \Illuminate\Support\Str::uuid(),
            'approved_at' => now(),
        ]);

        $qrData = json_encode([
            'participant_id' => $participant->id,
            'token' => $participant->approval_token,
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson(route('checkin.verify'), [
                'qr_data' => $qrData,
                'entry_point' => 'Gate A',
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('participant_attendances', [
            'participant_id' => $participant->id,
            'attendance_date' => now()->toDateString(),
            'entry_point' => 'Gate A',
        ]);
    }

    /** @test */
    public function visitor_cannot_check_in_twice_same_day()
    {
        $participant = Participant::create([
            'conference_id' => $this->conference->id,
            'name' => 'Double Check Visitor',
            'email' => 'double@test.com',
            'phone' => '444444444',
            'type' => 'visitor',
            'status' => 'approved',
            'approval_token' => \Illuminate\Support\Str::uuid(),
            'approved_at' => now(),
        ]);

        // تسجيل الحضور الأول
        ParticipantAttendance::create([
            'participant_id' => $participant->id,
            'conference_id' => $this->conference->id,
            'attendance_date' => now()->toDateString(),
            'check_in_time' => now(),
        ]);

        $qrData = json_encode([
            'participant_id' => $participant->id,
            'token' => $participant->approval_token,
        ]);

        // محاولة تسجيل الحضور الثاني في نفس اليوم
        $response = $this->actingAs($this->admin)
            ->postJson(route('checkin.verify'), [
                'qr_data' => $qrData,
            ]);

        $response->assertStatus(400)
            ->assertJson(['success' => false]);

        // التأكد من عدم إنشاء سجل جديد
        $this->assertEquals(1, ParticipantAttendance::where('participant_id', $participant->id)->count());
    }

    /** @test */
    public function visitor_can_check_in_different_days()
    {
        $participant = Participant::create([
            'conference_id' => $this->conference->id,
            'name' => 'Multi Day Visitor',
            'email' => 'multi@test.com',
            'phone' => '333333333',
            'type' => 'visitor',
            'status' => 'approved',
            'approval_token' => \Illuminate\Support\Str::uuid(),
            'approved_at' => now(),
        ]);

        // تسجيل حضور يوم أمس
        ParticipantAttendance::create([
            'participant_id' => $participant->id,
            'conference_id' => $this->conference->id,
            'attendance_date' => now()->subDay()->toDateString(),
            'check_in_time' => now()->subDay(),
        ]);

        $qrData = json_encode([
            'participant_id' => $participant->id,
            'token' => $participant->approval_token,
        ]);

        // محاولة تسجيل الحضور اليوم
        $response = $this->actingAs($this->admin)
            ->postJson(route('checkin.verify'), [
                'qr_data' => $qrData,
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        // التأكد من وجود سجلين
        $this->assertEquals(2, ParticipantAttendance::where('participant_id', $participant->id)->count());
    }
}
