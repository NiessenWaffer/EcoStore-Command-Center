<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\SustainabilityImpactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ImpactAggregationHardeningTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_aggregates_user_impact_from_actual_order_items()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $variant = ProductVariant::factory()->create(['product_id' => $product->id]);
        
        // Create an order from last month using factory to ensure created_at is respected
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'completed',
            'created_at' => now()->subMonth()
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 1,
            'price_at_purchase_cents' => 10000,
            'water_saved_at_purchase' => 500,
            'carbon_reduced_at_purchase' => 10
        ]);

        $service = new SustainabilityImpactService();
        $history = $service->getUserImpactHistory($user);

        // Find the month entry for last month
        $lastMonthName = now()->subMonth()->format('M');
        $monthData = collect($history)->firstWhere('month', $lastMonthName);

        $this->assertEquals(500, $monthData['water']);
        $this->assertEquals(10, $monthData['carbon']);
    }
}
