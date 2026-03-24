<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected function getActiveCart()
    {
        return Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => 'active',
            ]
        );
    }

    public function index()
    {
        $cart = $this->getActiveCart()->load('items.product');

        return view('cart.index', compact('cart'));
    }

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

    public function remove(CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clear()
    {
        $cart = $this->getActiveCart();
        $cart->items()->delete();

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }
}