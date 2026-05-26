<?php

namespace App\Console\Commands;

use App\Mail\ImpactRecap;
use App\Models\Order;
use App\Services\EmailGraphicService;
use App\Services\RegistrationTokenService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendImpactRecap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-impact-recap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send sustainability impact recap emails to guest users 24 hours after purchase.';

    /**
     * Execute the console command.
     */
    public function handle(
        RegistrationTokenService $tokenService,
        EmailGraphicService $graphicService
    ) {
        $orders = Order::whereNull('user_id')
            ->whereNull('recap_sent_at')
            ->where('created_at', '<=', Carbon::now()->subHours(24))
            ->where('created_at', '>', Carbon::now()->subHours(48)) // Avoid sending very old ones
            ->get();

        $this->info("Found {$orders->count()} orders to process.");

        foreach ($orders as $order) {
            $token = $tokenService->createToken($order->guest_session_id, $order->id);
            $waterSvg = $graphicService->generateWaterPoolSvg($order->total_water_saved);
            $carbonSvg = $graphicService->generateCarbonTreeSvg($order->total_carbon_reduced);

            Mail::to($order->shipping_address['email'])->send(
                new ImpactRecap($order, $token, $waterSvg, $carbonSvg)
            );

            $order->update(['recap_sent_at' => Carbon::now()]);
            
            $this->line("Sent recap for order #{$order->id}");
        }

        $this->info('Done!');
    }
}
