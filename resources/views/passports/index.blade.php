<x-layouts.app>
<div class="bg-stone-50 py-24">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-6xl font-black uppercase tracking-tighter text-stone-900 mb-8">Digital <span class="text-stone-500">Passports</span></h1>
        <p class="text-xl text-stone-600 max-w-2xl mx-auto leading-relaxed mb-12">
            Every EcoStore item is cryptographically linked to a Digital Product Passport. Verify the supply chain, the factory, and the environmental impact of your style.
        </p>
        
        <div class="bg-white p-12 rounded-3xl border border-stone-100 shadow-xl max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-left">
                <div class="space-y-4">
                    <x-lucide-factory class="w-8 h-8 text-stone-900" />
                    <h3 class="font-bold">Verified Sourcing</h3>
                    <p class="text-sm text-stone-500">Track every fiber back to its ethical origin.</p>
                </div>
                <div class="space-y-4">
                    <x-lucide-shield-check class="w-8 h-8 text-stone-900" />
                    <h3 class="font-bold">Immutable Trail</h3>
                    <p class="text-sm text-stone-500">Powered by Plan 6 cryptographic hash chains.</p>
                </div>
                <div class="space-y-4">
                    <x-lucide-refresh-cw class="w-8 h-8 text-stone-900" />
                    <h3 class="font-bold">Full Lifecycle</h3>
                    <p class="text-sm text-stone-500">From raw material to resale and recycling.</p>
                </div>
            </div>
            
            <div class="mt-16 pt-12 border-t border-stone-50 text-center">
                <p class="text-stone-400 text-sm mb-6 italic">To view a specific passport, scan the QR code on your EcoStore garment tag.</p>
                <a href="{{ route('shop') }}" class="inline-block bg-black text-white px-12 py-4 rounded-xl font-bold uppercase text-xs tracking-widest hover:bg-stone-800 transition shadow-lg shadow-stone-200">
                    Explore Sustainable Collection
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
