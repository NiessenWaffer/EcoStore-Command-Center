<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MobileAdminResponsiveTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_admin_dashboard_renders_with_mobile_hamburger()
    {
        $this->withoutExceptionHandling();
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        
        // Verify mobile hamburger exists in source
        $response->assertSee('adminMenuOpen');
        $response->assertSee('M4 12h16'); // SVG path for hamburger
    }

    /** @test */
    public function test_admin_kpi_grid_has_responsive_classes()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        // Verify responsive grid class
        $response->assertSee('grid-cols-1 sm:grid-cols-2 lg:grid-cols-4');
    }

    /** @test */
    public function test_admin_activity_log_converts_to_mobile_cards()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        // Verify mobile card container exists
        $response->assertSee('md:hidden space-y-4');
    }

    /** @test */
    public function test_mobile_fab_exists_in_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        // Verify FAB container
        $response->assertSee('fabOpen');
        $response->assertSee('fixed bottom-8 right-8');
    }
}
