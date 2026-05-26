<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MobileResponsiveTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_home_page_renders_with_mobile_elements()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // Verify Hamburger Menu exists in source (hidden or visible)
        $response->assertSee('mobileMenuOpen');
        $response->assertSee('M4 12h16'); // SVG path for the hamburger middle line
        
        // Verify stacked Hero layout class hints
        $response->assertSee('flex flex-col sm:flex-row justify-center');
    }

    /** @test */
    public function test_mobile_drawer_navigation_links_exist()
    {
        $response = $this->get('/');
        
        // Primary mobile menu links
        $response->assertSee('All Collections');
        $response->assertSee('Resale Portal');
        $response->assertSee('Traceability');
        $response->assertSee('Governance');
        $response->assertSee('Our Mission');
    }

    /** @test */
    public function test_creator_attribution_watermark_exists()
    {
        $response = $this->get('/');
        $response->assertSee('Created by Ronie R. Pactol');
    }
}
