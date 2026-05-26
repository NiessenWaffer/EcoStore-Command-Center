<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegistrationTokenService
{
    /**
     * Create a secure registration token for a guest session or order.
     */
    public function createToken(?string $guestSessionId = null, ?int $orderId = null, int $expiryHours = 24): string
    {
        $token = Str::random(64);

        DB::table('registration_tokens')->insert([
            'token' => $token,
            'guest_session_id' => $guestSessionId,
            'order_id' => $orderId,
            'expires_at' => Carbon::now()->addHours($expiryHours),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $token;
    }

    /**
     * Validate a token and return the guest data if valid.
     */
    public function validateToken(string $token): ?object
    {
        $record = DB::table('registration_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        return $record;
    }

    /**
     * Merge guest impact data into a newly registered user.
     */
    public function mergeGuestData(User $user, string $token): bool
    {
        $tokenRecord = $this->validateToken($token);

        if (!$tokenRecord) {
            return false;
        }

        return DB::transaction(function () use ($user, $tokenRecord) {
            $query = Order::whereNull('user_id');

            if ($tokenRecord->order_id) {
                $query->where('id', $tokenRecord->order_id);
            } elseif ($tokenRecord->guest_session_id) {
                $query->where('guest_session_id', $tokenRecord->guest_session_id);
            } else {
                return false;
            }

            $orders = $query->get();

            if ($orders->isEmpty()) {
                return false;
            }

            $totalWater = 0;
            $totalCarbon = 0;

            foreach ($orders as $order) {
                $order->update(['user_id' => $user->id]);
                $totalWater += $order->total_water_saved;
                $totalCarbon += $order->total_carbon_reduced;
            }

            $user->increment('cumulative_water_saved', $totalWater);
            $user->increment('cumulative_carbon_reduced', $totalCarbon);

            // Delete the token after successful merge
            DB::table('registration_tokens')->where('token', $tokenRecord->token)->delete();

            return true;
        });
    }
}
