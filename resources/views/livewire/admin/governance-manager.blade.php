<?php

use function Livewire\Volt\{state, mount};
use App\Models\GovernanceProposal;

state([
    'proposals' => [],
    'title' => '',
    'description' => '',
    'type' => 'Charity',
    'options' => [['name' => '', 'description' => '']],
    'quorum_threshold' => 1000,
    'ends_at' => '',
]);

mount(function () {
    // Sample list for admin task 7.1.5
    $this->proposals = [
        ['title' => 'Q3 Impact Fund', 'status' => 'Active', 'votes' => 45000],
        ['title' => 'Zero Waste Challenge', 'status' => 'Active', 'votes' => 12800],
    ];
});

$addOption = function () {
    $this->options[] = ['name' => '', 'description' => ''];
};

$removeOption = function ($index) {
    unset($this->options[$index]);
    $this->options = array_values($this->options);
};

$createProposal = function () {
    // Logic for task 7.3.3 will handle persistence
    session()->flash('admin_message', 'Proposal draft created and queued for review.');
};

?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-4xl font-black uppercase tracking-tighter text-stone-900">Governance <span class="text-stone-500">Manager</span></h1>
        <div class="bg-stone-900 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest">Admin Mode</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Proposal List -->
        <div class="lg:col-span-1 space-y-6">
            <h3 class="text-xl font-bold text-stone-900 mb-6">Existing Proposals</h3>
            @foreach($proposals as $p)
                <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-black uppercase tracking-widest text-stone-400">{{ $p['status'] }}</span>
                        <span class="text-xs font-bold text-stone-900">{{ number_format($p['votes']) }} Weight</span>
                    </div>
                    <h4 class="font-bold text-stone-800">{{ $p['title'] }}</h4>
                </div>
            @endforeach
        </div>

        <!-- Create New Proposal Form -->
        <div class="lg:col-span-2 bg-white p-10 rounded-3xl border border-stone-100 shadow-xl">
            <h3 class="text-2xl font-bold text-stone-900 mb-8">Initiate New Vote</h3>
            
            @if(session()->has('admin_message'))
                <div class="mb-8 p-4 bg-black text-white rounded-xl text-sm font-medium flex items-center gap-3">
                    <x-lucide-shield-check class="w-5 h-5 text-stone-400" />
                    {{ session('admin_message') }}
                </div>
            @endif

            <form wire:submit.prevent="createProposal" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-stone-400">Proposal Title</label>
                        <input type="text" wire:model="title" class="w-full bg-stone-50 border-stone-100 rounded-xl px-4 py-3 text-sm focus:ring-black focus:border-black" placeholder="e.g. Q4 Charity Selection">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-stone-400">Type</label>
                        <select wire:model="type" class="w-full bg-stone-50 border-stone-100 rounded-xl px-4 py-3 text-sm focus:ring-black focus:border-black">
                            <option>Charity</option>
                            <option>Challenge</option>
                            <option>Strategic</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-stone-400">Description</label>
                    <textarea wire:model="description" rows="3" class="w-full bg-stone-50 border-stone-100 rounded-xl px-4 py-3 text-sm focus:ring-black focus:border-black" placeholder="Explain the impact and goals..."></textarea>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <label class="text-[10px] font-black uppercase tracking-widest text-stone-400">Voting Options</label>
                        <button type="button" wire:click="addOption" class="text-xs font-bold text-stone-900 underline">+ Add Option</button>
                    </div>
                    
                    @foreach($options as $index => $option)
                        <div class="flex gap-4 items-start">
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 bg-stone-50 p-4 rounded-xl border border-stone-100">
                                <input type="text" wire:model="options.{{ $index }}.name" class="bg-white border-stone-100 rounded-lg px-3 py-2 text-xs" placeholder="Option Name">
                                <input type="text" wire:model="options.{{ $index }}.description" class="bg-white border-stone-100 rounded-lg px-3 py-2 text-xs" placeholder="Brief description">
                            </div>
                            @if(count($options) > 1)
                                <button type="button" wire:click="removeOption({{ $index }})" class="mt-2 text-stone-300 hover:text-red-500">
                                    <x-lucide-trash-2 class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-stone-50">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-stone-400">Quorum Threshold (Total Weight)</label>
                        <input type="number" wire:model="quorum_threshold" class="w-full bg-stone-50 border-stone-100 rounded-xl px-4 py-3 text-sm focus:ring-black focus:border-black">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-stone-400">End Date</label>
                        <input type="date" wire:model="ends_at" class="w-full bg-stone-50 border-stone-100 rounded-xl px-4 py-3 text-sm focus:ring-black focus:border-black">
                    </div>
                </div>

                <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-stone-800 transition shadow-xl">
                    Launch Proposal to Community
                </button>
            </form>
        </div>
    </div>
</div>
