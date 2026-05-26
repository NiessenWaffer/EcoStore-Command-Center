<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PassportTransfer extends Model
{
    protected $fillable = [
        'id',
        'passport_id',
        'sender_id',
        'recipient_id',
        'token',
        'status',
        'expires_at',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function passport(): BelongsTo
    {
        return $this->belongsTo(ProductPassport::class, 'passport_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
