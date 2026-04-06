<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // Kiểu mặc định là Big Increments
            
            // Đảm bảo có ->index() để phpMyAdmin dễ nhận diện dây nối
            // Liên kết với bảng carts
            $table->foreignId('cart_id')->index()->constrained()->onDelete('cascade');
            
            // Liên kết với bảng products
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade');
            
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('price');
            $table->timestamps();

            // Đảm bảo trong 1 giỏ hàng, mỗi sản phẩm chỉ xuất hiện 1 dòng (tránh trùng lặp)
            $table->unique(['cart_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};