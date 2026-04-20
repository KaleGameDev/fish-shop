<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Nối dây từ order_items sang orders
            $table->foreignId('order_id')->index()->constrained()->onDelete('cascade');
            // Nối dây từ order_items sang products
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade');
            
            $table->integer('quantity');
            $table->unsignedInteger('price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};