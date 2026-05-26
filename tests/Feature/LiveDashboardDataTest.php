<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\GovernanceProposal;
use App\Models\GovernanceVote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Admin\DashboardStats;

class LiveDashboardDataTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_admin_dashboard_stats_show_real_vote_influence()
    {
        \Illuminate\Support\Facades\Cache::forget('admin_active_governance');
        $admin = User::factory()->create(['is_admin' => true]);
        
        $proposal = GovernanceProposal::create([
            'title' => 'Test Proposal',
            'description' => 'Test Description',
            'type' => 'Charity',
            'options' => [],
            'status' => 'Active',
            'quorum_threshold' => 100,
            'starts_at' => now(),
            'ends_at' => now()->addDays(1)
        ]);

        // Cast a real vote with 50 influence
        GovernanceVote::create([
            'user_id' => $admin->id,
            'proposal_id' => $proposal->id,
            'resultant_influence' => 50,
            'weight_cast' => 50,
            'allocations' => []
        ]);

        Livewire::actingAs($admin)
            ->test('admin.dashboard-stats')
            ->assertSee('50%'); // 50 influence / 100 quorum
    }

    /** @test */
    public function test_admin_dashboard_impact_stats_are_aggregated_from_users()
    {
        \Illuminate\Support\Facades\Cache::forget('admin_impact_stats');
        $admin = User::factory()->create(['is_admin' => true]);
        
        User::factory()->create(['cumulative_water_saved' => 5000]);
        User::factory()->create(['cumulative_water_saved' => 2500]);

        Livewire::actingAs($admin)
            ->test('admin.dashboard-stats')
            ->assertSee('7,500 L');
    }
}
