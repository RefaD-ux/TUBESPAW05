<?php
// database/seeders/FasilitasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitas = [
            'AC',
            'Kamar Mandi Dalam',
            'WiFi',
            'Kasur',
            'Lemari',
            'Meja Belajar',
            'Kursi',
            'Dapur Bersama',
            'Parkir Motor',
            'Parkir Mobil',
            'Listrik Termasuk',
            'Air Termasuk',
        ];

        foreach ($fasilitas as $nama_fasilitas) {
            Fasilitas::create([
                'nama_fasilitas' => $nama_fasilitas,
            ]);
        }
    }
}
