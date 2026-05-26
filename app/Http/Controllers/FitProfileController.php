<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FitProfileController extends Controller
{
    /**
     * Show the fit profile wizard.
     */
    public function showWizard()
    {
        $user = Auth::user();
        return view('fit.wizard', compact('user'));
    }

    /**
     * Store the fit profile data.
     */
    public function store(Request $request)
    {
        $request->validate([
            'height_cm' => 'required|integer|min:50|max:250',
            'weight_kg' => 'required|integer|min:20|max:300',
            'fit_preference' => 'required|in:Slim,Regular,Loose',
        ]);

        $user = Auth::user();
        $user->update([
            'height_cm' => $request->height_cm,
            'weight_kg' => $request->weight_kg,
            'fit_preference' => $request->fit_preference,
        ]);

        return redirect()->route('shop')->with('success', 'Fit profile updated! Our AI will now prioritize your perfect sizes.');
    }
}
