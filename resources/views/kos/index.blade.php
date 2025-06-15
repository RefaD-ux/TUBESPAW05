<?php
// resources/views/kos/index.blade.php

?>
@extends('layouts.app')

@section('title', 'Cari Kos Impianmu')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Temukan Kos Impianmu</h1>

    <div class="card mb-4">
        <div class="card-header">Filter Pencarian</div>
        <div class="card-body">
            <form action="{{ route('pencarian.search') }}" method="GET" id="filterForm">
                <div class="form-group">
                    <label for="keyword">Kata Kunci (Nama Kos, Alamat, Deskripsi)</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="Cari kos...">
                </div>

                <div class="d-flex flex-wrap gap-4 mb-3">
                    <div class="form-group" style="flex: 1; min-width: 180px;">
                        <label for="kota_id">Kota</label>
                        <select name="kota_id" id="kota_id" class="form-control">
                            <option value="all">Semua Kota</option>
                            @foreach($kotaList as $kota)
                                <option value="{{ $kota->id }}" {{ request('kota_id') == $kota->id ? 'selected' : '' }}>{{ $kota->nama_kota }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1; min-width: 180px;">
                        <label for="kategori_kos_id">Kategori Kos</label>
                        <select name="kategori_kos_id" id="kategori_kos_id" class="form-control">
                            <option value="all">Semua Kategori</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_kos_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1; min-width: 180px;">
                        <label for="jenis_kos">Jenis Kos</label>
                        <select name="jenis_kos" id="jenis_kos" class="form-control">
                            <option value="all">Semua Jenis</option>
                            <option value="putra" {{ request('jenis_kos') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ request('jenis_kos') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ request('jenis_kos') == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-4 mb-3">
                    <div class="form-group" style="flex: 1; min-width: 150px;">
                        <label for="harga_min">Harga Min (Rp)</label>
                        <input type="number" name="harga_min" id="harga_min" class="form-control" value="{{ request('harga_min') }}" placeholder="Contoh: 500000">
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 150px;">
                        <label for="harga_max">Harga Max (Rp)</label>
                        <input type="number" name="harga_max" id="harga_max" class="form-control" value="{{ request('harga_max') }}" placeholder="Contoh: 2000000">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Fasilitas</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px;">
                        @foreach($fasilitasList as $fasilitas)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fasilitas[]" value="{{ $fasilitas->id }}" id="fasilitas_{{ $fasilitas->id }}"
                                    {{ in_array($fasilitas->id, (array)request('fasilitas')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fasilitas_{{ $fasilitas->id }}">
                                    {{ $fasilitas->nama_fasilitas }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Perubahan di sini: class mb-3 dihapus dari tombol Cari Kos --}}
                <button type="submit" class="btn btn-outline-primary" style="width: 100%; margin-top: 15px;">Cari Kos</button>
                {{-- Perubahan di sini: margin-top: 15px ditambahkan ke style tombol Reset Filter --}}
                <button type="button" id="resetFilterBtn" class="btn btn-outline-primary" style="width: 100%; margin-top: 15px;">Reset Filter</button>
            </form>
        </div>
    </div>  

    <div class="kos-list">
        @if($kos->isEmpty())
            <p class="text-center">Tidak ada kos yang ditemukan dengan kriteria pencarian Anda.</p>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                @foreach($kos as $item)
                    <div class="card kos-item" style="overflow: hidden;">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Kos {{ $item->nama_kos }}" style="width: 100%; height: 200px; object-fit: cover;">
                        @else
                            <img src="https://placehold.co/400x200/cccccc/333333?text=No+Image" alt="No Image" style="width: 100%; height: 200px; object-fit: cover;">
                        @endif
                        <div class="p-3">
                            <h4 style="margin-top: 0; margin-bottom: 10px;"><a href="{{ route('kos.show', $item->id) }}" style="color: var(--primary-color); text-decoration: none;">{{ $item->nama_kos }}</a></h4>
                            <p style="margin-bottom: 5px; font-size: 0.9em; color: #666;"><i class="fas fa-map-marker-alt"></i> {{ $item->alamat }}, {{ $item->kota->nama_kota }}</p>
                            <p style="margin-bottom: 5px; font-weight: bold; color: var(--primary-color);">Rp {{ number_format($item->harga_per_bulan, 0, ',', '.') }} / bulan</p>
                            <p style="margin-bottom: 15px; font-size: 0.9em;">
                                <span style="background-color:rgb(224, 224, 224); padding: 3px 8px; border-radius: 5px; font-size: 0.8em;">{{ $item->kategori->nama_kategori }} {{ ucfirst($item->jenis_kos) }}</span>
                            </p>
                            <a href="{{ route('kos.show', $item->id) }}" class="btn btn-primary btn-sm" style="width: 100%;">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $kos->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>

<style>
    body {
        background-image: url('/css/logo.png'); /* Ganti dengan path gambar Anda */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    .card.mb-4 {
        background-color: rgba(255, 255, 255, 0.77) !important; /* transparan */
        border: 1px solid #f3e8c7;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        backdrop-filter: blur(2px); /* efek blur jika ingin lebih modern */
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        border: 1px solid var(--border-color);
        padding: 10px;
        text-align: left;
    }
    .table thead tr {
        background-color: var(--light-gray);
    }
    .kos-item {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kos-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px var(--shadow-color);
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

{{-- Tambahkan script ini di bagian bawah konten --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resetFilterBtn = document.getElementById('resetFilterBtn');
        const filterForm = document.getElementById('filterForm');

        if (resetFilterBtn && filterForm) {
            resetFilterBtn.addEventListener('click', function() {
                // Reset input text
                document.getElementById('keyword').value = '';

                // Reset select dropdowns ke opsi "all"
                document.getElementById('kota_id').value = 'all';
                document.getElementById('kategori_kos_id').value = 'all';
                document.getElementById('jenis_kos').value = 'all';

                // Reset harga min dan max
                document.getElementById('harga_min').value = '';
                document.getElementById('harga_max').value = '';

                // Uncheck semua fasilitas
                document.querySelectorAll('input[name="fasilitas[]"]:checked').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Submit form setelah mereset semua input
                filterForm.submit();
            });
        }
    });
</script>
@endsection