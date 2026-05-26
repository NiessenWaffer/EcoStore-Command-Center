<x-layouts.app>
<div class="bg-stone-100 py-12 border-b border-stone-200">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-4 mb-4">
            <span class="bg-black text-white px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded">Digital Passport</span>
            <span class="text-stone-400 text-xs font-mono">Batch: {{ $passport->batch_number }}</span>
        </div>
        <h1 class="text-4xl font-black uppercase tracking-tighter text-stone-900">{{ $product->name }}</h1>
        <p class="text-stone-500 mt-2">Born on {{ $passport->manufacturing_date->format('M d, Y') }} at {{ $factory->name }}</p>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Ethical Backstory -->
        <div class="lg:col-span-2 space-y-12">
            <section>
                <h2 class="text-2xl font-bold mb-6">Manufacturing Backstory</h2>
                <div class="bg-white p-8 rounded-2xl border border-stone-100 shadow-sm">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h3 class="text-xl font-bold">{{ $factory->name }}</h3>
                            <p class="text-stone-500">{{ $factory->location }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold uppercase text-stone-400 mb-1">Ethical Score</p>
                            <p class="text-3xl font-black text-green-600">{{ $factory->ethical_score }}/100</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                        @foreach($factory->certifications as $cert)
                        <div class="text-center p-4 bg-stone-50 rounded-xl border border-stone-100">
                            <p class="text-[10px] font-bold uppercase text-stone-400 mb-1">Certified</p>
                            <p class="text-sm font-bold text-stone-800">{{ $cert }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="prose prose-stone max-w-none">
                        <h4 class="text-lg font-bold">Audit Summary</h4>
                        <p class="text-stone-600 leading-relaxed">{{ $factory->audit_report_summary }}</p>
                    </div>

                    @if($factory->video_url)
                    <div class="mt-8 aspect-video bg-stone-100 rounded-xl overflow-hidden relative group">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                        </div>
                        <img src="https://images.unsplash.com/photo-1558444479-c84825924375?auto=format&fit=crop&w=800&q=80" alt="Factory Video Placeholder" class="w-full h-full object-cover">
                    </div>
                    @endif
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-6">Trust & Verification</h2>
                <livewire:passports.verification-timeline :passport="$passport" />
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-6">Material Traceability</h2>
                <div class="space-y-4">
                    @foreach($product->material_composition as $material => $percent)
                    <div class="bg-white p-6 rounded-xl border border-stone-100 flex justify-between items-center">
                        <div>
                            <span class="font-bold text-stone-900">{{ $material }}</span>
                            <span class="text-stone-400 text-sm ml-2">Tier 1 Source</span>
                        </div>
                        <span class="text-xl font-black text-stone-800">{{ $percent }}%</span>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Right: Financial Transparency -->
        <div class="space-y-8">
            <x-true-cost :product="$product" />

            <div class="bg-stone-900 text-white p-8 rounded-2xl shadow-xl">
                <h3 class="text-lg font-bold mb-4">Transit Impact</h3>
                <p class="text-3xl font-black text-blue-400">{{ $passport->transit_impact_carbon }} kg CO2</p>
                <p class="text-stone-400 text-sm mt-2">Factory to warehouse transportation emissions. All offset via our climate program.</p>
            </div>

            @auth
                <livewire:passports.transfer-initialization :passport="$passport" />
            @endauth

            <div class="bg-white p-8 rounded-2xl border border-stone-100 shadow-sm text-center">
                <p class="text-stone-500 text-sm mb-6 italic">"Transparency is the only way forward for a sustainable future."</p>
                <a href="{{ route('shop') }}" class="inline-block w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-stone-800 transition">
                    Shop Responsible Apparel
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
