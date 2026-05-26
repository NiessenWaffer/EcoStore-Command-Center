<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResaleTradeIn extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'condition',
        'condition_notes',
        'photos',
        'estimated_credit_cents',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'photos' => 'array',
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
