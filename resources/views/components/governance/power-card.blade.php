@props(['power' => 0])

<div class="bg-stone-900 rounded-2xl p-6 shadow-2xl relative overflow-hidden group">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/5 rounded-full group-hover:bg-white/10 transition-all duration-700"></div>
    <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-stone-500/10 rounded-full"></div>

    <div class="relative z-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 bg-stone-800 rounded-lg border border-stone-700">
                <x-lucide-vote class="w-5 h-5 text-stone-300" />
            </div>
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-500">Your Voting Power</span>
        </div>

        <div class="flex items-baseline gap-2">
            <span class="text-5xl font-black text-white tracking-tighter">{{ number_format($power) }}</span>
            <span class="text-sm font-bold text-stone-500 uppercase tracking-widest">Votes</span>
        </div>

        <div class="mt-8 space-y-3">
            <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
                <span class="text-stone-400">Power Source</span>
                <span class="text-stone-200">Verified Impact</span>
            </div>
            <div class="h-1.5 w-full bg-stone-800 rounded-full overflow-hidden">
                <div class="h-full bg-stone-400 rounded-full transition-all duration-1000" style="width: {{ min(100, ($power / 1000) * 100) }}%"></div>
            </div>
            <p class="text-[10px] text-stone-500 italic leading-tight">
                Calculated as 1 vote per 100L of water saved through your sustainable choices.
            </p>
        </div>

        @if($power == 0)
            <div class="mt-6 p-3 bg-amber-900/20 border border-amber-900/30 rounded-lg flex gap-3">
                <x-lucide-info class="w-4 h-4 text-amber-500 shrink-0" />
                <p class="text-[10px] text-amber-200/70 leading-normal">
                    You haven't earned any governance power yet. Shop sustainable items to start influencing brand decisions.
                </p>
            </div>
        @endif
    </div>
</div>
