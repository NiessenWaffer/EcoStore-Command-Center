<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeoRoutingService;
use App\Services\SustainabilityImpactService;
use Illuminate\Http\JsonResponse;

class GeoRoutingController extends Controller
{
    protected $geoService;
    protected $impactService;

    public function __construct(GeoRoutingService $geoService, SustainabilityImpactService $impactService)
    {
        $this->geoService = $geoService;
        $this->impactService = $impactService;
    }

    /**
     * Detect user region based on IP.
     */
    public function detect(Request $request): JsonResponse
    {
        $ip = $request->ip();
        $region = $this->geoService->detectRegion($ip);

        return response()->json([
            'region' => $region,
            'ip' => $ip,
        ]);
    }

    /**
     * Calculate transit impact based on destination.
     */
    public function calculateImpact(Request $request): JsonResponse
    {
        $request->validate([
            'hub_id' => 'required|exists:local_hubs,id',
            'destination_zip' => 'required|string',
        ]);

        $hub = \App\Models\LocalHub::find($request->hub_id);
        $impact = $this->impactService->calculateTransitImpact($hub, $request->destination_zip);

        return response()->json($impact);
    }
}
