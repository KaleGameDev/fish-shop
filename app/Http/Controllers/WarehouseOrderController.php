<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class WarehouseOrderController extends Controller
{
    // Hiển thị danh sách tất cả đơn hàng
    public function index()
    {
        // Lấy đơn hàng kèm thông tin người mua và chi tiết cá, xếp mới nhất lên đầu
        $orders = Order::with(['user', 'items.product'])
                       ->orderBy('created_at', 'desc')
                       ->paginate(10); // Phân trang 10 đơn/trang cho gọn

        return view('warehouse.orders.index', compact('orders'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,shipping,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $order->id);
    }
    // Xóa vĩnh viễn đơn hàng
    public function destroy(Order $order)
    {
        // Xóa các chi tiết món cá trong đơn hàng trước (để tránh lỗi khóa ngoại)
        $order->items()->delete();
        
        // Xóa đơn hàng chính
        $order->delete();

        return back()->with('success', 'Đã xóa vĩnh viễn đơn hàng #' . $order->id);
    }
}