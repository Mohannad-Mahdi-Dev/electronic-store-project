<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب جميع المستخدمين العاديين (role_id = 3)
        $users = User::where('role_id', 3)->get();

        foreach ($users as $user) {
            // إنشاء طلبين لكل مستخدم لتجربة النظام
            Order::factory(2)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
