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
        'brand_id',
        'name',
        'slug',
        'description',
        'price_cents',
        'sustainability_score',
        'material_composition',
        'image_url',
        'is_published',
        'is_preorder',
    ];

    protected $casts = [
        'material_composition' => 'array',
        'is_published' => 'boolean',
        'is_preorder' => 'boolean',
        'price_cents' => 'integer',
        'sustainability_score' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
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
