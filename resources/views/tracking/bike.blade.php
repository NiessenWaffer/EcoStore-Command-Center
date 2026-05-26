<x-layouts.app>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-3xl font-black uppercase tracking-tighter">Live Delivery Mission</h1>
                <p class="text-stone-500">Order #{{ $order->id }} • Status: <span class="text-stone-900 font-bold uppercase">{{ $order->status }}</span></p>
            </div>
            <div class="text-right">
                <div class="inline-flex items-center space-x-2 bg-stone-900 text-white px-4 py-2 rounded-full">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-bold uppercase tracking-widest">Local Bike Courier Active</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left: Map Visualization -->
            <div class="lg:col-span-2 space-y-8">
                <div class="aspect-video bg-stone-100 rounded-3xl border border-stone-200 relative overflow-hidden group shadow-2xl">
                    <!-- Mock Map Background -->
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1526367790999-015078648402?auto=format&fit=crop&w=1200&q=80')] bg-cover opacity-30 grayscale contrast-125"></div>
                    
                    <!-- Animated Path -->
                    <svg class="absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M 20,80 Q 50,50 80,20" fill="none" stroke="#2D302D" stroke-width="0.5" stroke-dasharray="2,2" class="opacity-30" />
                        <!-- Animated Bike -->
                        <circle r="2" fill="black" class="animate-tracking-bike">
                            <animateMotion dur="10s" repeatCount="indefinite" path="M 20,80 Q 50,50 80,20" />
                        </circle>
                    </svg>

                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur px-6 py-3 rounded-xl shadow-xl border border-stone-100 text-center transform hover:scale-105 transition">
                            <p class="text-[10px] font-black uppercase tracking-widest text-stone-400 mb-1">Estimated Arrival</p>
                            <p class="text-2xl font-black text-stone-900">14:45 <span class="text-xs font-normal">Today</span></p>
                        </div>
                    </div>
                    
                    <!-- Distance Progress Overlay -->
                    <div class="absolute bottom-8 left-8 right-8 bg-white p-6 rounded-2xl shadow-xl border border-stone-100">
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-stone-400 mb-2">
                            <span>Fulfillment Hub ({{ $order->localHub->name ?? 'Main Hub' }})</span>
                            <span>Destination</span>
                        </div>
                        <div class="w-full bg-stone-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-black h-full animate-pulse-slow" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm">
                    <h3 class="text-lg font-bold mb-6">Mission Log</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="h-6 w-6 rounded-full bg-stone-900 text-white flex items-center justify-center text-[10px] mr-4 mt-0.5 font-bold">01</div>
                            <div>
                                <p class="text-sm font-bold">Courier picked up item from {{ $order->localHub->name ?? 'Hub' }}</p>
                                <p class="text-xs text-stone-400">12:30 PM • Zero-waste packaging verified</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="h-6 w-6 rounded-full bg-stone-900 text-white flex items-center justify-center text-[10px] mr-4 mt-0.5 font-bold">02</div>
                            <div>
                                <p class="text-sm font-bold">Courier entered your neighborhood geofence</p>
                                <p class="text-xs text-stone-400">14:10 PM • Neighborhood bundling bonus applied</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Impact Tracking -->
            <div class="space-y-8">
                <div class="bg-stone-900 text-white p-8 rounded-3xl shadow-2xl">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-stone-400 mb-6">Mission Impact</h3>
                    <div class="space-y-12">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-green-500 mb-2">Live CO2 Saved</p>
                            <p class="text-6xl font-black">2.4<span class="text-xl ml-1 text-stone-500">kg</span></p>
                            <p class="text-stone-500 text-xs mt-4">By choosing bike delivery over a traditional delivery truck.</p>
                        </div>
                        <div class="pt-8 border-t border-stone-800">
                            <p class="text-[10px] font-black uppercase tracking-widest text-blue-400 mb-2">Water Bonus</p>
                            <p class="text-4xl font-black">50<span class="text-lg ml-1 text-stone-500">L</span></p>
                            <p class="text-stone-500 text-xs mt-4">Earned through community bundling window choice.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-stone-100 shadow-sm text-center">
                    <p class="text-stone-500 text-sm mb-6">"Hyper-local logistics is the key to true net-zero commerce."</p>
                    <button class="w-full bg-stone-100 text-stone-900 py-4 rounded-xl font-bold text-sm hover:bg-stone-200 transition">Contact Courier</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes tracking-bike {
        0% { transform: scale(1); }
        50% { transform: scale(1.5); }
        100% { transform: scale(1); }
    }
    .animate-tracking-bike {
        animation: tracking-bike 2s infinite ease-in-out;
    }
</style>
</x-layouts.app>
