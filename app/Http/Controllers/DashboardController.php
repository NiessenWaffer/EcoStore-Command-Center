<?php

namespace App\Http\Controllers;

use App\Models\CommunityChallenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['items.product', 'items.variant'])->latest()->get();

        return view('dashboard.index', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    /**
     * Show the ambassador portal.
     */
    public function ambassador()
    {
        $user = Auth::user();
        $challenges = CommunityChallenge::where('is_active', true)->get();

        return view('dashboard.ambassador', [
            'user' => $user,
            'challenges' => $challenges,
        ]);
    }
}
