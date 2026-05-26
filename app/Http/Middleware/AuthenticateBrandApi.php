<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Brand;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateBrandApi
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'API Token required.'], 401);
        }

        $brand = Brand::where('api_token', hash('sha256', $token))
            ->where('is_verified', true)
            ->first();

        if (!$brand) {
            return response()->json(['error' => 'Invalid or unverified API token.'], 401);
        }

        // Attach brand to request for controller access
        $request->merge(['authenticated_brand' => $brand]);

        return $next($request);
    }
}
