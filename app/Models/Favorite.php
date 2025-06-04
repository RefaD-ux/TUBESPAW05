<?php
// app/Models/Favorite.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'kos_id',
    ];

    /**
     * Relasi: Satu Favorite dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Favorite terkait dengan satu Kos.
     */
    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}