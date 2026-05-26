<?php

namespace App\Services;

use App\Models\ProductPassport;
use App\Models\Product;
use App\Models\User;
use App\Models\PassportTransfer;
use App\Models\GovernanceProposal;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PassportService
{
    /**
     * Create a new product passport.
     */
    public function createPassport(int $productId, string $batchNumber, int $factoryId, array $data): ProductPassport
    {
        $passport = ProductPassport::create([
            'product_id' => $productId,
            'batch_number' => $batchNumber,
            'factory_id' => $factoryId,
            'user_id' => $data['user_id'] ?? null,
            'transit_impact_carbon' => $data['transit_impact_carbon'] ?? 0,
            'manufacturing_date' => $data['manufacturing_date'],
            'qr_token' => Str::random(64),
            'is_verified' => false,
            'last_audit_hash' => null,
        ]);

        // Record initial Creation event
        $this->recordEvent($passport, 'Creation', [
            'batch' => $batchNumber,
            'factory_id' => $factoryId,
            'date' => $data['manufacturing_date']
        ]);

        return $passport;
    }

    /**
     * Initiate an ownership transfer.
     */
    public function initiateTransfer(User $sender, ProductPassport $passport): PassportTransfer
    {
        // 1. Check for existing active transfer
        if ($passport->activeTransfer()->exists()) {
            throw new \Exception("A transfer is already pending for this passport.");
        }

        // 2. Generate secure token
        $token = 'XF-' . strtoupper(Str::random(12));

        return PassportTransfer::create([
            'passport_id' => $passport->id,
            'sender_id' => $sender->id,
            'token' => $token,
            'status' => 'Pending',
            'expires_at' => now()->addHours(48),
        ]);
    }

    /**
     * Complete an ownership transfer.
     */
    public function completeTransfer(User $recipient, string $token): ProductPassport
    {
        $transfer = PassportTransfer::where('token', $token)
            ->where('status', 'Pending')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $passport = $transfer->passport;

        return DB::transaction(function () use ($transfer, $passport, $recipient) {
            // 1. Record the handover in the audit log
            $this->recordEvent($passport, 'OwnershipTransfer', [
                'from_user_id' => $transfer->sender_id,
                'to_user_id' => $recipient->id,
                'transfer_id' => $transfer->id,
            ], $recipient);

            // 2. Update passport ownership
            $passport->update(['user_id' => $recipient->id]);

            // 3. Mark transfer as completed
            $transfer->update(['status' => 'Completed', 'recipient_id' => $recipient->id]);

            return $passport;
        });
    }

    /**
     * Propose a correction to an existing log entry.
     */
    public function proposeCorrection(User $proposer, string $logId, array $newData, string $reason): GovernanceProposal
    {
        return GovernanceProposal::create([
            'title' => "Audit Log Correction: " . $logId,
            'description' => "Reason: " . $reason,
            'type' => 'Correction',
            'options' => [
                'log_id' => $logId,
                'new_data' => $newData,
            ],
            'status' => 'Active',
            'starts_at' => now(),
            'ends_at' => now()->addDays(3),
            'quorum_threshold' => 1, // Requires 1 additional signature for simple corrections
        ]);
    }

    /**
     * Finalize a correction after governance approval.
     */
    public function finalizeCorrection(GovernanceProposal $proposal, User $approver): mixed
    {
        if ($proposal->type !== 'Correction' || $proposal->status !== 'Active') {
            throw new \Exception("Invalid correction proposal.");
        }

        $passport = ProductPassport::whereHas('auditLogs', function ($query) use ($proposal) {
            $query->where('id', $proposal->options['log_id']);
        })->firstOrFail();

        return DB::transaction(function () use ($proposal, $passport, $approver) {
            $logEntry = $this->recordEvent($passport, 'Correction', [
                'original_log_id' => $proposal->options['log_id'],
                'corrected_data' => $proposal->options['new_data'],
                'proposal_id' => $proposal->id,
            ], $approver);

            $proposal->update(['status' => 'Executed']);

            return $logEntry;
        });
    }

    /**
     * Record a new event in the passport's immutable audit log.
     */
    public function recordEvent(ProductPassport $passport, string $type, array $data, ?User $performer = null): mixed
    {
        $previousHash = $passport->last_audit_hash ?? 'genesis';
        $timestamp = now()->toDateTimeString();
        
        $payload = $this->generateDeterministicPayload($type, $data, $previousHash, $timestamp, $performer?->id);
        $currentHash = hash('sha256', $payload);

        // 2. Generate Digital Signature (if admin event)
        $signature = null;
        if ($performer) {
            $signature = base64_encode(hash_hmac('sha256', $currentHash, config('app.key')));
        }

        // 3. Persist Log Entry
        $logEntry = $passport->auditLogs()->create([
            'id' => Str::uuid(),
            'event_type' => $type,
            'event_data' => $data,
            'previous_hash' => $previousHash,
            'current_hash' => $currentHash,
            'signature' => $signature,
            'timestamp' => $timestamp,
            'performed_by' => $performer?->id,
            'original_log_id' => $data['original_log_id'] ?? null,
        ]);

        // 4. Update Passport State
        $passport->update([
            'last_audit_hash' => $currentHash,
            'is_verified' => $this->verifyIntegrity($passport)
        ]);

        return $logEntry;
    }

    /**
     * Verify the entire hash chain for a passport.
     */
    public function verifyIntegrity(ProductPassport $passport): bool
    {
        $logs = $passport->auditLogs()->orderBy('timestamp', 'asc')->get();
        $expectedPreviousHash = 'genesis';

        foreach ($logs as $log) {
            if ($log->previous_hash !== $expectedPreviousHash) {
                return false;
            }

            $payload = $this->generateDeterministicPayload(
                $log->event_type, 
                $log->event_data, 
                $log->previous_hash, 
                Carbon::parse($log->timestamp)->toDateTimeString(), 
                $log->performed_by
            );

            if (hash('sha256', $payload) !== $log->current_hash) {
                return false;
            }

            $expectedPreviousHash = $log->current_hash;
        }

        return true;
    }

    /**
     * Create a stable, sorted string for hashing.
     */
    private function generateDeterministicPayload(string $type, array $data, string $prevHash, string $ts, ?int $performerId): string
    {
        $payloadArray = [
            'data' => $data,
            'performer_id' => $performerId ? (string) $performerId : null,
            'previous_hash' => $prevHash,
            'timestamp' => $ts,
            'type' => $type,
        ];
        
        // Recursive sort
        $this->deepKsort($payloadArray);
        
        return json_encode($payloadArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function deepKsort(&$array): void
    {
        ksort($array);
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->deepKsort($value);
            }
        }
    }

    /**
     * Get a passport by its secure token.
     */
    public function getByToken(string $token): ?ProductPassport
    {
        return ProductPassport::where('qr_token', $token)->with(['product', 'originFactory'])->first();
    }

    /**
     * Sign a user's impact summary for a verifiable certificate.
     */
    public function signImpactSummary(array $data): string
    {
        $payload = json_encode($data);
        return hash_hmac('sha256', $payload, config('app.key'));
    }
}
