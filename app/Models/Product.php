<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price_cents',
        'sustainability_score',
        'material_composition',
        'image_url',
        'is_published',
        'is_preorder',
        'materials_cost_cents',
        'labor_cost_cents',
        'shipping_cost_cents',
        'operations_cost_cents',
    ];

    protected $casts = [
        'material_composition' => 'array',
        'sustainability_score' => 'decimal:2',
        'is_published' => 'boolean',
        'is_preorder' => 'boolean',
        'materials_cost_cents' => 'integer',
        'labor_cost_cents' => 'integer',
        'shipping_cost_cents' => 'integer',
        'operations_cost_cents' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function passports(): HasMany
    {
        return $this->hasMany(ProductPassport::class);
    }
}
