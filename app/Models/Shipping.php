<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    
    protected $fillable = [
        'user_id', 'full_name', 'address',
        'city', 'postal_code', 'phone'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
