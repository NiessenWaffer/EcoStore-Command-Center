<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GovernanceService;

class QuadraticMathTest extends TestCase
{
    /** @test */
    public function test_it_calculates_quadratic_influence_correctly()
    {
        $service = new GovernanceService();

        // 1 vote = 1 influence
        $this->assertEquals(1.0, $service->calculateQuadraticInfluence(1));
        
        // 4 votes = 2 influence
        $this->assertEquals(2.0, $service->calculateQuadraticInfluence(4));
        
        // 10 votes = 3.16 influence
        $this->assertEquals(3.16, $service->calculateQuadraticInfluence(10));
        
        // 100 votes = 10 influence
        $this->assertEquals(10.0, $service->calculateQuadraticInfluence(100));
    }
}
