<?php
// app/Http/Controllers/FavoriteController.php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Tampilkan daftar kos favorit pengguna yang sedang login.
     */
    public function index()
    {
        // Pastikan hanya pencari yang bisa melihat favorit
        if (Auth::user()->role !== 'pencari') {
            return redirect()->back()->with('error', 'Hanya pencari kos yang bisa melihat daftar favorit.');
        }

        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)
                             ->with('kos.kota', 'kos.kategori', 'kos.fasilitas') // Eager load relasi kos
                             ->get();

        return view('favorite.index', compact('favorites'));
    }

    /**
     * Tambahkan kos ke daftar favorit.
     */
    public function add(Request $request, Kos $kos)
    {
        // Pastikan pengguna sudah login dan adalah pencari
        if (!Auth::check() || Auth::user()->role !== 'pencari') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Cek apakah kos sudah difavoritkan
        $existingFavorite = Favorite::where('user_id', Auth::id())
                                    ->where('kos_id', $kos->id)
                                    ->first();

        if ($existingFavorite) {
            return response()->json(['message' => 'Kos sudah ada di favorit.'], 409);
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'kos_id' => $kos->id,
        ]);

        return response()->json(['message' => 'Kos berhasil ditambahkan ke favorit.', 'status' => 'added'], 200);
    }

    /**
     * Hapus kos dari daftar favorit.
     */
    public function remove(Request $request, Kos $kos)
    {
        // Pastikan pengguna sudah login dan adalah pencari
        if (!Auth::check() || Auth::user()->role !== 'pencari') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $favorite = Favorite::where('user_id', Auth::id())
                            ->where('kos_id', $kos->id)
                            ->first();

        if (!$favorite) {
            return response()->json(['message' => 'Kos tidak ditemukan di favorit.'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Kos berhasil dihapus dari favorit.', 'status' => 'removed'], 200);
    }
}

?>
