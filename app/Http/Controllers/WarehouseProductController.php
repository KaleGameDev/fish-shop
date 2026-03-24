<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WarehouseProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('warehouse.products.index', compact('products'));
    }

    public function create()
    {
        return view('warehouse.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Product::create($data);

        return redirect()
            ->route('warehouse.products.index')
            ->with('success', 'Đã thêm sản phẩm mới.');
    }

    public function edit(Product $product)
    {
        return view('warehouse.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $product->update($data);

        return redirect()
            ->route('warehouse.products.index')
            ->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('warehouse.products.index')
            ->with('success', 'Đã xóa sản phẩm.');
    }
}