<?php

namespace App\Http\Controllers;

use App\Models\ProductPassport;
use App\Services\PassportService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PassportVerificationController extends Controller
{
    protected $passportService;

    public function __construct(PassportService $passportService)
    {
        $this->passportService = $passportService;
    }

    /**
     * Verify the entire integrity chain of a product passport.
     */
    public function verify(string $id): JsonResponse
    {
        $passport = ProductPassport::with('auditLogs')->findOrFail($id);
        
        $isVerified = $this->passportService->verifyIntegrity($passport);

        return response()->json([
            'passport_id' => $passport->id,
            'is_verified' => $isVerified,
            'last_audit_at' => now()->toIso8601String(),
            'audit_trail' => $passport->auditLogs->map(function ($log) {
                return [
                    'id' => $log->id,
                    'type' => $log->event_type,
                    'timestamp' => $log->timestamp,
                    'hash' => $log->current_hash,
                    'is_signed' => !empty($log->signature),
                ];
            })
        ]);
    }

    /**
     * Admin endpoint to append a new verified event to the passport.
     */
    public function storeEvent(Request $request, string $id): JsonResponse
    {
        $passport = ProductPassport::findOrFail($id);

        $validated = $request->validate([
            'event_type' => 'required|string',
            'event_data' => 'required|array',
        ]);

        $logEntry = $this->passportService->recordEvent(
            $passport,
            $validated['event_type'],
            $validated['event_data'],
            auth()->user()
        );

        return response()->json([
            'message' => 'Event recorded successfully',
            'log_entry' => $logEntry
        ], 201);
    }

    /**
     * Display the admin correction queue.
     */
    public function correctionQueue()
    {
        return view('admin.corrections.index');
    }
}
