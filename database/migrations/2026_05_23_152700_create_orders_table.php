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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('guest_session_id')->nullable()->index();
            $table->integer('total_cents');
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->string('stripe_payment_intent_id')->nullable()->unique();
            $table->string('tracking_number')->nullable();
            $table->decimal('total_water_saved', 15, 2)->default(0);
            $table->decimal('total_carbon_reduced', 15, 2)->default(0);
            $table->json('shipping_address')->nullable();
            $table->boolean('is_carbon_neutral_shipping')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
