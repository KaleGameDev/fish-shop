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
    // Một sản phẩm có nhiều đánh giá
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}