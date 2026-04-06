<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Lấy giỏ hàng đang hoạt động của người dùng hiện tại
     */
    protected function getActiveCart()
    {
        return Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => 'active',
            ]
        );
    }

    /**
     * Hiển thị trang giỏ hàng
     */
    public function index()
    {
        $cart = $this->getActiveCart()->load('items.product');
        return view('cart.index', compact('cart'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Product $product)
    {
        if ($product->stock < 1) {
            return back()->with('error', 'Sản phẩm đã hết hàng.');
        }

        $cart = $this->getActiveCart();
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            if (($item->quantity + 1) > $product->stock) {
                return back()->with('error', 'Số lượng vượt quá tồn kho.');
            }
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    /**
     * Cập nhật số lượng món hàng trong giỏ
     */
    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        if ($request->quantity > $item->product->stock) {
            return back()->with('error', 'Số lượng vượt quá tồn kho.');
        }

        $item->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    /**
     * Xóa một món hàng khỏi giỏ
     */
    public function remove(CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    /**
     * Làm trống giỏ hàng
     */
    public function clear()
    {
        $cart = $this->getActiveCart();
        $cart->items()->delete();

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }

    /**
     * Xử lý thanh toán và trừ tồn kho
     */
    public function checkout(Request $request)
    {
        $cart = $this->getActiveCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // DB::transaction sẽ trả về giá trị mà closure bên trong return
        $order = DB::transaction(function () use ($cart, $request) {
            $total = $cart->items->sum(function($item) {
                return $item->quantity * $item->price;
            });

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'shipping_address' => $request->address ?? 'Chưa cập nhật',
                'shipping_phone' => $request->phone ?? Auth::user()->phone,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();
            $cart->update(['status' => 'completed']);

            return $order; // Trả về order để lấy ID sau khi xong transaction
        });

        // Chuyển hướng sang trang thông báo thành công kèm theo ID đơn hàng
        return redirect()->route('cart.success', ['order' => $order->id])
                         ->with('success', 'Thanh toán thành công!');
    }

    /**
     * Hiển thị trang thông báo đặt hàng thành công
     */
    public function thankYou(Order $order)
    {
        // Kiểm tra bảo mật: Chỉ chủ đơn hàng mới xem được trang này
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('cart.thankyou', compact('order'));
    }
    public function orderHistory()
{
    // Lấy danh sách đơn hàng của người dùng đang đăng nhập, sắp xếp mới nhất lên đầu
    $orders = Order::where('user_id', Auth::id())
                   ->with('items.product')
                   ->orderBy('created_at', 'desc')
                   ->get();

    return view('orders.history', compact('orders'));
}
/**
     * Hiển thị chi tiết 1 đơn hàng cụ thể cho khách
     */
    public function showOrder(Order $order)
    {
        // Kiểm tra bảo mật: Chỉ cho phép khách hàng xem đơn của chính họ
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        // Tải kèm dữ liệu chi tiết các món cá
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
    /**
     * Khách hàng tự hủy đơn hàng
     */
    public function cancel(Order $order)
    {
        // 1. Bảo mật: Kiểm tra có đúng chủ đơn hàng không
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // 2. Logic: Chỉ được hủy khi trạng thái là 'pending'
        if ($order->status !== 'pending') {
            return back()->with('error', 'Đơn hàng đã được vận chuyển hoặc hoàn thành, không thể tự hủy.');
        }

        // 3. Xử lý hủy và Hoàn tồn kho
        DB::transaction(function () use ($order) {
            // Đổi trạng thái đơn thành cancelled
            $order->update(['status' => 'cancelled']);

            // Cộng lại số lượng vào kho cá
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        });

        return back()->with('success', 'Đã hủy đơn hàng thành công. Sản phẩm đã được hoàn lại kho.');
    }
}