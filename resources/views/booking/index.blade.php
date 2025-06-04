<?php
// resources/views/booking/index.blade.php

?>
@extends('layouts.app')

@section('title', 'Riwayat Booking Saya')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Riwayat Booking Saya</h1>

    @if($bookings->isEmpty())
        <p class="text-center">Anda belum memiliki riwayat booking. <a href="{{ route('kos.index') }}" style="color: var(--primary-color); text-decoration: none;">Cari kos sekarang</a>!</p>
    @else
        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: var(--light-gray);">
                        <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Nama Kos</th>
                        <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Pemilik</th>
                        <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Tanggal Mulai</th>
                        <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Tanggal Selesai</th>
                        <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Status</th>
                        <th style="padding: 10px; border: 1px solid var(--border-color); text-align: left;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td style="padding: 10px; border: 1px solid var(--border-color);">
                                <a href="{{ route('kos.show', $booking->kos->id) }}" style="color: var(--primary-color); text-decoration: none;">{{ $booking->kos->nama_kos }}</a>
                            </td>
                            <td style="padding: 10px; border: 1px solid var(--border-color);">{{ $booking->kos->user->name }}</td>
                            <td style="padding: 10px; border: 1px solid var(--border-color);">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</td>
                            <td style="padding: 10px; border: 1px solid var(--border-color);">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</td>
                            <td style="padding: 10px; border: 1px solid var(--border-color);">
                                @if($booking->status == 'pending')
                                    <span style="color: orange; font-weight: bold;">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status == 'confirmed')
                                    <span style="color: green; font-weight: bold;">{{ ucfirst($booking->status) }}</span>
                                @else
                                    <span style="color: gray; font-weight: bold;">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid var(--border-color);">
                                @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm" style="background-color: #dc3545; color: #fff; padding: 5px 10px; font-size: 0.9em;" onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">Batalkan</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
