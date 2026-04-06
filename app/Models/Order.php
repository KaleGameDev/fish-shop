<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // Các cột cho phép lưu dữ liệu vào database
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'shipping_address',
        'shipping_phone'
    ];

    /**
     * Một Đơn hàng thuộc về một Người dùng
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Một Đơn hàng có nhiều món hàng chi tiết (Items)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}