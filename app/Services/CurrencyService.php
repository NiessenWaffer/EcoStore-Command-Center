<?php

namespace App\Services;

class CurrencyService
{
    /**
     * Fixed exchange rates for MVP.
     * In production, this would use a live API.
     */
    protected $rates = [
        'USD' => 1.0,
        'EUR' => 0.92,
        'GBP' => 0.79,
        'JPY' => 155.0,
    ];

    /**
     * Convert an amount between currencies.
     */
    public function convert(float $amount, string $from, string $to): float
    {
        if ($from === $to) return $amount;

        $baseAmount = $amount / ($this->rates[$from] ?? 1.0);
        $converted = $baseAmount * ($this->rates[$to] ?? 1.0);

        return round($converted, 2);
    }

    /**
     * Get symbol for a currency code.
     */
    public function getSymbol(string $code): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
        ];

        return $symbols[$code] ?? '$';
    }
}
