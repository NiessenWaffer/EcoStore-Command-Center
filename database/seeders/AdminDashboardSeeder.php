<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AdminActivityLog;
use Illuminate\Support\Str;

class AdminDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();
        if (!$admin) return;

        $actions = [
            ['action' => 'Created Product', 'description' => 'Added Organic Cotton Tee to inventory.'],
            ['action' => 'Verified Hub', 'description' => 'San Francisco Hub inspection complete.'],
            ['action' => 'Issued Correction', 'description' => 'Corrected carbon metrics for Batch #992-X.'],
            ['action' => 'Started Governance', 'description' => 'Launched June Charity Allocation round.'],
        ];

        foreach ($actions as $action) {
            AdminActivityLog::create([
                'id' => (string) Str::uuid(),
                'user_id' => $admin->id,
                'action' => $action['action'],
                'description' => $action['description'],
                'timestamp' => now()->subHours(rand(1, 48)),
            ]);
        }
    }
}
