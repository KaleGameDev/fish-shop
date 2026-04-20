<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    // Đánh giá này thuộc về User nào
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Đánh giá này thuộc về Sản phẩm (Con cá) nào
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}