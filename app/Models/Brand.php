<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'is_visible',
    ];

    /**
     * احصل على كل المنتجات التابعة لهذه العلامة التجارية
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
