<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureImmutable
{
    /**
     * Prevent deletion or modification of audit log entries.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['PUT', 'PATCH', 'DELETE'])) {
            // Check if the request is targeting the passport_audit_logs table
            // In a real app, we'd check the route name or model instance
            if ($request->is('admin/passports/*/events/*') || $request->is('api/v1/audit-logs/*')) {
                return response()->json([
                    'error' => 'Data Immutability Violation',
                    'message' => 'Audit log entries cannot be modified or deleted once recorded.'
                ], 403);
            }
        }

        return $next($request);
    }
}
