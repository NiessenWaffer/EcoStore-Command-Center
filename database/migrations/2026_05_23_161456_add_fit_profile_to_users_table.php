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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('height_cm')->nullable();
            $table->integer('weight_kg')->nullable();
            $table->string('fit_preference')->nullable(); // Slim, Regular, Loose
            $table->json('fit_profile_data')->nullable(); // For complex AI data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['height_cm', 'weight_kg', 'fit_preference', 'fit_profile_data']);
        });
    }
};
