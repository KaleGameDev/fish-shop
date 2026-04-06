<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Nối dây từ orders sang users
            $table->foreignId('user_id')->index()->constrained()->onDelete('cascade');
            
            $table->decimal('total', 15, 2);
            $table->string('status')->default('pending');
            $table->text('shipping_address')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};