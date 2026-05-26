<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Default Admin for immediate access
        User::updateOrCreate(
            ['email' => 'admin@ecostore.com'],
            [
                'name' => 'Brand Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
                'eco_tier' => 'Admin'
            ]
        );

        $this->call([
            BrandMasterSeeder::class,      // Core: Products, Hubs, Governance, History
            AdminDashboardSeeder::class,   // Admin: Activity Logs & Trust Alerts
            PassportTransferSeeder::class, // Circularity: Pending & Completed Transfers
            GlobalHubSeeder::class,        // Logistics: International Node coordinates
        ]);
    }
}
