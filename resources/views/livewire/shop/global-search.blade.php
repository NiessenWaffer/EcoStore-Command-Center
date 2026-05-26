<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component
{
    public $search = '';
    public $isOpen = false;

    public function updatedSearch()
    {
        // Search triggered dynamically
    }

    public function with()
    {
        return [
            'results' => $this->search ? Product::where('is_published', true)->where('name', 'like', '%' . $this->search . '%')->take(5)->get() : [],
        ];
    }
};
?>

<div x-data="{ open: false }" 
     x-show="open"
     x-on:open-search.window="open = true" 
     x-on:keydown.escape.window="open = false"
     class="fixed inset-0 z-[110] overflow-y-auto"
     style="display: none;">
    <div class="p-4 sm:p-6 md:p-20" role="dialog" aria-modal="true">
        <!-- Overlay -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-stone-900/40 transition-opacity" 
             @click="open = false"></div>

        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="mx-auto max-w-xl transform divide-y divide-stone-100 overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
            <div class="relative">
                <svg class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-stone-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                <input type="text" wire:model.live="search" class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-stone-900 placeholder:text-stone-400 focus:ring-0 sm:text-sm" placeholder="Search mission-driven apparel..." autofocus>
            </div>

            @if($search)
            <ul class="max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-stone-800">
                @forelse($results as $product)
                <li class="cursor-default select-none px-4 py-2 hover:bg-stone-50">
                    <a href="{{ route('product.show', $product->slug) }}" class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0 bg-stone-100 rounded-lg overflow-hidden mr-4">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" class="h-full w-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-stone-200 to-stone-300 opacity-40"></div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <p class="font-bold">{{ $product->name }}</p>
                            <p class="text-[10px] uppercase font-black text-stone-400 tracking-widest">{{ $product->category->name }}</p>
                        </div>
                        <span class="font-black text-stone-900">${{ number_format($product->price_cents / 100, 2) }}</span>
                    </a>
                </li>
                @empty
                <p class="p-4 text-stone-500 text-center font-bold uppercase tracking-widest text-xs">No items match your search.</p>
                @endforelse
            </ul>
            @else
            <div class="px-4 py-14 text-center sm:px-14">
                <svg class="mx-auto h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <p class="mt-4 text-sm text-stone-900 font-bold uppercase tracking-widest">Search our catalog</p>
                <p class="mt-2 text-xs text-stone-500">Find garments that align with your values.</p>
            </div>
            @endif
        </div>
    </div>
</div>
