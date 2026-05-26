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
        Schema::table('governance_proposals', function (Blueprint $table) {
            $table->decimal('total_weight_cast', 15, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('governance_proposals', function (Blueprint $table) {
            $table->integer('total_weight_cast')->default(0)->change();
        });
    }
};
