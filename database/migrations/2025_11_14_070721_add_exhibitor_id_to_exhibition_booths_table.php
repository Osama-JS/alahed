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
        Schema::table('exhibition_booths', function (Blueprint $table) {
            $table->foreignId('exhibitor_id')->nullable()->after('participant_id')->constrained('exhibitors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exhibition_booths', function (Blueprint $table) {
            $table->dropForeign(['exhibitor_id']);
            $table->dropColumn('exhibitor_id');
        });
    }
};
