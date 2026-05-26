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
        Schema::table('governance_votes', function (Blueprint $table) {
            $table->integer('weighted_cost')->nullable()->after('weight_cast');
            $table->decimal('resultant_influence', 12, 2)->nullable()->after('weighted_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('governance_votes', function (Blueprint $table) {
            $table->dropColumn(['weighted_cost', 'resultant_influence']);
        });
    }
};
