<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Services\SustainabilityImpactService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImpactPortfolioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_provides_impact_history_data()
    {
        $user = User::factory()->create();
        $service = new SustainabilityImpactService();

        $history = $service->getUserImpactHistory($user);

        $this->assertIsArray($history);
        $this->assertCount(6, $history);
        $this->assertArrayHasKey('month', $history[0]);
        $this->assertArrayHasKey('water', $history[0]);
        $this->assertArrayHasKey('carbon', $history[0]);
    }

    /** @test */
    public function test_impact_portfolio_page_is_accessible()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/impact');

        $response->assertStatus(200);
        $response->assertSee('Impact Pulse');
        $response->assertSee('Milestones');
    }
}
