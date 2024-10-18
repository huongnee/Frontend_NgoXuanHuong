<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_address');
            $table->string('customer_phone');
        });
    }
    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_email', 'customer_address', 'customer_phone']);
        });
    }
    
};
