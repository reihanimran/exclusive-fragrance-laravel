<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model: ProductImage.php
class ProductImage extends Model
{
    
    protected $fillable = ['product_id', 'image_path', 'is_featured', 'alt_text'];
    public $timestamps = false; // Since only created_at exists

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}