<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Your Dashboard</h1>
        <div class="text-right">
            <p class="text-gray-600">Welcome back, <span class="font-bold text-black">{{ $user->name }}</span></p>
            <p class="text-sm text-gray-500">Eco-Tier: <span class="text-green-600 font-semibold">{{ $user->eco_tier }}</span></p>
        </div>
    </div>

    <!-- Impact Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-gray-500 text-sm uppercase tracking-wider mb-2">Total Water Saved</h3>
            <p class="text-4xl font-bold text-blue-600">{{ number_format($user->cumulative_water_saved, 1) }} L</p>
            <p class="text-xs text-gray-400 mt-2">Across all your purchases</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-gray-500 text-sm uppercase tracking-wider mb-2">Total Carbon Reduced</h3>
            <p class="text-4xl font-bold text-green-600">{{ number_format($user->cumulative_carbon_reduced, 1) }} kg</p>
            <p class="text-xs text-gray-400 mt-2">Your contribution to a cooler planet</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-gray-500 text-sm uppercase tracking-wider mb-2">Network Impact Points</h3>
            <p class="text-4xl font-bold text-purple-600">{{ $user->network_impact_points }}</p>
            <p class="text-xs text-gray-400 mt-2">Earned through eco-conscious choices</p>
        </div>
    </div>

    <!-- Order History -->
    <h2 class="text-2xl font-bold mb-4">Order History</h2>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-gray-600">Order #</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Date</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Total</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-right">Impact</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-800 font-semibold">${{ number_format($order->total_cents / 100, 2) }}</td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-blue-600 font-bold">{{ $order->total_water_saved }}L</span> / 
                        <span class="text-green-600 font-bold">{{ $order->total_carbon_reduced }}kg</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($order->status === 'completed')
                        <a href="{{ route('return.deterrent', ['items' => $order->items->pluck('id')->toArray()]) }}" class="text-xs font-bold uppercase tracking-widest text-stone-400 hover:text-red-600 transition">
                            Return
                        </a>
                        @else
                        <span class="text-xs text-stone-300 uppercase font-bold tracking-widest">Processing</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        You haven't placed any orders yet. 
                        <a href="{{ route('shop') }}" class="text-black font-bold underline ml-1">Start shopping with impact</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-layouts.app>
