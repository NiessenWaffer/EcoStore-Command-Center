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
        Schema::create('governance_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('type'); // Charity, Challenge, Strategic
            $table->json('options'); // [{id, name, description}]
            $table->string('status')->default('Active'); // Draft, Active, Executed, Failed
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->integer('quorum_threshold')->default(1000);
            $table->integer('total_weight_cast')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('governance_proposals');
    }
};
