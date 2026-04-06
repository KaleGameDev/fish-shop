<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách cá, nếu có tìm kiếm thì lọc ra, sau đó phân mỗi trang 8 con
        $query = Product::query();

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // ĐỔI TỪ get() SANG paginate(8)
        // Mẹo nhỏ: Bạn có thể thêm ->latest() ngay trước ->paginate(8) nếu muốn cá mới nhập hiện lên đầu nhé
        $products = $query->paginate(8); 

        return view('shop.index', compact('products'));
    }

    public function show(Product $product)
    {
       $reviews = $product->reviews()->where('is_hidden', false)->with('user')->latest()->get();
        
        // Tính điểm sao trung bình (Ví dụ: 4.5 sao)
        $averageRating = $reviews->avg('rating');

        return view('shop.show', compact('product', 'reviews', 'averageRating'));
    }
}