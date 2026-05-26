<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Services\CartService;
use App\Services\SustainabilityImpactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use App\Services\RegistrationTokenService;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected SustainabilityImpactService $impactService;
    protected RegistrationTokenService $tokenService;

    public function __construct(
        CartService $cartService, 
        SustainabilityImpactService $impactService,
        RegistrationTokenService $tokenService
    ) {
        $this->cartService = $cartService;
        $this->impactService = $impactService;
        $this->tokenService = $tokenService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $totals = $this->cartService->getTotals();

        return view('shop.checkout', [
            'cart' => $cart,
            'totals' => $totals,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
        ]);

        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $totals = $this->cartService->getTotals();

        $lineItems = [];
        $hasLeases = false;
        foreach ($cart as $cartKey => $item) {
            $isLease = ($item['purchase_mode'] ?? 'buy') === 'lease';
            if ($isLease) $hasLeases = true;
            
            $lineItems[] = [
                'price_data' => [
                    'currency' => config('cashier.currency'),
                    'product_data' => [
                        'name' => $item['name'] . ' (' . $item['size'] . ' / ' . $item['color'] . ')' . ($isLease ? ' [Monthly Lease]' : ''),
                    ],
                    'unit_amount' => $item['price_cents'],
                    'recurring' => $isLease ? ['interval' => 'month'] : null,
                ],
                'quantity' => $item['quantity'],
            ];
            
            // Remove recurring key if null to prevent Stripe errors
            if (!$isLease) {
                unset($lineItems[array_key_last($lineItems)]['price_data']['recurring']);
            }
        }

        $shippingAddress = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ];

        Stripe::setApiKey(config('cashier.secret'));

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => $hasLeases ? 'subscription' : 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'customer_email' => Auth::check() ? Auth::user()->email : $request->email,
            'metadata' => [
                'shipping_address' => json_encode($shippingAddress),
                'user_id' => Auth::id() ?? null,
                'guest_session_id' => session()->getId(),
            ],
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('shop');
        }

        Stripe::setApiKey(config('cashier.secret'));
        $session = StripeSession::retrieve($sessionId);

        // Check if order already exists for this payment intent
        $existingOrder = Order::where('stripe_payment_intent_id', $session->payment_intent)->first();
        if ($existingOrder) {
            return view('shop.success', ['order' => $existingOrder]);
        }

        return DB::transaction(function () use ($session) {
            $totals = $this->cartService->getTotals();
            $cart = $this->cartService->getCart();

            $order = Order::create([
                'user_id' => $session->metadata->user_id ?? null,
                'guest_session_id' => $session->metadata->guest_session_id ?? null,
                'total_cents' => $session->amount_total,
                'status' => 'completed',
                'payment_status' => 'paid',
                'stripe_payment_intent_id' => $session->payment_intent,
                'total_water_saved' => $totals['total_water'] + (session('green_bonus_active') ? 50 : 0),
                'total_carbon_reduced' => $totals['total_carbon'],
                'shipping_address' => json_decode($session->metadata->shipping_address, true),
                'is_carbon_neutral_shipping' => true,
                'shipping_method' => session('selected_shipping_method', 'standard'),
                'local_hub_id' => session('selected_hub_id'),
            ]);

            foreach ($cart as $cartKey => $item) {
                $variant = ProductVariant::find($item['id']);
                $impact = $this->impactService->calculateVariantImpact($variant);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price_at_purchase_cents' => $item['price_cents'],
                    'water_saved_at_purchase' => $impact['water_saved'],
                    'carbon_reduced_at_purchase' => $impact['carbon_reduced'],
                ]);
                
                if (($item['purchase_mode'] ?? 'buy') === 'lease') {
                    for ($i = 0; $i < $item['quantity']; $i++) {
                        LeaseSubscription::create([
                            'user_id' => $order->user_id,
                            'product_variant_id' => $item['id'],
                            'hub_id' => $order->local_hub_id,
                            'status' => 'active',
                            'start_date' => now(),
                            'next_billing_date' => now()->addMonth(),
                        ]);
                    }
                }
            }

            // If authenticated, update cumulative impact
            if ($order->user_id) {
                $user = \App\Models\User::find($order->user_id);
                $user->increment('cumulative_water_saved', $order->total_water_saved);
                $user->increment('cumulative_carbon_reduced', $order->total_carbon_reduced);
            }

            // Send confirmation email
            Mail::to($order->shipping_address['email'])->send(new OrderConfirmed($order));

            $this->cartService->clear();

            $registrationToken = null;
            if (!$order->user_id) {
                $registrationToken = $this->tokenService->createToken(
                    $order->guest_session_id,
                    $order->id
                );
            }

            return view('shop.success', [
                'order' => $order,
                'registrationToken' => $registrationToken,
            ]);
        });
    }

    public function cancel()
    {
        return redirect()->route('shop')->with('error', 'Payment was cancelled.');
    }
}  
 