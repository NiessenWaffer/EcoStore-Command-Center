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
            $table->foreignId('user_id')->nullable()->after('factory_id')->constrained('users')->onDelete('set null');
        });

        Schema::table('passport_audit_logs', function (Blueprint $table) {
            $table->foreignId('governance_proposal_id')->nullable()->after('original_log_id')->constrained('governance_proposals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passport_audit_logs', function (Blueprint $table) {
            $table->dropForeign(['governance_proposal_id']);
            $table->dropColumn('governance_proposal_id');
        });

        Schema::table('product_passports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
