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
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Kiểu mặc định là Big Increments

            // Thiết lập user_id làm khóa ngoại, thêm index để tối ưu và hiện dây nối
            $table->foreignId('user_id')->index()->constrained()->onDelete('cascade');

            // Trạng thái giỏ hàng (active: đang chọn, ordered: đã đặt hàng, cancelled: đã hủy)
            $table->string('status')->default('active'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};