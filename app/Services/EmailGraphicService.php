<?php

namespace App\Services;

class EmailGraphicService
{
    /**
     * Generate a water filling pool SVG based on liters saved.
     * Max capacity represented is 5000L.
     */
    public function generateWaterPoolSvg(float $liters): string
    {
        $maxLiters = 5000;
        $percentage = min(100, ($liters / $maxLiters) * 100);
        $fillHeight = 100 - $percentage; // Rect height starts from top, so we calculate from top

        return "
        <svg width='200' height='200' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'>
            <!-- Pool Border -->
            <rect x='10' y='10' width='80' height='80' rx='10' fill='#eee' stroke='#ccc' stroke-width='2' />
            <!-- Water Fill -->
            <rect x='10' y='" . (10 + ($percentage > 0 ? (80 * (1 - $percentage/100)) : 80)) . "' width='80' height='" . (80 * ($percentage/100)) . "' rx='0' fill='#3b82f6' />
            <!-- Glass Overlay -->
            <rect x='10' y='10' width='80' height='80' rx='10' fill='none' stroke='#ccc' stroke-width='2' />
            <!-- Text Label -->
            <text x='50' y='55' text-anchor='middle' font-family='sans-serif' font-size='10' font-weight='bold' fill='#1e3a8a'>" . round($liters) . "L</text>
        </svg>";
    }

    /**
     * Generate a carbon reduction tree SVG.
     * 1 tree = 25kg CO2 approx.
     */
    public function generateCarbonTreeSvg(float $kg): string
    {
        $trees = max(1, round($kg / 25));
        $svg = "<svg width='200' height='100' viewBox='0 0 200 100' xmlns='http://www.w3.org/2000/svg'>";
        
        for ($i = 0; $i < min(5, $trees); $i++) {
            $x = 20 + ($i * 35);
            $svg .= "
            <g transform='translate($x, 20)'>
                <path d='M15 0 L30 30 L0 30 Z' fill='#059669' />
                <rect x='12' y='30' width='6' height='10' fill='#78350f' />
            </g>";
        }
        
        $svg .= "<text x='100' y='80' text-anchor='middle' font-family='sans-serif' font-size='10' font-weight='bold' fill='#065f46'>" . round($kg) . "kg Reduced</text>";
        $svg .= "</svg>";
        
        return $svg;
    }
}
