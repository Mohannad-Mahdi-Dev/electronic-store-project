<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Smartphones', 'slug' => 'smartphones'],
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Headphones', 'slug' => 'headphones'],
            ['name' => 'Smart Watches', 'slug' => 'smart-watches'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ];

        foreach ($categories as $cat) {
            Categorie::create([
                'name'  => $cat['name'],
                'slug'  => Str::slug($cat['name'], '-'),
                'image' => 'admin-assets/img/img.png',
            ]);
        }
    }
}
