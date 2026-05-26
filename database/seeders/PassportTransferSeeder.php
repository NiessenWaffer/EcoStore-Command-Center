<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProductPassport;
use App\Models\PassportTransfer;
use Illuminate\Support\Str;

class PassportTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        // Ensure we have at least 5 users
        if ($users->count() < 5) {
            for ($i = $users->count(); $i < 5; $i++) {
                User::factory()->create([
                    'name' => 'Sample User ' . $i,
                    'email' => 'user' . $i . '@example.com',
                ]);
            }
            $users = User::all();
        }

        $passports = ProductPassport::all();
        
        // Ensure we have at least 3 passports to show different scenarios
        if ($passports->count() < 3) {
            $product = \App\Models\Product::first();
            $factory = \App\Models\Factory::first();
            
            for ($i = $passports->count(); $i < 3; $i++) {
                ProductPassport::create([
                    'product_id' => $product->id,
                    'batch_number' => 'BATCH-SEED-' . $i,
                    'factory_id' => $factory->id,
                    'user_id' => $users[$i % $users->count()]->id,
                    'transit_impact_carbon' => 0.5,
                    'manufacturing_date' => now()->subDays(30),
                    'qr_token' => Str::random(64),
                    'is_verified' => true,
                ]);
            }
            $passports = ProductPassport::all();
        }

        // 1. Create a Pending Transfer
        PassportTransfer::create([
            'id' => (string) Str::uuid(),
            'passport_id' => $passports[0]->id,
            'sender_id' => $users[0]->id,
            'token' => 'XF-PENDING-123',
            'status' => 'Pending',
            'expires_at' => now()->addHours(48),
        ]);

        // 2. Create a Completed Transfer (Historical)
        PassportTransfer::create([
            'id' => (string) Str::uuid(),
            'passport_id' => $passports[1]->id,
            'sender_id' => $users[1]->id,
            'recipient_id' => $users[0]->id,
            'token' => 'XF-COMPLETED-456',
            'status' => 'Completed',
            'expires_at' => now()->subDays(5),
            'created_at' => now()->subDays(6),
        ]);

        // 3. Create an Expired Transfer
        PassportTransfer::create([
            'id' => (string) Str::uuid(),
            'passport_id' => $passports[2]->id,
            'sender_id' => $users[2]->id,
            'token' => 'XF-EXPIRED-789',
            'status' => 'Expired',
            'expires_at' => now()->subMinutes(10),
        ]);
    }
}
