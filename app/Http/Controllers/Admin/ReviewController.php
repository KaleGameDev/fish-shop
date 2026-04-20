<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function index()
    {
        // Lấy tất cả đánh giá, xếp mới nhất lên đầu
        $reviews = Review::with(['user', 'product'])->latest()->paginate(15);
        
        // ĐÃ SỬA: Trỏ về thư mục warehouse
        return view('warehouse.reviews.index', compact('reviews'));
    }

    // Xóa đánh giá vi phạm
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Đã xóa đánh giá vi phạm thành công!');
    }
    // Bật/Tắt trạng thái Ẩn của đánh giá
    public function toggle(Review $review)
    {
        $review->is_hidden = !$review->is_hidden; // Đảo ngược trạng thái
        $review->save();

        $message = $review->is_hidden ? 'Đã ẨN bình luận khỏi cửa hàng!' : 'Đã HIỆN lại bình luận!';
        return back()->with('success', $message);
    }
}