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
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nếu giỏ hàng có thể thuộc về người dùng đã đăng nhập,Nếu giỏ hàng dành cho khách vãng lai, user_id sẽ là null.
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Bảng carts sẽ có cột user_id để xác định giỏ hàng của người dùng nào. Nếu giỏ hàng dành cho khách vãng lai, user_id sẽ là null.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
