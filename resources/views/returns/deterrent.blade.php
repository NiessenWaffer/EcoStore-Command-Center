<x-layouts.app>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto">
        <div class="mb-12 text-center">
            <div class="inline-flex items-center space-x-2 bg-stone-100 px-4 py-2 rounded-full mb-6">
                <svg class="w-4 h-4 text-stone-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[10px] font-black uppercase tracking-widest text-stone-500">Environmental Alert</span>
            </div>
            <h1 class="text-4xl font-black uppercase tracking-tighter mb-4">The Real Cost of a Return</h1>
            <p class="text-stone-500">Every return journey adds a measurable carbon footprint to the planet.</p>
        </div>

        <div class="bg-white p-12 rounded-3xl shadow-xl border border-stone-100 relative overflow-hidden">
            <!-- Warning Accent -->
            <div class="absolute top-0 left-0 w-full h-2 bg-stone-900"></div>

            <div class="space-y-12">
                <div class="flex flex-col items-center text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-stone-400 mb-4">Projected Carbon Impact</p>
                    <p class="text-8xl font-black text-stone-900">{{ $carbonCost }}<span class="text-2xl ml-2">kg CO2</span></p>
                    <p class="text-stone-500 mt-6 max-w-md leading-relaxed">
                        This return journey is equivalent to charging your smartphone **{{ round($carbonCost * 120) }} times** or driving a conventional car for **{{ round($carbonCost * 2.5) }} miles**.
                    </p>
                </div>

                <div class="bg-stone-50 p-8 rounded-2xl border border-stone-100">
                    <h4 class="text-xs font-black uppercase tracking-widest text-stone-400 mb-6 text-center">Items requested for return</h4>
                    <div class="space-y-4">
                        @foreach($items as $item)
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-stone-900">{{ $item->product->name }} ({{ $item->variant->size }} / {{ $item->variant->color }})</span>
                            <span class="text-stone-400 font-mono text-xs">ID: #{{ $item->id }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- High Friction Path -->
                    <form action="{{ route('return.store') }}" method="POST" class="order-2 md:order-1">
                        @csrf
                        @foreach($itemIds as $id)
                            <input type="hidden" name="items[]" value="{{ $id }}">
                        @endforeach
                        <button type="submit" class="w-full py-4 rounded-xl text-stone-400 text-xs font-bold uppercase tracking-widest hover:text-stone-900 transition">
                            Proceed with Return anyway
                        </button>
                    </form>

                    <!-- Low Friction / Mission Path -->
                    <div class="order-1 md:order-2">
                        <a href="{{ route('fit.wizard') }}" class="block w-full bg-black text-white py-6 rounded-xl font-black text-center uppercase tracking-widest shadow-xl hover:bg-stone-800 transition transform hover:scale-[1.02]">
                            Keep & Update Fit AI
                        </a>
                        <p class="text-[10px] text-stone-400 text-center mt-4 font-bold uppercase tracking-widest">Updating your profile prevents future waste.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
