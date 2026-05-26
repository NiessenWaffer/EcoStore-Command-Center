<?php

use Livewire\Volt\Component;
use App\Models\SustainabilityMetric;

new class extends Component
{
    public $material_type = '';
    public $water_per_kg = '';
    public $carbon_per_kg = '';

    public function save()
    {
        $this->validate([
            'material_type' => 'required|unique:sustainability_metrics,material_type',
            'water_per_kg' => 'required|numeric|min:0',
            'carbon_per_kg' => 'required|numeric|min:0',
        ]);

        SustainabilityMetric::create([
            'material_type' => $this->material_type,
            'water_per_kg' => $this->water_per_kg,
            'carbon_per_kg' => $this->carbon_per_kg,
        ]);

        $this->reset(['material_type', 'water_per_kg', 'carbon_per_kg']);
        session()->flash('message', 'Metric added successfully.');
    }

    public function delete($id)
    {
        SustainabilityMetric::find($id)->delete();
    }

    public function with()
    {
        return [
            'metrics' => SustainabilityMetric::all(),
        ];
    }
};
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-stone-200 mb-8">
        <h2 class="text-lg font-bold mb-4">Add New Material Coefficient</h2>
        
        <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-stone-700">Material Type</label>
                <input type="text" wire:model="material_type" placeholder="e.g. Organic Cotton" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                @error('material_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700">Water Saved (L/kg)</label>
                <input type="number" step="0.01" wire:model="water_per_kg" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                @error('water_per_kg') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700">Carbon Reduced (kg/kg)</label>
                <input type="number" step="0.01" wire:model="carbon_per_kg" class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-stone-500 focus:ring-stone-500">
                @error('carbon_per_kg') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-stone-900 text-white px-4 py-2 rounded-md hover:bg-stone-800 transition">Save Metric</button>
            </div>
        </form>
        
        @if (session()->has('message'))
            <div class="mt-4 p-2 bg-green-50 text-green-700 rounded-md text-sm">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-stone-200 overflow-hidden">
        <table class="min-w-full divide-y divide-stone-200">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase">Material</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase">Water L/kg</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase">Carbon kg/kg</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-stone-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-200">
                @foreach($metrics as $metric)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-stone-900">{{ $metric->material_type }}</td>
                        <td class="px-6 py-4 text-sm text-stone-500">{{ $metric->water_per_kg }}</td>
                        <td class="px-6 py-4 text-sm text-stone-500">{{ $metric->carbon_per_kg }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <button wire:click="delete({{ $metric->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
