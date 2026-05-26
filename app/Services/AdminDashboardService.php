<?php

namespace App\Services;

use App\Models\User;
use App\Models\ProductPassport;
use App\Models\GovernanceProposal;
use App\Models\PassportAuditLog;
use Illuminate\Support\Facades\Cache;

class AdminDashboardService
{
    /**
     * Get global sustainability impact statistics.
     */
    public function getGlobalImpactStats(): array
    {
        $callback = function () {
            return [
                'water_saved' => User::sum('cumulative_water_saved'),
                'carbon_reduced' => User::sum('cumulative_carbon_reduced'),
            ];
        };

        if (app()->environment('testing')) {
            return $callback();
        }

        return Cache::remember('admin_impact_stats', 3600, $callback);
    }

    /**
     * Get current system integrity and trust status.
     */
    public function getSystemIntegrityStats(): array
    {
        $callback = function () {
            $totalPassports = ProductPassport::count();
            $tamperedCount = ProductPassport::where('is_verified', false)->count();
            $pendingCorrections = GovernanceProposal::where('type', 'Correction')
                ->where('status', 'Active')
                ->count();

            return [
                'total_passports' => $totalPassports,
                'tampered_count' => $tamperedCount,
                'pending_corrections' => $pendingCorrections,
                'health_percentage' => $totalPassports > 0 
                    ? round((($totalPassports - $tamperedCount) / $totalPassports) * 100) 
                    : 100,
            ];
        };

        if (app()->environment('testing')) {
            return $callback();
        }

        return Cache::remember('admin_integrity_stats', 600, $callback);
    }

    /**
     * Get active governance summary.
     */
    public function getActiveGovernanceSummary(): ?array
    {
        $callback = function () {
            $activeProposal = GovernanceProposal::where('status', 'Active')
                ->orderBy('ends_at', 'asc')
                ->first();

            if (!$activeProposal) {
                return null;
            }

            // Live Quorum Calculation: Sum of resultant_influence from all votes cast
            $totalInfluenceCast = \App\Models\GovernanceVote::where('proposal_id', $activeProposal->id)
                ->sum('resultant_influence');

            $quorumProgress = $activeProposal->quorum_threshold > 0 
                ? round(($totalInfluenceCast / $activeProposal->quorum_threshold) * 100)
                : 0;

            return [
                'title' => $activeProposal->title,
                'quorum_progress' => (int) min($quorumProgress, 100),
                'total_influence' => $totalInfluenceCast,
                'ends_at' => $activeProposal->ends_at,
            ];
        };

        if (app()->environment('testing')) {
            return $callback();
        }

        return Cache::remember('admin_active_governance', 300, $callback);
    }
}
