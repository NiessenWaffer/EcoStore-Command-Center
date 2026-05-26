<?php

use function Livewire\Volt\{state, mount};

state([
    'voteCost' => 1,
    'influence' => 1,
    'isQuadratic' => true,
    'maxVotes' => 100 // Based on user impact in real app
]);

$updatedCost = function () {
    if ($this->isQuadratic) {
        $this->influence = round(sqrt($this->voteCost), 2);
    } else {
        $this->influence = $this->voteCost;
    }
};

$toggleMode = function () {
    $this->isQuadratic = !$this->isQuadratic;
    $this->updatedCost();
};

?>

<div class="bg-stone-900 text-white p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
    <!-- Background Gradient Glow -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 blur-[100px] pointer-events-none"></div>

    <div class="flex items-center justify-between mb-12">
        <div>
            <h3 class="text-2xl font-black uppercase tracking-tighter">Cast Your Influence</h3>
            <p class="text-stone-500 text-sm font-medium mt-1">Allocation weights are calculated {{ $isQuadratic ? 'quadratically' : 'linearly' }}.</p>
        </div>
        <button wire:click="toggleMode" class="bg-white/5 border border-white/10 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white/10 transition-all flex items-center gap-2">
            <x-lucide-arrow-left-right class="w-3 h-3" />
            {{ $isQuadratic ? 'Switch to Linear' : 'Switch to Quadratic' }}
        </button>
    </div>

    <div class="space-y-12">
        <!-- Visualization: Cost vs Influence -->
        <div class="flex items-end gap-1 h-32 px-4">
            @for($i = 1; $i <= 10; $i++)
                @php
                    $stepCost = pow($i, 2);
                    $isActive = $this->voteCost >= $stepCost;
                @endphp
                <div class="flex-1 group relative">
                    <div 
                        class="w-full rounded-t-lg transition-all duration-500 {{ $isActive ? 'bg-emerald-400' : 'bg-white/5' }}" 
                        style="height: {{ $i * 10 }}%"
                    ></div>
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity bg-stone-800 text-[8px] font-bold px-2 py-1 rounded whitespace-nowrap">
                        Inf: {{ $i }} | Cost: {{ $stepCost }}
                    </div>
                </div>
            @endfor
        </div>

        <!-- Slider Control -->
        <div class="space-y-6">
            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-stone-500">
                <span>1 Vote</span>
                <span>{{ $maxVotes }} Votes Available</span>
            </div>
            <input 
                type="range" 
                wire:model.live="voteCost" 
                wire:input="updatedCost"
                min="1" 
                max="{{ $maxVotes }}" 
                class="w-full h-2 bg-white/10 rounded-lg appearance-none cursor-pointer accent-emerald-400"
            >
        </div>

        <!-- Final Calculation -->
        <div class="grid grid-cols-2 gap-8 pt-8 border-t border-white/5">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-2">Resource Cost</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black">{{ $voteCost }}</span>
                    <span class="text-xs font-bold text-stone-600 uppercase">Impact Credits</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-500 mb-2">Resultant Influence</p>
                <div class="flex items-baseline justify-end gap-2 text-emerald-400">
                    <span class="text-4xl font-black">{{ $influence }}</span>
                    <span class="text-xs font-bold uppercase">Weighted Power</span>
                </div>
            </div>
        </div>

        @if($isQuadratic)
            <div class="p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl">
                <p class="text-[10px] leading-relaxed text-stone-400">
                    <span class="text-emerald-400 font-bold">Democratic Protection Active:</span> Quadratic voting ensures that the square root of your credits equals your influence. This prevents large contributors from overriding the collective will of the community.
                </p>
            </div>
        @endif

        <button class="w-full bg-emerald-500 text-stone-900 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-xl shadow-emerald-500/10">
            Confirm & Cast Vote
        </button>
    </div>
</div>
