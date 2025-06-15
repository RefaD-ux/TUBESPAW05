<?php
// app/Http/Controllers/PencarianController.php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Kota;
use App\Models\KategoriKos;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    /**
     * Tangani pencarian dan filter kos.
     */
    public function search(Request $request)
    {
        $query = Kos::query();

        // Filter berdasarkan kata kunci (nama kos, alamat, deskripsi)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_kos', 'like', '%' . $keyword . '%')
                  ->orWhere('alamat', 'like', '%' . $keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        // Filter berdasarkan kota
        if ($request->filled('kota_id') && $request->kota_id != 'all') {
            $query->where('kota_id', $request->kota_id);
        }

        // Filter berdasarkan kategori kos
        if ($request->filled('kategori_kos_id') && $request->kategori_kos_id != 'all') {
            $query->where('kategori_kos_id', $request->kategori_kos_id);
        }

        // Filter berdasarkan jenis kos
        if ($request->filled('jenis_kos') && $request->jenis_kos != 'all') {
            $query->where('jenis_kos', $request->jenis_kos);
        }

        // Filter berdasarkan harga (min-max)
        if ($request->filled('harga_min')) {
            $query->where('harga_per_bulan', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_per_bulan', '<=', $request->harga_max);
        }

        // Filter berdasarkan fasilitas (many-to-many)
        if ($request->has('fasilitas') && is_array($request->fasilitas) && count($request->fasilitas) > 0) {
            foreach ($request->fasilitas as $fasilitas_id) {
                $query->whereHas('fasilitas', function ($q) use ($fasilitas_id) {
                    $q->where('fasilitas.id', $fasilitas_id);
                });
            }
        }

        $kos = $query->with(['kategori', 'kota', 'fasilitas'])->paginate(10)->appends($request->except('page'));

        $kotaList = Kota::all();
        $kategoriList = KategoriKos::all();
        $fasilitasList = Fasilitas::all();

        return view('kos.index', compact('kos', 'kotaList', 'kategoriList', 'fasilitasList'));
    }
}

?>
