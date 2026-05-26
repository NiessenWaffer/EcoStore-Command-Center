<?php

use function Livewire\Volt\{state, mount};
use App\Models\User;

state(['proposals' => [], 'userPower' => 0]);

mount(function () {
    $this->proposals = \App\Models\GovernanceProposal::where('status', 'Active')
        ->orderBy('ends_at', 'asc')
        ->get()
        ->map(function ($p) {
            return [
                'id' => $p->id,
                'title' => $p->title,
                'description' => $p->description,
                'type' => $p->type,
                'status' => $p->status,
                'ends_at' => $p->ends_at->format('M d, Y'),
                'total_weight' => $p->total_weight_cast,
                'image' => $p->type === 'Charity' 
                    ? 'https://images.unsplash.com/photo-1484291470158-b8f8d608850d?auto=format&fit=crop&w=800&q=80'
                    : 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=800&q=80'
            ];
        })->toArray();

    if (auth()->check()) {
        // Calculation logic: Floor(Water Saved / 100)
        $this->userPower = floor(auth()->user()->cumulative_water_saved / 100);
    }
});

?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-8">
        <div>
            <h1 class="text-5xl font-black uppercase tracking-tighter text-stone-900 leading-none mb-4">
                Community <span class="text-stone-500">Governance</span>
            </h1>
            <p class="text-xl text-stone-600 max-w-2xl leading-relaxed">
                Your sustainable actions earn you influence. Vote on brand donations, collective challenges, and our future impact roadmap.
            </p>
        </div>
        
        <!-- Power Card Integration Shell -->
        <div class="w-full md:w-80">
            <x-governance.power-card :power="$userPower" />
        </div>
    </div>

    <!-- Active Proposals Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($proposals as $proposal)
            <div class="group bg-white rounded-2xl overflow-hidden border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $proposal['image'] }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="{{ $proposal['title'] }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-900/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-6">
                        <span class="bg-white/20 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full border border-white/30">
                            {{ $proposal['type'] }}
                        </span>
                    </div>
                </div>
                
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold text-stone-900 group-hover:text-stone-600 transition-colors">{{ $proposal['title'] }}</h3>
                        <span class="text-[10px] font-black uppercase tracking-widest text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">
                            {{ $proposal['status'] }}
                        </span>
                    </div>
                    
                    <p class="text-stone-500 text-sm mb-8 leading-relaxed flex-1">
                        {{ $proposal['description'] }}
                    </p>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-stone-50">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1">Closes In</span>
                            <span class="text-sm font-bold text-stone-900">{{ $proposal['ends_at'] }}</span>
                        </div>
                        <a href="{{ route('governance.show', ['id' => $proposal['id']]) }}" class="bg-black text-white px-6 py-3 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-stone-800 transition shadow-lg shadow-stone-200">
                            View & Vote
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Future Proposals / Transparency Section -->
    <div class="mt-24 grid grid-cols-1 lg:grid-cols-3 gap-12 bg-stone-50 p-12 rounded-3xl border border-stone-100">
        <div class="space-y-4">
            <x-lucide-users class="w-8 h-8 text-stone-900" />
            <h4 class="text-xl font-bold">Community Led</h4>
            <p class="text-sm text-stone-500 leading-relaxed">No boardroom decisions. Every major impact donation is curated and decided by you, the community.</p>
        </div>
        <div class="space-y-4">
            <x-lucide-shield-check class="w-8 h-8 text-stone-900" />
            <h4 class="text-xl font-bold">Impact Weighted</h4>
            <p class="text-sm text-stone-500 leading-relaxed">The more water you save and carbon you reduce, the more weight your vote carries. Verified by Plan 6 Trust Layer.</p>
        </div>
        <div class="space-y-4">
            <x-lucide-line-chart class="w-8 h-8 text-stone-900" />
            <h4 class="text-xl font-bold">Radical Transparency</h4>
            <p class="text-sm text-stone-500 leading-relaxed">View the real-time allocation of our 1% revenue fund and the exact impact your vote achieved.</p>
        </div>
    </div>
</div>
