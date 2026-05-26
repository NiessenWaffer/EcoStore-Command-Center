<x-layouts.admin>
    <div class="mb-12">
        <h2 class="text-4xl font-black uppercase tracking-tighter text-stone-900">Global Hub Strategy</h2>
        <p class="text-stone-500 mt-2">Manage and monitor the worldwide decentralized fulfillment network.</p>
    </div>

    <livewire:hubs.global-map />

    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
            <h4 class="text-sm font-black uppercase tracking-widest text-stone-900 mb-4">Network Coverage</h4>
            <p class="text-4xl font-black text-emerald-600">84%</p>
            <p class="text-xs text-stone-400 mt-2">Global orders within 500km of a Hub.</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
            <h4 class="text-sm font-black uppercase tracking-widest text-stone-900 mb-4">Air-to-Ocean Ratio</h4>
            <p class="text-4xl font-black text-stone-900">1:9</p>
            <p class="text-xs text-stone-400 mt-2">Optimizing for low-carbon bulk sea freight.</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
            <h4 class="text-sm font-black uppercase tracking-widest text-stone-900 mb-4">Active Trade-Ins</h4>
            <p class="text-4xl font-black text-blue-600">1,240</p>
            <p class="text-xs text-stone-400 mt-2">Items currently in transit to global nodes.</p>
        </div>
    </div>
</x-layouts.admin>
