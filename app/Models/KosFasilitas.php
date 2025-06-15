<?php
// app/Models/KosFasilitas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KosFasilitas extends Model
{
    use HasFactory;

    protected $table = 'kos_fasilitas'; // Nama tabel pivot
    protected $fillable = [
        'kos_id',
        'fasilitas_id',
    ];
}
