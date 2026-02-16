<?php

namespace App\Models;

use \App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'order_number',
        'subtotal',
        'discount_amount',
        'shipping_fee',
        'total',
        'status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_notes',
        // 'shipping_state',
        // 'shipping_zip',
        // 'shipping_country',
        'payment_method',
        'payment_status',
        // 'shipping_address',
        // 'billing_address',
        // 'shipping_method',
        // 'shipping_cost',
        // 'tax_amount',
        'coupon_code',
        // 'coupon_discount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
