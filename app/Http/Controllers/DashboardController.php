<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kos;
use App\Models\Booking;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard untuk pemilik kos.
     */
    public function adminDashboard()
    {
    // Hanya boleh diakses oleh admin
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Anda bukan admin.');
        }

        $totalUsers = \App\Models\User::count();
        $pemilikCount = \App\Models\User::where('role', 'pemilik')->count();
        $pencariCount = \App\Models\User::where('role', 'pencari')->count();

        return view('admin.dashboard', compact('totalUsers', 'pemilikCount', 'pencariCount'));

    }

    public function pemilikDashboard()
    {
        $user = Auth::user();

        // Cek peran pengguna
        if ($user->role !== 'pemilik') {
            abort(403, 'Akses ditolak. Anda bukan pemilik kos.');
        }

        $kosSaya = Kos::where('user_id', $user->id)->with('bookings')->get();

        return view('dashboard.pemilik', compact('kosSaya'));
    }

    /**
     * Tampilkan dashboard untuk pencari kos.
     */
    public function pencariDashboard()
    {
        $user = Auth::user();

        // Cek peran pengguna
        if ($user->role !== 'pencari') {
            abort(403, 'Akses ditolak. Anda bukan pencari kos.');
        }

        $riwayatBooking = Booking::where('user_id', $user->id)
                                ->with('kos')
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('dashboard.pencari', compact('riwayatBooking'));
    }
}