<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Categorie::all();
        $brands = \App\Models\Brand::all();

        foreach ($categories as $category) {
            \App\Models\Product::factory(5)->create([
                'category_id' => $category->id,
                'brand_id'    => $brands->random()->id,
            ])->each(function ($product) {
                // إضافة صور تقنية للمنتج
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => 'admin-assets/img/img.png',
                    'is_main'    => true,
                ]);
            });
        }
    }
}
