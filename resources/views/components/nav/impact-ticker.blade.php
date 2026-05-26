@php
    $impact = app(App\Services\GlobalImpactService::class)->getGlobalTotals();
@endphp

<div class="hidden xl:flex items-center gap-6 bg-stone-50 px-5 py-2 rounded-full border border-stone-100 group cursor-default">
    <div class="flex items-center gap-2">
        <x-lucide-droplets class="w-3.5 h-3.5 text-blue-500" />
        <span class="text-[10px] font-black uppercase tracking-wider text-stone-400">
            <span class="text-stone-900">{{ number_format($impact['water']) }}L</span> Water Saved
        </span>
    </div>
    
    <div class="h-3 w-px bg-stone-200"></div>

    <div class="flex items-center gap-2">
        <x-lucide-wind class="w-3.5 h-3.5 text-green-500" />
        <span class="text-[10px] font-black uppercase tracking-wider text-stone-400">
            <span class="text-stone-900">{{ number_format($impact['carbon']) }}kg</span> CO2 Offset
        </span>
    </div>
</div>
