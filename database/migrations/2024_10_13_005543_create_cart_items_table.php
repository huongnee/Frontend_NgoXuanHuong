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
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();
    
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Bảng cart_items sẽ lưu các sản phẩm trong từng giỏ hàng, với cart_id để liên kết tới giỏ hàng và product_id để xác định sản phẩm nào.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
