<?php

namespace App\Services;

use App\Models\User;
use App\Models\GovernanceProposal;
use App\Models\GovernanceVote;
use App\Models\CommunityChallenge;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GovernanceService
{
    /**
     * Calculate user's voting weight.
     * Logic: Floor(Cumulative Water Saved / 100)
     */
    public function calculateUserPower(User $user): int
    {
        return (int) floor($user->cumulative_water_saved / 100);
    }

    /**
     * Calculate quadratic influence for a given weight cost.
     * Formula: sqrt(cost)
     */
    public function calculateQuadraticInfluence(int $cost): float
    {
        return round(sqrt(max(0, $cost)), 2);
    }

    /**
     * Cast a weighted vote using the Quadratic model.
     */
    public function castQuadraticVote(User $user, GovernanceProposal $proposal, array $allocations): GovernanceVote
    {
        $userPower = $this->calculateUserPower($user);
        $totalCostRequested = array_sum($allocations);

        if ($totalCostRequested > $userPower) {
            throw new \Exception("Insufficient governance power.");
        }

        if ($proposal->status !== 'Active' || now()->isAfter($proposal->ends_at)) {
            throw new \Exception("Voting is closed for this proposal.");
        }

        return DB::transaction(function () use ($user, $proposal, $allocations, $totalCostRequested) {
            $user->governanceVotes()->where('proposal_id', $proposal->id)->delete();

            // Calculate resultant influence for each allocation
            $quadraticAllocations = [];
            $totalInfluence = 0;

            foreach ($allocations as $optionId => $cost) {
                $influence = $this->calculateQuadraticInfluence($cost);
                $quadraticAllocations[$optionId] = [
                    'cost' => $cost,
                    'influence' => $influence
                ];
                $totalInfluence += $influence;
            }

            $vote = $user->governanceVotes()->create([
                'proposal_id' => $proposal->id,
                'allocations' => $quadraticAllocations,
                'weight_cast' => $totalCostRequested, // Using cost as weight_cast for legacy compatibility
                'weighted_cost' => $totalCostRequested,
                'resultant_influence' => $totalInfluence,
                'created_at' => now(),
            ]);

            $proposal->update([
                'total_weight_cast' => $proposal->total_weight_cast + $totalInfluence
            ]);

            return $vote;
        });
    }

    /**
     * Transition a successful proposal to a CommunityChallenge.
     */
    public function evaluateAndExecute(GovernanceProposal $proposal): bool
    {
        if ($proposal->status !== 'Active') {
            return false;
        }

        return DB::transaction(function () use ($proposal) {
            if ($proposal->total_weight_cast < $proposal->quorum_threshold) {
                $proposal->update(['status' => 'Failed']);
                return false;
            }

            // Determine winning option
            $results = $this->calculateResults($proposal);
            $winner = collect($results)->sortByDesc('votes')->first();

            if ($proposal->type === 'Challenge') {
                CommunityChallenge::create([
                    'title' => $proposal->title . ": " . $winner['name'],
                    'metric_type' => 'Water Saved', // Default for now
                    'target_value' => 50000, // Sample target
                    'current_value' => 0,
                    'donation_amount_cents' => 100000, // $1000
                    'charity_name' => $winner['name'],
                    'starts_at' => now(),
                    'ends_at' => now()->addMonth(),
                    'is_active' => true,
                ]);
            }

            $proposal->update(['status' => 'Executed']);
            return true;
        });
    }

    /**
     * Calculate weight distribution for a proposal.
     */
    public function calculateResults(GovernanceProposal $proposal): array
    {
        $votes = $proposal->votes;
        $tally = [];

        foreach ($proposal->options as $option) {
            $tally[$option['id']] = [
                'name' => $option['name'],
                'votes' => 0
            ];
        }

        foreach ($votes as $vote) {
            foreach ($vote->allocations as $optionId => $weight) {
                if (isset($tally[$optionId])) {
                    $tally[$optionId]['votes'] += $weight;
                }
            }
        }

        return $tally;
    }
}
