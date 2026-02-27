<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $q = request('q');

        $products = \App\Models\Product::query()
            ->when($q, fn($qr) => $qr->where('name', 'like', "%$q%"))
            ->orderByDesc('id')
            ->paginate(9);

        return view('shop.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }
}