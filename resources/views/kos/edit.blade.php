<?php
// resources/views/kos/edit.blade.php

?>
@extends('layouts.app')

@section('title', 'Edit Kos ' . $kos->nama_kos)

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card" style="width: 100%; max-width: 800px;">
        <div class="card-header text-center">Edit Kos: {{ $kos->nama_kos }}</div>
        <div class="card-body">
            <form action="{{ route('kos.update', $kos->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_kos">Nama Kos</label>
                    <input type="text" name="nama_kos" id="nama_kos" class="form-control @error('nama_kos') is-invalid @enderror" value="{{ old('nama_kos', $kos->nama_kos) }}" required>
                    @error('nama_kos')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kategori_kos_id">Kategori Kos</label>
                    <select name="kategori_kos_id" id="kategori_kos_id" class="form-control @error('kategori_kos_id') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriKos as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_kos_id', $kos->kategori_kos_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_kos_id')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kota_id">Kota</label>
                    <select name="kota_id" id="kota_id" class="form-control @error('kota_id') is-invalid @enderror" required>
                        <option value="">Pilih Kota</option>
                        @foreach($kota as $k)
                            <option value="{{ $k->id }}" {{ old('kota_id', $kos->kota_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kota }}</option>
                        @endforeach
                    </select>
                    @error('kota_id')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap</label>
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $kos->alamat) }}" required>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Kos</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5">{{ old('deskripsi', $kos->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga_per_bulan">Harga Per Bulan (Rp)</label>
                    <input type="number" name="harga_per_bulan" id="harga_per_bulan" class="form-control @error('harga_per_bulan') is-invalid @enderror" value="{{ old('harga_per_bulan', $kos->harga_per_bulan) }}" required min="100000">
                    @error('harga_per_bulan')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah_kamar">Jumlah Kamar Tersedia</label>
                    <input type="number" name="jumlah_kamar" id="jumlah_kamar" class="form-control @error('jumlah_kamar') is-invalid @enderror" value="{{ old('jumlah_kamar', $kos->jumlah_kamar) }}" required min="1">
                    @error('jumlah_kamar')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kos">Jenis Kos</label>
                    <select name="jenis_kos" id="jenis_kos" class="form-control @error('jenis_kos') is-invalid @enderror" required>
                        <option value="">Pilih Jenis</option>
                        <option value="putra" {{ old('jenis_kos', $kos->jenis_kos) == 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ old('jenis_kos', $kos->jenis_kos) == 'putri' ? 'selected' : '' }}>Putri</option>
                        <option value="campur" {{ old('jenis_kos', $kos->jenis_kos) == 'campur' ? 'selected' : '' }}>Campur</option>
                    </select>
                    @error('jenis_kos')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Kos (biarkan kosong jika tidak ingin mengubah)</label>
                    @if($kos->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $kos->gambar) }}" alt="Gambar Kos Saat Ini" style="max-width: 200px; height: auto; border-radius: 5px;">
                        </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror">
                    @error('gambar')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label>Fasilitas</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                        @foreach($fasilitas as $f)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fasilitas[]" value="{{ $f->id }}" id="fasilitas_{{ $f->id }}"
                                    {{ in_array($f->id, old('fasilitas', $selectedFasilitas)) ? 'checked' : '' }}>
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

                <button type="submit" class="btn btn-primary" style="width: 100%;">Update Kos</button>
            </form>
        </div>
    </div>
</div>
@endsection
