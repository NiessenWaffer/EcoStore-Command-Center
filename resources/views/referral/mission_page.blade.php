<x-layouts.app>
<div class="bg-stone-900 text-white py-24 border-b border-stone-800">
    <div class="container mx-auto px-4 text-center">
        <div class="inline-block px-4 py-1 rounded-full bg-green-500/10 text-green-400 text-xs font-bold uppercase tracking-widest mb-6 border border-green-500/20">
            You've been invited
        </div>
        <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter mb-8">
            Join the mission with <span class="text-green-500">{{ $referrer->name }}</span>
        </h1>
        <p class="text-xl text-stone-400 max-w-2xl mx-auto leading-relaxed mb-12">
            Your friend has already saved **{{ number_format($referrer->cumulative_water_saved) }} Liters** of water through sustainable choices. Join them in making a real difference.
        </p>

        <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-6">
            <a href="{{ route('shop') }}" class="w-full md:w-auto bg-white text-black px-12 py-4 rounded-lg font-bold text-lg hover:bg-stone-200 transition duration-300">
                Claim 10% Discount & Shop
            </a>
            <a href="{{ route('register', ['token' => 'referral']) }}" class="w-full md:w-auto bg-transparent border-2 border-stone-700 text-white px-12 py-4 rounded-lg font-bold text-lg hover:border-stone-500 transition duration-300">
                Learn About Our Mission
            </a>
        </div>
    </div>
</div>

<div class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
            <div>
                <h2 class="text-4xl font-bold mb-6">Why Sustainable Fashion?</h2>
                <p class="text-stone-600 leading-relaxed mb-8">
                    The fashion industry is responsible for 10% of global carbon emissions and is the second-largest consumer of the world's water supply. We're here to change that, one garment at a time.
                </p>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-blue-50 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Radical Transparency</h4>
                            <p class="text-stone-500 text-sm">We show you exactly how much water and carbon went into every piece.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-green-50 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Carbon Neutral Shipping</h4>
                            <p class="text-stone-500 text-sm">Every delivery is offset, ensuring your impact stays positive.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square bg-stone-100 rounded-2xl overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=800&q=80" alt="Sustainable Apparel" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-10 -left-10 bg-white p-8 rounded-xl shadow-2xl border border-stone-100 max-w-xs">
                    <p class="text-stone-400 text-xs uppercase tracking-widest font-bold mb-2">Live Community Impact</p>
                    <p class="text-3xl font-black text-stone-900">4,281,000L</p>
                    <p class="text-stone-500 text-sm mt-1">Water saved by our ambassadors this month.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
