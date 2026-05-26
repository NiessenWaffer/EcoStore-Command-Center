@props(['co2' => 0, 'fee' => 0, 'location' => 'International'])

<div x-data="{ open: true }" x-show="open" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-stone-900/80 backdrop-blur-sm">
    <div class="bg-white max-w-lg w-full rounded-[2.5rem] shadow-2xl overflow-hidden border border-stone-100 animate-bounce-in">
        <!-- Warning Header -->
        <div class="bg-amber-500 p-10 text-white relative">
            <x-lucide-plane-takeoff class="w-16 h-16 opacity-20 absolute -right-4 -bottom-4 rotate-12" />
            <div class="flex items-center gap-4 mb-6">
                <div class="p-2 bg-white/20 rounded-lg">
                    <x-lucide-alert-triangle class="w-6 h-6" />
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tighter">Global Transit Alert</h3>
            </div>
            <p class="text-white/90 text-sm font-medium leading-relaxed">
                This item is currently located in our <strong>{{ $location }} Hub</strong>. Shipping it to your current location requires long-distance air freight.
            </p>
        </div>

        <!-- Impact Breakdown -->
        <div class="p-10 space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-400 mb-1">Carbon Penalty</p>
                    <p class="text-3xl font-black text-stone-900">+{{ $co2 }} kg CO2</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-400 mb-1">Regeneration Fee</p>
                    <p class="text-3xl font-black text-emerald-600">${{ number_format($fee, 2) }}</p>
                </div>
            </div>

            <div class="p-4 bg-stone-50 rounded-2xl border border-stone-100">
                <p class="text-[10px] leading-relaxed text-stone-500">
                    <span class="font-bold text-stone-900 uppercase">Sustainability Mandate:</span> To maintain our 100% carbon neutral promise, all international transit must be offset at a 2x rate via our verified reforestation projects.
                </p>
            </div>

            <div class="flex gap-4">
                <button @click="open = false" class="flex-1 bg-stone-900 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-stone-800 transition shadow-xl">
                    Acknowledge & Offset
                </button>
            </div>
            
            <p class="text-center">
                <a href="{{ route('shop') }}" class="text-[10px] font-black uppercase tracking-widest text-stone-400 hover:text-stone-900 transition border-b border-transparent hover:border-stone-900 pb-0.5">
                    Browse Local Inventory Instead
                </a>
            </p>
        </div>
    </div>
</div>
