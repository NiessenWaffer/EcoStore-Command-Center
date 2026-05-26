<?php

namespace Database\Seeders;

use App\Models\ProductPassport;
use App\Models\Product;
use App\Models\Factory;
use App\Models\User;
use App\Services\PassportService;
use Illuminate\Database\Seeder;

class PassportAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(PassportService $passportService): void
    {
        $admin = User::where('email', 'admin@projectapp.com')->first();
        if (!$admin) {
            $admin = User::factory()->create([
                'name' => 'Brand Auditor',
                'email' => 'admin@projectapp.com',
            ]);
        }

        $factory = Factory::first();
        if (!$factory) {
            $factory = Factory::create([
                'name' => 'Eco-Weave Solutions',
                'location' => 'North Carolina, USA',
                'latitude' => 35.7596,
                'longitude' => -79.0193,
                'ethical_score' => 9.5,
                'certifications' => ['GOTS', 'Fair Trade'],
            ]);
        }

        $product = Product::first();
        if (!$product) {
            // This case should be covered by SampleProductSeeder, but adding fallback
            $product = Product::create([
                'category_id' => 1,
                'name' => 'Fallback Sustainable Tee',
                'slug' => 'fallback-sustainable-tee',
                'description' => 'A fallback product for seeding purposes.',
                'price_cents' => 4500,
                'sustainability_score' => 8.5,
                'is_published' => true,
                'image_url' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=800&q=80',
            ]);
        }

        $passport = ProductPassport::first();
        if (!$passport) {
            $passport = ProductPassport::create([
                'product_id' => $product->id,
                'batch_number' => 'BATCH-2026-001',
                'factory_id' => $factory->id,
                'manufacturing_date' => now()->subMonths(3),
                'qr_token' => 'test-token-123',
            ]);
        }

        // Clear existing logs for a clean seed
        $passport->auditLogs()->delete();
        $passport->update(['last_audit_hash' => null]);

        // 1. Sourcing
        $passportService->recordEvent($passport, 'Sourcing', [
            'material' => 'Organic Cotton',
            'origin' => 'Texas, USA',
            'certification' => 'GOTS-12345'
        ], $admin);

        // 2. Manufacturing
        $passportService->recordEvent($passport, 'Manufacturing', [
            'factory' => 'Eco-Weave Solutions',
            'location' => 'North Carolina, USA',
            'process' => 'Low-impact dyeing'
        ], $admin);

        // 3. Logistics
        $passportService->recordEvent($passport, 'Logistics', [
            'carrier' => 'Carbon-Neutral Freight',
            'destination' => 'Denver Local Hub',
            'status' => 'Received'
        ], $admin);

        // 4. Sale (System Event)
        $passportService->recordEvent($passport, 'Sale', [
            'order_id' => 'ORD-9988',
            'customer_masked' => 'J*** D***'
        ]);

        $this->command->info("Seeded 4 verified events for Passport ID: {$passport->id}");
    }
}
