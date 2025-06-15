<?php
// database/seeders/KosFasilitasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kos;
use App\Models\Fasilitas;

class KosFasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kos1 = Kos::where('nama_kos', 'Kos Melati Indah')->first();
        $kos2 = Kos::where('nama_kos', 'Kos Bintang Jaya')->first();
        // ... (jika ada lebih banyak kos, tambahkan di sini)

        $fasilitasAC = Fasilitas::where('nama_fasilitas', 'AC')->first();
        $fasilitasWifi = Fasilitas::where('nama_fasilitas', 'Wi-Fi')->first();
        $fasilitasKMDalam = Fasilitas::where('nama_fasilitas', 'Kamar Mandi Dalam')->first();
        $fasilitasKasur = Fasilitas::where('nama_fasilitas', 'Kasur')->first();
        $fasilitasMejaBelajar = Fasilitas::where('nama_fasilitas', 'Meja Belajar')->first();
        $fasilitasLemariPakaian = Fasilitas::where('nama_fasilitas', 'Lemari Pakaian')->first();
        // ... (jika ada lebih banyak fasilitas, tambahkan di sini)


        // Hubungkan Fasilitas untuk Kos Melati Indah
        if ($kos1 && $fasilitasAC && $fasilitasWifi && $fasilitasKMDalam) {
            $kos1->fasilitas()->attach([
                $fasilitasAC->id,
                $fasilitasWifi->id,
                $fasilitasKMDalam->id,
            ]);
        }

        // Hubungkan Fasilitas untuk Kos Bintang Jaya
        if ($kos2 && $fasilitasKasur && $fasilitasMejaBelajar && $fasilitasLemariPakaian) {
            $kos2->fasilitas()->attach([
                $fasilitasKasur->id,
                $fasilitasMejaBelajar->id,
                $fasilitasLemariPakaian->id,
            ]);
        }

        // ... (lanjutkan untuk kos lainnya dan fasilitas yang sesuai)
    }
}