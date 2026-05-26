<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ResaleTradeIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResaleController extends Controller
{
    public function index()
    {
        $tradeIns = Auth::user()->resaleTradeIns()->latest()->get();
        return view('resale.index', compact('tradeIns'));
    }

    public function create()
    {
        // Get all products the user has previously purchased and completed
        $purchasedProductIds = Auth::user()->orders()
            ->where('status', 'completed')
            ->with('items')
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product_id')
            ->unique();

        $products = Product::whereIn('id', $purchasedProductIds)->get();

        return view('resale.submit', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'condition' => 'required|in:Poor,Good,Excellent,Never Worn',
            'condition_notes' => 'nullable|string|max:1000',
        ]);

        // Find the original order for this product
        $order = Auth::user()->orders()
            ->where('status', 'completed')
            ->whereHas('items', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->firstOrFail();

        $product = Product::find($request->product_id);

        // Simple estimation logic: 30% of original price for "Excellent", etc.
        $multipliers = [
            'Never Worn' => 0.4,
            'Excellent' => 0.3,
            'Good' => 0.2,
            'Poor' => 0.1,
        ];
        
        $estimatedCredit = round($product->price_cents * $multipliers[$request->condition]);

        ResaleTradeIn::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'condition' => $request->condition,
            'condition_notes' => $request->condition_notes,
            'estimated_credit_cents' => $estimatedCredit,
            'status' => 'pending',
        ]);

        return redirect()->route('resale.index')->with('success', 'Trade-in request submitted! Our team will verify it within 48 hours.');
    }
}
