<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participant_attendances', function (Blueprint $table) {
            $table->id();

            // ربط بالمشارك
            $table->foreignId('participant_id')
                  ->constrained()
                  ->onDelete('cascade');

            // ربط بالمؤتمر
            $table->foreignId('conference_id')
                  ->constrained()
                  ->onDelete('cascade');

            // تاريخ الحضور
            $table->date('attendance_date');

            // وقت الدخول
            $table->time('check_in_time');

            // المستخدم الذي سجل الدخول
            $table->foreignId('checked_in_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // نقطة الدخول
            $table->string('entry_point')->nullable();

            // ملاحظات
            $table->text('notes')->nullable();

            $table->timestamps();

            // فهرس فريد لمنع تسجيل دخول مكرر في نفس اليوم
            $table->unique(['participant_id', 'attendance_date']);

            // فهارس للبحث السريع
            $table->index('attendance_date');
            $table->index('conference_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_attendances');
    }
};
