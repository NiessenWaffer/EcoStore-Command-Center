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
        Schema::create('sustainability_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('material_type')->unique();
            $table->decimal('water_per_kg', 10, 2);
            $table->decimal('carbon_per_kg', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sustainability_metrics');
    }
};
