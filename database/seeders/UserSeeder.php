<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat pengguna pemilik
        User::create([
            'name' => 'Pemilik Kos',
            'email' => 'pemilik@example.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
        ]);

        // Buat pengguna pencari
        User::create([
            'name' => 'Pencari Kos',
            'email' => 'pencari@example.com',
            'password' => Hash::make('password'),
            'role' => 'pencari',
        ]);

        // Anda bisa menambahkan lebih banyak user di sini
        User::factory()->count(5)->create(); // Contoh membuat 5 user acak
    }
}