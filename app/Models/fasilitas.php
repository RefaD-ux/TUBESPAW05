<?php
// app/Models/Fasilitas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas'; // Nama tabel di database

    protected $fillable = [
        'nama_fasilitas',
    ];

    /**
     * Relasi: Banyak Fasilitas dapat dimiliki oleh banyak Kos (Many-to-Many).
     */
    public function kos()
    {
        return $this->belongsToMany(Kos::class, 'kos_fasilitas', 'fasilitas_id', 'kos_id');
    }
}