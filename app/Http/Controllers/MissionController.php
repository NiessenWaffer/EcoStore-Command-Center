<?php

namespace App\Http\Controllers;

use App\Services\GlobalImpactService;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    /**
     * Show the Mission page.
     */
    public function index(GlobalImpactService $impactService)
    {
        $totals = $impactService->getGlobalTotals();

        return view('mission', [
            'totalWater' => $totals['water'],
            'totalCarbon' => $totals['carbon'],
        ]);
    }
}
