<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaseSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'product_variant_id',
        'hub_id',
        'status',
        'start_date',
        'next_billing_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'next_billing_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function hub(): BelongsTo
    {
        return $this->belongsTo(LocalHub::class, 'hub_id');
    }
}
