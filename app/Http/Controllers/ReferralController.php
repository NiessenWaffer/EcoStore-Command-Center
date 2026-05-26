<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReferralController extends Controller
{
    /**
     * Show the Mission Landing Page for an invited friend.
     */
    public function missionPage($referral_code)
    {
        $referrer = User::where('referral_code', $referral_code)->firstOrFail();
        
        // Store referral code in session for later attribution
        Session::put('active_referral_code', $referral_code);

        return view('referral.mission_page', [
            'referrer' => $referrer,
        ]);
    }

    /**
     * Return a QR code URL for a given referral link.
     */
    public function getQrCodeUrl($url)
    {
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($url);
    }
}
