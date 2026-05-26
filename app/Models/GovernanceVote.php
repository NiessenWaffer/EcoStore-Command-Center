<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovernanceVote extends Model
{
    protected $fillable = [
        'user_id',
        'proposal_id',
        'allocations',
        'weight_cast',
        'weighted_cost',
        'resultant_influence',
    ];

    protected $casts = [
        'allocations' => 'array',
        'weight_cast' => 'integer',
        'weighted_cost' => 'integer',
        'resultant_influence' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(GovernanceProposal::class, 'proposal_id');
    }
}
