<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    
    protected $fillable = [
        'order_id', 'product_id', 'quantity',
        'original_item_price', 'sale_item_price', 'item_discount'
    ];
    
    protected $casts = [
        'original_item_price' => 'decimal:2',
        'sale_item_price' => 'decimal:2',
        'item_discount' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
