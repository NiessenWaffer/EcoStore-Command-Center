@props(['product'])

@php
    $totalCost = $product->materials_cost_cents + $product->labor_cost_cents + $product->shipping_cost_cents + $product->operations_cost_cents;
    $profitCents = max(0, $product->price_cents - $totalCost);
    
    $breakdown = [
        ['label' => 'Materials', 'cents' => $product->materials_cost_cents, 'color' => 'bg-stone-300'],
        ['label' => 'Labor', 'cents' => $product->labor_cost_cents, 'color' => 'bg-stone-500'],
        ['label' => 'Shipping', 'cents' => $product->shipping_cost_cents, 'color' => 'bg-stone-400'],
        ['label' => 'Ops', 'cents' => $product->operations_cost_cents, 'color' => 'bg-stone-200'],
        ['label' => 'Profit', 'cents' => $profitCents, 'color' => 'bg-black'],
    ];

    $maxCents = max(array_column($breakdown, 'cents'));
@endphp

<div class="bg-stone-50 p-6 rounded-xl border border-stone-200">
    <h3 class="text-sm font-bold uppercase tracking-widest text-stone-500 mb-6">Financial Transparency (True Cost)</h3>
    
    <div class="space-y-4">
        @foreach($breakdown as $item)
        @if($item['cents'] > 0)
        <div>
            <div class="flex justify-between text-xs font-bold mb-1">
                <span>{{ $item['label'] }}</span>
                <span>${{ number_format($item['cents'] / 100, 2) }}</span>
            </div>
            <div class="w-full bg-white h-2 rounded-full overflow-hidden border border-stone-100">
                <div class="{{ $item['color'] }} h-full" style="width: {{ ($item['cents'] / $product->price_cents) * 100 }}%"></div>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <div class="mt-6 pt-6 border-t border-stone-200 flex justify-between items-center">
        <span class="text-xs font-bold uppercase text-stone-400">Retail Price</span>
        <span class="text-xl font-black">${{ number_format($product->price_cents / 100, 2) }}</span>
    </div>
</div>
