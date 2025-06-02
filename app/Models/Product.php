<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;


    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'brand',
        'fragrance_type',
        'original_price',
        'sale_price',
        'stock_quantity',
        'category_id',
        'product_desc',
        'size',
        'Bestseller',
        'gender'
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'Bestseller' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function featuredImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_featured', 1);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    // Accessors
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->original_price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->sale_price)
            return 0;
        return round((($this->original_price - $this->sale_price) / $this->original_price) * 100);
    }

    // Scopes
    public function scopeBestsellers($query)
    {
        return $query->where('Bestseller', true);
    }

    public function scopeGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
}