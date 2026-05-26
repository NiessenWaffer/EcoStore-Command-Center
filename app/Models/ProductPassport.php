<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPassport extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'batch_number',
        'factory_id',
        'user_id',
        'transit_impact_carbon',
        'manufacturing_date',
        'qr_token',
        'is_verified',
        'last_audit_hash',
        'is_leased',
        'ipfs_cid',
        'ipfs_synced_at',
        ];

        protected $casts = [
        'transit_impact_carbon' => 'decimal:2',
        'manufacturing_date' => 'date',
        'is_verified' => 'boolean',
        'condition_log' => 'array',
        'is_leased' => 'boolean',
        'ipfs_synced_at' => 'datetime',
        ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(PassportTransfer::class, 'passport_id');
    }

    public function activeTransfer(): BelongsTo
    {
        return $this->belongsTo(PassportTransfer::class, 'id', 'passport_id')
            ->where('status', 'Pending')
            ->where('expires_at', '>', now());
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function originFactory(): BelongsTo
    {
        return $this->belongsTo(Factory::class, 'factory_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(PassportAuditLog::class, 'passport_id')->orderBy('timestamp', 'asc');
    }
}
