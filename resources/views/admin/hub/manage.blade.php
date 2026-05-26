<x-layouts.admin>
<div class="p-8">
    <div class="flex justify-between items-center mb-12">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tighter">Hub Manager: {{ $hub->name }}</h1>
            <p class="text-stone-500 mt-1">{{ $hub->address }}, {{ $hub->city }}</p>
        </div>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest">
            Hub Online
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Verification Queue -->
        <div class="bg-white rounded-3xl border border-stone-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-stone-50">
                <h3 class="text-lg font-bold">Verification Queue</h3>
                <p class="text-stone-400 text-sm">Local trade-in drop-offs awaiting inspection.</p>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <thead class="bg-stone-50 text-[10px] font-black uppercase tracking-widest text-stone-400">
                        <tr>
                            <th class="px-8 py-4">Item</th>
                            <th class="px-8 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                        @foreach($pendingTradeIns as $tradeIn)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-8 py-6">
                                <p class="font-bold text-sm text-stone-900">{{ $tradeIn->product->name }}</p>
                                <p class="text-xs text-stone-400">Condition: {{ $tradeIn->condition }}</p>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('admin.hub.verify', $tradeIn->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-stone-800 transition">
                                        Verify & Credit
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Rebalancing -->
        <div class="bg-stone-900 text-white rounded-3xl p-8 shadow-2xl">
            <h3 class="text-lg font-bold mb-6">Inventory Rebalancing</h3>
            <div class="space-y-8">
                <div class="p-6 bg-white/5 rounded-2xl border border-white/10">
                    <p class="text-xs font-bold uppercase tracking-widest text-stone-500 mb-2">High Demand Prediction</p>
                    <p class="text-sm font-bold">Earth First Tee (Size M/Stone)</p>
                    <p class="text-xs text-stone-400 mt-2">AI suggests moving 10 units to this hub to prevent 150km of transit carbon.</p>
                </div>
                <button class="w-full bg-white text-black py-4 rounded-xl font-bold text-sm">Approve Stock Transfer</button>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin>
