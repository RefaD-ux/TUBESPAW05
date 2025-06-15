<?php
// database/seeders/KosSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kos;
use App\Models\User;
use App\Models\KategoriKos;
use App\Models\Kota;
use App\Models\Fasilitas;

class KosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemilikUser = User::where('role', 'pemilik')->first();
        $kategoriKos = KategoriKos::all();
        $kota = Kota::all();
        // $fasilitas = Fasilitas::all(); // Tidak diperlukan lagi di sini

        if (!$pemilikUser || $kategoriKos->isEmpty() || $kota->isEmpty()) {
            $this->command->info('Skip KosSeeder: Pemilik, Kategori, atau Kota tidak ditemukan.');
            return;
        }

        // Sample Kos 1
        Kos::create([
            'user_id' => $pemilikUser->id,
            'kategori_kos_id' => $kategoriKos->random()->id,
            'kota_id' => $kota->random()->id,
            'nama_kos' => 'Kos Melati Indah',
            'alamat' => 'Jl. Mawar No. 10',
            'deskripsi' => 'Kos nyaman dengan fasilitas lengkap di pusat kota.',
            'harga_per_bulan' => 1500000,
            'gambar' => 'kos/kos_melati.jpg',
            'jumlah_kamar' => 10,
            'jenis_kos' => 'putri',
        ]);
        // Hapus baris ini dan sejenisnya: $kos1->fasilitas()->attach([...]);

        // Sample Kos 2
        Kos::create([
            'user_id' => $pemilikUser->id,
            'kategori_kos_id' => $kategoriKos->random()->id,
            'kota_id' => $kota->random()->id,
            'nama_kos' => 'Kos Bintang Jaya',
            'alamat' => 'Jl. Sudirman No. 50',
            'deskripsi' => 'Kos strategis dekat kampus dan pusat perbelanjaan.',
            'harga_per_bulan' => 1200000,
            'gambar' => 'kos/kos_bintang.jpg',
            'jumlah_kamar' => 8,
            'jenis_kos' => 'putra',
        ]);
        // Hapus baris ini dan sejenisnya: $kos2->fasilitas()->attach([...]);

        // ... (lanjutkan untuk semua data kos lainnya, tetapi tanpa attach fasilitas)
    }
}