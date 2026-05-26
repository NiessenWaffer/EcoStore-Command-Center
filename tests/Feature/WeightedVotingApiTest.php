<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\GovernanceProposal;
use App\Services\GovernanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeightedVotingApiTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GovernanceService();
    }

    public function test_service_rejects_vote_exceeding_user_power()
    {
        $user = User::factory()->create(['cumulative_water_saved' => 500]); // 5 Power
        $proposal = GovernanceProposal::create([
            'title' => 'Test',
            'description' => 'Test',
            'type' => 'Charity',
            'options' => [['id' => 'o1', 'name' => 'Opt 1']],
            'status' => 'Active',
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
            'quorum_threshold' => 10,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Insufficient governance power.");

        $this->service->castQuadraticVote($user, $proposal, ['o1' => 6]);
    }

    public function test_service_records_valid_weighted_vote()
    {
        $user = User::factory()->create(['cumulative_water_saved' => 1000]); // 10 Power
        $proposal = GovernanceProposal::create([
            'title' => 'Test',
            'description' => 'Test',
            'type' => 'Charity',
            'options' => [['id' => 'o1', 'name' => 'Opt 1'], ['id' => 'o2', 'name' => 'Opt 2']],
            'status' => 'Active',
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
            'quorum_threshold' => 10,
        ]);

        $vote = $this->service->castQuadraticVote($user, $proposal, ['o1' => 4, 'o2' => 6]);

        $this->assertEquals(10, $vote->weight_cast);
        $this->assertDatabaseHas('governance_votes', [
            'user_id' => $user->id,
            'proposal_id' => $proposal->id,
            'weight_cast' => 10,
        ]);
        
        $proposal->refresh();
        // Influence = sqrt(4) + sqrt(6) = 2 + 2.45 = 4.45
        $this->assertEquals(4.45, $proposal->total_weight_cast);
    }
}
