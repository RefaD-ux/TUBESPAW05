<?php
// resources/views/kos/detail.blade.php

?>
@extends('layouts.app')

@section('title', 'Detail Kos ' . $kos->nama_kos)

@section('content')
<div class="container">
    <a href="{{ route('kos.index') }}" class="btn btn-outline-primary mb-3"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Kos</a>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-start">
                <div class="kos-image" style="flex: 0 0 400px; max-width: 100%; margin-right: 20px;">
                    @if($kos->gambar)
                        <img src="{{ asset('storage/' . $kos->gambar) }}" alt="Gambar Kos {{ $kos->nama_kos }}" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                    @else
                        <img src="https://placehold.co/600x300/cccccc/333333?text=No+Image" alt="No Image" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                    @endif
                </div>
                <div class="kos-info" style="flex-grow: 1; width: 100%;">
                    <h1 style="margin-top: 0;">{{ $kos->nama_kos }}</h1>
                    <p style="font-size: 1.2em; color: var(--primary-color); font-weight: bold;">Rp {{ number_format($kos->harga_per_bulan, 0, ',', '.') }} / bulan</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $kos->alamat }}, {{ $kos->kota->nama_kota }}</p>
                    <p><strong>Jenis Kos:</strong> {{ ucfirst($kos->jenis_kos) }}</p>
                    <p><strong>Kategori:</strong> {{ $kos->kategori->nama_kategori }}</p>
                    <p><strong>Jumlah Kamar:</strong> {{ $kos->jumlah_kamar }}</p>
                    <p><strong>Pemilik:</strong> {{ $kos->user->name }}</p>

                    <h4 class="mt-4">Deskripsi:</h4>
                    <p>{{ $kos->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                    <h4 class="mt-4">Fasilitas:</h4>
                    @if($kos->fasilitas->isNotEmpty())
                        <ul style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 10px;">
                            @foreach($kos->fasilitas as $fasilitas)
                                <li style="background-color: #e0e0e0; padding: 5px 10px; border-radius: 5px; font-size: 0.9em;">
                                    <i class="fas fa-check-circle" style="color: green;"></i> {{ $fasilitas->nama_fasilitas }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Tidak ada fasilitas yang terdaftar.</p>
                    @endif

                    <div class="mt-4 d-flex gap-4">
                        @auth
                            @if(Auth::user()->role === 'pencari')
                                <a href="{{ route('booking.create', $kos->id) }}" class="btn btn-primary btn-lg">Booking Sekarang</a>

                                <button id="favoriteButton" class="btn btn-outline-primary btn-lg" data-kos-id="{{ $kos->id }}" data-is-favorited="{{ $isFavorited ? 'true' : 'false' }}">
                                    <i class="fas fa-heart {{ $isFavorited ? 'text-danger' : '' }}"></i>
                                    <span id="favoriteText">{{ $isFavorited ? 'Hapus dari Favorit' : 'Tambahkan ke Favorit' }}</span>
                                </button>
                            @elseif(Auth::user()->id === $kos->user_id)
                                <a href="{{ route('kos.edit', $kos->id) }}" class="btn btn-secondary btn-lg">Edit Kos Ini</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Booking</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const favoriteButton = document.getElementById('favoriteButton');
        if (favoriteButton) {
            favoriteButton.addEventListener('click', function() {
                const kosId = this.dataset.kosId;
                let isFavorited = this.dataset.isFavorited === 'true';
                const favoriteIcon = this.querySelector('.fa-heart');
                const favoriteText = document.getElementById('favoriteText');

                let url = '';
                let method = '';

                if (isFavorited) {
                    // Jika sudah difavoritkan, berarti ingin menghapus
                    url = `/favorites/remove/${kosId}`;
                    method = 'DELETE';
                } else {
                    // Jika belum difavoritkan, berarti ingin menambahkan
                    url = `/favorites/add/${kosId}`;
                    method = 'POST';
                }

                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ kos_id: kosId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        favoriteIcon.classList.add('text-danger');
                        favoriteText.textContent = 'Hapus dari Favorit';
                        favoriteButton.dataset.isFavorited = 'true';
                        alert(data.message); // Ganti dengan modal UI jika tidak ingin alert
                    } else if (data.status === 'removed') {
                        favoriteIcon.classList.remove('text-danger');
                        favoriteText.textContent = 'Tambahkan ke Favorit';
                        favoriteButton.dataset.isFavorited = 'false';
                        alert(data.message); // Ganti dengan modal UI jika tidak ingin alert
                    } else {
                        alert('Terjadi kesalahan: ' + data.message); // Ganti dengan modal UI
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses permintaan.'); // Ganti dengan modal UI
                });
            });
        }
    });
</script>
@endsection
