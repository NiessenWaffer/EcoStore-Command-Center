<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalHub extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'is_active',
        'supports_naked_shipping',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
        'supports_naked_shipping' => 'boolean',
    ];
}
