@extends('layouts.app')

@section('title', 'Tambah Kos Baru')

@section('content')
<div style="min-height: 90vh; display: flex; justify-content: center; align-items: center;">
    <div class="card mb-4" style="width: 100%; max-width: 800px; background-color: rgba(255,255,255,0.85); border: 1px solid #f3e8c7; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
        <div class="card-header text-center fw-bold" style="font-size:1.4rem;">Tambah Kos Baru</div>
        <div class="card-body">
            <form action="{{ route('kos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Kos --}}
                <div class="form-group mb-3">
                    <label for="nama_kos" class="fw-semibold">Nama Kos</label>
                    <input type="text" name="nama_kos" id="nama_kos" 
                           class="form-control @error('nama_kos') is-invalid @enderror" 
                           value="{{ old('nama_kos') }}" required>
                    @error('nama_kos')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Kategori Kos --}}
                <div class="form-group mb-3">
                    <label for="kategori_kos_id" class="fw-semibold">Kategori Kos</label>
                    <select name="kategori_kos_id" id="kategori_kos_id"
                            class="form-control @error('kategori_kos_id') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriKos as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_kos_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_kos_id')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Kota --}}
                <div class="form-group mb-3">
                    <label for="kota_id" class="fw-semibold">Kota</label>
                    <select name="kota_id" id="kota_id"
                            class="form-control @error('kota_id') is-invalid @enderror" required>
                        <option value="">Pilih Kota</option>
                        @foreach($kota as $k)
                            <option value="{{ $k->id }}" {{ old('kota_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kota }}
                            </option>
                        @endforeach
                    </select>
                    @error('kota_id')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group mb-3">
                    <label for="alamat" class="fw-semibold">Alamat Lengkap</label>
                    <input type="text" name="alamat" id="alamat"
                           class="form-control @error('alamat') is-invalid @enderror"
                           value="{{ old('alamat') }}" required>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group mb-3">
                    <label for="deskripsi" class="fw-semibold">Deskripsi Kos</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Harga per Bulan --}}
                <div class="form-group mb-3">
                    <label for="harga_per_bulan" class="fw-semibold">Harga Per Bulan (Rp)</label>
                    <input type="number" name="harga_per_bulan" id="harga_per_bulan"
                           class="form-control @error('harga_per_bulan') is-invalid @enderror"
                           value="{{ old('harga_per_bulan') }}" min="100000" required>
                    @error('harga_per_bulan')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Jumlah Kamar --}}
                <div class="form-group mb-3">
                    <label for="jumlah_kamar" class="fw-semibold">Jumlah Kamar Tersedia</label>
                    <input type="number" name="jumlah_kamar" id="jumlah_kamar"
                           class="form-control @error('jumlah_kamar') is-invalid @enderror"
                           value="{{ old('jumlah_kamar', 1) }}" min="1" required>
                    @error('jumlah_kamar')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Jenis Kos --}}
                <div class="form-group mb-3">
                    <label for="jenis_kos" class="fw-semibold">Jenis Kos</label>
                    <select name="jenis_kos" id="jenis_kos"
                            class="form-control @error('jenis_kos') is-invalid @enderror" required>
                        <option value="">Pilih Jenis</option>
                        <option value="putra" {{ old('jenis_kos') == 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ old('jenis_kos') == 'putri' ? 'selected' : '' }}>Putri</option>
                        <option value="campur" {{ old('jenis_kos') == 'campur' ? 'selected' : '' }}>Campur</option>
                    </select>
                    @error('jenis_kos')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Gambar Kos --}}
                <div class="form-group mb-3">
                    <label for="gambar" class="fw-semibold">Gambar Kos</label>
                    <input type="file" name="gambar" id="gambar"
                           class="form-control @error('gambar') is-invalid @enderror">
                    @error('gambar')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Fasilitas --}}
                <div class="form-group mb-4">
                    <label class="fw-semibold">Fasilitas</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                        @foreach($fasilitas as $f)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="fasilitas[]" value="{{ $f->id }}" id="fasilitas_{{ $f->id }}"
                                       {{ in_array($f->id, old('fasilitas', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fasilitas_{{ $f->id }}">
                                    {{ $f->nama_fasilitas }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('fasilitas')
                        <span class="invalid-feedback d-block" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-outline-primary" style="width: 100%;">Simpan Kos</button>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-image: url('/css/logo.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    .card.mb-4 {
        background-color: rgba(255, 255, 255, 0.85) !important;
        border: 1px solid #f3e8c7;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        backdrop-filter: blur(2px);
    }
    .form-group label {
        margin-bottom: 4px;
    }
    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .form-check-input {
        margin-right: 8px;
    }
    .form-check-label {
        margin-bottom: 0;
    }
</style>
@endsection
