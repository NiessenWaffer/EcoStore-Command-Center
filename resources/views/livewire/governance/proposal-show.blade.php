<?php

use function Livewire\Volt\{state, mount};
use App\Models\User;

state(['proposal' => null, 'userPower' => 0, 'allocations' => [], 'totalAllocated' => 0]);

mount(function ($id) {
    // Sample data for task 7.1.3
    $this->proposal = [
        'id' => $id,
        'title' => 'Q3 Impact Fund: Charity Selection',
        'description' => 'We have allocated 1% of this quarter\'s revenue ($12,450) to ocean cleanup. Choose how to distribute this fund among our three vetted partners. You can split your voting power across multiple charities.',
        'type' => 'Charity',
        'options' => [
            ['id' => 'ocean_cleanup', 'name' => 'The Ocean Cleanup', 'description' => 'Developing advanced technologies to rid the oceans of plastic.', 'votes' => 15400, 'color' => 'bg-blue-500'],
            ['id' => 'surfrider', 'name' => 'Surfrider Foundation', 'description' => 'Protection and enjoyment of the world\'s ocean and beaches.', 'votes' => 12000, 'color' => 'bg-cyan-500'],
            ['id' => 'sea_shepherd', 'name' => 'Sea Shepherd', 'description' => 'Direct action to protect marine wildlife and habitats.', 'votes' => 17600, 'color' => 'bg-indigo-600'],
        ],
        'total_weight' => 45000,
        'ends_at' => now()->addDays(5)->format('F j, Y'),
    ];

    if (auth()->check()) {
        $this->userPower = floor(auth()->user()->cumulative_water_saved / 100);
        foreach ($this->proposal['options'] as $option) {
            $this->allocations[$option['id']] = 0;
        }
    }
});

$updateAllocation = function ($optionId, $value) {
    $currentAllocated = array_sum(array_diff_key($this->allocations, [$optionId => 0]));
    $remaining = $this->userPower - $currentAllocated;
    
    $this->allocations[$optionId] = min((int)$value, $remaining);
    $this->totalAllocated = array_sum($this->allocations);
};

$submitVote = function () {
    if ($this->totalAllocated > $this->userPower) return;
    // Logic for task 7.3.2 will handle persistence
    session()->flash('message', 'Your weighted vote has been recorded successfully!');
};

?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="/governance" class="text-stone-400 hover:text-stone-900 transition-colors mb-8 inline-flex items-center gap-2 font-bold uppercase text-[10px] tracking-widest">
        <x-lucide-arrow-left class="w-3 h-3" />
        Back to Hub
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
        <!-- Main Detail Area -->
        <div class="lg:col-span-2 space-y-12">
            <div>
                <span class="bg-stone-100 text-stone-600 text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full mb-4 inline-block border border-stone-200">
                    Active Proposal #{{ $proposal['id'] }}
                </span>
                <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter text-stone-900 leading-tight mb-6">
                    {{ $proposal['title'] }}
                </h1>
                <p class="text-xl text-stone-600 leading-relaxed max-w-2xl">
                    {{ $proposal['description'] }}
                </p>
            </div>

            <!-- Charity Selection Grid Shell -->
            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-stone-900">Cast Your Weighted Vote</h3>
                
                @if(session()->has('message'))
                    <div class="p-4 bg-green-50 border border-green-100 rounded-xl text-green-800 text-sm font-medium flex items-center gap-3">
                        <x-lucide-check-circle class="w-5 h-5 text-green-500" />
                        {{ session('message') }}
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach($proposal['options'] as $option)
                        <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-sm hover:border-stone-300 transition-all group">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl {{ $option['color'] }} flex items-center justify-center text-white font-black text-xl">
                                        {{ substr($option['name'], 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-stone-900">{{ $option['name'] }}</h4>
                                        <p class="text-xs text-stone-400">{{ $option['description'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-stone-900">{{ number_format($this->allocations[$option['id']]) }}</span>
                                    <span class="text-[10px] font-bold text-stone-400 uppercase ml-1">Votes</span>
                                </div>
                            </div>
                            
                            <input type="range" 
                                   min="0" 
                                   max="{{ $userPower }}" 
                                   wire:model.live="allocations.{{ $option['id'] }}"
                                   wire:input="updateAllocation('{{ $option['id'] }}', $event.target.value)"
                                   class="w-full h-1.5 bg-stone-100 rounded-lg appearance-none cursor-pointer accent-stone-900">
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 p-8 bg-stone-900 rounded-3xl text-white flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="space-y-2 text-center md:text-left">
                        <p class="text-stone-500 text-[10px] font-black uppercase tracking-[0.2em]">Total Allocation</p>
                        <div class="flex items-baseline gap-2 justify-center md:justify-start">
                            <span class="text-4xl font-black tracking-tighter">{{ number_format($totalAllocated) }}</span>
                            <span class="text-sm text-stone-500 font-bold uppercase">/ {{ number_format($userPower) }} Power</span>
                        </div>
                    </div>
                    <button wire:click="submitVote" 
                            {{ $totalAllocated == 0 ? 'disabled' : '' }}
                            class="w-full md:w-auto bg-white text-black px-12 py-4 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-stone-200 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirm Distribution
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar: Real-time Stats -->
        <div class="space-y-8">
            <div class="bg-stone-50 p-8 rounded-3xl border border-stone-100">
                <h4 class="text-lg font-bold text-stone-900 mb-6">Current Distribution</h4>
                <div class="space-y-6">
                    @foreach($proposal['options'] as $option)
                        @php $percent = round(($option['votes'] / $proposal['total_weight']) * 100); @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold uppercase tracking-widest">
                                <span class="text-stone-500">{{ $option['name'] }}</span>
                                <span class="text-stone-900">{{ $percent }}%</span>
                            </div>
                            <div class="h-2 w-full bg-stone-200 rounded-full overflow-hidden">
                                <div class="h-full {{ $option['color'] }} transition-all duration-1000" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 pt-6 border-t border-stone-200">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-[10px] font-black uppercase tracking-widest text-stone-400">Total Votes Cast</span>
                        <span class="text-sm font-black text-stone-900">{{ number_format($proposal['total_weight']) }}</span>
                    </div>
                    <p class="text-[10px] text-stone-400 italic">Voting closes on {{ $proposal['ends_at'] }}</p>
                </div>
            </div>

            <!-- Your Influence Card -->
            <x-governance.power-card :power="$userPower" />
        </div>
    </div>
</div>
