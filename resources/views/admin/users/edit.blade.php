@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pengguna</h1>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pemilik" {{ $user->role === 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                <option value="pencari" {{ $user->role === 'pencari' ? 'selected' : '' }}>Pencari</option>
            </select>
        </div>

        <button type="submit" class="btn btn-sm fw-bold" style="width:170px; height:40px; padding: 0 16px; text-align:center; background-color:#6c757d; color:white; border:none;">
            Simpan
        </button>

        <a href="{{ route('admin.users.index') }}" class="btn btn-sm fw-bold ms-2" style="width:170px; height:40px; padding: 0 16px; text-align:center; background-color:#6c757d; color:white; border:none; display:inline-block; line-height:40px;">
            Kembali
        </a>


    </form>
</div>
@endsection
