<?php

namespace App\Livewire\Admin;

use App\Models\ProductPassport;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;

class IpfsSyncManager extends Component
{
    public function resyncAll()
    {
        $passports = ProductPassport::all();
        foreach ($passports as $passport) {
            \App\Jobs\SyncPassportToIpfs::dispatch($passport);
        }
        
        \App\Models\AdminActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Global IPFS Re-sync',
            'description' => "Triggered manual re-sync for {$passports->count()} passports.",
        ]);

        session()->flash('message', "Global IPFS Re-sync queued for {$passports->count()} passports.");
    }

    public function render()
    {
        $hasColumns = Schema::hasColumn('product_passports', 'ipfs_cid');
        
        return view('livewire.admin.ipfs-sync-manager', [
            'totalPassports' => ProductPassport::count(),
            'syncedPassports' => $hasColumns ? ProductPassport::whereNotNull('ipfs_cid')->count() : 0,
            'lastSync' => $hasColumns ? ProductPassport::max('ipfs_synced_at') : null,
            'hasColumns' => $hasColumns,
        ]);
    }
}
