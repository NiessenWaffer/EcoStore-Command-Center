<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityChallenge extends Model
{
    protected $fillable = [
        'title',
        'metric_type',
        'target_value',
        'current_value',
        'donation_amount_cents',
        'charity_name',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'current_value' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getProgressPercentageAttribute(): float
    {
        if ($this->target_value <= 0) {
            return 0;
        }

        return min(100, round(($this->current_value / $this->target_value) * 100, 2));
    }
}
