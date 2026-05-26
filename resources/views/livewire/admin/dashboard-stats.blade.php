<?php

use function Livewire\Volt\{state, mount};
use App\Services\AdminDashboardService;

state(['waterSaved' => '0 L', 'carbonReduced' => '0 kg', 'quorum' => '0%', 'health' => '100%']);

mount(function (AdminDashboardService $service) {
    $impact = $service->getGlobalImpactStats();
    $integrity = $service->getSystemIntegrityStats();
    $governance = $service->getActiveGovernanceSummary();

    $this->waterSaved = number_format($impact['water_saved']) . ' L';
    $this->carbonReduced = number_format($impact['carbon_reduced']) . ' kg';
    $this->quorum = $governance ? $governance['quorum_progress'] . '%' : 'N/A';
    $this->health = $integrity['health_percentage'] . '%';
});

?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <livewire:admin.kpi-card 
        label="Community Water Saved" 
        :value="$waterSaved" 
        icon="droplets" 
        color="blue" 
    />
    <livewire:admin.kpi-card 
        label="Carbon Reduced" 
        :value="$carbonReduced" 
        icon="cloud" 
        color="stone" 
    />
    <livewire:admin.kpi-card 
        label="Governance Quorum" 
        :value="$quorum" 
        icon="vote" 
        :trend="$quorum !== 'N/A' ? 'Live' : null"
        color="green" 
    />
    <livewire:admin.kpi-card 
        label="System Health" 
        :value="$health" 
        icon="shield-check" 
        trend="Verified" 
        color="emerald" 
    />
</div>
