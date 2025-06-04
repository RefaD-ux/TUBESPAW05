<?php
// resources/views/booking/create.blade.php

?>
@extends('layouts.app')

@section('title', 'Booking Kos ' . $kos->nama_kos)

@section('content')
<div style="min-height: 90vh; display: flex; justify-content: center; align-items: center;">
    <div class="card mb-4" style="width: 100%; max-width: 600px; background-color: rgba(255,255,255,0.85); border: 1px solid #f3e8c7; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
        <div class="card-header text-center fw-bold" style="font-size:1.2rem;">Form Booking Kos: {{ $kos->nama_kos }}</div>
        <div class="card-body">
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kos_id" value="{{ $kos->id }}">

                <div class="form-group mb-3">
                    <label for="kos_name" class="fw-semibold">Nama Kos</label>
                    <input type="text" id="kos_name" class="form-control" value="{{ $kos->nama_kos }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="harga_per_bulan" class="fw-semibold">Harga Per Bulan</label>
                    <input type="text" id="harga_per_bulan" class="form-control" value="Rp {{ number_format($kos->harga_per_bulan, 0, ',', '.') }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_mulai" class="fw-semibold">Tanggal Mulai Booking</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}" required min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    @error('tanggal_mulai')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="tanggal_selesai" class="fw-semibold">Tanggal Selesai Booking</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary fw-bold" style="width: 100%;">Ajukan Booking</button>
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
</style>
@endsection
