<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SuperAdminSeeder::class,
            SubAdminSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);

        // اختياري: إنشاء عناصر الطلبات (Order Items) لربط الطلبات بالمنتجات
        $this->seedOrderItems();
    }

    private function seedOrderItems()
    {
        $orders = \App\Models\Order::all();
        $products = \App\Models\Product::all();

        foreach ($orders as $order) {
            // اختر 2-4 منتجات عشوائية لكل طلب
            $randomProducts = $products->random(rand(2, 4));

            foreach ($randomProducts as $product) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name, // Snapshot
                    'price' => $product->price,
                    'quantity' => rand(1, 3),
                ]);
            }
        }
    }
}
