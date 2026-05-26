<x-layouts.admin>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-stone-800">Product Management</h1>
            <p class="text-stone-500">Manage your catalog and sustainability data.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-stone-900 text-white px-4 py-2 rounded-md hover:bg-stone-800 transition">Create Product</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-stone-200 overflow-hidden">
        <table class="min-w-full divide-y divide-stone-200">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Impact Score</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-stone-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-200">
                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-stone-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-500">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-500">${{ number_format($product->price_cents / 100, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-bold @if($product->sustainability_score >= 8) bg-green-100 text-green-700 @else bg-stone-100 text-stone-600 @endif">
                                {{ $product->sustainability_score ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-stone-600 hover:text-stone-900">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</x-layouts.admin>
