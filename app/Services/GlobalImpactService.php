<?php

namespace App\Services;

use App\Models\Order;
use App\Models\CommunityChallenge;
use App\Models\User;
use Carbon\Carbon;

class GlobalImpactService
{
    /**
     * Update active community challenges based on a new order.
     */
    public function updateChallenges(Order $order): void
    {
        $activeChallenges = CommunityChallenge::where('is_active', true)
            ->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>=', Carbon::now())
            ->get();

        foreach ($activeChallenges as $challenge) {
            if ($challenge->metric_type === 'water') {
                $challenge->increment('current_value', $order->total_water_saved);
            } elseif ($challenge->metric_type === 'carbon') {
                $challenge->increment('current_value', $order->total_carbon_reduced);
            }
        }
    }

    /**
     * Calculate a user's contribution percentage to an active challenge.
     */
    public function getUserContribution(User $user, CommunityChallenge $challenge): float
    {
        $userImpact = $user->orders()
            ->where('created_at', '>=', $challenge->starts_at)
            ->where('created_at', '<=', $challenge->ends_at)
            ->sum($challenge->metric_type === 'water' ? 'total_water_saved' : 'total_carbon_reduced');

        if ($challenge->current_value <= 0) {
            return 0;
        }

        return round(($userImpact / $challenge->current_value) * 100, 2);
    }

    /**
     * Get aggregate impact totals for the entire community.
     */
    public function getGlobalTotals(): array
    {
        return [
            'water' => Order::where('payment_status', 'paid')->sum('total_water_saved'),
            'carbon' => Order::where('payment_status', 'paid')->sum('total_carbon_reduced'),
        ];
    }
}
