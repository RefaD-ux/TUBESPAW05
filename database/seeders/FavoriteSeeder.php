<?php
// database/seeders/FavoriteSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Kos;

class FavoriteSeeder extends Seeder
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

        $kos = Kos::inRandomOrder()->take(2)->get(); // Ambil 2 kos secara acak
        if ($kos->isEmpty()) {
            // Jika tidak ada kos, jalankan KosSeeder
            $this->call(KosSeeder::class);
            $kos = Kos::inRandomOrder()->take(2)->get();
        }

        if ($pencari && $kos->isNotEmpty()) {
            foreach ($kos as $k) {
                Favorite::create([
                    'user_id' => $pencari->id,
                    'kos_id' => $k->id,
                ]);
            }
        }
    }
}
