<?php

namespace App\Livewire\Admin;

use App\Models\LeaseSubscription;
use App\Models\ProductPassport;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LeaseReturnScanner extends Component
{
    public $qrToken = '';
    public $scannedPassport = null;
    public $activeLease = null;
    public $condition = 'good';
    public $conditionOptions = [
        'pristine' => 'Pristine (Like New)',
        'good' => 'Good (Minor Wear)',
        'fair' => 'Fair (Noticeable Wear)',
        'needs_repair' => 'Needs Repair (Damaged)',
    ];

    public function scan()
    {
        $this->validate([
            'qrToken' => 'required|string',
        ]);

        $this->scannedPassport = ProductPassport::where('qr_token', $this->qrToken)->first();

        if (!$this->scannedPassport) {
            $this->addError('qrToken', 'Product Passport not found.');
            return;
        }

        $this->activeLease = LeaseSubscription::where('product_variant_id', $this->scannedPassport->product_variant_id) // using variant ID approximation for prototype
            ->where('status', 'active')
            ->first();

        if (!$this->activeLease) {
            $this->addError('qrToken', 'No active lease found for this item.');
        }
    }

    public function processReturn()
    {
        $this->validate([
            'condition' => 'required|in:pristine,good,fair,needs_repair',
        ]);

        if (!$this->scannedPassport || !$this->activeLease) return;

        DB::transaction(function () {
            // Update lease status
            $this->activeLease->update(['status' => 'completed']);

            // Update passport condition ledger
            $currentLog = $this->scannedPassport->condition_log ?? [];
            $currentLog[] = [
                'date' => now()->toIso8601String(),
                'condition' => $this->condition,
                'assessed_by' => auth()->id(),
            ];

            $this->scannedPassport->update([
                'condition_log' => $currentLog,
                'is_leased' => false,
            ]);

            // Add Admin Activity Log
            \App\Models\AdminActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'Lease Return Processed',
                'description' => "Processed return for Passport {$this->scannedPassport->id}. Condition: {$this->condition}.",
            ]);
        });

        session()->flash('message', 'Lease return successfully processed and ledger updated.');
        
        // Reset state
        $this->reset(['qrToken', 'scannedPassport', 'activeLease', 'condition']);
    }

    public function render()
    {
        return view('livewire.admin.lease-return-scanner');
    }
}
