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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('level', ['beginner', 'intermediate', 'professional'])->default('beginner');
            $table->timestamps();
        });
        Schema::create('player_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('level', ['beginner', 'intermediate', 'professional'])->default('beginner');
            $table->unsignedSmallInteger('rating');
            $table->timestamps();
        });
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->foreignId('leader_id')->constrained('players')->cascadeOnDelete();
            $table->enum('level', ['beginner', 'intermediate', 'professional'])->default('beginner');
            $table->timestamps();
        });
        Schema::create('group_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_player');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('player_ratings');
        Schema::dropIfExists('players');
    }
};
