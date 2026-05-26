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
        Schema::table('product_passports', function (Blueprint $table) {
            $table->json('condition_log')->nullable()->after('last_audit_hash');
            $table->boolean('is_leased')->default(false)->after('condition_log');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_passports', function (Blueprint $table) {
            $table->dropColumn(['condition_log', 'is_leased']);
        });
    }
};
