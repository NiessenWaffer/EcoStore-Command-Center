<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CarbonCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    /**
     * Show the carbon impact deterrent page before confirming a return.
     */
    public function showDeterrent(Request $request, CarbonCalculator $calculator)
    {
        $itemIds = $request->input('items', []);
        if (empty($itemIds)) {
            return redirect()->back()->with('error', 'Please select items to return.');
        }

        $items = OrderItem::whereIn('id', $itemIds)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['product', 'variant'])
            ->get();

        $carbonCost = $calculator->calculateTotalReturnCarbon($itemIds);

        return view('returns.deterrent', [
            'items' => $items,
            'carbonCost' => $carbonCost,
            'itemIds' => $itemIds,
        ]);
    }

    /**
     * Process the actual return (Stub for MVP).
     */
    public function store(Request $request)
    {
        // In a real app, we'd create a ReturnRequest record and trigger logistics.
        // For MVP, we'll just acknowledge the mission-driven choice if they proceed.
        return redirect()->route('dashboard')->with('success', 'Return request received. We are working on a carbon-neutral pickup for you.');
    }
}
