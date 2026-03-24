<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'image',
        'description',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}