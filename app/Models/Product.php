<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['category_id', 'name', 'description', 'quantity', 'price', 'image']; // Đảm bảo cột image có thể được fill

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
