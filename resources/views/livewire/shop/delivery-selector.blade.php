<?php

use Livewire\Volt\Component;
use App\Models\LocalHub;
use App\Services\GeoRoutingService;
use Illuminate\Support\Facades\Session;

new class extends Component
{
    public $shippingMethod = 'standard'; // standard, bundle, hub
    public $selectedHubId = null;
    public $hubs = [];
    public $bonusApplied = false;

    public function mount()
    {
        // For MVP, we'll mock the user's current location to find hubs
        // In a real app, we'd use browser geolocation or the shipping address
        $routing = app(GeoRoutingService::class);
        $this->hubs = LocalHub::where('is_active', true)->get();
        
        $this->shippingMethod = Session::get('selected_shipping_method', 'standard');
        $this->selectedHubId = Session::get('selected_hub_id');
        $this->updateBonus();
    }

    public function selectMethod($method)
    {
        $this->shippingMethod = $method;
        Session::put('selected_shipping_method', $method);
        $this->updateBonus();
    }

    public function selectHub($id)
    {
        $this->selectedHubId = $id;
        Session::put('selected_hub_id', $id);
    }

    protected function updateBonus()
    {
        $this->bonusApplied = ($this->shippingMethod === 'bundle' || $this->shippingMethod === 'hub');
        Session::put('green_bonus_active', $this->bonusApplied);
    }
};
?>

<div class="space-y-6">
    <h3 class="text-xl font-bold mb-6">Select Green Delivery Method</h3>

    <!-- Neighborhood Bundle -->
    <div @click="selectMethod('bundle')" 
         class="p-6 rounded-2xl border-2 cursor-pointer transition @if($shippingMethod === 'bundle') border-black bg-stone-50 @else border-stone-100 hover:border-stone-200 @endif">
        <div class="flex justify-between items-start">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-stone-900">Neighborhood Bundle</h4>
                    <p class="text-stone-500 text-sm mt-1">Sync your delivery with a neighbor to reduce trips.</p>
                </div>
            </div>
            <span class="bg-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">+50L Impact Bonus</span>
        </div>
    </div>

    <!-- Local Hub Pickup -->
    <div @click="selectMethod('hub')" 
         class="p-6 rounded-2xl border-2 cursor-pointer transition @if($shippingMethod === 'hub') border-black bg-stone-50 @else border-stone-100 hover:border-stone-200 @endif">
        <div class="flex items-center space-x-4 mb-6">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-stone-900">Local Zero-Waste Pickup</h4>
                <p class="text-stone-500 text-sm mt-1">Pick up from a micro-hub with **Naked Shipping** (No packaging).</p>
            </div>
        </div>

        @if($shippingMethod === 'hub')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 animate-fadeIn">
            @foreach($hubs as $hub)
            <div @click.stop="selectHub({{ $hub->id }})" 
                 class="p-4 rounded-xl border transition @if($selectedHubId == $hub->id) border-black bg-white ring-2 ring-black/5 @else border-stone-100 hover:border-stone-200 @endif">
                <p class="font-bold text-sm">{{ $hub->name }}</p>
                <p class="text-stone-400 text-xs mt-1">{{ $hub->address }}, {{ $hub->city }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Standard Carbon-Neutral -->
    <div @click="selectMethod('standard')" 
         class="p-6 rounded-2xl border-2 cursor-pointer transition @if($shippingMethod === 'standard') border-black bg-stone-50 @else border-stone-100 hover:border-stone-200 @endif">
        <div class="flex items-center space-x-4">
            <div class="bg-stone-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-stone-900">Standard Carbon-Neutral</h4>
                <p class="text-stone-500 text-sm mt-1">Free domestic shipping via offset carriers.</p>
            </div>
        </div>
    </div>
</div>
