<x-layouts.app>
    <!-- Hero Section (Plan 1 Style) -->
    <div class="relative bg-stone-100 py-16 md:py-32 border-b border-stone-200 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl text-center md:text-left">
                <h1 class="text-5xl sm:text-6xl md:text-8xl font-black uppercase tracking-tighter text-stone-900 leading-[0.9] mb-8">
                    Wear the <br><span class="text-stone-500">Change.</span>
                </h1>
                <p class="text-lg md:text-xl text-stone-600 mb-12 max-w-xl mx-auto md:ml-0 leading-relaxed font-medium">
                    A collection of high-performance apparel designed for the planet. 100% transparent. 100% carbon neutral.
                </p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="{{ route('shop') }}" class="bg-black text-white px-12 py-5 rounded-xl font-bold text-lg hover:bg-stone-800 transition text-center shadow-xl shadow-black/10">
                        Explore Collection
                    </a>
                    <a href="{{ route('mission') }}" class="bg-white text-black border-2 border-stone-200 px-12 py-5 rounded-xl font-bold text-lg hover:bg-stone-50 transition text-center flex items-center justify-center">
                        Our Mission
                    </a>
                </div>
            </div>
        </div>
        <!-- Stylized geometric gradient background -->
        <div class="absolute right-0 top-0 h-full w-1/2 opacity-10 pointer-events-none hidden lg:block" style="background: linear-gradient(135deg, #2D302D 0%, #8C948C 100%); clip-path: polygon(25% 0%, 100% 0%, 100% 100%, 0% 100%);"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-stone-200/50 rounded-full blur-3xl md:hidden"></div>
    </div>

    <!-- Featured Sustainable Collections (Plan 1) -->
    <div class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-stone-900">Featured Collections</h2>
                    <p class="text-stone-500 mt-2">Curated by environmental impact and sustainability grade.</p>
                </div>
                <a href="{{ route('shop') }}" class="text-sm font-bold uppercase tracking-widest text-stone-400 hover:text-black transition">View All</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredCollections as $collection)
                <a href="{{ route('shop', ['selectedCategory' => $collection->id]) }}" class="group block relative aspect-[4/5] bg-stone-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition duration-500">
                    @if($collection->image_url)
                        <img src="{{ $collection->image_url }}" alt="{{ $collection->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center p-12 text-center" style="background: linear-gradient(135deg, #F5F5F0 0%, #ccb9aa 100%);">
                            <span class="text-stone-400 font-black text-4xl uppercase tracking-tighter mix-blend-multiply opacity-50">{{ $collection->name }}</span>
                        </div>
                    @endif
                    
                    <!-- Overlay Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-900/80 via-transparent to-transparent opacity-60 group-hover:opacity-90 transition duration-500"></div>

                    <div class="absolute bottom-0 left-0 p-8">
                        <p class="text-stone-300 text-[10px] font-black uppercase tracking-[0.3em] mb-2">{{ $collection->impact_label }}</p>
                        <h3 class="text-3xl font-black uppercase tracking-tighter text-white">{{ $collection->name }}</h3>
                        <div class="mt-4 flex items-center text-white text-xs font-bold uppercase tracking-widest translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition duration-500">
                            Explore Collection
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Latest Arrivals (Plan 1) -->
    <div class="py-24 bg-stone-50 border-t border-stone-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-black uppercase tracking-tighter text-stone-900 mb-12 text-center">Latest Arrivals</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($latestProducts as $product)
                <div class="group cursor-pointer">
                    <div class="aspect-square bg-white rounded-xl overflow-hidden mb-4 relative border border-stone-100">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(45deg, #eee 0%, #f9f9f9 100%);">
                                <svg class="w-8 h-8 text-stone-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="font-bold text-sm text-stone-900 truncate">{{ $product->name }}</h3>
                    <p class="text-stone-400 text-xs mt-1">${{ number_format($product->price_cents / 100, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Radical Transparency Callout -->
    <div class="py-24 bg-stone-900 text-white overflow-hidden relative">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-8 max-w-2xl mx-auto">Radical Transparency is our standard.</h2>
            <p class="text-stone-400 text-lg mb-12 max-w-xl mx-auto">Every item in our store comes with a Digital Product Passport. See the factory, the workers, and the environmental cost of your style.</p>
            <a href="{{ route('passports.index') }}" class="inline-block border-2 border-stone-700 text-stone-300 px-12 py-4 rounded-lg font-bold hover:border-white hover:text-white transition">Learn About Passports</a>
        </div>
        <div class="absolute inset-0 opacity-5 pointer-events-none select-none overflow-hidden flex items-center justify-center">
            <span class="text-[20vw] font-black uppercase tracking-tighter leading-none select-none">Transparent</span>
        </div>
    </div>
</x-layouts.app>
