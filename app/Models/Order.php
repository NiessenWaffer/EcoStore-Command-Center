<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_session_id',
        'total_cents',
        'status',
        'payment_status',
        'stripe_payment_intent_id',
        'tracking_number',
        'total_water_saved',
        'total_carbon_reduced',
        'shipping_address',
        'is_carbon_neutral_shipping',
        'recap_sent_at',
    ];

    protected $casts = [
        'total_water_saved' => 'decimal:2',
        'total_carbon_reduced' => 'decimal:2',
        'shipping_address' => 'array',
        'is_carbon_neutral_shipping' => 'boolean',
        'recap_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function localHub(): BelongsTo
    {
        return $this->belongsTo(LocalHub::class);
    }
}
