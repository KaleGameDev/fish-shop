<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    // Các cột cho phép lưu dữ liệu
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Một món hàng trong đơn phải thuộc về một Đơn hàng cha
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Một món hàng trong đơn phải trỏ đến một Sản phẩm (Cá)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}