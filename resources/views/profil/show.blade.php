@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Profil Saya</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

    <a href="{{ route('profil.edit') }}" class="btn btn-primary mt-3">Edit Profil</a>
</div>
@endsection
