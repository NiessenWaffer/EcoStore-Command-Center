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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('sourcing_hub_id')->nullable()->constrained('local_hubs')->onDelete('set null');
            $table->decimal('transit_co2_offset', 10, 2)->default(0);
            $table->boolean('is_international')->default(false);
            $table->decimal('transit_distance_km', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['sourcing_hub_id']);
            $table->dropColumn(['sourcing_hub_id', 'transit_co2_offset', 'is_international', 'transit_distance_km']);
        });
    }
};
