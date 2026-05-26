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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('materials_cost_cents')->default(0);
            $table->integer('labor_cost_cents')->default(0);
            $table->integer('shipping_cost_cents')->default(0);
            $table->integer('operations_cost_cents')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'materials_cost_cents',
                'labor_cost_cents',
                'shipping_cost_cents',
                'operations_cost_cents'
            ]);
        });
    }
};
