<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
    ];

    // علاقة عكسية: العنصر ينتمي لطلب واحد
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // علاقة: العنصر مرتبط بمنتج واحد
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
