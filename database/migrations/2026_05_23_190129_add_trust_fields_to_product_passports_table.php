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
        Schema::table('product_passports', function (Blueprint $blueprint) {
            $blueprint->boolean('is_verified')->default(false)->after('qr_token');
            $blueprint->string('last_audit_hash', 64)->nullable()->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_passports', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['is_verified', 'last_audit_hash']);
        });
    }
};
