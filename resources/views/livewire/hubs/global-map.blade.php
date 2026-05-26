<?php

use function Livewire\Volt\{state, mount};
use App\Models\LocalHub;

state(['hubs' => [], 'selectedHub' => null]);

mount(function () {
    $this->hubs = \App\Models\LocalHub::all()->map(function ($hub) {
        return [
            'id' => $hub->id,
            'name' => $hub->name,
            'region' => $hub->country ?? 'Global',
            'lat' => (float) $hub->latitude,
            'lng' => (float) $hub->longitude,
            'type' => $hub->capacity_limit > 1000 ? 'Full Service' : 'Micro-Fulfillment',
        ];
    })->toArray();
});

?>

<div class="bg-stone-900 text-white rounded-[3rem] overflow-hidden shadow-2xl relative">
    <!-- Map Header -->
    <div class="p-10 border-b border-white/5 flex justify-between items-center bg-stone-900/50 backdrop-blur-md relative z-20">
        <div>
            <h3 class="text-3xl font-black uppercase tracking-tighter">Global Network</h3>
            <p class="text-stone-500 text-sm font-medium mt-1">Scale of our decentralized circular economy.</p>
        </div>
        <div class="flex gap-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-widest">{{ count($hubs) }} Active Nodes</span>
            </div>
        </div>
    </div>

    <!-- Map Visualization Placeholder (Using SVG for cross-platform reliability) -->
    <div class="relative h-[500px] w-full bg-stone-950 overflow-hidden flex items-center justify-center">
        <!-- Abstract Globe Map -->
        <svg viewBox="0 0 800 400" class="w-full h-full opacity-20">
            <path d="M150 100 Q 200 80 250 100 T 350 120 T 450 100 T 550 130 T 650 110" stroke="white" fill="none" stroke-dasharray="5 5" />
            <path d="M100 200 Q 150 180 200 200 T 300 220 T 400 200 T 500 230 T 600 210" stroke="white" fill="none" stroke-dasharray="2 2" />
        </svg>

        <!-- Dynamic Hub Markers -->
        @foreach($hubs as $hub)
            <div 
                class="absolute cursor-pointer group transition-all"
                style="left: {{ (($hub['lng'] + 180) / 360) * 100 }}%; top: {{ ((90 - $hub['lat']) / 180) * 100 }}%;"
                wire:click="$set('selectedHub', {{ $hub['id'] }})"
            >
                <div class="relative">
                    <!-- Ripple Effect -->
                    <div class="absolute -inset-4 bg-emerald-400/20 rounded-full animate-ping"></div>
                    <!-- Marker Dot -->
                    <div class="w-4 h-4 bg-emerald-400 rounded-full border-2 border-stone-900 relative z-10 group-hover:scale-125 transition-transform shadow-lg shadow-emerald-400/50"></div>
                </div>

                <!-- Label -->
                <div class="absolute top-6 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap bg-stone-800 text-[10px] font-bold px-3 py-1.5 rounded-lg z-20 border border-white/10 shadow-xl">
                    {{ $hub['name'] }}
                </div>
            </div>
        @endforeach

        <!-- Overlay Details Card -->
        @if($selectedHub)
            @php $hubData = collect($hubs)->firstWhere('id', $selectedHub); @endphp
            <div class="absolute bottom-8 right-8 w-80 bg-white text-stone-900 p-8 rounded-3xl shadow-2xl animate-bounce-in z-30 border border-stone-100">
                <button wire:click="$set('selectedHub', null)" class="absolute top-4 right-4 text-stone-300 hover:text-stone-900 transition">
                    <x-lucide-x class="w-5 h-5" />
                </button>
                
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 mb-2 block">{{ $hubData['region'] }}</span>
                <h4 class="text-xl font-black uppercase tracking-tight mb-4">{{ $hubData['name'] }}</h4>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-stone-50 rounded-lg text-stone-400">
                            <x-lucide-settings-2 class="w-4 h-4" />
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-stone-400">Capabilities</p>
                            <p class="text-xs font-bold">{{ $hubData['type'] }}</p>
                        </div>
                    </div>
                    
                    <button class="w-full bg-stone-900 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-stone-800 transition shadow-lg">
                        Browse Hub Inventory
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Map Legend -->
    <div class="p-8 bg-stone-950/50 flex justify-between items-center text-[10px] font-black uppercase tracking-[0.2em] text-stone-600">
        <div class="flex gap-8">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                Full Service Hub
            </div>
            <div class="flex items-center gap-2 opacity-50">
                <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                Micro-Fulfillment
            </div>
        </div>
        <div>
            Interactive Geo-Logistics v1.0
        </div>
    </div>
</div>
