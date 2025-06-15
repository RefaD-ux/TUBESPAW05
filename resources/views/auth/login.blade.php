@extends('layouts.app')

@section('title', 'Login')

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
        <div class="card-header text-center"><h4>Login ke Kosku</h4></div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                        autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- RECAPTCHA --}}
                <div class="form-group mt-3">
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <span class="invalid-feedback d-block" role="alert" style="color: red; font-size: 0.9em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label mb-0" for="remember">Remember Me</label>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block" style="width: 100%;">Login</button>
                    <p class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}"
                            style="color: var(--primary-color); text-decoration: none;">Daftar di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Render reCAPTCHA JS --}}
{!! NoCaptcha::renderJs() !!}

@endsection