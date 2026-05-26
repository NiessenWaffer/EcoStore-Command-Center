<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">Resale & Trade-In Portal</h1>
            <p class="text-stone-500">Give your garments a second life and earn store credit.</p>
        </div>
        <a href="{{ route('resale.create') }}" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-stone-800 transition">
            New Trade-In
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-stone-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-stone-50 border-b border-stone-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-stone-600">Product</th>
                    <th class="px-6 py-4 font-semibold text-stone-600">Condition</th>
                    <th class="px-6 py-4 font-semibold text-stone-600">Est. Credit</th>
                    <th class="px-6 py-4 font-semibold text-stone-600">Status</th>
                    <th class="px-6 py-4 font-semibold text-stone-600 text-right">Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tradeIns as $tradeIn)
                <tr class="border-b border-stone-50 hover:bg-stone-50 transition duration-150">
                    <td class="px-6 py-4 font-medium">{{ $tradeIn->product->name }}</td>
                    <td class="px-6 py-4 text-stone-600">{{ $tradeIn->condition }}</td>
                    <td class="px-6 py-4 text-stone-800 font-semibold">${{ number_format($tradeIn->estimated_credit_cents / 100, 2) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                            @if($tradeIn->status === 'credited') bg-green-100 text-green-700 
                            @elseif($tradeIn->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-stone-100 text-stone-700 @endif">
                            {{ ucfirst($tradeIn->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-stone-500 text-sm">
                        {{ $tradeIn->created_at->format('M d, Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-stone-500">
                        You haven't traded in any items yet. 
                        <a href="{{ route('resale.create') }}" class="text-black font-bold underline ml-1">Start your first trade-in</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-layouts.app>
