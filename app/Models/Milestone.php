<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'name',
        'metric_type',
        'threshold_value',
        'reward_type',
        'reward_value',
    ];

    protected $casts = [
        'threshold_value' => 'decimal:2',
    ];
}
