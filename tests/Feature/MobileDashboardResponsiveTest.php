<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Dashboard\CommandCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MobileDashboardResponsiveTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_dashboard_renders_with_mobile_tab_bar()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CommandCenter::class)
            ->assertStatus(200)
            ->assertSee('overflow-x-auto no-scrollbar')
            ->assertSee('overview')
            ->assertSee('impact');
    }

    /** @test */
    public function test_order_history_converts_to_mobile_cards()
    {
        $user = User::factory()->create();
        \App\Models\Order::create([
            'user_id' => $user->id,
            'total_cents' => 5000,
            'status' => 'completed',
            'payment_status' => 'paid',
            'shipping_address' => ['city' => 'Denver'],
        ]);
        
        Livewire::actingAs($user)
            ->test(CommandCenter::class, ['tab' => 'orders'])
            ->assertStatus(200)
            ->assertSee('md:hidden space-y-4')
            ->assertSee('Order #');
    }

    /** @test */
    public function test_milestone_grid_is_responsive()
    {
        $user = User::factory()->create();
        
        Livewire::actingAs($user)
            ->test(CommandCenter::class, ['tab' => 'impact'])
            ->assertStatus(200)
            ->assertSee('grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6');
    }
}
