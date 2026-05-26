<?php

namespace App\Jobs;

use App\Models\ProductPassport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncPassportToIpfs implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public ProductPassport $passport)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $payload = [
            'id' => $this->passport->id,
            'batch_number' => $this->passport->batch_number,
            'factory_id' => $this->passport->factory_id,
            'transit_impact_carbon' => $this->passport->transit_impact_carbon,
            'manufacturing_date' => $this->passport->manufacturing_date ? $this->passport->manufacturing_date->toDateString() : null,
            'condition_log' => $this->passport->condition_log,
            'last_audit_hash' => $this->passport->last_audit_hash,
            'qr_token' => $this->passport->qr_token,
            'is_verified' => $this->passport->is_verified,
            'synced_at' => now()->toIso8601String(),
        ];

        $apiKey = config('services.pinata.secret');

        // Simulation mode for sandbox or missing keys
        if (app()->environment('testing') || !$apiKey || $apiKey === 'your-pinata-secret') {
            $mockCid = 'Qm' . substr(hash('sha256', json_encode($payload)), 0, 44);
            $this->passport->update([
                'ipfs_cid' => $mockCid,
                'ipfs_synced_at' => now(),
            ]);
            return;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
            ])->post('https://api.pinata.cloud/pinning/pinJSONToIPFS', [
                'pinataContent' => $payload,
                'pinataMetadata' => [
                    'name' => "Passport-{$this->passport->id}",
                ],
            ]);

            if ($response->successful()) {
                $this->passport->update([
                    'ipfs_cid' => $response->json('IpfsHash'),
                    'ipfs_synced_at' => now(),
                ]);
            } else {
                Log::error("IPFS Sync failed for Passport {$this->passport->id}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("IPFS Sync Exception for Passport {$this->passport->id}: " . $e->getMessage());
        }
    }
}
