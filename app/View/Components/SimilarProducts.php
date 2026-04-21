<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product; 

class SimilarProducts extends Component
{
    public $similarProducts;
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
        
        // Lấy 4 sản phẩm ngẫu nhiên khác với con cá hiện tại
        $this->similarProducts = Product::where('id', '!=', $product->id)
                                        ->inRandomOrder()
                                        ->limit(4)
                                        ->get();
    }

    public function render()
    {
        return view('components.similar-products');
    }
}