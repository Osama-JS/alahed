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
        Schema::create('exhibition_booths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->enum('type', ['standard', 'premium', 'strategic', 'main', 'gold', 'silver'])->default('standard');
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('area', 8, 2)->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('currency', 10)->default('SAR');
            $table->enum('status', ['available', 'reserved'])->default('available');
            $table->foreignId('participant_id')->nullable()->constrained('participants')->nullOnDelete();
            $table->timestamp('reserved_at')->nullable();
            $table->string('image')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('notes')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibition_booths');
    }
};



