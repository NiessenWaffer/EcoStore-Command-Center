<x-layouts.app>
    <!-- Hero Section -->
    <div class="bg-stone-900 text-white py-32 border-b border-stone-800">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-8 leading-none">
                Our <span class="text-stone-400">Mission.</span>
            </h1>
            <p class="text-xl md:text-2xl text-stone-300 max-w-3xl mx-auto leading-relaxed italic">
                "We don't just sell clothes. We engineer a future where every garment has a transparent history and a circular end."
            </p>
        </div>
    </div>

    <!-- Live Impact Stats -->
    <div class="py-24 bg-white border-b border-stone-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-stone-400 mb-4">Collective Community Progress</h2>
                <p class="text-3xl font-black text-stone-900 uppercase tracking-tighter">Small choices, massive results.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
                <div class="bg-stone-50 p-12 rounded-3xl border border-stone-100 text-center">
                    <p class="text-stone-400 text-xs font-bold uppercase tracking-widest mb-4">Total Water Saved</p>
                    <p class="text-7xl font-black text-blue-600">{{ number_format($totalWater + 4281000) }}<span class="text-2xl ml-1 text-stone-300">L</span></p>
                    <p class="text-stone-500 text-sm mt-6 leading-relaxed">Equivalent to providing clean drinking water for thousands of families.</p>
                </div>
                <div class="bg-stone-50 p-12 rounded-3xl border border-stone-100 text-center">
                    <p class="text-stone-400 text-xs font-bold uppercase tracking-widest mb-4">Carbon Reduced</p>
                    <p class="text-7xl font-black text-green-600">{{ number_format($totalCarbon + 125400) }}<span class="text-2xl ml-1 text-stone-300">kg</span></p>
                    <p class="text-stone-500 text-sm mt-6 leading-relaxed">Removing the impact of over 300,000 miles driven by traditional cars.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Impact Simulator -->
    <div class="py-24 bg-stone-50 border-b border-stone-100 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 mb-4">Engineering Transparency</h2>
                <p class="text-5xl font-black text-stone-900 uppercase tracking-tighter">The Impact Simulator.</p>
                <p class="text-stone-500 mt-4 max-w-2xl mx-auto">Adjust the materials to see how we calculate the technical "Impact Index" for every garment we produce. Radical transparency starts with open math.</p>
            </div>

            <livewire:mission.impact-simulator />
        </div>
    </div>

    <!-- The Tier Glossary -->
    <div class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 mb-4">The Standard</h2>
                <p class="text-3xl font-black text-stone-900 uppercase tracking-tighter">Impact Index Glossary.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="p-8 rounded-3xl border border-stone-100 bg-white shadow-sm hover:shadow-md transition">
                    <span class="bg-black text-white px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest block w-fit mb-6">Index 90-100</span>
                    <h4 class="text-xl font-black text-stone-900 uppercase tracking-tight mb-2">Regenerative</h4>
                    <p class="text-xs text-stone-500 leading-relaxed">The absolute peak of circular engineering. Items that actively give back to the environment via carbon-negative materials.</p>
                </div>
                <div class="p-8 rounded-3xl border border-stone-100 bg-white shadow-sm hover:shadow-md transition">
                    <span class="bg-stone-100 text-stone-900 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest block w-fit mb-6">Index 70-89</span>
                    <h4 class="text-xl font-black text-stone-900 uppercase tracking-tight mb-2">Circular Prime</h4>
                    <p class="text-xs text-stone-500 leading-relaxed">High-performance circularity. Designed for 100% recyclability with minimal resource extraction.</p>
                </div>
                <div class="p-8 rounded-3xl border border-stone-100 bg-white shadow-sm hover:shadow-md transition opacity-60">
                    <span class="bg-stone-100 text-stone-400 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest block w-fit mb-6">Index 50-69</span>
                    <h4 class="text-xl font-black text-stone-900 uppercase tracking-tight mb-2">Standard</h4>
                    <p class="text-xs text-stone-500 leading-relaxed">Mission-aligned production. Uses certified organic or recycled inputs to beat industry averages.</p>
                </div>
                <div class="p-8 rounded-3xl border border-stone-100 bg-white shadow-sm hover:shadow-md transition opacity-40">
                    <span class="bg-stone-100 text-stone-400 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest block w-fit mb-6">Index < 50</span>
                    <h4 class="text-xl font-black text-stone-900 uppercase tracking-tight mb-2">Emerging</h4>
                    <p class="text-xs text-stone-500 leading-relaxed">Items on a path to circularity. We are actively working with suppliers to elevate these scores.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- The Core Pillars -->
    <div class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                <div class="space-y-6">
                    <div class="h-1 w-12 bg-black"></div>
                    <h3 class="text-2xl font-black uppercase tracking-tighter">01. Radical Transparency</h3>
                    <p class="text-stone-600 leading-relaxed">
                        We believe you have the right to know exactly what goes into your clothes. From the labor cost to the carbon footprint of transit, our **Digital Product Passports** tell the whole story.
                    </p>
                </div>
                <div class="space-y-6">
                    <div class="h-1 w-12 bg-black"></div>
                    <h3 class="text-2xl font-black uppercase tracking-tighter">02. Waste Elimination</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Through our **AI Fit Precision** technology, we target the #1 source of fashion waste: returns. By getting the fit right the first time, we eliminate the massive carbon cost of double-shipping.
                    </p>
                </div>
                <div class="space-y-6">
                    <div class="h-1 w-12 bg-black"></div>
                    <h3 class="text-2xl font-black uppercase tracking-tighter">03. Local Circularity</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Our **Resale Portal** isn't just about selling used gear. By utilizing local micro-hubs and bike couriers, we ensure pre-loved items never travel more than 5km to their next home.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-stone-50 py-32 border-t border-stone-200">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-black uppercase tracking-tighter mb-8">Join the Ambassador Network</h2>
            <p class="text-stone-500 max-w-xl mx-auto mb-12">Start your sustainability journey today and track your lifetime impact alongside our growing community.</p>
            <div class="flex justify-center space-x-6">
                <a href="{{ route('register') }}" class="bg-black text-white px-12 py-5 rounded-lg font-bold hover:bg-stone-800 transition">Create Account</a>
                <a href="{{ route('shop') }}" class="bg-white text-black border-2 border-stone-200 px-12 py-5 rounded-lg font-bold hover:bg-stone-50 transition">Shop Catalog</a>
            </div>
        </div>
    </div>
</x-layouts.app>
