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
        Schema::create('passport_audit_logs', function (Blueprint $blueprint) {
            $blueprint->uuid('id')->primary();
            $blueprint->foreignId('passport_id')->constrained('product_passports')->onDelete('cascade');
            $blueprint->string('event_type');
            $blueprint->json('event_data');
            $blueprint->string('previous_hash', 64);
            $blueprint->string('current_hash', 64);
            $blueprint->text('signature')->nullable();
            $blueprint->timestamp('timestamp');
            $blueprint->foreignId('performed_by')->nullable()->constrained('users')->onDelete('set null');
            $blueprint->uuid('original_log_id')->nullable(); // For corrections
            
            $blueprint->index(['passport_id', 'timestamp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passport_audit_logs');
    }
};
