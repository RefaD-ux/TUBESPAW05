@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Manajemen Pengguna</h1>

    {{-- Tombol tambah user --}}
    <div class="mb-4 text-end">
        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary shadow-sm" style="border-radius: 90px; font-weight: 500; padding: 8px 20px; background: #fff;">
            + Tambah User Baru
        </a>
    </div>

    <div class="card shadow-sm" style="border-radius: 16px; margin-top: 24px;">
        <div class="card-body">
            @if ($users->isEmpty())
                <div class="alert alert-info">Belum ada pengguna yang terdaftar.</div>
            @else
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">{{ $user->role }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center" style="gap: 12px;">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" style="min-width:60px; min-height:40px; padding: 0 16px; display:flex; align-items:center; justify-content:center;">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-primary" style="min-width:90px; min-height:40px; padding: 0 16px; display:flex; align-items:center; justify-content:center;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
    /* Tambahkan jarak antar kolom tabel user */
    .table td, .table th {
        padding-left: 24px;
        padding-right: 24px;
    }
</style>
