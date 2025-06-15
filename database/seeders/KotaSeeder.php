<?php
// database/seeders/KotaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kota;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kota = [
            'Jakarta',
            'Bandung',
            'Surabaya',
            'Yogyakarta',
            'Malang',
            'Semarang',
        ];

        foreach ($kota as $nama_kota) {
            Kota::create([
                'nama_kota' => $nama_kota,
            ]);
        }
    }
}
