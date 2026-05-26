<?php

use function Livewire\Volt\{state, computed};
use App\Services\SustainabilityImpactService;

state([
    'hempPercent' => 0,
    'organicCottonPercent' => 100,
    'recycledPolyesterPercent' => 0,
    'weight' => 0.5,
]);

$impact = computed(function () {
    $service = app(SustainabilityImpactService::class);
    
    // Normalize percentages to ensure sum is 100 for the simulation
    $total = $this->hempPercent + $this->organicCottonPercent + $this->recycledPolyesterPercent;
    if ($total == 0) return ['impact_index' => 0, 'tier_label' => 'None'];

    $composition = [
        'Hemp' => $this->hempPercent,
        'Organic Cotton' => $this->organicCottonPercent,
        'Recycled Polyester' => $this->recycledPolyesterPercent,
    ];

    // Create a mock product/variant structure for the service
    $variant = new \App\Models\ProductVariant(['physical_weight_kg' => $this->weight]);
    $product = new \App\Models\Product(['material_composition' => $composition]);
    $variant->setRelation('product', $product);

    return $service->calculateVariantImpact($variant);
});

?>

<div class="bg-white rounded-[3rem] border border-stone-100 shadow-2xl overflow-hidden flex flex-col lg:flex-row">
    <!-- Controls Sidebar -->
    <div class="lg:w-1/3 bg-stone-50 p-12 border-r border-stone-100">
        <h3 class="text-2xl font-black uppercase tracking-tighter mb-8 text-stone-900">Material Simulator</h3>
        
        <div class="space-y-10">
            <!-- Weight Slider -->
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <label class="text-[10px] font-black uppercase tracking-widest text-stone-400">Garment Weight</label>
                    <span class="text-sm font-bold text-stone-900">{{ $weight }} kg</span>
                </div>
                <input type="range" wire:model.live="weight" min="0.1" max="1.5" step="0.05" class="w-full h-1.5 bg-stone-200 rounded-lg appearance-none cursor-pointer accent-black">
            </div>

            <!-- Material Mix -->
            <div class="space-y-8">
                <p class="text-[10px] font-black uppercase tracking-widest text-stone-400">Composition Mix</p>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-stone-600">Hemp</span>
                        <span class="text-xs font-black">{{ $hempPercent }}%</span>
                    </div>
                    <input type="range" wire:model.live="hempPercent" min="0" max="100" class="w-full h-1.5 bg-emerald-100 rounded-lg appearance-none cursor-pointer accent-emerald-500">
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-stone-600">Organic Cotton</span>
                        <span class="text-xs font-black">{{ $organicCottonPercent }}%</span>
                    </div>
                    <input type="range" wire:model.live="organicCottonPercent" min="0" max="100" class="w-full h-1.5 bg-blue-100 rounded-lg appearance-none cursor-pointer accent-blue-500">
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-stone-600">Recycled Poly</span>
                        <span class="text-xs font-black">{{ $recycledPolyesterPercent }}%</span>
                    </div>
                    <input type="range" wire:model.live="recycledPolyesterPercent" min="0" max="100" class="w-full h-1.5 bg-stone-200 rounded-lg appearance-none cursor-pointer accent-stone-400">
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-stone-200">
            <p class="text-[10px] leading-relaxed text-stone-400 italic">
                *Percentages are normalized during calculation to ensure a 100% total mix. Note how Hemp significantly boosts the index due to low water usage.
            </p>
        </div>
    </div>

    <!-- Live Results Dashboard -->
    <div class="flex-1 p-16 flex flex-col justify-center items-center text-center relative">
        <!-- Abstract Background Glow -->
        <div class="absolute inset-0 opacity-10 pointer-events-none overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-400 blur-[120px] rounded-full"></div>
        </div>

        <div class="relative z-10 space-y-12">
            <div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 mb-4 block">Simulation Result</span>
                <div class="text-9xl font-black text-stone-900 tracking-tighter leading-none">
                    {{ $this->impact['impact_index'] }}
                </div>
                <div class="mt-6">
                    <span class="bg-black text-white px-8 py-3 rounded-full text-sm font-black uppercase tracking-widest shadow-xl">
                        {{ $this->impact['tier_label'] }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-16 w-full max-w-lg mx-auto">
                <div class="space-y-2">
                    <p class="text-4xl font-black text-blue-600 tracking-tight">{{ number_format($this->impact['water_saved']) }}L</p>
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-400">Water Saved</p>
                </div>
                <div class="space-y-2">
                    <p class="text-4xl font-black text-stone-900 tracking-tight">{{ number_format($this->impact['carbon_reduced'], 1) }}kg</p>
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-400">Carbon Avoided</p>
                </div>
            </div>

            <div class="pt-12 border-t border-stone-100 max-w-md">
                <p class="text-sm text-stone-500 leading-relaxed">
                    At this index, your garment is <span class="font-bold text-stone-900">{{ $this->impact['impact_index'] }}% better</span> than industry standard conventional polyester equivalents.
                </p>
            </div>
        </div>
    </div>
</div>
