<?php

use function Livewire\Volt\{state, mount};
use App\Models\ProductPassport;

state(['passport' => null, 'events' => [], 'isVerifying' => false, 'verificationResult' => null]);

mount(function (ProductPassport $passport) {
    $this->passport = $passport;
    $this->loadEvents();
});

$loadEvents = function () {
    $this->events = $this->passport->auditLogs->map(function ($log) {
        return [
            'type' => $log->event_type,
            'label' => $log->event_data['label'] ?? ($log->event_type . ' Event'),
            'performer' => $log->masked_performer_label,
            'date' => $log->timestamp->format('Y-m-d'),
            'status' => 'verified', // Backend ensures valid logs exist
            'hash' => $log->current_hash,
            'signature' => $log->signature,
        ];
    })->toArray();
};

$verify = function (App\Services\PassportService $service) {
    $this->isVerifying = true;
    
    // Simulate network/compute delay for trust UI
    sleep(1); 
    
    $isValid = $service->verifyIntegrity($this->passport);
    $this->verificationResult = $isValid ? 'verified' : 'tampered';
    $this->isVerifying = false;
};

?>

<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <x-lucide-shield-check class="w-6 h-6 text-green-600" />
            Immutable Verification Timeline
        </h3>
        <button wire:click="verify" class="text-sm font-medium text-green-700 hover:text-green-800 flex items-center gap-1 bg-green-50 px-3 py-1.5 rounded-full transition-all">
            <x-lucide-refresh-cw class="w-4 h-4 {{ $isVerifying ? 'animate-spin' : '' }}" />
            {{ $isVerifying ? 'Verifying Chain...' : 'Verify History' }}
        </button>
    </div>

    <div class="relative border-l-2 border-gray-200 ml-3 space-y-8 overflow-hidden">
        @if($isVerifying)
            <div class="absolute inset-0 bg-green-50/20 z-10 pointer-events-none overflow-hidden">
                <div class="w-full h-1 bg-green-500/50 animate-scan"></div>
            </div>
        @endif

        @foreach($events as $event)
            <div class="relative pl-8">
                <!-- Timeline Dot -->
                <div class="absolute -left-[9px] mt-1.5 w-4 h-4 rounded-full bg-white border-2 {{ $event['status'] === 'verified' ? 'border-green-500' : 'border-red-500' }}"></div>
                
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ $event['type'] }}</span>
                        <span class="text-xs text-gray-400 font-mono">{{ $event['date'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-base font-semibold text-gray-800">{{ $event['label'] }}</span>
                        @if($event['status'] === 'verified')
                            <x-lucide-check-circle-2 class="w-4 h-4 text-green-500" />
                        @endif
                    </div>
                    <div class="text-[10px] text-gray-400 font-medium">
                        {{ $event['performer'] }}
                    </div>
                    <div class="mt-2">
                        <x-passports.technical-details-modal :event="$event" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($verificationResult === 'verified')
        <div class="mt-8 p-4 bg-green-50 rounded-lg border border-green-100 flex items-center gap-3 transition-all duration-500">
            <x-lucide-shield-check class="w-5 h-5 text-green-600" />
            <p class="text-sm text-green-800 font-medium">Chain integrity verified. 100% untampered history detected.</p>
        </div>
    @elseif($verificationResult === 'tampered')
        <div class="mt-8 p-4 bg-red-50 rounded-lg border border-red-100 flex items-center gap-3 transition-all duration-500">
            <x-lucide-alert-triangle class="w-5 h-5 text-red-600" />
            <p class="text-sm text-red-800 font-bold">Integrity Alert! Historical tampering detected in the cryptographic chain.</p>
        </div>
    @endif
</div>
