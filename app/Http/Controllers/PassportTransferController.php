<?php

namespace App\Http\Controllers;

use App\Models\ProductPassport;
use Illuminate\Http\Request;

class PassportTransferController extends Controller
{
    /**
     * Show the claim page for a specific token.
     */
    public function showClaim(string $token)
    {
        $transfer = \App\Models\PassportTransfer::where('transfer_token', $token)
            ->where('status', 'pending')
            ->firstOrFail();
        
        return view('passports.claim', [
            'token' => $token,
            'passport' => $transfer->passport,
            'transfer' => $transfer,
        ]);
    }
}
