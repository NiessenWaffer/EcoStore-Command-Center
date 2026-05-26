<x-layouts.app>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-stone-200">
        <h1 class="text-3xl font-bold mb-2">Trade-In Your Garment</h1>
        <p class="text-stone-500 mb-8">Select an item from your order history to begin the circular process.</p>

        <form action="{{ route('resale.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="product_id" class="block text-sm font-bold text-stone-700 mb-2">Which item are you trading in?</label>
                <select name="product_id" id="product_id" required class="w-full px-4 py-3 border rounded-xl focus:ring-stone-500 focus:border-stone-500 bg-stone-50">
                    <option value="">Select a previously purchased product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="condition" class="block text-sm font-bold text-stone-700 mb-2">Item Condition</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['Poor', 'Good', 'Excellent', 'Never Worn'] as $cond)
                    <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer hover:bg-stone-50 transition border-stone-200 has-[:checked]:border-black has-[:checked]:bg-stone-50">
                        <input type="radio" name="condition" value="{{ $cond }}" class="absolute opacity-0" required>
                        <span class="text-sm font-bold">{{ $cond }}</span>
                    </label>
                    @endforeach
                </div>
                @error('condition') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="condition_notes" class="block text-sm font-bold text-stone-700 mb-2">Notes (Optional)</label>
                <textarea name="condition_notes" id="condition_notes" rows="4" class="w-full px-4 py-3 border rounded-xl focus:ring-stone-500 focus:border-stone-500 bg-stone-50" placeholder="Tell us about any wear, repairs, or unique history..."></textarea>
            </div>

            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-1">Circular Credit & Bonus</h4>
                        <p class="text-blue-700 text-sm leading-relaxed">
                            Upon verification, you'll receive store credit based on your item's condition. Plus, you'll earn a **+200L Water Impact Bonus** for choosing recycling over landfill.
                        </p>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-bold text-lg hover:bg-stone-800 transition duration-300">
                Submit Trade-In Request
            </button>
        </form>
    </div>
</div>
</x-layouts.app>
