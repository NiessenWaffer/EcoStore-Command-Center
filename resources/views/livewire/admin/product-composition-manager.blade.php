<?php

use Livewire\Volt\Component;
use App\Models\SustainabilityMetric;
use App\Services\SustainabilityImpactService;

new class extends Component
{
    public $rows = [['material' => '', 'percent' => 100]];
    public $weight = 0.5; // Default weight for preview
    public $impact = ['water_saved' => 0, 'carbon_reduced' => 0, 'grade' => 'E'];

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
        $this->calculate();
    }

    public function calculate()
    {
        $service = app(SustainabilityImpactService::class);
        
        $water = 0;
        $carbon = 0;

        foreach ($this->rows as $row) {
            if (empty($row['material']) || empty($row['percent'])) continue;
            
            $metric = SustainabilityMetric::where('material_type', $row['material'])->first();
            if ($metric) {
                $multiplier = ($row['percent'] / 100) * $this->weight;
                $water += $multiplier * $metric->water_per_kg;
                $carbon += $multiplier * $metric->carbon_per_kg;
            }
        }

        $composition = [];
        foreach ($this->rows as $row) {
            if (!empty($row['material']) && !empty($row['percent'])) {
                $composition[$row['material']] = $row['percent'];
            }
        }

        $this->impact = $service->calculateVariantImpact(new \App\Models\ProductVariant([
            'physical_weight_kg' => $this->weight,
            'product' => new \App\Models\Product(['material_composition' => $composition])
        ]));
    }

    public function with()
    {
        return [
            'availableMaterials' => SustainabilityMetric::pluck('material_type'),
        ];
    }
};
?>

<div class="bg-stone-100 p-6 rounded-lg border border-stone-200">
    <h3 class="text-sm font-bold uppercase tracking-wider text-stone-500 mb-4">Sustainability Real-Time Preview</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-stone-700">Preview Weight (kg)</label>
                <input type="number" step="0.01" wire:model.live="weight" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                <p class="text-xs text-stone-400 mt-1">Simulate impact for a specific variant weight.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-700 mb-2">Material Composition (%)</label>
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
                <button type="button" wire:click="addRow" class="text-sm text-stone-600 hover:text-stone-900">+ Add Material</button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg border border-stone-200 flex flex-col justify-center items-center text-center">
            <div class="text-5xl font-black mb-2 text-emerald-600">
                {{ $impact['impact_index'] ?? 0 }}
            </div>
            <div class="text-[10px] uppercase tracking-[0.2em] text-stone-400 font-black mb-4">Impact Index</div>
            
            <div class="bg-stone-900 text-white px-4 py-2 rounded-xl inline-block">
                <span class="text-[10px] font-black uppercase tracking-widest">{{ $impact['tier_label'] ?? 'Calculating...' }}</span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 w-full border-t border-stone-100 pt-4">
                <div>
                    <div class="text-lg font-bold text-stone-800">{{ $impact['water_saved'] }}L</div>
                    <div class="text-[10px] uppercase text-stone-400">Water Saved</div>
                </div>
                <div>
                    <div class="text-lg font-bold text-stone-800">{{ $impact['carbon_reduced'] }}kg</div>
                    <div class="text-[10px] uppercase text-stone-400">CO2 Reduced</div>
                </div>
            </div>
        </div>
    </div>
</div>
