<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
        Schema::create('coach_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->cascadeOnDelete();
            $table->enum('weekday', ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri']);
            $table->time('starts_at');
            $table->time('ends_at');
            $table->timestamps();
        });
        Schema::create('coach_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_schedule_id')->constrained('coach_schedules')->cascadeOnDelete();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('coach_breaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->cascadeOnDelete();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_breaks');
        Schema::dropIfExists('coach_regions');
        Schema::dropIfExists('coach_schedules');
        Schema::dropIfExists('coaches');
    }
};
