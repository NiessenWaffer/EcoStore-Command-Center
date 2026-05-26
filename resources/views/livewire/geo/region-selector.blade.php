<?php

use function Livewire\Volt\{state, mount};

state(['regions' => [], 'currentRegion' => 'US']);

mount(function () {
    $this->regions = [
        ['code' => 'US', 'name' => 'North America', 'flag' => '🇺🇸'],
        ['code' => 'EU', 'name' => 'European Union', 'flag' => '🇪🇺'],
        ['code' => 'UK', 'name' => 'United Kingdom', 'flag' => '🇬🇧'],
        ['code' => 'JP', 'name' => 'Asia Pacific', 'flag' => '🇯🇵'],
    ];
});

$selectRegion = function ($code) {
    $this->currentRegion = $code;
    // In a real app, this would refresh session/cookies and redirect or dispatch event
    $this->dispatch('region-changed', region: $code);
};

?>

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center gap-3 bg-stone-50 px-4 py-2 rounded-xl border border-stone-100 hover:bg-stone-100 transition-all group">
        @php $active = collect($regions)->firstWhere('code', $currentRegion); @endphp
        <span class="text-sm">{{ $active['flag'] }}</span>
        <span class="text-[10px] font-black uppercase tracking-widest text-stone-900">{{ $active['code'] }}</span>
        <x-lucide-chevron-down class="w-3 h-3 text-stone-300 group-hover:text-stone-900 transition-transform" ::class="open ? 'rotate-180' : ''" />
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-stone-100 overflow-hidden z-[60]"
         style="display: none;">
        
        <div class="p-4 bg-stone-50 border-b border-stone-100">
            <p class="text-[10px] font-black uppercase tracking-widest text-stone-400">Select Market</p>
        </div>

        <div class="p-2">
            @foreach($regions as $region)
                <button 
                    wire:click="selectRegion('{{ $region['code'] }}')"
                    @click="open = false"
                    class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-stone-50 transition-colors group {{ $currentRegion === $region['code'] ? 'bg-stone-50' : '' }}"
                >
                    <div class="flex items-center gap-3">
                        <span class="text-base">{{ $region['flag'] }}</span>
                        <div class="text-left">
                            <p class="text-xs font-bold text-stone-900">{{ $region['name'] }}</p>
                            <p class="text-[9px] text-stone-400 uppercase tracking-widest">{{ $region['code'] }} Market</p>
                        </div>
                    </div>
                    @if($currentRegion === $region['code'])
                        <x-lucide-check class="w-4 h-4 text-emerald-500" />
                    @endif
                </button>
            @endforeach
        </div>

        <div class="p-4 bg-stone-900 text-white">
            <p class="text-[9px] leading-relaxed opacity-60">
                Switching regions may affect inventory availability and shipping impact calculations.
            </p>
        </div>
    </div>
</div>
