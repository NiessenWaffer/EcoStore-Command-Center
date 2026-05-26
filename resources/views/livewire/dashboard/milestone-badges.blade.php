<?php

use function Livewire\Volt\{state, mount};
use App\Models\UserMilestone;

state(['milestones' => []]);

mount(function () {
    $user = auth()->user();
    
    // Define the canonical milestones for the platform
    $definitions = [
        ['type' => 'water', 'label' => 'Water Guardian', 'threshold' => 1000],
        ['type' => 'carbon', 'label' => 'Carbon Neutral', 'threshold' => 100],
        ['type' => 'network', 'label' => 'Eco Ambassador', 'threshold' => 5],
        ['type' => 'lifetime', 'label' => 'Impact Pioneer', 'threshold' => 10],
    ];

    $this->milestones = collect($definitions)->map(function ($milestone) use ($user) {
        $achievement = \App\Models\UserMilestone::where('user_id', $user->id)
            ->where('type', $milestone['type'])
            ->first();

        return [
            'type' => $milestone['type'],
            'label' => $milestone['label'],
            'threshold' => number_format($milestone['threshold']) . ($milestone['type'] === 'water' ? 'L' : ($milestone['type'] === 'carbon' ? 'kg' : ' Items')),
            'achieved' => (bool) $achievement,
            'date' => $achievement ? $achievement->achieved_at->format('M Y') : null,
        ];
    })->toArray();
});

?>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
    @foreach($milestones as $milestone)
        <div class="bg-white p-6 rounded-[2rem] border border-stone-100 shadow-sm text-center relative overflow-hidden group flex flex-col items-center justify-center min-h-[180px]">
            @if(!$milestone['achieved'])
                <div class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-10 flex items-center justify-center">
                    <x-lucide-lock class="w-5 h-5 text-stone-300" />
                </div>
            @endif

            <div class="inline-flex items-center justify-center w-12 h-12 mb-4 rounded-2xl {{ $milestone['achieved'] ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-50 text-stone-300' }}">
                @php $icon = ['water' => 'droplets', 'carbon' => 'cloud', 'network' => 'users-2', 'lifetime' => 'award'][$milestone['type']]; @endphp
                <x-dynamic-component :component="'lucide-'.$icon" class="w-6 h-6" />
            </div>

            <h4 class="text-[10px] font-black uppercase tracking-widest text-stone-900 leading-tight">{{ $milestone['label'] }}</h4>
            <p class="text-[9px] font-bold text-stone-400 mt-1 uppercase">{{ $milestone['threshold'] }}</p>

            @if($milestone['achieved'])
                <p class="text-[8px] font-black text-emerald-500 uppercase mt-4 tracking-tighter">Achieved {{ $milestone['date'] }}</p>
            @endif
        </div>
    @endforeach
</div>
