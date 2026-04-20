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
     * ==========================================
     * XỬ LÝ THANH TOÁN (CHECKOUT CHUNG)
     * ==========================================
     */
    public function checkout(Request $request)
    {
        $cart = $this->getActiveCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Lấy phương thức thanh toán người dùng chọn
        $paymentMethod = $request->input('payment_method', 'cod');

        // DB::transaction: Tạo đơn, trừ kho, xóa giỏ ngay lập tức
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

                // Trừ tồn kho lập tức
                $item->product->decrement('stock', $item->quantity);
            }

            // Xóa giỏ hàng
            $cart->items()->delete();
            $cart->update(['status' => 'completed']);

            return $order; 
        });

        // Rẽ nhánh: Nếu chọn VNPAY thì gọi hàm tạo link VNPAY
        if ($paymentMethod === 'vnpay') {
            return redirect()->route('checkout.vnpay', ['order' => $order->id]);
        }

        // Mặc định là COD: Chuyển thẳng tới trang thành công
        return redirect()->route('cart.success', ['order' => $order->id])
                         ->with('success', 'Thanh toán thành công!');
    }

    /**
     * ==========================================
     * TÍCH HỢP THANH TOÁN VNPAY API
     * ==========================================
     */
    
    /**
     * Tạo URL và chuyển hướng sang cổng thanh toán VNPAY
     */
    public function vnpayPayment(Order $order, Request $request)
    {
        // Kiểm tra bảo mật
        if ($order->user_id !== Auth::id() || $order->status !== 'pending') {
            abort(403);
        }

        // Lấy config từ file .env
        $vnp_TmnCode = env('VNP_TMN_CODE', 'CUJ4845K');
        $vnp_HashSecret = env('VNP_HASH_SECRET', 'JY1G5V4ALB46Y1TMQZ7C0GLXL8YBZO34');
        $vnp_Url = env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $vnp_Returnurl = route('checkout.vnpay.return'); // Link trả về

        // Các thông số bắt buộc gửi sang VNPAY
        $vnp_TxnRef = $order->id . "_" . time(); // Mã giao dịch (thêm time để chống trùng lặp test)
        $vnp_OrderInfo = "Thanh toan don hang Fish Shop " . $order->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = intval($order->total) * 100; // VNPAY yêu cầu số tiền phải nhân lên 100 lần
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip() === '::1' ? '127.0.0.1' : $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        // Thuật toán tạo chữ ký số của VNPAY
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Chuyển hướng người dùng sang VNPAY
        return redirect($vnp_Url);
    }

    /**
     * Nhận kết quả từ VNPAY trả về sau khi khách quẹt thẻ
     */
    public function vnpayReturn(Request $request)
    {
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        // Cắt lấy ID thật của đơn hàng
        $realOrderId = explode('_', $request->vnp_TxnRef)[0];
        $order = Order::findOrFail($realOrderId);

        // Kiểm tra chữ ký và Trạng thái thanh toán (Mã 00 là thanh toán thành công)
        if ($secureHash == $vnp_SecureHash && $request->vnp_ResponseCode == '00') {
            
            // Đổi trạng thái thành đang giao hàng
            $order->update(['status' => 'pending']); 
            
            return redirect()->route('cart.success', ['order' => $order->id])
                             ->with('success', 'Thanh toán qua VNPAY thành công!');
        } else {
            // Thanh toán THẤT BẠI hoặc HỦY GIAO DỊCH
            DB::transaction(function () use ($order) {
                // Đổi trạng thái đơn thành bị hủy
                $order->update(['status' => 'cancelled']);
                
                // HOÀN LẠI TỒN KHO cho các sản phẩm
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            });
            
            return redirect()->route('cart.index')
                             ->with('error', 'Thanh toán thất bại hoặc bạn đã hủy giao dịch. Đã hoàn lại sản phẩm.');
        }
    }

    /**
     * ==========================================
     * QUẢN LÝ ĐƠN HÀNG VÀ LỊCH SỬ
     * ==========================================
     */

    /**
     * Hiển thị trang thông báo đặt hàng thành công
     */
    public function thankYou(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('cart.thankyou', compact('order'));
    }

    /**
     * Lịch sử đơn hàng
     */
    public function orderHistory()
    {
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
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Khách hàng tự hủy đơn hàng
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Đơn hàng đã được vận chuyển hoặc hoàn thành, không thể tự hủy.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);

            // Cộng lại số lượng vào kho cá
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        });

        return back()->with('success', 'Đã hủy đơn hàng thành công. Sản phẩm đã được hoàn lại kho.');
    }
}