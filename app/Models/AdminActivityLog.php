<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'action',
        'description',
        'target_type',
        'target_id',
        'timestamp',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
            if (!$model->timestamp) {
                $model->timestamp = now();
            }
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
