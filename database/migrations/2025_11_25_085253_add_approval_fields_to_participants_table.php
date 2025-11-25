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
        Schema::table('participants', function (Blueprint $table) {
            // حالة الطلب
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('type');

            // رمز التحقق الفريد (UUID)
            $table->string('approval_token', 36)
                  ->unique()
                  ->nullable()
                  ->after('status');

            // تاريخ ووقت الموافقة
            $table->timestamp('approved_at')
                  ->nullable()
                  ->after('approval_token');

            // المستخدم الذي وافق على الطلب
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->after('approved_at');

            // ملاحظات الإدارة
            $table->text('admin_notes')
                  ->nullable()
                  ->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'status',
                'approval_token',
                'approved_at',
                'approved_by',
                'admin_notes',
            ]);
        });
    }
};
