<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute autentikasi untuk guest (login & register)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Logout (hanya untuk yang sudah login)
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Fitur Profil (lihat & edit)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [App\Http\Controllers\ProfileController::class, 'show'])->name('profil.show');
    Route::get('/profil/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profil.update');
});

// Dashboard (semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/pemilik', [DashboardController::class, 'pemilikDashboard'])->name('dashboard.pemilik');
    Route::get('/dashboard/pencari', [DashboardController::class, 'pencariDashboard'])->name('dashboard.pencari');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserManagementController::class, 'create'])->name('admin.users.create'); // route create
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store'); // route store
    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');

});

// Route Kos umum (bisa diakses semua pengunjung)
// **Letakkan route spesifik /kos/create sebelum /kos/{kos}**
Route::get('/kos', [KosController::class, 'index'])->name('kos.index');

Route::middleware(['auth', 'role:pemilik'])->group(function () {
    Route::get('/kos/create', [KosController::class, 'create'])->name('kos.create');
    Route::post('/kos', [KosController::class, 'store'])->name('kos.store');
    Route::get('/kos/{kos}/edit', [KosController::class, 'edit'])->name('kos.edit');
    Route::put('/kos/{kos}', [KosController::class, 'update'])->name('kos.update');
    Route::delete('/kos/{kos}', [KosController::class, 'destroy'])->name('kos.destroy');

    // Pemilik juga bisa update status booking
    Route::put('/booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.updateStatus');
});

// Route show kos ini harus terakhir karena parameter wildcard
Route::get('/kos/{kos}', [KosController::class, 'show'])->name('kos.show');

// Route Pencarian
Route::get('/pencarian', [PencarianController::class, 'search'])->name('pencarian.search');

// Route yang memerlukan autentikasi dan role tertentu
Route::middleware(['auth'])->group(function () {

    // Rute khusus untuk pencari kos
    Route::middleware('role:pencari')->group(function () {
        Route::get('/booking/create/{kos}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/riwayat', [BookingController::class, 'index'])->name('booking.index');
        Route::put('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

        // Favorite kos
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.index');
        Route::post('/favorites/add/{kos}', [FavoriteController::class, 'add'])->name('favorite.add');
        Route::delete('/favorites/remove/{kos}', [FavoriteController::class, 'remove'])->name('favorite.remove');
    });
    
});
