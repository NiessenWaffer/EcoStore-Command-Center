<?php

namespace App\Services;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $sessionKey = 'shopping_cart';
    protected SustainabilityImpactService $impactService;

    public function __construct(SustainabilityImpactService $impactService)
    {
        $this->impactService = $impactService;
    }

    public function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    public function add(int $variantId, int $quantity = 1, string $purchaseMode = 'buy'): void
    {
        $cart = $this->getCart();
        $cartKey = $variantId . '_' . $purchaseMode;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $variant = ProductVariant::with('product')->findOrFail($variantId);
            
            // Lease price is 10% of the full price per month
            $priceCents = $purchaseMode === 'lease' 
                ? (int) ceil($variant->product->price_cents * 0.10) 
                : $variant->product->price_cents;

            $cart[$cartKey] = [
                'id' => $variantId,
                'cart_key' => $cartKey,
                'product_id' => $variant->product_id,
                'name' => $variant->product->name,
                'size' => $variant->size,
                'color' => $variant->color,
                'price_cents' => $priceCents,
                'purchase_mode' => $purchaseMode,
                'quantity' => $quantity,
                'image_url' => $variant->product->image_url,
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    public function remove(string $cartKey): void
    {
        $cart = $this->getCart();
        unset($cart[$cartKey]);
        Session::put($this->sessionKey, $cart);
    }

    public function updateQuantity(string $cartKey, int $quantity): void
    {
        $cart = $this->getCart();
        if ($quantity <= 0) {
            $this->remove($cartKey);
            return;
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $quantity;
            Session::put($this->sessionKey, $cart);
        }
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    public function getTotals(): array
    {
        $cart = $this->getCart();
        $totalCents = 0;
        $totalWater = 0;
        $totalCarbon = 0;

        foreach ($cart as $cartKey => $item) {
            $variant = ProductVariant::find($item['id']);
            if ($variant) {
                $impact = $this->impactService->calculateVariantImpact($variant);
                $totalCents += $item['price_cents'] * $item['quantity'];
                $totalWater += $impact['water_saved'] * $item['quantity'];
                $totalCarbon += $impact['carbon_reduced'] * $item['quantity'];
            }
        }

        return [
            'total_cents' => $totalCents,
            'total_water' => round($totalWater, 2),
            'total_carbon' => round($totalCarbon, 2),
            'total_items' => array_sum(array_column($cart, 'quantity')),
        ];
    }
}
