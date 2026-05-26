<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cumulative_water_saved',
        'cumulative_carbon_reduced',
        'leaderboard_opt_in',
        'referral_code',
        'network_impact_points',
        'eco_tier',
        'store_credit_cents',
        'height_cm',
        'weight_kg',
        'fit_preference',
        'fit_profile_data',
        'last_rewarded_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'cumulative_water_saved' => 'decimal:2',
            'cumulative_carbon_reduced' => 'decimal:2',
            'leaderboard_opt_in' => 'boolean',
            'store_credit_cents' => 'integer',
            'fit_profile_data' => 'array',
            'last_rewarded_at' => 'datetime',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function resaleTradeIns(): HasMany
    {
        return $this->hasMany(ResaleTradeIn::class);
    }

    public function governanceVotes(): HasMany
    {
        return $this->hasMany(GovernanceVote::class);
    }

    public function leaseSubscriptions(): HasMany
    {
        return $this->hasMany(LeaseSubscription::class);
    }
}
