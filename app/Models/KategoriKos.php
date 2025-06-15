<?php
// app/Models/KategoriKos.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKos extends Model
{
    use HasFactory;

    protected $table = 'kategori_kos'; // Nama tabel di database

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Relasi: Satu KategoriKos memiliki banyak Kos.
     */
    public function kos()
    {
        return $this->hasMany(Kos::class);
    }
}
