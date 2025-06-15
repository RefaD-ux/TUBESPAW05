<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin01@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin1234'), // ganti dengan yang aman
                'role' => 'admin',
            ]
        );
    }
}
