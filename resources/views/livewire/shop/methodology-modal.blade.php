<?php

use function Livewire\Volt\{state, mount};

state(['open' => false, 'impact' => []]);

mount(function (array $impact) {
    $this->impact = $impact;
});

?>

<div>
    <button wire:click="$set('open', true)" class="text-[10px] font-black uppercase tracking-widest text-stone-400 border-b border-stone-300 hover:text-stone-900 transition">
        Transparency Data
    </button>

    @if($open)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-stone-900/90 backdrop-blur-md">
            <div class="bg-white max-w-2xl w-full rounded-[3rem] shadow-2xl overflow-hidden border border-stone-100 animate-bounce-in">
                <!-- Header -->
                <div class="bg-stone-50 p-12 border-b border-stone-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-3xl font-black uppercase tracking-tighter text-stone-900">Methodology</h3>
                        <p class="text-stone-500 text-sm font-medium mt-1">Mathematical proof behind the Impact Index.</p>
                    </div>
                    <button wire:click="$set('open', false)" class="p-3 bg-white rounded-2xl shadow-sm border border-stone-100 hover:bg-stone-50 transition">
                        <x-lucide-x class="w-6 h-6 text-stone-400" />
                    </button>
                </div>

                <!-- Body -->
                <div class="p-12 space-y-12">
                    <div class="flex items-center gap-8">
                        <div class="relative h-32 w-32 flex items-center justify-center rounded-full bg-stone-50 border border-stone-100">
                             <span class="text-5xl font-black text-stone-900 tracking-tighter">{{ $impact['impact_index'] }}</span>
                        </div>
                        <div class="flex-1">
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                                {{ $impact['tier_label'] }}
                            </span>
                            <p class="text-stone-600 text-sm leading-relaxed mt-4">
                                This score is a weighted aggregation of resource conservation relative to conventional industry baselines.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-8 bg-stone-50 rounded-3xl border border-stone-100">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-[10px] font-black uppercase tracking-widest text-blue-600">60% Weight</span>
                                <x-lucide-droplets class="w-4 h-4 text-blue-500" />
                            </div>
                            <h4 class="text-xl font-black uppercase tracking-tight text-stone-900">Water Conservation</h4>
                            <p class="text-xs text-stone-500 mt-2 leading-relaxed">Calculated by measuring the delta between organic crop irrigation and traditional flood-irrigation cotton.</p>
                        </div>

                        <div class="p-8 bg-stone-50 rounded-3xl border border-stone-100">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-[10px] font-black uppercase tracking-widest text-stone-900">40% Weight</span>
                                <x-lucide-cloud class="w-4 h-4 text-stone-400" />
                            </div>
                            <h4 class="text-xl font-black uppercase tracking-tight text-stone-900">Carbon Efficiency</h4>
                            <p class="text-xs text-stone-500 mt-2 leading-relaxed">Includes energy reduction in processing and the low-impact benefits of decentralized geo-logistics.</p>
                        </div>
                    </div>

                    <div class="p-6 bg-emerald-500 text-white rounded-2xl">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">Impact Multiplier</p>
                        <p class="text-sm font-medium">This product achieves a <span class="font-black underline">{{ round($impact['impact_index'] / 2, 1) }}x performance gain</span> compared to conventional peers.</p>
                    </div>
                </div>

                <div class="p-8 bg-stone-50 border-t border-stone-100 text-center">
                    <a href="{{ route('mission') }}" class="text-[10px] font-black uppercase tracking-widest text-stone-400 hover:text-stone-900 transition">View Full Engineering Documentation</a>
                </div>
            </div>
        </div>
    @endif
</div>
