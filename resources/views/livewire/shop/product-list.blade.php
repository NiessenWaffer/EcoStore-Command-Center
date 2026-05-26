<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

new class extends Component
{
    use WithPagination;

    public $selectedCategory = '';
    public $selectedGrade = '';
    public $search = '';

    protected $queryString = ['selectedCategory', 'selectedGrade', 'search'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingSelectedCategory() { $this->resetPage(); }
    public function updatingSelectedGrade() { $this->resetPage(); }

    public function with()
    {
        $query = Product::query()
            ->with('category')
            ->where('is_published', true);

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedGrade) {
            // Simplified mapping for MVP: Grade A = score 10, B = 8, others = 5
            $minScore = match($this->selectedGrade) {
                'A' => 10,
                'B' => 8,
                'C' => 5,
                default => 0
            };
            $query->where('sustainability_score', '>=', $minScore);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Mission-aligned boosting: Grade A products first
        $products = $query->orderByDesc('sustainability_score')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return [
            'products' => $products,
            'categories' => Category::all(),
        ];
    }

    public function quickAdd($productId)
    {
        $product = \App\Models\Product::with('variants')->findOrFail($productId);
        $variant = $product->variants->first();

        if ($variant) {
            app(\App\Services\CartService::class)->add($variant->id);
            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');
        }
    }
};
?>

<div class="container mx-auto px-4 py-8 md:py-12" x-data="{ mobileFiltersOpen: false }">
    <!-- Mobile Header Actions -->
    <div class="md:hidden flex justify-between items-center mb-8 bg-white p-4 rounded-2xl border border-stone-100 shadow-sm sticky top-20 z-40">
        <button @click="mobileFiltersOpen = true" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-stone-900">
            <x-lucide-list-filter class="w-4 h-4" />
            Filter & Sort
        </button>
        <div class="h-4 w-px bg-stone-200"></div>
        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">
            {{ $products->total() }} Items
        </p>
    </div>

    <div class="flex flex-col md:flex-row gap-12">
        <!-- Sidebar Filters (Desktop) -->
        <aside class="hidden md:block w-full md:w-64 space-y-10 shrink-0">
            <div>
                <h3 class="text-xs font-black uppercase tracking-widest text-stone-400 mb-6">Categories</h3>
                <div class="space-y-3">
                    <label class="flex items-center group cursor-pointer">
                        <input type="radio" wire:model.live="selectedCategory" value="" class="hidden">
                        <span class="text-sm font-bold @if($selectedCategory === '') text-stone-900 @else text-stone-400 @endif group-hover:text-stone-900 transition">All Items</span>
                    </label>
                    @foreach($categories as $category)
                        <label class="flex items-center group cursor-pointer">
                            <input type="radio" wire:model.live="selectedCategory" value="{{ $category->id }}" class="hidden">
                            <span class="text-sm font-bold @if($selectedCategory == $category->id) text-stone-900 @else text-stone-400 @endif group-hover:text-stone-900 transition">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-xs font-black uppercase tracking-widest text-stone-400 mb-6">Impact Tier</h3>
                <div class="space-y-3">
                    @foreach(['Regenerative' => 90, 'Circular Prime' => 70, 'Standard' => 50] as $label => $min)
                        <label class="flex items-center group cursor-pointer">
                            <input type="radio" wire:model.live="selectedGrade" value="{{ $label }}" class="hidden">
                            <div class="flex items-center space-x-3">
                                <span class="h-5 w-5 flex items-center justify-center rounded-full border border-stone-200 group-hover:border-stone-900 transition @if($selectedGrade === $label) bg-stone-900 border-stone-900 @endif">
                                    @if($selectedGrade === $label) <x-lucide-check class="w-3 h-3 text-white" /> @endif
                                </span>
                                <span class="text-sm font-bold @if($selectedGrade === $label) text-stone-900 @else text-stone-400 @endif group-hover:text-stone-900 transition">
                                    {{ $label }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Mobile Filter Drawer -->
        <div x-show="mobileFiltersOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="fixed inset-0 z-[100] bg-white flex flex-col md:hidden"
             style="display: none;">
            
            <div class="p-6 border-b border-stone-100 flex justify-between items-center bg-white sticky top-0 z-10">
                <span class="text-xl font-black uppercase tracking-tighter">Filter & Sort</span>
                <button @click="mobileFiltersOpen = false" class="p-2 bg-stone-100 rounded-full text-stone-900">
                    <x-lucide-x class="h-5 w-5" />
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-8 space-y-12">
                <!-- Mobile Search -->
                <div class="space-y-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Search</p>
                    <input wire:model.live="search" type="text" placeholder="Search catalog..." class="w-full bg-stone-50 border border-stone-100 rounded-xl px-4 py-4 text-sm focus:ring-black">
                </div>

                <!-- Mobile Categories -->
                <div class="space-y-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Collections</p>
                    <div class="grid grid-cols-2 gap-3">
                        <button wire:click="$set('selectedCategory', '')" @click="mobileFiltersOpen = false" class="p-4 rounded-xl border text-xs font-bold uppercase tracking-widest text-center transition {{ $selectedCategory === '' ? 'bg-black text-white border-black shadow-lg' : 'bg-stone-50 text-stone-500 border-stone-100' }}">All</button>
                        @foreach($categories as $category)
                            <button wire:click="$set('selectedCategory', {{ $category->id }})" @click="mobileFiltersOpen = false" class="p-4 rounded-xl border text-xs font-bold uppercase tracking-widest text-center transition {{ $selectedCategory == $category->id ? 'bg-black text-white border-black shadow-lg' : 'bg-stone-50 text-stone-500 border-stone-100' }}">{{ $category->name }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile Tiers -->
                <div class="space-y-6 pb-12">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Impact Tiers</p>
                    <div class="space-y-4">
                        @foreach(['Regenerative' => 90, 'Circular Prime' => 70, 'Standard' => 50] as $label => $min)
                            <button wire:click="$set('selectedGrade', '{{ $label }}')" @click="mobileFiltersOpen = false" class="w-full flex items-center justify-between p-5 rounded-2xl border transition {{ $selectedGrade === $label ? 'bg-emerald-50 border-emerald-500 text-emerald-900 shadow-sm' : 'bg-stone-50 border-stone-100 text-stone-600' }}">
                                <span class="font-bold text-sm uppercase tracking-tight">{{ $label }}</span>
                                @if($selectedGrade === $label) <x-lucide-check class="w-4 h-4" /> @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="p-8 border-t border-stone-100 bg-white">
                <button @click="mobileFiltersOpen = false" class="w-full bg-black text-white py-5 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl">
                    Show {{ $products->total() }} Results
                </button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="flex-grow">
            @if($products->isEmpty())
                <div class="bg-white p-20 rounded-3xl border border-stone-100 text-center">
                    <x-lucide-search class="w-12 h-12 text-stone-200 mx-auto mb-6" />
                    <h3 class="text-2xl font-bold text-stone-900 mb-4">No products found</h3>
                    <p class="text-stone-500">Try adjusting your filters or search query.</p>
                </div>
            @else
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-8 md:gap-x-8 md:gap-y-16">
                    @foreach($products as $product)
                    <a href="{{ route('product.show', $product->slug) }}" class="group block space-y-4">
                        <div class="aspect-[3/4] bg-stone-100 rounded-sm md:rounded-xl overflow-hidden relative shadow-sm hover:shadow-xl transition-all duration-500">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-100 to-stone-300 p-8 text-center">
                                    <span class="text-stone-400 font-black uppercase tracking-tighter text-xl mix-blend-multiply opacity-40">{{ $product->name }}</span>
                                </div>
                            @endif

                            <!-- Quick Add Overlay (Desktop) -->
                            <div class="hidden md:flex absolute inset-0 bg-stone-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 items-center justify-center p-6">
                                <button wire:click.prevent="quickAdd({{ $product->id }})" class="w-full bg-white text-black py-4 rounded-sm font-black uppercase tracking-widest text-xs shadow-2xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 hover:bg-stone-100">
                                    Quick Add +
                                </button>
                            </div>

                            <!-- Quick Add "+" (Mobile) -->
                            <div class="md:hidden absolute bottom-3 right-3 z-20">
                                <button wire:click.prevent="quickAdd({{ $product->id }})" class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-lg border border-stone-100 active:scale-90 transition-transform">
                                    <x-lucide-plus class="w-4 h-4 text-stone-900" />
                                </button>
                            </div>
                            
                            <!-- Impact Index Badge -->
                            <div class="absolute top-3 right-3 md:top-4 md:right-4">
                                @php
                                    $impactData = app(App\Services\SustainabilityImpactService::class)->calculateVariantImpact($product->variants->first());
                                    $index = $impactData['impact_index'];
                                @endphp
                                <div class="bg-white/90 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-full shadow-lg border border-stone-100 flex items-center gap-1.5">
                                    <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-emerald-500 rounded-full"></div>
                                    <span class="text-[8px] md:text-[10px] font-black tracking-tighter text-stone-900">{{ $index }} INDEX</span>
                                </div>
                            </div>

                            @if($product->is_preorder)
                                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4">
                                    <span class="bg-stone-900 text-white text-[8px] md:text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded shadow-lg">Pre-Order</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col flex-grow justify-between space-y-2 px-1">
                            <div class="flex flex-col space-y-1.5">
                                <div class="flex justify-between items-start gap-3">
                                    <h4 class="text-sm md:text-base font-bold text-stone-900 uppercase tracking-tight leading-tight line-clamp-2 flex-1">{{ $product->name }}</h4>
                                    <span class="text-sm md:text-base font-medium text-stone-500 mt-0.5">${{ number_format($product->price_cents / 100, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-[9px] md:text-[10px] font-bold text-stone-400 uppercase tracking-widest">{{ $product->category->name }}</p>
                                    <p class="text-[9px] md:text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded-sm">Saves {{ number_format($product->variants->first()->physical_weight_kg * 2700) }}L</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-20">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
