<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIShstylistService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openai.key') ?? '';
        $this->model = config('services.openai.model') ?? 'gpt-4o';
    }

    /**
     * Get a styling recommendation based on user message and profile.
     */
    public function getRecommendation(string $message, ?User $user = null): string
    {
        if (empty($this->apiKey)) {
            return $this->getMockResponse($message);
        }

        $context = $this->prepareContext($user);
        $products = $this->getProductContext();

        try {
            $response = Http::withToken($this->apiKey)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "You are the EcoStore AI Sustainability Concierge. Your mission is to help users build a sustainable, minimalist wardrobe.
                            
                            PRIORITY RULES:
                            1. Always bias recommendations toward 'Regenerative' (Index 90+) and 'Circular Prime' (Index 70+) products.
                            2. Use the user's fit profile (height/weight/preference) to suggest the best size.
                            3. Explain WHY a product is sustainable (e.g., water saved, organic materials).
                            4. Be helpful, authoritative, and minimalist in your tone.
                            5. If suggesting products, use their specific names and prices.
                            
                            USER CONTEXT:
                            {$context}
                            
                            AVAILABLE PRODUCTS:
                            {$products}"
                        ],
                        ['role' => 'user', 'content' => $message],
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }

            Log::error('OpenAI API Error: ' . $response->body());
            return "I'm having a little trouble connecting to my knowledge base. But based on our mission, I'd always recommend our Regenerative Organic T-shirts for a sustainable start!";

        } catch (\Exception $e) {
            Log::error('AI Stylist Exception: ' . $e->getMessage());
            return "I'm currently resting my circuits. Please browse our Regenerative collection in the shop while I get back online!";
        }
    }

    protected function prepareContext(?User $user): string
    {
        if (!$user) return "Guest User. No fit profile available.";

        return "Name: {$user->name}, Height: {$user->height_cm}cm, Weight: {$user->weight_kg}kg, Preference: {$user->fit_preference}. 
                Lifetime Impact: {$user->cumulative_water_saved}L water saved.";
    }

    protected function getProductContext(): string
    {
        $products = Product::where('is_published', true)
            ->with('category', 'variants')
            ->orderByDesc('sustainability_score')
            ->take(10)
            ->get();

        $context = "";
        $service = app(SustainabilityImpactService::class);
        foreach ($products as $product) {
            $impact = $service->calculateVariantImpact($product->variants->first());
            $context .= "- {$product->name} ({$product->category->name}): \${$product->price_cents}/100. Impact Index: {$impact['impact_index']}. Tier: {$impact['tier_label']}. Description: {$product->description}\n";
        }

        return $context;
    }

    protected function getMockResponse(string $message): string
    {
        return "👋 I'm the EcoStore AI Concierge (Demo Mode). I see you're asking about: '{$message}'. 
        
        Since I'm in demo mode, I'll recommend our **Regenerative Earth First Tee** ($45.00). 
        It has a near-perfect **Impact Index of 94**, using 100% Organic Cotton and saving 2,700 liters of water. 
        Based on your profile, I'd suggest a **Size M** for that perfect regular fit.
        
        [Check it out in the shop!]( " . route('shop') . " )";
    }
}
