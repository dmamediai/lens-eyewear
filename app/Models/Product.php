<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'brand', 'price', 'original_price',
        'stock', 'images', 'colors', 'specs', 'badge', 'is_bogo',
        'active', 'featured', 'rating', 'review_count', 'description',
    ];

    protected $casts = [
        'images'         => 'array',
        'colors'         => 'array',
        'specs'          => 'array',
        'is_bogo'        => 'boolean',
        'active'         => 'boolean',
        'featured'       => 'boolean',
        'price'          => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating'         => 'decimal:1',
    ];

    // ── Scopes ─────────────────────────────────────────────
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory(Builder $query, string $slug): Builder
    {
        return $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }

    public function scopeByBrand(Builder $query, string $brand): Builder
    {
        return $query->where('brand', $brand);
    }

    public function scopeLowStock(Builder $query, int $threshold = 5): Builder
    {
        return $query->where('stock', '<=', $threshold)->where('active', true);
    }

    // ── Accessors ───────────────────────────────────────────
    public function getDiscountPercentAttribute(): int
    {
        if (!$this->original_price || $this->original_price <= 0) return 0;
        return (int) round((1 - $this->price / $this->original_price) * 100);
    }

    public function getPrimaryImageAttribute(): string
    {
        return $this->images[0] ?? '/images/placeholder.jpg';
    }

    // ── Relations ───────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
