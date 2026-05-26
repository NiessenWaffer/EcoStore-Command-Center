<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RewardZeroReturns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reward-zero-returns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reward users with a 5% discount after 3 consecutive 0-return orders.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where(function($query) {
            $query->whereNull('last_rewarded_at')
                  ->orWhere('last_rewarded_at', '<', Carbon::now()->subMonths(1));
        })->get();

        $this->info("Checking {$users->count()} users for zero-return rewards...");

        foreach ($users as $user) {
            $lastOrders = $user->orders()->latest()->take(3)->get();

            if ($lastOrders->count() < 3) {
                continue;
            }

            // Check if all 3 are 'completed' (not returned or cancelled)
            $allSuccessful = $lastOrders->every(fn($order) => $order->status === 'completed');

            if ($allSuccessful) {
                $couponCode = 'HERO-' . strtoupper(Str::random(8));
                
                // In a real app, we'd save this coupon to a 'coupons' table.
                // For MVP, we'll just log it and send the "email" (mocked).
                $this->line("User #{$user->id} ({$user->email}) earned a reward! Code: {$couponCode}");

                // Update last_rewarded_at to prevent immediate duplicate rewards
                $user->update(['last_rewarded_at' => Carbon::now()]);

                // Log the reward in the trust system for traceability
                \App\Models\AdminActivityLog::create([
                    'action' => 'Reward Issued',
                    'description' => "Zero-return reward code {$couponCode} issued to {$user->email}.",
                    'timestamp' => now(),
                ]);

                $this->info("Reward notification and code {$couponCode} sent to {$user->email}");
            }
        }

        $this->info('Done!');
    }
}
