<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'code',
        'type', // fixed / percentage
        'value', // 100 / 10
        'cart_value', // minimum cart value
        'expiry_date',
        'usage_limit',
        'used_count',
        'is_active',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_code', 'code');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('expiry_date', '>=', now());
    }
    public function getDiscountAmount($total)
    {
        if ($this->type == 'fixed') {
            return $this->value;
        }
        return ($total * $this->value) / 100;
    }
    public function isExpired()
    {
        return $this->expiry_date < now();
    }
    public function isNotActive()
    {
        return !$this->is_active;
    }
    public function isUsedFully()
    {
        return $this->used_count >= $this->usage_limit;
    }
}
