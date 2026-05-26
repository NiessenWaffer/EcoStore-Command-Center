<x-layouts.app>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto">
        <div class="mb-12 text-center">
            <div class="inline-flex items-center space-x-2 bg-stone-100 px-4 py-2 rounded-full mb-6">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-stone-500">AI Concierge Active</span>
            </div>
            <h1 class="text-4xl font-black uppercase tracking-tighter mb-4">The Precision Fit Wizard</h1>
            <p class="text-stone-500">Help our AI understand your body to eliminate returns and reduce waste.</p>
        </div>

        <div class="bg-white p-12 rounded-3xl shadow-xl border border-stone-100">
            <form action="{{ route('fit.store') }}" method="POST" class="space-y-12">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <label for="height_cm" class="block text-xs font-bold uppercase tracking-widest text-stone-400 mb-4">Height (cm)</label>
                        <input type="number" name="height_cm" id="height_cm" value="{{ $user->height_cm ?? 175 }}" required class="w-full bg-stone-50 border-stone-200 rounded-xl px-6 py-4 text-2xl font-black focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label for="weight_kg" class="block text-xs font-bold uppercase tracking-widest text-stone-400 mb-4">Weight (kg)</label>
                        <input type="number" name="weight_kg" id="weight_kg" value="{{ $user->weight_kg ?? 70 }}" required class="w-full bg-stone-50 border-stone-200 rounded-xl px-6 py-4 text-2xl font-black focus:ring-black focus:border-black">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-stone-400 mb-6 text-center">Your Fit Preference</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['Slim', 'Regular', 'Loose'] as $pref)
                        <label class="relative flex flex-col items-center p-6 border-2 rounded-2xl cursor-pointer hover:bg-stone-50 transition border-stone-100 has-[:checked]:border-black has-[:checked]:bg-stone-50 group">
                            <input type="radio" name="fit_preference" value="{{ $pref }}" class="absolute opacity-0" @if(($user->fit_preference ?? 'Regular') === $pref) checked @endif required>
                            <span class="text-sm font-black uppercase tracking-tight group-hover:scale-110 transition">{{ $pref }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-stone-900 text-white p-8 rounded-2xl">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-400 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h4 class="font-bold mb-2">Why this matters?</h4>
                            <p class="text-stone-400 text-sm leading-relaxed">
                                Returns account for 15M tons of carbon emissions annually. By providing accurate data, you help our AI predict your size with **98% accuracy**, directly reducing your environmental footprint.
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-black text-white py-6 rounded-2xl font-black text-xl uppercase tracking-tighter hover:bg-stone-800 transition transform hover:scale-[1.01] active:scale-[0.99]">
                    Initialize Style Profile
                </button>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>
