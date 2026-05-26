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
            $table->string('ipfs_cid')->nullable()->after('is_leased');
            $table->timestamp('ipfs_synced_at')->nullable()->after('ipfs_cid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_passports', function (Blueprint $table) {
            $table->dropColumn(['ipfs_cid', 'ipfs_synced_at']);
        });
    }
};
