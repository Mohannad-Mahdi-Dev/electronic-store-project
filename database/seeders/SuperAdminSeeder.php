<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'mohannad@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345'),
                'role_id' => 1,
            ]
        );
    }
}
