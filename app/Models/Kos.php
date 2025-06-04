<?php
// app/Models/Kos.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    use HasFactory;

    protected $table = 'kos'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'kategori_kos_id',
        'kota_id',
        'nama_kos',
        'alamat',
        'deskripsi',
        'harga_per_bulan',
        'gambar',
        'jumlah_kamar',
        'jenis_kos',
    ];

    /**
     * Relasi: Satu Kos dimiliki oleh satu User (pemilik).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Kos memiliki satu KategoriKos.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriKos::class, 'kategori_kos_id');
    }

    /**
     * Relasi: Satu Kos berada di satu Kota.
     */
    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    /**
     * Relasi: Banyak Kos dapat memiliki banyak Fasilitas (Many-to-Many).
     */
    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'kos_fasilitas', 'kos_id', 'fasilitas_id');
    }

    /**
     * Relasi: Satu Kos memiliki banyak Booking.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi: Satu Kos memiliki banyak Favorite.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
