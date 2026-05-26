<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\SustainabilityMetric;
use App\Services\SustainabilityImpactService;
use Illuminate\Support\Str;

new class extends Component
{
    public $name = '';
    public $slug = '';
    public $description = '';
    public $price_cents = 0;
    public $category_id = '';
    public $is_published = false;
    public $is_preorder = false;
    public $image_url = '';

    public $rows = [['material' => '', 'percent' => 100]];
    public $previewWeight = 0.5;
    public $impact = ['water_saved' => 0, 'carbon_reduced' => 0, 'impact_index' => 0, 'tier_label' => 'Calculating...'];

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function addRow()
    {
        $this->rows[] = ['material' => '', 'percent' => 0];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
        $this->calculate();
    }

    public function updated($property)
    {
        if (Str::contains($property, ['rows', 'previewWeight'])) {
            $this->calculate();
        }
    }

    public function calculate()
    {
        $service = app(SustainabilityImpactService::class);
        
        $composition = [];
        foreach ($this->rows as $row) {
            if (!empty($row['material']) && !empty($row['percent'])) {
                $composition[$row['material']] = $row['percent'];
            }
        }

        $this->impact = $service->calculateVariantImpact(new \App\Models\ProductVariant([
            'physical_weight_kg' => $this->previewWeight,
            'product' => new \App\Models\Product(['material_composition' => $composition])
        ]));
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug',
            'description' => 'required',
            'price_cents' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'rows.*.material' => 'required|exists:sustainability_metrics,material_type',
            'rows.*.percent' => 'required|numeric|min:0|max:100',
        ]);

        $product = Product::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price_cents' => $this->price_cents,
            'category_id' => $this->category_id,
            'is_published' => $this->is_published,
            'is_preorder' => $this->is_preorder,
            'image_url' => $this->image_url,
            'material_composition' => $this->rows,
            'sustainability_score' => (int) ($this->impact['impact_index'] / 10), // Use impact index for normalized score
        ]);

        session()->flash('message', 'Product created successfully.');
        return redirect()->route('admin.products');
    }

    public function with()
    {
        return [
            'categories' => Category::all(),
            'availableMaterials' => SustainabilityMetric::pluck('material_type'),
        ];
    }
};
?>

<div class="max-w-6xl mx-auto">
    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-stone-200 space-y-4">
                <h2 class="font-bold text-stone-800 uppercase tracking-wider text-sm">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Product Name</label>
                        <input type="text" wire:model.live="name" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Slug</label>
                        <input type="text" wire:model="slug" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500 bg-stone-50">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Description</label>
                    <textarea wire:model="description" rows="4" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500"></textarea>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-stone-200">
                <h2 class="font-bold text-stone-800 uppercase tracking-wider text-sm mb-4">Sustainability & Material Composition</h2>
                
                <div class="bg-stone-50 p-6 rounded-lg border border-stone-100 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-2">Composition (%)</label>
                            @foreach($rows as $index => $row)
                                <div class="flex items-center space-x-2 mb-2">
                                    <select wire:model.live="rows.{{ $index }}.material" class="block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                                        <option value="">Select Material</option>
                                        @foreach($availableMaterials as $material)
                                            <option value="{{ $material }}">{{ $material }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" wire:model.live="rows.{{ $index }}.percent" placeholder="%" class="w-24 rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                                    <button type="button" wire:click="removeRow({{ $index }})" class="text-red-500 hover:text-red-700">&times;</button>
                                </div>
                            @endforeach
                            <button type="button" wire:click="addRow" class="text-sm text-stone-600 hover:text-stone-900 font-bold">+ Add Material</button>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-stone-200 text-center flex flex-col justify-center">
                            <div class="text-[10px] uppercase tracking-widest text-stone-400 font-black mb-1">Impact Index</div>
                            <div class="text-4xl font-black mb-2 text-emerald-600">
                                {{ $impact['impact_index'] ?? 0 }}
                            </div>
                            <div class="mb-4">
                                <span class="bg-stone-900 text-white px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest">
                                    {{ $impact['tier_label'] ?? 'Calculating...' }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-[10px] uppercase font-bold text-stone-500">
                                <div><span class="text-stone-900 block">{{ $impact['water_saved'] }}L</span> Water</div>
                                <div><span class="text-stone-900 block">{{ $impact['carbon_reduced'] }}kg</span> CO2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-stone-200 space-y-4">
                <h2 class="font-bold text-stone-800 uppercase tracking-wider text-sm">Pricing & Category</h2>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Category</label>
                    <select wire:model="category_id" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Price (Cents)</label>
                    <input type="number" wire:model="price_cents" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-stone-200 space-y-4">
                <h2 class="font-bold text-stone-800 uppercase tracking-wider text-sm">Status</h2>
                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_published" class="h-4 w-4 text-stone-600 focus:ring-stone-500 border-stone-300 rounded">
                    <label class="ml-2 block text-sm text-stone-900 font-medium">Published</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_preorder" class="h-4 w-4 text-stone-600 focus:ring-stone-500 border-stone-300 rounded">
                    <label class="ml-2 block text-sm text-stone-900 font-medium">Pre-Order Only</label>
                </div>
                <button type="submit" class="w-full bg-stone-900 text-white px-4 py-3 rounded-md font-bold hover:bg-stone-800 transition">Save Product</button>
            </div>
        </div>
    </form>
</div>
