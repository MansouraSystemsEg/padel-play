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
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedSmallInteger('maximum_simultanious_bookings');
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('court_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained('courts')->cascadeOnDelete();
            $table->enum('day', ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri']);
            $table->time('opens_at');
            $table->time('closes_at');
            $table->timestamps();
        });
        Schema::create('court_breaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained('courts')->cascadeOnDelete();
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
        Schema::dropIfExists('court_breaks');
        Schema::dropIfExists('court_schedules');
        Schema::dropIfExists('courts');
    }
};
