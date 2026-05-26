<?php

namespace App\Http\Controllers;

use App\Models\ProductPassport;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    /**
     * Display the specified product passport.
     */
    public function show($token)
    {
        $passport = ProductPassport::where('qr_token', $token)
            ->with(['product', 'originFactory'])
            ->firstOrFail();

        return view('passports.show', [
            'passport' => $passport,
            'product' => $passport->product,
            'factory' => $passport->originFactory,
        ]);
    }
}
