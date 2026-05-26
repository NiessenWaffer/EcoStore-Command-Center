<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\GovernanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GovernancePowerTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GovernanceService();
    }

    public function test_calculate_user_power_returns_floor_divided_by_100()
    {
        $user = User::factory()->create(['cumulative_water_saved' => 1250]);
        $this->assertEquals(12, $this->service->calculateUserPower($user));

        $user2 = User::factory()->create(['cumulative_water_saved' => 99]);
        $this->assertEquals(0, $this->service->calculateUserPower($user2));

        $user3 = User::factory()->create(['cumulative_water_saved' => 10000]);
        $this->assertEquals(100, $this->service->calculateUserPower($user3));
    }
}
