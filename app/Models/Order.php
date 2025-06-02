<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shipping;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shipping_id',
        'order_status',
        'total_sale_amount',
        'total_order_amount',
        'order_date'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_sale_amount' => 'decimal:2',
        'total_order_amount' => 'decimal:2'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

