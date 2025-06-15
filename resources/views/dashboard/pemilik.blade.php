<?php
// resources/views/dashboard/pemilik.blade.php

?>
@extends('layouts.app')

@section('title', 'Dashboard Pemilik Kos')

@section('content')
<div class="container">
    <h1 class="mb-4">Selamat Datang, {{ Auth::user()->name }}!</h1>
    <p>Anda login sebagai Pemilik Kos.</p>

    <div class="card mb-4">
        <div class="card-header">Ringkasan Kos Anda</div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Daftar Kos yang Anda Kelola</h3>
                <a href="{{ route('kos.create') }}" class="btn btn-primary">Tambah Kos Baru</a>
            </div>

            @if($kosSaya->isEmpty())
                <p class="text-center">Anda belum memiliki kos yang terdaftar. Yuk, <a href="{{ route('kos.create') }}">tambahkan kos pertama Anda</a>!</p>
            @else
                <div class="table-responsive">
                    <table class="table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--light-gray);">
                                <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Nama Kos</th>
                                <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Lokasi</th>
                                <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Harga/Bulan</th>
                                <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Jumlah Booking</th>
                                <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kosSaya as $kos)
                                <tr>
                                    <td style="padding: 10px; border: 1px solid var(--border-color);">{{ $kos->nama_kos }}</td>
                                    <td style="padding: 10px; border: 1px solid var(--border-color);">{{ $kos->kota->nama_kota }}</td>
                                    <td style="padding: 10px; border: 1px solid var(--border-color);">Rp {{ number_format($kos->harga_per_bulan, 0, ',', '.') }}</td>
                                    <td style="padding: 10px; border: 1px solid var(--border-color);">{{ $kos->bookings->count() }}</td>
                                    <td style="padding: 10px; border: 1px solid var(--border-color);">
                                        <a href="{{ route('kos.show', $kos->id) }}" class="btn btn-primary btn-sm" style="padding: 5px 10px; font-size: 0.9em;">Lihat</a>
                                        <a href="{{ route('kos.edit', $kos->id) }}" class="btn btn-secondary btn-sm" style="padding: 5px 10px; font-size: 0.9em;">Edit</a>
                                        <form action="{{ route('kos.destroy', $kos->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="background-color: #dc3545; color: #fff; padding: 5px 10px; font-size: 0.9em;" onclick="return confirm('Apakah Anda yakin ingin menghapus kos ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">Permintaan Booking Masuk</div>
        <div class="card-body">
            @php
                $hasPendingBookings = false;
            @endphp
            @foreach($kosSaya as $kos)
                @foreach($kos->bookings->where('status', 'pending') as $booking)
                    @php
                        $hasPendingBookings = true;
                    @endphp
                    <div class="booking-item card mb-3 p-3">
                        <p><strong>Kos:</strong> {{ $booking->kos->nama_kos }}</p>
                        <p><strong>Pencari:</strong> {{ $booking->user->name }} ({{ $booking->user->email }})</p>
                        <p><strong>Tanggal Booking:</strong> {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</p>
                        <p><strong>Status:</strong> <span style="color: orange; font-weight: bold;">{{ ucfirst($booking->status) }}</span></p>
                        <div class="d-flex gap-4">
                            <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-primary btn-sm">Konfirmasi</button>
                            </form>
                            <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger btn-sm" style="background-color: #dc3545;">Tolak</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endforeach

            @if(!$hasPendingBookings)
                <p class="text-center">Tidak ada permintaan booking yang tertunda saat ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection
