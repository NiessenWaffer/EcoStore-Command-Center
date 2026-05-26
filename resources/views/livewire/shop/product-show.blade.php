<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Services\SustainabilityImpactService;

new class extends Component
{
    public Product $product;
    public $selectedVariantId = null;
    public $purchaseMode = 'buy';
    public $impact = ['water_saved' => 0, 'carbon_reduced' => 0, 'grade' => 'E'];
    public $equivalencies = [];

    public function mount(Product $product)
    {
        $this->product = $product->load('variants', 'category');
        if ($this->product->variants->count() > 0) {
            $this->selectedVariantId = $this->product->variants->first()->id;
            $this->calculate();
        }
    }

    public function updatedSelectedVariantId()
    {
        $this->calculate();
    }

    public function calculate()
    {
        $service = app(SustainabilityImpactService::class);
        $variant = $this->product->variants->where('id', $this->selectedVariantId)->first();

        if ($variant) {
            $this->impact = $service->calculateVariantImpact($variant);
            $this->equivalencies = $service->getEquivalencies($this->impact['water_saved'], $this->impact['carbon_reduced']);
        }
    }

    public function addToCart()
    {
        if (!$this->selectedVariantId) return;

        app(App\Services\CartService::class)->add($this->selectedVariantId, 1, $this->purchaseMode);

        $this->dispatch('cart-updated');
        $this->dispatch('open-cart');
    }
};
?>

