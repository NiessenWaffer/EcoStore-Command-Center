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
        Schema::create('community_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('metric_type'); // water or carbon
            $table->decimal('target_value', 20, 2);
            $table->decimal('current_value', 20, 2)->default(0);
            $table->integer('donation_amount_cents')->nullable();
            $table->string('charity_name')->nullable();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_challenges');
    }
};
