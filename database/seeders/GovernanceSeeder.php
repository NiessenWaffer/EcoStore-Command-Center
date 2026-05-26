<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GovernanceProposal;
use Carbon\Carbon;

class GovernanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Charity Selection (Active)
        GovernanceProposal::create([
            'title' => 'Q3 Impact Fund: Charity Selection',
            'description' => 'Help us decide which ocean cleanup initiative receives our quarterly 1% revenue donation.',
            'type' => 'Charity',
            'options' => [
                ['id' => 'ocean_cleanup', 'name' => 'The Ocean Cleanup', 'description' => 'Advanced technologies for plastic removal.'],
                ['id' => 'surfrider', 'name' => 'Surfrider Foundation', 'description' => 'Beach protection and ocean health.'],
                ['id' => 'sea_shepherd', 'name' => 'Sea Shepherd', 'description' => 'Direct action wildlife protection.'],
            ],
            'status' => 'Active',
            'starts_at' => now()->subDays(2),
            'ends_at' => now()->addDays(5),
            'quorum_threshold' => 1000,
            'total_weight_cast' => 0,
        ]);

        // 2. Community Challenge (Active)
        GovernanceProposal::create([
            'title' => 'Community Challenge: September Goal',
            'description' => 'Vote on the target reduction for our next collective community challenge.',
            'type' => 'Challenge',
            'options' => [
                ['id' => 'water_50k', 'name' => 'Save 50,000L Water', 'description' => 'A moderate goal for early autumn.'],
                ['id' => 'water_100k', 'name' => 'Save 100,000L Water', 'description' => 'An ambitious goal for high impact.'],
            ],
            'status' => 'Active',
            'starts_at' => now()->subDays(1),
            'ends_at' => now()->addDays(12),
            'quorum_threshold' => 500,
            'total_weight_cast' => 0,
        ]);

        // 3. Past Executed Proposal
        GovernanceProposal::create([
            'title' => 'Q2 Impact Allocation',
            'description' => 'Deciding the reforestation project for spring.',
            'type' => 'Charity',
            'options' => [
                ['id' => 'tree_nation', 'name' => 'TreeNation', 'description' => 'Planting in Madagascar.'],
                ['id' => 'eden', 'name' => 'Eden Projects', 'description' => 'Planting in Ethiopia.'],
            ],
            'status' => 'Executed',
            'starts_at' => now()->subMonths(3),
            'ends_at' => now()->subMonths(2),
            'quorum_threshold' => 1000,
            'total_weight_cast' => 12500,
        ]);
    }
}
