<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PassportAuditLog extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'passport_id',
        'event_type',
        'event_data',
        'previous_hash',
        'current_hash',
        'signature',
        'timestamp',
        'performed_by',
        'original_log_id',
    ];

    protected $casts = [
        'event_data' => 'array',
        'timestamp' => 'datetime',
    ];

    public function passport(): BelongsTo
    {
        return $this->belongsTo(ProductPassport::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    /**
     * Get a masked label for the performer to protect privacy.
     */
    public function getMaskedPerformerLabelAttribute(): string
    {
        if ($this->event_type === 'OwnershipTransfer') {
            return "New Owner Claimed";
        }

        if ($this->performer && $this->performer->is_admin) {
            return "Verified Brand Admin (" . $this->performer->name . ")";
        }

        // Masking logic for previous owners
        return "Owner " . substr(md5($this->performed_by), 0, 4);
    }
}
