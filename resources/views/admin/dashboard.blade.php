@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="card-text fs-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pemilik Kos</h5>
                    <p class="card-text fs-4">{{ $pemilikCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pencari Kos</h5>
                    <p class="card-text fs-4">{{ $pencariCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="nav-link btn btn-outline-primary">Kelola Pengguna</a>
</div>
@endsection
