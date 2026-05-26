<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class FraudDetectionService
{
    /**
     * Check if the current request is likely a self-referral.
     */
    public function isSelfReferral(Request $request, string $referrerIp): bool
    {
        // IP match check
        if ($request->ip() === $referrerIp) {
            return true;
        }

        // Fingerprint check (simple cookie-based for now)
        $fingerprint = $request->cookie('device_fingerprint');
        $referrerFingerprint = session('referrer_fingerprint'); // Hypothetical, set when referrer visits

        if ($fingerprint && $referrerFingerprint && $fingerprint === $referrerFingerprint) {
            return true;
        }

        return false;
    }

    /**
     * Ensure a device fingerprint exists.
     */
    public function ensureFingerprint(Request $request): void
    {
        if (!$request->hasCookie('device_fingerprint')) {
            Cookie::queue('device_fingerprint', Str::uuid()->toString(), 60 * 24 * 365);
        }
    }
}
