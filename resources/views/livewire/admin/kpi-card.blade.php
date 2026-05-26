<?php

use function Livewire\Volt\{state};

state(['label', 'value', 'icon', 'trend' => null, 'color' => 'stone']);

?>

<div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm group hover:shadow-md transition-all">
    <div class="flex items-center justify-between mb-6">
        <div class="p-3 bg-{{ $color }}-100 rounded-2xl group-hover:scale-110 transition-transform">
            @php
                $iconComponent = "lucide-" . $icon;
            @endphp
            <x-dynamic-component :component="$iconComponent" class="w-6 h-6 text-{{ $color }}-600" />
        </div>
        @if($trend)
        <span class="text-[10px] font-black uppercase tracking-widest text-green-500 bg-green-50 px-2 py-1 rounded-full">
            {{ $trend }}
        </span>
        @endif
    </div>
    
    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 mb-2">{{ $label }}</p>
    <h4 class="text-3xl font-black text-stone-900 tracking-tighter">{{ $value }}</h4>
</div>
