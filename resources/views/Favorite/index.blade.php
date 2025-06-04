<?php
// resources/views/favorite/index.blade.php

?>
@extends('layouts.app')

@section('title', 'Kos Favorit Saya')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Kos Favorit Saya</h1>

    @if($favorites->isEmpty())
        <p class="text-center">Anda belum memiliki kos favorit. <a href="{{ route('kos.index') }}" style="color: var(--primary-color); text-decoration: none;">Cari kos untuk ditambahkan ke favorit</a>!</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            @foreach($favorites as $favorite)
                <div class="card kos-item" style="overflow: hidden;">
                    @if($favorite->kos->gambar)
                        <img src="{{ asset('storage/' . $favorite->kos->gambar) }}" alt="Gambar Kos {{ $favorite->kos->nama_kos }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <img src="https://placehold.co/400x200/cccccc/333333?text=No+Image" alt="No Image" style="width: 100%; height: 200px; object-fit: cover;">
                    @endif
                    <div class="p-3">
                        <h4 style="margin-top: 0; margin-bottom: 10px;"><a href="{{ route('kos.show', $favorite->kos->id) }}" style="color: var(--primary-color); text-decoration: none;">{{ $favorite->kos->nama_kos }}</a></h4>
                        <p style="margin-bottom: 5px; font-size: 0.9em; color: #666;"><i class="fas fa-map-marker-alt"></i> {{ $favorite->kos->alamat }}, {{ $favorite->kos->kota->nama_kota }}</p>
                        <p style="margin-bottom: 5px; font-weight: bold; color: var(--primary-color);">Rp {{ number_format($favorite->kos->harga_per_bulan, 0, ',', '.') }} / bulan</p>
                        <p style="margin-bottom: 15px; font-size: 0.9em;">
                            <span style="background-color: #e0e0e0; padding: 3px 8px; border-radius: 5px; font-size: 0.8em;">{{ $favorite->kos->kategori->nama_kategori }} {{ ucfirst($favorite->kos->jenis_kos) }}</span>
                        </p>
                        <a href="{{ route('kos.show', $favorite->kos->id) }}" class="btn btn-primary btn-sm" style="width: 100%;">Lihat Detail</a>
                        <form action="{{ route('favorite.remove', $favorite->kos->id) }}" method="POST" style="display: inline-block; width: 100%; margin-top: 10px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-primary btn-sm" style="width: 100%;" onclick="return confirm('Apakah Anda yakin ingin menghapus kos ini dari favorit?')">
                                <i class="fas fa-heart text-danger"></i> Hapus dari Favorit
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    /* Re-use kos-item styles from kos/index.blade.php */
    .kos-item {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kos-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px var(--shadow-color);
    }
</style>
@endsection
