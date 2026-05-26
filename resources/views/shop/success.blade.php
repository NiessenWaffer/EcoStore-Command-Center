<x-layouts.app>
<div class="container mx-auto px-4 py-16 text-center">
    <div class="mb-8">
        <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    
    <h1 class="text-4xl font-bold mb-4">Thank you for your order!</h1>
    <p class="text-xl text-gray-600 mb-8">Your contribution to a more sustainable world is being processed.</p>
    
    <div class="max-w-md mx-auto bg-green-50 p-8 rounded-xl mb-12 border border-green-100">
        <h2 class="text-lg font-semibold text-green-800 mb-4">Your Positive Impact from this Purchase:</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-3xl font-bold text-green-600">{{ $order->total_water_saved }}</p>
                <p class="text-sm text-green-800 uppercase tracking-wider">Liters of Water Saved</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-green-600">{{ $order->total_carbon_reduced }}</p>
                <p class="text-sm text-green-800 uppercase tracking-wider">kg of CO2 Reduced</p>
            </div>
        </div>
    </div>

    @if(isset($registrationToken))
    <div class="max-w-md mx-auto bg-stone-900 text-white p-8 rounded-xl mb-12 shadow-xl transform hover:scale-[1.02] transition duration-300">
        <h2 class="text-xl font-bold mb-4">Save Your Lifetime Impact</h2>
        <p class="text-stone-400 text-sm mb-6">Don't lose your environmental contributions. Create a free account to track your mission and earn rewards.</p>
        <a href="{{ route('register', ['token' => $registrationToken]) }}" class="inline-block w-full bg-white text-black py-3 rounded-lg font-bold hover:bg-stone-200 transition">
            Save My Impact
        </a>
    </div>
    @endif
    
    <div class="space-x-4">
        <a href="{{ route('shop') }}" class="inline-block bg-black text-white px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition duration-300">
            Continue Shopping
        </a>
        <a href="/" class="inline-block bg-white text-black border border-black px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-300">
            Back Home
        </a>
    </div>
    
    <p class="mt-12 text-gray-500">
        Order #{{ $order->id }} - A confirmation email has been sent to {{ $order->shipping_address['email'] }}.
    </p>
</div>
</x-layouts.app>
