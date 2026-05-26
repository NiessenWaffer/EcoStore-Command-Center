<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SustainabilityMetric extends Model
{
    protected $fillable = [
        'material_type',
        'water_per_kg',
        'carbon_per_kg',
    ];

    protected $casts = [
        'water_per_kg' => 'decimal:2',
        'carbon_per_kg' => 'decimal:2',
    ];
}
