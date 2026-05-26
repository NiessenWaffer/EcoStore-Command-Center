<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GeoRoutingService;

class GeoDistanceTest extends TestCase
{
    /** @test */
    public function test_it_calculates_haversine_distance_accurately()
    {
        $service = new GeoRoutingService();

        // Distance between NYC and London (approx 5570 km)
        $nycLat = 40.7128;
        $nycLng = -74.0060;
        $lonLat = 51.5074;
        $lonLng = -0.1278;

        $distance = $service->calculateDistance($nycLat, $nycLng, $lonLat, $lonLng);

        // Allow for small margin of error (standard in Haversine)
        $this->assertGreaterThan(5500, $distance);
        $this->assertLessThan(5600, $distance);
    }

    /** @test */
    public function test_it_returns_zero_for_same_coordinates()
    {
        $service = new GeoRoutingService();
        $this->assertEquals(0, $service->calculateDistance(40.7, -74.0, 40.7, -74.0));
    }
}
