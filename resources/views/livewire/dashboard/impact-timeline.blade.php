<?php

use function Livewire\Volt\{state, mount};
use App\Services\SustainabilityImpactService;

state(['timeframe' => '6m', 'data' => []]);

mount(function (SustainabilityImpactService $service) {
    $this->data = $service->getUserImpactHistory(auth()->user());
});

?>

<div class="bg-white p-6 md:p-8 rounded-3xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
        <div>
            <h3 class="text-xl font-bold text-stone-900 uppercase tracking-tight">Impact Pulse</h3>
            <p class="text-[10px] text-stone-400 font-black uppercase tracking-widest mt-1">Sustainability Trends over {{ $timeframe }}</p>
        </div>
        <div class="flex bg-stone-50 p-1 rounded-xl border border-stone-100 w-fit">
            <button wire:click="$set('timeframe', '6m')" class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ $timeframe === '6m' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-400 hover:text-stone-600' }}">6M</button>
            <button wire:click="$set('timeframe', '1y')" class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ $timeframe === '1y' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-400 hover:text-stone-600' }}">1Y</button>
        </div>
    </div>

    <!-- Visual Chart Placeholder (Responsive CSS bars) -->
    <div class="h-64 flex items-end justify-between gap-1 sm:gap-4 px-2">
        @foreach($data as $point)
            <div class="flex-1 flex flex-col items-center group">
                <div class="w-full relative flex flex-col justify-end gap-0.5 md:gap-1 h-48">
                    <!-- Carbon Bar -->
                    <div 
                        class="w-full bg-stone-900 rounded-t-lg transition-all duration-500 group-hover:bg-stone-700" 
                        style="height: {{ min(100, ($point['carbon'] / 35) * 100) }}%"
                        title="Carbon: {{ $point['carbon'] }}kg"
                    ></div>
                    <!-- Water Bar -->
                    <div 
                        class="w-full bg-blue-500 rounded-t-sm transition-all duration-500 group-hover:bg-blue-400" 
                        style="height: {{ min(100, ($point['water'] / 1500) * 100) }}%"
                        title="Water: {{ $point['water'] }}L"
                    ></div>
                </div>
                <span class="text-[9px] md:text-[10px] font-bold text-stone-400 mt-4 uppercase tracking-widest">{{ $point['month'] }}</span>
            </div>
        @endforeach
    </div>

    <div class="mt-8 pt-8 border-t border-stone-50 flex flex-wrap gap-6 md:gap-8">
        <div class="flex items-center gap-3">
            <div class="w-2.5 h-2.5 bg-blue-500 rounded-full"></div>
            <span class="text-[10px] font-black uppercase tracking-widest text-stone-500">Water Saved (L)</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-2.5 h-2.5 bg-stone-900 rounded-full"></div>
            <span class="text-[10px] font-black uppercase tracking-widest text-stone-500">Carbon Reduced (kg)</span>
        </div>
    </div>
</div>
