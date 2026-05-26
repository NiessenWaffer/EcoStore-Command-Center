<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GovernanceProposal;
use App\Services\GovernanceService;

class EvaluateProposals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:evaluate-proposals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically close expired governance proposals and execute winners.';

    /**
     * Execute the console command.
     */
    public function handle(GovernanceService $service)
    {
        $expiredProposals = GovernanceProposal::where('status', 'Active')
            ->where('ends_at', '<', now())
            ->get();

        if ($expiredProposals->isEmpty()) {
            $this->info("No active proposals have expired.");
            return;
        }

        foreach ($expiredProposals as $proposal) {
            $this->info("Evaluating proposal: {$proposal->title}");
            $executed = $service->evaluateAndExecute($proposal);
            
            if ($executed) {
                $this->info("Result: Executed successfully.");
            } else {
                $this->warn("Result: Failed (Quorum not met).");
            }
        }
    }
}
