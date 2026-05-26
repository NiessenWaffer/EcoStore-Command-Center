<x-layouts.admin>
    <div class="space-y-12">
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tighter text-stone-900">Local Hub <span class="text-stone-500">Network</span></h1>
                <p class="text-stone-500 mt-2">Manage decentralized fulfillment and verification centers.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($hubs as $hub)
                <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-stone-100 rounded-2xl group-hover:bg-black group-hover:text-white transition-colors">
                            <x-lucide-truck class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="font-bold text-stone-900">{{ $hub->name }}</h3>
                            <p class="text-xs text-stone-400 font-medium">{{ $hub->city }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-xs font-bold uppercase tracking-widest">
                            <span class="text-stone-400">Naked Shipping</span>
                            <span class="{{ $hub->supports_naked_shipping ? 'text-green-600' : 'text-stone-300' }}">
                                {{ $hub->supports_naked_shipping ? 'Supported' : 'No' }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('admin.hub.manage', $hub->id) }}" class="block w-full bg-stone-50 text-center py-4 rounded-xl text-[10px] font-black uppercase tracking-widest text-stone-900 hover:bg-black hover:text-white transition-all">
                        Manage Hub Inventory
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.admin>
