<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Masuk;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\KelolaPemilihan;
use App\Livewire\Admin\KelolaKandidat;
use App\Livewire\Admin\KelolaAnggota;
use App\Livewire\Admin\HasilPemilihan;
use App\Livewire\User\DaftarPemilihan;
use App\Livewire\User\LihatKandidat;
use App\Livewire\User\TerimaKasih;

Route::get('/', function () {
    return redirect()->route('masuk');
});

// Auth Routes
Route::get('/login', Login::class)->name('masuk')->middleware('guest');

Route::post('/keluar', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('masuk');
})->name('keluar');

// Admin Routes
Route::middleware(['auth', 'hanya.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardAdmin::class)->name('dashboard');
    Route::get('/pemilihan', KelolaPemilihan::class)->name('pemilihan');
    Route::get('/kandidat', KelolaKandidat::class)->name('kandidat');
    Route::get('/anggota', KelolaAnggota::class)->name('anggota');
    Route::get('/hasil', HasilPemilihan::class)->name('hasil');
});

// User Routes
Route::middleware(['auth', 'hanya.user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/pemilihan', DaftarPemilihan::class)->name('daftar-pemilihan');
    Route::get('/pemilihan/{pemilihanId}/kandidat', LihatKandidat::class)->name('lihat-kandidat');
    Route::get('/terima-kasih', TerimaKasih::class)->name('terima-kasih');
});