<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocalHub;
use App\Models\ResaleTradeIn;
use App\Services\CreditService;
use Illuminate\Http\Request;

class HubInventoryController extends Controller
{
    /**
     * List all local hubs for administration.
     */
    public function adminIndex()
    {
        $hubs = LocalHub::all();
        return view('admin.hub.index', compact('hubs'));
    }

    /**
     * Show the local hub management dashboard.
     */
    public function index(LocalHub $hub)
    {
        // Get trade-ins assigned to this hub for verification
        $pendingTradeIns = ResaleTradeIn::where('status', 'pending')->latest()->get();

        return view('admin.hub.manage', [
            'hub' => $hub,
            'pendingTradeIns' => $pendingTradeIns,
        ]);
    }

    /**
     * Verify a trade-in locally at the hub.
     */
    public function verifyReturn(Request $request, ResaleTradeIn $tradeIn, CreditService $creditService)
    {
        $success = $creditService->verifyAndCredit($tradeIn);

        if ($success) {
            return redirect()->back()->with('success', 'Item verified and credited! It is now listed in the local Pre-loved section.');
        }

        return redirect()->back()->with('error', 'Could not verify item.');
    }
}
