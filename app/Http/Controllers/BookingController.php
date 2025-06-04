<?php
// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Tampilkan riwayat booking pengguna yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)
                            ->with('kos.user') // Load kos dan pemilik kos
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('booking.index', compact('bookings'));
    }

    /**
     * Tampilkan form untuk membuat booking baru.
     */
    public function create(Kos $kos)
    {
        // Pastikan hanya pencari yang bisa booking
        if (Auth::user()->role !== 'pencari') {
            return redirect()->back()->with('error', 'Hanya pencari kos yang bisa melakukan booking.');
        }
        return view('booking.create', compact('kos'));
    }

    /**
     * Simpan booking baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        // Pastikan hanya pencari yang bisa booking
        if (Auth::user()->role !== 'pencari') {
            return redirect()->back()->with('error', 'Hanya pencari kos yang bisa melakukan booking.');
        }

        $kos = Kos::findOrFail($request->kos_id);

        // Cek ketersediaan kamar (logika sederhana)
        // Anda bisa mengembangkan ini dengan memeriksa booking lain yang tumpang tindih
        $existingBookings = Booking::where('kos_id', $kos->id)
                                    ->where(function($query) use ($request) {
                                        $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                                              ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                                              ->orWhere(function($q) use ($request) {
                                                  $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                                                    ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                                              });
                                    })
                                    ->whereIn('status', ['pending', 'confirmed']) // Periksa booking yang masih aktif
                                    ->count();

        // Ini adalah logika sangat sederhana. Untuk sistem yang lebih kompleks, Anda perlu melacak kamar yang tersedia.
        // Untuk saat ini, kita asumsikan kos memiliki banyak kamar dan tidak ada batasan jumlah booking.
        // Jika Anda ingin membatasi berdasarkan 'jumlah_kamar', Anda perlu logika yang lebih kompleks.
        // Contoh sederhana:
        // if ($existingBookings >= $kos->jumlah_kamar) {
        //     return redirect()->back()->with('error', 'Maaf, kamar penuh pada tanggal tersebut.');
        // }


        Booking::create([
            'user_id' => Auth::id(),
            'kos_id' => $kos->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'pending', // Status awal booking
        ]);

        return redirect()->route('booking.index')->with('success', 'Permintaan booking Anda telah dikirim. Menunggu konfirmasi pemilik.');
    }

    /**
     * Update status booking (hanya untuk pemilik kos terkait).
     * Pemilik bisa mengkonfirmasi atau membatalkan booking.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        // Pastikan pemilik kos yang terkait yang mengupdate status
        if (Auth::user()->role !== 'pemilik' || $booking->kos->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status booking ini.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.pemilik')->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Batalkan booking (oleh pencari).
     */
    public function cancel(Booking $booking)
    {
        // Pastikan pengguna yang membatalkan adalah pemilik booking atau pemilik kos
        if (Auth::id() !== $booking->user_id && Auth::id() !== $booking->kos->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan booking ini.');
        }

        // Hanya booking pending yang bisa dibatalkan oleh pencari
        if ($booking->status === 'pending' || $booking->status === 'confirmed') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Booking tidak dapat dibatalkan pada status ini.');
    }
}

?>
