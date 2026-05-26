<?php

use function Livewire\Volt\{state, rules};

state(['token' => '', 'isClaiming' => false, 'claimed' => false]);

rules(['token' => 'required|min:4']);

$claim = function () {
    $this->validate();
    $this->isClaiming = true;
    
    // Mock backend delay
    sleep(1.5);
    
    $this->claimed = true;
    $this->isClaiming = false;
};

?>

<div>
    @if(!$claimed)
        <div class="space-y-4">
            <div>
                <label for="token" class="block text-xs font-bold uppercase text-stone-400 mb-2">Transfer Token</label>
                <input 
                    wire:model="token" 
                    type="text" 
                    id="token" 
                    placeholder="e.g. XF-A1B2C3D4"
                    class="w-full bg-stone-800 border-stone-700 text-white rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 transition-all outline-none placeholder-stone-600"
                >
                @error('token') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <button 
                wire:click="claim" 
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-blue-500 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
            >
                <x-lucide-loader-2 wire:loading class="w-5 h-5 animate-spin" />
                <span wire:loading.remove>Verify & Accept Ownership</span>
                <span wire:loading>Processing Claim...</span>
            </button>
        </div>
    @else
        <div class="text-center py-4 animate-bounce">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500 rounded-full mb-4 shadow-lg shadow-green-500/20">
                <x-lucide-check class="w-8 h-8 text-white" />
            </div>
            <h4 class="text-xl font-bold">Ownership Secured!</h4>
            <p class="text-stone-400 text-sm mt-1">This passport is now linked to your account.</p>
            
            <a href="{{ route('dashboard') }}" class="inline-block mt-6 text-blue-400 hover:text-blue-300 text-sm font-bold border-b border-blue-400 pb-1">
                Go to My Assets
            </a>
        </div>
    @endif
</div>
