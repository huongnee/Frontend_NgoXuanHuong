<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'total', 'status', 'payment_method', 'customer_name', 'customer_email', 'customer_address', 'customer_phone'
    ];
    
    // Thêm dòng này
    protected $casts = [
        'created_at' => 'datetime',
    ];
    // Quan hệ với OrderItems
    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Thêm mối quan hệ với OrderItems
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
