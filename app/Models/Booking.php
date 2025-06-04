<?php
// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'kos_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    /**
     * Relasi: Satu Booking dimiliki oleh satu User (pencari).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Booking terkait dengan satu Kos.
     */
    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}