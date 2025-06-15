<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriKos; // Import model KategoriKos

class KategoriKosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriKos = [
            ['nama_kategori' => 'Harian'],
            ['nama_kategori' => 'Mingguan'],
            ['nama_kategori' => 'Bulanan'],
            ['nama_kategori' => 'Tahunan'],
        ];

        foreach ($kategoriKos as $kategori) {
            KategoriKos::create($kategori);
        }
    }
}