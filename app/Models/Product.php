<?php

namespace App\Models;

use App\Models\ProductImage;
use App\Models\Categorie;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'compare_price',
        'sale_price',
        'discount',
        'stock',
        'image',
        'is_active',
        // 'stock_status',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     * Aliased as 'categorie' for view compatibility.
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    /**
     * Alias for categorie relationship.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Get all images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the main image for the product.
     */
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
    // public function wishlistedByUsers()
    // {
    //     return $this->belongsToMany(User::class, 'wishlists')
    //         ->withTimestamps();
    // }

    // public function wishlistItems()
    // {
    //     return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    // }
}
