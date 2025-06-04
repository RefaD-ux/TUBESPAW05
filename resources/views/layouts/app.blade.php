<?php
// resources/views/layouts/app.blade.php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosku - @yield('title', 'Cari Kos Impianmu')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="{{ url('/') }}" class="navbar-brand">Kosku</a>
            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('kos.index') }}" class="nav-link btn btn-outline-primary">Cari Kos</a></li>
                @guest
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link btn btn-outline-primary">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link btn btn-outline-primary">Register</a></li>
                @else
                    @if(Auth::user()->role === 'pemilik')
                        <li class="nav-item"><a href="{{ route('dashboard.pemilik') }}" class="nav-link btn btn-outline-primary">Dashboard Pemilik</a></li>
                        <li class="nav-item"><a href="{{ route('kos.create') }}" class="nav-link btn btn-outline-primary">Tambah Kos</a></li>
                    @elseif(Auth::user()->role === 'pencari')
                        <li class="nav-item"><a href="{{ route('dashboard.pencari') }}" class="nav-link btn btn-outline-primary">Dashboard Pencari</a></li>
                        <li class="nav-item"><a href="{{ route('booking.index') }}" class="nav-link btn btn-outline-primary">Riwayat Booking</a></li>
                        <li class="nav-item"><a href="{{ route('favorite.index') }}" class="nav-link btn btn-outline-primary">Favorit Saya</a></li>
                    @elseif(Auth::user()->role === 'admin')
                        <li class="nav-item"><a href="{{ route('dashboard.admin') }}" class="nav-link btn btn-outline-primary">Dashboard Admin</a></li>
                    @endif
                    <li class="nav-item"><a href="{{ route('profil.show') }}" class="nav-link btn btn-outline-primary">Profil</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-secondary">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </nav>
    </header>

    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="text-center py-4 mt-4" style="background-color: #fff; box-shadow: 0 -2px 4px var(--shadow-color);">
        <p>&copy; {{ date('Y') }} Kosku. All rights reserved.</p>
    </footer>
</body>
</html>
