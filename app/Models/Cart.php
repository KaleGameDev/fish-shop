<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function totalQuantity()
    {
        return $this->items->sum('quantity');
    }

    public function totalPrice()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}