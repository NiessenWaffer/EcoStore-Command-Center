<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MobileShopResponsiveTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_catalog_renders_mobile_filter_trigger()
    {
        $response = $this->get('/shop');

        $response->assertStatus(200);
        
        // Verify mobile filter button exists
        $response->assertSee('mobileFiltersOpen');
        $response->assertSee('Filter & Sort', false); // Allow escaped chars
    }

    /** @test */
    public function test_product_grid_has_responsive_classes()
    {
        $response = $this->get('/shop');
        
        // Verify 2-column mobile grid class
        $response->assertSee('grid-cols-2');
    }

    /** @test */
    public function test_pdp_has_sticky_cta_bar()
    {
        $product = \App\Models\Product::first() ?? Product::factory()->create(['is_published' => true]);
        
        $response = $this->get(route('product.show', $product->slug));

        $response->assertStatus(200);
        
        // Verify sticky bar exist in source
        $response->assertSee('fixed bottom-0');
        $response->assertSee('Add to Bag');
    }
}
