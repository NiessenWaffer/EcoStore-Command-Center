<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
            <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
            
            <div class="mb-12">
                <livewire:shop.⚡delivery-selector />
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email ?? old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ auth()->user()->name ?? old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="city">City</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="postal_code">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="country">Country</label>
                    <input type="text" name="country" id="country" value="{{ old('country') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold w-full hover:bg-gray-800 transition duration-300">
                    Proceed to Payment
                </button>
            </form>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
                @foreach($cart as $item)
                <div class="flex justify-between mb-4 border-bottom pb-4">
                    <div>
                        <p class="font-bold">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-600">{{ $item['size'] }} / {{ $item['color'] }} x {{ $item['quantity'] }}</p>
                    </div>
                    <p>${{ number_format($item['price_cents'] / 100, 2) }}</p>
                </div>
                @endforeach

                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>${{ number_format($totals['total_cents'] / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2 text-green-600">
                        <span>Water Saved</span>
                        <span>{{ $totals['total_water'] }} Liters</span>
                    </div>
                    <div class="flex justify-between mb-4 text-green-600">
                        <span>Carbon Reduced</span>
                        <span>{{ $totals['total_carbon'] }} kg</span>
                    </div>
                    <div class="flex justify-between font-bold text-xl border-t pt-4">
                        <span>Total</span>
                        <span>${{ number_format($totals['total_cents'] / 100, 2) }}</span>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-500 text-center">
                All our shipping is 100% carbon neutral.
            </p>
        </div>
    </div>
</div>
</x-layouts.app>
