<?php

namespace App\Observers;

use App\Jobs\SyncPassportToIpfs;
use App\Models\ProductPassport;

class ProductPassportObserver
{
    /**
     * Handle the ProductPassport "created" event.
     */
    public function created(ProductPassport $productPassport): void
    {
        SyncPassportToIpfs::dispatch($productPassport);
    }

    /**
     * Handle the ProductPassport "updated" event.
     */
    public function updated(ProductPassport $productPassport): void
    {
        if ($productPassport->isDirty(['condition_log', 'user_id', 'last_audit_hash', 'is_verified'])) {
            SyncPassportToIpfs::dispatch($productPassport);
        }
    }
}
