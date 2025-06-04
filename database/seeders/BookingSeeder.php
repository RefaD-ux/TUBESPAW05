<?php
// database/seeders/BookingSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Kos;
use Carbon\Carbon; // Untuk tanggal

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pencari = User::where('role', 'pencari')->first();
        if (!$pencari) {
            $pencari = User::factory()->create(['role' => 'pencari']);
        }

        $kos = Kos::inRandomOrder()->first(); // Ambil satu kos secara acak
        if (!$kos) {
            // Jika tidak ada kos, jalankan KosSeeder
            $this->call(KosSeeder::class);
            $kos = Kos::inRandomOrder()->first();
        }

        if ($pencari && $kos) {
            Booking::create([
                'user_id' => $pencari->id,
                'kos_id' => $kos->id,
                'tanggal_mulai' => Carbon::now()->addDays(7), // Seminggu dari sekarang
                'tanggal_selesai' => Carbon::now()->addMonths(1)->addDays(7), // Sebulan dari tanggal mulai
                'status' => 'pending',
            ]);

            Booking::create([
                'user_id' => $pencari->id,
                'kos_id' => Kos::inRandomOrder()->where('id', '!=', $kos->id)->first()->id ?? $kos->id, // Ambil kos lain
                'tanggal_mulai' => Carbon::now()->addMonths(2),
                'tanggal_selesai' => Carbon::now()->addMonths(3),
                'status' => 'confirmed',
            ]);
        }
    }
}