<div class="container mx-auto px-4 py-8 md:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
        <!-- Product Image Section -->
        <div class="space-y-4">
            <div class="aspect-[4/5] bg-stone-100 rounded-2xl md:rounded-sm overflow-hidden relative">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center p-12 text-center" style="background: linear-gradient(135deg, #F5F5F0 0%, #ccb9aa 100%);">
                        <span class="text-stone-400 font-black uppercase tracking-tighter text-3xl md:text-5xl mix-blend-multiply opacity-30">{{ $product->name }}</span>
                    </div>
                @endif

                <!-- Impact Index Gauge -->
                <div class="absolute -top-4 -right-2 md:-top-10 md:-right-4 z-10 scale-75 md:scale-100">
                    <div class="relative h-32 w-32 flex items-center justify-center rounded-full bg-white shadow-2xl border border-stone-100 p-2">
                        <!-- Progress Ring -->
                        <svg class="absolute inset-0 w-full h-full -rotate-90">
                            <circle class="text-stone-100" stroke-width="4" stroke="currentColor" fill="transparent" r="58" cx="64" cy="64" />
                            <circle class="text-emerald-500 transition-all duration-1000" stroke-width="4" stroke-dasharray="364.4" stroke-dashoffset="{{ 364.4 - (364.4 * ($impact['impact_index'] ?? 0) / 100) }}" stroke-linecap="round" stroke="currentColor" fill="transparent" r="58" cx="64" cy="64" />
                        </svg>

                        <div class="text-center relative z-10">
                            <span class="text-4xl font-black text-stone-900 tracking-tighter leading-none block">{{ $impact['impact_index'] ?? 0 }}</span>
                            <span class="text-[8px] uppercase tracking-widest font-black text-emerald-600">Impact Index</span>
                        </div>
                    </div>

                    <div class="mt-4 bg-black text-white px-4 py-1.5 rounded-full shadow-lg border border-white/10 text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest leading-none">{{ $impact['tier_label'] ?? 'Calculating...' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Info Section -->
        <div class="flex flex-col">
            <div class="mb-8 md:mb-10 pb-8 border-b border-stone-200">
                <p class="text-[9px] md:text-[10px] font-bold text-stone-400 uppercase tracking-[0.2em] mb-4">{{ $product->category->name }}</p>
                <h1 class="text-3xl md:text-4xl font-black text-stone-900 uppercase tracking-tight mb-4 leading-none">{{ $product->name }}</h1>
                <p class="text-xl font-medium text-stone-500 mb-8">${{ number_format($product->price_cents / 100, 2) }}</p>
                
                <div class="prose prose-stone text-stone-600 leading-relaxed max-w-none text-sm md:text-base">
                    {{ $product->description }}
                </div>
            </div>

            <!-- Variant Selector -->
            <div class="mb-8 md:mb-10">
                <h3 class="text-xs font-black uppercase tracking-widest text-stone-400 mb-6">Select Size / Color</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($product->variants as $variant)
                        <label class="relative">
                            <input type="radio" wire:model.live="selectedVariantId" value="{{ $variant->id }}" class="hidden peer">
                            <div class="border border-stone-200 py-4 md:py-3 text-center rounded-xl md:rounded-sm text-xs md:text-sm font-bold cursor-pointer peer-checked:bg-stone-900 peer-checked:text-white peer-checked:border-stone-900 active:scale-95 transition-all">
                                {{ $variant->size }} / {{ $variant->color }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Purchase Mode Selector -->
            <div class="mb-8 md:mb-10 bg-stone-50 p-1.5 rounded-lg flex gap-1 border border-stone-200">
                <button wire:click="$set('purchaseMode', 'buy')" class="flex-1 py-3 text-sm font-black uppercase tracking-widest rounded-md transition-all {{ $purchaseMode === 'buy' ? 'bg-white shadow-sm text-stone-900' : 'text-stone-400 hover:text-stone-600' }}">
                    Buy New
                </button>
                <button wire:click="$set('purchaseMode', 'lease')" class="flex-1 py-3 text-sm font-black uppercase tracking-widest rounded-md transition-all {{ $purchaseMode === 'lease' ? 'bg-stone-900 text-white shadow-sm' : 'text-stone-400 hover:text-stone-600' }}">
                    Lease Monthly
                </button>
            </div>

            <!-- Sustainability Dashboard -->
            <div class="bg-stone-50 md:bg-stone-100 p-6 md:p-8 rounded-3xl md:rounded-sm mb-10">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-[10px] md:text-xs font-black uppercase tracking-widest text-stone-900">Environmental Impact</h3>
                    <livewire:shop.methodology-modal :impact="$impact" :wire:key="'methodology-'.$selectedVariantId" />
                </div>

                <div class="grid grid-cols-2 gap-8 md:gap-12 mb-10">
                    <div class="space-y-1">
                        <div class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">{{ $impact['water_saved'] }}L</div>
                        <div class="text-[9px] md:text-[10px] font-bold text-stone-400 uppercase tracking-widest">Water Saved</div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">{{ $impact['carbon_reduced'] }}kg</div>
                        <div class="text-[9px] md:text-[10px] font-bold text-stone-400 uppercase tracking-widest">Carbon Reduced</div>
                    </div>
                </div>

                <!-- Real-World Equivalencies -->
                <div class="space-y-4 pt-8 border-t border-stone-200/60">
                    <div class="flex items-center space-x-4">
                        <div class="h-8 w-8 bg-white shadow-sm border border-stone-100 flex items-center justify-center rounded-full">
                            <x-lucide-droplets class="h-4 w-4 text-blue-500" />
                        </div>
                        <p class="text-xs md:text-sm text-stone-600">Saves enough water for <span class="font-black text-stone-900">{{ $equivalencies['showers'] ?? 0 }} full showers</span>.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="h-8 w-8 bg-white shadow-sm border border-stone-100 flex items-center justify-center rounded-full">
                            <x-lucide-wind class="h-4 w-4 text-stone-400" />
                        </div>
                        <p class="text-xs md:text-sm text-stone-600">Avoids CO2 equivalent to driving <span class="font-black text-stone-900">{{ $equivalencies['miles_driven'] ?? 0 }} miles</span>.</p>
                    </div>
                </div>
            </div>

            <!-- Desktop Action Buttons -->
            <div class="hidden md:block space-y-4">
                <button wire:click="addToCart" class="w-full bg-stone-900 text-white py-5 rounded-sm font-black uppercase tracking-[0.2em] hover:bg-stone-800 transition shadow-xl">
                    @if($purchaseMode === 'lease')
                        Lease for ${{ number_format(($product->price_cents * 0.10) / 100, 2) }} / mo
                    @else
                        Add to Bag &bull; ${{ number_format($product->price_cents / 100, 2) }}
                    @endif
                </button>
                @if (session()->has('cart_message'))
                    <p class="text-center text-xs font-bold text-green-600 uppercase tracking-widest mt-2">{{ session('cart_message') }}</p>
                @endif
            </div>

            <!-- Mobile Sticky CTA -->
            <div class="md:hidden fixed bottom-0 left-0 right-0 p-4 bg-white/90 backdrop-blur-md border-t border-stone-100 z-50 animate-slide-up">
                <button wire:click="addToCart" class="w-full bg-stone-900 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-2xl active:scale-95 transition-transform flex items-center justify-center gap-3">
                    <x-lucide-shopping-bag class="w-4 h-4" />
                    Add to Bag &bull; ${{ number_format($product->price_cents / 100, 2) }}
                </button>
                @if (session()->has('cart_message'))
                    <p class="text-center text-[10px] font-bold text-green-600 uppercase tracking-widest mt-2">{{ session('cart_message') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
