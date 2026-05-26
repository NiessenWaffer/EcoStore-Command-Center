<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\ResaleTradeIn;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Eco Pioneer',
                'email' => 'test@example.com',
                'eco_tier' => 'Ambassador',
                'referral_code' => 'ECO-WIN-123',
            ]);
        }

        // 1. Seed some historical orders
        for ($i = 1; $i <= 3; $i++) {
            $variants = ProductVariant::inRandomOrder()->take(rand(1, 3))->get();
            $totalWater = 0;
            $totalCarbon = 0;
            $totalCents = 0;

            $order = Order::create([
                'user_id' => $user->id,
                'total_cents' => 0, // Update later
                'status' => 'completed',
                'payment_status' => 'paid',
                'tracking_number' => 'TRK-' . Str::upper(Str::random(10)),
                'total_water_saved' => 0, // Update later
                'total_carbon_reduced' => 0, // Update later
                'shipping_address' => [
                    'line1' => '123 Sustainability Way',
                    'city' => 'Denver',
                    'country' => 'USA'
                ],
                'is_carbon_neutral_shipping' => true,
                'created_at' => now()->subMonths($i)->subDays(rand(1, 20)),
            ]);

            foreach ($variants as $variant) {
                $qty = rand(1, 2);
                $water = rand(500, 1500) * $qty;
                $carbon = (rand(10, 50) / 10) * $qty;
                $price = $variant->product->price_cents * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $variant->product_id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $qty,
                    'price_at_purchase_cents' => $price,
                    'water_saved_at_purchase' => $water,
                    'carbon_reduced_at_purchase' => $carbon,
                ]);

                $totalWater += $water;
                $totalCarbon += $carbon;
                $totalCents += $price;
            }

            $order->update([
                'total_cents' => $totalCents,
                'total_water_saved' => $totalWater,
                'total_carbon_reduced' => $totalCarbon,
            ]);

            // Update user aggregates
            $user->increment('cumulative_water_saved', $totalWater);
            $user->increment('cumulative_carbon_reduced', $totalCarbon);
        }

        // 2. Seed some Resale Trade-ins
        $firstOrder = $user->orders()->first();
        $firstProduct = $firstOrder->items()->first()->product;

        ResaleTradeIn::create([
            'user_id' => $user->id,
            'order_id' => $firstOrder->id,
            'product_id' => $firstProduct->id,
            'condition' => 'Excellent',
            'status' => 'credited',
            'estimated_credit_cents' => 1500,
            'verified_at' => now()->subDays(10),
        ]);

        $secondProduct = Product::where('id', '!=', $firstProduct->id)->first();
        ResaleTradeIn::create([
            'user_id' => $user->id,
            'order_id' => $firstOrder->id, // Simplified for seeder
            'product_id' => $secondProduct->id,
            'condition' => 'Good',
            'status' => 'pending',
            'estimated_credit_cents' => 4500,
        ]);

        $this->command->info("Seeded historical activity for user: {$user->email}");
    }
}
