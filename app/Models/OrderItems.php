<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Quan hệ với Orders
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
