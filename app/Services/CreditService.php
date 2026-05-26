<?php

namespace App\Services;

use App\Models\ResaleTradeIn;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreditService
{
    /**
     * Verify a trade-in and release credit to the user.
     * Also grants a +200L recycling impact bonus.
     */
    public function verifyAndCredit(ResaleTradeIn $tradeIn): bool
    {
        if ($tradeIn->status !== 'pending') {
            return false;
        }

        return DB::transaction(function () use ($tradeIn) {
            $user = $tradeIn->user;

            // 1. Update user balance
            $user->increment('store_credit_cents', $tradeIn->estimated_credit_cents);

            // 2. Grant impact bonus (+200L)
            $user->increment('cumulative_water_saved', 200.00);

            // 3. Update trade-in status
            $tradeIn->update([
                'status' => 'credited',
                'verified_at' => Carbon::now(),
            ]);

            return true;
        });
    }
}
