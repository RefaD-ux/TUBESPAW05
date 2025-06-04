<?php
// app/Http/Controllers/KosController.php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\KategoriKos;
use App\Models\Kota;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class KosController extends Controller
{
     use AuthorizesRequests;
    /**
     * Tampilkan daftar semua kos (untuk umum/pencari).
     */
    public function index()
    {
        $kos = Kos::with(['kategori', 'kota', 'fasilitas'])->paginate(10); // Tampilkan 10 kos per halaman
        $kotaList = Kota::all();
        $kategoriList = KategoriKos::all();
        $fasilitasList = Fasilitas::all();

        return view('kos.index', compact('kos', 'kotaList', 'kategoriList', 'fasilitasList'));
    }

    /**
     * Tampilkan detail satu kos.
     */
    public function show(Kos $kos)
    {
        // Eager load relasi untuk detail lengkap
        $kos->load(['user', 'kategori', 'kota', 'fasilitas']);
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = $kos->favorites()->where('user_id', Auth::id())->exists();
        }

        return view('kos.detail', compact('kos', 'isFavorited'));
    }

    /**
     * Tampilkan form untuk membuat kos baru (hanya untuk pemilik).
     */
    public function create()
    {
        $this->authorize('create', Kos::class); // Authorize menggunakan policy

        $kategoriKos = KategoriKos::all();
        $kota = Kota::all();
        $fasilitas = Fasilitas::all();
        return view('kos.create', compact('kategoriKos', 'kota', 'fasilitas'));
    }

    /**
     * Simpan kos baru ke database (hanya untuk pemilik).
     */
    public function store(Request $request)
    {
        $this->authorize('create', Kos::class); // Authorize menggunakan policy

        $request->validate([
            'nama_kos' => 'required|string|max:255',
            'kategori_kos_id' => 'required|exists:kategori_kos,id',
            'kota_id' => 'required|exists:kota,id',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_per_bulan' => 'required|integer|min:100000',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'jumlah_kamar' => 'required|integer|min:1',
            'jenis_kos' => 'required|in:putra,putri,campur',
            'fasilitas' => 'array', // Array of facility IDs
            'fasilitas.*' => 'exists:fasilitas,id', // Each facility ID must exist
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('uploads', 'public');
        }

        $kos = Kos::create([
            'user_id' => Auth::id(), // Otomatis ambil ID pemilik yang sedang login
            'kategori_kos_id' => $request->kategori_kos_id,
            'kota_id' => $request->kota_id,
            'nama_kos' => $request->nama_kos,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'harga_per_bulan' => $request->harga_per_bulan,
            'gambar' => $gambarPath,
            'jumlah_kamar' => $request->jumlah_kamar,
            'jenis_kos' => $request->jenis_kos,
        ]);

        // Sinkronkan fasilitas
        if ($request->has('fasilitas')) {
            $kos->fasilitas()->sync($request->fasilitas);
        }

        return redirect()->route('dashboard.pemilik')->with('success', 'Kos berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk mengedit kos (hanya untuk pemilik kos yang bersangkutan).
     */
    public function edit(Kos $kos)
    {
        $this->authorize('update', $kos); // Authorize menggunakan policy

        $kategoriKos = KategoriKos::all();
        $kota = Kota::all();
        $fasilitas = Fasilitas::all();
        $selectedFasilitas = $kos->fasilitas->pluck('id')->toArray();

        return view('kos.edit', compact('kos', 'kategoriKos', 'kota', 'fasilitas', 'selectedFasilitas'));
    }

    /**
     * Update data kos di database (hanya untuk pemilik kos yang bersangkutan).
     */
    public function update(Request $request, Kos $kos)
    {
        $this->authorize('update', $kos); // Authorize menggunakan policy

        $request->validate([
            'nama_kos' => 'required|string|max:255',
            'kategori_kos_id' => 'required|exists:kategori_kos,id',
            'kota_id' => 'required|exists:kota,id',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_per_bulan' => 'required|integer|min:100000',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah_kamar' => 'required|integer|min:1',
            'jenis_kos' => 'required|in:putra,putri,campur',
            'fasilitas' => 'array',
            'fasilitas.*' => 'exists:fasilitas,id',
        ]);

        $gambarPath = $kos->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($kos->gambar) {
                Storage::disk('public')->delete($kos->gambar);
            }
            $gambarPath = $request->file('gambar')->store('uploads', 'public');
        }

        $kos->update([
            'kategori_kos_id' => $request->kategori_kos_id,
            'kota_id' => $request->kota_id,
            'nama_kos' => $request->nama_kos,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'harga_per_bulan' => $request->harga_per_bulan,
            'gambar' => $gambarPath,
            'jumlah_kamar' => $request->jumlah_kamar,
            'jenis_kos' => $request->jenis_kos,
        ]);

        // Sinkronkan fasilitas
        if ($request->has('fasilitas')) {
            $kos->fasilitas()->sync($request->fasilitas);
        } else {
            $kos->fasilitas()->detach(); // Hapus semua fasilitas jika tidak ada yang dipilih
        }

        return redirect()->route('dashboard.pemilik')->with('success', 'Data kos berhasil diperbarui!');
    }

    /**
     * Hapus kos dari database (hanya untuk pemilik kos yang bersangkutan).
     */
    public function destroy(Kos $kos)
    {
        $this->authorize('delete', $kos); // Authorize menggunakan policy

        // Hapus gambar terkait jika ada
        if ($kos->gambar) {
            Storage::disk('public')->delete($kos->gambar);
        }
        $kos->delete();

        return redirect()->route('dashboard.pemilik')->with('success', 'Kos berhasil dihapus.');
    }
}

?>
