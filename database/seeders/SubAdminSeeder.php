<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SubAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sub Admin
        User::updateOrCreate([
            'name' => 'Sub Admin',
            'email' => 'Omar@gmail.com',
            'password' => Hash::make('sub123'),
            'role_id' => 2,
        ]);
    }
}
