<?php

use function Livewire\Volt\{state, mount};
use App\Models\ProductPassport;

state(['passport' => null, 'isInitiating' => false, 'transferToken' => null, 'expiresAt' => null]);

mount(function (ProductPassport $passport) {
    $this->passport = $passport;
});

$initiateTransfer = function () {
    $this->isInitiating = true;
    
    // Mocking the backend call for now (Phase 1: Frontend First)
    sleep(1); 
    
    $this->transferToken = 'XF-' . strtoupper(Str::random(8));
    $this->expiresAt = now()->addHours(48)->format('M d, Y H:i');
    $this->isInitiating = false;
};

?>

<div class="bg-white p-8 rounded-2xl border border-stone-100 shadow-sm">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 bg-stone-100 rounded-lg">
            <x-lucide-share-2 class="w-5 h-5 text-stone-600" />
        </div>
        <h3 class="text-lg font-bold text-stone-900">Ownership Transfer</h3>
    </div>

    @if(!$transferToken)
        <p class="text-stone-500 text-sm mb-6">
            Ready to pass this item on? Generate a secure transfer token to officially move the Digital Passport to the new owner.
        </p>
        
        <button 
            wire:click="initiateTransfer" 
            wire:loading.attr="disabled"
            class="w-full bg-stone-900 text-white py-3 rounded-xl font-bold hover:bg-stone-800 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
        >
            <x-lucide-refresh-cw wire:loading class="w-4 h-4 animate-spin" />
            <span wire:loading.remove>Initiate Transfer</span>
            <span wire:loading>Preparing Token...</span>
        </button>
    @else
        <div class="space-y-4">
            <div class="p-4 bg-green-50 border border-green-100 rounded-xl">
                <p class="text-[10px] font-bold uppercase text-green-600 mb-1">Secure Transfer Token</p>
                <p class="text-2xl font-mono font-black text-green-900 tracking-wider">{{ $transferToken }}</p>
            </div>
            
            <div class="text-sm text-stone-500">
                <p class="flex items-center gap-2 mb-2">
                    <x-lucide-clock class="w-4 h-4" />
                    Expires: <span class="font-bold">{{ $expiresAt }}</span>
                </p>
                <p class="bg-stone-50 p-3 rounded-lg border border-stone-100 italic">
                    Share this token with the buyer. They can claim ownership at <strong>/claim</strong>
                </p>
            </div>

            <div class="flex gap-2">
                <button class="flex-1 bg-stone-100 text-stone-600 py-2 rounded-lg text-sm font-bold hover:bg-stone-200 transition">
                    Copy Link
                </button>
                <button wire:click="$set('transferToken', null)" class="text-stone-400 hover:text-stone-600 p-2">
                    <x-lucide-x class="w-5 h-5" />
                </button>
            </div>
        </div>
    @endif
</div>
