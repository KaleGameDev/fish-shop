<?php

namespace App\Http\Controllers;

use App\Models\Product; // Đường dẫn gọi Model Sản phẩm
use App\Models\Review;  // Đường dẫn gọi Model Đánh giá
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // 1. CHỐT CHẶN: Kiểm tra xem user này đã đánh giá con cá này chưa
        $hasReviewed = Review::where('user_id', auth()->id())
                             ->where('product_id', $product->id)
                             ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi. Không thể đánh giá thêm!');
        }

        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'comment.required' => 'Vui lòng nhập nội dung bình luận.'
        ]);

        // Lưu đánh giá vào database
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}