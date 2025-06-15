<?php
// app/Models/Kota.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'kota'; // Nama tabel di database

    protected $fillable = [
        'nama_kota',
    ];

    /**
     * Relasi: Satu Kota memiliki banyak Kos.
     */
    public function kos()
    {
        return $this->hasMany(Kos::class);
    }
}