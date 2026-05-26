<?php

use function Livewire\Volt\{state, mount};
use App\Services\AdminDashboardService;
use App\Models\GovernanceProposal;
use App\Models\ProductPassport;

state(['alerts' => []]);

mount(function (AdminDashboardService $service) {
    $integrity = $service->getSystemIntegrityStats();
    
    $alerts = [];

    // 1. Pending Corrections (Urgent)
    $pendingCorrections = GovernanceProposal::where('type', 'Correction')
        ->where('status', 'Active')
        ->get();

    foreach ($pendingCorrections as $proposal) {
        $alerts[] = [
            'id' => 'corr-' . $proposal->id,
            'type' => 'correction_required',
            'title' => 'Pending Multi-Sig Correction',
            'description' => $proposal->title . ' requires review and a second signature.',
            'status' => 'urgent',
            'url' => route('admin.corrections.index'),
        ];
    }

    // 2. Tampered Passports (Urgent)
    $tampered = ProductPassport::where('is_verified', false)->take(5)->get();
    foreach ($tampered as $passport) {
        $alerts[] = [
            'id' => 'tamper-' . $passport->id,
            'type' => 'integrity_failure',
            'title' => 'Integrity Failure Detected',
            'description' => 'Passport Batch #' . $passport->batch_number . ' failed chain verification.',
            'status' => 'urgent',
            'url' => route('passports.verify', $passport->id), // Needs frontend route or admin detail
        ];
    }

    // 3. System Success (If no urgent alerts)
    if (empty($alerts)) {
        $alerts[] = [
            'id' => 'sys-ok',
            'type' => 'integrity_check',
            'title' => 'Ecosystem Integrity Stable',
            'description' => '100% of product passports verified successfully in the last scan.',
            'status' => 'success',
            'url' => '#',
        ];
    }

    $this->alerts = $alerts;
});

?>

<div class="space-y-4">
    @forelse($alerts as $alert)
        <div class="flex items-start gap-4 p-6 bg-white rounded-2xl border {{ $alert['status'] === 'urgent' ? 'border-amber-100 bg-amber-50/30' : 'border-stone-100' }} shadow-sm">
            <div class="p-2 {{ $alert['status'] === 'urgent' ? 'bg-amber-100' : 'bg-green-100' }} rounded-xl mt-1">
                @if($alert['status'] === 'urgent')
                    <x-lucide-shield-alert class="w-4 h-4 text-amber-600" />
                @else
                    <x-lucide-check-circle class="w-4 h-4 text-green-600" />
                @endif
            </div>
            
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                    <h4 class="text-sm font-bold text-stone-900">{{ $alert['title'] }}</h4>
                    <span class="text-[10px] font-black uppercase tracking-widest {{ $alert['status'] === 'urgent' ? 'text-amber-600' : 'text-green-600' }}">
                        {{ $alert['status'] }}
                    </span>
                </div>
                <p class="text-xs text-stone-500 leading-relaxed mb-4">{{ $alert['description'] }}</p>
                <a href="{{ $alert['url'] }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-stone-900 border-b border-black pb-0.5 hover:text-stone-600 transition">
                    Resolve Alert
                    <x-lucide-chevron-right class="w-3 h-3" />
                </a>
            </div>
        </div>
    @empty
        <div class="p-12 text-center bg-stone-50 rounded-2xl border border-dashed border-stone-200">
            <x-lucide-shield-check class="w-12 h-12 text-stone-200 mx-auto mb-4" />
            <p class="text-stone-400 text-sm">No critical alerts detected. System integrity is stable.</p>
        </div>
    @endforelse
</div>
