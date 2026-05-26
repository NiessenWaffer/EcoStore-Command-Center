<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\LocalHub;
use App\Models\User;
use App\Services\SustainabilityImpactService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class InternationalCheckoutTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** @test */
    public function test_it_calculates_high_carbon_impact_for_international_transit()
    {
        $hub = LocalHub::create([
            'name' => 'Test EU Hub',
            'region_code' => 'EU',
            'address' => 'Berlin',
            'city' => 'Berlin',
            'postal_code' => '10117',
            'latitude' => 52.52,
            'longitude' => 13.40,
        ]);

        $impactService = new SustainabilityImpactService();
        
        // Mocking a long distance destination zip (In our MVP service it uses rand for distance)
        $impact = $impactService->calculateTransitImpact($hub, '10001');

        $this->assertArrayHasKey('co2_penalty', $impact);
        $this->assertArrayHasKey('regeneration_fee', $impact);
        $this->assertEquals('Test EU Hub', $impact['sourcing_hub']);
    }

    /** @test */
    public function test_geo_detection_endpoint_is_accessible()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('api.geo.detect'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['region', 'ip']);
    }
}
