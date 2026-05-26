<?php

use Livewire\Volt\Component;
use App\Services\CartService;
use Livewire\Attributes\On;

new class extends Component
{
    public bool $isOpen = false;

    #[On('cart-updated')]
    public function refresh()
    {
        // Re-render
    }

    #[On('open-cart')]
    public function open()
    {
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function removeItem(int $variantId)
    {
        app(CartService::class)->remove($variantId);
        $this->dispatch('cart-updated');
    }

    public function updateQuantity(string $cartKey, int $quantity)
    {
        app(CartService::class)->updateQuantity($cartKey, $quantity);
        $this->dispatch('cart-updated');
    }

    public function with()
    {
        $cartService = app(CartService::class);
        return [
            'items' => $cartService->getCart(),
            'totals' => $cartService->getTotals(),
        ];
    }
};
?>

<div 
    x-data="{ open: false }"
    x-show="open"
    class="fixed inset-0 z-[100] overflow-hidden"
    style="display: none;"
    x-on:keydown.escape.window="open = false"
    x-on:open-cart.window="open = true"
>
    <!-- Overlay -->
        <div 
        x-show="open"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-stone-900/40 transition-opacity"
        @click="open = false"
    ></div>

    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div 
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-md"
        >
            <div class="flex h-full flex-col bg-white shadow-2xl">
                <div class="flex-1 overflow-y-auto px-6 py-8">
                    <div class="flex items-start justify-between mb-10">
                        <h2 class="text-xl font-black uppercase tracking-tighter text-stone-900">Your Bag</h2>
                        <button type="button" class="text-stone-400 hover:text-stone-900 transition" @click="open = false">
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Impact Summary Banner -->
                    <div class="bg-stone-900 text-white p-6 rounded-sm mb-10">
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-4">Cumulative Order Impact</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-2xl font-black">{{ $totals['total_water'] }}L</div>
                                <div class="text-[8px] uppercase font-bold text-stone-500">Water Saved</div>
                            </div>
                            <div>
                                <div class="text-2xl font-black">{{ $totals['total_carbon'] }}kg</div>
                                <div class="text-[8px] uppercase font-bold text-stone-500">CO2 Reduced</div>
                            </div>
                        </div>
                    </div>

                    <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-stone-100">
                            @forelse($items as $cartKey => $item)
                                <li class="flex py-6">
                                    <div class="h-24 w-20 flex-shrink-0 overflow-hidden rounded-sm bg-stone-100 border border-stone-200">
                                        @if($item['image_url'])
                                            <img src="{{ $item['image_url'] }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-stone-200 to-stone-300 opacity-30"></div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-sm font-bold text-stone-900 uppercase tracking-tight">
                                                <h3>{{ $item['name'] }} @if(($item['purchase_mode'] ?? 'buy') === 'lease') <span class="text-[10px] bg-stone-900 text-white px-2 py-0.5 rounded-sm ml-2">Lease</span> @endif</h3>
                                                <p class="ml-4">${{ number_format($item['price_cents'] / 100, 2) }}@if(($item['purchase_mode'] ?? 'buy') === 'lease')/mo @endif</p>
                                            </div>
                                            <p class="mt-1 text-[10px] font-bold text-stone-400 uppercase tracking-widest">{{ $item['size'] }} / {{ $item['color'] }}</p>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm">
                                            <div class="flex items-center space-x-3 border border-stone-200 px-2 py-1 rounded-sm">
                                                <button wire:click="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] - 1 }})" class="text-stone-400 hover:text-stone-900">&minus;</button>
                                                <span class="text-xs font-bold w-4 text-center">{{ $item['quantity'] }}</span>
                                                <button wire:click="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] + 1 }})" class="text-stone-400 hover:text-stone-900">&plus;</button>
                                            </div>

                                            <div class="flex">
                                                <button wire:click="removeItem('{{ $cartKey }}')" class="text-[10px] font-black uppercase text-stone-400 hover:text-red-600 transition">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="py-20 text-center">
                                    <p class="text-stone-400 font-bold uppercase tracking-widest text-xs mb-8">Your bag is empty.</p>
                                    <a href="{{ route('shop') }}" @click="open = false" class="bg-stone-900 text-white px-8 py-3 rounded-sm text-xs font-black uppercase tracking-widest">Start Shopping</a>
                                </div>
                            @endforelse
                        </ul>
                    </div>
                </div>

                @if(count($items) > 0)
                    <div class="border-t border-stone-100 px-6 py-8 bg-stone-50">
                        <div class="flex justify-between text-sm font-bold text-stone-900 uppercase tracking-tight mb-6">
                            <p>Subtotal</p>
                            <p>${{ number_format($totals['total_cents'] / 100, 2) }}</p>
                        </div>
                        <p class="mt-0.5 text-[10px] text-stone-500 mb-8 italic">Shipping (Carbon-Neutral) calculated at checkout.</p>
                        <div class="mt-6">
                            <a href="{{ route('checkout.index') }}" class="flex items-center justify-center rounded-sm bg-stone-900 px-6 py-4 text-sm font-black uppercase tracking-[0.2em] text-white shadow-xl hover:bg-stone-800 transition">
                                Checkout
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
