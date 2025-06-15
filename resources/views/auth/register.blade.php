@extends('layouts.app')

@section('title', 'Register')

@section('content')
<style>
  /* CSS tambahan untuk posisi tengah dan transparansi */
  .full-height {
    height: 100vh; /* 100% tinggi viewport */
    display: flex;
    justify-content: center; /* horisontal tengah */
    align-items: center;     /* vertikal tengah */
  }
  .transparent-card {
    background-color: rgba(255, 255, 255, 0.85); /* putih dengan transparansi */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border-radius: 12px;
    width: 100%;
    max-width: 400px;
    padding: 20px;
  }
</style>

<div class="container full-height">
    <div class="card transparent-card">
        <div class="card-header text-center"><h4>Daftar Akun Kosku</h4></div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                        required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                        required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password-confirm">Konfirmasi Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password">
                </div>

                <div class="form-group mb-3">
                    <label for="role">Daftar Sebagai</label>
                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                        <option value="">Pilih Peran</option>
                        <option value="pencari" {{ old('role') == 'pencari' ? 'selected' : '' }}>Pencari Kos</option>
                        <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik Kos</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block" style="width: 100%;">Daftar</button>
                    <p class="text-center mt-3">Sudah punya akun? <a href="{{ route('login') }}"
                            style="color: var(--primary-color); text-decoration: none;">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection