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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->decimal('cumulative_water_saved', 15, 2)->default(0);
            $table->decimal('cumulative_carbon_reduced', 15, 2)->default(0);
            $table->boolean('leaderboard_opt_in')->default(false);
            $table->string('referral_code')->unique()->nullable();
            $table->integer('network_impact_points')->default(0);
            $table->string('eco_tier')->default('Eco-Novice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
