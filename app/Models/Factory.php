<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'ethical_score',
        'certifications',
        'audit_report_summary',
        'audit_report_url',
        'video_url',
    ];

    protected $casts = [
        'certifications' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function passports(): HasMany
    {
        return $this->hasMany(ProductPassport::class);
    }
}
