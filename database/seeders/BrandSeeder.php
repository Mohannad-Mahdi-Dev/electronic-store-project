<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'description' => 'Premium smartphones and laptops'],
            ['name' => 'Samsung', 'description' => 'Cutting-edge electronics and displays'],
            ['name' => 'Sony', 'description' => 'Best in class audio and gaming'],
            ['name' => 'HP', 'description' => 'Professional laptops and printers'],
            ['name' => 'Xiaomi', 'description' => 'High quality smart devices'],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'description' => $brand['description'],
                'logo' => 'admin-assets/img/brands/default-logo.png',
                'is_visible' => true,
            ]);
        }
    }
}
