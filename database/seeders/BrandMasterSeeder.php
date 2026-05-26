<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandMasterSeeder extends Seeder
{
    /**
     * Run the database seeds in a unified sequence.
     */
    public function run(): void
    {
        // 1. Core Data (Metrics, Categories, Products, Variants)
        $this->call(SampleProductSeeder::class);

        // 2. Logistics (Hubs)
        $this->call(LocalHubSeeder::class);

        // 3. Governance (Proposals)
        $this->call(GovernanceSeeder::class);

        // 4. User Activity (Orders, Resale, Points)
        $this->call(UserActivitySeeder::class);

        // 5. Trust Layer (Verified Chain)
        $this->call(PassportAuditSeeder::class);

        $this->command->info('Brand Ecosystem successfully seeded and unified!');
    }
}
