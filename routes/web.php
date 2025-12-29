<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\KelolaPemilihan;
use App\Livewire\Admin\KelolaKandidat;
use App\Livewire\Admin\KelolaAnggota;
use App\Livewire\Admin\HasilPemilihan;
use App\Livewire\User\DaftarPemilihan;
use App\Livewire\User\LihatKandidat;
use App\Livewire\User\TerimaKasih;




/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/
    Route::get('/', fn () => redirect()->route('login'));

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    Route::get('/login', Login::class)
        ->middleware('guest')
        ->name('login');

    Route::post('/logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->middleware('auth')->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'hanya.admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', DashboardAdmin::class)->name('dashboard');
            Route::get('/pemilihan', KelolaPemilihan::class)->name('pemilihan');
            Route::get('/kandidat', KelolaKandidat::class)->name('kandidat');
            Route::get('/anggota', KelolaAnggota::class)->name('anggota');
            Route::get('/hasil', HasilPemilihan::class)->name('hasil');
        });

        

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'hanya.user'])
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('/pemilihan', DaftarPemilihan::class)->name('daftar-pemilihan');
            Route::get('/pemilihan/{pemilihanId}/kandidat', LihatKandidat::class)->name('lihat-kandidat');
            Route::get('/terima-kasih', TerimaKasih::class)->name('terima-kasih');
        });
