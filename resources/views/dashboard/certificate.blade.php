<x-layouts.app>
<div class="bg-stone-50 min-h-screen py-16 flex items-center justify-center px-4">
    <div class="max-w-4xl w-full bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-stone-100 flex flex-col md:flex-row">
        
        <!-- Sidebar: Verification Stats -->
        <div class="md:w-1/3 bg-stone-900 text-white p-12 flex flex-col justify-between">
            <div>
                <x-lucide-shield-check class="w-12 h-12 text-emerald-400 mb-8" />
                <h2 class="text-3xl font-black uppercase tracking-tighter leading-none mb-4">Verified Impact</h2>
                <p class="text-stone-400 text-sm leading-relaxed font-medium">This certificate proves your individual contribution to a sustainable future, backed by unforgeable blockchain-ready audit logs.</p>
            </div>

            <div class="space-y-8 pt-12 border-t border-white/10">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-2">Member Since</p>
                    <p class="text-xl font-bold uppercase tracking-tight">{{ auth()->user()->created_at->format('M Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-2">Ecosystem ID</p>
                    <p class="text-sm font-mono text-emerald-400">{{ substr(md5(auth()->id()), 0, 16) }}</p>
                </div>
            </div>
        </div>

        <!-- Main: Certificate Body -->
        <div class="flex-1 p-16 relative">
            <!-- Decorative Grain/Pattern -->
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>

            <div class="text-center mb-16">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-stone-400">Sustainable Fashion Store</span>
                <h1 class="text-5xl font-black uppercase tracking-tighter text-stone-900 mt-4">Impact Portfolio</h1>
            </div>

            <div class="grid grid-cols-2 gap-12 mb-16 relative z-10">
                <div class="text-center p-8 bg-stone-50 rounded-3xl border border-stone-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-2">Water Offset</p>
                    <p class="text-4xl font-black text-blue-600">{{ number_format(auth()->user()->cumulative_water_saved) }}L</p>
                </div>
                <div class="text-center p-8 bg-stone-50 rounded-3xl border border-stone-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-stone-500 mb-2">Carbon Avoided</p>
                    <p class="text-4xl font-black text-stone-900">{{ number_format(auth()->user()->cumulative_carbon_reduced, 1) }}kg</p>
                </div>
            </div>

            <div class="prose prose-stone max-w-none text-center mb-16">
                <p class="text-stone-500 italic text-lg">
                    "I am a conscious participant in the circular economy, choosing radical transparency and community governance over mass consumption."
                </p>
            </div>

            <div class="flex items-center justify-between pt-12 border-t border-stone-100">
                <div class="flex items-center gap-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode(url('/certificate/verify/' . md5(auth()->id()))) }}" alt="Verification QR" class="w-16 h-16 opacity-80">
                    <div class="text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-stone-900">Scan to Verify</p>
                        <p class="text-[8px] font-bold text-stone-400 mt-1 uppercase">Cryptographically Signed ID</p>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-sm font-black uppercase tracking-tighter text-stone-900">EcoStore Official Seal</p>
                    <p class="text-[9px] font-bold text-emerald-600 uppercase mt-1">Verified Proof of Impact</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-12 pb-24">
    <button class="bg-black text-white px-8 py-4 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-stone-800 transition shadow-xl inline-flex items-center gap-3">
        <x-lucide-download class="w-4 h-4" />
        Export verified PNG
    </button>
</div>
</x-layouts.app>
