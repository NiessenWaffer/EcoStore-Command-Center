<x-layouts.app>
<div class="bg-stone-50">
    <!-- Hero Section -->
    <div class="relative py-24 md:py-32 overflow-hidden border-b border-stone-200">
        <div class="absolute inset-0 z-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-emerald-500 via-transparent to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="bg-emerald-100 text-emerald-800 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-8 inline-block">Partner Ecosystem</span>
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter text-stone-900 mb-8 leading-[0.9]">
                Scale Your <span class="text-stone-400">Impact</span>
            </h1>
            <p class="text-lg md:text-xl text-stone-600 max-w-2xl mx-auto leading-relaxed mb-12">
                Join the world's most transparent sustainable marketplace. Access our Local Hub logistics, mint Digital Passports on the trust layer, and reach a global community of eco-conscious ambassadors.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-black text-white px-10 py-5 rounded-xl font-black uppercase text-xs tracking-[0.2em] shadow-2xl hover:bg-stone-800 transition">Apply to Partner</a>
                <a href="#how-it-works" class="bg-white text-stone-900 px-10 py-5 rounded-xl font-black uppercase text-xs tracking-[0.2em] shadow-xl border border-stone-200 hover:bg-stone-50 transition">Learn More</a>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div id="how-it-works" class="py-24 md:py-32 container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-20">
            <div class="space-y-6">
                <div class="h-16 w-16 bg-white rounded-3xl shadow-xl border border-stone-100 flex items-center justify-center">
                    <x-lucide-shield-check class="w-8 h-8 text-emerald-600" />
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tight">Trust as a Service</h3>
                <p class="text-stone-500 leading-relaxed">Leverage our Plan 20 IPFS-backed trust layer. Mint Digital Product Passports via API to prove every sustainability claim you make with immutable data.</p>
            </div>

            <div class="space-y-6">
                <div class="h-16 w-16 bg-white rounded-3xl shadow-xl border border-stone-100 flex items-center justify-center">
                    <x-lucide-truck class="w-8 h-8 text-blue-600" />
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tight">Local Fulfillment</h3>
                <p class="text-stone-500 leading-relaxed">Ship items to our NYC, London, Tokyo, and Berlin hubs. Our hyper-local logistics engine reduces transit carbon and ensures fast, ethical delivery.</p>
            </div>

            <div class="space-y-6">
                <div class="h-16 w-16 bg-white rounded-3xl shadow-xl border border-stone-100 flex items-center justify-center">
                    <x-lucide-users class="w-8 h-8 text-amber-600" />
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tight">Ambassador Network</h3>
                <p class="text-stone-500 leading-relaxed">Instant access to 10,000+ verified EcoStore Ambassadors. Benefit from our tiered referral system and circular resale loop for your products.</p>
            </div>
        </div>
    </div>

    <!-- Technical Integration Section -->
    <div class="bg-stone-900 text-white py-24 md:py-32">
        <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div>
                <span class="text-stone-500 text-[10px] font-black uppercase tracking-[0.3em] mb-4 block">Developer First</span>
                <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-8 leading-none">Radically Simple <span class="text-emerald-400">API Integration</span></h2>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <x-lucide-terminal class="w-6 h-6 text-emerald-500 mt-1" />
                        <p class="text-stone-400">Standardized JSON schemas for material composition and factory audits.</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <x-lucide-zap class="w-6 h-6 text-emerald-500 mt-1" />
                        <p class="text-stone-400">Real-time webhook updates for order fulfillment and return processing.</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <x-lucide-lock class="w-6 h-6 text-emerald-500 mt-1" />
                        <p class="text-stone-400">Secure Sanctum-based authentication for enterprise-grade security.</p>
                    </div>
                </div>
            </div>
            <div class="bg-stone-800 p-8 rounded-3xl border border-white/10 shadow-3xl font-mono text-xs overflow-hidden">
                <div class="flex gap-2 mb-6">
                    <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-500/50"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                </div>
                <div class="space-y-2 opacity-80">
                    <p class="text-emerald-400">POST /api/v1/passports</p>
                    <p class="text-stone-500">{</p>
                    <p class="pl-4 text-stone-300">"product_name": "Organic Hemp Hoodie",</p>
                    <p class="pl-4 text-stone-300">"batch": "HB-2026-05",</p>
                    <p class="pl-4 text-stone-300">"materials": [</p>
                    <p class="pl-8 text-stone-300">{"type": "Hemp", "source": "Tier 1", "percent": 100}</p>
                    <p class="pl-4 text-stone-300">]</p>
                    <p class="text-stone-500">}</p>
                    <p class="pt-4 text-blue-400">// Response 201 Created</p>
                    <p class="text-stone-300">{ "ipfs_cid": "QmXoyp...", "qr_token": "V8K-92J" }</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
