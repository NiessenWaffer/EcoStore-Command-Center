<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernanceProposal extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'options',
        'status',
        'starts_at',
        'ends_at',
        'quorum_threshold',
        'total_weight_cast',
    ];

    protected $casts = [
        'options' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'total_weight_cast' => 'decimal:2',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(GovernanceVote::class, 'proposal_id');
    }
}
