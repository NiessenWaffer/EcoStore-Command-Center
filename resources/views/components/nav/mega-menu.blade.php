@props(['label', 'items'])

<div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative group">
    <button class="flex items-center gap-1.5 hover:text-stone-900 transition-colors py-2">
        {{ $label }}
        <x-lucide-chevron-down class="w-3.5 h-3.5 transition-transform duration-300" x-bind:class="open ? 'rotate-180' : ''" />
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1"
         class="absolute left-0 mt-1 w-64 bg-white rounded-2xl shadow-2xl border border-stone-100 p-2 z-50 overflow-hidden"
         style="display: none;">
        
        <div class="grid grid-cols-1 gap-1">
            @foreach($items as $item)
                <a href="{{ $item['url'] }}" class="flex items-start gap-4 p-4 rounded-xl hover:bg-stone-50 transition-all group/item">
                    <div class="p-2 bg-stone-100 rounded-lg group-hover/item:bg-white transition-colors">
                        <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-4 h-4 text-stone-600" />
                    </div>
                    <div>
                        <p class="text-xs font-bold text-stone-900 tracking-tight">{{ $item['title'] }}</p>
                        <p class="text-[10px] text-stone-400 leading-tight mt-0.5">{{ $item['description'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Callout Section (Optional) -->
        <div class="mt-2 p-4 bg-stone-900 rounded-xl text-white">
            <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-1">Our Commitment</p>
            <p class="text-[10px] leading-tight text-stone-300">100% verified impact across every island of our platform.</p>
        </div>
    </div>
</div>
